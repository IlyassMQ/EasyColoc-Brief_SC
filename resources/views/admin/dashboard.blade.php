@extends('layouts.admin')
@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-bold text-gray-900">Vue d'ensemble</h2>
</div>


<div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-3">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition">
        <div class="p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Users</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{$totalUsers}}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fa-regular fa-user text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition">
        <div class="p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Colocations</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{$totalColocations}}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-house text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition">
        <div class="p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Banned Users</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $bannedUsersCount }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-user-slash text-orange-600 text-xl"></i>
                </div>
            </div>
            
        </div>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-200 flex items-center justify-between">
        <div>
            <h3 class="text-lg font-semibold text-gray-900">Liste des utilisateurs</h3>
            <p class="text-sm text-gray-500 mt-1">Gérez les utilisateurs de la plateforme</p>
        </div>
        
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        ID
                    </th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Utilisateur
                    </th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Email
                    </th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Réputation
                    </th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Statut
                    </th>
                    <th scope="col" class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($users as $user)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        #{{$user->id}}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">{{$user->name}}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                        {{$user->email}}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <span class="text-sm font-medium {{ $user->reputation >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{$user->reputation}}
                            </span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if ($user->role === 'admin')
                            <span class="px-3 py-1 text-xs font-medium bg-purple-100 text-purple-700 rounded-full">Admin</span>
                        @elseif ($user->banned_at === null)
                            <span class="px-3 py-1 text-xs font-medium bg-green-100 text-green-700 rounded-full">Actif</span>
                        @else
                            <span class="px-3 py-1 text-xs font-medium bg-red-100 text-red-700 rounded-full">Banni</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right">
                        @if ($user->role === 'admin')
                            <button class="px-4 py-2 text-sm font-medium text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed" disabled>
                                <i class="fas fa-shield-alt mr-1"></i> Protégé
                            </button>
                        @elseif ($user->banned_at === null)
                            <form action="{{ route('admin.users.ban', $user) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" 
                                        class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition shadow-sm hover:shadow"
                                        onclick="return confirm('Êtes-vous sûr de vouloir bannir {{ $user->name }} ?')">
                                    <i class="fas fa-ban mr-1"></i> Banni
                                </button>
                            </form>
                        @else
                            <form action="{{ route('admin.users.unban', $user) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" 
                                        class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 transition shadow-sm hover:shadow"
                                        onclick="return confirm('Réactiver le compte de {{ $user->name }} ?')">
                                    <i class="fas fa-check mr-1"></i> Debanni
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>    
</div>

@endsection