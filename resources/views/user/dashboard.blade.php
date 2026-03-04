@extends('layouts.user')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">
                    Bonjour, {{ $user->name }}
                </h2>
                
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-2">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">
                            Votre Réputation
                        </p>
                        <div class="flex items-baseline mt-2">
                            <p class="text-4xl font-bold text-gray-900">{{ $user->reputation }}</p>
                            <span class="ml-2 text-sm text-gray-500">points</span>
                        </div>
                    </div>
                    <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center">
                        <i class="fa-solid fa-star text-blue-600 text-3xl"></i>
                    </div>
                </div>
                
            
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">
                            Total Dépenses Payées
                        </p>
                        <div class="flex items-baseline mt-2">
                            <p class="text-4xl font-bold text-gray-900">{{ number_format($totalExpenses, 2) }}</p>
                            <span class="ml-2 text-sm text-gray-500">DH</span>
                        </div>
                        <p class="mt-3 text-sm text-gray-500">
                            Depuis votre inscription
                        </p>
                    </div>
                    <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center">
                        <i class="fa-solid fa-euro-sign text-green-600 text-3xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-200 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-receipt text-blue-600"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">
                        Vos 10 dernières dépenses
                    </h3>
                    <p class="text-sm text-gray-500">
                        Historique de vos transactions récentes
                    </p>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <div class="flex items-center space-x-1">
                                <span>Titre</span>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <div class="flex items-center space-x-1">
                                <span>Montant</span>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <div class="flex items-center space-x-1">
                                <span>Colocation</span>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <div class="flex items-center space-x-1">
                                <span>Catégorie</span>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <div class="flex items-center space-x-1">
                                <span>Date</span>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($recentExpenses as $expense)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-receipt text-blue-600 text-xs"></i>
                                    </div>
                                    <span class="font-medium text-gray-900">{{ $expense->title }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-semibold text-gray-900">{{ number_format($expense->amount, 2) }}</span>
                                <span class="text-gray-500">DH</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('colocations.show', $expense->colocation) }}" class="text-blue-600 hover:text-blue-700 hover:underline">
                                    {{ $expense->colocation->name }}
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 text-xs font-medium bg-gray-100 text-gray-700 rounded-full">
                                    {{ $expense->category->name }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{$expense->date}}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12">
                                <div class="text-center">
                                    <div class="w-16 h-16 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-3">
                                        <i class="fa-solid fa-receipt text-gray-400 text-xl"></i>
                                    </div>
                                    <p class="text-gray-500 font-medium">Aucune dépense enregistrée</p>
                                    
                                    <a href="{{ route('colocations.index') }}" 
                                       class="inline-flex items-center mt-4 px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition">
                                        <i class="fas fa-plus-circle mr-2"></i>
                                        Voir mes colocations
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        
    </div>
</div>
@endsection