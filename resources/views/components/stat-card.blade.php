{{-- resources/views/components/stat-card.blade.php --}}
@props(['label', 'value', 'icon' => ''])

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 hover:shadow-md transition-all duration-300">
    <div class="flex items-center justify-between mb-3">
        <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">{{ $label }}</span>
        @if($icon)
            <div class="text-gray-400 scale-75 opacity-70">
                {!! $icon !!}
            </div>
        @endif
    </div>
    <div class="flex items-baseline gap-1">
        <span class="text-2xl font-black text-gray-900 tracking-tight">{{ $value }}</span>
        <span class="text-[10px] font-bold text-green-500 bg-green-50 px-1.5 py-0.5 rounded uppercase">Data</span>
    </div>
</div>
