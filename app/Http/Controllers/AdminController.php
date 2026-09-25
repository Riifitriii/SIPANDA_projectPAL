<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Pengajuan;
use App\Models\UmkmTerdaftar;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

        $recentSubmissions = Pengajuan::orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentSubmissions'));
    }

    /**
     * List all submissions with search and filter.
     */
    public function listPengajuan(Request $request)
    {
        $query = Pengajuan::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nomor_pengajuan', 'like', "%{$search}%")
                  ->orWhere('nama_pemilik', 'like', "%{$search}%")
                  ->orWhere('nama_usaha', 'like', "%{$search}%")
                  ->orWhere('jenis_usaha', 'like', "%{$search}%");
            });
        }

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

        $statusLama = $submission->status;

        $submission->update([
            'status' => $validated['status'],
            'catatan_admin' => $validated['catatan_admin'],
        ]);

        // Catat ke activity_logs (Poin 6)
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'verifikasi_pengajuan',
            'description' => "Memperbarui status pengajuan {$submission->nomor_pengajuan} ({$submission->nama_usaha}) dari '{$statusLama}' menjadi '{$submission->status}'" . ($submission->catatan_admin ? ". Catatan: {$submission->catatan_admin}" : ""),
            'subject_type' => 'pengajuan',
            'subject_id' => $submission->id,
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

        $umkms = $query->join('pengajuan', 'umkm_terdaftar.pengajuan_id', '=', 'pengajuan.id')
            ->select('umkm_terdaftar.*')
            ->orderBy('pengajuan.nama_usaha', 'asc')
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

        $umkms = $query->join('pengajuan', 'umkm_terdaftar.pengajuan_id', '=', 'pengajuan.id')
            ->select('umkm_terdaftar.*')
            ->orderBy('pengajuan.nama_usaha', 'asc')
            ->get();

        $selectedDesa = $request->input('desa', 'Semua Desa');

        return view('admin.laporan', compact('umkms', 'selectedDesa'));
    }

    /**
     * Tampilkan halaman Kelola Admin (Khusus Super Admin).
     */
    public function kelolaAdmin(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->input('role'));
        }

        $admins = $query->orderByRaw("CASE WHEN role = 'super_admin' THEN 1 ELSE 2 END")
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.kelola-admin', compact('admins'));
    }

    /**
     * Simpan admin baru (Khusus Super Admin).
     * Role di-hardcode jadi 'admin' biasa demi keamanan sistem.
     */
    public function storeAdmin(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
        ], [
            'name.required' => 'Nama lengkap admin wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Alamat email ini sudah terdaftar sebagai akun admin.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal harus 6 karakter.',
        ]);

        // Role di-hardcode menjadi 'admin' (bukan pilihan bebas)
        $newAdmin = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'admin',
        ]);

        // Catat ke activity_logs
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'tambah_admin',
            'description' => "Menambahkan admin baru: {$newAdmin->name} ({$newAdmin->email}) dengan role 'admin'",
            'subject_type' => 'user',
            'subject_id' => $newAdmin->id,
        ]);

        return redirect()->route('admin.kelola-admin')
            ->with('success', "Admin baru \"{$newAdmin->name}\" ({$newAdmin->email}) berhasil ditambahkan dengan role Admin.");
    }

    /**
     * Hapus admin (Khusus Super Admin) dengan proteksi.
     */
    public function destroyAdmin($id)
    {
        $admin = User::findOrFail($id);

        // Proteksi 1: Super Admin tidak bisa menghapus dirinya sendiri
        if ($admin->id === auth()->id()) {
            return back()->with('error', 'Aksi ditolak: Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // Proteksi 2: Tidak bisa menghapus Super Admin terakhir yang tersisa
        if ($admin->isSuperAdmin() && User::where('role', 'super_admin')->count() <= 1) {
            return back()->with('error', 'Aksi ditolak: Tidak dapat menghapus Super Admin terakhir yang tersisa.');
        }

        $adminName = $admin->name;
        $adminEmail = $admin->email;

        // Catat ke activity_logs
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'hapus_admin',
            'description' => "Menghapus akun admin: {$adminName} ({$adminEmail})",
            'subject_type' => 'user',
            'subject_id' => $admin->id,
        ]);

        $admin->delete();

        return redirect()->route('admin.kelola-admin')
            ->with('success', "Akun admin \"{$adminName}\" berhasil dihapus.");
    }

    /**
     * Tampilkan riwayat Log Aktivitas (Khusus Super Admin).
     */
    public function logAktivitas(Request $request)
    {
        $query = ActivityLog::with(['user', 'subject']);

        // Filter berdasarkan Pengguna / Admin
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->input('user_id'));
        }

        // Filter rentang tanggal
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->input('start_date'));
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->input('end_date'));
        }

        // Filter jenis aksi
        if ($request->filled('action')) {
            $query->where('action', $request->input('action'));
        }

        // Pencarian teks dalam deskripsi
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('description', 'like', "%{$search}%");
        }

        // Data ditampilkan bertahap per halaman (pagination 15 data per halaman agar ringan)
        $logs = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        // Daftar semua admin untuk dropdown filter
        $adminList = User::orderBy('name', 'asc')->get();

        return view('admin.log-aktivitas', compact('logs', 'adminList'));
    }
}
