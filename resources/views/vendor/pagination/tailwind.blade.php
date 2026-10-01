@if ($paginator->hasPages())
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 w-full">
        <!-- Informasi Data -->
        <div class="text-xs text-secondary-500 font-medium order-2 sm:order-1">
            Menampilkan
            @if ($paginator->firstItem())
                <span class="font-bold text-secondary-900">{{ $paginator->firstItem() }}</span>
                sampai
                <span class="font-bold text-secondary-900">{{ $paginator->lastItem() }}</span>
            @else
                {{ $paginator->count() }}
            @endif
            dari
            <span class="font-bold text-secondary-900">{{ $paginator->total() }}</span>
            total data
        </div>

        <!-- Tombol Navigasi Kanan & Kiri -->
        <div class="flex items-center justify-between sm:justify-end gap-2 w-full sm:w-auto order-1 sm:order-2">
            {{-- Tombol Sebelumnya (Kiri) --}}
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center px-3.5 py-2 text-xs font-semibold text-slate-400 bg-slate-100 border border-slate-200 cursor-not-allowed rounded-xl select-none">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    Sebelumnya
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center px-3.5 py-2 text-xs font-semibold text-secondary-700 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 hover:text-primary-600 hover:border-primary-300 transition-all shadow-sm">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    Sebelumnya
                </a>
            @endif

            {{-- Angka Halaman (Desktop) --}}
            <div class="hidden md:flex items-center gap-1">
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span class="inline-flex items-center px-3 py-1.5 text-xs font-semibold text-slate-400 bg-transparent">{{ $element }}</span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span class="inline-flex items-center px-3.5 py-2 text-xs font-bold text-white bg-primary-600 border border-primary-600 rounded-xl shadow-sm">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="inline-flex items-center px-3.5 py-2 text-xs font-semibold text-secondary-700 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 hover:text-primary-600 hover:border-primary-300 transition-all">{{ $page }}</a>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>

            {{-- Tombol Berikutnya (Kanan) --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center px-3.5 py-2 text-xs font-semibold text-secondary-700 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 hover:text-primary-600 hover:border-primary-300 transition-all shadow-sm">
                    Berikutnya
                    <svg class="w-4 h-4 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            @else
                <span class="inline-flex items-center px-3.5 py-2 text-xs font-semibold text-slate-400 bg-slate-100 border border-slate-200 cursor-not-allowed rounded-xl select-none">
                    Berikutnya
                    <svg class="w-4 h-4 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </span>
            @endif
        </div>
    </div>
@endif
