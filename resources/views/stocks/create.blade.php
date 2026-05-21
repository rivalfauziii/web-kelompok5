<x-app-layout>

<div class="max-w-3xl mx-auto p-8">

    <div class="bg-white rounded-2xl shadow p-8">

        <h1 class="text-3xl font-bold mb-6">

            Tambah Stock

        </h1>

        <form
            action="{{ route('stocks.store') }}"
            method="POST">

            @csrf

            <div class="mb-5">

                <label class="block mb-2">

                    Produk

                </label>

                <select
                    name="product_id"
                    class="w-full rounded-xl border-gray-300">

                    @foreach($products as $product)

                        <option value="{{ $product->id }}">

                            {{ $product->name }}

                        </option>

                    @endforeach

                </select>

            </div>

            <div class="mb-5">

                <label class="block mb-2">

                    Type

                </label>

                <select
                    name="type"
                    class="w-full rounded-xl border-gray-300">

                    <option value="in">

                        Stock Masuk

                    </option>

                    <option value="out">

                        Stock Keluar

                    </option>

                </select>

            </div>

            <div class="mb-5">

                <label class="block mb-2">

                    Qty

                </label>

                <input
                    type="number"
                    name="qty"
                    class="w-full rounded-xl border-gray-300">

            </div>

            <div class="mb-6">

                <label class="block mb-2">

                    Keterangan

                </label>

                <textarea
                    name="description"
                    class="w-full rounded-xl border-gray-300"></textarea>

            </div>

            <button
                class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-3 rounded-xl">

                Simpan Stock

            </button>

        </form>

    </div>

</div>

</x-app-layout>