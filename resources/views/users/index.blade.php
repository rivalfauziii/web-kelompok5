<x-app-layout>

    <div class="p-8">

        <div class="flex justify-between items-center mb-8">

            <div>

                <h1 class="text-3xl font-bold">

                    Kelola User

                </h1>

                <p class="text-gray-500">

                    Manajemen pengguna aplikasi

                </p>

            </div>

            <a href="{{ route('users.create') }}" class="bg-emerald-600 text-white px-5 py-3 rounded-xl">

                + Tambah User

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

                        <th class="p-4 text-left">Nama</th>
                        <th class="p-4 text-left">Email</th>
                        <th class="p-4 text-left">Role</th>
                        <th class="p-4 text-left">Cabang</th>
                        <th class="p-4 text-left">Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($users as $user)

                        <tr class="border-t">

                            <td class="p-4">

                                {{ $user->name }}

                            </td>

                            <td class="p-4">

                                {{ $user->email }}

                            </td>

                            <td class="p-4">

                                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full">

                                    {{ $user->role }}

                                </span>

                            </td>

                            <td class="p-4">

                                {{ $user->branch->name ?? '-' }}

                            </td>

                            <td class="p-4 flex gap-2">

                                <a href="{{ route('users.edit', $user->id) }}"
                                    class="bg-yellow-400 text-white px-4 py-2 rounded-lg">

                                    Edit

                                </a>

                                <form action="{{ route('users.destroy', $user->id) }}" method="POST">

                                    @csrf
                                    @method('DELETE')

                                    <button class="bg-red-500 text-white px-4 py-2 rounded-lg">

                                        Hapus

                                    </button>

                                </form>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</x-app-layout>