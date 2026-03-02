@extends('layouts.user')

@section('content')
<div class="max-w-5xl mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Mes colocations</h1>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    @php
        $hasActiveColocation = $colocations->where('status', 'active')->count() > 0;
    @endphp

    @unless($hasActiveColocation)
        <a href="{{ route('colocations.create') }}" 
           class="mb-4 inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            + Créer une colocation
        </a>
    @endunless

    @if($colocations->count())
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($colocations as $colocation)
                @php
                    $isOwner = $colocation->users->where('id', auth()->id())->first()?->pivot->role_intern === 'owner';
                @endphp

                <div class="relative p-4 bg-white shadow rounded hover:shadow-lg transition">
                    <a href="{{ route('colocations.show', $colocation) }}">
                        <h2 class="text-xl font-bold">{{ $colocation->name }}</h2>
                        <p class="text-gray-500">{{ $colocation->description ?? 'Aucune description' }}</p>
                        <p class="text-sm mt-2 text-gray-400">
                            Status: 
                            @if($colocation->status === 'cancelled')
                                <span class="text-red-500 font-bold">Annulée</span>
                            @else
                                <span class="text-green-600 font-bold">{{ $colocation->status }}</span>
                            @endif
                        </p>
                    </a>

                    @if($isOwner)
                        <div class="mt-4 flex space-x-2">
                            @if($colocation->status === 'active')
                                <a href="{{ route('colocations.edit', $colocation) }}"
                                   class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-sm">
                                   Éditer
                                </a>

                                <form action="{{ route('colocations.cancel', $colocation) }}" method="POST"
                                      onsubmit="return confirm('Voulez-vous vraiment annuler cette colocation ?');">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                            class="px-3 py-1 bg-gray-500 text-white rounded hover:bg-gray-600 text-sm">
                                        Annuler
                                    </button>
                                </form>
                            @endif

                            <form action="{{ route('colocations.destroy', $colocation) }}" method="POST"
                                  onsubmit="return confirm('Voulez-vous vraiment supprimer cette colocation ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm">
                                    Supprimer
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-500">Vous n'avez aucune colocation pour le moment.</p>
    @endif
</div>
@endsection