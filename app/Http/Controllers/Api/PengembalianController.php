<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pengembalian;
use App\Models\Peminjaman;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PengembalianController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $pengembalian = Pengembalian::with([
            'peminjaman.barang',
            'peminjaman.user'
        ])->whereHas('peminjaman', function ($query) use ($user) {
            $query->where('user_id', $user->id_user);
        })->latest()->get();

        return response()->json([
            'data' => $pengembalian
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_peminjaman'    => 'required|exists:peminjaman,id_peminjaman',
            'tanggal_kembali'  => 'required|date',
            'catatan_user'     => 'nullable|string|max:255',
            'gambar_barang'    => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $peminjaman = Peminjaman::with('barang')->findOrFail($request->id_peminjaman);

            if ($peminjaman->pengembalian) {
                return response()->json(['message' => 'Peminjaman ini sudah dikembalikan'], 400);
            }

            $gambarPath = $request->file('gambar_barang')->store('pengembalian', 'public');

            $pengembalian = Pengembalian::create([
                'id_peminjaman'   => $peminjaman->id_peminjaman,
                'gambar_barang'   => $gambarPath,
                'tanggal_kembali' => $request->tanggal_kembali,
                'catatan_user'    => $request->catatan_user,
                'status'          => 'pending',
            ]);

            // Update stok barang berdasarkan jumlah dari peminjaman
            //$peminjaman->barang->increment('stok', $peminjaman->jumlah);

            DB::commit();

            return response()->json([
                'message' => 'Pengembalian berhasil diajukan',
                'data'    => [
                    'id_pengembalian' => $pengembalian->id_pengembalian,
                    'id_peminjaman'   => $pengembalian->id_peminjaman,
                    'tanggal_kembali' => $pengembalian->tanggal_kembali,
                    'catatan_user'    => $pengembalian->catatan_user,
                    'status'          => $pengembalian->status,
                    'gambar_barang'   => Storage::url($pengembalian->gambar_barang),
                ]
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Gagal menyimpan pengembalian',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function downloadpengembalian()
    {
        $data = Pengembalian::with(['peminjaman.user', 'peminjaman.barang'])->get();
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('laporan.pengembalian', compact('data'));

        return $pdf->download('laporan-pengembalian.pdf');
    }
}
