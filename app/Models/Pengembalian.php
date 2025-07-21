<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class Pengembalian extends Model
{
    use HasFactory;

    protected $table = 'pengembalian';
    protected $primaryKey = 'id_pengembalian';

    protected $fillable = [
        'id_peminjaman',
        'gambar_barang',
        'tanggal_kembali',
        'catatan_user',
        'status',
    ];

    protected $casts = [
        'tanggal_kembali' => 'datetime',
    ];

    public $timestamps = true;

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'id_peminjaman', 'id_peminjaman');
    }

    // Accessor untuk menampilkan URL gambar lengkap
    public function getGambarBarangAttribute($value)
    {
        return $value ? asset('storage/' . $value) : null;
    }
}

