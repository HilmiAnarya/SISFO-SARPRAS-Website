<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Peminjaman</title>
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
<h2>Laporan Data Peminjaman</h2>
<p class="tanggal">Tanggal Cetak: {{ now()->format('d-m-Y H:i') }}</p>
<table>
    <thead>
    <tr>
        <th>No</th>
        <th>Nama User</th>
        <th>Nama Barang</th>
        <th>Jumlah</th>
        <th>Tanggal Pinjam</th>
        <th>Tanggal Kembali</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
    @forelse ($data as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->user->nama ?? '-' }}</td>
            <td>{{ $item->barang->nama_barang ?? '-' }}</td>
            <td>{{ $item->jumlah }}</td>
            <td>{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d-m-Y') }}</td>
            <td>{{ $item->tanggal_kembali ? \Carbon\Carbon::parse($item->tanggal_kembali)->format('d-m-Y') : '-' }}</td>
            <td>{{ ucfirst($item->status) }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="7" style="text-align: center;">Tidak ada data</td>
        </tr>
    @endforelse
    </tbody>
</table>
</body>
</html>
