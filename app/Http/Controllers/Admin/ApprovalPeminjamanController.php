<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class ApprovalPeminjamanController extends Controller
{
    public function index()
    {
        return Peminjaman::with(['user', 'detail.barang'])
            ->where('status', 'pending')
            ->latest()
            ->get();
    }

    public function show($id)
    {
        return Peminjaman::with(['user', 'detail.barang'])->findOrFail($id);
    }

    public function approve($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        if ($peminjaman->status !== 'pending') {
            return response()->json(['message' => 'Sudah diproses'], 400);
        }
        $peminjaman->update(['status' => 'disetujui']);
        return response()->json(['message' => 'Disetujui']);
    }

    public function reject(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        if ($peminjaman->status !== 'pending') {
            return response()->json(['message' => 'Sudah diproses'], 400);
        }
        $peminjaman->update([
            'status' => 'ditolak',
            //'catatan' => $request->catatan,
        ]);
        return response()->json(['message' => 'Ditolak']);
    }
}
