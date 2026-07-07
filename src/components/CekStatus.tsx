import React, { useState } from 'react';
import { motion } from 'motion/react';
import { 
  Search, 
  FileText, 
  Clock, 
  CheckCircle, 
  AlertCircle, 
  XCircle, 
  ArrowRight,
  MapPin,
  Phone,
  Store,
  HelpCircle
} from 'lucide-react';
import { ActiveTab, Submission } from '../types';

interface CekStatusProps {
  onNavigate: (tab: ActiveTab) => void;
  onEditSubmission: (submission: Submission) => void;
}

export default function CekStatus({ onNavigate, onEditSubmission }: CekStatusProps) {
  const [searchNo, setSearchNo] = useState('');
  const [loading, setLoading] = useState(false);
  const [searched, setSearched] = useState(false);
  const [submission, setSubmission] = useState<Submission | null>(null);
  const [error, setError] = useState<string | null>(null);

  const handleSearch = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!searchNo.trim()) return;

    setLoading(true);
    setError(null);
    setSearched(true);
    setSubmission(null);

    try {
      const response = await fetch(`/api/submissions/${searchNo.trim()}`);
      if (response.ok) {
        const data = await response.json();
        setSubmission(data);
      } else {
        const errData = await response.json();
        setError(errData.message || 'Nomor pengajuan tidak ditemukan. Pastikan format nomor yang Anda ketik benar (Contoh: SPD-20240524-001).');
      }
    } catch (err) {
      setError('Terjadi kesalahan jaringan. Silakan coba beberapa saat lagi.');
    } finally {
      setLoading(false);
    }
  };

  const handleRepair = () => {
    if (submission) {
      onEditSubmission(submission);
      onNavigate('ajukan');
    }
  };

  const getStatusConfig = (status: string) => {
    switch (status) {
      case 'Menunggu Verifikasi':
        return {
          bg: 'bg-amber-50 dark:bg-amber-950/20 text-amber-800 dark:text-amber-450 border-amber-200 dark:border-amber-900/30',
          dot: 'bg-amber-500',
          title: 'Menunggu Verifikasi',
          icon: <Clock className="w-5 h-5 text-amber-600 dark:text-amber-400" />,
          desc: 'Pengajuan Anda telah berhasil kami terima dan sedang mengantre untuk diperiksa keselarasan dokumen oleh Seksi Pemberdayaan Masyarakat Kecamatan Cicalengka.'
        };
      case 'Perlu Perbaikan':
        return {
          bg: 'bg-orange-50 dark:bg-orange-950/20 text-orange-850 dark:text-orange-400 border-orange-200 dark:border-orange-900/30',
          dot: 'bg-orange-500',
          title: 'Perlu Perbaikan Data',
          icon: <AlertCircle className="w-5 h-5 text-orange-600 dark:text-orange-400" />,
          desc: 'Terdapat beberapa kesalahan pengisian berkas atau kualitas foto yang tidak jelas. Segera lakukan perbaikan sesuai dengan instruksi catatan admin di bawah ini.'
        };
      case 'Disetujui':
        return {
          bg: 'bg-emerald-50 dark:bg-emerald-950/20 text-emerald-800 dark:text-emerald-450 border-emerald-200 dark:border-emerald-900/30',
          dot: 'bg-emerald-500',
          title: 'Pengajuan Disetujui',
          icon: <CheckCircle className="w-5 h-5 text-emerald-600 dark:text-emerald-400" />,
          desc: 'Selamat! Data usaha Anda telah terverifikasi secara resmi dan kini telah masuk ke dalam basis data resmi UMKM Kecamatan Cicalengka.'
        };
      case 'Ditolak':
        return {
          bg: 'bg-red-50 dark:bg-red-950/20 text-red-800 dark:text-red-450 border-red-200 dark:border-red-900/30',
          dot: 'bg-red-500',
          title: 'Pengajuan Ditolak',
          icon: <XCircle className="w-5 h-5 text-red-600 dark:text-red-400" />,
          desc: 'Mohon maaf, berkas pengajuan Anda ditolak karena tidak memenuhi kriteria administrasi atau tidak berlokasi di area Kecamatan Cicalengka.'
        };
      default:
        return {
          bg: 'bg-slate-50 dark:bg-slate-800 text-slate-800 dark:text-slate-200 border-slate-200 dark:border-slate-700',
          dot: 'bg-slate-500',
          title: 'Tidak Diketahui',
          icon: <HelpCircle className="w-5 h-5 text-slate-600 dark:text-slate-400" />,
          desc: 'Status pengajuan tidak dapat diidentifikasi.'
        };
    }
  };

  const statusConfig = submission ? getStatusConfig(submission.status) : null;

  return (
    <div id="status-view" className="pt-24 pb-16 max-w-4xl mx-auto px-6 text-left">
      {/* Search Header Container */}
      <div className="bg-gradient-to-r from-[#0F172A] to-[#1E293B] text-white p-8 md:p-12 rounded-3xl shadow-lg border border-slate-800 space-y-6 mb-8 text-center relative overflow-hidden">
        <div className="absolute top-0 right-0 w-32 h-32 bg-blue-500/10 blur-2xl rounded-full transform translate-x-1/3 -translate-y-1/3"></div>
        
        <div className="max-w-2xl mx-auto space-y-2">
          <h1 className="text-3xl font-extrabold tracking-tight">Lacak Status Pengajuan Anda</h1>
          <p className="text-slate-400 text-sm md:text-base font-light">
            Masukkan nomor pengajuan unik yang Anda peroleh setelah mengirimkan formulir pendataan.
          </p>
        </div>

        <form onSubmit={handleSearch} className="max-w-lg mx-auto flex flex-col sm:flex-row gap-3">
          <div className="relative flex-grow">
            <input
              type="text"
              required
              value={searchNo}
              onChange={(e) => setSearchNo(e.target.value)}
              placeholder="Contoh: SPD-20240524-001"
              className="w-full bg-slate-900/60 border border-slate-700 rounded-xl pl-4 pr-4 py-4 text-white font-mono tracking-wider focus:outline-none focus:ring-2 focus:ring-blue-500/40 text-sm uppercase placeholder-slate-500"
            />
          </div>
          <button
            id="btn-status-cari"
            type="submit"
            disabled={loading}
            className="px-8 py-4 bg-blue-600 hover:bg-blue-500 text-white font-bold rounded-xl active:scale-95 transition-all text-sm flex items-center justify-center gap-2 cursor-pointer shadow-lg shadow-blue-500/20 disabled:opacity-50"
          >
            <Search className="w-4 h-4" />
            <span>{loading ? 'Mencari...' : 'Lacak Status'}</span>
          </button>
        </form>
      </div>

      {/* Loading indicator */}
      {loading && (
        <div className="py-12 flex flex-col items-center justify-center space-y-3">
          <div className="w-10 h-10 border-4 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
          <p className="text-sm font-semibold text-slate-500 dark:text-slate-400">Mencari data pengajuan...</p>
        </div>
      )}

      {/* No results or Error */}
      {searched && !loading && error && (
        <motion.div 
          initial={{ opacity: 0, y: 10 }}
          animate={{ opacity: 1, y: 0 }}
          className="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-8 shadow-sm text-center max-w-xl mx-auto space-y-4 transition-colors duration-300"
        >
          <div className="w-12 h-12 rounded-full bg-red-50 dark:bg-red-950/20 text-red-500 flex items-center justify-center mx-auto">
            <AlertCircle className="w-6 h-6" />
          </div>
          <div className="space-y-1">
            <h4 className="font-bold text-slate-900 dark:text-white text-lg">Pencarian Tidak Ditemukan</h4>
            <p className="text-slate-500 dark:text-slate-400 text-xs md:text-sm leading-relaxed max-w-sm mx-auto">
              {error}
            </p>
          </div>
          <div className="pt-2">
            <button
              onClick={() => onNavigate('ajukan')}
              className="text-xs font-bold text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 inline-flex items-center gap-1 cursor-pointer"
            >
              <span>Ingin melakukan pengajuan baru?</span>
              <ArrowRight className="w-3.5 h-3.5" />
            </button>
          </div>
        </motion.div>
      )}

      {/* Success result display */}
      {searched && !loading && submission && statusConfig && (
        <motion.div 
          initial={{ opacity: 0, y: 15 }}
          animate={{ opacity: 1, y: 0 }}
          className="space-y-6"
        >
          {/* Main Card */}
          <div className="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl shadow-sm p-6 md:p-8 space-y-8 transition-colors duration-300">
            {/* Header: No & Status */}
            <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 dark:border-slate-800 pb-6">
              <div className="space-y-1">
                <span className="text-[10px] text-slate-400 dark:text-slate-500 font-bold uppercase tracking-wider">ID PELACAKAN PENGAJUAN</span>
                <h3 className="text-2xl font-mono font-extrabold text-[#0F172A] dark:text-white">{submission.nomor_pengajuan}</h3>
              </div>
              
              <div className={`px-4 py-2 rounded-full border ${statusConfig.bg} font-bold text-xs flex items-center gap-2 self-start sm:self-center`}>
                <span className={`w-2 h-2 rounded-full ${statusConfig.dot}`}></span>
                <span>{statusConfig.title}</span>
              </div>
            </div>

            {/* Explanation box */}
            <div className="p-5 rounded-2xl bg-slate-50 dark:bg-slate-950/40 border border-slate-200/50 dark:border-slate-800/80 flex gap-4 text-left">
              <div className="mt-0.5 shrink-0">
                {statusConfig.icon}
              </div>
              <div className="space-y-1">
                <h4 className="font-bold text-slate-900 dark:text-white text-sm">Status: {statusConfig.title}</h4>
                <p className="text-slate-500 dark:text-slate-400 text-xs leading-relaxed">{statusConfig.desc}</p>
              </div>
            </div>

            {/* Verification specific alert if Needs repair or rejected */}
            {(submission.status === 'Perlu Perbaikan' || submission.status === 'Ditolak') && (
              <div className="p-6 bg-amber-50 dark:bg-amber-950/20 border border-amber-200 dark:border-amber-900/30 rounded-2xl space-y-3 text-left">
                <h4 className="font-extrabold text-amber-900 dark:text-amber-200 text-sm flex items-center gap-2">
                  <AlertCircle className="w-5 h-5 text-amber-600 dark:text-amber-400" />
                  <span>Catatan Khusus Verifikator Kecamatan:</span>
                </h4>
                <p className="text-slate-700 dark:text-slate-300 text-xs md:text-sm leading-relaxed whitespace-pre-line bg-white/60 dark:bg-slate-950/60 p-4 rounded-xl border border-amber-200/30 dark:border-amber-900/20">
                  {submission.catatan_admin || 'Tidak ada catatan khusus yang dilampirkan.'}
                </p>

                {submission.status === 'Perlu Perbaikan' && (
                  <div className="pt-2">
                    <button
                      id="btn-status-perbaiki"
                      onClick={handleRepair}
                      className="px-6 py-3 bg-[#EAB308] hover:bg-yellow-600 text-white font-extrabold rounded-xl text-xs flex items-center gap-2 transition-all shadow-md cursor-pointer hover:scale-[1.02] active:scale-95"
                    >
                      <FileText className="w-4 h-4" />
                      <span>Perbaiki & Kirim Ulang Data</span>
                    </button>
                  </div>
                )}
              </div>
            )}

            {/* Business info fields */}
            <div className="space-y-6">
              <h4 className="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest border-b border-slate-100 dark:border-slate-800 pb-2">Rincian Data yang Diinput</h4>
              
              <div className="grid grid-cols-1 md:grid-cols-2 gap-6 text-left">
                <div className="flex gap-3">
                  <Store className="w-5 h-5 text-slate-400 dark:text-slate-500 shrink-0 mt-0.5" />
                  <div>
                    <span className="block text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase">Nama Usaha</span>
                    <span className="text-sm font-bold text-slate-800 dark:text-white">{submission.nama_usaha}</span>
                  </div>
                </div>

                <div className="flex gap-3">
                  <FileText className="w-5 h-5 text-slate-400 dark:text-slate-500 shrink-0 mt-0.5" />
                  <div>
                    <span className="block text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase">Jenis Usaha</span>
                    <span className="text-sm font-bold text-slate-800 dark:text-white">{submission.jenis_usaha}</span>
                  </div>
                </div>

                <div className="flex gap-3">
                  <MapPin className="w-5 h-5 text-slate-400 dark:text-slate-500 shrink-0 mt-0.5" />
                  <div>
                    <span className="block text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase">Domisili Desa / Kelurahan</span>
                    <span className="text-sm font-bold text-slate-800 dark:text-white">Desa {submission.desa}</span>
                  </div>
                </div>

                <div className="flex gap-3">
                  <Clock className="w-5 h-5 text-slate-400 dark:text-slate-500 shrink-0 mt-0.5" />
                  <div>
                    <span className="block text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase">Tanggal Pengajuan</span>
                    <span className="text-sm font-bold text-slate-800 dark:text-white">{submission.tanggal_pengajuan}</span>
                  </div>
                </div>

                <div className="flex gap-3 md:col-span-2">
                  <MapPin className="w-5 h-5 text-slate-400 dark:text-slate-500 shrink-0 mt-0.5" />
                  <div>
                    <span className="block text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase">Alamat Lengkap Usaha</span>
                    <span className="text-sm text-slate-700 dark:text-slate-355 leading-relaxed">{submission.alamat_lengkap}</span>
                  </div>
                </div>
              </div>
            </div>

            {/* Attached photo preview */}
            {submission.foto_usaha && (
              <div className="space-y-3 text-left pt-2">
                <span className="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase block">Lampiran Dokumentasi Foto Usaha</span>
                <div className="max-w-md rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-800">
                  <img 
                    src={submission.foto_usaha} 
                    alt="Dokumentasi Usaha" 
                    className="w-full h-56 object-cover"
                  />
                </div>
              </div>
            )}
          </div>
        </motion.div>
      )}
    </div>
  );
}
