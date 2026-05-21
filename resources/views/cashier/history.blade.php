<x-app-layout>

<div class="p-8">

    <div class="flex justify-between items-center mb-8">

        <div>

            <h1 class="text-3xl font-bold">
                Riwayat Transaksi
            </h1>

            <p class="text-gray-500">
                Semua transaksi minimarket
            </p>

        </div>

    </div>

    <div class="bg-white rounded-2xl shadow overflow-hidden">

        <table class="w-full">

            <thead class="bg-gray-100">

                <tr>

                    <th class="p-4 text-left">Invoice</th>
                    <th class="p-4 text-left">Kasir</th>
                    <th class="p-4 text-left">Total</th>
                    <th class="p-4 text-left">Tanggal</th>
                    <th class="p-4 text-left">Aksi</th>

                </tr>

            </thead>

            <tbody>

                @foreach($transactions as $trx)

                <tr class="border-t">

                    <td class="p-4">
                        {{ $trx->invoice }}
                    </td>

                    <td class="p-4">
                        {{ $trx->user->name ?? '-' }}
                    </td>

                    <td class="p-4">

                        Rp {{ number_format($trx->total,0,',','.') }}

                    </td>

                    <td class="p-4">

                        {{ $trx->created_at->format('d M Y H:i') }}

                    </td>

                    <td class="p-4">

                        <a
                            href="{{ route('transactions.show', $trx->id) }}"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">

                            Detail

                        </a>

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

    <div class="mt-5">

        {{ $transactions->links() }}

    </div>

</div>

</x-app-layout>