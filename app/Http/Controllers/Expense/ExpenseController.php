<?php

namespace App\Http\Controllers\Expense;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExpenseRequest;
use App\Models\Category;
use App\Models\Colocation;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function create(Colocation $colocation)
    {
        
        if (!$colocation->users->contains(auth()->id())) {
            abort(403);
        }
        $categories = Category::all();

        return view('expenses.create', compact('colocation', 'categories'));
    }


    public function store(StoreExpenseRequest $request, Colocation $colocation)
    {

    if (!$colocation->users()->where('user_id', auth()->id())->exists()) {
        abort(403, 'Vous ne faites pas partie de cette colocation.');
    }

    $expense = Expense::create([
        'title' => $request->title,
        'amount' => $request->amount,
        'date' => $request->date,
        'category_id' => $request->category_id,
        'colocation_id' => $colocation->id,
        'payer_id' => auth()->id(),
    ]);

    return redirect()
        ->route('colocations.show', $colocation)
        ->with('success', 'Dépense ajoutée avec succès.');
}
}
