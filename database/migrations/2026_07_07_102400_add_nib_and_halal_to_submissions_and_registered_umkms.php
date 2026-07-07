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
        Schema::table('submissions', function (Blueprint $table) {
            $table->string('nib')->nullable()->after('foto_usaha');
            $table->string('sertifikasi_halal')->nullable()->after('nib');
        });

        Schema::table('registered_umkms', function (Blueprint $table) {
            $table->string('nib')->nullable()->after('foto_usaha');
            $table->string('sertifikasi_halal')->nullable()->after('nib');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('submissions', function (Blueprint $table) {
            $table->dropColumn(['nib', 'sertifikasi_halal']);
        });

        Schema::table('registered_umkms', function (Blueprint $table) {
            $table->dropColumn(['nib', 'sertifikasi_halal']);
        });
    }
};
