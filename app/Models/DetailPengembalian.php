<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPengembalian extends Model
{
    protected $table = 'detail_pengembalian';
    protected $primaryKey = 'id_detail_pengembalian';
    protected $fillable = ['id_pengembalian', 'id_barang', 'jumlah_kembali', 'kondisi_kembali'];

    public function pengembalian()
    {
        return $this->belongsTo(Pengembalian::class, 'id_pengembalian');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }
}
