<?php

namespace App\Http\Controllers;

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
        return view('landing');
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
            'nib' => 'nullable|string|max:100',
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
        ]);

        $submission = DB::transaction(function () use ($request, $validated) {
            // Generate unique sequential nomor_pengajuan: SPD-YYYYMMDD-XXXX
            $datePrefix = 'SPD-' . date('Ymd') . '-';
            
            // Use pessimistic lock (lockForUpdate) to prevent duplicate generation during race condition
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

            // Store the file using Storage facade (public disk)
            if ($request->hasFile('foto_usaha')) {
                $file = $request->file('foto_usaha');
                $fileName = $nomorPengajuan . '_' . time() . '.' . $file->extension();
                $path = $file->storeAs('submissions', $fileName, 'public');
                $fotoPath = 'storage/' . $path;
            } else {
                $fotoPath = '';
            }

            // Create submission
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
}
