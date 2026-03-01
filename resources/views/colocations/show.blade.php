@extends('layouts.user')
@section('content')
<div class="max-w-5xl mx-auto p-6">
    <div class="mb-6">
        <a href="{{ route('colocations.index') }}" class="text-gray-500 underline text-sm">← Retour à la liste</a>
        <h1 class="text-3xl font-bold mt-2">{{ $colocation->name }}</h1>
    </div>

    <div class="flex space-x-4 mb-6">
    <!-- Invite button -->
    <a href="{{ route('invitations.create', $colocation) }}"
       class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
       Inviter un membre
    </a>

    <!-- Add Expense button -->
    <a href="#"
       class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
       Ajouter une dépense
    </a>
</div>

    <div class="grid grid-cols-3 gap-6">
        <div class="col-span-1 bg-gray-50 p-4 rounded shadow-sm">
            <h3 class="font-bold border-b mb-3">Colocataires</h3>
            <ul class="space-y-2">
                @foreach($members as $member)
                    <li class="flex justify-between items-center text-sm">
                        <span>{{ $member->name }}</span>
                        <span class="text-xs px-2 py-0.5 bg-blue-100 text-blue-700 rounded-full">
                            {{ $member->pivot->role_intern }}
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="col-span-2">
            <h3 class="text-xl font-bold mb-4">Dernières Dépenses</h3>
            @forelse($expenses as $expense)
                <div class="flex justify-between p-3 border-b">
                    <div>
                        <p class="font-bold">{{ $expense->title }}</p>
                        <p class="text-xs text-gray-500">{{ $expense->payer->name }} • {{ $expense->category->name }}</p>
                    </div>
                    <div class="text-lg font-mono font-bold">{{$expense->amount }}€</div>
                </div>
            @empty
                <p class="text-gray-400 italic">Aucune dépense enregistrée.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection