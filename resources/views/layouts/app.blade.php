<!DOCTYPE html>
<html lang="en" class="text-[14px]"> {{-- Mengecilkan basis ukuran font --}}
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Sistem Pengolahan Rapor</title>
    
    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    {{-- CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Poppins', sans-serif; }
        {{-- Mengoptimalkan tampilan pada zoom 100% agar lebih padat --}}
        input, select, button { font-size: 0.875rem !important; }
    </style>

    {{-- Alpine.js --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('toast', {
                show: false,
                message: '',
                type: 'success',
                showNotification(msg, type = 'success') {
                    this.show = true;
                    this.message = msg;
                    this.type = type;
                    setTimeout(() => { this.show = false; }, 3000);
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

    {{-- Global Toast Notification --}}
    <div x-data x-show="$store.toast.show" 
         x-transition:enter="transition ease-out duration-300"
         class="fixed bottom-5 right-5 z-[100] max-w-sm w-full"
         x-cloak>
        <div class="bg-white/80 backdrop-blur-md border border-gray-100 shadow-2xl rounded-xl p-3 flex items-center gap-3">
            <div class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center bg-green-500 text-white shadow-lg">
                <i class="fa-solid fa-check text-sm"></i>
            </div>
            <div class="flex-1">
                <p class="text-xs font-bold text-gray-900" x-text="$store.toast.message"></p>
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
