<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang';
    protected $primaryKey = 'id_barang';
    protected $fillable = ['nama_barang', 'id_kategori', 'stok', 'kondisi']; // Ganti 'jumlah' dengan 'stok'

    // Relasi ke Kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }
}
