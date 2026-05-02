{{-- resources/views/components/pagination.blade.php --}}
@props(['from' => 1, 'to' => 20, 'total' => 432, 'lastPage' => 22])

<div class="px-6 py-4 border-t border-gray-200 flex flex-col md:flex-row items-start md:items-center justify-between gap-4 bg-gray-50">
    <span class="text-sm text-gray-600 font-medium">Menampilkan <span class="text-gray-900 font-bold">{{ $from }} - {{ $to }}</span> dari <span class="text-gray-900 font-bold">{{ $total }}</span> data</span>

    <div class="flex items-center gap-2">
        <button class="p-2 text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition-colors disabled:opacity-50 disabled:cursor-not-allowed" disabled>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>

        <div class="flex items-center gap-1">
            <button class="px-3 py-2 text-sm font-semibold text-white bg-gray-900 rounded-lg">1</button>
            <button class="px-3 py-2 text-sm font-medium text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition-colors">2</button>
            <button class="px-3 py-2 text-sm font-medium text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition-colors">3</button>
            <span class="px-2 text-gray-500">...</span>
            <button class="px-3 py-2 text-sm font-medium text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition-colors">{{ $lastPage }}</button>
        </div>

        <button class="p-2 text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </button>
    </div>
</div>
