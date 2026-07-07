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
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_pengajuan')->unique();
            $table->string('nama_pemilik');
            $table->string('nomor_telepon');
            $table->string('nama_usaha');
            $table->string('jenis_usaha');
            $table->text('deskripsi_usaha');
            $table->string('desa');
            $table->text('alamat_lengkap');
            $table->string('foto_usaha');
            $table->string('nib')->nullable();
            $table->string('sertifikasi_halal')->nullable();
            $table->enum('status', ['Menunggu Verifikasi', 'Perlu Perbaikan', 'Disetujui', 'Ditolak'])->default('Menunggu Verifikasi');
            $table->text('catatan_admin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
