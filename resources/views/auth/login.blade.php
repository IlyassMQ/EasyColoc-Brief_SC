<script src="https://cdn.tailwindcss.com"></script>
<div class="min-h-screen bg-gray-100 flex flex-col justify-center py-12 px-6">
    <div class="sm:mx-auto sm:w-full sm:max-max-w-md">
        <h2 class="text-center text-3xl font-extrabold text-gray-900">Connexion à EasyColoc</h2>
        <p class="mt-2 text-center text-sm text-gray-600">
            Ou 
            <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-500">créez un compte gratuitement</a>
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-6 shadow rounded-lg sm:px-10">
            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Mot de passe</label>
                    <input type="password" name="password" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input type="checkbox" name="remember" class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                        <label class="ml-2 block text-sm text-gray-900">Se souvenir de moi</label>
                    </div>
                </div>

                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none">
                    Se connecter
                </button>
            </form>
        </div>
    </div>
</div>