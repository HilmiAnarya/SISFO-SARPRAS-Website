<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengembalian;
use Illuminate\Http\Request;

class AdminPengembalianController extends Controller
{
    public function index()
    {
        $data = Pengembalian::with([
            'peminjaman.user',
            'peminjaman.detail.barang',
        ])->latest()->get();

        return response()->json(['data' => $data]);
    }

    public function show($id)
    {
        $pengembalian = Pengembalian::with([
            'peminjaman.user',
            'peminjaman.detail.barang',
        ])->findOrFail($id);

        return response()->json(['data' => $pengembalian]);
    }

    public function approve($id)
    {
        $pengembalian = Pengembalian::findOrFail($id);

        if ($pengembalian->status_approval !== 'pending') {
            return response()->json(['message' => 'Pengembalian sudah diproses'], 400);
        }

        $pengembalian->update([
            'status_approval' => 'disetujui',
        ]);

        return response()->json([
            'message' => 'Pengembalian disetujui',
            'data' => $pengembalian,
        ]);
    }

    public function reject(Request $request, $id)
    {
        $pengembalian = Pengembalian::findOrFail($id);

        if ($pengembalian->status_approval !== 'pending') {
            return response()->json(['message' => 'Pengembalian sudah diproses'], 400);
        }

        $request->validate([
            'catatan' => 'nullable|string|max:255',
        ]);

        $pengembalian->update([
            'status_approval' => 'ditolak',
            'catatan' => $request->catatan,
        ]);

        return response()->json([
            'message' => 'Pengembalian ditolak',
            'data' => $pengembalian,
        ]);
    }
}
