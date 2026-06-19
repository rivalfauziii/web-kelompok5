<x-app-layout>

    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 p-8">

        <!-- TOP HEADER -->
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

                <p class="text-gray-500 text-sm">

                    Today

                </p>

                <h2 class="font-bold text-xl">

                    {{ now()->format('d M Y') }}

                </h2>

            </div>

        </div>
        <div class="mb-5 flex items-center gap-3">

            <span class="bg-blue-100 text-blue-700 px-4 py-2 rounded-full font-semibold">
                {{ strtoupper(auth()->user()->role) }}
            </span>

            @if(auth()->user()->branch)

                <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full font-semibold">
                    {{ auth()->user()->branch->name }}
                </span>

            @endif

        </div>
        <!-- CARD -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-8 mb-10">

            <!-- CARD -->
            <div
                class="bg-gradient-to-r from-blue-500 to-blue-700 p-8 rounded-3xl shadow-xl text-white relative overflow-hidden">

                <div class="absolute right-5 top-5 text-7xl opacity-10">

                    📦

                </div>

                <p class="text-blue-100 text-lg">

                    Total Produk

                </p>

                <h2 class="text-5xl font-black mt-4">

                    {{ $totalProducts }}

                </h2>

            </div>

            <!-- CARD -->
            <div
                class="bg-gradient-to-r from-green-500 to-green-700 p-8 rounded-3xl shadow-xl text-white relative overflow-hidden">

                <div class="absolute right-5 top-5 text-7xl opacity-10">

                    🛒

                </div>

                <p class="text-green-100 text-lg">

                    Total Transaksi

                </p>

                <h2 class="text-5xl font-black mt-4">

                    {{ $totalTransactions }}

                </h2>

            </div>

            <!-- CARD -->
            <div
                class="bg-gradient-to-r from-purple-500 to-purple-700 p-8 rounded-3xl shadow-xl text-white relative overflow-hidden">

                <div class="absolute right-5 top-5 text-7xl opacity-10">

                    💰

                </div>

                <p class="text-purple-100 text-lg">

                    Total Penjualan

                </p>

                <h2 class="text-3xl font-black mt-4">

                    Rp {{ number_format($totalSales, 0, ',', '.') }}

                </h2>

            </div>

            <!-- CARD -->
            <div
                class="bg-gradient-to-r from-red-500 to-red-700 p-8 rounded-3xl shadow-xl text-white relative overflow-hidden">

                <div class="absolute right-5 top-5 text-7xl opacity-10">

                    ⚠️

                </div>

                <p class="text-red-100 text-lg">

                    Stock Menipis

                </p>

                <h2 class="text-5xl font-black mt-4">

                    {{ $lowStocks }}

                </h2>

            </div>

        </div>

        <!-- CONTENT -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">

            <!-- CHART -->
            <div class="xl:col-span-2 bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-8">

                <div class="flex justify-between items-center mb-8">

                    <div>

                        <h2 class="text-3xl font-bold text-gray-800 dark:text-white">

                            Sales Analytics

                        </h2>

                        <p class="text-gray-500 mt-1">

                            Statistik penjualan 7 hari terakhir

                        </p>

                    </div>

                    <div class="bg-blue-100 text-blue-600 px-5 py-2 rounded-2xl font-bold">

                        Realtime

                    </div>

                </div>

                <div class="h-96">

                    <canvas id="salesChart"></canvas>

                </div>

            </div>

            <!-- BEST PRODUCT -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-8">

                <div class="flex justify-between items-center mb-8">

                    <div>

                        <h2 class="text-3xl font-bold text-gray-800 dark:text-white">

                            Best Seller

                        </h2>

                        <p class="text-gray-500 mt-1">

                            Produk terlaris

                        </p>

                    </div>

                    <div class="text-4xl">
                        🔥
                    </div>

                </div>

                <div class="space-y-5">

                    @foreach($bestProducts as $item)

                        <div class="bg-gray-100 dark:bg-gray-700 p-5 rounded-2xl">

                            <div class="flex justify-between items-center">

                                <div>

                                    <h2 class="font-bold text-lg text-gray-800 dark:text-white">

                                        {{ $item->product->name ?? '-' }}

                                    </h2>

                                    <p class="text-gray-500 text-sm">

                                        Total Terjual

                                    </p>

                                </div>

                                <div class="bg-green-500 text-white px-4 py-2 rounded-xl font-bold">

                                    {{ $item->total_qty }}

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>

        const ctx = document.getElementById('salesChart');

        new Chart(ctx, {

            type: 'line',

            data: {

                labels: [
                    @foreach($salesChart as $chart)
                        '{{ $chart->date }}',
                    @endforeach
        ],

                datasets: [{

                    label: 'Penjualan',

                    data: [
                        @foreach($salesChart as $chart)
                            {{ $chart->total }},
                        @endforeach
            ],

                    borderWidth: 4,
                    tension: 0.4,
                    fill: true

                }]
            },

            options: {

                maintainAspectRatio: false

            }

        });

    </script>

</x-app-layout>