<x-app-layout>
    <div class="p-8 bg-zinc-50 min-h-screen">

        {{-- HEADER --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-zinc-800">
                Laporan
            </h1>
            <p class="text-zinc-500 mt-1">
                Monitoring laporan penjualan, transaksi, dan stock
            </p>
        </div>

        {{-- FILTER --}}
        <div class="bg-white rounded-2xl shadow-sm p-5 mb-8 border border-zinc-200">
            <form method="GET" class="flex gap-4 items-center flex-wrap">

                @if(auth()->user()->role == 'owner')
                    <select name="branch_id" class="rounded-xl border-zinc-300">
                        <option value="">Semua Cabang</option>

                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                @endif

                <select name="report_type" class="rounded-xl border-zinc-300">

                    @if(in_array(auth()->user()->role, ['owner', 'manager', 'supervisor']))
                        <option value="sales" {{ $reportType == 'sales' ? 'selected' : '' }}>
                            Laporan Penjualan
                        </option>
                    @endif

                    @if(in_array(auth()->user()->role, ['owner', 'manager', 'supervisor', 'cashier']))
                        <option value="transaction" {{ $reportType == 'transaction' ? 'selected' : '' }}>
                            Laporan Transaksi
                        </option>
                    @endif

                    @if(in_array(auth()->user()->role, ['owner', 'manager', 'warehouse']))
                        <option value="stock" {{ $reportType == 'stock' ? 'selected' : '' }}>
                            Laporan Stock
                        </option>
                    @endif

                </select>

                <button class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2 rounded-xl">
                    Filter
                </button>

                <a href="{{ route('reports.download.pdf', [
    'branch_id' => request('branch_id'),
    'report_type' => request('report_type')
]) }}" class="bg-red-500 text-white px-4 py-2 rounded-xl">
                    Download PDF
                </a>
            </form>
        </div>

        {{-- SALES --}}
@if(
    in_array(auth()->user()->role, ['owner', 'manager', 'supervisor']) &&
    $reportType == 'sales'
)

            <div class="grid md:grid-cols-3 gap-6 mb-8">

                <div class="bg-white rounded-2xl p-6 shadow border border-zinc-100">
                    <p class="text-zinc-500 text-sm">Total Penjualan</p>
                    <h2 class="text-3xl font-bold mt-2 text-zinc-800">
                        Rp {{ number_format($totalSales, 0, ',', '.') }}
                    </h2>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow border border-zinc-100">
                    <p class="text-zinc-500 text-sm">Total Transaksi</p>
                    <h2 class="text-3xl font-bold mt-2 text-zinc-800">
                        {{ $totalTransactions }}
                    </h2>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow border border-zinc-100">
                    <p class="text-zinc-500 text-sm">Rata-rata Transaksi</p>
                    <h2 class="text-3xl font-bold mt-2 text-zinc-800">
                        Rp {{ number_format($avgTransaction, 0, ',', '.') }}
                    </h2>
                </div>

            </div>

        @endif

        {{-- TRANSACTION --}}
@if(
    in_array(auth()->user()->role, ['owner', 'manager', 'supervisor', 'cashier']) &&
    $reportType == 'transaction'
)

            <div class="bg-white rounded-2xl shadow overflow-hidden">
                <div class="p-5 border-b">
                    <h2 class="font-semibold text-lg">Riwayat Transaksi</h2>
                </div>

                <table class="w-full">
                    <thead class="bg-zinc-100">
                        <tr>
                            <th class="p-4 text-left">Invoice</th>
                            <th class="p-4 text-left">Kasir</th>
                            <th class="p-4 text-left">Total</th>
                            <th class="p-4 text-left">Tanggal</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($transactions as $trx)
                            <tr class="border-t hover:bg-zinc-50">
                                <td class="p-4">{{ $trx->invoice }}</td>
                                <td class="p-4">{{ $trx->user->name ?? '-' }}</td>
                                <td class="p-4">
                                    Rp {{ number_format($trx->total, 0, ',', '.') }}
                                </td>
                                <td class="p-4">
                                    {{ $trx->created_at->format('d M Y H:i') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        @endif

        {{-- STOCK --}}
@if(
    in_array(auth()->user()->role, ['owner', 'manager', 'warehouse']) &&
    $reportType == 'stock'
)

            <div class="grid md:grid-cols-2 gap-6 mb-8">

                <div class="bg-white rounded-2xl p-6 shadow">
                    <p class="text-zinc-500 text-sm">Total Produk</p>
                    <h2 class="text-3xl font-bold mt-2">
                        {{ $totalProducts }}
                    </h2>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow">
                    <p class="text-zinc-500 text-sm">Stock Menipis</p>
                    <h2 class="text-3xl font-bold mt-2 text-red-500">
                        {{ $lowStock }}
                    </h2>
                </div>

            </div>

            <div class="bg-white rounded-2xl shadow overflow-hidden">
                <div class="p-5 border-b">
                    <h2 class="font-semibold text-lg">Riwayat Pergerakan Stock</h2>
                </div>

                <table class="w-full">
                    <thead class="bg-zinc-100">
                        <tr>
                            <th class="p-4 text-left">Produk</th>
                            <th class="p-4 text-left">Type</th>
                            <th class="p-4 text-left">Qty</th>
                            <th class="p-4 text-left">User</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($stockMovements as $stock)
                            <tr class="border-t hover:bg-zinc-50">
                                <td class="p-4">{{ $stock->product->name ?? '-' }}</td>
                                <td class="p-4">
                                    @if($stock->type == 'in')
                                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">
                                            Masuk
                                        </span>
                                    @else
                                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full">
                                            Keluar
                                        </span>
                                    @endif
                                </td>
                                <td class="p-4">{{ $stock->qty }}</td>
                                <td class="p-4">{{ $stock->user->name ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        @endif

    </div>
</x-app-layout>