<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - EasyColoc</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  
</head>
<body class="bg-gradient-to-br from-gray-100 to-gray-200 min-h-screen flex flex-col justify-center py-12 px-4 sm:px-6 lg:px-8">

    
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
      
        
        <h2 class="mt-4 text-center text-3xl font-extrabold text-gray-900">
            EasyColoc
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600">
            Bienvenue ! 
            <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-500 transition">
                Créez un compte gratuitement
            </a>
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-6 shadow-xl rounded-xl sm:px-10 border border-gray-100">

            @error('email')
                <div class="mb-4 bg-red-50 border border-red-200 text-red-700 rounded-lg p-3 flex items-center">
                    <i class="fas fa-exclamation-circle text-red-500 mr-2"></i>
                    <span class="text-sm">{{ $message }}</span>
                </div>
            @enderror

            @error('password')
                <div class="mb-4 bg-red-50 border border-red-200 text-red-700 rounded-lg p-3 flex items-center">
                    <i class="fas fa-exclamation-circle text-red-500 mr-2"></i>
                    <span class="text-sm">{{ $message }}</span>
                </div>
            @enderror

            @if(session('status'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-700 rounded-lg p-3 flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                    <span class="text-sm">{{ session('status') }}</span>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Adresse email
                    </label>
                    <div class="relative">
                        
                        <input type="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required 
                               autofocus
                               class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('email') border-red-500 ring-red-500 @enderror"
                               placeholder="vous@exemple.com">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Mot de passe
                    </label>
                    <div class="relative">
                        
                        <input type="password" 
                               name="password" 
                               required 
                               class="w-full pl-10 pr-10 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('password') border-red-500 ring-red-500 @enderror"
                               placeholder="********">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:text-blue-500 transition">
                            Mot de passe oublié ?
                        </a>
                    @endif
                </div>

                <button type="submit" 
                        class="w-full flex items-center justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition transform hover:-translate-y-0.5">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Se connecter
                </button>
            </form>
        </div>

        
    </div>
</body>
</html>