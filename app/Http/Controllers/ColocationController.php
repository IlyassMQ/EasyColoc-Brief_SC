<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Http\Requests\StoreColocationRequest;
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
            return abort(403, 'Unauthorized action.');
        }


    $colocation = Colocation::create([
        'name' => $request->name,
        'description' => $request->description,
        'status' => 'active'
    ]);

    $colocation->users()->attach(Auth::id(), [
        'role_intern' => 'owner',
        'joined_at' => now(),
    ]);

    return redirect()
        ->route('colocations.show',$colocation)
        ->with('success', 'Colocation créée avec succès');

    }

    public function show(Colocation $colocation)
    {
    if (!$colocation->users->contains(auth()->id())) {
        abort(403);
    }

    $members = $colocation->users;

    $expenses = $colocation->expenses()
        ->with(['payer', 'category'])
        ->latest()
        ->take(10)
        ->get();

    return view('colocations.show', compact('colocation', 'members', 'expenses'));
    }
}