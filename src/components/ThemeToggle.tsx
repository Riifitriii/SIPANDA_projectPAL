import React, { useState, useEffect, useRef } from 'react';
import { Sun, Moon, Monitor } from 'lucide-react';

export type Theme = 'light' | 'dark' | 'system';

interface ThemeToggleProps {
  theme: Theme;
  onThemeChange: (theme: Theme) => void;
  align?: 'left' | 'right';
}

export default function ThemeToggle({ theme, onThemeChange, align = 'right' }: ThemeToggleProps) {
  const [isOpen, setIsOpen] = useState(false);
  const dropdownRef = useRef<HTMLDivElement>(null);

  // Close dropdown when clicking outside
  useEffect(() => {
    function handleClickOutside(event: MouseEvent) {
      if (dropdownRef.current && !dropdownRef.current.contains(event.target as Node)) {
        setIsOpen(false);
      }
    }
    document.addEventListener('mousedown', handleClickOutside);
    return () => document.removeEventListener('mousedown', handleClickOutside);
  }, []);

  const themeOptions = [
    {
      value: 'light' as Theme,
      label: 'Terang',
      icon: Sun,
      colorClass: 'text-amber-500',
    },
    {
      value: 'dark' as Theme,
      label: 'Gelap',
      icon: Moon,
      colorClass: 'text-indigo-400',
    },
    {
      value: 'system' as Theme,
      label: 'Sistem',
      icon: Monitor,
      colorClass: 'text-slate-400 dark:text-slate-500',
    },
  ];

  const currentOption = themeOptions.find(opt => opt.value === theme) || themeOptions[2];
  const IconComponent = currentOption.icon;

  return (
    <div className="relative inline-block text-left" ref={dropdownRef}>
      {/* Toggle Button */}
      <button
        onClick={() => setIsOpen(!isOpen)}
        type="button"
        className="flex items-center justify-center w-9 h-9 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800/80 transition-all cursor-pointer focus:outline-none"
        aria-haspopup="true"
        aria-expanded={isOpen}
        title={`Tema saat ini: ${currentOption.label}`}
      >
        <IconComponent className={`w-4 h-4 transition-transform duration-300 ${currentOption.colorClass}`} />
      </button>

      {/* Dropdown menu */}
      {isOpen && (
        <div
          className={`absolute ${align === 'right' ? 'right-0' : 'left-0'} mt-2 w-36 rounded-xl border border-slate-100 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-xl ring-1 ring-black/5 focus:outline-none z-50 overflow-hidden transition-all`}
          role="menu"
        >
          <div className="py-1">
            {themeOptions.map((option) => {
              const OptIcon = option.icon;
              const isSelected = theme === option.value;
              return (
                <button
                  key={option.value}
                  onClick={() => {
                    onThemeChange(option.value);
                    setIsOpen(false);
                  }}
                  className={`w-full flex items-center gap-2.5 px-3 py-2 text-left text-xs font-bold transition-colors cursor-pointer ${
                    isSelected
                      ? 'bg-blue-50 dark:bg-blue-950/40 text-blue-600 dark:text-blue-400'
                      : 'text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800/50'
                  }`}
                  role="menuitem"
                >
                  <OptIcon className={`w-3.5 h-3.5 ${option.colorClass}`} />
                  <span>{option.label}</span>
                </button>
              );
            })}
          </div>
        </div>
      )}
    </div>
  );
}
