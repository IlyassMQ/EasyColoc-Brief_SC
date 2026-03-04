<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - EasyColoc</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-gray-100 to-gray-200 min-h-screen flex flex-col justify-center py-12 px-4 sm:px-6 lg:px-8">
    
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        
        <h2 class="mt-4 text-center text-3xl font-extrabold text-gray-900">
            Rejoindre
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600">
            Déjà inscrit ? 
            <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500 transition">
                Connectez-vous
            </a>
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-6 shadow-xl rounded-xl sm:px-10 border border-gray-100">

            @if ($errors->any())
                <div class="mb-4 bg-red-50 border border-red-200 text-red-700 rounded-lg p-4">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-circle text-red-500 mr-2 mt-0.5"></i>
                        <div>
                            <span class="text-sm font-medium">Veuillez corriger les erreurs suivantes :</span>
                            <ul class="mt-2 text-xs list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Nom complet
                    </label>
                    <div class="relative">
                        <input type="text" 
                               name="name" 
                               value="{{ old('name') }}" 
                               required 
                               autofocus
                               class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('name') border-red-500 ring-red-500 @enderror"
                               placeholder="Name">
                    </div>
                    @error('name')
                        <p class="mt-1 text-xs text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Adresse email
                    </label>
                    <div class="relative">

                        <input type="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required
                               class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('email') border-red-500 ring-red-500 @enderror"
                               placeholder="vous@exemple.com">
                    </div>
                    @error('email')
                        <p class="mt-1 text-xs text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Mot de passe
                        </label>
                        <div class="relative">
                            <input type="password" 
                                   name="password" 
                                   required
                                   id="password"
                                   class="w-full pl-10 pr-10 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('password') border-red-500 @enderror"
                                   placeholder="********">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Confirmation</span>
                        </label>
                        <div class="relative">
                            <input type="password" 
                                   name="password_confirmation" 
                                   required
                                   id="password_confirmation"
                                   class="w-full pl-10 pr-10 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                   placeholder="********">
                        </div>
                    </div>
                </div>
                @error('password')
                    <p class="mt-1 text-xs text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
                <div class="pt-2">
                    <button type="submit" 
                            class="w-full flex items-center justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition transform hover:-translate-y-0.5">
                        <i class="fas fa-user-plus mr-2"></i>
                        Créer mon compte
                    </button>
                </div>

                <div class="relative mt-4">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-xs">
                        <span class="px-2 bg-white text-gray-500">Déjà un compte ?</span>
                    </div>
                </div>

                <p class="text-center text-sm">
                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-500 font-medium">
                        Connectez-vous ici
                    </a>
                </p>
            </form>
        </div>
    </div>
</body>
</html>