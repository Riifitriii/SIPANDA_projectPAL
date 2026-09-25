<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PublicController extends Controller
{
    /**
     * Display the landing page.
     */
    public function landing()
    {
        $this->ensureTransparentLogos();
        return view('landing');
    }

    /**
     * Ensure transparent PNG logos are created from original JPGs.
     */
    private function ensureTransparentLogos()
    {
        $dir = public_path('images/gov-logos');
        if (!file_exists($dir)) {
            return;
        }

        $logos = [
            'logo-berakhlak' => 'white',
            'logo-banggamelayani' => 'white',
            'logo-cicalengka' => 'black',
            'logo-bandung-shield' => 'black',
        ];

        foreach ($logos as $name => $bg) {
            $pngPath = $dir . DIRECTORY_SEPARATOR . $name . '.png';
            $jpgPath = $dir . DIRECTORY_SEPARATOR . $name . '.jpg';

            if (!file_exists($pngPath) && file_exists($jpgPath)) {
                if ($bg === 'white') {
                    $this->removeWhiteBg($jpgPath, $pngPath);
                } else {
                    $this->removeBlackBg($jpgPath, $pngPath);
                }
            }
        }
    }

    /**
     * Convert JPEG with white background to transparent PNG.
     */
    private function removeWhiteBg($inputPath, $outputPath)
    {
        if (!extension_loaded('gd')) {
            return;
        }
        $img = @imagecreatefromjpeg($inputPath);
        if (!$img) {
            return;
        }

        $width = imagesx($img);
        $height = imagesy($img);

        $newImg = imagecreatetruecolor($width, $height);
        imagealphablending($newImg, false);
        imagesavealpha($newImg, true);

        $transparent = imagecolorallocatealpha($newImg, 0, 0, 0, 127);
        imagefill($newImg, 0, 0, $transparent);

        for ($x = 0; $x < $width; $x++) {
            for ($y = 0; $y < $height; $y++) {
                $rgb = imagecolorat($img, $x, $y);
                $r = ($rgb >> 16) & 0xFF;
                $g = ($rgb >> 8) & 0xFF;
                $b = $rgb & 0xFF;

                if ($r > 230 && $g > 230 && $b > 230) {
                    $maxVal = max($r, $g, $b);
                    $alpha = (int)(($maxVal - 230) / 25 * 127);
                    if ($alpha > 127) $alpha = 127;
                    if ($alpha < 0) $alpha = 0;

                    $color = imagecolorallocatealpha($newImg, $r, $g, $b, $alpha);
                } else {
                    $color = imagecolorallocatealpha($newImg, $r, $g, $b, 0);
                }
                imagesetpixel($newImg, $x, $y, $color);
            }
        }

        imagepng($newImg, $outputPath);
        imagedestroy($img);
        imagedestroy($newImg);
    }

    /**
     * Convert JPEG with black background to transparent PNG.
     */
    private function removeBlackBg($inputPath, $outputPath)
    {
        if (!extension_loaded('gd')) {
            return;
        }
        $img = @imagecreatefromjpeg($inputPath);
        if (!$img) {
            return;
        }

        $width = imagesx($img);
        $height = imagesy($img);

        $newImg = imagecreatetruecolor($width, $height);
        imagealphablending($newImg, false);
        imagesavealpha($newImg, true);

        $transparent = imagecolorallocatealpha($newImg, 0, 0, 0, 127);
        imagefill($newImg, 0, 0, $transparent);

        for ($x = 0; $x < $width; $x++) {
            for ($y = 0; $y < $height; $y++) {
                $rgb = imagecolorat($img, $x, $y);
                $r = ($rgb >> 16) & 0xFF;
                $g = ($rgb >> 8) & 0xFF;
                $b = $rgb & 0xFF;

                if ($r < 35 && $g < 35 && $b < 35) {
                    $minVal = min($r, $g, $b);
                    $alpha = (int)((35 - $minVal) / 35 * 127);
                    if ($alpha > 127) $alpha = 127;
                    if ($alpha < 0) $alpha = 0;

                    $color = imagecolorallocatealpha($newImg, $r, $g, $b, $alpha);
                } else {
                    $color = imagecolorallocatealpha($newImg, $r, $g, $b, 0);
                }
                imagesetpixel($newImg, $x, $y, $color);
            }
        }

        imagepng($newImg, $outputPath);
        imagedestroy($img);
        imagedestroy($newImg);
    }

    /**
     * Show the application submission form.
     */
    public function showForm()
    {
        return view('ajukan');
    }

    /**
     * Process the submission form.
     */
    public function submitForm(Request $request)
    {
        $validated = $request->validate([
            'nama_pemilik' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:20',
            'nama_usaha' => 'required|string|max:255',
            'jenis_usaha' => 'required|string|max:100',
            'deskripsi_usaha' => 'required|string',
            'desa' => 'required|string|max:100',
            'alamat_lengkap' => 'required|string',
            'foto_usaha' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'nib' => 'required|string|max:100',
            'sertifikasi_halal' => 'nullable|string|max:100',
        ], [
            'nama_pemilik.required' => 'Nama pemilik wajib diisi.',
            'nomor_telepon.required' => 'Nomor telepon/WhatsApp wajib diisi.',
            'nama_usaha.required' => 'Nama usaha wajib diisi.',
            'jenis_usaha.required' => 'Jenis usaha wajib dipilih.',
            'deskripsi_usaha.required' => 'Deskripsi usaha wajib diisi.',
            'desa.required' => 'Desa wajib dipilih.',
            'alamat_lengkap.required' => 'Alamat lengkap usaha wajib diisi.',
            'foto_usaha.required' => 'Foto usaha/produk wajib diunggah.',
            'foto_usaha.image' => 'File harus berupa gambar.',
            'foto_usaha.mimes' => 'Format gambar harus jpeg, png, jpg, atau webp.',
            'foto_usaha.max' => 'Ukuran gambar maksimal adalah 2MB.',
            'nib.required' => 'Nomor Induk Berusaha (NIB) wajib diisi.',
        ]);

        $submission = DB::transaction(function () use ($request, $validated) {
            $datePrefix = 'SPD-' . date('Ymd') . '-';
            
            $latest = Pengajuan::where('nomor_pengajuan', 'like', $datePrefix . '%')
                ->orderBy('nomor_pengajuan', 'desc')
                ->lockForUpdate()
                ->first();

            if ($latest) {
                $lastSequence = (int) substr($latest->nomor_pengajuan, -4);
                $sequence = $lastSequence + 1;
            } else {
                $sequence = 1;
            }
            $nomorPengajuan = $datePrefix . str_pad($sequence, 4, '0', STR_PAD_LEFT);

            if ($request->hasFile('foto_usaha')) {
                $file = $request->file('foto_usaha');
                $fileName = $nomorPengajuan . '_' . time() . '.' . $file->extension();
                $path = $file->storeAs('submissions', $fileName);
                $fotoPath = Storage::url($path);
            } else {
                $fotoPath = '';
            }

            return Pengajuan::create([
                'nomor_pengajuan' => $nomorPengajuan,
                'nama_pemilik' => $validated['nama_pemilik'],
                'nomor_telepon' => $validated['nomor_telepon'],
                'nama_usaha' => $validated['nama_usaha'],
                'jenis_usaha' => $validated['jenis_usaha'],
                'deskripsi_usaha' => $validated['deskripsi_usaha'],
                'desa' => $validated['desa'],
                'alamat_lengkap' => $validated['alamat_lengkap'],
                'foto_usaha' => $fotoPath,
                'nib' => $validated['nib'] ?? null,
                'sertifikasi_halal' => $validated['sertifikasi_halal'] ?? null,
                'status' => 'Menunggu Verifikasi',
            ]);
        });

        return redirect()->route('ajukan')->with('success_submission', [
            'nomor_pengajuan' => $submission->nomor_pengajuan,
            'nama_usaha' => $submission->nama_usaha,
            'nama_pemilik' => $submission->nama_pemilik,
        ]);
    }

    /**
     * Show the checking status form.
     */
    public function showStatusForm(Request $request)
    {
        $submission = null;
        $error = null;

        if ($request->has('nomor_pengajuan')) {
            $nomorPengajuan = trim($request->query('nomor_pengajuan'));

            if (empty($nomorPengajuan)) {
                $error = 'Nomor pengajuan wajib diisi.';
            } else {
                $submission = Pengajuan::where('nomor_pengajuan', $nomorPengajuan)->first();
                if (!$submission) {
                    $error = 'Nomor pengajuan tidak ditemukan. Silakan periksa kembali format penulisan Anda.';
                }
            }
        }

        return view('cek-status', compact('submission', 'error'));
    }

    /**
     * Process status checking (POST fallback).
     */
    public function checkStatus(Request $request)
    {
        $request->validate([
            'nomor_pengajuan' => 'required|string',
        ], [
            'nomor_pengajuan.required' => 'Nomor pengajuan wajib diisi.',
        ]);

        return redirect()->route('cek-status', ['nomor_pengajuan' => trim($request->input('nomor_pengajuan'))]);
    }

    /**
     * Normalisasi nomor telepon: buang spasi, tanda hubung, simbol, dan seragamkan format (08xxx / 62xxx).
     */
    public static function normalizePhoneNumber(?string $phone): string
    {
        if (!$phone) {
            return '';
        }
        $clean = preg_replace('/[^0-9]/', '', $phone);

        // Jika diawali 62 -> ubah awalan jadi 0
        if (str_starts_with($clean, '62')) {
            $clean = '0' . substr($clean, 2);
        } elseif (str_starts_with($clean, '8')) {
            // Jika diawali 8 (misal 8123456789) -> tambahkan 0 di depan
            $clean = '0' . $clean;
        }

        return $clean;
    }

    /**
     * Tampilkan halaman/formulir khusus perbaikan pengajuan (diakses via link nomor_pengajuan).
     */
    public function showPerbaikanForm(Request $request, $nomor_pengajuan)
    {
        $submission = Pengajuan::where('nomor_pengajuan', trim($nomor_pengajuan))->first();

        if (!$submission) {
            return redirect()->route('cek-status')
                ->with('error', "Nomor pengajuan '{$nomor_pengajuan}' tidak ditemukan. Silakan periksa kembali format penulisan Anda.");
        }

        // Hanya boleh diakses jika status pengajuan adalah 'Perlu Perbaikan'
        if ($submission->status !== 'Perlu Perbaikan') {
            $statusMessage = match ($submission->status) {
                'Menunggu Verifikasi' => "Pengajuan {$submission->nomor_pengajuan} saat ini sedang dalam proses 'Menunggu Verifikasi' dan belum memerlukan perbaikan data.",
                'Disetujui' => "Pengajuan {$submission->nomor_pengajuan} telah 'Disetujui' (terdata resmi) dan data sudah tidak dapat diubah.",
                'Ditolak' => "Pengajuan {$submission->nomor_pengajuan} berstatus 'Ditolak'.",
                default => "Pengajuan {$submission->nomor_pengajuan} tidak berstatus 'Perlu Perbaikan'."
            };

            return redirect()->route('cek-status', ['nomor_pengajuan' => $submission->nomor_pengajuan])
                ->with('info', $statusMessage);
        }

        $sessionKey = 'perbaikan_verified_' . $submission->nomor_pengajuan;
        $isVerified = session($sessionKey) === true;

        return view('perbaikan', compact('submission', 'isVerified'));
    }

    /**
     * Verifikasi kepemilikan pengajuan berdasarkan kombinasi nomor_pengajuan + nomor_telepon terdaftar.
     */
    public function verifyPerbaikanPhone(Request $request, $nomor_pengajuan)
    {
        $submission = Pengajuan::where('nomor_pengajuan', trim($nomor_pengajuan))->first();

        if (!$submission) {
            return redirect()->route('cek-status')
                ->with('error', "Nomor pengajuan '{$nomor_pengajuan}' tidak ditemukan.");
        }

        if ($submission->status !== 'Perlu Perbaikan') {
            return redirect()->route('cek-status', ['nomor_pengajuan' => $submission->nomor_pengajuan])
                ->with('info', "Pengajuan tidak berstatus 'Perlu Perbaikan'.");
        }

        $request->validate([
            'nomor_telepon' => 'required|string',
        ], [
            'nomor_telepon.required' => 'Nomor telepon/WhatsApp wajib diisi untuk verifikasi kepemilikan.',
        ]);

        $inputPhone = self::normalizePhoneNumber($request->input('nomor_telepon'));
        $dbPhone = self::normalizePhoneNumber($submission->nomor_telepon);

        if (empty($inputPhone) || empty($dbPhone) || $inputPhone !== $dbPhone) {
            return back()->withInput()->with('verification_error', 'Nomor telepon/WhatsApp yang Anda masukkan tidak cocok dengan data pendaftaran awal pengajuan ini. Silakan periksa kembali nomor yang Anda gunakan.');
        }

        // Simpan tanda verifikasi ke dalam session
        session(['perbaikan_verified_' . $submission->nomor_pengajuan => true]);

        return redirect()->route('pengajuan.perbaikan', $submission->nomor_pengajuan)
            ->with('verification_success', 'Verifikasi kepemilikan berhasil! Silakan periksa catatan admin dan perbarui data yang diperlukan di bawah ini.');
    }

    /**
     * Simpan perbaikan data pengajuan (update baris yang sama, status kembali ke 'Menunggu Verifikasi').
     */
    public function updatePerbaikan(Request $request, $nomor_pengajuan)
    {
        $submission = Pengajuan::where('nomor_pengajuan', trim($nomor_pengajuan))->first();

        if (!$submission) {
            return redirect()->route('cek-status')
                ->with('error', "Nomor pengajuan '{$nomor_pengajuan}' tidak ditemukan.");
        }

        if ($submission->status !== 'Perlu Perbaikan') {
            return redirect()->route('cek-status', ['nomor_pengajuan' => $submission->nomor_pengajuan])
                ->with('info', "Pengajuan tidak berstatus 'Perlu Perbaikan'.");
        }

        $sessionKey = 'perbaikan_verified_' . $submission->nomor_pengajuan;
        if (session($sessionKey) !== true) {
            return redirect()->route('pengajuan.perbaikan', $submission->nomor_pengajuan)
                ->with('verification_error', 'Sesi verifikasi kepemilikan Anda telah berakhir atau belum dilakukan. Silakan verifikasi nomor telepon kembali.');
        }

        $validated = $request->validate([
            'nama_pemilik' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:20',
            'nama_usaha' => 'required|string|max:255',
            'jenis_usaha' => 'required|string|max:100',
            'deskripsi_usaha' => 'required|string',
            'desa' => 'required|string|max:100',
            'alamat_lengkap' => 'required|string',
            'foto_usaha' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'nib' => 'required|string|max:100',
            'sertifikasi_halal' => 'nullable|string|max:100',
        ], [
            'nama_pemilik.required' => 'Nama pemilik wajib diisi.',
            'nomor_telepon.required' => 'Nomor telepon/WhatsApp wajib diisi.',
            'nama_usaha.required' => 'Nama usaha wajib diisi.',
            'jenis_usaha.required' => 'Jenis usaha wajib dipilih.',
            'deskripsi_usaha.required' => 'Deskripsi usaha wajib diisi.',
            'desa.required' => 'Desa wajib dipilih.',
            'alamat_lengkap.required' => 'Alamat lengkap usaha wajib diisi.',
            'foto_usaha.image' => 'File harus berupa gambar.',
            'foto_usaha.mimes' => 'Format gambar harus jpeg, png, jpg, atau webp.',
            'foto_usaha.max' => 'Ukuran gambar maksimal adalah 2MB.',
            'nib.required' => 'Nomor Induk Berusaha (NIB) wajib diisi.',
        ]);

        // Foto usaha opsional:
        // Jika tidak upload ulang, foto lama tetap dipakai.
        // Jika upload foto baru, foto lama dihapus dari penyimpanan agar tidak menumpuk.
        $fotoPath = $submission->foto_usaha;
        if ($request->hasFile('foto_usaha')) {
            // Hapus file lama jika ada di storage
            if (!empty($submission->foto_usaha)) {
                $parsedPath = parse_url($submission->foto_usaha, PHP_URL_PATH);
                $relativeStoragePath = preg_replace('#^/storage/#', '', $parsedPath);
                if (Storage::disk('public')->exists($relativeStoragePath)) {
                    Storage::disk('public')->delete($relativeStoragePath);
                }
            }

            $file = $request->file('foto_usaha');
            $fileName = $submission->nomor_pengajuan . '_' . time() . '.' . $file->extension();
            $path = $file->storeAs('submissions', $fileName);
            $fotoPath = Storage::url($path);
        }

        // Perbarui data pada baris yang sama (nomor pengajuan tetap sama) dan ubah status ke 'Menunggu Verifikasi'
        $submission->update([
            'nama_pemilik' => $validated['nama_pemilik'],
            'nomor_telepon' => $validated['nomor_telepon'],
            'nama_usaha' => $validated['nama_usaha'],
            'jenis_usaha' => $validated['jenis_usaha'],
            'deskripsi_usaha' => $validated['deskripsi_usaha'],
            'desa' => $validated['desa'],
            'alamat_lengkap' => $validated['alamat_lengkap'],
            'foto_usaha' => $fotoPath,
            'nib' => $validated['nib'] ?? null,
            'sertifikasi_halal' => $validated['sertifikasi_halal'] ?? null,
            'status' => 'Menunggu Verifikasi',
        ]);

        // Catat ke activity_logs
        try {
            ActivityLog::create([
                'user_id' => null,
                'action' => 'perbaikan_pengajuan',
                'description' => "Pemohon telah memperbarui data pengajuan {$submission->nomor_pengajuan} ({$submission->nama_usaha}). Status dikembalikan ke 'Menunggu Verifikasi' untuk ditinjau ulang.",
                'subject_type' => 'pengajuan',
                'subject_id' => $submission->id,
            ]);
        } catch (\Exception $e) {
            // Abaikan jika log gagal agar tidak menghalangi alur pemohon
        }

        // Bersihkan sesi verifikasi setelah selesai perbaikan
        session()->forget($sessionKey);

        return redirect()->route('cek-status', ['nomor_pengajuan' => $submission->nomor_pengajuan])
            ->with('success', "Data pengajuan {$submission->nomor_pengajuan} berhasil diperbarui! Status telah dikembalikan ke 'Menunggu Verifikasi' dan akan segera ditinjau kembali oleh tim verifikator.");
    }
}

