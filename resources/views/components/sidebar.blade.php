{{-- resources/views/components/sidebar.blade.php --}}

<aside id="sidebar" class="fixed top-0 left-0 z-50 flex flex-col w-52 min-h-screen bg-white border-r border-gray-200">

    {{-- Logo --}}
    <div class="px-5 py-5 border-b border-gray-100">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-gray-900 rounded flex items-center justify-center text-white">
                <i class="fa-solid fa-graduation-cap text-xs"></i>
            </div>
            <div>
                <h1 class="text-sm font-black tracking-tighter text-gray-900 leading-none">Smart<span class="text-blue-600">Rapor</span></h1>
                <p class="text-[9px] font-medium text-gray-400 tracking-tight mt-0.5">Management</p>
            </div>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 py-4 overflow-y-auto scrollbar-thin">

        {{-- Dashboard --}}
        <div class="px-2 mb-2">
            <a href="{{ route('dashboard') }}"
               class="relative flex items-center gap-3 px-3 py-2 rounded text-xs font-medium transition-all duration-150
                      {{ request()->is('dashboard')
                         ? 'bg-gray-900 text-white font-bold'
                         : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                <svg class="w-4 h-4 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M3 4a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 12a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H4a1 1 0 01-1-1v-4zM11 4a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1V4zM11 12a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"/>
                </svg>
                <span>Dashboard</span>
            </a>
        </div>


        {{-- Data Master (Dropdown) --}}
        @if(auth()->check() && auth()->user()->isAdmin())
        <div class="px-2 mb-2" x-data="{ open: {{ request()->is('data_siswa') || request()->is('data_guru') || request()->is('data_kelas') || request()->is('data_mapel') ? 'true' : 'false' }} }">
            <button @click="open = !open"
                    class="relative flex items-center gap-3 w-full px-3 py-2 rounded text-xs font-medium transition-all duration-150
                           {{ request()->is('data_siswa') || request()->is('data_guru') || request()->is('data_kelas') || request()->is('data_mapel')
                              ? 'bg-gray-900 text-white font-semibold'
                              : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900 font-medium' }}">
                <svg class="w-4 h-4 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M3 12v3c0 1.657 3.134 3 7 3s7-1.343 7-3v-3c0 1.657-3.134 3-7 3s-7-1.343-7-3z"/>
                    <path d="M3 7v3c0 1.657 3.134 3 7 3s7-1.343 7-3V7c0 1.657-3.134 3-7 3S3 8.657 3 7z"/>
                    <path d="M17 5c0 1.657-3.134 3-7 3S3 6.657 3 5s3.134-3 7-3 7 1.343 7 3z"/>
                </svg>
                <span class="flex-1 text-left">Data Master</span>
                <svg class="w-3 h-3 flex-shrink-0 transition-transform duration-200"
                     :class="{ 'rotate-180': open }"
                     viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
            </button>

            <div x-show="open"
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0 -translate-y-1"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="mt-1 ml-4 pl-3 border-l border-gray-200 space-y-1">
                <a href="{{ route('data_siswa') }}" class="block px-3 py-1.5 text-xs font-medium rounded transition-all
                                   {{ request()->is('data_siswa') ? 'bg-gray-900 text-white font-bold shadow-sm' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-800' }}">
                    Siswa
                </a>
                <a href="{{ route('data_guru') }}" class="block px-3 py-1.5 text-xs font-medium rounded transition-all
                                   {{ request()->is('data_guru') ? 'bg-gray-900 text-white font-bold shadow-sm' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-800' }}">
                    Guru
                </a>
                <a href="{{ route('data_kelas') }}" class="block px-3 py-1.5 text-xs font-medium rounded transition-all
                                   {{ request()->is('data_kelas') ? 'bg-gray-900 text-white font-bold shadow-sm' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-800' }}">
                    Kelas
                </a>
                <a href="{{ route('data_mapel') }}" class="block px-3 py-1.5 text-xs font-medium rounded transition-all
                                   {{ request()->is('data_mapel') ? 'bg-gray-900 text-white font-bold shadow-sm' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-800' }}">
                    Mata Pelajaran
                </a>
            </div>
        </div>
        @endif


        {{-- Akademik (Dropdown) --}}
        <div class="px-2 mb-2" x-data="{ open: {{ request()->is('pengampu') || request()->is('rekap_nilai') || request()->is('input_nilai') ? 'true' : 'false' }} }">
            <button @click="open = !open"
                    class="relative flex items-center gap-3 w-full px-3 py-2 rounded text-xs font-medium transition-all duration-150
                           {{ request()->is('pengampu') || request()->is('rekap_nilai') || request()->is('input_nilai')
                              ? 'bg-gray-900 text-white font-semibold'
                              : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900 font-medium' }}">
                <svg class="w-4 h-4 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                </svg>
                <span class="flex-1 text-left">Akademik</span>
                <svg class="w-3 h-3 flex-shrink-0 transition-transform duration-200"
                     :class="{ 'rotate-180': open }"
                     viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
            </button>

            <div x-show="open"
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0 -translate-y-1"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="mt-1 ml-4 pl-3 border-l border-gray-200 space-y-1">
                @if(auth()->check() && auth()->user()->isAdmin())
                <a href="{{ route('pengampu') }}" class="block px-3 py-1.5 text-xs font-medium rounded transition-all
                                   {{ request()->is('pengampu') ? 'bg-gray-900 text-white font-bold shadow-sm' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-800' }}">
                    Pengampu
                </a>
                <a href="{{ route('rekap_nilai') }}" class="block px-3 py-1.5 text-xs font-medium rounded transition-all
                                   {{ request()->is('rekap_nilai') ? 'bg-gray-900 text-white font-bold shadow-sm' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-800' }}">
                    Rekap Nilai
                </a>
                @endif
                @if(auth()->check() && auth()->user()->isGuru())
                 <a href="{{ route('input_nilai') }}" class="block px-3 py-1.5 text-xs font-medium rounded transition-all
                                   {{ request()->is('input_nilai') ? 'bg-gray-900 text-white font-bold shadow-sm' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-800' }}">
                    Input Nilai
                </a>

                @endif
            </div>
        </div>

        {{-- Rapor (Hanya Admin & Wali Kelas) --}}
        @if(auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isWaliKelas()))
        <div class="px-2 mb-2">
            <a href="{{ route('data_rapor') }}"
               class="relative flex items-center gap-3 px-3 py-2 rounded text-xs font-medium transition-all duration-150
                      {{ request()->is('data_rapor')
                         ? 'bg-gray-900 text-white font-semibold'
                         : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900 font-medium' }}">
                <svg class="w-4 h-4 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                </svg>
                <span>Rapor Siswa</span>
            </a>
        </div>
        @endif

        {{-- Pengaturan Akun --}}
        <div class="px-2">
            <a href="{{ route('ubah_kata_sandi') }}"
               class="relative flex items-center gap-3 px-3 py-2 rounded text-xs font-medium transition-all duration-150
                      {{ request()->is('ubah_kata_sandi')
                         ? 'bg-gray-900 text-white font-semibold'
                         : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900 font-medium' }}">
                <svg class="w-4 h-4 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                </svg>
                <span>Pengaturan Akun</span>
            </a>
        </div>


    </nav>

    {{-- Logout --}}
    <div class="p-3 border-t border-gray-200">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="w-full flex items-center justify-center gap-2 px-4 py-2.5 text-xs font-semibold text-white bg-red-600 rounded
                           hover:bg-red-700 active:bg-red-800 transition-all duration-150 cursor-pointer shadow-sm hover:shadow-md">
                <svg class="w-4 h-4 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"/>
                </svg>
                <span>Logout</span>
            </button>
        </form>
    </div>

</aside>