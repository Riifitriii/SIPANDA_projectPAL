<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\UmkmTerdaftar;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display the dashboard statistics.
     */
    public function dashboard()
    {
        $stats = [
            'total_pengajuan' => Pengajuan::count(),
            'menunggu' => Pengajuan::where('status', 'Menunggu Verifikasi')->count(),
            'perbaikan' => Pengajuan::where('status', 'Perlu Perbaikan')->count(),
            'disetujui' => Pengajuan::where('status', 'Disetujui')->count(),
            'ditolak' => Pengajuan::where('status', 'Ditolak')->count(),
            'total_umkm' => UmkmTerdaftar::count(),
        ];

        // Fetch recent submissions (last 5)
        $recentSubmissions = Pengajuan::orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentSubmissions'));
    }

    /**
     * List all submissions with search and filter.
     */
    public function listPengajuan(Request $request)
    {
        $query = Pengajuan::query();

        // Search filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nomor_pengajuan', 'like', "%{$search}%")
                  ->orWhere('nama_pemilik', 'like', "%{$search}%")
                  ->orWhere('nama_usaha', 'like', "%{$search}%")
                  ->orWhere('jenis_usaha', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $submissions = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('admin.pengajuan', compact('submissions'));
    }

    /**
     * Display submission detail for verification.
     */
    public function detailPengajuan($id)
    {
        $submission = Pengajuan::findOrFail($id);
        return view('admin.detail-pengajuan', compact('submission'));
    }

    /**
     * Process verification.
     */
    public function verifyPengajuan(Request $request, $id)
    {
        $submission = Pengajuan::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:Menunggu Verifikasi,Perlu Perbaikan,Disetujui,Ditolak',
            'catatan_admin' => 'required_if:status,Perlu Perbaikan,Ditolak|nullable|string',
        ], [
            'status.required' => 'Status verifikasi wajib dipilih.',
            'status.in' => 'Status verifikasi tidak valid.',
            'catatan_admin.required_if' => 'Catatan admin wajib diisi apabila status "Perlu Perbaikan" atau "Ditolak" agar dipahami pemohon.',
        ]);

        $submission->update([
            'status' => $validated['status'],
            'catatan_admin' => $validated['catatan_admin'],
        ]);

        return redirect()->route('admin.pengajuan.detail', $submission->id)
            ->with('success', 'Status pengajuan berhasil diperbarui.');
    }

    /**
     * List registered UMKM.
     */
    public function listUmkm(Request $request)
    {
        $query = UmkmTerdaftar::with('pengajuan');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('pengajuan', function ($q) use ($search) {
                $q->where('nomor_pengajuan', 'like', "%{$search}%")
                  ->orWhere('nama_pemilik', 'like', "%{$search}%")
                  ->orWhere('nama_usaha', 'like', "%{$search}%")
                  ->orWhere('jenis_usaha', 'like', "%{$search}%")
                  ->orWhere('desa', 'like', "%{$search}%");
            });
        }

        if ($request->filled('desa')) {
            $query->whereHas('pengajuan', function ($q) use ($request) {
                $q->where('desa', $request->input('desa'));
            });
        }

        // Join with submissions table for ordering by nama_usaha
        $umkms = $query->join('submissions', 'umkm_terdaftar.pengajuan_id', '=', 'submissions.id')
            ->select('umkm_terdaftar.*')
            ->orderBy('submissions.nama_usaha', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.umkm', compact('umkms'));
    }

    /**
     * Export / Print layout for UMKM data.
     */
    public function printLaporan(Request $request)
    {
        $query = UmkmTerdaftar::with('pengajuan');

        if ($request->filled('desa')) {
            $query->whereHas('pengajuan', function ($q) use ($request) {
                $q->where('desa', $request->input('desa'));
            });
        }

        // Join with submissions table for ordering by nama_usaha
        $umkms = $query->join('submissions', 'umkm_terdaftar.pengajuan_id', '=', 'submissions.id')
            ->select('umkm_terdaftar.*')
            ->orderBy('submissions.nama_usaha', 'asc')
            ->get();

        $selectedDesa = $request->input('desa', 'Semua Desa');

        return view('admin.laporan', compact('umkms', 'selectedDesa'));
    }
}
