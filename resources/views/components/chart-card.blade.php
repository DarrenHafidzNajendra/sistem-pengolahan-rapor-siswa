{{-- resources/views/components/chart-card.blade.php --}}
@props(['title' => '', 'icon' => ''])

<div class="bg-white rounded-lg border border-gray-200 p-6">
    @if($title)
    <div class="flex items-center gap-2 mb-4">
        @if($icon) <div class="text-gray-400">{!! $icon !!}</div> @endif
        <h3 class="text-sm font-bold text-gray-900">{{ $title }}</h3>
    </div>
    @endif
    {{ $slot }}
</div>
