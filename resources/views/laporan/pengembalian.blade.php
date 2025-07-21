<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengembalian</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
        }
        table, th, td {
            border: 1px solid #444;
        }
        th, td {
            padding: 6px;
            text-align: left;
        }
        h2 {
            text-align: center;
            margin-bottom: 0;
        }
        .tanggal {
            text-align: center;
            margin-top: 0;
        }
    </style>
</head>
<body>
<h2>Laporan Data Pengembalian</h2>
<p class="tanggal">Tanggal Cetak: {{ now()->format('d-m-Y H:i') }}</p>
<table>
    <thead>
    <tr>
        <th>No</th>
        <th>Nama User</th>
        <th>Nama Barang</th>
        <th>Jumlah</th>
        <th>Tanggal Pengembalian</th>
        <th>Keterangan</th>
    </tr>
    </thead>
    <tbody>
    @forelse ($data as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->peminjaman->user->nama ?? '-' }}</td>
            <td>{{ $item->peminjaman->barang->nama_barang ?? '-' }}</td>
            <td>{{ $item->peminjaman->jumlah ?? '-' }}</td>
            <td>{{ \Carbon\Carbon::parse($item->tanggal_pengembalian)->format('d-m-Y') }}</td>
            <td>{{ $item->keterangan ?? '-' }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="6" style="text-align: center;">Tidak ada data</td>
        </tr>
    @endforelse
    </tbody>
</table>
</body>
</html>
