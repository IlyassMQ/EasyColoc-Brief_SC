@extends('layouts.user')

@section('content')
<div class="max-w-5xl mx-auto p-6">

    {{-- HEADER --}}
    <div class="mb-6 flex justify-between items-center">
        <div>
            <a href="{{ route('colocations.index') }}" class="text-gray-500 underline text-sm">
                ← Retour à la liste
            </a>
            <h1 class="text-3xl font-bold mt-2">{{ $colocation->name }}</h1>
        </div>

        @php
            $owner = $members->firstWhere('pivot.role_intern', 'owner');
            $isOwner = $owner && $owner->id === auth()->id();
            $membership = $members->firstWhere('id', auth()->id());
        @endphp

        <div class="flex space-x-3">
            {{-- Owner only → Invite member --}}
            @if($isOwner)
                <a href="{{ route('invitations.create', $colocation) }}"
                   class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
                    Inviter un membre
                </a>
            @endif

            {{-- All members → Add expense --}}
            @if($membership)
                <a href="{{ route('expenses.create', $colocation) }}"
                   class="px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition">
                    Ajouter une dépense
                </a>
            @endif

            {{-- Non-owner members → Quit colocation --}}
            @if($membership && $membership->pivot->role_intern !== 'owner')
                <form action="{{ route('colocations.quit', $colocation) }}" method="POST"
                      onsubmit="return confirm('Voulez-vous vraiment quitter cette colocation ?');">
                    @csrf
                    <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white rounded-lg shadow hover:bg-red-700 transition">
                        Quitter la colocation
                    </button>
                </form>
            @endif
        </div>
    </div>

    {{-- GRID --}}
    <div class="grid grid-cols-3 gap-6">

        {{-- Members list --}}
        <div class="col-span-1 bg-white p-4 rounded-xl shadow">
            <h3 class="font-semibold border-b pb-2 mb-3">Colocataires</h3>
            <ul class="space-y-2">
                @foreach($members as $member)
                    <li class="flex justify-between items-center text-sm">
                        <span>{{ $member->name }}</span>
                        <span class="text-xs px-2 py-1 bg-blue-100 text-blue-700 rounded-full">
                            {{ $member->pivot->role_intern }}
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- Dernières Dépenses --}}
        <div class="col-span-2 bg-white p-4 rounded-xl shadow">
            <h3 class="text-xl font-semibold mb-4">Dernières Dépenses</h3>

            @forelse($allExpenses as $expense)
                <div class="flex justify-between items-center p-3 border-b last:border-none">
                    <div>
                        <p class="font-medium">{{ $expense->title }}</p>
                        <p class="text-xs text-gray-500">
                            {{ $expense->payer->name }} • {{ $expense->category->name }}
                        </p>
                    </div>
                    <div class="text-lg font-bold text-gray-800 flex items-center gap-2">
                        {{ number_format($expense->amount, 2) }} €

                        {{-- Show button only if owner AND expense not paid --}}
                        @if($isOwner && !$expense->paid)
                            <form action="{{ route('expenses.markPaid', $expense) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-xs">
                                    Marquer comme payée
                                </button>
                            </form>
                        @elseif($expense->paid)
                            <span class="text-green-600 font-semibold text-sm">Payé ✅</span>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-gray-400 italic">Aucune dépense enregistrée.</p>
            @endforelse
        </div>

        {{-- Ce que je dois payer --}}
        <div class="mt-6 col-span-3 bg-white p-4 rounded-xl shadow">
            <h3 class="text-xl font-semibold mb-3">Ce que je dois payer</h3>

            @forelse($expensesToPay as $expense)
                <div class="flex justify-between items-center p-3 border-b last:border-none">
                    <div>
                        <p class="font-medium">{{ $expense->title }}</p>
                        <p class="text-xs text-gray-500">
                            Payé par : {{ $expense->payer->name }} • {{ $expense->category->name }}
                        </p>
                    </div>
                    <div class="text-lg font-bold text-gray-800">
                        {{ number_format($expense->my_share, 2) }} €
                    </div>
                </div>
            @empty
                <p class="text-gray-400 italic">Vous ne devez rien</p>
            @endforelse
        </div>

    </div>
</div>
@endsection