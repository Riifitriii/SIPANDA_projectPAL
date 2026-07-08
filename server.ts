import express from "express";
import path from "path";
import fs from "fs";
import { createServer as createViteServer } from "vite";

const PORT = 3000;
const DB_FILE = path.join(process.cwd(), "data", "db.json");

// Ensure data directory and db file exist with seed data
function initDatabase() {
  const dir = path.dirname(DB_FILE);
  if (!fs.existsSync(dir)) {
    fs.mkdirSync(dir, { recursive: true });
  }

  const defaultSubmissions = [
    {
      id: "sub-1",
      nomor_pengajuan: "SPD-20240524-001",
      nama_pemilik: "Ahmad Sudrajat",
      nomor_telepon: "081234567890",
      nama_usaha: "Warung Kopi Sejahtera",
      jenis_usaha: "Kuliner",
      deskripsi_usaha: "Warung kopi tradisional yang menyajikan kopi khas Cicalengka dengan makanan ringan berkualitas untuk masyarakat sekitar.",
      desa: "Cicalengka Kulon",
      alamat_lengkap: "Jl. Raya Cicalengka No. 45, RT 02 / RW 04",
      foto_usaha: "https://images.unsplash.com/photo-1554118811-1e0d58224f24?w=500&auto=format&fit=crop&q=60",
      nib: "9120001234567",
      sertifikasi_halal: "ID3211000012345",
      status: "Menunggu Verifikasi",
      catatan_admin: "",
      tanggal_pengajuan: "24 Mei 2024"
    },
    {
      id: "sub-2",
      nomor_pengajuan: "SPD-20240523-002",
      nama_pemilik: "Ibu Siti Aminah",
      nomor_telepon: "082198765432",
      nama_usaha: "Batik Cicalengka Indah",
      jenis_usaha: "Kerajinan",
      deskripsi_usaha: "Produksi batik tulis dengan motif khas sunda dan pewarna alami ramah lingkungan.",
      desa: "Panenjoan",
      alamat_lengkap: "Kp. Babakan RT 01 / RW 05, Desa Panenjoan",
      foto_usaha: "https://images.unsplash.com/photo-1544816155-12df9643f363?w=500&auto=format&fit=crop&q=60",
      nib: "9120007654321",
      sertifikasi_halal: "ID3211000098765",
      status: "Disetujui",
      catatan_admin: "Dokumen lengkap dan usaha memenuhi syarat administrasi kecamatan.",
      tanggal_pengajuan: "23 Mei 2024"
    },
    {
      id: "sub-3",
      nomor_pengajuan: "SPD-20231025-0042",
      nama_pemilik: "Bambang Heru",
      nomor_telepon: "085211223344",
      nama_usaha: "Bengkel Motor Jaya",
      jenis_usaha: "Jasa",
      deskripsi_usaha: "Jasa perbaikan sepeda motor, servis rutin, ganti oli, dan penyediaan suku cadang asli.",
      desa: "Cicalengka Wetan",
      alamat_lengkap: "Jl. Stasiun Cicalengka No. 12",
      foto_usaha: "https://images.unsplash.com/photo-1486006920555-c77dce18193b?w=500&auto=format&fit=crop&q=60",
      nib: "",
      sertifikasi_halal: "",
      status: "Perlu Perbaikan",
      catatan_admin: "Mohon lampirkan foto produk/bengkel tampak depan yang lebih jelas dan cantumkan RT/RW alamat desa.",
      tanggal_pengajuan: "25 Oktober 2023"
    },
    {
      id: "sub-4",
      nomor_pengajuan: "SPD-20240522-004",
      nama_pemilik: "Ibu Lilis",
      nomor_telepon: "087822334455",
      nama_usaha: "Keripik Tempe Renyah",
      jenis_usaha: "Kuliner",
      deskripsi_usaha: "Produsen camilan keripik tempe tipis renyah rasa orisinal dan pedas jeruk purut tanpa pengawet.",
      desa: "Tenjolaya",
      alamat_lengkap: "Kp. Tenjolaya Indah Blok C No. 4, RT 03 / RW 09",
      foto_usaha: "https://images.unsplash.com/photo-1566843972142-a7fcb70de55a?w=500&auto=format&fit=crop&q=60",
      nib: "9120008888888",
      sertifikasi_halal: "",
      status: "Menunggu Verifikasi",
      catatan_admin: "",
      tanggal_pengajuan: "22 Mei 2024"
    }
  ];

  if (!fs.existsSync(DB_FILE)) {
    const initialData = {
      submissions: defaultSubmissions,
      umkm_terdaftar: defaultSubmissions.filter(s => s.status === "Disetujui")
    };
    fs.writeFileSync(DB_FILE, JSON.stringify(initialData, null, 2), "utf8");
    console.log("Database initialized with seed data.");
  } else {
    // Make sure structure is sound
    try {
      const data = JSON.parse(fs.readFileSync(DB_FILE, "utf8"));
      if (!data.submissions || !data.umkm_terdaftar) {
        throw new Error("Invalid structure");
      }
    } catch (e) {
      const initialData = {
        submissions: defaultSubmissions,
        umkm_terdaftar: defaultSubmissions.filter(s => s.status === "Disetujui")
      };
      fs.writeFileSync(DB_FILE, JSON.stringify(initialData, null, 2), "utf8");
      console.log("Database re-initialized due to parse error.");
    }
  }
}

