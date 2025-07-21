<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Barang;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $peminjaman = Peminjaman::with('barang')
            ->where('user_id', $request->user()->id_user)
            ->latest()
            ->get();

        return response()->json(['data' => $peminjaman]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal_peminjaman' => 'required|date_format:Y-m-d H:i:s',
            'tanggal_pengembalian' => 'nullable|date_format:Y-m-d H:i:s|after_or_equal:tanggal_peminjaman',
            'id_barang' => 'required|exists:barang,id_barang',
            'jumlah' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            $barang = Barang::findOrFail($validated['id_barang']);

            if ($barang->stok < $validated['jumlah']) {
                return response()->json([
                    'message' => 'Stok barang tidak mencukupi.',
                ], 400);
            }

            // Kurangi stok barang
            $barang->stok -= $validated['jumlah'];
            $barang->save();

            // Buat peminjaman
            $peminjaman = Peminjaman::create([
                'user_id' => $request->user()->id_user,
                'barang_id' => $validated['id_barang'],
                'jumlah' => $validated['jumlah'],
                'tanggal_pinjam' => $validated['tanggal_peminjaman'],
                'tanggal_kembali' => $validated['tanggal_pengembalian'] ?? null,
                'status' => 'pending',
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Peminjaman berhasil diajukan',
                'data' => $peminjaman->load('barang'),
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Gagal membuat peminjaman: ' . $e->getMessage());

            return response()->json([
                'message' => 'Gagal membuat peminjaman',
                'error' => $e->getMessage(),
            ], 500);
        }


    }

    public function downloadpeminjaman()
    {
        $data = Peminjaman::with(['user', 'barang'])->get();

        $pdf = app('dompdf.wrapper'); // 👈 gunakan app() untuk mengambil instance
        $pdf->loadView('laporan.peminjaman', compact('data'));

        return $pdf->download('laporan-peminjaman.pdf');
    }
}
