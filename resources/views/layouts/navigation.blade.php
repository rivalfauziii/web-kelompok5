{{-- resources/views/layouts/navigation.blade.php --}}

<nav class="w-64 h-screen bg-[#0f172a] text-white fixed z-50 shadow-2xl flex flex-col overflow-hidden">

    {{-- LOGO --}}
    <div class="px-6 py-6 border-b border-slate-700 flex-shrink-0">

        <h1 class="text-2xl font-black tracking-wide text-blue-400">
            SYAKAMARKET
        </h1>

        <p class="text-slate-400 text-sm mt-1">
            Smart Minimarket Syste
        </p>

    </div>

    {{-- PROFILE --}}
    <div class="px-6 py-5 border-b border-slate-700 flex-shrink-0">

        <div class="flex items-center gap-3">

            <div class="w-11 h-11 rounded-xl bg-blue-500 flex items-center justify-center text-lg font-bold shadow-lg">

                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

            </div>

            <div>

                <h2 class="font-semibold text-sm">

                    {{ auth()->user()->name }}

                </h2>

                <p class="text-xs text-slate-400 uppercase">

                    {{ auth()->user()->role }}

                </p>

                @if(auth()->user()->branch)

                    <p class="text-[10px] text-blue-400">

                        {{ auth()->user()->branch->name }}

                    </p>

                @endif

            </div>

        </div>

    </div>

    {{-- MENU --}}
    <div class="flex-1 overflow-y-auto px-4 py-5 space-y-2">

        {{-- DASHBOARD --}}
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition duration-200
           {{ request()->routeIs('dashboard') ? 'bg-blue-500 shadow-lg' : 'hover:bg-slate-800' }}">

            <span class="text-lg">📊</span>

            <div>

                <h2 class="font-semibold text-sm">
                    Dashboard
                </h2>

                <p class="text-[11px] text-slate-300">
                    Statistik sistem
                </p>

            </div>

        </a>

        {{-- PRODUK --}}
        @if(
                in_array(auth()->user()->role, [
                    'owner',
                    'manager',
                    'supervisor'
                ])
            )

            <a href="{{ route('products.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition duration-200
                   {{ request()->routeIs('products.*') ? 'bg-blue-500 shadow-lg' : 'hover:bg-slate-800' }}">

                <span class="text-lg">📦</span>

                <div>

                    <h2 class="font-semibold text-sm">
                        Produk
                    </h2>

                    <p class="text-[11px] text-slate-300">
                        Data produk
                    </p>

                </div>

            </a>

        @endif

        {{-- KASIR --}}
        @if(auth()->user()->role == 'cashier')

            <a href="{{ route('cashier.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition duration-200
                   {{ request()->routeIs('cashier.*') ? 'bg-blue-500 shadow-lg' : 'hover:bg-slate-800' }}">

                <span class="text-lg">🛒</span>

                <div>

                    <h2 class="font-semibold text-sm">
                        Kasir
                    </h2>

                    <p class="text-[11px] text-slate-300">
                        Transaksi penjualan
                    </p>

                </div>

            </a>

        @endif

        {{-- TRANSAKSI --}}
        @if(
                in_array(auth()->user()->role, [
                    'owner',
                    'manager',
                    'supervisor',
                    'cashier'
                ])
            )

            <a href="{{ route('transactions.history') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition duration-200
                   {{ request()->routeIs('transactions.*') ? 'bg-blue-500 shadow-lg' : 'hover:bg-slate-800' }}">

                <span class="text-lg">💳</span>

                <div>

                    <h2 class="font-semibold text-sm">
                        Transaksi
                    </h2>

                    <p class="text-[11px] text-slate-300">
                        Riwayat transaksi
                    </p>

                </div>

            </a>

        @endif

        {{-- STOCK --}}
        @if(
                in_array(auth()->user()->role, [
                    'owner',
                    'manager',
                    'warehouse',
                    'supervisor'
                ])
            )

            <a href="{{ route('stocks.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition duration-200
                   {{ request()->routeIs('stocks.*') ? 'bg-blue-500 shadow-lg' : 'hover:bg-slate-800' }}">

                <span class="text-lg">📚</span>

                <div>

                    <h2 class="font-semibold text-sm">
                        Stock
                    </h2>

                    <p class="text-[11px] text-slate-300">
                        Monitoring stok
                    </p>

                </div>

            </a>

        @endif

        {{-- CABANG --}}
        @if(auth()->user()->role == 'owner')

            <a href="{{ route('branches.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition duration-200
                   {{ request()->routeIs('branches.*') ? 'bg-blue-500 shadow-lg' : 'hover:bg-slate-800' }}">

                <span class="text-lg">🏢</span>

                <div>

                    <h2 class="font-semibold text-sm">
                        Cabang
                    </h2>

                    <p class="text-[11px] text-slate-300">
                        Kelola cabang
                    </p>

                </div>

            </a>

        @endif

        {{-- USER --}}
        @if(auth()->user()->role == 'owner')

            <a href="{{ route('users.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition duration-200
                   {{ request()->routeIs('users.*') ? 'bg-blue-500 shadow-lg' : 'hover:bg-slate-800' }}">

                <span class="text-lg">👥</span>

                <div>

                    <h2 class="font-semibold text-sm">
                        Kelola User
                    </h2>

                    <p class="text-[11px] text-slate-300">
                        Akun seluruh cabang
                    </p>

                </div>

            </a>

        @endif

        {{-- PROFILE --}}
        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition duration-200
           {{ request()->routeIs('profile.*') ? 'bg-blue-500 shadow-lg' : 'hover:bg-slate-800' }}">

            <span class="text-lg">⚙️</span>

            <div>

                <h2 class="font-semibold text-sm">Profile
                </h2>

                <p class="text-[11px] text-slate-300">Pengaturan akun
                </p>

            </div>

        </a>

    </div>

    {{-- FOOTER --}}
    <div class="p-4 border-t border-slate-700 bg-[#0f172a] flex-shrink-0">

        <form method="POST" action="{{ route('logout') }}">

            @csrf

            <button type="submit"
                class="w-full bg-red-500 hover:bg-red-600 transition py-3 rounded-xl font-semibold text-sm shadow-lg">

                Logout

            </button>

        </form>

    </div>

</nav>