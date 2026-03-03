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

        {{-- Expenses --}}
        <div class="col-span-2 bg-white p-4 rounded-xl shadow">
            <h3 class="text-xl font-semibold mb-4">Dernières Dépenses</h3>

            @forelse($expenses as $expense)
                <div class="flex justify-between items-center p-3 border-b last:border-none">
                    <div>
                        <p class="font-medium">{{ $expense->title }}</p>
                        <p class="text-xs text-gray-500">
                            {{ $expense->payer->name }} • {{ $expense->category->name }}
                        </p>
                    </div>

                    <div class="text-lg font-bold text-gray-800">
                        {{ number_format($expense->amount, 2) }} €
                    </div>
                </div>
            @empty
                <p class="text-gray-400 italic">Aucune dépense enregistrée.</p>
            @endforelse
        </div>

        {{-- Expenses summary --}}
        <div class="mt-6 bg-white p-4 rounded-xl shadow">
            <h3 class="text-xl font-semibold mb-3">Synthèse des dépenses</h3>

            <p><strong>Total des dépenses :</strong> {{ number_format($totalExpenses, 2) }} €</p>
            <p><strong>Part individuelle :</strong> {{ number_format($individualShare, 2) }} €</p>

            <h4 class="mt-3 font-medium">Part par colocataire :</h4>
            <ul class="list-disc list-inside">
                @foreach($members as $member)
                    {{-- Skip the logged-in user --}}
                    @if($member->id !== auth()->id())
                        <li>{{ $member->name }} : {{ number_format($individualShare, 2) }} €</li>
                    @endif
                @endforeach
            </ul>
        </div>

    </div>
</div>
@endsection