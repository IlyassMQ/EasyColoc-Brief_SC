<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="font-sans bg-gray-100">
    <div class="flex min-h-screen">
        <aside class="flex-shrink-0 w-64 text-white shadow-xl bg-slate-900">
            <div class="p-6">
                <h1 class="text-xl font-bold tracking-widest text-indigo-400 uppercase">Admin</h1>
            </div>
            
            <nav class="px-4 mt-4">
                <div class="space-y-2">
                    <a href="#" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-slate-800">
                    <i class="fas fa-chart-bar"></i>                      
                    <span>Statistique</span>
                    </a>

                    <div class="pt-4 pb-2">
                        <p class="px-3 text-xs font-semibold text-gray-500 uppercase">Inventaire</p>
                    </div>
                    
                    <a href="#" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-slate-800 transition {{ request()->routeIs('fournisseurs.*') ? 'bg-indigo-600' : '' }}">
                        <i class="w-5 fas fa-truck"></i>
                        <span>Routour App</span>
                    </a>
                </div>
            </nav>
        </aside>

        <div class="flex flex-col flex-1">
            

            <main class="p-8">

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>