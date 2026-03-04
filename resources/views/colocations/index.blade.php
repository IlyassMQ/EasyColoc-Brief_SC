@extends('layouts.user')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Mes colocations</h1>
            <p class="text-gray-600 mt-1">Gérez toutes vos colocations</p>
        </div>
        
        @php
            $hasActiveColocation = $colocations->where('status', 'active')->count() > 0;
        @endphp

        @unless($hasActiveColocation)
            <a href="{{ route('colocations.create') }}" 
               class="mt-4 sm:mt-0 inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-sm hover:shadow">
                <i class="fas fa-plus-circle mr-2"></i>
                Créer une colocation
            </a>
        @endunless
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 rounded-lg p-4 flex items-center">
            <i class="fas fa-check-circle text-green-500 mr-3"></i>
            <div class="flex-1">
                <span class="font-medium">{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    @if($colocations->count())
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($colocations as $colocation)
                @php
                    $isOwner = $colocation->users->where('id', auth()->id())->first()?->pivot->role_intern === 'owner';
                    $memberCount = $colocation->users->count();
                @endphp

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition">
                    <div class="relative h-32 bg-gradient-to-r from-blue-500 to-blue-600">
                        @if($colocation->status === 'cancelled')
                            <div class="absolute inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center">
                                <span class="px-3 py-1 bg-red-500 text-white text-sm font-medium rounded-full">Annulée</span>
                            </div>
                        @endif
                        <div class="absolute top-3 right-3">
                            @if($colocation->status === 'active')
                                <span class="px-3 py-1 bg-green-500 text-white text-xs font-medium rounded-full">Active</span>
                            @endif
                        </div>
                        <div class="absolute bottom-3 left-3 flex items-center">
                            <div class="flex -space-x-2">
                                @foreach($colocation->users->take(3) as $user)
                                    <div class="w-8 h-8 rounded-full border-2 border-white bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-700">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                @endforeach
                                @if($memberCount > 3)
                                    <div class="w-8 h-8 rounded-full border-2 border-white bg-gray-300 flex items-center justify-center text-xs font-bold text-gray-700">
                                        +{{ $memberCount - 3 }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="p-5">
                        <a href="{{ route('colocations.show', $colocation) }}" class="block group">
                            <h2 class="text-xl font-semibold text-gray-900 group-hover:text-blue-600 transition">
                                {{ $colocation->name }}
                            </h2>
                            <p class="text-gray-600 mt-1 line-clamp-2">
                                {{ $colocation->description ?? 'Aucune description' }}
                            </p>
                        </a>

                        <div class="mt-4 pt-4 border-t border-gray-100">
                            @if($isOwner)
                                <div class="flex flex-wrap gap-2">
                                    @if($colocation->status === 'active')
                                        <a href="{{ route('colocations.edit', $colocation) }}"
                                           class="inline-flex items-center px-3 py-1.5 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition text-sm">
                                            <i class="fas fa-edit mr-1"></i>
                                            Éditer
                                        </a>

                                        <form action="{{ route('colocations.cancel', $colocation) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                    onclick="return confirm('Voulez-vous vraiment annuler cette colocation ?')"
                                                    class="inline-flex items-center px-3 py-1.5 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition text-sm">
                                                <i class="fas fa-ban mr-1"></i>
                                                Annuler
                                            </button>
                                        </form>
                                    @endif

                                    <form action="{{ route('colocations.destroy', $colocation) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                onclick="return confirm('Voulez-vous vraiment supprimer cette colocation ? Cette action est irréversible.')"
                                                class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm">
                                            <i class="fas fa-trash mr-1"></i>
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-500">
                                        <i class="fas fa-users mr-1"></i>
                                        {{ $memberCount }} membre{{ $memberCount > 1 ? 's' : '' }}
                                    </span>
                                    <span class="text-xs px-2 py-1 bg-gray-100 text-gray-600 rounded-full">
                                        Membre
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if(method_exists($colocations, 'links'))
            <div class="mt-6">
                {{ $colocations->links() }}
            </div>
        @endif
    @else
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
            
            <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune colocation</h3>
            <p class="text-gray-500 mb-6">Vous n'avez pas encore créé ou rejoint de colocation.</p>
            
        </div>
    @endif
</div>

@endsection