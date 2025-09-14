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

        .header { margin-bottom: 10px; }
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
        .header .title h1 { font-size: 22px; font-weight: bold; }
        .header .title h2 { font-size: 16px; margin-top: 6px; }
        .header .title p  { font-size: 12px; margin-top: 4px; }

        .info-table td.left { text-align: left; vertical-align: top; padding-right: 10px; }
        .info-table td.right { text-align: right; vertical-align: top; }

        .footer { margin-top: 50px; text-align: right; }

        @media print {
            body { margin: 0; }
            .no-print { display: none; }
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
                    <b>Total Ambil:</b> {{ $inventoryReportData['grand_total_ambil'] }}<br>
                    <b>Total Kembali:</b> {{ $inventoryReportData['grand_total_kembali'] }}
                </td>
            </tr>
        </table>
    </div>

    <table class="data-table" width="100%" cellspacing="0" cellpadding="5">
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th>Total Ambil</th>
                <th>Total Kembali</th>
                <th>Log Transaksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inventoryReportData['items'] as $item)
            <tr>
                <td>{{ $item['nama_barang'] }}</td>
                <td>{{ $item['total_ambil'] }}</td>
                <td>{{ $item['total_kembali'] }}</td>
                <td>
                    @if(!empty($item['logs']))
                        <table width="100%" border="0" cellspacing="0" cellpadding="3" style="border:none;">
                            <thead>
                                <tr>
                                    <th style="border:1px solid #000;">Tanggal</th>
                                    <th style="border:1px solid #000;">Pengrajin</th>
                                    <th style="border:1px solid #000;">Jenis</th>
                                    <th style="border:1px solid #000;">Qty</th>
                                    <th style="border:1px solid #000;">Keterangan</th>
                                    <th style="border:1px solid #000;">Trx ID</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($item['logs'] as $log)
                                <tr>
                                    <td style="border:1px solid #000;">{{ \Carbon\Carbon::parse($log['tanggal'])->format('d-m-Y H:i') }}</td>
                                    <td style="border:1px solid #000;">{{ $log['nama_pengrajin'] }}</td>
                                    <td style="border:1px solid #000;">{{ strtoupper($log['type']) }}</td>
                                    <td style="border:1px solid #000;">{{ $log['quantity'] }}</td>
                                    <td style="border:1px solid #000;">{{ $log['keterangan'] }}</td>
                                    <td style="border:1px solid #000;">{{ $log['trx_id'] ?? '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        Tidak ada log
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>