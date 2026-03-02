@extends('layouts.user')

@section('content')
<div class="max-w-xl mx-auto p-6 bg-white shadow rounded">

    <div class="mb-6">
        <a href="{{ route('colocations.show', $colocation) }}" 
           class="text-gray-500 underline text-sm">
           ← Retour à la colocation
        </a>

        <h1 class="text-2xl font-bold mt-2">
            Modifier la colocation
        </h1>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('colocations.update', $colocation) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Name -->
        <div class="mb-4">
            <label class="block mb-2 font-medium">Nom de la colocation</label>
            <input type="text"
                   name="name"
                   value="{{ old('name', $colocation->name) }}"
                   class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500">

            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Description -->
        <div class="mb-6">
            <label class="block mb-2 font-medium">Description</label>
            <textarea name="description"
                      rows="4"
                      class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500">{{ old('description', $colocation->description) }}</textarea>

            @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Buttons -->
        <div class="flex justify-between items-center">
            <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Mettre à jour
            </button>

            <a href="{{ route('colocations.show', $colocation) }}"
               class="text-gray-500 underline text-sm">
               Annuler
            </a>
        </div>

    </form>

</div>
@endsection