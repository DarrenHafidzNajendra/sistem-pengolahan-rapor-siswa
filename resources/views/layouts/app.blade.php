<!DOCTYPE html>
<html lang="en" class="text-[14px]"> {{-- Mengecilkan basis ukuran font --}}
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Sistem Pengolahan Rapor</title>
    
    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    
    {{-- CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <style>
        [x-cloak] { display: none !important; }
        body { 
            font-family: 'Inter', sans-serif; 
            letter-spacing: -0.03em; /* Slightly more aggressive tightening for Inter */
        }
        {{-- Mengoptimalkan tampilan pada zoom 100% agar lebih padat --}}
        input, select, button { font-size: 0.875rem !important; }

        /* ── Flat Toast Animations ── */
        @keyframes toast-in {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes toast-out {
            from { opacity: 1; transform: translateY(0); }
            to   { opacity: 0; transform: translateY(12px); }
        }
        @keyframes toast-countdown {
            from { width: 100%; }
            to   { width: 0%; }
        }
        .toast-enter { animation: toast-in 0.3s ease-out forwards; }
        .toast-leave { animation: toast-out 0.25s ease-in forwards; }
        .toast-bar   { animation: toast-countdown 3.5s linear forwards; }
    </style>

    {{-- Alpine.js --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('toast', {
                show: false,
                leaving: false,
                message: '',
                type: 'success',
                _timer: null,

                showNotification(msg, type = 'success') {
                    if (this._timer) clearTimeout(this._timer);
                    this.leaving = false;
                    this.show = true;
                    this.message = msg;
                    this.type = type;
                    this._timer = setTimeout(() => this.dismiss(), 3500);
                },

                dismiss() {
                    this.leaving = true;
                    setTimeout(() => {
                        this.show = false;
                        this.leaving = false;
                    }, 250);
                }
            });
        });

        window.addEventListener('notify', (e) => {
            Alpine.store('toast').showNotification(e.detail.message, e.detail.type);
        });
    </script>

    @stack('head-scripts')
    @stack('styles')
<body class="bg-gray-50 font-sans antialiased text-gray-900" @yield('body-attrs')>
 
    {{-- ═══ Global Notifications (Success Modal) ═══ --}}
    <div x-data="{ showSuccess: false, successMsg: '' }" 
         @notify.window="
            if(($event.detail.type || 'success') === 'success') { 
                setTimeout(() => {
                    showSuccess = true; 
                    successMsg = $event.detail.message;
                }, 300);
            }
         ">
        {{-- 🟢 Flat Success Pop-up Modal --}}
        <div x-show="showSuccess" 
             x-transition:enter="transition opacity ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition opacity ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-[150] flex items-center justify-center p-4 bg-gray-900/50" x-cloak>
            
            {{-- Card with its own transition --}}
            <div x-show="showSuccess"
                 x-transition:enter="transition ease-out duration-300 delay-75"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="bg-white rounded-xl p-8 max-w-sm w-full shadow-2xl text-center border border-gray-100">
                <div class="w-16 h-16 bg-emerald-50 text-emerald-500 rounded-full flex items-center justify-center mx-auto mb-5">
                    <i class="fa-solid fa-check text-2xl"></i>
                </div>
                <h2 class="text-lg font-bold text-gray-900 mb-1">Berhasil</h2>
                <p class="text-[12px] font-medium text-gray-500 mb-8 leading-relaxed px-4" x-text="successMsg"></p>
                <button @click="showSuccess = false" 
                        class="w-full py-3 bg-gray-900 text-white text-xs font-bold rounded hover:bg-gray-800 transition-all active:scale-[0.98]">
                    Selesai
                </button>
            </div>
        </div>
    </div>

        {{-- 🔴 Static Error Alerts (Akan muncul di posisi absolut di atas konten melalui portal atau tetap di sini) --}}
        {{-- Note: Agar error tetap di atas konten, saya akan memisahkannya atau menaruhnya di main. --}}
    </div>

    {{-- Sidebar --}}
    <x-sidebar />
 
    {{-- Main Content --}}
    <main class="ml-52 min-h-screen bg-gray-50 p-4 lg:p-5"> {{-- ml disesuaikan dengan lebar sidebar baru --}}
        <div class="flex flex-col gap-5">
            {{-- Error Alerts di dalam main agar tetap nempel di atas konten --}}
            <div class="space-y-3">
                @if(session('error'))
                    <div x-data="{ show: true }" x-show="show" x-transition
                         class="p-4 bg-red-50 border border-red-200 rounded text-red-700 text-xs font-bold flex items-center justify-between shadow-sm transition-all">
                        <div class="flex items-center gap-3">
                            <div class="w-6 h-6 rounded bg-red-500 text-white flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-triangle-exclamation text-[10px]"></i>
                            </div>
                            <span>{{ session('error') }}</span>
                        </div>
                        <button @click="show = false" class="text-red-400 hover:text-red-700">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                @endif

                @if($errors->any())
                    <div x-data="{ show: true }" x-show="show" x-transition
                         class="p-4 bg-red-50 border border-red-200 rounded text-red-700 text-xs font-bold space-y-2 shadow-sm border-l-4 border-l-red-500 transition-all relative">
                        <div class="flex items-center gap-2 mb-1">
                            <i class="fa-solid fa-circle-xmark"></i>
                            <span class="uppercase tracking-wider">Terjadi Kesalahan:</span>
                        </div>
                        <ul class="list-disc list-inside pl-1 space-y-1 font-medium text-[11px]">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button @click="show = false" class="absolute top-4 right-4 text-red-400 hover:text-red-700">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                @endif
            </div>
        </div>

        @yield('content')
    </div>
</main>

    @stack('scripts')
    
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            @if(session('success'))
                window.dispatchEvent(new CustomEvent('notify', {
                    detail: { message: "{{ session('success') }}", type: 'success' }
                }));
            @endif

            @if(session('error'))
                window.dispatchEvent(new CustomEvent('notify', {
                    detail: { message: "{{ session('error') }}", type: 'error' }
                }));
            @endif
        });
    </script>
</body>
</html>
