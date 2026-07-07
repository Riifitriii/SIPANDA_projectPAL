export const laravelAssets = {
  migration: `<?php

use Illuminate\\Database\\Migrations\\Migration;
use Illuminate\\Database\\Schema\\Blueprint;
use Illuminate\\Support\\Facades\\Schema;

class CreateSubmissionsAndRegisteredUmkmsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 1. Table Submissions (Pengajuan)
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_pengajuan')->unique();
            $table->string('nama_pemilik');
            $table->string('nomor_telepon');
            $table->string('nama_usaha');
            $table->string('jenis_usaha');
            $table->text('deskripsi_usaha')->nullable();
            $table->string('desa');
            $table->text('alamat_lengkap');
            $table->string('foto_usaha');
            $table->enum('status', [
                'Menunggu Verifikasi', 
                'Perlu Perbaikan', 
                'Disetujui', 
                'Ditolak'
            ])->default('Menunggu Verifikasi');
            $table->text('catatan_admin')->nullable();
            $table->timestamps();
        });

        // 2. Table Registered UMKM (UMKM Terdaftar)
        Schema::create('registered_umkms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained('submissions')->onDelete('cascade');
            $table->string('nomor_pengajuan')->unique();
            $table->string('nama_pemilik');
            $table->string('nomor_telepon');
            $table->string('nama_usaha');
            $table->string('jenis_usaha');
            $table->text('deskripsi_usaha')->nullable();
            $table->string('desa');
            $table->text('alamat_lengkap');
            $table->string('foto_usaha');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registered_umkms');
        Schema::dropIfExists('submissions');
    }
}`,

  submissionModel: `<?php

namespace App\\Models;

use Illuminate\\Database\\Eloquent\\Factories\\HasFactory;
use Illuminate\\Database\\Eloquent\\Model;

class Submission extends Model
{
    use HasFactory;

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
        'status',
        'catatan_admin'
    ];

    /**
     * Get the registered UMKM associated with the submission.
     */
    public function registeredUmkm()
    {
        return $this->hasOne(RegisteredUmkm::class);
    }
}`,

  registeredModel: `<?php

namespace App\\Models;

use Illuminate\\Database\\Eloquent\\Factories\\HasFactory;
use Illuminate\\Database\\Eloquent\\Model;

class RegisteredUmkm extends Model
{
    use HasFactory;

    protected $fillable = [
        'submission_id',
        'nomor_pengajuan',
        'nama_pemilik',
        'nomor_telepon',
        'nama_usaha',
        'jenis_usaha',
        'deskripsi_usaha',
        'desa',
        'alamat_lengkap',
        'foto_usaha'
    ];

    /**
     * Get the submission that owns the registered UMKM.
     */
    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }
}`,

  routes: `<?php

use Illuminate\\Support\\Facades\\Route;
use App\\Http\\Controllers\\UmkmController;

/*
|--------------------------------------------------------------------------
| Web Routes - SIPANDA Cicalengka
|--------------------------------------------------------------------------
*/

// --- Public Routes (Akses Publik, Tanpa Auth) ---
Route::get('/', [UmkmController::class, 'index'])->name('home');
Route::get('/ajukan', [UmkmController::class, 'create'])->name('ajukan.form');
Route::post('/ajukan', [UmkmController::class, 'store'])->name('ajukan.store');
Route::get('/cek-status', [UmkmController::class, 'statusForm'])->name('status.form');
Route::post('/cek-status', [UmkmController::class, 'checkStatus'])->name('status.check');

// --- Admin Authentication ---
Route::get('/admin/login', [UmkmController::class, 'loginForm'])->name('login');
Route::post('/admin/login', [UmkmController::class, 'login'])->name('admin.login');
Route::post('/admin/logout', [UmkmController::class, 'logout'])->name('admin.logout');

// --- Protected Admin Routes (Diproteksi Middleware Auth) ---
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [UmkmController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/pengajuan', [UmkmController::class, 'listSubmissions'])->name('admin.pengajuan.list');
    Route::get('/pengajuan/{id}', [UmkmController::class, 'detailSubmission'])->name('admin.pengajuan.detail');
    Route::post('/pengajuan/{id}/verifikasi', [UmkmController::class, 'verifySubmission'])->name('admin.pengajuan.verify');
    Route::get('/umkm', [UmkmController::class, 'listRegistered'])->name('admin.umkm.list');
    Route::get('/laporan', [UmkmController::class, 'printReport'])->name('admin.laporan.print');
});`,

  controller: `<?php

namespace App\\Http\\Controllers;

use Illuminate\\Http\\Request;
use App\\Models\\Submission;
use App\\Models\\RegisteredUmkm;
use Illuminate\\Support\\Facades\\Auth;
use Illuminate\\Support\\Facades\\DB;
use Illuminate\\Support\\Facades\\Storage;

class UmkmController extends Controller
{
    /**
     * GET '/' -> Menampilkan Landing Page.
     */
    public function index()
    {
        // Mendapatkan statistik ringkas untuk ditampilkan di landing page
        $total_terdaftar = RegisteredUmkm::count();
        return view('landing', compact('total_terdaftar'));
    }

    /**
     * GET '/ajukan' -> Menampilkan Form Pengajuan.
     */
    public function create()
    {
        $daftar_desa = [
            'Babakan Peuteuy', 'Cicalengka Kulon', 'Cicalengka Wetan', 
            'Cikuya', 'Dampit', 'Margaasih', 'Nagrog', 'Narawita', 
            'Panenjoan', 'Tanjungwangi', 'Tenjolaya', 'Waluya'
        ];
        return view('form_pengajuan', compact('daftar_desa'));
    }

    /**
     * POST '/ajukan' -> Memproses data pengajuan.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_pemilik' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:20',
            'nama_usaha' => 'required|string|max:255',
            'jenis_usaha' => 'required|string',
            'deskripsi_usaha' => 'nullable|string',
            'desa' => 'required|string',
            'alamat_lengkap' => 'required|string',
            'foto_usaha' => 'required|image|mimes:jpeg,png,jpg|max:5120', // Max 5MB
        ]);

        try {
            DB::beginTransaction();

            // 1. Upload Foto Usaha
            $path = $request->file('foto_usaha')->store('foto_usaha', 'public');

            // 2. Generate Nomor Pengajuan Unik
            // Format: SPD-YYYYMMDD-XXX
            $datePrefix = 'SPD-' . date('Ymd') . '-';
            
            // Lock table row untuk menghindari race condition counter pengajuan di hari yang sama
            $lastSubmission = Submission::where('nomor_pengajuan', 'LIKE', $datePrefix . '%')
                ->orderBy('id', 'desc')
                ->lockForUpdate()
                ->first();

            $nextSequence = 1;
            if ($lastSubmission) {
                $lastParts = explode('-', $lastSubmission->nomor_pengajuan);
                $lastSeq = intval(end($lastParts));
                $nextSequence = $lastSeq + 1;
            }
            $nomor_pengajuan = $datePrefix . str_pad($nextSequence, 3, '0', STR_PAD_LEFT);

            // 3. Simpan Submission
            $submission = Submission::create([
                'nomor_pengajuan' => $nomor_pengajuan,
                'nama_pemilik' => $request->nama_pemilik,
                'nomor_telepon' => $request->nomor_telepon,
                'nama_usaha' => $request->nama_usaha,
                'jenis_usaha' => $request->jenis_usaha,
                'deskripsi_usaha' => $request->deskripsi_usaha,
                'desa' => $request->desa,
                'alamat_lengkap' => $request->alamat_lengkap,
                'foto_usaha' => $path,
                'status' => 'Menunggu Verifikasi',
            ]);

            DB::commit();

            return redirect()->route('status.form')->with([
                'success' => 'Pengajuan berhasil dikirim!',
                'nomor_pengajuan' => $nomor_pengajuan,
                'nama_usaha' => $request->nama_usaha
            ]);

        } catch (\\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Gagal memproses pengajuan: ' . $e->getMessage()]);
        }
    }

    /**
     * GET '/cek-status' -> Menampilkan halaman form cek status.
     */
    public function statusForm()
    {
        return view('cek_status');
    }

    /**
     * POST '/cek-status' -> Memproses pencarian nomor_pengajuan.
     */
    public function checkStatus(Request $request)
    {
        $request->validate([
            'nomor_pengajuan' => 'required|string',
        ]);

        $submission = Submission::where('nomor_pengajuan', trim($request->nomor_pengajuan))->first();

        if (!$submission) {
            return back()->withErrors(['nomor_pengajuan' => 'Nomor pengajuan tidak terdaftar.']);
        }

        return view('cek_status', compact('submission'));
    }

    /**
     * GET '/admin/login' -> Menampilkan login admin.
     */
    public function loginForm()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    /**
     * POST '/admin/login' -> Autentikasi Admin.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Autentikasi custom / bawaan Laravel
        if (Auth::attempt(['email' => $request->username . '@cicalengka.go.id', 'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['username' => 'Username atau Password salah.']);
    }

    /**
     * POST '/admin/logout' -> Logout admin.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

    /**
     * GET '/admin/dashboard' -> Ringkasan Dashboard.
     */
    public function dashboard()
    {
        $total_pengajuan = Submission::count();
        $total_menunggu = Submission::where('status', 'Menunggu Verifikasi')->count();
        $total_perbaikan = Submission::where('status', 'Perlu Perbaikan')->count();
        $total_disetujui = Submission::where('status', 'Disetujui')->count();
        $total_ditolak = Submission::where('status', 'Ditolak')->count();
        $total_terdaftar = RegisteredUmkm::count();

        $pengajuan_terbaru = Submission::orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.dashboard', compact(
            'total_pengajuan', 'total_menunggu', 'total_perbaikan',
            'total_disetujui', 'total_ditolak', 'total_terdaftar', 'pengajuan_terbaru'
        ));
    }

    /**
     * GET '/admin/pengajuan' -> Tabel List Pengajuan.
     */
    public function listSubmissions(Request $request)
    {
        $query = Submission::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nomor_pengajuan', 'LIKE', "%{$search}%")
                  ->orWhere('nama_usaha', 'LIKE', "%{$search}%")
                  ->orWhere('nama_pemilik', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $submissions = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.pengajuan_index', compact('submissions'));
    }

    /**
     * GET '/admin/pengajuan/{id}' -> Detail Pengajuan.
     */
    public function detailSubmission($id)
    {
        $submission = Submission::findOrFail($id);
        return view('admin.pengajuan_detail', compact('submission'));
    }

    /**
     * POST '/admin/pengajuan/{id}/verifikasi' -> Proses Verifikasi.
     */
    public function verifySubmission(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Disetujui,Perlu Perbaikan,Ditolak',
            'catatan_admin' => 'nullable|string'
        ]);

        $submission = Submission::findOrFail($id);

        try {
            DB::beginTransaction();

            // Update status dan catatan
            $submission->update([
                'status' => $request->status,
                'catatan_admin' => $request->catatan_admin
            ]);

            // Sync ke registered_umkms menggunakan DB event/observer atau logika controller
            if ($request->status === 'Disetujui') {
                // Pastikan belum terdaftar sebelumnya untuk menghindari duplikasi
                RegisteredUmkm::firstOrCreate(
                    ['submission_id' => $submission->id],
                    [
                        'nomor_pengajuan' => $submission->nomor_pengajuan,
                        'nama_pemilik' => $submission->nama_pemilik,
                        'nomor_telepon' => $submission->nomor_telepon,
                        'nama_usaha' => $submission->nama_usaha,
                        'jenis_usaha' => $submission->jenis_usaha,
                        'deskripsi_usaha' => $submission->deskripsi_usaha,
                        'desa' => $submission->desa,
                        'alamat_lengkap' => $submission->alamat_lengkap,
                        'foto_usaha' => $submission->foto_usaha
                    ]
                );
            } else {
                // Hapus dari data terdaftar jika status diturunkan dari disetujui
                RegisteredUmkm::where('submission_id', $submission->id)->delete();
            }

            DB::commit();
            return redirect()->route('admin.pengajuan.list')->with('success', 'Verifikasi berhasil disimpan.');

        } catch (\\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal menyimpan verifikasi: ' . $e->getMessage()]);
        }
    }

    /**
     * GET '/admin/umkm' -> List UMKM Terdaftar.
     */
    public function listRegistered(Request $request)
    {
        $query = RegisteredUmkm::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nomor_pengajuan', 'LIKE', "%{$search}%")
                  ->orWhere('nama_usaha', 'LIKE', "%{$search}%")
                  ->orWhere('nama_pemilik', 'LIKE', "%{$search}%");
        }

        $umkms = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.umkm_index', compact('umkms'));
    }

    /**
     * GET '/admin/laporan' -> Print-ready Report.
     */
    public function printReport(Request $request)
    {
        $umkms = RegisteredUmkm::orderBy('desa', 'asc')->get();
        return view('admin.laporan_print', compact('umkms'));
    }
}`,

  bladeLanding: `<!-- resources/views/landing.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPANDA - Sistem Informasi Pengajuan dan Pendataan UMKM Cicalengka</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#f8f9ff] text-[#0b1c30]">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 bg-white/80 backdrop-blur-md border-b border-slate-200">
        <div class="flex justify-between items-center px-10 h-16 max-w-7xl mx-auto">
            <span class="text-xl font-bold text-[#00236f]">SIPANDA</span>
            <div class="hidden md:flex items-center gap-8">
                <a class="text-[#00236f] font-bold border-b-2 border-[#00236f] py-1" href="#home">Beranda</a>
                <a class="text-slate-600 hover:text-[#00236f] transition-colors" href="#about">Informasi</a>
                <a class="text-slate-600 hover:text-[#00236f] transition-colors" href="#requirements">Syarat</a>
                <a class="text-slate-600 hover:text-[#00236f] transition-colors" href="{{ route('ajukan.form') }}">Ajukan</a>
                <a class="text-slate-600 hover:text-[#00236f] transition-colors" href="{{ route('status.form') }}">Cek Status</a>
            </div>
            <a href="{{ route('login') }}" class="bg-[#00236f] text-white px-6 py-2 rounded-lg font-medium hover:bg-opacity-95 transition-all">
                Masuk
            </a>
        </div>
    </nav>

    <!-- Hero -->
    <section class="relative min-h-[700px] flex items-center pt-20" id="home">
        <div class="max-w-7xl mx-auto px-10 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="space-y-6">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#82f5c1]/30 text-[#00714e] font-semibold border border-[#006c4a]/20">
                    <span class="material-symbols-outlined text-[18px]">verified</span>
                    <span>Resmi: Kecamatan Cicalengka</span>
                </div>
                <h1 class="text-5xl font-extrabold text-[#00236f] leading-tight">
                    SIPANDA <br><span class="text-slate-900">Cicalengka</span>
                </h1>
                <p class="text-lg text-slate-600 max-w-lg">
                    Sistem Informasi Pengajuan dan Pendataan UMKM Seksi Pemberdayaan Masyarakat. Wujudkan database UMKM yang terintegrasi dan transparan.
                </p>
                <div class="flex flex-wrap gap-4 pt-2">
                    <a href="{{ route('ajukan.form') }}" class="px-8 py-4 bg-[#00236f] text-white rounded-xl font-bold shadow-lg hover:bg-opacity-90 transition-all">
                        Ajukan Pendataan
                    </a>
                    <a href="{{ route('status.form') }}" class="px-8 py-4 border-2 border-[#00236f] text-[#00236f] rounded-xl font-bold hover:bg-[#00236f]/5 transition-all">
                        Cek Status
                    </a>
                </div>
            </div>
            <div class="hidden lg:block">
                <img src="https://images.unsplash.com/photo-1544816155-12df9643f363?w=600&auto=format&fit=crop&q=60" alt="UMKM" class="rounded-3xl shadow-2xl">
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-100 border-t border-slate-200 py-12">
        <div class="max-w-7xl mx-auto px-10 text-center text-slate-500">
            <p>© 2024 Kecamatan Cicalengka. SIPANDA</p>
        </div>
    </footer>
</body>
</html>`,

  bladeForm: `<!-- resources/views/form_pengajuan.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pengajuan Pendataan UMKM | SIPANDA</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#F9FAFB] text-[#0b1c30]">
    <nav class="fixed top-0 w-full z-50 bg-white/80 backdrop-blur-md border-b border-slate-200">
        <div class="flex justify-between items-center px-10 h-16 max-w-7xl mx-auto">
            <span class="text-xl font-bold text-[#00236f]">SIPANDA</span>
            <a href="{{ route('home') }}" class="text-slate-600 hover:text-[#00236f]">Kembali ke Beranda</a>
        </div>
    </nav>

    <main class="pt-24 pb-12 max-w-4xl mx-auto px-6">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-[#00236f] mb-2">Formulir Pengajuan Pendataan UMKM</h1>
            <p class="text-slate-600">Lengkapi data usaha Anda dengan benar untuk terdaftar di database Kecamatan Cicalengka.</p>
        </div>

        @if($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r">
                <p>{{ $errors->first() }}</p>
            </div>
        @endif

        <form action="{{ route('ajukan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <!-- Section 1: Data Pemilik -->
            <section class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                <h2 class="text-lg font-bold mb-4 flex items-center gap-2"><span class="material-symbols-outlined text-[#00236f]">person</span> Data Pemilik</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="nama_pemilik" required class="w-full rounded-lg border-slate-300 shadow-sm focus:border-[#00236f] focus:ring-[#00236f]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Nomor Telepon (WhatsApp)</label>
                        <input type="text" name="nomor_telepon" required placeholder="0812xxxxxx" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-[#00236f] focus:ring-[#00236f]">
                    </div>
                </div>
            </section>

            <!-- Section 2: Informasi Usaha -->
            <section class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                <h2 class="text-lg font-bold mb-4 flex items-center gap-2"><span class="material-symbols-outlined text-[#00236f]">storefront</span> Informasi Usaha</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Nama Usaha</label>
                        <input type="text" name="nama_usaha" required class="w-full rounded-lg border-slate-300 shadow-sm focus:border-[#00236f] focus:ring-[#00236f]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Jenis Usaha</label>
                        <select name="jenis_usaha" required class="w-full rounded-lg border-slate-300 shadow-sm focus:border-[#00236f] focus:ring-[#00236f]">
                            <option value="">Pilih Jenis Usaha</option>
                            <option value="Kuliner">Kuliner</option>
                            <option value="Fashion">Fashion</option>
                            <option value="Kriya/Kerajinan">Kriya/Kerajinan</option>
                            <option value="Jasa">Jasa</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi Usaha</label>
                    <textarea name="deskripsi_usaha" rows="3" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-[#00236f] focus:ring-[#00236f]"></textarea>
                </div>
            </section>

            <!-- Section 3: Lokasi Usaha -->
            <section class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                <h2 class="text-lg font-bold mb-4 flex items-center gap-2"><span class="material-symbols-outlined text-[#00236f]">location_on</span> Lokasi Usaha</h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Desa</label>
                        <select name="desa" required class="w-full rounded-lg border-slate-300 shadow-sm focus:border-[#00236f] focus:ring-[#00236f]">
                            <option value="">Pilih Desa</option>
                            @foreach($daftar_desa as $d)
                                <option value="{{ $d }}">{{ $d }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Alamat Lengkap</label>
                        <textarea name="alamat_lengkap" required rows="2" placeholder="Nama Jalan, RT/RW, dsb" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-[#00236f] focus:ring-[#00236f]"></textarea>
                    </div>
                </div>
            </section>

            <!-- Section 4: Dokumentasi -->
            <section class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                <h2 class="text-lg font-bold mb-4 flex items-center gap-2"><span class="material-symbols-outlined text-[#00236f]">camera_alt</span> Dokumentasi</h2>
                <div class="border-2 border-dashed border-slate-300 rounded-lg p-6 text-center hover:bg-slate-50 transition-colors">
                    <span class="material-symbols-outlined text-4xl text-slate-400 mb-2">cloud_upload</span>
                    <p class="text-slate-600 mb-2">Pilih Foto Usaha atau Produk Anda</p>
                    <input type="file" name="foto_usaha" required class="mx-auto block text-sm text-slate-500">
                    <span class="text-xs text-slate-400 mt-2 block">Format: JPG, PNG (Max 5MB)</span>
                </div>
            </section>

            <button type="submit" class="w-full py-4 bg-[#006c4a] text-white rounded-xl font-bold shadow-lg hover:bg-opacity-95 transition-all">
                Kirim Pengajuan
            </button>
        </form>
    </main>
</body>
</html>`,

  bladeStatus: `<!-- resources/views/cek_status.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Status Pengajuan - SIPANDA</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#F9FAFB] text-[#0b1c30] min-h-screen">
    <nav class="fixed top-0 w-full z-50 bg-white/80 backdrop-blur-md border-b border-slate-200">
        <div class="flex justify-between items-center px-10 h-16 max-w-7xl mx-auto">
            <span class="text-xl font-bold text-[#00236f]">SIPANDA</span>
            <a href="{{ route('home') }}" class="text-slate-600">Kembali</a>
        </div>
    </nav>

    <main class="pt-24 max-w-3xl mx-auto px-6">
        <!-- Search Box -->
        <div class="bg-[#00236f] text-white p-8 rounded-3xl text-center mb-8">
            <h1 class="text-3xl font-bold mb-2">Lacak Pengajuan Anda</h1>
            <p class="opacity-80 mb-6">Pantau proses verifikasi administrasi UMKM Anda secara real-time.</p>
            <form action="{{ route('status.check') }}" method="POST" class="max-w-md mx-auto flex gap-2">
                @csrf
                <input type="text" name="nomor_pengajuan" required placeholder="SPD-YYYYMMDD-XXXX" class="flex-grow rounded-xl text-slate-800 font-mono tracking-wider focus:ring-2 focus:ring-[#00236f]">
                <button type="submit" class="bg-[#006c4a] hover:bg-opacity-95 px-6 py-3 rounded-xl font-bold transition-all">Cari</button>
            </form>
        </div>

        @if(isset($submission))
            <!-- Result -->
            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 space-y-6">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-slate-100 pb-4">
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-widest mb-1">Nomor Pengajuan</p>
                        <h2 class="text-2xl font-bold text-[#00236f] font-mono">{{ $submission->nomor_pengajuan }}</h2>
                    </div>
                    
                    @php
                        $color = 'bg-yellow-100 text-yellow-800 border-yellow-200';
                        if($submission->status === 'Disetujui') $color = 'bg-green-100 text-green-800 border-green-200';
                        if($submission->status === 'Perlu Perbaikan') $color = 'bg-orange-100 text-orange-800 border-orange-200';
                        if($submission->status === 'Ditolak') $color = 'bg-red-100 text-red-800 border-red-200';
                    @endphp

                    <div class="px-4 py-1.5 rounded-full border {{ $color }} font-bold text-sm">
                        {{ $submission->status }}
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs text-slate-400">Nama Usaha</p>
                        <p class="font-bold">{{ $submission->nama_usaha }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400">Tanggal Pengajuan</p>
                        <p class="font-bold">{{ $submission->created_at->format('d M Y') }}</p>
                    </div>
                </div>

                @if($submission->status === 'Perlu Perbaikan' || $submission->status === 'Ditolak')
                    <div class="bg-orange-50 border-l-4 border-orange-500 p-4 rounded-r">
                        <h4 class="font-bold text-orange-800 flex items-center gap-2 mb-1">
                            <span class="material-symbols-outlined">announcement</span> Catatan Verifikasi Admin
                        </h4>
                        <p class="text-slate-600">{{ $submission->catatan_admin }}</p>
                    </div>
                @endif
            </div>
        @endif
    </main>
</body>
</html>`,

  bladeDashboard: `<!-- resources/views/admin/dashboard.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPANDA Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex">
    <!-- Sidebar -->
    <aside class="w-[280px] bg-[#00236f] text-white flex flex-col py-4 px-3 shrink-0">
        <h1 class="text-xl font-bold px-4 mb-8">Admin SIPANDA</h1>
        <nav class="flex-grow space-y-1">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-4 px-4 py-3 bg-white/10 rounded-lg font-bold">
                <span class="material-symbols-outlined">dashboard</span> Dashboard
            </a>
            <a href="{{ route('admin.pengajuan.list') }}" class="flex items-center gap-4 px-4 py-3 hover:bg-white/5 rounded-lg text-slate-300">
                <span class="material-symbols-outlined">description</span> Pengajuan
            </a>
            <a href="{{ route('admin.umkm.list') }}" class="flex items-center gap-4 px-4 py-3 hover:bg-white/5 rounded-lg text-slate-300">
                <span class="material-symbols-outlined">storefront</span> UMKM Terdaftar
            </a>
        </nav>
        <form action="{{ route('admin.logout') }}" method="POST" class="px-4">
            @csrf
            <button type="submit" class="flex items-center gap-4 py-3 text-slate-400 hover:text-white">
                <span class="material-symbols-outlined">logout</span> Logout
            </button>
        </form>
    </aside>

    <!-- Main Content -->
    <div class="flex-grow flex flex-col min-h-screen">
        <header class="h-16 bg-white border-b border-slate-200 px-8 flex justify-between items-center">
            <h2 class="text-xl font-bold text-[#00236f]">Dashboard</h2>
            <span class="font-bold">Admin Utama</span>
        </header>

        <main class="p-8 space-y-6">
            <h3 class="text-2xl font-bold">Selamat Datang, Admin!</h3>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
                    <p class="text-slate-400 text-sm">Total Pengajuan</p>
                    <p class="text-3xl font-bold mt-1">{{ $total_pengajuan }}</p>
                </div>
                <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
                    <p class="text-slate-400 text-sm">Menunggu Verifikasi</p>
                    <p class="text-3xl font-bold mt-1 text-yellow-600">{{ $total_menunggu }}</p>
                </div>
                <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
                    <p class="text-slate-400 text-sm">Disetujui</p>
                    <p class="text-3xl font-bold mt-1 text-green-600">{{ $total_disetujui }}</p>
                </div>
                <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
                    <p class="text-slate-400 text-sm">Perlu Perbaikan</p>
                    <p class="text-3xl font-bold mt-1 text-orange-600">{{ $total_perbaikan }}</p>
                </div>
            </div>
        </main>
    </div>
</body>
</html>`
};
