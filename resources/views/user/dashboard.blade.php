@extends('layouts.user')
@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-bold text-gray-800">Bienvenue {{ $user->name }}</h2>
    <p class="text-gray-600">Voici un aperçu de votre activité dans EasyColoc.</p>
</div>

<div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-2">
    <!-- Reputation -->
    <div class="p-6 bg-white border-b-4 border-blue-500 shadow-sm rounded-xl">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-bold text-gray-500 uppercase">Votre Réputation</p>
                <p class="text-3xl font-black text-gray-800">{{ $user->reputation }}</p>
            </div>
            <div class="p-3 text-blue-600 bg-blue-100 rounded-full">
                <i class="fa-solid fa-star fa-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Total expenses -->
    <div class="p-6 bg-white border-b-4 border-green-500 shadow-sm rounded-xl">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-bold text-gray-500 uppercase">Total Dépenses Payées</p>
                <p class="text-3xl font-black text-gray-800">{{ number_format($totalExpenses, 2) }}€</p>
            </div>
            <div class="p-3 text-green-600 bg-green-100 rounded-full">
                <i class="fa-solid fa-euro-sign fa-2xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Recent expenses -->
<div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default">
    <table class="w-full text-sm text-left rtl:text-right text-body">
        <caption class="p-5 text-lg font-medium text-left rtl:text-right text-heading">
            Vos 10 dernières dépenses
        </caption>
        <thead class="text-sm text-body bg-neutral-secondary-medium border-b border-t border-default-medium">
            <tr>
                <th class="px-6 py-3 font-medium">Titre</th>
                <th class="px-6 py-3 font-medium">Montant</th>
                <th class="px-6 py-3 font-medium">Colocation</th>
                <th class="px-6 py-3 font-medium">Catégorie</th>
                <th class="px-6 py-3 font-medium">Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentExpenses as $expense)
                <tr class="bg-neutral-primary-soft border-b border-default">
                    <td class="px-6 py-4">{{ $expense->title }}</td>
                    <td class="px-6 py-4">{{ number_format($expense->amount, 2) }}€</td>
                    <td class="px-6 py-4">{{ $expense->colocation->name }}</td>
                    <td class="px-6 py-4">{{ $expense->category->name }}</td>
                    <td class="px-6 py-4">{{ $expense->date->format('d/m/Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-gray-400 italic text-center">
                        Aucune dépense enregistrée.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection