<x-app-layout>

<div class="p-8">

    <div class="flex justify-between items-center mb-8">

        <div>

            <h1 class="text-3xl font-bold">
                Riwayat Stock
            </h1>

            <p class="text-gray-500">
                Semua pergerakan stok barang
            </p>

        </div>

        <a
            href="{{ route('stocks.create') }}"
            class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-3 rounded-xl">

            + Tambah Stock

        </a>

    </div>

    @if(session('success'))

        <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-5">

            {{ session('success') }}

        </div>

    @endif

    <div class="bg-white rounded-2xl shadow overflow-hidden">

        <table class="w-full">

            <thead class="bg-gray-100">

                <tr>

                    <th class="p-4 text-left">Produk</th>
                    <th class="p-4 text-left">Type</th>
                    <th class="p-4 text-left">Qty</th>
                    <th class="p-4 text-left">Keterangan</th>
                    <th class="p-4 text-left">User</th>
                    <th class="p-4 text-left">Tanggal</th>

                </tr>

            </thead>

            <tbody>

                @foreach($stocks as $stock)

                <tr class="border-t">

                    <td class="p-4">

                        {{ $stock->product->name ?? '-' }}

                    </td>

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

                        {{ $stock->description }}

                    </td>

                    <td class="p-4">

                        {{ $stock->user->name ?? '-' }}

                    </td>

                    <td class="p-4">

                        {{ $stock->created_at->format('d M Y H:i') }}

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

    <div class="mt-5">

        {{ $stocks->links() }}

    </div>

</div>

</x-app-layout>