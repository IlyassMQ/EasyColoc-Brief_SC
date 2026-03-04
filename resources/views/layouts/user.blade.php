<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">

<div class="flex min-h-screen">

    <aside class="w-64 bg-gray-900 text-white">
        
        <div class="p-6 bg-gray-950 border-b border-gray-800">
            <h1 class="text-xl font-bold text-white">
                <i class="fas fa-home mr-2 text-blue-400"></i>
                EasyColoc
            </h1>
            <p class="text-sm text-gray-400 mt-2">
                <i class="fas fa-user-circle mr-1"></i>
                {{ auth()->user()->name }}
            </p>
        </div>
        
        <nav class="p-4">
            <div class="mb-6">
                <p class="text-xs text-gray-500 uppercase tracking-wider mb-2 px-3">
                    Menu principal
                </p>
                
                <a href="{{ route('user.dashboard') }}" 
                   class="flex items-center space-x-3 p-3 rounded-lg bg-gray-800 text-white mb-1">
                    <i class="fas fa-home w-5 text-blue-400"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-800 hover:text-white transition mb-1">
                    <i class="fas fa-user-shield w-5 text-gray-400"></i>
                    <span>Admin</span>
                    <span class="ml-auto text-xs bg-gray-700 text-gray-300 px-2 py-0.5 rounded-full">Admin</span>
                </a>

                <a href="{{ route('colocations.index') }}" 
                   class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-gray-800 hover:text-white transition mb-1">
                    <i class="fas fa-users w-5 text-gray-400"></i>
                    <span>Colocations</span>
                </a>
            </div>

        </nav>

        <div class="p-4 border-t border-gray-800 mt-auto">
            <div class="bg-gray-800 rounded-lg p-3 mb-3">
                <div class="flex justify-between items-center">
                    <p class="text-xs text-gray-400">Ma réputation</p>
                </div>
                <div class="flex items-center justify-between mt-1">
                    <p class="text-2xl font-bold {{ (auth()->user()->reputation ?? 0) >= 0 ? 'text-green-400' : 'text-red-400' }}">
                        {{ auth()->user()->reputation ?? 0 }}
                    </p>
                </div>
                
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" 
                        class="w-full flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-red-600 hover:text-white transition">
                    <i class="fas fa-sign-out-alt w-5"></i>
                    <span>Déconnexion</span>
                </button>
            </form>
            
        </div>
    </aside>

    <div class="flex-1">
        <div class="bg-white shadow-sm p-4 flex justify-between items-center border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">
                <i class="fas fa-home text-blue-600 mr-2"></i>
                Mon Dashboard
            </h2>
            
        </div>

        <main class="p-6">
            @yield('content')
        </main>
        
    </div>
</div>

</body>
</html>