{{-- resources/views/components/modal.blade.php --}}
@props(['name' => 'openTambah', 'title' => 'Modal', 'maxWidth' => 'max-w-lg'])

<div
    x-show="{{ $name }}"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4"
    @click.self="{{ $name }} = false"
    style="display: none;"
>
    <div
        x-show="{{ $name }}"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="bg-white rounded-lg border border-gray-200 w-full {{ $maxWidth }}"
    >
        {{-- Modal Header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
            <h2 class="text-base font-bold text-gray-900">{{ $title }}</h2>
            <button
                @click="{{ $name }} = false"
                class="p-1.5 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Modal Body --}}
        <div class="px-6 py-5">
            {{ $slot }}
        </div>
    </div>
</div>
