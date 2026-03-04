@extends('layouts.user')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">    
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Modifier la colocation</h1>
                <p class="text-gray-600 mt-1">Modifiez les informations de votre colocation</p>
            </div>
            
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 rounded-lg p-4 flex items-center">
            <i class="fas fa-check-circle text-green-500 mr-3"></i>
            <div class="flex-1">
                <span class="font-medium">{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.parentElement.remove()" class="text-green-500 hover:text-green-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-edit text-blue-600 text-lg"></i>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Informations de la colocation</h2>
                </div>
            </div>
        </div>

        <form action="{{ route('colocations.update', $colocation) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Nom de la colocation <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    
                    <input type="text"
                           name="name"
                           value="{{ old('name', $colocation->name) }}"
                           class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('name') border-red-500 ring-red-500 @enderror"
                           placeholder="ex: Coloc' des artistes"
                           required>
                </div>
                @error('name')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Description
                </label>
                <div class="relative">
                    
                    <textarea name="description"
                              rows="5"
                              class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('description') border-red-500 @enderror"
                              placeholder="Décrivez votre colocation...">{{ old('description', $colocation->description) }}</textarea>
                </div>
                @error('description')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>



            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <button type="submit"
                        class="px-6 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition shadow-sm hover:shadow flex items-center">
                    <i class="fas fa-save mr-2"></i>
                    Enregistrer les modifications
                </button>
                
                <a href="{{ route('colocations.show', $colocation) }}"
                   class="text-sm text-gray-500 hover:text-gray-700 underline transition">
                    Annuler
                </a>
            </div>
        </form>
    </div>


</div>
@endsection