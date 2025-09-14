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
                    <b>Pengrajin:</b> {{ $namaPengrajin }}<br>
                    <b>Total Upah:</b> Rp. {{ number_format($inventoryReportData['data']['total_upah'], 0, ',', '.') }}
                </td>
            </tr>
        </table>
    </div>

    <table class="data-table" width="100%" cellspacing="0" cellpadding="5">
        <thead>
            <tr>
                <th>No</th>
                <th>TRX ID</th>
                <th>Nama Barang</th>
                <th>Tgl Ambil</th>
                <th>Jumlah Ambil</th>
                <th>Tgl Kembali</th>
                <th>Jumlah Kembali</th>
                <th>Upah</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($inventoryReportData['data']['transaksi'] as $i => $trx)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $trx['trx_id'] }}</td>
                <td>{{ $trx['nama_barang'] }}</td>
                <td>{{ \App\Helpers\IndoDateFormat::formatIndo($trx['tanggal_ambil']) }}</td>
                <td>{{ $trx['jumlah_ambil'] }}</td>
                <td>
                    @if($trx['tanggal_kembali'] === 'BELUM KEMBALI')
                    <span style="color:#fff; background-color:#dc3545; padding:2px 6px; border-radius:4px; font-size:12px;">
                        BELUM KEMBALI
                    </span>
                    @else
                    {{ \App\Helpers\IndoDateFormat::formatIndo($trx['tanggal_kembali']) }}
                    @endif
                </td>
                <td>{{ $trx['jumlah_kembali'] != 0 ? $trx['jumlah_kembali'] : '-' }}</td>
                <td>Rp. {{ number_format($trx['upah'], 0, ',', '.') }}</td>
                <td>
                    @if($trx['status'] === 'SELESAI')
                    <span style="color:#fff; background-color:#28a745; padding:2px 6px; border-radius:4px; font-size:12px;">
                        SELESAI
                    </span>
                    @else
                    {{ $trx['status'] }}
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="8" style="text-align:right; font-weight:bold;">Total Upah</td>
                <td style="font-weight:bold;">Rp. {{ number_format($inventoryReportData['data']['total_upah'], 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>


</body>

</html>