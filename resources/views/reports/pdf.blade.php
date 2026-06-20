<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan SyakaMarket</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #222;
            margin: 30px;
        }

        h1,
        h2 {
            margin: 0;
        }

        .header {
            margin-bottom: 30px;
            border-bottom: 2px solid #ddd;
            padding-bottom: 15px;
        }

        .header p {
            margin: 5px 0;
            color: #666;
        }

        .section-title {
            font-size: 18px;
            margin: 30px 0 15px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 8px;
        }

        .summary-box {
            border: 1px solid #ddd;
            padding: 12px;
            margin-bottom: 12px;
            border-radius: 6px;
        }

        .label {
            color: #666;
            font-size: 11px;
        }

        .value {
            font-size: 18px;
            font-weight: bold;
            margin-top: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f3f4f6;
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        td {
            padding: 10px;
            border: 1px solid #ddd;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>SYAKAMARKET REPORT</h1>

        <p>Tanggal: {{ now()->format('d M Y H:i') }}</p>
        <p>Cabang: {{ $branchName }}</p>
        <p>Jenis Laporan: {{ strtoupper($reportType) }}</p>
    </div>

    {{-- SALES --}}
    @if($reportType == 'sales')

        <div class="section-title">Ringkasan Penjualan</div>

        <div class="summary-box">
            <div class="label">Total Penjualan</div>
            <div class="value">
                Rp {{ number_format($totalSales, 0, ',', '.') }}
            </div>
        </div>

        <div class="summary-box">
            <div class="label">Total Transaksi</div>
            <div class="value">
                {{ $totalTransactions }}
            </div>
        </div>

        <div class="summary-box">
            <div class="label">Total Produk</div>
            <div class="value">
                {{ $totalProducts }}
            </div>
        </div>

        <div class="summary-box">
            <div class="label">Stock Menipis</div>
            <div class="value">
                {{ $lowStock }}
            </div>
        </div>

    @endif

    {{-- TRANSACTIONS --}}
    @if($reportType == 'transactions')

        <div class="section-title">Riwayat Transaksi</div>

        <table>
            <thead>
                <tr>
                    <th>Invoice</th>
                    <th>Kasir</th>
                    <th>Total</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $trx)
                    <tr>
                        <td>{{ $trx->invoice }}</td>
                        <td>{{ $trx->user->name ?? '-' }}</td>
                        <td>Rp {{ number_format($trx->total, 0, ',', '.') }}</td>
                        <td>{{ $trx->created_at->format('d M Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">Belum ada transaksi</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    @endif

    {{-- STOCK --}}
    @if($reportType == 'stocks')

        <div class="section-title">Riwayat Stock</div>

        <table>
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Type</th>
                    <th>Qty</th>
                    <th>User</th>
                </tr>
            </thead>
            <tbody>
                @forelse($stockMovements as $stock)
                    <tr>
                        <td>{{ $stock->product->name ?? '-' }}</td>
                        <td>{{ strtoupper($stock->type) }}</td>
                        <td>{{ $stock->qty }}</td>
                        <td>{{ $stock->user->name ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">Belum ada pergerakan stock</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    @endif

</body>

</html>