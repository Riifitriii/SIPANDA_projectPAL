import React, { useState, useEffect } from 'react';
import { motion } from 'motion/react';
import { 
  Compass, 
  MapPin, 
  Phone, 
  Mail, 
  Menu, 
  X, 
  User, 
  FileText, 
  Search,
  ExternalLink,
  ShieldCheck
} from 'lucide-react';
import { ActiveTab, Submission, User as AdminUser } from './types';
import LandingPage from './components/LandingPage';
import FormPengajuan from './components/FormPengajuan';
import CekStatus from './components/CekStatus';
import AdminLogin from './components/AdminLogin';
import AdminPanel from './components/AdminPanel';
import ThemeToggle, { Theme } from './components/ThemeToggle';

export default function App() {
  const [activeTab, setActiveTab] = useState<ActiveTab>('home');
  const [adminUser, setAdminUser] = useState<AdminUser | null>(null);
  const [repairSubmission, setRepairSubmission] = useState<Submission | null>(null);
  const [registeredCount, setRegisteredCount] = useState<number>(1);
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);
  const [theme, setTheme] = useState<Theme>(() => {
    return (localStorage.getItem('theme') as Theme) || 'system';
  });

  useEffect(() => {
    const root = document.documentElement;
    const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
    
    const applyTheme = () => {
      if (theme === 'dark' || (theme === 'system' && mediaQuery.matches)) {
        root.classList.add('dark');
      } else {
        root.classList.remove('dark');
      }
    };

    applyTheme();
    localStorage.setItem('theme', theme);

    if (theme === 'system') {
      const handleChange = () => applyTheme();
      mediaQuery.addEventListener('change', handleChange);
      return () => mediaQuery.removeEventListener('change', handleChange);
    }
  }, [theme]);

  // Fetch registered count for landing page hero
  const fetchRegisteredCount = async () => {
    try {
      const res = await fetch('/api/umkm');
      if (res.ok) {
        const data = await res.json();
        setRegisteredCount(data.length);
      }
    } catch (e) {
      console.error(e);
    }
  };

  useEffect(() => {
    fetchRegisteredCount();
  }, [activeTab]);

  const handleLoginSuccess = (user: AdminUser) => {
    setAdminUser(user);
    setActiveTab('admin-dashboard');
  };

  const handleLogout = () => {
    setAdminUser(null);
    setActiveTab('home');
  };

  const handleEditSubmission = (submission: Submission) => {
    setRepairSubmission(submission);
    setActiveTab('ajukan');
  };

  const handleClearEdit = () => {
    setRepairSubmission(null);
  };

  // Smooth scroll helper for sections on landing page
  const scrollToSection = (id: string) => {
    setActiveTab('home');
    setMobileMenuOpen(false);
    setTimeout(() => {
      const element = document.getElementById(id);
      if (element) {
        element.scrollIntoView({ behavior: 'smooth' });
      }
    }, 100);
  };

  const isInsideAdminDashboard = activeTab === 'admin-dashboard' && adminUser !== null;

  return (
    <div className="min-h-screen flex flex-col font-sans bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-200 antialiased select-none transition-colors duration-350">
      
      {/* PUBLIC NAVBAR - Hidden in Admin Panel or Print */}
      {!isInsideAdminDashboard && (
        <nav className="fixed top-0 w-full z-50 bg-white/80 dark:bg-slate-950/80 backdrop-blur-md border-b border-slate-200/80 dark:border-slate-800/80 shadow-sm transition-all duration-305 print:hidden">
          <div className="max-w-7xl mx-auto px-6 md:px-10 h-16 flex justify-between items-center">
            
            {/* Logo */}
            <button 
              onClick={() => { setActiveTab('home'); handleClearEdit(); }}
              className="flex items-center gap-2.5 hover:opacity-90 transition-all cursor-pointer text-left"
            >
              <img 
                src="/logo-icon.png" 
                alt="SIPANDA Logo" 
                className="w-12 h-12 object-contain rounded-full bg-white dark:bg-slate-900 p-0.5 border border-slate-200 dark:border-slate-800 shadow-sm"
              />
              <div>
                <span className="block text-[#0F172A] dark:text-white font-extrabold text-base tracking-wide leading-tight">SIPANDA</span>
                <span className="text-[9px] text-slate-400 dark:text-slate-500 font-bold uppercase tracking-widest leading-none block">Kec. Cicalengka</span>
              </div>
            </button>

            {/* Desktop Menu */}
            <div className="hidden md:flex items-center gap-8">
              <button 
                id="nav-beranda"
                onClick={() => { setActiveTab('home'); handleClearEdit(); }}
                className={`text-sm font-bold transition-all py-1.5 cursor-pointer ${
                  activeTab === 'home' 
                    ? 'text-blue-600 dark:text-blue-400 border-b-2 border-blue-600 dark:border-blue-400' 
                    : 'text-slate-500 hover:text-slate-850 dark:text-slate-400 dark:hover:text-slate-200'
                }`}
              >
                Beranda
              </button>
              <button 
                id="nav-informasi"
                onClick={() => scrollToSection('about')}
                className="text-sm font-bold text-slate-500 hover:text-slate-850 dark:text-slate-400 dark:hover:text-slate-200 transition-all py-1.5 cursor-pointer"
              >
                Informasi
              </button>
              <button 
                id="nav-syarat"
                onClick={() => scrollToSection('requirements')}
                className="text-sm font-bold text-slate-500 hover:text-slate-850 dark:text-slate-400 dark:hover:text-slate-200 transition-all py-1.5 cursor-pointer"
              >
                Syarat & FAQ
              </button>
              <button 
                id="nav-ajukan"
                onClick={() => { setActiveTab('ajukan'); handleClearEdit(); }}
                className={`text-sm font-bold transition-all py-1.5 cursor-pointer ${
                  activeTab === 'ajukan' 
                    ? 'text-blue-600 dark:text-blue-400 border-b-2 border-blue-600 dark:border-blue-400' 
                    : 'text-slate-500 hover:text-slate-850 dark:text-slate-400 dark:hover:text-slate-200'
                }`}
              >
                Ajukan Pendataan
              </button>
              <button 
                id="nav-cek-status"
                onClick={() => { setActiveTab('cek-status'); handleClearEdit(); }}
                className={`text-sm font-bold transition-all py-1.5 cursor-pointer ${
                  activeTab === 'cek-status' 
                    ? 'text-blue-600 dark:text-blue-400 border-b-2 border-blue-600 dark:border-blue-400' 
                    : 'text-slate-500 hover:text-slate-850 dark:text-slate-400 dark:hover:text-slate-200'
                }`}
              >
                Cek Status
              </button>
            </div>

            {/* Action Buttons & Theme Switcher */}
            <div className="hidden md:flex items-center gap-4">
              <ThemeToggle theme={theme} onThemeChange={setTheme} />
              
              {adminUser ? (
                <button
                  onClick={() => setActiveTab('admin-dashboard')}
                  className="px-5 py-2 bg-slate-900 hover:bg-slate-800 dark:bg-slate-800 dark:hover:bg-slate-700 text-white font-bold text-xs rounded-xl shadow-md transition-all cursor-pointer flex items-center gap-1.5"
                >
                  <ShieldCheck className="w-4 h-4 text-emerald-400" />
                  <span>Dashboard Admin</span>
                </button>
              ) : (
                <button
                  id="btn-nav-login"
                  onClick={() => setActiveTab('admin-login')}
                  className={`px-5 py-2 rounded-xl text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 border ${
                    activeTab === 'admin-login'
                      ? 'bg-blue-600 text-white border-blue-600'
                      : 'bg-white hover:bg-slate-50 dark:bg-slate-900 dark:hover:bg-slate-800 border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-200'
                  }`}
                >
                  <User className="w-3.5 h-3.5" />
                  <span>Masuk Admin</span>
                </button>
              )}
            </div>

            {/* Mobile Menu Icon & Theme Toggle */}
            <div className="flex md:hidden items-center gap-3">
              <ThemeToggle theme={theme} onThemeChange={setTheme} align="right" />
              <button 
                onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
                className="p-1.5 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg text-slate-500 dark:text-slate-400 cursor-pointer"
              >
                {mobileMenuOpen ? <X className="w-6 h-6" /> : <Menu className="w-6 h-6" />}
              </button>
            </div>
          </div>

          {/* Mobile Dropdown Menu */}
          {mobileMenuOpen && (
            <div className="md:hidden bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 px-6 py-4 space-y-3 flex flex-col items-stretch text-left">
              <button 
                onClick={() => { setActiveTab('home'); handleClearEdit(); setMobileMenuOpen(false); }}
                className={`py-2 text-sm font-bold ${activeTab === 'home' ? 'text-blue-600 dark:text-blue-400' : 'text-slate-500 dark:text-slate-400'}`}
              >
                Beranda
              </button>
              <button 
                onClick={() => scrollToSection('about')}
                className="py-2 text-sm font-bold text-slate-500 dark:text-slate-400"
              >
                Informasi
              </button>
              <button 
                onClick={() => scrollToSection('requirements')}
                className="py-2 text-sm font-bold text-slate-500 dark:text-slate-400"
              >
                Syarat & FAQ
              </button>
              <button 
                onClick={() => { setActiveTab('ajukan'); handleClearEdit(); setMobileMenuOpen(false); }}
                className={`py-2 text-sm font-bold ${activeTab === 'ajukan' ? 'text-blue-600 dark:text-blue-400' : 'text-slate-500 dark:text-slate-400'}`}
              >
                Ajukan Pendataan
              </button>
              <button 
                onClick={() => { setActiveTab('cek-status'); handleClearEdit(); setMobileMenuOpen(false); }}
                className={`py-2 text-sm font-bold ${activeTab === 'cek-status' ? 'text-blue-600 dark:text-blue-400' : 'text-slate-500 dark:text-slate-400'}`}
              >
                Cek Status
              </button>
              <div className="h-px bg-slate-100 dark:bg-slate-800 my-2"></div>
              {adminUser ? (
                <button
                  onClick={() => { setActiveTab('admin-dashboard'); setMobileMenuOpen(false); }}
                  className="py-2.5 px-4 bg-slate-900 dark:bg-slate-850 text-white font-bold text-xs rounded-xl flex items-center justify-center gap-1.5"
                >
                  <ShieldCheck className="w-4 h-4 text-emerald-400" />
                  <span>Dashboard Admin</span>
                </button>
              ) : (
                <button
                  onClick={() => { setActiveTab('admin-login'); setMobileMenuOpen(false); }}
                  className="py-2.5 px-4 bg-blue-600 text-white font-bold text-xs rounded-xl flex items-center justify-center gap-1.5"
                >
                  <User className="w-4 h-4" />
                  <span>Masuk Admin</span>
                </button>
              )}
            </div>
          )}
        </nav>
      )}

      {/* CORE VIEW PORTS */}
      <div className="flex-grow">
        {activeTab === 'home' && (
          <LandingPage onNavigate={setActiveTab} registeredCount={registeredCount} />
        )}
        {activeTab === 'ajukan' && (
          <FormPengajuan 
            onNavigate={setActiveTab} 
            editSubmission={repairSubmission} 
            onClearEdit={handleClearEdit} 
          />
        )}
        {activeTab === 'cek-status' && (
          <CekStatus onNavigate={setActiveTab} onEditSubmission={handleEditSubmission} />
        )}
        {activeTab === 'admin-login' && (
          <AdminLogin onNavigate={setActiveTab} onLoginSuccess={handleLoginSuccess} />
        )}
        {activeTab === 'admin-dashboard' && adminUser && (
          <AdminPanel onLogout={handleLogout} theme={theme} onThemeChange={setTheme} />
        )}
      </div>

      {/* PUBLIC FOOTER - Hidden in Admin Panel or Print */}
      {!isInsideAdminDashboard && (
        <footer className="bg-slate-900 text-slate-400 pt-16 pb-12 border-t border-slate-800 print:hidden text-left">
          <div className="max-w-7xl mx-auto px-6 md:px-10 grid grid-cols-1 md:grid-cols-12 gap-10">
            
            {/* Column 1: Info */}
            <div className="md:col-span-5 space-y-4">
              <div className="flex items-center gap-2.5">
                <img 
                  src="/logo-icon.png" 
                  alt="SIPANDA Logo" 
                  className="w-10 h-10 object-contain rounded-full bg-white p-0.5 border border-slate-800"
                />
                <span className="text-white font-extrabold text-base tracking-wide leading-tight">SIPANDA Cicalengka</span>
              </div>
              <p className="text-xs text-slate-400 leading-relaxed max-w-sm">
                Sistem Informasi Pengajuan dan Pendataan UMKM Seksi Pemberdayaan Masyarakat Kecamatan Cicalengka, Kabupaten Bandung. Media verifikasi data usaha formal & informal.
              </p>
              <div className="space-y-2 text-xs pt-2">
                <div className="flex gap-2.5 items-center">
                  <MapPin className="w-4 h-4 text-blue-500" />
                  <span>Jl. Raya Cicalengka No.1, Cicalengka, Bandung, 40395</span>
                </div>
                <div className="flex gap-2.5 items-center">
                  <Mail className="w-4 h-4 text-blue-500" />
                  <span>pemberdayaan@cicalengka.go.id</span>
                </div>
              </div>
            </div>

            {/* Column 2: Navigation Links */}
            <div className="md:col-span-3 space-y-4">
              <h4 className="text-xs font-bold text-white uppercase tracking-wider">Navigasi Utama</h4>
              <ul className="space-y-2 text-xs">
                <li>
                  <button onClick={() => { setActiveTab('home'); handleClearEdit(); }} className="hover:text-white transition-all cursor-pointer">
                    Beranda Utama
                  </button>
                </li>
                <li>
                  <button onClick={() => scrollToSection('about')} className="hover:text-white transition-all cursor-pointer">
                    Tentang SIPANDA
                  </button>
                </li>
                <li>
                  <button onClick={() => scrollToSection('requirements')} className="hover:text-white transition-all cursor-pointer">
                    Persyaratan Administrasi
                  </button>
                </li>
                <li>
                  <button onClick={() => { setActiveTab('ajukan'); handleClearEdit(); }} className="hover:text-white transition-all cursor-pointer">
                    Kirim Pengajuan Usaha
                  </button>
                </li>
                <li>
                  <button onClick={() => { setActiveTab('cek-status'); handleClearEdit(); }} className="hover:text-white transition-all cursor-pointer">
                    Lacak Status Berkas
                  </button>
                </li>
              </ul>
            </div>

            {/* Column 3: Regional Links */}
            <div className="md:col-span-4 space-y-4">
              <h4 className="text-xs font-bold text-white uppercase tracking-wider">Tautan Pemerintahan</h4>
              <ul className="space-y-2 text-xs">
                <li>
                  <a href="https://bandungkab.go.id" target="_blank" rel="noopener noreferrer" className="hover:text-white transition-all inline-flex items-center gap-1">
                    <span>Pemerintah Kab. Bandung</span>
                    <ExternalLink className="w-3 h-3 text-slate-500" />
                  </a>
                </li>
                <li>
                  <a href="https://jabarprov.go.id" target="_blank" rel="noopener noreferrer" className="hover:text-white transition-all inline-flex items-center gap-1">
                    <span>Portal Provinsi Jawa Barat</span>
                    <ExternalLink className="w-3 h-3 text-slate-500" />
                  </a>
                </li>
                <li>
                  <a href="https://oss.go.id" target="_blank" rel="noopener noreferrer" className="hover:text-white transition-all inline-flex items-center gap-1">
                    <span>Perizinan Berusaha OSS NIB</span>
                    <ExternalLink className="w-3 h-3 text-slate-500" />
                  </a>
                </li>
              </ul>
            </div>
          </div>

          <div className="max-w-7xl mx-auto px-6 md:px-10 border-t border-slate-800 mt-12 pt-8 flex flex-col sm:flex-row justify-between items-center gap-4">
            <p className="text-[10px] text-slate-500 font-medium">
              © {new Date().getFullYear()} Seksi Pemberdayaan Masyarakat Kecamatan Cicalengka. Hak Cipta Dilindungi.
            </p>
            <div className="flex gap-4 text-[10px] text-slate-500 font-semibold tracking-wide uppercase">
              <span>Keamanan Valid</span>
              <span>•</span>
              <span>Akurasi Data</span>
            </div>
          </div>
        </footer>
      )}
    </div>
  );
}
