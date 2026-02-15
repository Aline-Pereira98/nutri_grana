<x-guest-layout>

    <div class="bg-white/95 backdrop-blur-xl shadow-2xl rounded-2xl
                w-full max-w-md p-8 border border-white/20">

        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-[#1fa67e]">
                NutriGrana
            </h1>
            <p class="text-gray-500 text-sm mt-2">
                Crie sua conta e organize suas finanças
            </p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <!-- Nome -->
            <div>
                <label class="block text-sm font-medium text-gray-600">
                    Nome
                </label>
                <input type="text"
                       name="name"
                       value="{{ old('name') }}"
                       required
                       class="mt-1 w-full rounded-lg border-gray-200
                              focus:border-[#1fa67e] focus:ring-[#1fa67e] shadow-sm">
                <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-red-500" />
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-gray-600">
                    Email
                </label>
                <input type="email"
                       name="email"
                       value="{{ old('email') }}"
                       required
                       class="mt-1 w-full rounded-lg border-gray-200
                              focus:border-[#1fa67e] focus:ring-[#1fa67e] shadow-sm">
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-500" />
            </div>

            <!-- Senha -->
            <div>
                <label class="block text-sm font-medium text-gray-600">
                    Senha
                </label>
                <input type="password"
                       name="password"
                       required
                       class="mt-1 w-full rounded-lg border-gray-200
                              focus:border-[#1fa67e] focus:ring-[#1fa67e] shadow-sm">
            </div>

            <!-- Confirmar -->
            <div>
                <label class="block text-sm font-medium text-gray-600">
                    Confirmar senha
                </label>
                <input type="password"
                       name="password_confirmation"
                       required
                       class="mt-1 w-full rounded-lg border-gray-200
                              focus:border-[#1fa67e] focus:ring-[#1fa67e] shadow-sm">
            </div>

            <button type="submit"
                    class="w-full bg-[#1fa67e] hover:bg-[#188f6b]
                           text-white font-semibold py-2.5 rounded-lg
                           shadow-lg transition duration-300">
                Criar conta
            </button>

            <div class="text-center text-sm text-gray-500 mt-4">
                Já tem conta?
                <a href="{{ route('login') }}"
                   class="text-[#1fa67e] font-semibold hover:underline">
                    Entrar
                </a>
            </div>

        </form>

    </div>

</x-guest-layout>
