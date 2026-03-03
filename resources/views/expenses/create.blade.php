@extends('layouts.user')

@section('content')
<div class="max-w-3xl mx-auto p-6">
    <div class="mb-6">
        <a href="{{ route('colocations.show', $colocation) }}" class="text-gray-500 underline text-sm">← Retour à la colocation</a>
        <h1 class="text-3xl font-bold mt-2">Ajouter une dépense : {{ $colocation->name }}</h1>
    </div>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            <span class="block sm:inline">error.</span>
            <ul class="mt-2 list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('expenses.store', $colocation) }}" method="POST" class="bg-white p-6 rounded shadow-sm">
        @csrf
        <input type="hidden" name="colocation_id" value="{{ $colocation->id }}">

        <!-- Title -->
        <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-700">Titre de la dépense</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" required
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 h-10 px-3">
        </div>

        <!-- Amount -->
        <div class="mb-4">
            <label for="amount" class="block text-sm font-medium text-gray-700">Montant (€)</label>
            <input type="number" step="0.01" name="amount" id="amount" value="{{ old('amount') }}" required
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 h-10 px-3">
        </div>

        <!-- Date -->
        <div class="mb-4">
            <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
            <input type="date" name="date" id="date" value="{{ old('date', date('Y-m-d')) }}" required
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 h-10 px-3">
        </div>

        
        <!-- Category -->
        <div class="mb-6">
            <label for="category_id" class="block text-sm font-medium text-gray-700">Catégorie</label>
            
            <!-- Existing categories select -->
            <select name="category_id" id="category_id" class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 h-10 px-3">
                <option value="">-- Sélectionner une catégorie --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <label for="new_category" class="block text-sm font-medium text-gray-700 mt-2">Ou créer une nouvelle catégorie</label>
            <input type="text" name="new_category" id="new_category" value="{{ old('new_category') }}" 
                placeholder="Nouvelle categorie"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 h-10 px-3">
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 font-medium">
                Enregistrer la dépense
            </button>
        </div>
    </form>
</div>
@endsection