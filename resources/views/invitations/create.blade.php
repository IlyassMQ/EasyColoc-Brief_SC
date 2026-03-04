@extends('layouts.user')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 py-8">
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-5 bg-gradient-to-r from-blue-600 to-blue-700">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                    <i class="fas fa-user-plus text-white text-xl"></i>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-white">Inviter un membre</h2>
                    <p class="text-sm text-blue-100">pour rejoindre <span class="font-medium">{{ $colocation->name }}</span></p>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="mx-6 mt-6 bg-green-50 border border-green-200 text-green-700 rounded-lg p-4 flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                <div class="flex-1">
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        <div class="p-6">
            <form action="{{ route('invitations.store') }}" method="POST">
                @csrf
                <input type="hidden" name="colocation_id" value="{{ $colocation->id }}">

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Email du membre à inviter
                    </label>
                    
                    <div class="relative">
                        <input type="email" 
                               name="email" 
                               value="{{ old('email') }}"
                               placeholder="ex: jean.dupont@email.com"
                               class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('email') border-red-500 ring-red-500 @enderror"
                               required>
                    </div>

                    @error('email')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror

                    
                </div>

                

                <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
                    <a href="{{ route('colocations.show', $colocation) }}"
                       class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                        <i class="fas fa-times mr-2"></i>
                        Annuler
                    </a>
                    <button type="submit" 
                            class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition shadow-sm hover:shadow flex items-center">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Envoyer l'invitation
                    </button>
                </div>
            </form>
        </div>
    </div>

    

    
</div>
@endsection