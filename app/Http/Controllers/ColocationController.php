<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Http\Requests\StoreColocationRequest;
use App\Http\Requests\UpdateColocationRequest;
use Illuminate\Support\Facades\Auth;

class ColocationController extends Controller
{

    public function index()
    {
        $colocations = Auth::user()->colocations;

        return view('colocations.index', compact('colocations'));
    }


    public function create()
    {
        return view('colocations.create');
    }


    public function store(StoreColocationRequest $request)
    {
        if (Auth::user()->colocations()->where('status', 'active')->exists()) {
            abort(403, 'Vous avez déjà une colocation active.');
        }

        $colocation = Colocation::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => 'active',
        ]);

        $colocation->users()->attach(Auth::id(), [
            'role_intern' => 'owner',
            'joined_at' => now(),
        ]);

        return redirect()
            ->route('colocations.show', $colocation)
            ->with('success', 'Colocation créée avec succès.');
    }

public function show(Colocation $colocation)
{
    $this->isMember($colocation);

    $members = $colocation->users;
    $memberCount = $members->count();
    $userId = auth()->id();

    // All expenses for the “Dernières Dépenses” section
    $allExpenses = $colocation->expenses()->with(['payer', 'category'])
        ->latest()
        ->take(10)
        ->get();

    // Expenses for "Ce que je dois payer"
    $expensesToPay = $colocation->expenses()->with(['payer', 'category'])
        ->get()
        ->filter(function ($expense) use ($userId, $members) {
            // Skip if user is the payer or if marked as paid
            return $expense->user_id !== $userId && ($expense->paid ?? 0) != 1;
        })
        ->map(function ($expense) use ($userId, $members) {
            $usersCount = $members->count(); 
            $expense->my_share = $usersCount > 0 ? $expense->amount / $usersCount : 0;
            return $expense;
        });

    return view('colocations.show', compact('colocation', 'members', 'allExpenses', 'expensesToPay'));
}

    public function edit(Colocation $colocation)
    {
        $this->isOwner($colocation);

        return view('colocations.edit', compact('colocation'));
    }

    public function update(UpdateColocationRequest $request, Colocation $colocation)
    {
        $this->isOwner($colocation);

        $colocation->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()
            ->route('colocations.show', $colocation)
            ->with('success', 'Colocation mise à jour avec succès.');
    }

    public function destroy(Colocation $colocation)
    {
        $this->isOwner($colocation);

        $colocation->delete();

        return redirect()
            ->route('colocations.index')
            ->with('success', 'Colocation supprimée avec succès.');
    }

    public function cancel(Colocation $colocation)
    {
        $this->isOwner($colocation);

        $colocation->update([
            'status' => 'cancelled',
        ]);

        return redirect()
            ->route('colocations.index')
            ->with('success', 'Colocation annulée avec succès.');
    }
    public function quit(Colocation $colocation)
{
    $user = auth()->user();

    // Check if the user is a member
    $membership = $colocation->users()->where('user_id', $user->id)->first();
    if (!$membership) {
        abort(403, 'Vous ne faites pas partie de cette colocation.');
    }

    // Simple check: does the user have any unpaid expense shares?
    $hasDebt = false;

    foreach ($colocation->expenses as $expense) {
        if ($expense->user_id !== $user->id && !$expense->paid) {
            $hasDebt = true;
            break; // stop checking if we found one
        }
    }

    // Update reputation
    if ($hasDebt) {
        $user->reputation -= 1; // owes money
    } else {
        $user->reputation += 1; // no debt
    }

    $user->save();

    // Remove user from colocation
    $colocation->users()->detach($user->id);

    return redirect()
        ->route('colocations.index')
        ->with('success', 'Vous avez quitté la colocation !');
}
    
    private function isOwner(Colocation $colocation)
    {
        $membership = $colocation->users()
            ->where('user_id', Auth::id())
            ->first();

        if (!$membership || $membership->pivot->role_intern !== 'owner') {
            abort(403, 'Seul le propriétaire peut effectuer cette action.');
        }
    }

    private function isMember(Colocation $colocation)
    {
        if (!$colocation->users()
            ->where('user_id', Auth::id())
            ->exists()) {
            abort(403, 'Vous n êtes pas membre de cette colocation.');
        }
    }
}