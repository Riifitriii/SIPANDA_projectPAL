<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Pengajuan extends Model
{
    protected $table = 'pengajuan';

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

    public function umkmTerdaftar(): HasOne
    {
        return $this->hasOne(UmkmTerdaftar::class, 'pengajuan_id');
    }

    /**
     * Riwayat log aktivitas terkait pengajuan ini.
     */
    public function activityLogs(): MorphMany
    {
        return $this->morphMany(ActivityLog::class, 'subject');
    }

    /**
     * Aksesor created_at agar selalu ditampilkan dalam zona waktu Indonesia Barat (WIB).
     */
    public function getCreatedAtAttribute($value): ?\Carbon\Carbon
    {
        if (!$value) {
            return null;
        }
        return \Carbon\Carbon::parse($value, 'UTC')->timezone('Asia/Jakarta');
    }

    /**
     * Aksesor updated_at agar selalu ditampilkan dalam zona waktu Indonesia Barat (WIB).
     */
    public function getUpdatedAtAttribute($value): ?\Carbon\Carbon
    {
        if (!$value) {
            return null;
        }
        return \Carbon\Carbon::parse($value, 'UTC')->timezone('Asia/Jakarta');
    }

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
