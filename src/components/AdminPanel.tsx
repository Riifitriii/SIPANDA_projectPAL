import React, { useState, useEffect } from 'react';
import { motion } from 'motion/react';
import { 
  LayoutDashboard,
  FileText, 
  Store, 
  Printer, 
  Code, 
  LogOut, 
  Search, 
  Filter, 
  Check, 
  X, 
  AlertTriangle, 
  CheckCircle2, 
  Clock, 
  ExternalLink,
  ChevronRight,
  Clipboard,
  Phone,
  User,
  MapPin,
  Calendar,
  AlertCircle
} from 'lucide-react';
import { ActiveTab, Submission, BusinessStatus } from '../types';
import { laravelAssets } from '../laravelAssets';

interface AdminPanelProps {
  onLogout: () => void;
}

type AdminSubTab = 'dashboard' | 'pengajuan' | 'umkm' | 'laporan' | 'laravel';

export default function AdminPanel({ onLogout }: AdminPanelProps) {
  const [subTab, setSubTab] = useState<AdminSubTab>('dashboard');
  const [submissions, setSubmissions] = useState<Submission[]>([]);
  const [registeredUmkm, setRegisteredUmkm] = useState<Submission[]>([]);
  
  // Search & filter states
  const [searchQuery, setSearchQuery] = useState('');
  const [statusFilter, setStatusFilter] = useState('Semua');
  
  // Detail & action states
  const [selectedSub, setSelectedSub] = useState<Submission | null>(null);
  const [actionStatus, setActionStatus] = useState<BusinessStatus | ''>('');
  const [adminNotes, setAdminNotes] = useState('');
  const [isSaving, setIsSaving] = useState(false);
  
  // Copy to clipboard notification
  const [copiedKey, setCopiedKey] = useState<string | null>(null);

  // Fetch submissions and registered umkms
  const fetchData = async () => {
    try {
      // Submissions
      const subRes = await fetch('/api/submissions');
      if (subRes.ok) {
        const subData = await subRes.json();
        setSubmissions(subData);
      }

      // Registered UMKM
      const regRes = await fetch('/api/umkm');
      if (regRes.ok) {
        const regData = await regRes.json();
        setRegisteredUmkm(regData);
      }
    } catch (e) {
      console.error("Error fetching admin data:", e);
    }
  };

  useEffect(() => {
    fetchData();
  }, [subTab]);

  const handleCopy = (code: string, key: string) => {
    navigator.clipboard.writeText(code);
    setCopiedKey(key);
    setTimeout(() => setCopiedKey(null), 2000);
  };

  const handleSelectSubmission = (sub: Submission) => {
    setSelectedSub(sub);
    setActionStatus(sub.status);
    setAdminNotes(sub.catatan_admin);
  };

  const handleSaveVerification = async () => {
    if (!selectedSub || !actionStatus) return;

    setIsSaving(true);
    try {
      const response = await fetch(`/api/submissions/${selectedSub.id}/verifikasi`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          status: actionStatus,
          catatan_admin: adminNotes
        }),
      });

      if (response.ok) {
        // Success
        await fetchData();
        setSelectedSub(null);
      } else {
        alert("Gagal memperbarui status pengajuan");
      }
    } catch (err) {
      console.error(err);
      alert("Terjadi kesalahan koneksi");
    } finally {
      setIsSaving(false);
    }
  };

  // Printing trigger
  const handlePrint = () => {
    window.print();
  };

  // Calculations for stats
  const totalSubmissions = submissions.length;
  const pendingCount = submissions.filter(s => s.status === 'Menunggu Verifikasi').length;
  const needRevisionCount = submissions.filter(s => s.status === 'Perlu Perbaikan').length;
  const approvedCount = submissions.filter(s => s.status === 'Disetujui').length;
  const rejectedCount = submissions.filter(s => s.status === 'Ditolak').length;
  const totalRegistered = registeredUmkm.length;

  // Filter lists based on inputs
  const filteredSubmissions = submissions.filter(s => {
    const matchesSearch = 
      s.nomor_pengajuan.toLowerCase().includes(searchQuery.toLowerCase()) ||
      s.nama_usaha.toLowerCase().includes(searchQuery.toLowerCase()) ||
      s.nama_pemilik.toLowerCase().includes(searchQuery.toLowerCase()) ||
      s.desa.toLowerCase().includes(searchQuery.toLowerCase());
      
    const matchesStatus = statusFilter === 'Semua' || s.status === statusFilter;
    
    return matchesSearch && matchesStatus;
  });

  const filteredRegistered = registeredUmkm.filter(s => {
    return (
      s.nomor_pengajuan.toLowerCase().includes(searchQuery.toLowerCase()) ||
      s.nama_usaha.toLowerCase().includes(searchQuery.toLowerCase()) ||
      s.nama_pemilik.toLowerCase().includes(searchQuery.toLowerCase()) ||
      s.desa.toLowerCase().includes(searchQuery.toLowerCase()) ||
      s.jenis_usaha.toLowerCase().includes(searchQuery.toLowerCase())
    );
  });

  return (
    <div className="flex min-h-screen bg-slate-50 text-slate-800 text-left">
      {/* SIDEBAR - hidden on print */}
      <aside className="w-[280px] bg-[#0F172A] text-slate-300 flex flex-col py-6 px-4 shrink-0 border-r border-slate-800 print:hidden">
        {/* Header/Logo */}
        <div className="flex items-center gap-3 px-3 mb-10">
          <img 
            src="/logo-icon.png" 
            alt="SIPANDA Logo" 
            className="w-10 h-10 object-contain rounded-full bg-white p-0.5 border border-slate-700 shadow-sm"
          />
          <div>
            <span className="block text-white font-extrabold text-base tracking-wider leading-tight">SIPANDA</span>
            <span className="text-[10px] text-slate-500 font-semibold uppercase tracking-widest">Kec. Cicalengka</span>
          </div>
        </div>

        {/* Navigation */}
        <nav className="flex-grow space-y-1">
          <button
            onClick={() => { setSubTab('dashboard'); setSelectedSub(null); }}
            className={`w-full flex items-center gap-4 px-4 py-3.5 rounded-xl font-bold text-sm transition-all cursor-pointer ${
              subTab === 'dashboard' 
                ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/15' 
                : 'hover:bg-slate-800/60 text-slate-400 hover:text-slate-200'
            }`}
          >
            <LayoutDashboard className="w-5 h-5" />
            <span>Dashboard</span>
          </button>

          <button
            onClick={() => { setSubTab('pengajuan'); setSelectedSub(null); setSearchQuery(''); setStatusFilter('Semua'); }}
            className={`w-full flex items-center gap-4 px-4 py-3.5 rounded-xl font-bold text-sm transition-all cursor-pointer ${
              subTab === 'pengajuan' 
                ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/15' 
                : 'hover:bg-slate-800/60 text-slate-400 hover:text-slate-200'
            }`}
          >
            <FileText className="w-5 h-5" />
            <div className="flex justify-between items-center flex-grow">
              <span>Pengajuan</span>
              {pendingCount > 0 && (
                <span className="text-[10px] font-extrabold bg-amber-500 text-slate-950 px-2 py-0.5 rounded-full">
                  {pendingCount}
                </span>
              )}
            </div>
          </button>

          <button
            onClick={() => { setSubTab('umkm'); setSelectedSub(null); setSearchQuery(''); }}
            className={`w-full flex items-center gap-4 px-4 py-3.5 rounded-xl font-bold text-sm transition-all cursor-pointer ${
              subTab === 'umkm' 
                ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/15' 
                : 'hover:bg-slate-800/60 text-slate-400 hover:text-slate-200'
            }`}
          >
            <Store className="w-5 h-5" />
            <span>UMKM Terdaftar</span>
          </button>

          <button
            onClick={() => { setSubTab('laporan'); setSelectedSub(null); }}
            className={`w-full flex items-center gap-4 px-4 py-3.5 rounded-xl font-bold text-sm transition-all cursor-pointer ${
              subTab === 'laporan' 
                ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/15' 
                : 'hover:bg-slate-800/60 text-slate-400 hover:text-slate-200'
            }`}
          >
            <Printer className="w-5 h-5" />
            <span>Laporan (Siap Cetak)</span>
          </button>

          <div className="pt-4 pb-2 border-t border-slate-800/60 my-4">
            <span className="px-4 text-[10px] text-slate-500 font-bold tracking-widest uppercase">KODE LARAVEL</span>
          </div>

          <button
            onClick={() => { setSubTab('laravel'); setSelectedSub(null); }}
            className={`w-full flex items-center gap-4 px-4 py-3.5 rounded-xl font-bold text-sm transition-all cursor-pointer ${
              subTab === 'laravel' 
                ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/15' 
                : 'hover:bg-slate-800/60 text-slate-400 hover:text-slate-200'
            }`}
          >
            <Code className="w-5 h-5" />
            <span>Laravel Assets</span>
          </button>
        </nav>

        {/* Footer info & Logout */}
        <div className="pt-6 border-t border-slate-800">
          <div className="flex items-center gap-3 px-3 mb-4">
            <div className="w-8 h-8 rounded-full bg-slate-800 text-white flex items-center justify-center font-bold text-xs uppercase">
              AD
            </div>
            <div>
              <span className="block text-xs font-bold text-white">Administrator</span>
              <span className="text-[10px] text-slate-500 font-medium">Seksi PM Cicalengka</span>
            </div>
          </div>
          <button
            onClick={onLogout}
            className="w-full flex items-center gap-4 px-4 py-3 rounded-xl font-semibold text-xs text-red-400 hover:text-red-300 hover:bg-red-500/10 transition-all cursor-pointer"
          >
            <LogOut className="w-4 h-4" />
            <span>Keluar Sistem</span>
          </button>
        </div>
      </aside>

      {/* MAIN CONTAINER */}
      <div className="flex-grow flex flex-col min-h-screen overflow-x-hidden">
        {/* HEADER - hidden on print */}
        <header className="h-16 bg-white border-b border-slate-200 px-8 flex justify-between items-center shrink-0 print:hidden">
          <div className="flex items-center gap-2">
            <span className="text-xs font-bold text-slate-400 uppercase tracking-widest">Admin Panel</span>
            <span className="text-slate-300">/</span>
            <span className="text-xs font-bold text-slate-800 capitalize">{subTab}</span>
          </div>
          <div className="text-xs text-slate-400 font-bold">
            {new Date().toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })}
          </div>
        </header>

        {/* CONTENT */}
        <main className="p-6 md:p-8 flex-grow">
          {/* 1. DASHBOARD VIEW */}
          {subTab === 'dashboard' && (
            <div className="space-y-8 animate-fade-in print:hidden">
              <div className="space-y-1">
                <h2 className="text-3xl font-extrabold text-slate-900 tracking-tight">Selamat Datang, Admin!</h2>
                <p className="text-slate-500 text-sm">Berikut adalah ringkasan data pengajuan dan pendataan UMKM Kecamatan Cicalengka.</p>
              </div>

              {/* Stats Counters Grid */}
              <div className="grid grid-cols-2 lg:grid-cols-6 gap-4">
                <div className="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm text-left">
                  <span className="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Total Masuk</span>
                  <span className="text-2xl font-extrabold text-[#0F172A] block mt-1">{totalSubmissions}</span>
                </div>
                <div className="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm text-left border-l-4 border-l-amber-500">
                  <span className="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Menunggu</span>
                  <span className="text-2xl font-extrabold text-amber-600 block mt-1">{pendingCount}</span>
                </div>
                <div className="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm text-left border-l-4 border-l-orange-500">
                  <span className="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Perlu Perbaikan</span>
                  <span className="text-2xl font-extrabold text-orange-600 block mt-1">{needRevisionCount}</span>
                </div>
                <div className="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm text-left border-l-4 border-l-emerald-500">
                  <span className="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Disetujui</span>
                  <span className="text-2xl font-extrabold text-emerald-600 block mt-1">{approvedCount}</span>
                </div>
                <div className="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm text-left border-l-4 border-l-red-500">
                  <span className="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Ditolak</span>
                  <span className="text-2xl font-extrabold text-red-600 block mt-1">{rejectedCount}</span>
                </div>
                <div className="bg-slate-900 text-white p-5 rounded-2xl shadow-sm text-left">
                  <span className="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Total Terdaftar</span>
                  <span className="text-2xl font-extrabold text-emerald-400 block mt-1">{totalRegistered}</span>
                </div>
              </div>

              {/* Submissions Section */}
              <div className="grid grid-cols-1 gap-6">
                <div className="bg-white border border-slate-200 rounded-3xl shadow-sm p-6 space-y-4">
                  <div className="flex justify-between items-center border-b border-slate-100 pb-4">
                    <h3 className="font-extrabold text-slate-900 text-base">Daftar Pengajuan Terbaru</h3>
                    <button
                      onClick={() => setSubTab('pengajuan')}
                      className="text-xs font-bold text-blue-600 hover:text-blue-800 flex items-center gap-1 cursor-pointer"
                    >
                      <span>Lihat Semua</span>
                      <ChevronRight className="w-4 h-4" />
                    </button>
                  </div>

                  <div className="overflow-x-auto">
                    <table className="w-full text-sm text-left">
                      <thead>
                        <tr className="border-b border-slate-200 text-slate-400 font-bold text-xs uppercase tracking-wider">
                          <th className="py-3 px-4">No Pengajuan</th>
                          <th className="py-3 px-4">Nama Usaha</th>
                          <th className="py-3 px-4">Pemilik</th>
                          <th className="py-3 px-4">Tanggal Masuk</th>
                          <th className="py-3 px-4">Status</th>
                          <th className="py-3 px-4 text-right">Aksi</th>
                        </tr>
                      </thead>
                      <tbody className="divide-y divide-slate-100">
                        {submissions.slice(0, 5).map((sub) => (
                          <tr key={sub.id} className="hover:bg-slate-50/50">
                            <td className="py-3 px-4 font-mono font-bold text-[#0F172A]">{sub.nomor_pengajuan}</td>
                            <td className="py-3 px-4 font-semibold text-slate-800">{sub.nama_usaha}</td>
                            <td className="py-3 px-4 text-slate-600">{sub.nama_pemilik}</td>
                            <td className="py-3 px-4 text-slate-500 text-xs">{sub.tanggal_pengajuan}</td>
                            <td className="py-3 px-4">
                              <span className={`px-2.5 py-0.5 rounded-full border text-[10px] font-bold ${
                                sub.status === 'Disetujui' ? 'bg-emerald-50 text-emerald-800 border-emerald-100' :
                                sub.status === 'Perlu Perbaikan' ? 'bg-orange-50 text-orange-800 border-orange-100' :
                                sub.status === 'Ditolak' ? 'bg-red-50 text-red-800 border-red-100' :
                                'bg-amber-50 text-amber-800 border-amber-100'
                              }`}>
                                {sub.status}
                              </span>
                            </td>
                            <td className="py-3 px-4 text-right">
                              <button
                                onClick={() => { setSubTab('pengajuan'); handleSelectSubmission(sub); }}
                                className="text-xs font-bold text-blue-600 hover:text-blue-800 cursor-pointer"
                              >
                                Detail / Verifikasi
                              </button>
                            </td>
                          </tr>
                        ))}
                        {submissions.length === 0 && (
                          <tr>
                            <td colSpan={6} className="text-center py-8 text-slate-400 text-xs">Belum ada pengajuan masuk.</td>
                          </tr>
                        )}
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          )}

          {/* 2. PENGAJUAN (ALL SUBMISSIONS) VIEW */}
          {subTab === 'pengajuan' && (
            <div className="space-y-6 animate-fade-in print:hidden">
              {!selectedSub ? (
                <div className="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm space-y-6">
                  {/* Header controls */}
                  <div className="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-slate-100 pb-4">
                    <div className="space-y-1">
                      <h3 className="font-extrabold text-slate-900 text-lg">Kelola Berkas Pengajuan</h3>
                      <p className="text-slate-400 text-xs">Total {filteredSubmissions.length} pengajuan sesuai kriteria.</p>
                    </div>

                    <div className="flex flex-wrap gap-3">
                      {/* Search */}
                      <div className="relative">
                        <input
                          type="text"
                          placeholder="Cari nama, No, desa..."
                          value={searchQuery}
                          onChange={(e) => setSearchQuery(e.target.value)}
                          className="pl-9 pr-4 py-2 border border-slate-200 bg-slate-50 rounded-xl text-xs focus:bg-white outline-none focus:ring-2 focus:ring-blue-600/20"
                        />
                        <Search className="w-3.5 h-3.5 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" />
                      </div>

                      {/* Filter */}
                      <div className="flex items-center gap-1.5 border border-slate-200 bg-slate-50 rounded-xl px-3 py-1.5 text-xs">
                        <Filter className="w-3.5 h-3.5 text-slate-400" />
                        <select
                          value={statusFilter}
                          onChange={(e) => setStatusFilter(e.target.value)}
                          className="bg-transparent border-none outline-none font-semibold text-slate-600 text-xs focus:ring-0 p-0"
                        >
                          <option value="Semua">Semua Status</option>
                          <option value="Menunggu Verifikasi">Menunggu Verifikasi</option>
                          <option value="Perlu Perbaikan">Perlu Perbaikan</option>
                          <option value="Disetujui">Disetujui</option>
                          <option value="Ditolak">Ditolak</option>
                        </select>
                      </div>
                    </div>
                  </div>

                  {/* Table */}
                  <div className="overflow-x-auto">
                    <table className="w-full text-sm text-left">
                      <thead>
                        <tr className="border-b border-slate-200 text-slate-400 font-bold text-xs uppercase tracking-wider">
                          <th className="py-3 px-4">No Pengajuan</th>
                          <th className="py-3 px-4">Nama Usaha</th>
                          <th className="py-3 px-4">Jenis</th>
                          <th className="py-3 px-4">Pemilik</th>
                          <th className="py-3 px-4">Desa</th>
                          <th className="py-3 px-4">Tanggal Masuk</th>
                          <th className="py-3 px-4">Status</th>
                          <th className="py-3 px-4 text-right">Aksi</th>
                        </tr>
                      </thead>
                      <tbody className="divide-y divide-slate-100">
                        {filteredSubmissions.map((sub) => (
                          <tr key={sub.id} className="hover:bg-slate-50/50">
                            <td className="py-3 px-4 font-mono font-bold text-[#0F172A]">{sub.nomor_pengajuan}</td>
                            <td className="py-3 px-4 font-semibold text-slate-800">{sub.nama_usaha}</td>
                            <td className="py-3 px-4 text-slate-500 text-xs">{sub.jenis_usaha}</td>
                            <td className="py-3 px-4 text-slate-600">{sub.nama_pemilik}</td>
                            <td className="py-3 px-4 text-slate-500 text-xs">{sub.desa}</td>
                            <td className="py-3 px-4 text-slate-500 text-xs">{sub.tanggal_pengajuan}</td>
                            <td className="py-3 px-4">
                              <span className={`px-2.5 py-0.5 rounded-full border text-[10px] font-bold ${
                                sub.status === 'Disetujui' ? 'bg-emerald-50 text-emerald-800 border-emerald-100' :
                                sub.status === 'Perlu Perbaikan' ? 'bg-orange-50 text-orange-800 border-orange-100' :
                                sub.status === 'Ditolak' ? 'bg-red-50 text-red-800 border-red-100' :
                                'bg-amber-50 text-amber-800 border-amber-100'
                              }`}>
                                {sub.status}
                              </span>
                            </td>
                            <td className="py-3 px-4 text-right">
                              <button
                                onClick={() => handleSelectSubmission(sub)}
                                className="px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 hover:text-blue-700 rounded-lg text-xs font-bold cursor-pointer transition-all"
                              >
                                Detail & Verifikasi
                              </button>
                            </td>
                          </tr>
                        ))}
                        {filteredSubmissions.length === 0 && (
                          <tr>
                            <td colSpan={8} className="text-center py-12 text-slate-400 text-xs">Tidak ada data pengajuan yang cocok dengan kriteria pencarian.</td>
                          </tr>
                        )}
                      </tbody>
                    </table>
                  </div>
                </div>
              ) : (
                /* Verification details pane */
                <motion.div 
                  initial={{ opacity: 0, scale: 0.98 }}
                  animate={{ opacity: 1, scale: 1 }}
                  className="grid grid-cols-1 lg:grid-cols-12 gap-6"
                >
                  {/* Left Column: Details & Photo */}
                  <div className="lg:col-span-7 bg-white p-6 md:p-8 rounded-3xl border border-slate-200 shadow-sm space-y-6">
                    <div className="flex justify-between items-center border-b border-slate-100 pb-4">
                      <div className="space-y-1">
                        <button
                          onClick={() => setSelectedSub(null)}
                          className="text-xs font-bold text-slate-400 hover:text-slate-800 flex items-center gap-1 mb-1 cursor-pointer"
                        >
                          <ChevronRight className="w-4 h-4 rotate-180" />
                          <span>Kembali ke List</span>
                        </button>
                        <h3 className="font-extrabold text-slate-900 text-lg">Detail Pengajuan Berkas</h3>
                      </div>
                      <span className="font-mono text-sm bg-slate-100 border border-slate-200 px-3 py-1 rounded-xl font-bold">
                        {selectedSub.nomor_pengajuan}
                      </span>
                    </div>

                    <div className="grid grid-cols-1 md:grid-cols-2 gap-6 text-left">
                      <div className="flex gap-3">
                        <User className="w-5 h-5 text-slate-400 shrink-0 mt-0.5" />
                        <div>
                          <span className="block text-[10px] font-bold text-slate-400 uppercase">Nama Lengkap Pemilik</span>
                          <span className="text-sm font-bold text-slate-800">{selectedSub.nama_pemilik}</span>
                        </div>
                      </div>

                      <div className="flex gap-3">
                        <Phone className="w-5 h-5 text-slate-400 shrink-0 mt-0.5" />
                        <div>
                          <span className="block text-[10px] font-bold text-slate-400 uppercase">No Telepon (WA)</span>
                          <span className="text-sm font-bold text-slate-800 select-all">{selectedSub.nomor_telepon}</span>
                        </div>
                      </div>

                      <div className="flex gap-3">
                        <Store className="w-5 h-5 text-slate-400 shrink-0 mt-0.5" />
                        <div>
                          <span className="block text-[10px] font-bold text-slate-400 uppercase">Nama Usaha / Merk Dagang</span>
                          <span className="text-sm font-bold text-slate-800">{selectedSub.nama_usaha}</span>
                        </div>
                      </div>

                      <div className="flex gap-3">
                        <FileText className="w-5 h-5 text-slate-400 shrink-0 mt-0.5" />
                        <div>
                          <span className="block text-[10px] font-bold text-slate-400 uppercase">Kategori Jenis Usaha</span>
                          <span className="text-sm font-bold text-slate-800">{selectedSub.jenis_usaha}</span>
                        </div>
                      </div>

                      <div className="flex gap-3">
                        <MapPin className="w-5 h-5 text-slate-400 shrink-0 mt-0.5" />
                        <div>
                          <span className="block text-[10px] font-bold text-slate-400 uppercase">Desa Domisili</span>
                          <span className="text-sm font-bold text-slate-800">Desa {selectedSub.desa}</span>
                        </div>
                      </div>

                      <div className="flex gap-3">
                        <Calendar className="w-5 h-5 text-slate-400 shrink-0 mt-0.5" />
                        <div>
                          <span className="block text-[10px] font-bold text-slate-400 uppercase">Tanggal Mengajukan</span>
                          <span className="text-sm font-bold text-slate-800">{selectedSub.tanggal_pengajuan}</span>
                        </div>
                      </div>

                      <div className="flex gap-3 md:col-span-2">
                        <MapPin className="w-5 h-5 text-slate-400 shrink-0 mt-0.5" />
                        <div>
                          <span className="block text-[10px] font-bold text-slate-400 uppercase">Alamat Lengkap Domisili Usaha</span>
                          <span className="text-sm text-slate-700 leading-relaxed">{selectedSub.alamat_lengkap}</span>
                        </div>
                      </div>

                      <div className="flex gap-3 md:col-span-2">
                        <FileText className="w-5 h-5 text-slate-400 shrink-0 mt-0.5" />
                        <div>
                          <span className="block text-[10px] font-bold text-slate-400 uppercase">Deskripsi Usaha</span>
                          <p className="text-sm text-slate-600 leading-relaxed bg-slate-50 p-3 rounded-xl border border-slate-200/50 mt-1">
                            {selectedSub.deskripsi_usaha || 'Tidak ada deskripsi usaha.'}
                          </p>
                        </div>
                      </div>
                    </div>

                    {/* Photo */}
                    <div className="space-y-3 pt-2 text-left">
                      <span className="text-[10px] font-bold text-slate-400 uppercase block">Dokumentasi Foto Usaha / Produk</span>
                      <div className="max-w-md rounded-2xl overflow-hidden border border-slate-200">
                        <img 
                          src={selectedSub.foto_usaha} 
                          alt="Dokumentasi" 
                          className="w-full h-64 object-cover"
                        />
                      </div>
                    </div>
                  </div>

                  {/* Right Column: Verification Actions */}
                  <div className="lg:col-span-5 bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-6 self-start text-left">
                    <h3 className="font-extrabold text-slate-900 text-base border-b border-slate-100 pb-4">Tindakan Verifikator</h3>

                    {/* Radio state selectors */}
                    <div className="space-y-3">
                      <label className="text-xs font-bold text-slate-500 uppercase tracking-wide">Pilih Status Validasi:</label>
                      <div className="space-y-2">
                        <button
                          onClick={() => setActionStatus('Disetujui')}
                          className={`w-full flex items-center justify-between p-4 rounded-xl border font-bold text-xs transition-all cursor-pointer ${
                            actionStatus === 'Disetujui'
                              ? 'bg-emerald-50 border-emerald-500 text-emerald-800 ring-2 ring-emerald-500/20'
                              : 'border-slate-200 hover:bg-slate-50 text-slate-700'
                          }`}
                        >
                          <div className="flex items-center gap-3">
                            <span className="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                            <span>Disetujui (Terbit Registrasi)</span>
                          </div>
                          {actionStatus === 'Disetujui' && <Check className="w-4 h-4 text-emerald-600" />}
                        </button>

                        <button
                          onClick={() => setActionStatus('Perlu Perbaikan')}
                          className={`w-full flex items-center justify-between p-4 rounded-xl border font-bold text-xs transition-all cursor-pointer ${
                            actionStatus === 'Perlu Perbaikan'
                              ? 'bg-orange-50 border-orange-500 text-orange-800 ring-2 ring-orange-500/20'
                              : 'border-slate-200 hover:bg-slate-50 text-slate-700'
                          }`}
                        >
                          <div className="flex items-center gap-3">
                            <span className="w-2.5 h-2.5 rounded-full bg-orange-500"></span>
                            <span>Perlu Perbaikan Berkas</span>
                          </div>
                          {actionStatus === 'Perlu Perbaikan' && <Check className="w-4 h-4 text-orange-600" />}
                        </button>

                        <button
                          onClick={() => setActionStatus('Ditolak')}
                          className={`w-full flex items-center justify-between p-4 rounded-xl border font-bold text-xs transition-all cursor-pointer ${
                            actionStatus === 'Ditolak'
                              ? 'bg-red-50 border-red-500 text-red-800 ring-2 ring-red-500/20'
                              : 'border-slate-200 hover:bg-slate-50 text-slate-700'
                          }`}
                        >
                          <div className="flex items-center gap-3">
                            <span className="w-2.5 h-2.5 rounded-full bg-red-500"></span>
                            <span>Tolak Berkas (Gugur)</span>
                          </div>
                          {actionStatus === 'Ditolak' && <Check className="w-4 h-4 text-red-600" />}
                        </button>
                      </div>
                    </div>

                    {/* Text notes */}
                    <div className="space-y-1.5">
                      <label className="text-xs font-bold text-slate-500 uppercase tracking-wide">
                        Catatan Khusus Admin / Alasan Perbaikan:
                      </label>
                      <textarea
                        rows={5}
                        value={adminNotes}
                        onChange={(e) => setAdminNotes(e.target.value)}
                        placeholder="Tulis instruksi perbaikan yang jelas, atau alasan penolakan berkas untuk dibaca oleh pelaku UMKM..."
                        className="w-full bg-slate-50 text-slate-800 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:bg-white outline-none focus:ring-2 focus:ring-blue-600/20 resize-none"
                      />
                    </div>

                    {/* Action trigger */}
                    <button
                      id="btn-admin-simpan-verifikasi"
                      onClick={handleSaveVerification}
                      disabled={isSaving || !actionStatus}
                      className="w-full py-4 bg-[#0F172A] hover:bg-slate-800 text-white font-bold rounded-xl text-sm transition-all shadow-md flex items-center justify-center gap-2 cursor-pointer disabled:opacity-50"
                    >
                      {isSaving ? 'Menyimpan...' : 'Simpan Keputusan Verifikasi'}
                    </button>
                  </div>
                </motion.div>
              )}
            </div>
          )}

          {/* 3. UMKM TERDAFTAR VIEW */}
          {subTab === 'umkm' && (
            <div className="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm space-y-6 animate-fade-in print:hidden">
              <div className="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-slate-100 pb-4">
                <div className="space-y-1 text-left">
                  <h3 className="font-extrabold text-slate-900 text-lg">UMKM Terdaftar Resmi</h3>
                  <p className="text-slate-400 text-xs">Menyimpan data pengajuan berstatus 'Disetujui' di Cicalengka.</p>
                </div>

                {/* Search */}
                <div className="relative">
                  <input
                    type="text"
                    placeholder="Cari UMKM, pemilik..."
                    value={searchQuery}
                    onChange={(e) => setSearchQuery(e.target.value)}
                    className="pl-9 pr-4 py-2 border border-slate-200 bg-slate-50 rounded-xl text-xs focus:bg-white outline-none"
                  />
                  <Search className="w-3.5 h-3.5 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" />
                </div>
              </div>

              {/* Grid / Table */}
              <div className="overflow-x-auto text-left">
                <table className="w-full text-sm">
                  <thead>
                    <tr className="border-b border-slate-200 text-slate-400 font-bold text-xs uppercase tracking-wider">
                      <th className="py-3 px-4">No Reg</th>
                      <th className="py-3 px-4">Nama Usaha</th>
                      <th className="py-3 px-4">Kategori</th>
                      <th className="py-3 px-4">Pemilik</th>
                      <th className="py-3 px-4">Kontak</th>
                      <th className="py-3 px-4">Desa</th>
                      <th className="py-3 px-4">Alamat</th>
                    </tr>
                  </thead>
                  <tbody className="divide-y divide-slate-100">
                    {filteredRegistered.map((u) => (
                      <tr key={u.id} className="hover:bg-slate-50/50">
                        <td className="py-3 px-4 font-mono font-bold text-[#0F172A]">{u.nomor_pengajuan}</td>
                        <td className="py-3 px-4 font-bold text-slate-800">{u.nama_usaha}</td>
                        <td className="py-3 px-4 text-xs font-semibold bg-slate-100 rounded border border-slate-200 px-2.5 py-0.5 inline-block my-2.5">{u.jenis_usaha}</td>
                        <td className="py-3 px-4 text-slate-700">{u.nama_pemilik}</td>
                        <td className="py-3 px-4 font-mono text-xs text-blue-600 select-all">{u.nomor_telepon}</td>
                        <td className="py-3 px-4 text-slate-500 font-semibold">{u.desa}</td>
                        <td className="py-3 px-4 text-slate-400 text-xs max-w-xs truncate">{u.alamat_lengkap}</td>
                      </tr>
                    ))}
                    {filteredRegistered.length === 0 && (
                      <tr>
                        <td colSpan={7} className="text-center py-12 text-slate-400 text-xs">Belum ada UMKM yang disetujui.</td>
                      </tr>
                    )}
                  </tbody>
                </table>
              </div>
            </div>
          )}

          {/* 4. LAPORAN (PRINT READY) VIEW */}
          {subTab === 'laporan' && (
            <div className="space-y-6">
              {/* Controls bar (hidden on print) */}
              <div className="bg-white border border-slate-200 p-6 rounded-3xl shadow-sm flex flex-col md:flex-row justify-between items-center gap-4 print:hidden">
                <div className="space-y-1 text-left">
                  <h3 className="font-extrabold text-slate-900 text-lg">Format Cetak Laporan Resmi</h3>
                  <p className="text-slate-400 text-xs">Telah diformat agar rapi dan pas untuk ukuran kertas cetak standard.</p>
                </div>
                <button
                  id="btn-admin-cetak"
                  onClick={handlePrint}
                  className="px-6 py-3 bg-[#0F172A] hover:bg-slate-800 text-white font-extrabold rounded-xl text-xs flex items-center gap-2 transition-all shadow-md cursor-pointer"
                >
                  <Printer className="w-4 h-4" />
                  <span>Cetak Laporan (PDF)</span>
                </button>
              </div>

              {/* Printable Area - styled for paper standard */}
              <div id="print-area" className="bg-white p-8 md:p-12 border border-slate-200 rounded-3xl shadow-sm space-y-8 text-left max-w-4xl mx-auto print:border-none print:shadow-none print:p-0">
                
                {/* Kop Surat */}
                <div className="flex items-center gap-6 border-b-4 border-double border-slate-800 pb-4 justify-center text-center">
                  <div className="w-16 h-16 shrink-0 flex items-center justify-center bg-slate-900 text-white rounded font-extrabold text-2xl print:bg-black">
                    CP
                  </div>
                  <div className="space-y-1">
                    <h2 className="text-xl font-extrabold tracking-wider text-slate-900 uppercase">PEMERINTAH KABUPATEN BANDUNG</h2>
                    <h1 className="text-2xl font-black tracking-widest text-slate-900 uppercase">KECAMATAN CICALENGKA</h1>
                    <p className="text-xs text-slate-500 font-semibold uppercase">SEKSI PEMBERDAYAAN MASYARAKAT</p>
                    <p className="text-[10px] text-slate-400 font-medium tracking-wide">Jl. Raya Cicalengka No.1, Cicalengka, Jawa Barat 40395</p>
                  </div>
                </div>

                {/* Judul Laporan */}
                <div className="text-center space-y-1">
                  <h3 className="text-base font-extrabold text-slate-900 uppercase tracking-wider underline">LAPORAN DATA UMKM KECAMATAN CICALENGKA</h3>
                  <p className="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Tahun {new Date().getFullYear()}</p>
                </div>

                {/* Report Table */}
                <div className="overflow-x-auto pt-4">
                  <table className="w-full text-xs text-left border-collapse border border-slate-300">
                    <thead>
                      <tr className="bg-slate-50 border-b border-slate-300 text-slate-800 font-bold uppercase tracking-wider">
                        <th className="py-2.5 px-3 border border-slate-300 text-center w-10">No</th>
                        <th className="py-2.5 px-3 border border-slate-300">No Registrasi</th>
                        <th className="py-2.5 px-3 border border-slate-300">Nama Usaha</th>
                        <th className="py-2.5 px-3 border border-slate-300">Nama Pemilik</th>
                        <th className="py-2.5 px-3 border border-slate-300">Desa</th>
                        <th className="py-2.5 px-3 border border-slate-300">Jenis Usaha</th>
                        <th className="py-2.5 px-3 border border-slate-300">Kontak</th>
                      </tr>
                    </thead>
                    <tbody className="divide-y divide-slate-300">
                      {registeredUmkm.map((u, idx) => (
                        <tr key={u.id} className="hover:bg-slate-50/20">
                          <td className="py-2 px-3 border border-slate-300 text-center font-bold">{idx + 1}</td>
                          <td className="py-2 px-3 border border-slate-300 font-mono font-bold">{u.nomor_pengajuan}</td>
                          <td className="py-2 px-3 border border-slate-300 font-bold text-slate-900">{u.nama_usaha}</td>
                          <td className="py-2 px-3 border border-slate-300">{u.nama_pemilik}</td>
                          <td className="py-2 px-3 border border-slate-300">{u.desa}</td>
                          <td className="py-2 px-3 border border-slate-300">{u.jenis_usaha}</td>
                          <td className="py-2 px-3 border border-slate-300 font-mono">{u.nomor_telepon}</td>
                        </tr>
                      ))}
                      {registeredUmkm.length === 0 && (
                        <tr>
                          <td colSpan={7} className="text-center py-6 text-slate-400 font-medium">Belum ada UMKM yang terdaftar di basis data resmi.</td>
                        </tr>
                      )}
                    </tbody>
                  </table>
                </div>

                {/* Tanda Tangan (Signature) Block */}
                <div className="flex justify-end pt-12">
                  <div className="text-center space-y-16 w-64">
                    <div>
                      <p className="text-xs">Cicalengka, {new Date().toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric' })}</p>
                      <p className="text-xs font-bold uppercase mt-1">Kepala Seksi Pemberdayaan Masyarakat</p>
                    </div>
                    <div>
                      <p className="text-xs font-bold tracking-wide uppercase underline">......................................................</p>
                      <p className="text-[10px] text-slate-400 font-semibold uppercase mt-0.5">NIP. .........................................</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          )}

          {/* 5. LARAVEL ASSETS VIEW */}
          {subTab === 'laravel' && (
            <div className="space-y-8 animate-fade-in text-left max-w-4xl mx-auto print:hidden">
              <div className="space-y-1">
                <h2 className="text-3xl font-extrabold text-slate-900 tracking-tight">Source Code Laravel & Blade</h2>
                <p className="text-slate-500 text-sm">Salin kode arsitektur database, model, controller, dan antarmuka Blade siap pakai untuk proyek Laravel Anda.</p>
              </div>

              {/* Asset blocks loop */}
              <div className="space-y-6">
                {/* Block 1: Migration */}
                <div className="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm space-y-4">
                  <div className="flex justify-between items-center border-b border-slate-100 pb-3">
                    <div>
                      <span className="text-[10px] text-emerald-600 font-extrabold uppercase tracking-widest block">DATABASE CONFIG</span>
                      <h3 className="font-extrabold text-slate-900 text-base">1. Migration (`create_submissions_and_registered_umkms_tables.php`)</h3>
                    </div>
                    <button
                      onClick={() => handleCopy(laravelAssets.migration, 'migration')}
                      className={`px-3.5 py-1.5 rounded-lg border text-xs font-bold flex items-center gap-1.5 transition-all cursor-pointer ${
                        copiedKey === 'migration'
                          ? 'bg-emerald-50 border-emerald-300 text-emerald-700'
                          : 'bg-slate-50 hover:bg-slate-100 border-slate-200 text-slate-600'
                      }`}
                    >
                      <Clipboard className="w-3.5 h-3.5" />
                      <span>{copiedKey === 'migration' ? 'Tersalin!' : 'Salin Kode'}</span>
                    </button>
                  </div>
                  <pre className="bg-slate-900 text-emerald-400 p-4 rounded-xl text-xs overflow-x-auto max-h-[300px] font-mono leading-relaxed">
                    {laravelAssets.migration}
                  </pre>
                </div>

                {/* Block 2: Submission Model */}
                <div className="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm space-y-4">
                  <div className="flex justify-between items-center border-b border-slate-100 pb-3">
                    <div>
                      <span className="text-[10px] text-emerald-600 font-extrabold uppercase tracking-widest block">ELOQUENT MODEL</span>
                      <h3 className="font-extrabold text-slate-900 text-base">2. Model Pengajuan (`App\Models\Submission.php`)</h3>
                    </div>
                    <button
                      onClick={() => handleCopy(laravelAssets.submissionModel, 'subModel')}
                      className={`px-3.5 py-1.5 rounded-lg border text-xs font-bold flex items-center gap-1.5 transition-all cursor-pointer ${
                        copiedKey === 'subModel'
                          ? 'bg-emerald-50 border-emerald-300 text-emerald-700'
                          : 'bg-slate-50 hover:bg-slate-100 border-slate-200 text-slate-600'
                      }`}
                    >
                      <Clipboard className="w-3.5 h-3.5" />
                      <span>{copiedKey === 'subModel' ? 'Tersalin!' : 'Salin Kode'}</span>
                    </button>
                  </div>
                  <pre className="bg-slate-900 text-emerald-400 p-4 rounded-xl text-xs overflow-x-auto max-h-[250px] font-mono leading-relaxed">
                    {laravelAssets.submissionModel}
                  </pre>
                </div>

                {/* Block 3: Registered UMKM Model */}
                <div className="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm space-y-4">
                  <div className="flex justify-between items-center border-b border-slate-100 pb-3">
                    <div>
                      <span className="text-[10px] text-emerald-600 font-extrabold uppercase tracking-widest block">ELOQUENT MODEL</span>
                      <h3 className="font-extrabold text-slate-900 text-base">3. Model Terdaftar (`App\Models\RegisteredUmkm.php`)</h3>
                    </div>
                    <button
                      onClick={() => handleCopy(laravelAssets.registeredModel, 'regModel')}
                      className={`px-3.5 py-1.5 rounded-lg border text-xs font-bold flex items-center gap-1.5 transition-all cursor-pointer ${
                        copiedKey === 'regModel'
                          ? 'bg-emerald-50 border-emerald-300 text-emerald-700'
                          : 'bg-slate-50 hover:bg-slate-100 border-slate-200 text-slate-600'
                      }`}
                    >
                      <Clipboard className="w-3.5 h-3.5" />
                      <span>{copiedKey === 'regModel' ? 'Tersalin!' : 'Salin Kode'}</span>
                    </button>
                  </div>
                  <pre className="bg-slate-900 text-emerald-400 p-4 rounded-xl text-xs overflow-x-auto max-h-[250px] font-mono leading-relaxed">
                    {laravelAssets.registeredModel}
                  </pre>
                </div>

                {/* Block 4: Web Routes */}
                <div className="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm space-y-4">
                  <div className="flex justify-between items-center border-b border-slate-100 pb-3">
                    <div>
                      <span className="text-[10px] text-emerald-600 font-extrabold uppercase tracking-widest block">SYSTEM ROUTING</span>
                      <h3 className="font-extrabold text-slate-900 text-base">4. Routing (`routes/web.php`)</h3>
                    </div>
                    <button
                      onClick={() => handleCopy(laravelAssets.routes, 'routes')}
                      className={`px-3.5 py-1.5 rounded-lg border text-xs font-bold flex items-center gap-1.5 transition-all cursor-pointer ${
                        copiedKey === 'routes'
                          ? 'bg-emerald-50 border-emerald-300 text-emerald-700'
                          : 'bg-slate-50 hover:bg-slate-100 border-slate-200 text-slate-600'
                      }`}
                    >
                      <Clipboard className="w-3.5 h-3.5" />
                      <span>{copiedKey === 'routes' ? 'Tersalin!' : 'Salin Kode'}</span>
                    </button>
                  </div>
                  <pre className="bg-slate-900 text-emerald-400 p-4 rounded-xl text-xs overflow-x-auto max-h-[300px] font-mono leading-relaxed">
                    {laravelAssets.routes}
                  </pre>
                </div>

                {/* Block 5: Controller */}
                <div className="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm space-y-4">
                  <div className="flex justify-between items-center border-b border-slate-100 pb-3">
                    <div>
                      <span className="text-[10px] text-emerald-600 font-extrabold uppercase tracking-widest block">BUSINESS LOGIC</span>
                      <h3 className="font-extrabold text-slate-900 text-base">5. Controller Utama (`App\Http\Controllers\UmkmController.php`)</h3>
                    </div>
                    <button
                      onClick={() => handleCopy(laravelAssets.controller, 'controller')}
                      className={`px-3.5 py-1.5 rounded-lg border text-xs font-bold flex items-center gap-1.5 transition-all cursor-pointer ${
                        copiedKey === 'controller'
                          ? 'bg-emerald-50 border-emerald-300 text-emerald-700'
                          : 'bg-slate-50 hover:bg-slate-100 border-slate-200 text-slate-600'
                      }`}
                    >
                      <Clipboard className="w-3.5 h-3.5" />
                      <span>{copiedKey === 'controller' ? 'Tersalin!' : 'Salin Kode'}</span>
                    </button>
                  </div>
                  <pre className="bg-slate-900 text-emerald-400 p-4 rounded-xl text-xs overflow-x-auto max-h-[400px] font-mono leading-relaxed">
                    {laravelAssets.controller}
                  </pre>
                </div>

                {/* Block 6: Blade Landing */}
                <div className="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm space-y-4">
                  <div className="flex justify-between items-center border-b border-slate-100 pb-3">
                    <div>
                      <span className="text-[10px] text-emerald-600 font-extrabold uppercase tracking-widest block">TEMPLATING & FRONTEND</span>
                      <h3 className="font-extrabold text-slate-900 text-base">6. Blade: Landing Page (`resources/views/landing.blade.php`)</h3>
                    </div>
                    <button
                      onClick={() => handleCopy(laravelAssets.bladeLanding, 'bladeLanding')}
                      className={`px-3.5 py-1.5 rounded-lg border text-xs font-bold flex items-center gap-1.5 transition-all cursor-pointer ${
                        copiedKey === 'bladeLanding'
                          ? 'bg-emerald-50 border-emerald-300 text-emerald-700'
                          : 'bg-slate-50 hover:bg-slate-100 border-slate-200 text-slate-600'
                      }`}
                    >
                      <Clipboard className="w-3.5 h-3.5" />
                      <span>{copiedKey === 'bladeLanding' ? 'Tersalin!' : 'Salin Kode'}</span>
                    </button>
                  </div>
                  <pre className="bg-slate-900 text-emerald-400 p-4 rounded-xl text-xs overflow-x-auto max-h-[300px] font-mono leading-relaxed">
                    {laravelAssets.bladeLanding}
                  </pre>
                </div>

                {/* Block 7: Blade Form */}
                <div className="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm space-y-4">
                  <div className="flex justify-between items-center border-b border-slate-100 pb-3">
                    <div>
                      <span className="text-[10px] text-emerald-600 font-extrabold uppercase tracking-widest block">TEMPLATING & FRONTEND</span>
                      <h3 className="font-extrabold text-slate-900 text-base">7. Blade: Form Pengajuan (`resources/views/form_pengajuan.blade.php`)</h3>
                    </div>
                    <button
                      onClick={() => handleCopy(laravelAssets.bladeForm, 'bladeForm')}
                      className={`px-3.5 py-1.5 rounded-lg border text-xs font-bold flex items-center gap-1.5 transition-all cursor-pointer ${
                        copiedKey === 'bladeForm'
                          ? 'bg-emerald-50 border-emerald-300 text-emerald-700'
                          : 'bg-slate-50 hover:bg-slate-100 border-slate-200 text-slate-600'
                      }`}
                    >
                      <Clipboard className="w-3.5 h-3.5" />
                      <span>{copiedKey === 'bladeForm' ? 'Tersalin!' : 'Salin Kode'}</span>
                    </button>
                  </div>
                  <pre className="bg-slate-900 text-emerald-400 p-4 rounded-xl text-xs overflow-x-auto max-h-[300px] font-mono leading-relaxed">
                    {laravelAssets.bladeForm}
                  </pre>
                </div>

                {/* Block 8: Blade Cek Status */}
                <div className="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm space-y-4">
                  <div className="flex justify-between items-center border-b border-slate-100 pb-3">
                    <div>
                      <span className="text-[10px] text-emerald-600 font-extrabold uppercase tracking-widest block">TEMPLATING & FRONTEND</span>
                      <h3 className="font-extrabold text-slate-900 text-base">8. Blade: Cek Status (`resources/views/cek_status.blade.php`)</h3>
                    </div>
                    <button
                      onClick={() => handleCopy(laravelAssets.bladeStatus, 'bladeStatus')}
                      className={`px-3.5 py-1.5 rounded-lg border text-xs font-bold flex items-center gap-1.5 transition-all cursor-pointer ${
                        copiedKey === 'bladeStatus'
                          ? 'bg-emerald-50 border-emerald-300 text-emerald-700'
                          : 'bg-slate-50 hover:bg-slate-100 border-slate-200 text-slate-600'
                      }`}
                    >
                      <Clipboard className="w-3.5 h-3.5" />
                      <span>{copiedKey === 'bladeStatus' ? 'Tersalin!' : 'Salin Kode'}</span>
                    </button>
                  </div>
                  <pre className="bg-slate-900 text-emerald-400 p-4 rounded-xl text-xs overflow-x-auto max-h-[300px] font-mono leading-relaxed">
                    {laravelAssets.bladeStatus}
                  </pre>
                </div>

                {/* Block 9: Blade Dashboard */}
                <div className="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm space-y-4">
                  <div className="flex justify-between items-center border-b border-slate-100 pb-3">
                    <div>
                      <span className="text-[10px] text-emerald-600 font-extrabold uppercase tracking-widest block">TEMPLATING & FRONTEND</span>
                      <h3 className="font-extrabold text-slate-900 text-base">9. Blade: Admin Dashboard (`resources/views/admin/dashboard.blade.php`)</h3>
                    </div>
                    <button
                      onClick={() => handleCopy(laravelAssets.bladeDashboard, 'bladeDashboard')}
                      className={`px-3.5 py-1.5 rounded-lg border text-xs font-bold flex items-center gap-1.5 transition-all cursor-pointer ${
                        copiedKey === 'bladeDashboard'
                          ? 'bg-emerald-50 border-emerald-300 text-emerald-700'
                          : 'bg-slate-50 hover:bg-slate-100 border-slate-200 text-slate-600'
                      }`}
                    >
                      <Clipboard className="w-3.5 h-3.5" />
                      <span>{copiedKey === 'bladeDashboard' ? 'Tersalin!' : 'Salin Kode'}</span>
                    </button>
                  </div>
                  <pre className="bg-slate-900 text-emerald-400 p-4 rounded-xl text-xs overflow-x-auto max-h-[300px] font-mono leading-relaxed">
                    {laravelAssets.bladeDashboard}
                  </pre>
                </div>
              </div>
            </div>
          )}
        </main>
      </div>
    </div>
  );
}
