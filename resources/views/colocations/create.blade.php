@extends('layouts.user')
@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Créer une nouvelle colocation</h1>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-home text-blue-600 text-lg"></i>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Informations de la colocation</h2>
                </div>
            </div>
        </div>

        <form action="{{ route('colocations.store') }}" method="POST" class="p-6">
            @csrf
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Nom de la colocation
                </label>
                <div class="relative">
                    <input type="text" 
                           name="name" 
                           value="{{ old('name') }}"
                           class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('name') border-red-500 ring-red-500 @enderror" 
                           placeholder="Coloc Name"
                           required>
                </div>
                @error('name')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
                <p class="mt-1 text-xs text-gray-500">Choisissez un nom descriptif et unique</p>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Description
                </label>
                <div class="relative">
                    <textarea name="description" 
                              rows="5"
                              class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('description') border-red-500 @enderror" 
                              placeholder="Description de votre colocation">{{ old('description') }}</textarea>
                </div>
                @error('description')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('colocations.index') }}" 
                   class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                    Annuler
                </a>
                <button type="submit" 
                        class="px-6 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition shadow-sm hover:shadow flex items-center">
                    <i class="fas fa-plus-circle mr-2"></i>
                    Créer la colocation
                </button>
            </div>
        </form>
    </div>

</div>
@endsection