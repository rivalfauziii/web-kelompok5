<x-app-layout>

<div class="max-w-4xl mx-auto p-8">

    <div class="bg-white rounded-2xl shadow p-8">

        <div class="flex justify-between mb-8">

            <div>

                <h1 class="text-3xl font-bold">
                    Detail Transaksi
                </h1>

                <p class="text-gray-500">

                    {{ $transaction->invoice }}

                </p>

            </div>

            <button
                onclick="window.print()"
                class="bg-green-500 hover:bg-green-600 text-white px-5 py-3 rounded-xl">

                Print

            </button>

        </div>

        <table class="w-full">

            <thead class="bg-gray-100">

                <tr>

                    <th class="p-4 text-left">Produk</th>
                    <th class="p-4 text-left">Qty</th>
                    <th class="p-4 text-left">Harga</th>
                    <th class="p-4 text-left">Subtotal</th>

                </tr>

            </thead>

            <tbody>

                @foreach($transaction->details as $detail)

                <tr class="border-t">

                    <td class="p-4">

                        {{ $detail->product->name }}

                    </td>

                    <td class="p-4">

                        {{ $detail->qty }}

                    </td>

                    <td class="p-4">

                        Rp {{ number_format($detail->price,0,',','.') }}

                    </td>

                    <td class="p-4">

                        Rp {{ number_format($detail->subtotal,0,',','.') }}

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

        <div class="mt-8 text-right">

            <h2 class="text-2xl font-bold">

                Total:
                Rp {{ number_format($transaction->total,0,',','.') }}

            </h2>

        </div>

    </div>

</div>

</x-app-layout>