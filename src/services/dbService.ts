import { db, isFirebaseConfigured } from './firebase';
import { 
  collection, 
  doc, 
  getDoc, 
  getDocs, 
  setDoc, 
  updateDoc, 
  query, 
  where 
} from 'firebase/firestore';
import { Submission, BusinessStatus, User as AdminUser } from '../types';

// Helper to format date in Indonesian style
function getIndonesianDate(): string {
  const now = new Date();
  const monthsId = [
    "Januari", "Februari", "Maret", "April", "Mei", "Juni",
    "Juli", "Agustus", "September", "Oktober", "November", "Desember"
  ];
  return `${now.getDate()} ${monthsId[now.getMonth()]} ${now.getFullYear()}`;
}

// Generate unique nomor_pengajuan like: SPD-YYYYMMDD-XXX
async function generateNomorPengajuan(): Promise<string> {
  const now = new Date();
  const year = now.getFullYear();
  const month = String(now.getMonth() + 1).padStart(2, '0');
  const date = String(now.getDate()).padStart(2, '0');
  const dateStr = `${year}${month}${date}`;
  const prefix = `SPD-${dateStr}-`;

  if (isFirebaseConfigured && db) {
    const q = query(
      collection(db, 'submissions'),
      where('nomor_pengajuan', '>=', prefix),
      where('nomor_pengajuan', '<=', prefix + '\uf8ff')
    );
    const querySnapshot = await getDocs(q);
    const count = querySnapshot.size;
    const nextSeq = String(count + 1).padStart(3, '0');
    return `${prefix}${nextSeq}`;
  } else {
    // This is handled by Express server when using fallback
    return '';
  }
}

