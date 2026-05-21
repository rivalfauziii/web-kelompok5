<x-app-layout>

<div class="p-8">

    <div class="flex justify-between items-center mb-6">

        <div>

            <h1 class="text-3xl font-bold text-gray-800 dark:text-white">
                Data Produk
            </h1>

            <p class="text-gray-500">
                Semua produk minimarket
            </p>

        </div>

        <a href="{{ route('products.create') }}"
            class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-3 rounded-xl shadow">

            + Tambah Produk

        </a>

    </div>

    @if(session('success'))

        <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-5">

            {{ session('success') }}

        </div>

    @endif

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow overflow-hidden">

        <table class="w-full">

            <thead class="bg-gray-100 dark:bg-gray-700">

                <tr>

                    <th class="p-4 text-left">Gambar</th>
                    <th class="p-4 text-left">Nama</th>
                    <th class="p-4 text-left">Barcode</th>
                    <th class="p-4 text-left">Stock</th>
                    <th class="p-4 text-left">Harga</th>
                    <th class="p-4 text-left">Aksi</th>

                </tr>

            </thead>

            <tbody>

                @forelse($products as $product)

                <tr class="border-t dark:border-gray-700">

                    <td class="p-4">

                        @if($product->image)

                            <img
                                src="{{ asset('storage/'.$product->image) }}"
                                class="w-16 h-16 object-cover rounded-xl">

                        @else

                            <div class="w-16 h-16 bg-gray-200 rounded-xl"></div>

                        @endif

                    </td>

                    <td class="p-4 text-gray-800 dark:text-white">
                        {{ $product->name }}
                    </td>

                    <td class="p-4 text-gray-800 dark:text-white">
                        {{ $product->barcode }}
                    </td>

                    <td class="p-4 text-gray-800 dark:text-white">
                        {{ $product->stock }}
                    </td>

                    <td class="p-4 text-gray-800 dark:text-white">

                        Rp {{ number_format($product->price,0,',','.') }}

                    </td>

                    <td class="p-4 flex gap-2">

                        <a href="{{ route('products.edit', $product->id) }}"
                            class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-2 rounded-lg">

                            Edit

                        </a>

                        <form
                            action="{{ route('products.destroy', $product->id) }}"
                            method="POST">

                            @csrf
                            @method('DELETE')

                            <button
                                onclick="return confirm('Yakin hapus produk?')"
                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg">

                                Hapus

                            </button>

                        </form>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="6" class="text-center p-8 text-gray-500">

                        Belum ada produk

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <div class="mt-6">

        {{ $products->links() }}

    </div>

</div>

</x-app-layout>