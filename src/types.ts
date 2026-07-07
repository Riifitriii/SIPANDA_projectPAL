export type BusinessStatus = 'Menunggu Verifikasi' | 'Perlu Perbaikan' | 'Disetujui' | 'Ditolak';

export interface Submission {
  id: string;
  nomor_pengajuan: string;
  nama_pemilik: string;
  nomor_telepon: string;
  nama_usaha: string;
  jenis_usaha: string;
  deskripsi_usaha: string;
  desa: string;
  alamat_lengkap: string;
  foto_usaha: string;
  status: BusinessStatus;
  catatan_admin: string;
  tanggal_pengajuan: string;
}

export interface User {
  username: string;
  name: string;
}

export type ActiveTab = 'home' | 'about' | 'requirements' | 'ajukan' | 'cek-status' | 'admin-login' | 'admin-dashboard';
