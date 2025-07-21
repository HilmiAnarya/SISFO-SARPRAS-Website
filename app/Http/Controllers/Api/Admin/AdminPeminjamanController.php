<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminPeminjamanController extends Controller
{
    public function index()
    {
        $data = Peminjaman::with(['user', 'barang'])->latest()->get();
        return response()->json(['data' => $data]);
    }

    public function show($id)
    {
        $peminjaman = Peminjaman::with(['user', 'barang'])->findOrFail($id);
        return response()->json(['data' => $peminjaman]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id_user',
            'tanggal_peminjaman' => 'required|date',
            'tanggal_pengembalian' => 'required|date|after_or_equal:tanggal_peminjaman',
            'id_barang' => 'required|exists:barang,id_barang',
            'jumlah' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $peminjaman = Peminjaman::create([
                'user_id' => $request->user_id,
                'barang_id' => $request->id_barang,
                'jumlah' => $request->jumlah,
                'tanggal_pinjam' => $request->tanggal_peminjaman,
                'tanggal_kembali' => $request->tanggal_pengembalian,
                'status' => 'disetujui',
            ]);

            DB::commit();
            return response()->json(['message' => 'Peminjaman berhasil dibuat', 'data' => $peminjaman], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Gagal menyimpan', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,disetujui,ditolak',
        ]);

        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update(['status' => $request->status]);

        return response()->json(['message' => 'Status diperbarui', 'data' => $peminjaman]);
    }

    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->delete();

        return response()->json(['message' => 'Peminjaman dihapus']);
    }
}
