import React, { useState, useRef, useEffect } from 'react';
import { motion } from 'motion/react';
import { 
  User, 
  Store, 
  MapPin, 
  Upload, 
  CheckCircle, 
  Send, 
  X, 
  AlertTriangle,
  Loader2,
  FileImage,
  ArrowLeft
} from 'lucide-react';
import { ActiveTab, Submission } from '../types';
import { dbService } from '../services/dbService';

interface FormPengajuanProps {
  onNavigate: (tab: ActiveTab) => void;
  editSubmission?: Submission | null;
  onClearEdit?: () => void;
}

const LIST_DESA = [
  "Babakan Peuteuy",
  "Cicalengka Kulon",
  "Cicalengka Wetan",
  "Cikuya",
  "Dampit",
  "Margaasih",
  "Nagrog",
  "Narawita",
  "Panenjoan",
  "Tanjungwangi",
  "Tenjolaya",
  "Waluya"
];

const JENIS_USAHA = [
  "Kuliner",
  "Fashion",
  "Kerajinan",
  "Jasa",
  "Pertanian / Perkebunan",
  "Perdagangan",
  "Lainnya"
];

export default function FormPengajuan({ onNavigate, editSubmission, onClearEdit }: FormPengajuanProps) {
  // Form fields
  const [namaPemilik, setNamaPemilik] = useState('');
  const [nomorTelepon, setNomorTelepon] = useState('');
  const [namaUsaha, setNamaUsaha] = useState('');
  const [jenisUsaha, setJenisUsaha] = useState('');
  const [deskripsiUsaha, setDeskripsiUsaha] = useState('');
  const [desa, setDesa] = useState('');
  const [alamatLengkap, setAlamatLengkap] = useState('');
  const [fotoUsaha, setFotoUsaha] = useState('');
  const [nib, setNib] = useState('');
  const [sertifikasiHalal, setSertifikasiHalal] = useState('');
  
  // UI states
  const [imagePreview, setImagePreview] = useState<string | null>(null);
  const [isDragging, setIsDragging] = useState(false);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState<string | null>(null);
  const [successData, setSuccessData] = useState<any | null>(null);
  
  const fileInputRef = useRef<HTMLInputElement>(null);

  // Load edit submission data if in repair mode
  useEffect(() => {
    if (editSubmission) {
      setNamaPemilik(editSubmission.nama_pemilik);
      setNomorTelepon(editSubmission.nomor_telepon);
      setNamaUsaha(editSubmission.nama_usaha);
      setJenisUsaha(editSubmission.jenis_usaha);
      setDeskripsiUsaha(editSubmission.deskripsi_usaha);
      setDesa(editSubmission.desa);
      setAlamatLengkap(editSubmission.alamat_lengkap);
      setFotoUsaha(editSubmission.foto_usaha);
      setImagePreview(editSubmission.foto_usaha);
      setNib(editSubmission.nib || '');
      setSertifikasiHalal(editSubmission.sertifikasi_halal || '');
    }
  }, [editSubmission]);

  // Convert uploaded image to base64
  const processFile = (file: File) => {
    if (!file.type.startsWith('image/')) {
      setError('Hanya file gambar yang diperbolehkan.');
      return;
    }
    if (file.size > 5 * 1024 * 1024) {
      setError('Ukuran file tidak boleh melebihi 5MB.');
      return;
    }

    const reader = new FileReader();
    reader.onload = () => {
      const base64String = reader.result as string;
      setFotoUsaha(base64String);
      setImagePreview(base64String);
      setError(null);
    };
    reader.onerror = () => {
      setError('Gagal membaca file gambar.');
    };
    reader.readAsDataURL(file);
  };

  const handleFileChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    if (e.target.files && e.target.files[0]) {
      processFile(e.target.files[0]);
    }
  };

  // Drag and drop handlers
  const handleDragOver = (e: React.DragEvent) => {
    e.preventDefault();
    setIsDragging(true);
  };

  const handleDragLeave = () => {
    setIsDragging(false);
  };

  const handleDrop = (e: React.DragEvent) => {
    e.preventDefault();
    setIsDragging(false);
    if (e.dataTransfer.files && e.dataTransfer.files[0]) {
      processFile(e.dataTransfer.files[0]);
    }
  };

  const removeImage = () => {
    setFotoUsaha('');
    setImagePreview(null);
  };

  const triggerFileInput = () => {
    fileInputRef.current?.click();
  };

  // Submit handler
  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setLoading(true);
    setError(null);

    if (!namaPemilik || !nomorTelepon || !namaUsaha || !jenisUsaha || !desa || !alamatLengkap) {
      setError('Mohon lengkapi semua bidang wajib bertanda bintang (*).');
      setLoading(false);
      return;
    }

    if (!fotoUsaha) {
      setError('Mohon unggah dokumentasi foto usaha atau produk.');
      setLoading(false);
      return;
    }

    try {
      const resData = await dbService.createSubmission({
        nama_pemilik: namaPemilik,
        nomor_telepon: nomorTelepon,
        nama_usaha: namaUsaha,
        jenis_usaha: jenisUsaha,
        deskripsi_usaha: deskripsiUsaha,
        desa,
        alamat_lengkap: alamatLengkap,
        foto_usaha: fotoUsaha,
        nib: nib,
        sertifikasi_halal: sertifikasiHalal
      });

      if (resData.success) {
        setSuccessData(resData.data);
        if (onClearEdit) onClearEdit(); // clear editing context
      } else {
        setError('Gagal mengirimkan pengajuan.');
      }
    } catch (err: any) {
      setError(err.message || 'Terjadi kesalahan jaringan. Silakan coba lagi.');
    } finally {
      setLoading(false);
    }
  };

  const handleBackToLanding = () => {
    if (onClearEdit) onClearEdit();
    onNavigate('home');
  };

  // Success screen
  if (successData) {
    return (
      <div className="pt-24 pb-16 max-w-2xl mx-auto px-6 text-center">
        <motion.div 
          initial={{ opacity: 0, scale: 0.95 }}
          animate={{ opacity: 1, scale: 1 }}
          className="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-8 md:p-12 shadow-xl space-y-6 text-center transition-colors duration-300"
        >
          <div className="mx-auto w-16 h-16 rounded-full bg-emerald-50 dark:bg-emerald-950/40 text-emerald-500 dark:text-emerald-400 flex items-center justify-center">
            <CheckCircle className="w-10 h-10" />
          </div>

          <div className="space-y-2">
            <h1 className="text-3xl font-extrabold text-slate-900 dark:text-white">Pengajuan Terkirim!</h1>
            <p className="text-sm text-slate-500 dark:text-slate-400 max-w-md mx-auto">
              Terima kasih, data usaha Anda telah tersimpan dalam sistem pengajuan Kecamatan Cicalengka.
            </p>
          </div>

          <div className="p-6 bg-blue-50/50 dark:bg-blue-950/20 rounded-2xl border border-blue-100/80 dark:border-blue-900/30 max-w-md mx-auto text-center space-y-4">
            <div>
              <span className="block text-xs text-slate-400 dark:text-slate-500 font-semibold uppercase tracking-wider mb-1">Nomor Pengajuan Anda</span>
              <span className="text-2xl font-mono font-extrabold text-[#0F172A] dark:text-emerald-400 select-all bg-white dark:bg-slate-950 px-4 py-1.5 rounded-lg border border-slate-200 dark:border-slate-800 shadow-sm inline-block">
                {successData.nomor_pengajuan}
              </span>
            </div>
            
            <div className="text-left text-xs space-y-2 text-slate-600 dark:text-slate-400 border-t border-blue-100/50 dark:border-blue-900/20 pt-3">
              <div className="flex justify-between">
                <span>Nama Usaha:</span>
                <span className="font-bold text-slate-900 dark:text-white">{successData.nama_usaha}</span>
              </div>
              <div className="flex justify-between">
                <span>Pemilik:</span>
                <span className="font-bold text-slate-900 dark:text-white">{successData.nama_pemilik}</span>
              </div>
              <div className="flex justify-between">
                <span>Tanggal:</span>
                <span className="font-bold text-slate-900 dark:text-white">{successData.tanggal_pengajuan}</span>
              </div>
            </div>
          </div>

          <div className="bg-amber-50 dark:bg-amber-950/20 border border-amber-200/50 dark:border-amber-900/30 p-4 rounded-xl text-xs text-amber-800 dark:text-amber-300 text-left flex gap-3 max-w-md mx-auto">
            <AlertTriangle className="w-5 h-5 shrink-0 text-amber-600 dark:text-amber-400" />
            <p className="leading-relaxed">
              <strong>PENTING:</strong> Catat atau salin nomor pengajuan di atas. Nomor ini diperlukan untuk melacak status verifikasi dokumen usaha Anda pada menu <strong>Cek Status</strong>.
            </p>
          </div>

          <div className="flex flex-col sm:flex-row gap-3 pt-4 justify-center">
            <button
              onClick={() => onNavigate('cek-status')}
              className="px-6 py-3 bg-[#0F172A] dark:bg-blue-600 hover:bg-slate-800 dark:hover:bg-blue-500 text-white font-bold rounded-xl text-sm transition-all shadow-md cursor-pointer"
            >
              Cek Status Sekarang
            </button>
            <button
              onClick={() => {
                setSuccessData(null);
                setNamaPemilik('');
                setNomorTelepon('');
                setNamaUsaha('');
                setJenisUsaha('');
                setDeskripsiUsaha('');
                setDesa('');
                setAlamatLengkap('');
                setFotoUsaha('');
                setImagePreview(null);
                setNib('');
                setSertifikasiHalal('');
              }}
              className="px-6 py-3 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 font-bold rounded-xl text-sm transition-all cursor-pointer"
            >
              Kirim Pengajuan Baru
            </button>
          </div>
        </motion.div>
      </div>
    );
  }

  return (
    <div id="ajukan-view" className="pt-24 pb-16 max-w-4xl mx-auto px-6 text-left">
      <div className="mb-8 flex items-center justify-between">
        <div>
          <button 
            onClick={handleBackToLanding}
            className="flex items-center gap-1.5 text-xs font-bold text-slate-500 hover:text-slate-850 dark:text-slate-400 dark:hover:text-slate-200 transition-colors mb-2 cursor-pointer"
          >
            <ArrowLeft className="w-3.5 h-3.5" />
            <span>Kembali ke Beranda</span>
          </button>
          <h1 className="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight flex items-center gap-3">
            <span>Formulir Pengajuan Pendataan UMKM</span>
            {editSubmission && (
              <span className="text-xs bg-orange-100 dark:bg-orange-950/40 text-orange-850 dark:text-orange-400 border border-orange-200 dark:border-orange-900/40 px-2.5 py-1 rounded-full font-bold">
                Mode Perbaikan Data
              </span>
            )}
          </h1>
          <p className="text-slate-500 dark:text-slate-400 text-sm mt-1">
            Lengkapi kolom di bawah ini dengan informasi sebenar-benarnya untuk proses verifikasi Seksi PM Cicalengka.
          </p>
        </div>
      </div>

      {error && (
        <motion.div 
          initial={{ opacity: 0, y: -10 }}
          animate={{ opacity: 1, y: 0 }}
          className="p-4 bg-red-50 dark:bg-red-950/20 border border-red-200 dark:border-red-900/30 text-red-800 dark:text-red-300 rounded-2xl flex gap-3 text-sm items-start mb-6"
        >
          <AlertTriangle className="w-5 h-5 shrink-0 text-red-600 dark:text-red-400 mt-0.5" />
          <p className="font-medium">{error}</p>
        </motion.div>
      )}

      <form onSubmit={handleSubmit} className="space-y-6">
        
        {/* Section 1: Data Pemilik */}
        <section className="bg-white dark:bg-slate-900 p-6 md:p-8 rounded-3xl border border-slate-200/80 dark:border-slate-800/80 shadow-sm space-y-6 transition-colors duration-300">
          <div className="flex items-center gap-3 border-b border-slate-100 dark:border-slate-800 pb-4">
            <div className="p-2 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-xl">
              <User className="w-5 h-5" />
            </div>
            <div>
              <h2 className="text-lg font-extrabold text-slate-900 dark:text-white">1. Data Pemilik Usaha</h2>
              <p className="text-xs text-slate-400 dark:text-slate-500">Isi data diri pemilik penanggung jawab utama usaha.</p>
            </div>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div className="space-y-1.5 text-left">
              <label className="text-xs font-bold text-slate-700 dark:text-slate-300 tracking-wide uppercase">
                Nama Lengkap Pemilik <span className="text-red-500">*</span>
              </label>
              <input
                type="text"
                required
                value={namaPemilik}
                onChange={(e) => setNamaPemilik(e.target.value)}
                placeholder="Contoh: Ahmad Sudrajat"
                className="w-full bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-200 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-3 text-sm focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-blue-600/20 dark:focus:ring-blue-600/30 focus:border-blue-600 dark:focus:border-blue-400 transition-all outline-none"
              />
            </div>

            <div className="space-y-1.5 text-left">
              <label className="text-xs font-bold text-slate-700 dark:text-slate-300 tracking-wide uppercase">
                Nomor Telepon / WhatsApp <span className="text-red-500">*</span>
              </label>
              <input
                type="tel"
                required
                value={nomorTelepon}
                onChange={(e) => setNomorTelepon(e.target.value)}
                placeholder="Contoh: 081234567890"
                className="w-full bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-200 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-3 text-sm focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-blue-600/20 dark:focus:ring-blue-600/30 focus:border-blue-600 dark:focus:border-blue-400 transition-all outline-none"
              />
              <span className="text-[10px] text-slate-400 dark:text-slate-550 block">Digunakan untuk pemberitahuan dan koordinasi.</span>
            </div>
          </div>
        </section>

        {/* Section 2: Informasi Usaha */}
        <section className="bg-white dark:bg-slate-900 p-6 md:p-8 rounded-3xl border border-slate-200/80 dark:border-slate-800/80 shadow-sm space-y-6 transition-colors duration-300">
          <div className="flex items-center gap-3 border-b border-slate-100 dark:border-slate-800 pb-4">
            <div className="p-2 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-xl">
              <Store className="w-5 h-5" />
            </div>
            <div>
              <h2 className="text-lg font-extrabold text-slate-900 dark:text-white">2. Informasi Detail Usaha</h2>
              <p className="text-xs text-slate-400 dark:text-slate-500">Deskripsikan bidang usaha dan produk utama Anda.</p>
            </div>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div className="space-y-1.5 text-left">
              <label className="text-xs font-bold text-slate-700 dark:text-slate-300 tracking-wide uppercase">
                Nama Usaha / Merk Dagang <span className="text-red-500">*</span>
              </label>
              <input
                type="text"
                required
                value={namaUsaha}
                onChange={(e) => setNamaUsaha(e.target.value)}
                placeholder="Contoh: Warung Kopi Sejahtera"
                className="w-full bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-200 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-3 text-sm focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-blue-600/20 dark:focus:ring-blue-600/30 focus:border-blue-600 dark:focus:border-blue-400 transition-all outline-none"
              />
            </div>

            <div className="space-y-1.5 text-left">
              <label className="text-xs font-bold text-slate-700 dark:text-slate-300 tracking-wide uppercase">
                Kategori Jenis Usaha <span className="text-red-500">*</span>
              </label>
              <select
                required
                value={jenisUsaha}
                onChange={(e) => setJenisUsaha(e.target.value)}
                className="w-full bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-200 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-3 text-sm focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-blue-600/20 dark:focus:ring-blue-600/30 focus:border-blue-600 dark:focus:border-blue-400 transition-all outline-none appearance-none"
              >
                <option value="">-- Pilih Jenis Usaha --</option>
                {JENIS_USAHA.map((kat) => (
                  <option key={kat} value={kat} className="dark:bg-slate-900 dark:text-slate-100">{kat}</option>
                ))}
              </select>
            </div>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div className="space-y-1.5 text-left">
              <label className="text-xs font-bold text-slate-700 dark:text-slate-300 tracking-wide uppercase">
                Nomor Induk Berusaha (NIB) <span className="text-slate-400 font-normal">(Opsional)</span>
              </label>
              <input
                type="text"
                value={nib}
                onChange={(e) => setNib(e.target.value)}
                placeholder="Contoh: 9120001234567"
                className="w-full bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-200 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-3 text-sm focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-blue-600/20 dark:focus:ring-blue-600/30 focus:border-blue-600 dark:focus:border-blue-400 transition-all outline-none"
              />
            </div>

            <div className="space-y-1.5 text-left">
              <label className="text-xs font-bold text-slate-700 dark:text-slate-300 tracking-wide uppercase">
                Sertifikat Halal <span className="text-slate-400 font-normal">(Opsional)</span>
              </label>
              <input
                type="text"
                value={sertifikasiHalal}
                onChange={(e) => setSertifikasiHalal(e.target.value)}
                placeholder="Contoh: ID3211000012345"
                className="w-full bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-200 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-3 text-sm focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-blue-600/20 dark:focus:ring-blue-600/30 focus:border-blue-600 dark:focus:border-blue-400 transition-all outline-none"
              />
            </div>
          </div>

          <div className="space-y-1.5 text-left">
            <label className="text-xs font-bold text-slate-700 dark:text-slate-300 tracking-wide uppercase">
              Deskripsi Usaha / Produk
            </label>
            <textarea
              rows={4}
              value={deskripsiUsaha}
              onChange={(e) => setDeskripsiUsaha(e.target.value)}
              placeholder="Jelaskan mengenai produk, jam operasional, atau nilai jual unik usaha Anda..."
              className="w-full bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-200 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-3 text-sm focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-blue-600/20 dark:focus:ring-blue-600/30 focus:border-blue-600 dark:focus:border-blue-400 transition-all outline-none resize-none"
            />
          </div>
        </section>

        {/* Section 3: Lokasi Usaha */}
        <section className="bg-white dark:bg-slate-900 p-6 md:p-8 rounded-3xl border border-slate-200/80 dark:border-slate-800/80 shadow-sm space-y-6 transition-colors duration-300">
          <div className="flex items-center gap-3 border-b border-slate-100 dark:border-slate-800 pb-4">
            <div className="p-2 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-xl">
              <MapPin className="w-5 h-5" />
            </div>
            <div>
              <h2 className="text-lg font-extrabold text-slate-900 dark:text-white">3. Domisili & Alamat Usaha</h2>
              <p className="text-xs text-slate-400 dark:text-slate-500">Harus berada dalam lingkup administrasi Kecamatan Cicalengka.</p>
            </div>
          </div>

          <div className="space-y-4">
            <div className="space-y-1.5 text-left">
              <label className="text-xs font-bold text-slate-700 dark:text-slate-300 tracking-wide uppercase">
                Pilih Desa <span className="text-red-500">*</span>
              </label>
              <select
                required
                value={desa}
                onChange={(e) => setDesa(e.target.value)}
                className="w-full bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-200 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-3 text-sm focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-blue-600/20 dark:focus:ring-blue-600/30 focus:border-blue-600 dark:focus:border-blue-400 transition-all outline-none"
              >
                <option value="">-- Pilih Desa --</option>
                {LIST_DESA.map((d) => (
                  <option key={d} value={d} className="dark:bg-slate-900 dark:text-slate-100">{d}</option>
                ))}
              </select>
            </div>

            <div className="space-y-1.5 text-left">
              <label className="text-xs font-bold text-slate-700 dark:text-slate-300 tracking-wide uppercase">
                Alamat Lengkap Usaha <span className="text-red-500">*</span>
              </label>
              <textarea
                required
                rows={2}
                value={alamatLengkap}
                onChange={(e) => setAlamatLengkap(e.target.value)}
                placeholder="Nama Jalan, Kampung/Blok, Nomor Rumah, RT/RW..."
                className="w-full bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-200 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-3 text-sm focus:bg-white dark:focus:bg-slate-900 focus:ring-2 focus:ring-blue-600/20 dark:focus:ring-blue-600/30 focus:border-blue-600 dark:focus:border-blue-400 transition-all outline-none resize-none"
              />
            </div>
          </div>
        </section>

        {/* Section 4: Dokumentasi Usaha */}
        <section className="bg-white dark:bg-slate-900 p-6 md:p-8 rounded-3xl border border-slate-200/80 dark:border-slate-800/80 shadow-sm space-y-6 transition-colors duration-300">
          <div className="flex items-center gap-3 border-b border-slate-100 dark:border-slate-800 pb-4">
            <div className="p-2 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-xl">
              <Upload className="w-5 h-5" />
            </div>
            <div>
              <h2 className="text-lg font-extrabold text-slate-900 dark:text-white">4. Dokumentasi Usaha / Produk</h2>
              <p className="text-xs text-slate-400 dark:text-slate-500">Unggah foto penunjang yang memperlihatkan fisik tempat usaha atau produk Anda.</p>
            </div>
          </div>

          <div className="space-y-4">
            <label className="text-xs font-bold text-slate-700 dark:text-slate-300 tracking-wide uppercase block text-left">
              Foto Produk / Tempat Usaha <span className="text-red-500">*</span>
            </label>

            {!imagePreview ? (
              <div
                id="image-dropzone"
                onDragOver={handleDragOver}
                onDragLeave={handleDragLeave}
                onDrop={handleDrop}
                onClick={triggerFileInput}
                className={`border-2 border-dashed rounded-2xl p-8 text-center cursor-pointer transition-all flex flex-col items-center justify-center space-y-2 hover:bg-slate-50/50 dark:hover:bg-slate-800/30 ${
                  isDragging 
                    ? 'border-blue-500 bg-blue-50/30 dark:bg-blue-950/20' 
                    : 'border-slate-300 dark:border-slate-700 text-slate-400 dark:border-slate-700'
                }`}
              >
                <div className="p-4 bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 rounded-full">
                  <Upload className="w-6 h-6" />
                </div>
                <div className="space-y-1">
                  <p className="text-sm font-bold text-slate-700 dark:text-slate-300">Tarik dan jatuhkan gambar di sini</p>
                  <p className="text-xs text-slate-400 dark:text-slate-500">atau klik untuk menelusuri dari folder komputer</p>
                </div>
                <span className="text-[10px] text-slate-400 dark:text-slate-500 font-semibold uppercase tracking-wider bg-slate-100 dark:bg-slate-800 px-2 py-0.5 rounded">
                  Format: JPG, JPEG, PNG (Maks 5MB)
                </span>
                <input
                  type="file"
                  ref={fileInputRef}
                  onChange={handleFileChange}
                  accept="image/*"
                  className="hidden"
                />
              </div>
            ) : (
              <div className="relative rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950/40 p-4 max-w-md">
                <img 
                  src={imagePreview} 
                  alt="Preview Usaha" 
                  className="rounded-xl w-full h-48 object-cover shadow-sm"
                />
                <button
                  type="button"
                  onClick={removeImage}
                  className="absolute top-6 right-6 p-1.5 bg-red-600/90 text-white rounded-full hover:bg-red-700 transition-all shadow-md hover:scale-105 cursor-pointer"
                  title="Hapus gambar"
                >
                  <X className="w-4 h-4" />
                </button>
                <div className="mt-3 flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400 font-medium">
                  <FileImage className="w-4 h-4 text-emerald-500" />
                  <span>Foto berhasil dimuat</span>
                </div>
              </div>
            )}
          </div>
        </section>

        {/* Action Button */}
        <div className="pt-2 text-left">
          <button
            type="submit"
            disabled={loading}
            className="w-full sm:w-auto px-10 py-4 bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-500 hover:to-emerald-600 text-white rounded-xl font-extrabold shadow-lg shadow-emerald-900/10 active:scale-95 transition-all flex items-center justify-center gap-2 cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed"
          >
            {loading ? (
              <>
                <Loader2 className="w-5 h-5 animate-spin" />
                <span>Memproses Data...</span>
              </>
            ) : (
              <>
                <Send className="w-4 h-4" />
                <span>Kirim Formulir Pengajuan</span>
              </>
            )}
          </button>
        </div>
      </form>
    </div>
  );
}
