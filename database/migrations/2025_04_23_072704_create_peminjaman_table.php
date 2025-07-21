<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id('id_peminjaman'); // Kolom ID untuk peminjaman
            $table->unsignedBigInteger('user_id'); // Kolom untuk userId yang terhubung dengan tabel users
            $table->foreign('user_id')->references('id_user')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('barang_id'); // Kolom untuk barangId yang terhubung dengan tabel barang
            $table->foreign('barang_id')->references('id_barang')->on('barang')->onDelete('cascade');
            $table->dateTime('tanggal_pinjam'); // Kolom tanggal peminjaman
            $table->dateTime('tanggal_kembali')->nullable(); // tambahkan ini
            $table->integer('jumlah'); // Kolom untuk jumlah barang yang dipinjam
            $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');
            $table->timestamps(); // Kolom created_at dan updated_at

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
