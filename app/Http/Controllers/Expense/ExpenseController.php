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

    // Determine category ID
    if ($request->filled('new_category')) {
        // Create new category attached to this colocation
        $category = Category::firstOrCreate([
            'name' => $request->new_category,
            'colocation_id' => $colocation->id, // important!
        ]);
        $categoryId = $category->id;
    } elseif ($request->filled('category_id')) {
        $categoryId = $request->category_id;
    } else {
        return back()->withErrors(['category_id' => 'Vous devez sélectionner ou créer une catégorie'])->withInput();
    }

    // Create the expense
    Expense::create([
        'title' => $request->title,
        'amount' => $request->amount,
        'date' => $request->date,
        'category_id' => $categoryId,
        'colocation_id' => $colocation->id,
        'user_id' => auth()->id(),
    ]);

    return redirect()
        ->route('colocations.show', $colocation)
        ->with('success', 'Dépense ajoutée avec succès.');
}

    public function markPaid($id)
    {
        $expense = Expense::findOrFail($id);

        // Only owner of the colocation can mark as paid
        if (auth()->id() !== $expense->colocation->users->firstWhere('pivot.role_intern', 'owner')->id) {
            abort(403, 'Seul le propriétaire peut marquer une dépense comme payée.');
        }

        $expense->update(['paid' => true]);

        return back()->with('success', 'Dépense marquée comme payée.');
    }
}
