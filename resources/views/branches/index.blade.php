<x-app-layout>

    <div class="p-8">

        <div class="flex justify-between items-center mb-6">

            <h1 class="text-3xl font-bold">

                Data Cabang

            </h1>

            <a href="{{ route('branches.create') }}" class="bg-blue-500 text-white px-5 py-3 rounded-xl">

                + Tambah Cabang

            </a>

        </div>

        <div class="bg-white rounded-2xl shadow p-6">

            <table class="w-full">

                <thead>

                    <tr class="border-b">

                        <th class="text-left py-3">Nama</th>
                        <th class="text-left py-3">Alamat</th>
                        <th class="text-left py-3">Kota</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($branches as $branch)

                        <tr class="border-b">

                            <td class="py-3">

                                {{ $branch->name }}

                            </td>

                            <td class="py-3">

                                {{ $branch->address }}

                            </td>

                            <td class="py-3">

                                {{ $branch->city }}

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</x-app-layout>