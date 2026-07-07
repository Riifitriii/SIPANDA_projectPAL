import React, { useState } from 'react';
import { motion } from 'motion/react';
import { 
  Lock, 
  User, 
  ShieldAlert, 
  Loader2, 
  ArrowLeft,
  KeyRound
} from 'lucide-react';
import { ActiveTab } from '../types';

interface AdminLoginProps {
  onNavigate: (tab: ActiveTab) => void;
  onLoginSuccess: (adminUser: any) => void;
}

export default function AdminLogin({ onNavigate, onLoginSuccess }: AdminLoginProps) {
  const [username, setUsername] = useState('');
  const [password, setPassword] = useState('');
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState<string | null>(null);

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setLoading(true);
    setError(null);

    try {
      const response = await fetch('/api/login', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ username, password }),
      });

      const data = await response.json();
      if (response.ok && data.success) {
        onLoginSuccess(data.user);
        onNavigate('admin-dashboard');
      } else {
        setError(data.message || 'Kredensial tidak valid. Silakan coba lagi.');
      }
    } catch (err) {
      setError('Terjadi kesalahan koneksi ke server.');
    } finally {
      setLoading(false);
    }
  };

  return (
    <div id="login-view" className="pt-24 pb-16 min-h-screen bg-slate-50 flex items-center justify-center px-6">
      <motion.div 
        initial={{ opacity: 0, y: 15 }}
        animate={{ opacity: 1, y: 0 }}
        className="w-full max-w-md bg-white border border-slate-200 rounded-3xl p-8 shadow-xl space-y-6"
      >
        {/* Header/Branding */}
        <div className="text-center space-y-3">
          <img 
            src="/logo-icon.png" 
            alt="SIPANDA Logo" 
            className="mx-auto w-20 h-20 object-contain rounded-full bg-white p-1 border border-slate-200 shadow-md"
          />
          <div className="space-y-1">
            <h2 className="text-2xl font-extrabold text-slate-900 tracking-tight">Portal Admin SIPANDA</h2>
            <p className="text-xs text-slate-400 font-semibold uppercase tracking-wider">Kecamatan Cicalengka</p>
          </div>
        </div>

        {error && (
          <motion.div 
            initial={{ opacity: 0, y: -5 }}
            animate={{ opacity: 1, y: 0 }}
            className="p-3.5 bg-red-50 border border-red-200 text-red-800 rounded-2xl flex gap-3 text-xs items-center text-left font-medium"
          >
            <ShieldAlert className="w-4 h-4 shrink-0 text-red-600" />
            <span>{error}</span>
          </motion.div>
        )}

        {/* Form */}
        <form onSubmit={handleSubmit} className="space-y-4">
          <div className="space-y-1.5 text-left">
            <label className="text-xs font-bold text-slate-500 uppercase tracking-wider">Username</label>
            <div className="relative">
              <input
                type="text"
                required
                value={username}
                onChange={(e) => setUsername(e.target.value)}
                placeholder="Masukkan username"
                className="w-full bg-slate-50 text-slate-800 border border-slate-200 rounded-xl pl-10 pr-4 py-3 text-sm focus:bg-white outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition-all"
              />
              <User className="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" />
            </div>
          </div>

          <div className="space-y-1.5 text-left">
            <label className="text-xs font-bold text-slate-500 uppercase tracking-wider">Password</label>
            <div className="relative">
              <input
                type="password"
                required
                value={password}
                onChange={(e) => setPassword(e.target.value)}
                placeholder="Masukkan password"
                className="w-full bg-slate-50 text-slate-800 border border-slate-200 rounded-xl pl-10 pr-4 py-3 text-sm focus:bg-white outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition-all"
              />
              <Lock className="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" />
            </div>
          </div>

          {/* Quick Info Box */}
          <div className="bg-slate-50 border border-slate-200/60 p-3.5 rounded-2xl text-left flex gap-2.5 items-start">
            <KeyRound className="w-4.5 h-4.5 text-blue-500 shrink-0 mt-0.5" />
            <div className="text-[10px] text-slate-500 leading-normal">
              <span className="font-bold text-slate-700 block">Kredensial Pengujian:</span>
              <span>Username: <strong className="text-slate-800 font-bold select-all">admin</strong> | Password: <strong className="text-slate-800 font-bold select-all">admin</strong></span>
            </div>
          </div>

          <button
            id="btn-login-masuk"
            type="submit"
            disabled={loading}
            className="w-full py-3.5 bg-blue-600 hover:bg-blue-500 text-white rounded-xl font-bold text-sm shadow-md transition-all flex items-center justify-center gap-2 cursor-pointer"
          >
            {loading ? (
              <>
                <Loader2 className="w-4 h-4 animate-spin" />
                <span>Memproses...</span>
              </>
            ) : (
              <span>Masuk Sistem</span>
            )}
          </button>
        </form>

        <div className="border-t border-slate-100 pt-4">
          <button
            onClick={() => onNavigate('home')}
            className="text-xs font-bold text-slate-400 hover:text-slate-600 inline-flex items-center gap-1 cursor-pointer"
          >
            <ArrowLeft className="w-3.5 h-3.5" />
            <span>Kembali ke Beranda</span>
          </button>
        </div>
      </motion.div>
    </div>
  );
}
