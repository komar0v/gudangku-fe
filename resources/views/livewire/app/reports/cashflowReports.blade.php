<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Inventory Bulanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            color: #000;
        }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table.data-table th,
        table.data-table td {
            border: 1px solid #000;
            padding: 8px;
            font-size: 14px;
            text-align: left;
        }

        table.data-table th {
            background-color: #f2f2f2;
        }

        .header {
            margin-bottom: 10px;
        }

        .header-table,
        .info-table {
            width: 100%;
            border-collapse: collapse;
            border: none;
            margin: 0 0 8px 0;
        }

        .header-table td,
        .info-table td {
            border: none !important;
            padding: 0;
            vertical-align: middle;
        }

        .header .title h1,
        .header .title h2,
        .header .title p {
            text-align: left;
            margin: 0;
        }

        .header .title h1 {
            font-size: 22px;
            font-weight: bold;
        }

        .header .title h2 {
            font-size: 16px;
            margin-top: 6px;
        }

        .header .title p {
            font-size: 12px;
            margin-top: 4px;
        }

        .info-table td.left {
            text-align: left;
            vertical-align: top;
            padding-right: 10px;
        }

        .info-table td.right {
            text-align: right;
            vertical-align: top;
        }

        .footer {
            margin-top: 50px;
            text-align: right;
        }

        @media print {
            body {
                margin: 0;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="header">
        <table class="header-table" width="100%" border="0" cellspacing="0" cellpadding="0" style="border:none;">
            <tr>
                <td width="110" style="text-align:left; vertical-align:middle; border:none;">
                    <img src="{{ public_path('app_assets/img/empingmerapi.png') }}" width="100" height="100" alt="Logo">
                </td>
                <td style="text-align:left; vertical-align:middle; border:none;">
                    <div class="title">
                        <h1>Emping Merapi</h1>
                        <h2>{{$subject}}</h2>
                        <p>Periode: {{ $periode }}</p>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="info">
        <table class="info-table" width="100%" border="0" cellspacing="0" cellpadding="0" style="border:none;">
            <tr>
                <td class="left" style="border:none;">
                    <strong>Dicetak pada:</strong> {{ $printedOn }}<br>
                    <strong>Disiapkan oleh:</strong> {{ $namaAdmin }}
                </td>
                <td class="right" style="border:none;">
                    <strong>Total Pengeluaran: </strong>Rp. {{ number_format($cashflowHistory['total_out'], 0, ',', '.') }}<br>
                    <strong>Total Pemasukan: </strong>Rp. {{ number_format($cashflowHistory['total_in'], 0, ',', '.') }}
                </td>
            </tr>
        </table>
    </div>

    <table class="data-table" width="100%" cellspacing="0" cellpadding="5">
        <thead>
            <tr>
                <th>No</th>
                <th>TRX ID</th>
                <th>Tipe</th>
                <th>Kategori</th>
                <th>Deskripsi</th>
                <th>Nominal</th>
                <th>Tanggal</th>
                <th>Creator</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cashflowHistory['cashflows'] as $i => $trx)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ explode('-', $trx['id'])[1] }}</td>
                <td>
                    @if($trx['type'] === 'in')
                    <span class="badge" style="background-color:#4154F1; color:white;">Masuk</span>
                    @else
                    <span class="badge" style="background-color:#2ECA6A;">Keluar</span>
                    @endif
                </td>
                <td>{{ $trx['category'] }}</td>
                <td>{{ $trx['description'] }}</td>
                <td>Rp {{ number_format($trx['amount'], 0, ',', '.') }}</td>
                <td>{{ \App\Helpers\IndoDateFormat::formatTanggalIndo($trx['transaction_date']) }}</td>
                <td>{{ $trx['creator'] ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>