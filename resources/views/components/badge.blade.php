{{-- resources/views/components/badge.blade.php --}}
@props([
    'type' => 'default',  {{-- success, danger, warning, info, purple, default --}}
    'dot' => true,         {{-- show dot indicator --}}
])

@php
    $styles = [
        'success' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
        'danger'  => 'bg-rose-50 text-rose-700 border-rose-200',
        'warning' => 'bg-amber-50 text-amber-700 border-amber-200',
        'info'    => 'bg-sky-50 text-sky-700 border-sky-200',
        'purple'  => 'bg-violet-50 text-violet-700 border-violet-200',
        'default' => 'bg-gray-50 text-gray-600 border-gray-200',
    ];

    $dotStyles = [
        'success' => 'bg-emerald-500',
        'danger'  => 'bg-rose-500',
        'warning' => 'bg-amber-500',
        'info'    => 'bg-sky-500',
        'purple'  => 'bg-violet-500',
        'default' => 'bg-gray-400',
    ];

    $classes = $styles[$type] ?? $styles['default'];
    $dotClass = $dotStyles[$type] ?? $dotStyles['default'];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded border $classes"]) }}>
    @if($dot)
        <span class="w-1.5 h-1.5 rounded-full {{ $dotClass }}"></span>
    @endif
    {{ $slot }}
</span>
