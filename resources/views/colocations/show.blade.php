@extends('layouts.user')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">


    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-8">
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <a href="{{ route('colocations.index') }}" class="text-blue-100 hover:text-white transition inline-flex items-center text-sm">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Retour à la liste
                    </a>
                    <h1 class="text-3xl font-bold text-white mt-2">{{ $colocation->name }}</h1>
                </div>
                
                @php
                    $owner = $members->firstWhere('pivot.role_intern', 'owner');
                    $isOwner = $owner && $owner->id === auth()->id();
                    $membership = $members->firstWhere('id', auth()->id());
                @endphp

                <div class="flex space-x-3">
                    @if($isOwner)
                        <a href="{{ route('invitations.create', $colocation) }}"
                           class="inline-flex items-center px-4 py-2 bg-white text-blue-700 rounded-lg hover:bg-blue-50 transition shadow-sm">
                            <i class="fas fa-user-plus mr-2"></i>
                            Inviter un membre
                        </a>
                    @endif

                    @if($membership)
                        <a href="{{ route('expenses.create', $colocation) }}"
                           class="inline-flex items-center px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition shadow-sm">
                            <i class="fas fa-plus-circle mr-2"></i>
                            Ajouter une dépense
                        </a>
                    @endif

                    @if($membership && $membership->pivot->role_intern !== 'owner')
                        <form action="{{ route('colocations.quit', $colocation) }}" method="POST"
                              onsubmit="return confirm('Voulez-vous vraiment quitter cette colocation ?');">
                            @csrf
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition shadow-sm">
                                <i class="fas fa-sign-out-alt mr-2"></i>
                                Quitter la colocation
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-3 divide-x divide-gray-200 bg-gray-50">
            <div class="p-4 text-center">
                <p class="text-sm text-gray-500">Membres</p>
                <p class="text-2xl font-bold text-gray-900">{{ $members->count() }}</p>
            </div>
            <div class="p-4 text-center">
                <p class="text-sm text-gray-500">Dépenses</p>
                <p class="text-2xl font-bold text-gray-900">{{ $allExpenses->count() }}</p>
            </div>
            <div class="p-4 text-center">
                <p class="text-sm text-gray-500">Total dépensé</p>
                <p class="text-2xl font-bold text-gray-900">{{ number_format($allExpenses->sum('amount'), 2) }} DH</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden sticky top-4">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <h3 class="font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-users text-blue-600 mr-2"></i>
                        Colocataires ({{ $members->count() }})
                    </h3>
                </div>
                <div class="p-4">
                    <ul class="space-y-3">
                        @foreach($members as $member)
                            <li class="flex items-center justify-between p-2 hover:bg-gray-50 rounded-lg transition">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-bold text-sm">
                                        {{ strtoupper(substr($member->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $member->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $member->email }}</p>
                                    </div>
                                </div>
                                <span class="text-xs px-3 py-1 rounded-full 
                                    {{ $member->pivot->role_intern === 'owner' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                                    {{ $member->pivot->role_intern === 'owner' ? 'Owner' : 'Membre' }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-receipt text-blue-600 mr-2"></i>
                        Dernières Dépenses
                    </h3>
                    @if($allExpenses->count() > 0)
                        <span class="text-sm text-gray-500">Total: {{ number_format($allExpenses->sum('amount'), 2) }} DH</span>
                    @endif
                </div>

                <div class="divide-y divide-gray-200">
                    @forelse($allExpenses as $expense)
                        <div class="p-4 hover:bg-gray-50 transition">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-2">
                                        <p class="font-medium text-gray-900">{{ $expense->title }}</p>
                                        <span class="text-xs px-2 py-0.5 bg-gray-100 text-gray-600 rounded-full">
                                            {{ $expense->category->name }}
                                        </span>
                                    </div>
                                    <div class="flex items-center space-x-3 mt-1">
                                        <div class="flex items-center text-sm text-gray-500">
                                            <i class="fas fa-user-circle mr-1 text-xs"></i>
                                            {{ $expense->payer->name }}
                                        </div>
                                        <span class="text-gray-300">•</span>
                                        <div class="flex items-center text-sm text-gray-500">
                                            <i class="far fa-calendar mr-1 text-xs"></i>
                                            {{ $expense->created_at->format('d/m/Y') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <div class="text-right">
                                        <p class="text-lg font-bold text-gray-900">{{ number_format($expense->amount, 2) }} DH</p>
                                        @if($expense->paid)
                                            <span class="text-xs text-green-600 font-medium flex items-center">
                                                <i class="fas fa-check-circle mr-1"></i> Payé
                                            </span>
                                        @endif
                                    </div>

                                    @if($isOwner && !$expense->paid)
                                        <form action="{{ route('expenses.markPaid', $expense) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                    class="px-3 py-1.5 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition text-sm font-medium"
                                                    onclick="return confirm('Marquer cette dépense comme payée ?')">
                                                Marquer payée
                                            </button>
                                        </form>
                                    @elseif($expense->paid)
                                        <span class="px-3 py-1.5 bg-green-100 text-green-700 rounded-lg text-sm font-medium">
                                            <i class="fas fa-check mr-1"></i> Payée
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-12 text-center">
                            <div class="w-16 h-16 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-3">
                                <i class="fas fa-receipt text-gray-400 text-xl"></i>
                            </div>
                            <p class="text-gray-500">Aucune dépense enregistrée</p>
                            @if($membership)
                                <a href="{{ route('expenses.create', $colocation) }}" 
                                   class="inline-flex items-center text-sm text-blue-600 hover:text-blue-700 mt-2">
                                    <i class="fas fa-plus-circle mr-1"></i>
                                    Ajouter une première dépense
                                </a>
                            @endif
                        </div>
                    @endforelse
                </div>

                
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <h3 class="font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-hand-holding-usd text-blue-600 mr-2"></i>
                        Ce que je dois
                    </h3>
                </div>

                <div class="divide-y divide-gray-200">
                    @forelse($expensesToPay as $expense)
                        <div class="p-4 hover:bg-gray-50 transition">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-2">
                                        <p class="font-medium text-gray-900">{{ $expense->title }}</p>
                                        <span class="text-xs px-2 py-0.5 bg-gray-100 text-gray-600 rounded-full">
                                            {{ $expense->category->name }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-500 mt-1">
                                        Payé par <span class="font-medium">{{ $expense->payer->name }}</span>
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xl font-bold text-orange-600">{{ number_format($expense->my_share, 2) }} DH</p>
                                    <p class="text-xs text-gray-500">à rembourser</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-12 text-center">
                            <p class="text-sm text-gray-400">Vous ne devez rien pour le moment</p>
                        </div>
                    @endforelse
                </div>

                @if($expensesToPay->count() > 0)
                    <div class="px-6 py-3 bg-orange-50 border-t border-orange-200">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-orange-700">Total à payer</span>
                            <span class="text-lg font-bold text-orange-700">{{ number_format($expensesToPay->sum('my_share'), 2) }} DH</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection