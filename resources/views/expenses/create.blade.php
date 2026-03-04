@extends('layouts.user')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 py-8">
    <div class="mb-6">
        
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Ajouter une dépense</h1>
                <p class="text-gray-600 mt-1">pour <span class="font-semibold">{{ $colocation->name }}</span></p>
            </div>
            <a href="{{ route('colocations.show', $colocation) }}" 
               class="flex items-center text-sm text-gray-600 hover:text-gray-900 bg-white border border-gray-300 rounded-lg px-4 py-2 hover:bg-gray-50 transition">
                <i class="fas fa-arrow-left mr-2"></i>
                Retour
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 rounded-lg p-4">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-500"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Le formulaire contient des erreurs</h3>
                    <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-blue-700">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                    <i class="fas fa-receipt text-white text-lg"></i>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-white">Nouvelle dépense</h2>
                    <p class="text-sm text-blue-100">Remplissez les informations ci-dessous</p>
                </div>
            </div>
        </div>

        <form action="{{ route('expenses.store', $colocation) }}" method="POST" class="p-6">
            @csrf
            <input type="hidden" name="colocation_id" value="{{ $colocation->id }}">

            <div class="mb-5">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
                    Titre de la dépense
                </label>
                <div class="relative">
                    
                    <input type="text" 
                           name="title" 
                           id="title" 
                           value="{{ old('title') }}" 
                           required
                           class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('title') border-red-500 @enderror">
                </div>
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">
                    Montant
                </label>
                <div class="relative">
                   
                    <input type="number" 
                           step="0.01" 
                           min="0" 
                           name="amount" 
                           id="amount" 
                           value="{{ old('amount') }}" 
                           required
                           class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('amount') border-red-500 @enderror">
                </div>
                @error('amount')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label for="date" class="block text-sm font-medium text-gray-700 mb-1">
                    Date
                </label>
                <div class="relative">
                    
                    <input type="date" 
                           name="date" 
                           id="date" 
                           value="{{ old('date', date('Y-m-d')) }}" 
                           required
                           class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('date') border-red-500 @enderror">
                </div>
                @error('date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Catégorie
                </label>
                
                <div class="mb-3">
                    <div class="relative">
                        
                        <select name="category_id" id="category_id" 
                                class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition appearance-none bg-white">
                            <option value="">-- Choisir une catégorie existante --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                        </div>
                    </div>
                </div>

                <div class="flex items-center my-3">
                    <div class="flex-grow h-px bg-gray-200"></div>
                    <span class="flex-shrink mx-3 text-xs text-gray-400 uppercase">Ou</span>
                    <div class="flex-grow h-px bg-gray-200"></div>
                </div>

                <div>
                    <label for="new_category" class="block text-sm font-medium text-gray-700 mb-1">
                        Créer une nouvelle catégorie
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-plus-circle text-gray-400"></i>
                        </div>
                        <input type="text" 
                               name="new_category" 
                               id="new_category" 
                               value="{{ old('new_category') }}" 
                               class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('new_category') border-red-500 @enderror">
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <a href="{{ route('colocations.show', $colocation) }}" 
                   class="text-sm text-gray-600 hover:text-gray-900 underline transition">
                    Annuler
                </a>
                <button type="submit" 
                        class="inline-flex items-center px-6 py-2.5 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition shadow-sm hover:shadow">
                    <i class="fas fa-save mr-2"></i>
                    Enregistrer la dépense
                </button>
            </div>
        </form>
    </div>

  
</div>
@endsection