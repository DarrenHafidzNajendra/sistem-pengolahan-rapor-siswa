{{-- resources/views/components/pagination.blade.php --}}
@props(['paginator' => null, 'from' => 1, 'to' => 20, 'total' => 0, 'lastPage' => 1])

@php
    // Jika paginator object diberikan, ambil data dari situ
    if ($paginator) {
        $from = $paginator->firstItem() ?? 0;
        $to = $paginator->lastItem() ?? 0;
        $total = $paginator->total();
        $lastPage = $paginator->lastPage();
        $currentPage = $paginator->currentPage();
    } else {
        $currentPage = 1;
    }
@endphp

<div class="px-6 py-4 border-t border-gray-200 flex flex-col md:flex-row items-start md:items-center justify-between gap-4 bg-gray-50">
    <span class="text-sm text-gray-600 font-medium">Menampilkan <span class="text-gray-900 font-bold">{{ $from }} - {{ $to }}</span> dari <span class="text-gray-900 font-bold">{{ $total }}</span> data</span>

    @if($lastPage > 1)
    <div class="flex items-center gap-2">
        {{-- Tombol Previous --}}
        @if($paginator && $paginator->onFirstPage())
            <button class="p-2 text-gray-600 border border-gray-300 rounded-lg disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </button>
        @elseif($paginator)
            <a href="{{ $paginator->previousPageUrl() }}" class="p-2 text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
        @endif

        {{-- Nomor Halaman --}}
        <div class="flex items-center gap-1">
            @foreach($paginator->getUrlRange(1, $lastPage) as $page => $url)
                @if($lastPage <= 7 || $page <= 3 || $page >= $lastPage - 1 || abs($page - $currentPage) <= 1)
                    @if($page === $currentPage)
                        <button class="px-3 py-2 text-sm font-semibold text-white bg-gray-900 rounded-lg">{{ $page }}</button>
                    @else
                        <a href="{{ $url }}" class="px-3 py-2 text-sm font-medium text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition-colors">{{ $page }}</a>
                    @endif
                @elseif($page === 4 || $page === $lastPage - 2)
                    <span class="px-2 text-gray-500">...</span>
                @endif
            @endforeach
        </div>

        {{-- Tombol Next --}}
        @if($paginator && $paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="p-2 text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        @elseif($paginator)
            <button class="p-2 text-gray-600 border border-gray-300 rounded-lg disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>
        @endif
    </div>
    @endif
</div>
