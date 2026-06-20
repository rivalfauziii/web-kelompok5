<x-app-layout>

    @php
        $role = auth()->user()->role;
    @endphp

    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 p-8">

        {{-- TOP HEADER --}}
        <div class="flex justify-between items-center mb-10">

            <div>
                <h1 class="text-5xl font-black text-gray-800 dark:text-white">
                    Dashboard
                </h1>

                <p class="text-gray-500 mt-2 text-lg">
                    Welcome back, {{ auth()->user()->name }} 👋
                </p>
            </div>

            <div class="bg-white dark:bg-gray-800 px-6 py-4 rounded-3xl shadow-lg">
                <p class="text-gray-500 text-sm">Today</p>
                <h2 class="font-bold text-xl">
                    {{ now()->format('d M Y') }}
                </h2>
            </div>

        </div>

        {{-- ROLE BADGE --}}
        <div class="mb-6 flex gap-3 items-center">

            <span class="bg-blue-100 text-blue-700 px-4 py-2 rounded-full font-semibold">
                {{ strtoupper($role) }}
            </span>

            @if(auth()->user()->branch)
                <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full font-semibold">
                    {{ auth()->user()->branch->name }}
                </span>
            @endif

        </div>

        {{-- ================= CARD SECTION ================= --}}

        <div class="grid gap-8 mb-10">

            {{-- OWNER / MANAGER --}}
            @if(in_array($role, ['owner', 'manager']))

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-8">

                    {{-- PRODUCT --}}
                    <div class="bg-gradient-to-r from-blue-500 to-blue-700 p-8 rounded-3xl text-white">
                        <p>Total Produk</p>
                        <h2 class="text-4xl font-bold">{{ $totalProducts }}</h2>
                    </div>

                    {{-- TRANSACTION --}}
                    <div class="bg-gradient-to-r from-green-500 to-green-700 p-8 rounded-3xl text-white">
                        <p>Total Transaksi</p>
                        <h2 class="text-4xl font-bold">{{ $totalTransactions }}</h2>
                    </div>

                    {{-- SALES --}}
                    <div class="bg-gradient-to-r from-purple-500 to-purple-700 p-8 rounded-3xl text-white">
                        <p>Total Penjualan</p>
                        <h2 class="text-2xl font-bold">
                            Rp {{ number_format($totalSales, 0, ',', '.') }}
                        </h2>
                    </div>

                    {{-- STOCK --}}
                    <div class="bg-gradient-to-r from-red-500 to-red-700 p-8 rounded-3xl text-white">
                        <p>Stock Menipis</p>
                        <h2 class="text-4xl font-bold">{{ $lowStocks }}</h2>
                    </div>

                </div>

            @endif

            {{-- SUPERVISOR --}}
            @if($role == 'supervisor')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    <div class="bg-white p-8 rounded-3xl shadow">
                        <p>Total Transaksi</p>
                        <h2 class="text-4xl font-bold">{{ $totalTransactions }}</h2>
                    </div>

                    <div class="bg-white p-8 rounded-3xl shadow">
                        <p>Total Penjualan</p>
                        <h2 class="text-3xl font-bold">
                            Rp {{ number_format($totalSales, 0, ',', '.') }}
                        </h2>
                    </div>

                </div>

            @endif

            {{-- WAREHOUSE --}}
            @if($role == 'warehouse')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    <div class="bg-white p-8 rounded-3xl shadow">
                        <p>Total Produk</p>
                        <h2 class="text-4xl font-bold">{{ $totalProducts }}</h2>
                    </div>

                    <div class="bg-white p-8 rounded-3xl shadow">
                        <p>Stock Menipis</p>
                        <h2 class="text-4xl font-bold text-red-500">{{ $lowStocks }}</h2>
                    </div>

                </div>

            @endif

            {{-- CASHIER --}}
            @if($role == 'cashier')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    <div class="bg-white p-8 rounded-3xl shadow">
                        <p>Total Transaksi</p>
                        <h2 class="text-4xl font-bold">{{ $totalTransactions }}</h2>
                    </div>

                    <div class="bg-white p-8 rounded-3xl shadow">
                        <p>Penjualan Hari Ini</p>
                        <h2 class="text-3xl font-bold">
                            Rp {{ number_format($todaySales, 0, ',', '.') }}
                        </h2>
                    </div>

                </div>

            @endif

        </div>

        {{-- ================= CHART & BEST SELLER ================= --}}

        @if(in_array($role, ['owner', 'manager', 'supervisor']))

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">

                {{-- CHART --}}
                <div class="xl:col-span-2 bg-white p-8 rounded-3xl shadow">

                    <h2 class="text-2xl font-bold mb-5">Sales Analytics</h2>

                    <div class="h-96 relative">
                        <canvas id="salesChart"></canvas>
                    </div>

                </div>

                {{-- BEST SELLER --}}
                <div class="bg-white p-8 rounded-3xl shadow">

                    <h2 class="text-2xl font-bold mb-5">Best Seller</h2>

                    <div class="space-y-4">

                        @foreach($bestProducts as $item)

                            <div class="p-4 bg-gray-100 rounded-2xl flex justify-between">
                                <div>
                                    <p class="font-bold">
                                        {{ $item->product->name ?? '-' }}
                                    </p>
                                </div>

                                <span class="bg-green-500 text-white px-3 py-1 rounded-xl">
                                    {{ $item->total_qty }}
                                </span>
                            </div>

                        @endforeach

                    </div>

                </div>

            </div>

        @endif

    </div>

    {{-- CHART --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const labels = @json($salesChart->pluck('date'));
    const data = @json($salesChart->pluck('total'));

    const ctx = document.getElementById('salesChart');

    if (ctx && labels.length) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Penjualan',
                    data: data,
                    borderWidth: 3,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }
</script>

</x-app-layout>