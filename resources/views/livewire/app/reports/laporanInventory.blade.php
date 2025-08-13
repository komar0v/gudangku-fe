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

        h1,
        h2 {
            text-align: center;
            margin: 0;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .info {
            margin: 20px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            font-size: 14px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
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
        <h1>GudangKu</h1>
        <h2>Laporan Inventory Bulanan</h2>
        <p>Periode: {{$periode}}</p>
    </div>

    <div class="info">
        <strong>Dicetak pada:</strong> {{$printedOn}}<br>
        <strong>Disiapkan oleh:</strong> {{ $namaAdmin }}
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Masuk</th>
                <th>Keluar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inventoryReportData as $inventoryData)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{$inventoryData['nama_barang']}}</td>
                <td>{{$inventoryData['kategori']}}</td>
                <td>{{$inventoryData['masuk']}}</td>
                <td>{{$inventoryData['keluar']}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- <div class="footer">
  <p>TTD,</p>
  <br><br>
  <p>(Nama Penanggung Jawab)</p>
</div> -->

</body>

</html>