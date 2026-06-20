<x-app-layout>

    <div class="p-8">

        <div class="flex justify-between items-center mb-8">

            <div>

                <h1 class="text-3xl font-bold">
                    Monitoring Stock
                </h1>

                <p class="text-gray-500">
                    Stock realtime dan riwayat pergerakan barang
                </p>

            </div>

            @if(in_array(auth()->user()->role, ['manager', 'warehouse']))

                <a href="{{ route('stocks.create') }}"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-xl">

                    + Tambah Stock

                </a>

            @endif

        </div>

        {{-- FILTER CABANG OWNER --}}
        @if(auth()->user()->role == 'owner')

            <div class="mb-6">

                <form method="GET">

                    <select name="branch_id" onchange="this.form.submit()" class="border rounded-xl px-4 py-2">

                        <option value="">
                            Semua Cabang
                        </option>

                        @foreach($branches as $branch)

                            <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>

                                {{ $branch->name }}

                            </option>

                        @endforeach

                    </select>

                </form>

            </div>

        @endif
        <div class="grid grid-cols-4 gap-4 mb-6">

            <div class="bg-blue-100 p-4 rounded-xl">
                <h2 class="text-sm text-gray-500">
                    Total Produk
                </h2>
                <p class="text-2xl font-bold">
                    {{ $products->count() }}
                </p>
            </div>

            <div class="bg-green-100 p-4 rounded-xl">
                <h2 class="text-sm text-gray-500">
                    Total Stock
                </h2>
                <p class="text-2xl font-bold">
                    {{ $products->sum('stock') }}
                </p>
            </div>

            <div class="bg-yellow-100 p-4 rounded-xl">
                <h2 class="text-sm text-gray-500">
                    Stock Menipis
                </h2>
                <p class="text-2xl font-bold">
                    {{ $products->where('stock', '<=', 10)->count() }}
                </p>
            </div>

            <div class="bg-red-100 p-4 rounded-xl">
                <h2 class="text-sm text-gray-500">
                    Habis
                </h2>
                <p class="text-2xl font-bold">
                    {{ $products->where('stock', 0)->count() }}
                </p>
            </div>

        </div>
        {{-- STOCK REALTIME --}}
        <div class="bg-white rounded-2xl shadow mb-8 overflow-hidden">

            <div class="p-5 border-b">

                <h2 class="font-bold text-lg">
                    Stock Saat Ini
                </h2>

            </div>

            <table class="w-full">

                <thead class="bg-gray-100">

                    <tr>

                        <th class="p-4 text-left">Produk</th>

                        <th class="p-4 text-left">Barcode</th>

                        @if(auth()->user()->role == 'owner')
                            <th class="p-4 text-left">Cabang</th>
                        @endif

                        <th class="p-4 text-left">Stock</th>

                        <th class="p-4 text-left">Harga</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($products as $product)

                        <tr class="border-b">

                            <td class="p-4">
                                {{ $product->name }}
                            </td>

                            <td class="p-4">
                                {{ $product->barcode }}
                            </td>

                            @if(auth()->user()->role == 'owner')

                                <td class="p-4">

                                    {{ $product->branch->name ?? '-' }}

                                </td>

                            @endif

                            <td class="p-4">

                                @if($product->stock <= 5)

                                    <span class="font-bold text-red-600">

                                        {{ $product->stock }}

                                    </span>

                                @elseif($product->stock <= 20)

                                    <span class="font-bold text-yellow-600">

                                        {{ $product->stock }}

                                    </span>

                                @else

                                    <span class="font-bold text-green-600">

                                        {{ $product->stock }}

                                    </span>

                                @endif

                            </td>

                            <td class="p-4">

                                Rp {{ number_format($product->price, 0, ',', '.') }}

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5" class="p-5 text-center text-gray-500">

                                Tidak ada data stock

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- RIWAYAT STOCK --}}
        <div class="bg-white rounded-2xl shadow overflow-hidden">

            <div class="p-5 border-b">

                <h2 class="font-bold text-lg">
                    Riwayat Pergerakan Stock
                </h2>

            </div>

            <table class="w-full">

                <thead class="bg-gray-100">

                    <tr>

                        <th class="p-4 text-left">Produk</th>

                        @if(auth()->user()->role == 'owner')
                            <th class="p-4 text-left">Cabang</th>
                        @endif

                        <th class="p-4 text-left">Type</th>

                        <th class="p-4 text-left">Qty</th>

                        <th class="p-4 text-left">User</th>

                        <th class="p-4 text-left">Tanggal</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($stocks as $stock)

                        <tr class="border-b">

                            <td class="p-4">

                                {{ $stock->product->name ?? '-' }}

                            </td>

                            @if(auth()->user()->role == 'owner')

                                <td class="p-4">

                                    {{ $stock->product->branch->name ?? '-' }}

                                </td>

                            @endif

                            <td class="p-4">

                                @if($stock->type == 'in')

                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">

                                        STOCK MASUK

                                    </span>

                                @else

                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full">

                                        STOCK KELUAR

                                    </span>

                                @endif

                            </td>

                            <td class="p-4">

                                {{ $stock->qty }}

                            </td>

                            <td class="p-4">

                                {{ $stock->user->name ?? '-' }}

                            </td>

                            <td class="p-4">

                                {{ $stock->created_at->format('d M Y H:i') }}

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6" class="p-5 text-center text-gray-500">

                                Belum ada riwayat stock

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="mt-5">

            {{ $stocks->links() }}

        </div>

    </div>

</x-app-layout>