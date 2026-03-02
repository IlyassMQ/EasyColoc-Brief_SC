<form action="{{ route('expenses.store', $colocation) }}" method="POST" class="space-y-4">
    @csrf
    <input type="hidden" name="colocation_id" value="{{ $colocation->id }}">

    <label>Titre</label>
    <input type="text" name="title" class="w-full border px-3 py-2 rounded" required>

    <label>Montant</label>
    <input type="number" step="0.01" name="amount" class="w-full border px-3 py-2 rounded" required>

    <label>Catégorie</label>
    <select name="category_id" class="w-full border px-3 py-2 rounded">
        @foreach($colocation->categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </select>

    <label>Date</label>
    <input type="date" name="date" class="w-full border px-3 py-2 rounded" required>

    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
        Ajouter la dépense
    </button>
</form>