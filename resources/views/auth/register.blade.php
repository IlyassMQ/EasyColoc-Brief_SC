<script src="https://cdn.tailwindcss.com"></script>
<div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 px-6">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <h2 class="text-center text-3xl font-extrabold text-gray-900">Rejoindre l'aventure</h2>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-6 shadow-xl rounded-2xl border border-gray-100">
            <form action="{{ route('register') }}" method="POST" class="space-y-4">
                @csrf
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nom complet</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="mt-1 block w-full border rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="mt-1 block w-full border rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                    @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Mot de passe</label>
                        <input type="password" name="password" required class="mt-1 block w-full border rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Confirmation</label>
                        <input type="password" name="password_confirmation" required class="mt-1 block w-full border rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                </div>
                @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

                <div class="pt-4">
                    <button type="submit" class="w-full bg-black text-white py-3 rounded-lg font-bold hover:bg-gray-800 transition duration-200">
                        Créer mon compte
                    </button>
                </div>

                <p class="text-center text-xs text-gray-500 mt-4">
                    En vous inscrivant, vous acceptez nos conditions d'utilisation.
                </p>
            </form>
        </div>
    </div>
</div>