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

    /**
     * Aksesor foto_usaha agar selalu menghasilkan path yang valid untuk asset($submission->foto_usaha).
     */
    public function getFotoUsahaAttribute($value): string
    {
        if (empty($value)) {
            return 'images/default-store.svg';
        }

        // Ambil nama file murni
        $rawPath = parse_url($value, PHP_URL_PATH) ?? $value;
        $fileName = basename(str_replace('\\', '/', $rawPath));

        // 1. Cek langsung di direktori publik uploads/submissions (portabel 100% tanpa symlink)
        if (!empty($fileName) && file_exists(public_path('uploads/submissions/' . $fileName))) {
            return 'uploads/submissions/' . $fileName;
        }

        // 2. Cek di direktori publik storage/submissions
        if (!empty($fileName) && file_exists(public_path('storage/submissions/' . $fileName))) {
            return 'storage/submissions/' . $fileName;
        }

        // 3. Cek di storage internal via route fallback / storage path
        if (!empty($fileName) && (file_exists(storage_path('app/public/submissions/' . $fileName)) || file_exists(storage_path('app/submissions/' . $fileName)))) {
            return 'storage/submissions/' . $fileName;
        }

        $cleanPath = ltrim(str_replace('\\', '/', $value), '/');
        if (file_exists(public_path($cleanPath))) {
            return $cleanPath;
        }

        // Jika berkas fisiknya tidak ditemukan di server/terhapus, kembalikan gambar placeholder bawaan
        return 'images/default-store.svg';
    }

    /**
     * Aksesor foto_usaha_url untuk akses URL lengkap.
     */
    public function getFotoUsahaUrlAttribute(): string
    {
        return asset($this->foto_usaha);
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
