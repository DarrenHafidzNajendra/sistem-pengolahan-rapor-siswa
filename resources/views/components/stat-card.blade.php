{{-- resources/views/components/stat-card.blade.php --}}
@props(['label', 'value', 'icon' => ''])

<div class="bg-white rounded-lg shadow-md p-5">
    <div class="flex items-center justify-between mb-2">
        <span class="text-gray-600 text-sm font-medium">{{ $label }}</span>
        @if($icon)
            {!! $icon !!}
        @endif
    </div>
    <p class="text-4xl font-bold text-gray-900">{{ $value }}</p>
</div>
