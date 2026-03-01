@extends('layouts.user')
@section('content')
<div class="max-w-lg mx-auto p-6 bg-white shadow mt-10 rounded">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Créer une colocation</h1>

    <form action="{{ route('colocations.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Nom de la coloc</label>
            <input type="text" name="name" class="w-full border p-2 rounded @error('name') border-red-500 @enderror" value="{{ old('name') }}">
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Description</label>
            <textarea name="description" class="w-full border p-2 rounded" rows="3">{{ old('description') }}</textarea>
        </div>

        <button type="submit" class="w-full bg-green-600 text-white font-bold py-2 rounded">C'est parti !</button>
    </form>
</div>
@endsection