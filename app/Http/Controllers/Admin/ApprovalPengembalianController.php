<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApprovalPengembalianController extends Controller
{
    public function index()
    {
        $pengembalian = Pengembalian::with('peminjaman.user')
            ->where('status', 'pending')
            ->latest()
            ->get();

        return response()->json(['data' => $pengembalian]);
    }

    public function show($id)
    {
        $pengembalian = Pengembalian::with([
            'peminjaman.user',
            'peminjaman.detail.barang'
        ])->findOrFail($id);

        return response()->json(['data' => $pengembalian]);
    }

    public function approve($id)
    {
        DB::beginTransaction();

        try {
            $pengembalian = Pengembalian::with('peminjaman.detail.barang')->findOrFail($id);

            if ($pengembalian->status !== 'pending') {
                return response()->json(['message' => 'Pengembalian sudah diproses sebelumnya'], 400);
            }

            // Tambah stok barang
            foreach ($pengembalian->peminjaman->detail as $detail) {
                $detail->barang->increment('stok', $detail->jumlah);
            }

            $pengembalian->update(['status' => 'disetujui']);

            DB::commit();

            return response()->json(['message' => 'Pengembalian disetujui']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Gagal menyetujui pengembalian',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function reject($id)
    {
        $pengembalian = Pengembalian::findOrFail($id);

        if ($pengembalian->status !== 'pending') {
            return response()->json(['message' => 'Pengembalian sudah diproses sebelumnya'], 400);
        }

        $pengembalian->update(['status' => 'ditolak']);

        return response()->json([
            'message' => 'Pengembalian ditolak',
            'data' => $pengembalian
        ]);
    }
}