function getDatabase() {
  initDatabase();
  return JSON.parse(fs.readFileSync(DB_FILE, "utf8"));
}

function saveDatabase(data: any) {
  fs.writeFileSync(DB_FILE, JSON.stringify(data, null, 2), "utf8");
}

async function startServer() {
  initDatabase();
  const app = express();

  // Increase body size limit to support base64 image uploads
  app.use(express.json({ limit: "20mb" }));
  app.use(express.urlencoded({ limit: "20mb", extended: true }));

  // API: Login Admin
  app.post("/api/login", (req, res) => {
    const { username, password } = req.body;
    if (username === "admin" && password === "admin") {
      res.json({ success: true, token: "admin-session-token", user: { username: "admin", name: "Admin Utama" } });
    } else {
      res.status(401).json({ success: false, message: "Username atau Password salah" });
    }
  });

  // API: Get all submissions (Admin with optional search/filter)
  app.get("/api/submissions", (req, res) => {
    const db = getDatabase();
    const search = req.query.search as string;
    const status = req.query.status as string;

    let filtered = [...db.submissions];

    if (status && status !== "Semua") {
      filtered = filtered.filter(s => s.status === status);
    }

    if (search) {
      const query = search.toLowerCase();
      filtered = filtered.filter(
        s =>
          s.nomor_pengajuan.toLowerCase().includes(query) ||
          s.nama_usaha.toLowerCase().includes(query) ||
          s.nama_pemilik.toLowerCase().includes(query) ||
          s.desa.toLowerCase().includes(query)
      );
    }

    // Sort by latest (we can reverse or parse date, let's reverse to show latest first)
    res.json(filtered.reverse());
  });

  // API: Get single submission by number (Cek Status) or ID
  app.get("/api/submissions/:id", (req, res) => {
    const db = getDatabase();
    const id = req.params.id;
    
    // Check both by ID and by nomor_pengajuan
    const submission = db.submissions.find(
      s => s.id === id || s.nomor_pengajuan.toUpperCase() === id.trim().toUpperCase()
    );

    if (submission) {
      res.json(submission);
    } else {
      res.status(404).json({ message: "Pengajuan tidak ditemukan" });
    }
  });

  // API: Create new submission (Public Form)
  app.post("/api/submissions", (req, res) => {
    const db = getDatabase();
    const {
      nama_pemilik,
      nomor_telepon,
      nama_usaha,
      jenis_usaha,
      deskripsi_usaha,
      desa,
      alamat_lengkap,
      foto_usaha, // this will be base64 string or image URL
      nib,
      sertifikasi_halal
    } = req.body;

    if (!nama_pemilik || !nomor_telepon || !nama_usaha || !jenis_usaha || !desa || !alamat_lengkap) {
      return res.status(400).json({ message: "Data formulir tidak lengkap" });
    }

    // Generate unique nomor_pengajuan
    // Format: SPD-YYYYMMDD-XXX
    const now = new Date();
    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, "0");
    const date = String(now.getDate()).padStart(2, "0");
    const dateStr = `${year}${month}${date}`;

    // Count how many submissions have been generated today
    const prefix = `SPD-${dateStr}-`;
    const todaySubmissions = db.submissions.filter((s: any) => s.nomor_pengajuan.startsWith(prefix));
    const nextSeq = String(todaySubmissions.length + 1).padStart(3, "0");
    const nomor_pengajuan = `${prefix}${nextSeq}`;

    // Format display date Indonesian style
    const monthsId = [
      "Januari", "Februari", "Maret", "April", "Mei", "Juni",
      "Juli", "Agustus", "September", "Oktober", "November", "Desember"
    ];
    const displayDate = `${now.getDate()} ${monthsId[now.getMonth()]} ${now.getFullYear()}`;

    const newSubmission = {
      id: `sub-${Date.now()}`,
      nomor_pengajuan,
      nama_pemilik,
      nomor_telepon,
      nama_usaha,
      jenis_usaha,
      deskripsi_usaha: deskripsi_usaha || "",
      desa,
      alamat_lengkap,
      foto_usaha: foto_usaha || "https://images.unsplash.com/photo-1542838132-92c53300491e?w=500&auto=format&fit=crop&q=60", // default placeholder if no image
      nib: nib || "",
      sertifikasi_halal: sertifikasi_halal || "",
      status: "Menunggu Verifikasi" as const,
      catatan_admin: "",
      tanggal_pengajuan: displayDate
    };

    db.submissions.push(newSubmission);
    saveDatabase(db);

    res.status(201).json({
      success: true,
      message: "Pengajuan berhasil dikirim",
      data: newSubmission
    });
  });

  // API: Verify Submission (Admin action)
  app.post("/api/submissions/:id/verifikasi", (req, res) => {
    const db = getDatabase();
    const id = req.params.id;
    const { status, catatan_admin } = req.body;

    if (!status || !["Menunggu Verifikasi", "Perlu Perbaikan", "Disetujui", "Ditolak"].includes(status)) {
      return res.status(400).json({ message: "Status tidak valid" });
    }

    const subIndex = db.submissions.findIndex((s: any) => s.id === id);
    if (subIndex === -1) {
      return res.status(404).json({ message: "Pengajuan tidak ditemukan" });
    }

    // Update submission
    db.submissions[subIndex].status = status;
    db.submissions[subIndex].catatan_admin = catatan_admin || "";

    // Sync umkm_terdaftar
    // Remove if previously registered but now changed status (should not happen normally but good practice)
    db.umkm_terdaftar = db.umkm_terdaftar.filter((u: any) => u.id !== id);

    if (status === "Disetujui") {
      // Add to registered
      db.umkm_terdaftar.push(db.submissions[subIndex]);
    }

    saveDatabase(db);
    res.json({ success: true, message: "Status verifikasi berhasil diperbarui", data: db.submissions[subIndex] });
  });

  // API: Get registered UMKM lists
  app.get("/api/umkm", (req, res) => {
    const db = getDatabase();
    const search = req.query.search as string;

    let list = [...db.umkm_terdaftar];

    if (search) {
      const query = search.toLowerCase();
      list = list.filter(
        u =>
          u.nomor_pengajuan.toLowerCase().includes(query) ||
          u.nama_usaha.toLowerCase().includes(query) ||
          u.nama_pemilik.toLowerCase().includes(query) ||
          u.desa.toLowerCase().includes(query) ||
          u.jenis_usaha.toLowerCase().includes(query)
      );
    }

    res.json(list.reverse());
  });

  // Serve static assets or mount Vite middleware
  if (process.env.NODE_ENV !== "production") {
    const vite = await createViteServer({
      server: { middlewareMode: true },
      appType: "spa",
    });
    app.use(vite.middlewares);
  } else {
    const distPath = path.join(process.cwd(), "dist");
    app.use(express.static(distPath));
    app.get("*", (req, res) => {
      res.sendFile(path.join(distPath, "index.html"));
    });
  }

  app.listen(PORT, "0.0.0.0", () => {
    console.log(`Server running on http://localhost:${PORT}`);
  });
}

startServer().catch((err) => {
  console.error("Failed to start server:", err);
});
