<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Colocation;
use App\Models\Expense;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $totalUsers = User::where('role', 'user')->count();

        $totalColocations = Colocation::where('status','active')->count();

        $totalExpenses = Expense::sum('amount');

        $bannedUsersCount = User::whereNotNull('banned_at')->count();

        $users = User::all();


        return view('admin.dashboard', compact(
            'totalUsers',
            'totalColocations', 
            'totalExpenses', 
            'bannedUsersCount',
            'users',
        ));
    }
    

    public function ban(User $user)
    {
        $user->update(['banned_at' => now()]);
        return back()->with('status', 'Utilisateur banni avec succès.');
    }

    public function unban(User $user){
        $user->update(['banned_at' => null ]);
        return back()->with('status', 'Utilisateur debanni avec succès.');

    }
}
