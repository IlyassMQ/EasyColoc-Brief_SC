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
        
        $expenses = $colocation->expenses()
            ->with(['payer', 'category'])
            ->latest()
            ->take(10)
            ->get();
            //pour qui doit à qui
            $colocation->load('users', 'expenses');

        $memberCount = $members->count();

        $totalExpenses = $colocation->expenses->sum('amount');
        $individualShare = $memberCount > 0 ? $totalExpenses / $memberCount : 0;

        return view('colocations.show', compact('colocation', 'members', 'totalExpenses', 'individualShare','expenses'));
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

    $membership = $colocation->users()->where('user_id', $user->id)->first();
    if (!$membership) {
        abort(403, 'Vous ne faites pas partie de cette colocation.');
    }

    $hasDebt = $colocation->payments()
        ->where('payer_id', $user->id)
        ->whereColumn('payer_id', '!=', 'receiver_id')
        ->exists();

    
    if ($hasDebt) {
        $user->reputation -= 1; 
    } else {
        $user->reputation += 1;
    }
    $user->save();

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