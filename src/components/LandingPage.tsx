import React from 'react';
import { motion } from 'motion/react';
import { 
  FileText, 
  ShieldCheck, 
  Search, 
  ArrowRight, 
  UserCheck, 
  ClipboardCheck, 
  AlertCircle, 
  Clock, 
  HelpCircle,
  MapPin,
  Compass
} from 'lucide-react';
import { ActiveTab } from '../types';

interface LandingPageProps {
  onNavigate: (tab: ActiveTab) => void;
  registeredCount: number;
}

export default function LandingPage({ onNavigate, registeredCount }: LandingPageProps) {
  return (
    <div id="home-view" className="pt-16 min-h-screen flex flex-col bg-[#F8FAFC] dark:bg-slate-950 transition-colors duration-300">
      {/* Hero Section */}
      <section className="relative overflow-hidden py-20 lg:py-32 bg-gradient-to-br from-[#0F172A] via-[#1E293B] to-[#334155] text-white">
        {/* Abstract background shape */}
        <div className="absolute top-0 right-0 w-1/3 h-full bg-[#3B82F6]/5 blur-3xl rounded-full transform translate-x-1/2 -translate-y-1/4"></div>
        <div className="absolute bottom-0 left-0 w-1/4 h-1/2 bg-[#10B981]/5 blur-3xl rounded-full transform -translate-x-1/4 translate-y-1/4"></div>

        <div className="max-w-7xl mx-auto px-6 md:px-10 relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
          <div className="lg:col-span-7 space-y-6 text-left">
            <motion.div 
              initial={{ opacity: 0, y: 15 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.5 }}
              className="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-blue-500/10 text-blue-300 font-medium text-xs md:text-sm border border-blue-500/20"
            >
              <Compass className="w-4 h-4 text-emerald-400 animate-pulse" />
              <span>Resmi: Seksi Pemberdayaan Masyarakat Kecamatan Cicalengka</span>
            </motion.div>

            <motion.h1 
              initial={{ opacity: 0, y: 15 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.5, delay: 0.1 }}
              className="text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight leading-tight"
            >
              SIPANDA <br />
              <span className="bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-emerald-400">
                Sistem Informasi Pengajuan & Pendataan UMKM
              </span>
            </motion.h1>

            <motion.p 
              initial={{ opacity: 0, y: 15 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.5, delay: 0.2 }}
              className="text-slate-300 text-base md:text-lg max-w-2xl font-light"
            >
              Media digital pendukung administrasi dan verifikasi data UMKM di wilayah Kecamatan Cicalengka. Daftarkan usaha Anda untuk pendataan resmi instansi pemerintahan.
            </motion.p>

            <motion.div 
              initial={{ opacity: 0, y: 15 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.5, delay: 0.3 }}
              className="flex flex-wrap gap-4 pt-4"
            >
              <button
                id="btn-hero-ajukan"
                onClick={() => onNavigate('ajukan')}
                className="px-8 py-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl font-bold shadow-lg shadow-blue-900/30 hover:from-blue-500 hover:to-blue-600 active:scale-95 transition-all flex items-center gap-2 cursor-pointer"
              >
                <FileText className="w-5 h-5" />
                <span>Ajukan Pendataan</span>
                <ArrowRight className="w-4 h-4" />
              </button>
              <button
                id="btn-hero-cek"
                onClick={() => onNavigate('cek-status')}
                className="px-8 py-4 bg-slate-800/80 hover:bg-slate-800 text-slate-100 border border-slate-700 rounded-xl font-bold active:scale-95 transition-all flex items-center gap-2 cursor-pointer"
              >
                <Search className="w-5 h-5" />
                <span>Cek Status Pengajuan</span>
              </button>
            </motion.div>

            {/* Quick counters */}
            <motion.div 
              initial={{ opacity: 0 }}
              animate={{ opacity: 1 }}
              transition={{ duration: 0.5, delay: 0.4 }}
              className="flex items-center gap-8 pt-6 border-t border-slate-800/80"
            >
              <div>
                <span className="block text-3xl font-extrabold text-blue-400">{registeredCount}</span>
                <span className="text-xs text-slate-400 uppercase tracking-wider font-semibold">UMKM Terverifikasi</span>
              </div>
              <div className="h-8 w-px bg-slate-800"></div>
              <div>
                <span className="block text-3xl font-extrabold text-emerald-400">11</span>
                <span className="text-xs text-slate-400 uppercase tracking-wider font-semibold">Desa Terjangkau</span>
              </div>
            </motion.div>
          </div>

          <motion.div 
            initial={{ opacity: 0, scale: 0.95 }}
            animate={{ opacity: 1, scale: 1 }}
            transition={{ duration: 0.6, delay: 0.2 }}
            className="lg:col-span-5 hidden lg:block"
          >
            <div className="relative p-2 bg-slate-800/40 rounded-3xl border border-slate-700/50 shadow-2xl">
              <img 
                src="https://images.unsplash.com/photo-1544816155-12df9643f363?w=600&auto=format&fit=crop&q=80" 
                alt="UMKM Cicalengka" 
                className="rounded-2xl object-cover w-full h-[400px] shadow-inner"
              />
              <div className="absolute -bottom-6 -left-6 bg-slate-900 border border-slate-800 p-4 rounded-2xl shadow-xl flex items-center gap-3">
                <div className="p-3 bg-emerald-500/10 text-emerald-400 rounded-xl">
                  <ShieldCheck className="w-6 h-6" />
                </div>
                <div>
                  <span className="block text-xs text-slate-400 font-medium">Sistem Pendataan</span>
                  <span className="text-sm font-bold text-white">100% Terverifikasi</span>
                </div>
              </div>
            </div>
          </motion.div>
        </div>
      </section>

      {/* About Section */}
      <section id="about" className="py-20 bg-white dark:bg-slate-900 transition-colors duration-300">
        <div className="max-w-7xl mx-auto px-6 md:px-10">
          <div className="text-center max-w-3xl mx-auto space-y-4 mb-16">
            <h2 className="text-xs font-bold text-blue-600 uppercase tracking-widest">Tentang SIPANDA</h2>
            <h3 className="text-3xl md:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">
              Pilar Administrasi UMKM Kecamatan Cicalengka
            </h3>
            <div className="w-12 h-1 bg-blue-600 mx-auto rounded-full"></div>
            <p className="text-slate-600 dark:text-slate-400 leading-relaxed pt-2">
              SIPANDA dirancang sebagai media digital pendukung proses administrasi pengajuan dan pendataan UMKM, <strong className="text-slate-900 dark:text-white font-semibold">BUKAN sistem pendaftaran izin otomatis</strong>. Sistem ini membantu Seksi Pemberdayaan Masyarakat dalam memvalidasi data pelaku usaha secara tertib, akurat, dan transparan.
            </p>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div className="p-8 rounded-2xl bg-[#F8FAFC] dark:bg-slate-800/50 border border-slate-200/60 dark:border-slate-700/60 hover:border-blue-500/30 dark:hover:border-blue-500/50 transition-all shadow-sm space-y-4 text-left">
              <div className="w-12 h-12 rounded-xl bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center">
                <FileText className="w-6 h-6" />
              </div>
              <h4 className="text-lg font-bold text-slate-900 dark:text-white">1. Pengajuan Mandiri</h4>
              <p className="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                Masyarakat dapat mengajukan pendataan usahanya secara mandiri dengan mengisi data pemilik, detail lokasi usaha, deskripsi produk, serta dokumentasi foto usaha.
              </p>
            </div>

            <div className="p-8 rounded-2xl bg-[#F8FAFC] dark:bg-slate-800/50 border border-slate-200/60 dark:border-slate-700/60 hover:border-blue-500/30 dark:hover:border-blue-500/50 transition-all shadow-sm space-y-4 text-left">
              <div className="w-12 h-12 rounded-xl bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 flex items-center justify-center">
                <UserCheck className="w-6 h-6" />
              </div>
              <h4 className="text-lg font-bold text-slate-900 dark:text-white">2. Verifikasi Manual Admin</h4>
              <p className="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                Setiap data yang masuk akan diperiksa secara detail oleh Admin Seksi Pemberdayaan Masyarakat Cicalengka guna memastikan kelayakan dan validitas administrasi.
              </p>
            </div>

            <div className="p-8 rounded-2xl bg-[#F8FAFC] dark:bg-slate-800/50 border border-slate-200/60 dark:border-slate-700/60 hover:border-blue-500/30 dark:hover:border-blue-500/50 transition-all shadow-sm space-y-4 text-left">
              <div className="w-12 h-12 rounded-xl bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 flex items-center justify-center">
                <ClipboardCheck className="w-6 h-6" />
              </div>
              <h4 className="text-lg font-bold text-slate-900 dark:text-white">3. Database Terpusat</h4>
              <p className="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                Usaha yang disetujui akan dimasukkan ke dalam basis data resmi UMKM Kecamatan Cicalengka, memudahkan program pembinaan dan monitoring berkala.
              </p>
            </div>
          </div>
        </div>
      </section>

      {/* Flow Section */}
      <section className="py-20 bg-slate-50 dark:bg-slate-950/40 border-y border-slate-200/80 dark:border-slate-800/80 transition-colors duration-300">
        <div className="max-w-7xl mx-auto px-6 md:px-10">
          <div className="text-center max-w-3xl mx-auto space-y-4 mb-16">
            <h2 className="text-xs font-bold text-blue-600 uppercase tracking-widest">Alur Sistem</h2>
            <h3 className="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">
              Bagaimana Alur Pengajuan Berjalan?
            </h3>
            <div className="w-12 h-1 bg-blue-600 mx-auto rounded-full"></div>
          </div>

          <div className="relative">
            {/* Connection line for desktop */}
            <div className="absolute top-1/2 left-0 right-0 h-0.5 bg-slate-200 dark:bg-slate-800 -translate-y-1/2 hidden lg:block z-0"></div>

            <div className="grid grid-cols-1 lg:grid-cols-4 gap-8 relative z-10">
              {/* Step 1 */}
              <div className="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200/80 dark:border-slate-800/80 shadow-sm space-y-4 relative">
                <div className="absolute -top-4 left-6 w-8 h-8 rounded-full bg-[#0F172A] dark:bg-slate-800 text-white flex items-center justify-center font-bold text-sm border border-white dark:border-slate-800 shadow-sm">
                  1
                </div>
                <div className="w-10 h-10 rounded-lg bg-blue-50 dark:bg-blue-950/40 text-blue-600 dark:text-blue-400 flex items-center justify-center font-bold">
                  <FileText className="w-5 h-5" />
                </div>
                <h4 className="font-bold text-slate-900 dark:text-white text-left">Pengisian Formulir</h4>
                <p className="text-xs text-slate-500 dark:text-slate-400 leading-relaxed text-left">
                  Pelaku UMKM mengunggah data identitas, informasi usaha, alamat detail, dan foto usaha secara lengkap di platform SIPANDA.
                </p>
              </div>

              {/* Step 2 */}
              <div className="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200/80 dark:border-slate-800/80 shadow-sm space-y-4 relative">
                <div className="absolute -top-4 left-6 w-8 h-8 rounded-full bg-[#0F172A] dark:bg-slate-800 text-white flex items-center justify-center font-bold text-sm border border-white dark:border-slate-800 shadow-sm">
                  2
                </div>
                <div className="w-10 h-10 rounded-lg bg-yellow-50 dark:bg-amber-950/40 text-yellow-600 dark:text-amber-400 flex items-center justify-center font-bold">
                  <Clock className="w-5 h-5" />
                </div>
                <h4 className="font-bold text-slate-900 dark:text-white text-left">Verifikasi Admin</h4>
                <p className="text-xs text-slate-500 dark:text-slate-400 leading-relaxed text-left">
                  Data pengajuan berstatus 'Menunggu Verifikasi'. Admin akan meninjau kelayakan data dan foto dokumentasi produk/lokasi.
                </p>
              </div>

              {/* Step 3 */}
              <div className="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200/80 dark:border-slate-800/80 shadow-sm space-y-4 relative">
                <div className="absolute -top-4 left-6 w-8 h-8 rounded-full bg-[#0F172A] dark:bg-slate-800 text-white flex items-center justify-center font-bold text-sm border border-white dark:border-slate-800 shadow-sm">
                  3
                </div>
                <div className="w-10 h-10 rounded-lg bg-orange-50 dark:bg-orange-950/40 text-orange-600 dark:text-orange-400 flex items-center justify-center font-bold">
                  <AlertCircle className="w-5 h-5" />
                </div>
                <h4 className="font-bold text-slate-900 dark:text-white text-left">Perbaikan Data</h4>
                <p className="text-xs text-slate-500 dark:text-slate-400 leading-relaxed text-left">
                  Bila data kurang lengkap, admin akan mengubah status menjadi 'Perlu Perbaikan' disertai catatan perbaikan yang dapat dipantau publik.
                </p>
              </div>

              {/* Step 4 */}
              <div className="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200/80 dark:border-slate-800/80 shadow-sm space-y-4 relative">
                <div className="absolute -top-4 left-6 w-8 h-8 rounded-full bg-[#0F172A] dark:bg-slate-800 text-white flex items-center justify-center font-bold text-sm border border-white dark:border-slate-800 shadow-sm">
                  4
                </div>
                <div className="w-10 h-10 rounded-lg bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 flex items-center justify-center font-bold">
                  <ShieldCheck className="w-5 h-5" />
                </div>
                <h4 className="font-bold text-slate-900 dark:text-white text-left">Selesai & Terdaftar</h4>
                <p className="text-xs text-slate-500 dark:text-slate-400 leading-relaxed text-left">
                  Pengajuan yang disetujui akan masuk ke database UMKM Terdaftar Kecamatan Cicalengka, dan siap dicetak sebagai laporan resmi.
                </p>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Requirements Section */}
      <section id="requirements" className="py-20 bg-white dark:bg-slate-900 transition-colors duration-300">
        <div className="max-w-7xl mx-auto px-6 md:px-10">
          <div className="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div className="space-y-6 text-left">
              <h2 className="text-xs font-bold text-blue-600 uppercase tracking-widest">Persyaratan Administrasi</h2>
              <h3 className="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                Dokumen & Informasi yang Diperlukan
              </h3>
              <p className="text-slate-600 dark:text-slate-400 leading-relaxed">
                Sebelum mengisi formulir SIPANDA, pastikan Anda telah menyiapkan dokumen dan informasi pendukung agar proses verifikasi berjalan lancar.
              </p>

              <div className="space-y-4 pt-2">
                <div className="flex gap-4 items-start">
                  <div className="mt-1 p-1 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg">
                    <UserCheck className="w-5 h-5" />
                  </div>
                  <div>
                    <h4 className="font-bold text-slate-900 dark:text-white">Identitas Pemilik Valid</h4>
                    <p className="text-sm text-slate-500 dark:text-slate-400">Nama lengkap sesuai KTP dan nomor telepon/WhatsApp yang aktif untuk koordinasi.</p>
                  </div>
                </div>

                <div className="flex gap-4 items-start">
                  <div className="mt-1 p-1 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg">
                    <MapPin className="w-5 h-5" />
                  </div>
                  <div>
                    <h4 className="font-bold text-slate-900 dark:text-white">Alamat Usaha di Cicalengka</h4>
                    <p className="text-sm text-slate-500 dark:text-slate-400">Usaha harus berlokasi fisik di salah satu dari 11 desa yang berada di wilayah Kecamatan Cicalengka.</p>
                  </div>
                </div>

                <div className="flex gap-4 items-start">
                  <div className="mt-1 p-1 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg">
                    <FileText className="w-5 h-5" />
                  </div>
                  <div>
                    <h4 className="font-bold text-slate-900 dark:text-white">Dokumentasi Produk / Tempat Usaha</h4>
                    <p className="text-sm text-slate-500 dark:text-slate-400">Foto fisik yang jelas dari produk utama atau tampak depan toko/tempat usaha Anda (maksimal 5MB).</p>
                  </div>
                </div>
              </div>
            </div>

            <div className="bg-slate-50 dark:bg-slate-800/40 border border-slate-200 dark:border-slate-850 rounded-3xl p-8 space-y-6 text-left">
              <h4 className="text-xl font-extrabold text-slate-900 dark:text-white flex items-center gap-2">
                <HelpCircle className="w-6 h-6 text-blue-600 dark:text-blue-400" />
                <span>Pertanyaan Sering Diajukan (FAQ)</span>
              </h4>
              <div className="space-y-4 divide-y divide-slate-200 dark:divide-slate-800">
                <div className="pt-4 first:pt-0">
                  <h5 className="font-bold text-slate-900 dark:text-white text-sm mb-1">Apakah sistem ini menerbitkan NIB?</h5>
                  <p className="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                    Tidak. SIPANDA adalah sistem pendataan internal Kecamatan Cicalengka untuk pembinaan UMKM, bukan platform perizinan nasional (OSS) yang menerbitkan NIB.
                  </p>
                </div>
                <div className="pt-4">
                  <h5 className="font-bold text-slate-900 dark:text-white text-sm mb-1">Berapa lama proses verifikasi dilakukan?</h5>
                  <p className="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                    Proses verifikasi oleh Seksi Pemberdayaan Masyarakat biasanya memakan waktu 1-3 hari kerja tergantung volume antrean pengajuan yang masuk.
                  </p>
                </div>
                <div className="pt-4">
                  <h5 className="font-bold text-slate-900 dark:text-white text-sm mb-1">Bagaimana jika status saya ditolak?</h5>
                  <p className="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                    Jika ditolak atau perlu perbaikan, Anda akan menerima catatan penjelas dari admin. Anda dapat mengirimkan ulang formulir perbaikan dengan merujuk nomor pengajuan awal.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  );
}
