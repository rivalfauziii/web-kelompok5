{{-- resources/views/layouts/navigation.blade.php --}}

@php
    $user = auth()->user();
    $role = $user->role;
@endphp

<nav class="fixed left-0 top-0 h-screen w-72 bg-zinc-950 border-r border-zinc-800 text-zinc-100 flex flex-col">

    {{-- LOGO --}}
    <div class="px-7 py-7 border-b border-zinc-800">
        <h1 class="text-2xl font-semibold tracking-wide">
            Syaka<span class="text-emerald-500">Market</span>
        </h1>
        <p class="text-zinc-500 text-sm mt-1">
            Retail Management System
        </p>
    </div>

    {{-- PROFILE --}}
    <div class="p-5">
        <div class="bg-zinc-900 rounded-2xl p-4 border border-zinc-800">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-600 flex items-center justify-center font-semibold">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>

                <div>
                    <h2 class="font-medium text-sm">{{ $user->name }}</h2>
                    <p class="text-xs text-zinc-500 uppercase mt-1">{{ $role }}</p>

                    @if($user->branch)
                        <p class="text-xs text-emerald-500 mt-1">
                            {{ $user->branch->name }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- MENU --}}
    <div class="flex-1 px-4 space-y-2 overflow-y-auto">

        {{-- Dashboard --}}
        <a href="{{ route('dashboard') }}"
            class="block px-4 py-3 rounded-2xl {{ request()->routeIs('dashboard') ? 'bg-emerald-600' : 'hover:bg-zinc-900' }}">
            Dashboard
        </a>

        {{-- Produk --}}
        @if(in_array($role, ['owner', 'manager', 'supervisor']))
            <a href="{{ route('products.index') }}"
                class="block px-4 py-3 rounded-2xl {{ request()->routeIs('products.*') ? 'bg-emerald-600' : 'hover:bg-zinc-900' }}">
                Produk
            </a>
        @endif

        {{-- Kasir --}}
        @if($role == 'cashier')
            <a href="{{ route('cashier.index') }}"
                class="block px-4 py-3 rounded-2xl {{ request()->routeIs('cashier.*') ? 'bg-emerald-600' : 'hover:bg-zinc-900' }}">
                Kasir
            </a>
        @endif

        {{-- Transaksi --}}
        @if(in_array($role, ['owner', 'manager', 'supervisor', 'cashier']))
            <a href="{{ route('transactions.history') }}"
                class="block px-4 py-3 rounded-2xl {{ request()->routeIs('transactions.*') ? 'bg-emerald-600' : 'hover:bg-zinc-900' }}">
                Transaksi
            </a>
        @endif

        {{-- Stock --}}
        @if(in_array($role, ['owner', 'manager', 'warehouse', 'supervisor']))
            <a href="{{ route('stocks.index') }}"
                class="block px-4 py-3 rounded-2xl {{ request()->routeIs('stocks.*') ? 'bg-emerald-600' : 'hover:bg-zinc-900' }}">
                Stock
            </a>
        @endif

        {{-- Owner Only --}}
        @if($role == 'owner')
            <a href="{{ route('branches.index') }}"
                class="block px-4 py-3 rounded-2xl {{ request()->routeIs('branches.*') ? 'bg-emerald-600' : 'hover:bg-zinc-900' }}">
                Cabang
            </a>

            <a href="{{ route('users.index') }}"
                class="block px-4 py-3 rounded-2xl {{ request()->routeIs('users.*') ? 'bg-emerald-600' : 'hover:bg-zinc-900' }}">
                Users
            </a>
        @endif
        
        @if(in_array(auth()->user()->role, ['owner', 'manager', 'supervisor', 'warehouse']))
            <a href="{{ route('reports.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition
            {{ request()->routeIs('reports.*') ? 'bg-emerald-600 text-white' : 'hover:bg-zinc-900 text-zinc-300' }}">
                <span>Laporan</span>
            </a>
        @endif

        {{-- Profile --}}
        <a href="{{ route('profile.edit') }}"
            class="block px-4 py-3 rounded-2xl {{ request()->routeIs('profile.*') ? 'bg-emerald-600' : 'hover:bg-zinc-900' }}">
            Profile
        </a>

    </div>

    {{-- FOOTER --}}
    <div class="p-5 border-t border-zinc-800">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="w-full bg-zinc-900 hover:bg-red-600 transition py-3 rounded-2xl font-medium">
                Logout
            </button>
        </form>
    </div>

</nav>