<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use App\Models\Barang;

class BarangController extends Controller
{
    // Menampilkan semua data barang
    public function index()
    {
        $barangs = Barang::with('kategori')->get(); // Menampilkan relasi kategori jika diperlukan
        return response()->json(['data' => $barangs]);
    }

    // Menambahkan data barang baru
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:100', // Validasi nama_barang
            'id_kategori' => 'required|exists:kategori,id_kategori', // Validasi kategori
            'stok' => 'required|integer', // Validasi stok
            'kondisi' => 'nullable|string|max:50', // Validasi kondisi, opsional
        ]);

        // Menambahkan data barang ke database
        $barang = Barang::create($validated);

        return response()->json(['data' => $barang], 201);
    }

    // Menampilkan detail barang berdasarkan ID
    public function show($id)
    {
        // Mencari barang berdasarkan ID dengan relasi kategori
        $barang = Barang::with('kategori')->findOrFail($id);

        return response()->json(['data' => $barang]);
    }

    // Mengupdate data barang berdasarkan ID
    public function update(Request $request, $id)
    {
        // Mencari barang berdasarkan ID
        $barang = Barang::findOrFail($id);

        // Validasi dan update data barang
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:100',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'stok' => 'required|integer',
            'kondisi' => 'nullable|string|max:50',
        ]);

        $barang->update($validated);

        return response()->json(['data' => $barang]);
    }

    // Menghapus barang berdasarkan ID
    public function destroy($id)
    {
        // Menghapus barang berdasarkan ID
        Barang::destroy($id);
        return response()->json(['message' => 'Barang deleted']);
    }

    public function downloadbarang()
    {
        $barangs = Barang::all();

        $pdf = PDF::loadView('laporan.barang', compact('barangs'));
        return $pdf->download('laporan-barang.pdf');
    }
}
