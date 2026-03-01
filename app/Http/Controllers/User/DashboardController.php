<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $totalExpenses = Expense::where('user_id', $user->id)->sum('amount');

        $recentExpenses = Expense::where('user_id', $user->id)
                            ->with(['colocation', 'category'])
                            ->latest()
                            ->take(10)
                            ->get();

        return view('user.dashboard', compact('user', 'totalExpenses', 'recentExpenses'));
    }
}
