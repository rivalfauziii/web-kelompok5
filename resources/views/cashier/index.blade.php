<x-app-layout>

<div class="p-8">

    <h1 class="text-3xl font-bold mb-8">
        Kasir Minimarket
    </h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- PRODUK -->
        <div class="lg:col-span-2">

            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">

                @foreach($products as $product)

                <div
                    onclick="addToCart(
                        {{ $product->id }},
                        '{{ $product->name }}',
                        {{ $product->price }}
                    )"
                    class="bg-white rounded-2xl shadow p-4 cursor-pointer hover:scale-105 transition">

                    @if($product->image)

                        <img
                            src="{{ asset('storage/'.$product->image) }}"
                            class="w-full h-40 object-cover rounded-xl mb-4">

                    @endif

                    <h2 class="font-bold">
                        {{ $product->name }}
                    </h2>

                    <p class="text-green-500 font-bold mt-2">

                        Rp {{ number_format($product->price,0,',','.') }}

                    </p>

                    <p class="text-sm text-gray-500">

                        Stock: {{ $product->stock }}

                    </p>

                </div>

                @endforeach

            </div>

        </div>

        <!-- KERANJANG -->
        <div>

            <div class="bg-white rounded-2xl shadow p-6 sticky top-5">

                <h2 class="text-2xl font-bold mb-5">
                    Keranjang
                </h2>

                <div id="cart-list">

                </div>

                <div class="border-t mt-5 pt-5">

                    <h3 class="text-xl font-bold">

                        Total:
                        Rp <span id="total">0</span>

                    </h3>

                    <button
                        onclick="checkout()"
                        class="w-full mt-5 bg-blue-500 hover:bg-blue-600 text-white py-3 rounded-xl">

                        Checkout

                    </button>

                </div>

            </div>

        </div>

    </div>

</div>

<script>

let cart = [];

function addToCart(id, name, price)
{
    let found = cart.find(item => item.id === id);

    if(found){

        found.qty++;

    } else {

        cart.push({
            id: id,
            name: name,
            price: price,
            qty: 1
        });
    }

    renderCart();
}

function renderCart()
{
    let html = '';

    let total = 0;

    cart.forEach(item => {

        total += item.price * item.qty;

        html += `
            <div class="flex justify-between mb-4 border-b pb-2">

                <div>

                    <h4 class="font-bold">${item.name}</h4>

                    <p class="text-sm text-gray-500">
                        ${item.qty} x Rp ${item.price}
                    </p>

                </div>

                <div class="font-bold">

                    Rp ${item.price * item.qty}

                </div>

            </div>
        `;
    });

    document.getElementById('cart-list').innerHTML = html;

    document.getElementById('total').innerHTML =
        total.toLocaleString('id-ID');
}

function checkout()
{
    if(cart.length < 1){

        alert('Keranjang masih kosong');

        return;
    }

    fetch('/cashier/checkout', {

        method: 'POST',

        headers: {

            'Content-Type': 'application/json',

            'Accept': 'application/json',

            'X-CSRF-TOKEN': '{{ csrf_token() }}'

        },

        body: JSON.stringify({

            products: cart

        })

    })
    .then(async response => {

        let data = await response.json();

        if(!response.ok){

            throw data;
        }

        return data;
    })
    .then(data => {

        alert(data.message || 'Transaksi berhasil');

        cart = [];

        renderCart();

        location.reload();

    })
    .catch(error => {

        console.log(error);

        alert(
            error.message ||
            'Checkout gagal'
        );
    });
}

</script>

</x-app-layout>