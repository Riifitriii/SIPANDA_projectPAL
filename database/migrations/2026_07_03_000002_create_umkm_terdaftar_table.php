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
        Schema::create('umkm_terdaftar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_id')->constrained('submissions')->onDelete('cascade');
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
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('umkm_terdaftar');
    }
};