// Client-side Database Service with fallback to Local API
export const dbService = {
  // 1. Admin Login
  async login(username: string, password: string): Promise<{ success: boolean; token: string; user: AdminUser }> {
    if (isFirebaseConfigured && db) {
      try {
        // Attempt to check configs/admin in Firestore
        const adminDocRef = doc(db, 'configs', 'admin');
        const adminDoc = await getDoc(adminDocRef);

        let isValid = false;
        if (adminDoc.exists()) {
          const data = adminDoc.data();
          isValid = username === data.username && password === data.password;
        } else {
          // Fallback to default admin/admin if config document doesn't exist in Firestore
          isValid = username === 'admin' && password === 'admin';
          // Auto-create the default document for convenience
          try {
            await setDoc(adminDocRef, { username: 'admin', password: 'admin', name: 'Admin Utama' });
          } catch (e) {
            console.warn('Failed to seed default admin credentials into Firestore:', e);
          }
        }

        if (isValid) {
          return {
            success: true,
            token: 'admin-session-token',
            user: { username, name: 'Admin Utama' }
          };
        } else {
          throw new Error('Username atau Password salah');
        }
      } catch (err: any) {
        throw new Error(err.message || 'Gagal login melalui Firebase.');
      }
    } else {
      // Local Express API Fallback
      const response = await fetch('/api/login', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ username, password }),
      });
      const data = await response.json();
      if (response.ok && data.success) {
        return data;
      } else {
        throw new Error(data.message || 'Username atau Password salah');
      }
    }
  },

  // 2. Get All Submissions (with Client-Side Search and Filtering for flexibility)
  async getSubmissions(search?: string, status?: string): Promise<Submission[]> {
    if (isFirebaseConfigured && db) {
      const submissionsCol = collection(db, 'submissions');
      const snapshot = await getDocs(submissionsCol);
      let list = snapshot.docs.map(doc => doc.data() as Submission);

      // Sorting: latest first (ID contains timestamp or we sort by tanggal_pengajuan)
      list.sort((a, b) => {
        const idA = a.id.replace('sub-', '');
        const idB = b.id.replace('sub-', '');
        return Number(idB) - Number(idA);
      });

      // Filter by status
      if (status && status !== 'Semua') {
        list = list.filter(s => s.status === status);
      }

      // Filter by search query
      if (search) {
        const queryStr = search.toLowerCase();
        list = list.filter(
          s =>
            s.nomor_pengajuan.toLowerCase().includes(queryStr) ||
            s.nama_usaha.toLowerCase().includes(queryStr) ||
            s.nama_pemilik.toLowerCase().includes(queryStr) ||
            s.desa.toLowerCase().includes(queryStr)
        );
      }

      return list;
    } else {
      // Local Express API Fallback
      const params = new URLSearchParams();
      if (search) params.append('search', search);
      if (status) params.append('status', status);
      const res = await fetch(`/api/submissions?${params.toString()}`);
      if (!res.ok) throw new Error('Gagal mengambil data pengajuan.');
      return res.json();
    }
  },

  // 3. Get Single Submission by ID or nomor_pengajuan (Cek Status)
  async getSubmissionByIdOrNo(idOrNo: string): Promise<Submission> {
    const cleanId = idOrNo.trim();
    if (isFirebaseConfigured && db) {
      // Check by doc ID
      const docRef = doc(db, 'submissions', cleanId);
      const docSnap = await getDoc(docRef);

      if (docSnap.exists()) {
        return docSnap.data() as Submission;
      }

      // Check by nomor_pengajuan
      const q = query(
        collection(db, 'submissions'),
        where('nomor_pengajuan', '==', cleanId.toUpperCase())
      );
      const querySnapshot = await getDocs(q);
      if (!querySnapshot.empty) {
        return querySnapshot.docs[0].data() as Submission;
      }

      throw new Error('Pengajuan tidak ditemukan');
    } else {
      // Local Express API Fallback
      const res = await fetch(`/api/submissions/${cleanId}`);
      if (!res.ok) throw new Error('Pengajuan tidak ditemukan');
      return res.json();
    }
  },

  // 4. Create New Submission
  async createSubmission(
    data: Omit<Submission, 'id' | 'nomor_pengajuan' | 'status' | 'catatan_admin' | 'tanggal_pengajuan'>
  ): Promise<{ success: boolean; message: string; data: Submission }> {
    if (isFirebaseConfigured && db) {
      const nomor_pengajuan = await generateNomorPengajuan();
      const id = `sub-${Date.now()}`;
      const displayDate = getIndonesianDate();

      const newSubmission: Submission = {
        ...data,
        id,
        nomor_pengajuan,
        status: 'Menunggu Verifikasi',
        catatan_admin: '',
        tanggal_pengajuan: displayDate,
        foto_usaha: data.foto_usaha || 'https://images.unsplash.com/photo-1542838132-92c53300491e?w=500&auto=format&fit=crop&q=60'
      };

      await setDoc(doc(db, 'submissions', id), newSubmission);

      return {
        success: true,
        message: 'Pengajuan berhasil dikirim',
        data: newSubmission
      };
    } else {
      // Local Express API Fallback
      const response = await fetch('/api/submissions', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data),
      });
      const resData = await response.json();
      if (response.ok) {
        return resData;
      } else {
        throw new Error(resData.message || 'Gagal mengirim pengajuan.');
      }
    }
  },

  // 5. Verify / Update Submission Status
  async verifySubmission(id: string, status: BusinessStatus, catatanAdmin: string): Promise<{ success: boolean; message: string; data: Submission }> {
    if (isFirebaseConfigured && db) {
      const docRef = doc(db, 'submissions', id);
      const docSnap = await getDoc(docRef);

      if (!docSnap.exists()) {
        throw new Error('Pengajuan tidak ditemukan');
      }

      const updatedData = {
        status,
        catatan_admin: catatanAdmin || ''
      };

      await updateDoc(docRef, updatedData);

      const finalData = {
        ...(docSnap.data() as Submission),
        ...updatedData
      };

      return {
        success: true,
        message: 'Status verifikasi berhasil diperbarui',
        data: finalData
      };
    } else {
      // Local Express API Fallback
      const response = await fetch(`/api/submissions/${id}/verifikasi`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ status, catatan_admin: catatanAdmin }),
      });
      const resData = await response.json();
      if (response.ok) {
        return resData;
      } else {
        throw new Error(resData.message || 'Gagal memperbarui status verifikasi.');
      }
    }
  },

  // 6. Get Registered UMKM (Status = Disetujui)
  async getUmkm(search?: string): Promise<Submission[]> {
    if (isFirebaseConfigured && db) {
      const q = query(
        collection(db, 'submissions'),
        where('status', '==', 'Disetujui')
      );
      const snapshot = await getDocs(q);
      let list = snapshot.docs.map(doc => doc.data() as Submission);

      // Sort latest first
      list.sort((a, b) => {
        const idA = a.id.replace('sub-', '');
        const idB = b.id.replace('sub-', '');
        return Number(idB) - Number(idA);
      });

      // Search filtering client-side
      if (search) {
        const queryStr = search.toLowerCase();
        list = list.filter(
          u =>
            u.nomor_pengajuan.toLowerCase().includes(queryStr) ||
            u.nama_usaha.toLowerCase().includes(queryStr) ||
            u.nama_pemilik.toLowerCase().includes(queryStr) ||
            u.desa.toLowerCase().includes(queryStr) ||
            u.jenis_usaha.toLowerCase().includes(queryStr)
        );
      }

      return list;
    } else {
      // Local Express API Fallback
      const params = new URLSearchParams();
      if (search) params.append('search', search);
      const res = await fetch(`/api/umkm?${params.toString()}`);
      if (!res.ok) throw new Error('Gagal mengambil daftar UMKM.');
      return res.json();
    }
  }
};
