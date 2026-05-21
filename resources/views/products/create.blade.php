<x-app-layout>

<div class="max-w-3xl mx-auto p-8">

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-8">

        <h1 class="text-3xl font-bold mb-6 text-gray-800 dark:text-white">

            Tambah Produk

        </h1>

        <form
            action="{{ route('products.store') }}"
            method="POST"
            enctype="multipart/form-data">

            @csrf

            <div class="mb-5">

                <label class="block mb-2 text-gray-700 dark:text-white">

                    Nama Produk

                </label>

                <input
                    type="text"
                    name="name"
                    class="w-full rounded-xl border-gray-300">

            </div>

            <div class="mb-5">

                <label class="block mb-2 text-gray-700 dark:text-white">

                    Barcode

                </label>

                <input
                    type="text"
                    name="barcode"
                    class="w-full rounded-xl border-gray-300">

            </div>

            <div class="mb-5">

                <label class="block mb-2 text-gray-700 dark:text-white">

                    Stock

                </label>

                <input
                    type="number"
                    name="stock"
                    class="w-full rounded-xl border-gray-300">

            </div>

            <div class="mb-5">

                <label class="block mb-2 text-gray-700 dark:text-white">

                    Harga

                </label>

                <input
                    type="number"
                    name="price"
                    class="w-full rounded-xl border-gray-300">

            </div>

            <div class="mb-6">

                <label class="block mb-2 text-gray-700 dark:text-white">

                    Gambar

                </label>

                <input
                    type="file"
                    name="image"
                    class="w-full rounded-xl border-gray-300">

            </div>

            <button
                class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-3 rounded-xl">

                Simpan Produk

            </button>

        </form>

    </div>

</div>

</x-app-layout>