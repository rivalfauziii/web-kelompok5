<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SyakaMarket</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="h-screen flex bg-gray-50">

    <div class="hidden md:flex w-1/2 bg-gradient-to-br from-emerald-500 to-emerald-800 text-white items-center justify-center">
        <div class="text-center px-10">
            <h1 class="text-5xl font-black mb-4 tracking-wide">
                SYAKAMARKET
            </h1>
            <p class="text-emerald-100 text-lg">
                Solusi Belanja Kebutuhanmu
            </p>
            <div class="mt-10 text-7xl opacity-20">
                🛒
            </div>
        </div>
    </div>

    {{-- RIGHT FORM --}}
    <div class="w-full md:w-1/2 flex items-center justify-center">

        <div class="w-full max-w-md bg-white p-10 rounded-2xl shadow-xl border border-gray-100">

            <h2 class="text-3xl font-bold text-gray-800">Login</h2>
            <p class="text-gray-500 mb-6">Masuk ke sistem kasir</p>

            {{-- ERROR --}}
            @if ($errors->any())
                <div class="mb-4 text-red-500 text-sm">
                    Email atau password salah
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">

                @csrf

                <div>
                    <label class="text-sm text-gray-600">Email</label>
                    <input type="email" name="email"
                        class="w-full mt-1 border rounded-xl px-4 py-3 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                        required>
                </div>

                <div>
                    <label class="text-sm text-gray-600">Password</label>
                    <input type="password" name="password"
                        class="w-full mt-1 border rounded-xl px-4 py-3 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                        required>
                </div>

                <div class="flex items-center justify-between text-sm">

                    <label class="flex items-center gap-2 text-gray-600">
                        <input type="checkbox" name="remember">
                        Remember me
                    </label>

                    <a href="#" class="text-emerald-600 hover:underline">
                        Lupa password?
                    </a>

                </div>

                <button type="submit"
                    class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-3 rounded-xl font-bold shadow-md transition">

                    LOGIN

                </button>

            </form>

        </div>

    </div>

</body>
</html>