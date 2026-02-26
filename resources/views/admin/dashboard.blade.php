@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-bold text-gray-800">Vue d'ensemble</h2>
    <p class="text-gray-600">Bienvenue dans votre gestionnaire TifawinSouk.</p>
</div>

<div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-3">
    <div class="p-6 bg-white border-b-4 border-blue-500 shadow-sm rounded-xl">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-bold text-gray-500 uppercase">Total User</p>
                <p class="text-3xl font-black text-gray-800">{{$totalUsers}}</p>
            </div>
            <div class="p-3 text-blue-600 bg-blue-100 rounded-full">
<i class="fa-regular fa-user fa-2xl" style="color: rgb(0, 0, 0);"></i>            </div>
        </div>
    </div>

    <div class="p-6 bg-white border-b-4 border-purple-500 shadow-sm rounded-xl">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-bold text-gray-500 uppercase">Total Colocation</p>
                <p class="text-3xl font-black text-gray-800">{{$totalColocations}}</p>
            </div>
            <div class="p-3 text-purple-600 bg-purple-100 rounded-full">
<i class="fa-solid fa-house fa-2xl" style="color: rgb(0, 0, 0);"></i>  
          </div>
        </div>
    </div>

    <div class="p-6 bg-white border-b-4 border-orange-500 shadow-sm rounded-xl">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-bold text-gray-500 uppercase">Banned User</p>
                <p class="text-3xl font-black text-gray-800">{{ $bannedUsersCount }}</p>
            </div>
            <div class="p-3 text-orange-600 bg-orange-100 rounded-full">
<i class="fa-solid fa-user-slash fa-2xl" style="color: rgb(0, 0, 0);"></i>            </div>
        </div>
    </div>
</div>

@endsection 