{{-- resources/views/components/stat-card.blade.php --}}
@props(['label', 'value', 'icon' => ''])

<div class="bg-white rounded border border-gray-200 p-4">
    <div class="flex items-center justify-between mb-3">
        <span class="text-[11px] font-semibold text-gray-400 tracking-tight">{{ $label }}</span>
        @if($icon)
            <div class="text-gray-400 scale-75 opacity-70">
                {!! $icon !!}
            </div>
        @endif
    </div>
    <div class="flex items-baseline gap-1">
        <span class="text-2xl font-black text-gray-900 tracking-tight">{{ $value }}</span>
        <span class="text-[10px] font-semibold text-green-600 bg-green-50 px-1.5 py-0.5 rounded">Data</span>
    </div>
</div>
