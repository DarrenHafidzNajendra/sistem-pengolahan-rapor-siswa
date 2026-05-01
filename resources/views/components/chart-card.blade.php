{{-- resources/views/components/chart-card.blade.php --}}
@props(['title', 'icon' => ''])

<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-sm font-medium text-gray-700">{{ $title }}</h3>
        @if($icon)
            {!! $icon !!}
        @endif
    </div>
    {{ $slot }}
</div>
