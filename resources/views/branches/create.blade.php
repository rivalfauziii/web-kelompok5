<x-app-layout>

<div class="p-8 max-w-2xl">

    <h1 class="text-3xl font-bold mb-6">

        Tambah Cabang

    </h1>

    <div class="bg-white rounded-2xl shadow p-6">

        <form action="{{ route('branches.store') }}" method="POST">

            @csrf

            <div class="mb-5">

                <label class="block mb-2 font-semibold">

                    Nama Cabang

                </label>

                <input type="text"
                       name="name"
                       class="w-full border rounded-xl p-3">

            </div>

            <div class="mb-5">

                <label class="block mb-2 font-semibold">

                    Alamat

                </label>

                <textarea name="address"
                          class="w-full border rounded-xl p-3"></textarea>

            </div>

                        <div class="mb-5">

                <label class="block mb-2 font-semibold">

                    Kota
                    
                </label>

                <textarea name="address"
                          class="w-full border rounded-xl p-3"></textarea>

            </div>

            <button
                class="bg-blue-500 text-white px-6 py-3 rounded-xl">

                Simpan

            </button>

        </form>

    </div>

</div>

</x-app-layout>