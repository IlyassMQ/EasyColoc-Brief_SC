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
            <i class="fa-regular fa-user fa-2xl" style="color: rgb(0, 0, 0);"></i>
         </div>
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
            <i class="fa-solid fa-user-slash fa-2xl" style="color: rgb(0, 0, 0);"></i>
         </div>
      </div>
   </div>
</div>
<div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default">
   <table class="w-full text-sm text-left rtl:text-right text-body">
      <caption class="p-5 text-lg font-medium text-left rtl:text-right text-heading">
         All Users
      </caption>
      <thead class="text-sm text-body bg-neutral-secondary-medium border-b border-t border-default-medium">
         <tr>
            <th scope="col" class="px-6 py-3 font-medium">
               ID
            </th>
            <th scope="col" class="px-6 py-3 font-medium">
               Utilisateur
            </th>
            <th scope="col" class="px-6 py-3 font-medium">
               Email
            </th>
            <th scope="col" class="px-6 py-3 font-medium">
               Reputation
            </th>
            <th scope="col" class="px-6 py-3 font-medium">
               Actions
            </th>
         </tr>
      </thead>
      <tbody>
         @foreach ($users as $user)
         <tr class="bg-neutral-primary-soft border-b border-default">
            <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
               {{$user->id}}
            </th>
            <td class="px-6 py-4">
               {{$user->name}}
            </td>
            <td class="px-6 py-4">
               {{$user->email}}
            </td>
            <td class="px-6 py-4">
               {{$user->reputation}}
            </td>
            <td class="px-6 py-4">
               @if ($user->banned_at === null)
               <span class="text-green-700 font-bold">Actif</span>
               @else
               <span class="text-red-500 font-bold">Banned</span>
               @endif
            </td>
            <td class="px-6 py-4 text-right">
               @if ($user->role === 'admin')
               <button
                  class="px-3 py-1 text-sm font-semibold text-white bg-gray-600 rounded hover:bg-gray-700 cursor-not-allowed">
               protected
               </button>
               @elseif ($user->banned_at === null)
               <form action="{{ route('admin.users.ban', $user) }}" method="POST">
                  @csrf
                  <button type="submit"
                     class="px-3 py-1 text-sm font-semibold text-white bg-red-600 rounded hover:bg-red-700">
                  Ban
                  </button>
               </form>
               @else
               <form action="{{ route('admin.users.unban', $user) }}" method="POST">
                  @csrf
                  <button type="submit"
                     class="px-3 py-1 text-sm font-semibold text-white bg-green-600 rounded hover:bg-green-700">
                  Unban
                  </button>
               </form>
               @endif                 
            </td>
         </tr>
         @endforeach
      </tbody>
   </table>
</div>
@endsection