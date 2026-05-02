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
        body { font-family: 'Inter', sans-serif; }
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
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-900">

    {{-- ═══ Flat Toast Notification ═══ --}}
    <div x-data x-show="$store.toast.show" x-cloak
         class="fixed bottom-6 right-6 z-[100] w-[360px]">

        <div :class="$store.toast.leaving ? 'toast-leave' : 'toast-enter'">
            <div class="bg-gray-900 rounded-lg overflow-hidden border border-gray-700">

                {{-- Content Row --}}
                <div class="flex items-center gap-3 px-4 py-3">

                    {{-- Flat Icon --}}
                    <div class="flex-shrink-0 w-8 h-8 rounded-lg flex items-center justify-center"
                         :class="{
                            'bg-emerald-500': $store.toast.type === 'success',
                            'bg-red-500': $store.toast.type === 'error',
                            'bg-amber-500': $store.toast.type === 'warning',
                            'bg-blue-500': $store.toast.type === 'info'
                         }">
                        <i class="fa-solid text-white text-xs"
                           :class="{
                               'fa-check': $store.toast.type === 'success',
                               'fa-xmark': $store.toast.type === 'error',
                               'fa-exclamation': $store.toast.type === 'warning',
                               'fa-info': $store.toast.type === 'info'
                           }"></i>
                    </div>

                    {{-- Text --}}
                    <div class="flex-1 min-w-0">
                        <p class="text-[10px] font-bold uppercase tracking-widest mb-0.5"
                           :class="{
                               'text-emerald-400': $store.toast.type === 'success',
                               'text-red-400': $store.toast.type === 'error',
                               'text-amber-400': $store.toast.type === 'warning',
                               'text-blue-400': $store.toast.type === 'info'
                           }"
                           x-text="$store.toast.type === 'success' ? 'Berhasil' : 
                                   $store.toast.type === 'error' ? 'Gagal' : 
                                   $store.toast.type === 'warning' ? 'Peringatan' : 'Informasi'"></p>
                        <p class="text-sm font-medium text-white leading-snug truncate" x-text="$store.toast.message"></p>
                    </div>

                    {{-- Close --}}
                    <button @click="$store.toast.dismiss()" 
                            class="flex-shrink-0 w-6 h-6 flex items-center justify-center rounded text-gray-500 hover:text-white transition-colors">
                        <i class="fa-solid fa-xmark text-xs"></i>
                    </button>
                </div>

                {{-- Flat Progress Bar --}}
                <div class="h-[3px] bg-gray-800">
                    <div class="h-full toast-bar"
                         :class="{
                             'bg-emerald-500': $store.toast.type === 'success',
                             'bg-red-500': $store.toast.type === 'error',
                             'bg-amber-500': $store.toast.type === 'warning',
                             'bg-blue-500': $store.toast.type === 'info'
                         }"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Sidebar --}}
    <x-sidebar />

    {{-- Main Content --}}
    <main class="ml-52 min-h-screen bg-gray-50 p-4 lg:p-5"> {{-- ml disesuaikan dengan lebar sidebar baru --}}
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
