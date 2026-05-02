{{-- resources/views/components/search-toolbar.blade.php --}}
@props([
    'placeholder' => 'Cari...',
    'filterOptions' => [],
    'filterLabel' => 'Filter Status',
    'showFilter' => true,
    'showTambah' => true,
    'tambahClick' => 'openTambah = true',
])

<div class="p-6 border-b border-gray-200">
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        {{-- Left: Search Input --}}
        <div class="w-full md:w-auto md:max-w-xs">
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" placeholder="{{ $placeholder }}"
                       class="w-full pl-10 pr-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:border-gray-900 transition-colors bg-white">
            </div>
        </div>

        {{-- Right: Filter & Tombol Tambah --}}
        <div class="flex items-center gap-3 w-full md:w-auto">
            @if($showFilter)
            <select class="flex-1 md:flex-none px-4 py-2.5 text-sm font-medium text-gray-700 border border-gray-300 rounded-lg focus:outline-none focus:border-gray-900 transition-colors bg-white cursor-pointer">
                <option>{{ $filterLabel }}</option>
                @foreach($filterOptions as $option)
                    <option>{{ $option }}</option>
                @endforeach
            </select>
            @endif

            @if($showTambah)
            {{-- Tombol Tambah — membuka modal --}}
            <button
                @click="{{ $tambahClick }}"
                class="px-5 py-2.5 bg-gray-900 text-white text-sm font-semibold rounded-lg hover:bg-gray-800 transition-colors flex items-center gap-2 whitespace-nowrap"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span>Tambah</span>
            </button>
            @endif
        </div>
    </div>
</div>
