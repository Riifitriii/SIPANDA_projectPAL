@if ($paginator->hasPages())
    <div class="flex items-center justify-between w-full">
        {{-- Tombol Sebelumnya (Kiri) --}}
        @if ($paginator->onFirstPage())
            <span class="inline-flex items-center px-4 py-2 text-xs font-semibold text-slate-400 bg-slate-100 border border-slate-200 cursor-not-allowed rounded-xl select-none">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                Sebelumnya
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center px-4 py-2 text-xs font-semibold text-secondary-700 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 hover:text-primary-600 hover:border-primary-300 transition-all shadow-sm">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                Sebelumnya
            </a>
        @endif

        {{-- Tombol Berikutnya (Kanan) --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center px-4 py-2 text-xs font-semibold text-secondary-700 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 hover:text-primary-600 hover:border-primary-300 transition-all shadow-sm">
                Berikutnya
                <svg class="w-4 h-4 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        @else
            <span class="inline-flex items-center px-4 py-2 text-xs font-semibold text-slate-400 bg-slate-100 border border-slate-200 cursor-not-allowed rounded-xl select-none">
                Berikutnya
                <svg class="w-4 h-4 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </span>
        @endif
    </div>
@endif
