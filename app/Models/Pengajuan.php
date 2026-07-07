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
        return $this->hasOne(UmkmTerdaftar::class, 'submission_id');
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::saved(function (Pengajuan $pengajuan) {
            if ($pengajuan->status === 'Disetujui') {
                $pengajuan->umkmTerdaftar()->updateOrCreate(
                    ['submission_id' => $pengajuan->id],
                    [
                        'nomor_pengajuan' => $pengajuan->nomor_pengajuan,
                        'nama_pemilik' => $pengajuan->nama_pemilik,
                        'nomor_telepon' => $pengajuan->nomor_telepon,
                        'nama_usaha' => $pengajuan->nama_usaha,
                        'jenis_usaha' => $pengajuan->jenis_usaha,
                        'deskripsi_usaha' => $pengajuan->deskripsi_usaha,
                        'desa' => $pengajuan->desa,
                        'alamat_lengkap' => $pengajuan->alamat_lengkap,
                        'foto_usaha' => $pengajuan->foto_usaha,
                        'nib' => $pengajuan->nib,
                        'sertifikasi_halal' => $pengajuan->sertifikasi_halal,
                    ]
                );
            } else {
                $pengajuan->umkmTerdaftar()->delete();
            }
        });
    }
}
