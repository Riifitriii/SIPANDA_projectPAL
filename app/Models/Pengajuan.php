<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pengajuan extends Model
{
    protected $table = 'submissions';

    protected $fillable = [
        'nomor_pengajuan',
        'nama_pemilik',
        'nomor_telepon',
        'nama_usaha',
        'jenis_usaha',
        'deskripsi_usaha',
        'desa',
        'alamat_lengkap',
        'foto_usaha',
        'nib',
        'sertifikasi_halal',
        'status',
        'catatan_admin',
    ];

    /**
     * Get the registered UMKM associated with the submission.
     */
    public function umkmTerdaftar(): HasOne
    {
        return $this->hasOne(UmkmTerdaftar::class, 'pengajuan_id');
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::saved(function (Pengajuan $pengajuan) {
            if ($pengajuan->status === 'Disetujui') {
                $pengajuan->umkmTerdaftar()->updateOrCreate(
                    ['pengajuan_id' => $pengajuan->id],
                    []
                );
            } else {
                $pengajuan->umkmTerdaftar()->delete();
            }
        });
    }
}
