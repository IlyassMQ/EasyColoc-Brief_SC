@extends('layouts.user')
@section('content')
<div class="max-w-4xl mx-auto p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Mes Colocations</h1>
        <a href="{{ route('colocations.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded shadow">Nouvelle Coloc</a>
    </div>

    @if(session('status'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('status') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @forelse($colocations as $coloc)
            <div class="border rounded-lg p-4 hover:shadow-md transition">
                <h2 class="text-xl font-semibold">{{ $coloc->name }}</h2>
                <p class="text-gray-600 text-sm mb-4">{{ $coloc->description}}</p>
                <div class="flex justify-between items-center">
                    <span class="text-xs font-bold uppercase px-2 py-1 bg-gray-100 rounded">{{ $coloc->status }}</span>
                    <a href="{{ route('colocations.show', $coloc) }}" class="text-blue-500 font-medium">Voir détails →</a>
                </div>
            </div>
        @empty
            <p class="text-gray-500">Vous n'avez pas encore de colocation.</p>
        @endforelse
    </div>
</div>  
@endsection

