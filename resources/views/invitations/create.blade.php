@extends('layouts.user')

@section('content')
<div class="max-w-md mx-auto bg-white shadow-md rounded-xl p-6">
    
    <h2 class="text-xl font-semibold text-gray-800 mb-4">
        Inviter un membre
    </h2>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('invitations.store') }}" method="POST" class="space-y-4">
        @csrf

        <input type="hidden" name="colocation_id" value="{{ $colocation->id }}">

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Email du membre à inviter
            </label>

            <input 
                type="email" 
                name="email" 
                value="{{ old('email') }}"
                class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                required
            >

            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end space-x-2">
            <a href="{{ route('colocations.show', $colocation) }}"
               class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                Annuler
            </a>

            <button 
                type="submit" 
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                Envoyer l'invitation
            </button>
        </div>
    </form>
</div>
@endsection