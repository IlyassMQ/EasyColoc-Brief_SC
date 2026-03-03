<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="font-sans bg-gray-100">

<div class="flex min-h-screen">

    <!-- Sidebar -->
    <aside class="flex-shrink-0 w-64 text-white shadow-xl bg-slate-900">
        
        <div class="p-6">
            <h1 class="text-xl font-bold tracking-widest text-indigo-400 uppercase">
                EasyColoc
            </h1>
            <p class="mt-2 text-sm text-gray-400">
                Bonjour {{ auth()->user()->name }}
            </p>
        </div>

        <nav class="px-4 mt-4">
            <div class="space-y-2">

                <!-- Dashboard -->
                <a href="{{ route('user.dashboard') }}"
                   class="flex items-center space-x-3 p-3 rounded-lg hover:bg-slate-800 transition>
                    <i class="fas fa-home w-5"></i>
                    <span>Dashboard</span>
                </a>

                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center space-x-3 p-3 rounded-lg hover:bg-slate-800 transition>
                    <i class="fas fa-home w-5"></i>
                    <span>admin</span>
                </a>

                <!-- Colocations -->
                <a href="{{ route('colocations.index') }}"
                   class="flex items-center space-x-3 p-3 rounded-lg hover:bg-slate-800 transition">
                    <i class="fas fa-users w-5"></i>
                    <span>Colocations</span>
                </a>

                <!-- Profile -->
                <a href="{{ route('profile.edit') }}"
                   class="flex items-center space-x-3 p-3 rounded-lg hover:bg-slate-800 transition">
                    <i class="fas fa-user w-5"></i>
                    <span>Profile</span>
                </a>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex items-center w-full p-3 space-x-3 text-left transition rounded-lg hover:bg-red-600">
                        <i class="fas fa-sign-out-alt w-5"></i>
                        <span>Déconnexion</span>
                    </button>
                </form>

            </div>
        </nav>

    </aside>

    <!-- Main Content -->
    <div class="flex flex-col flex-1">
        <main class="p-8">
            @yield('content')
        </main>
    </div>

</div>

</body>
</html>