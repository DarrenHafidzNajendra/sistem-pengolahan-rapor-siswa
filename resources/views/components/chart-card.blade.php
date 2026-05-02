{{-- resources/views/components/chart-card.blade.php --}}
@props(['title', 'icon' => ''])

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-300">
    <div class="px-4 py-3 border-b border-gray-50 flex items-center justify-between bg-gray-50/30">
        <div class="flex items-center gap-2">
            @if($icon)
                <div class="w-7 h-7 rounded-lg bg-white shadow-sm border border-gray-100 flex items-center justify-center text-gray-400 scale-90">
                    {!! $icon !!}
                </div>
            @endif
            <h3 class="text-xs font-bold text-gray-700 tracking-tight">{{ $title }}</h3>
        </div>
        <div class="flex gap-1">
            <div class="w-1 h-1 rounded-full bg-gray-200"></div>
            <div class="w-1 h-1 rounded-full bg-gray-200"></div>
        </div>
    </div>
    <div class="p-4"> {{-- Padding dikurangi dari p-6 menjadi p-4 --}}
        {{ $slot }}
    </div>
</div>
