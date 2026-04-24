{{-- resources/views/components/sidebar.blade.php --}}
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap');
    
    * {
        font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }
    
    h1, h2, h3, h4, h5, h6 {
        font-family: 'Plus Jakarta Sans', 'Inter', system-ui, sans-serif;
        font-weight: 600;
    }
    
    body {
        font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        letter-spacing: -0.3px;
    }
</style>

<aside id="sidebar" class="fixed top-0 left-0 z-50 flex flex-col w-48 min-h-screen bg-gray-50 border-r border-gray-200">

    {{-- Logo --}}
    <div class="px-4 py-4 border-b border-gray-200">
        <svg width="130" height="40" viewBox="0 0 148 48" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="0" y="6" width="20" height="26" rx="3" fill="#4B5563"/>
            <rect x="22" y="6" width="20" height="26" rx="3" fill="#6B7280"/>
            <line x1="21" y1="6" x2="21" y2="32" stroke="white" stroke-width="2"/>
            <circle cx="10" cy="19" r="4" fill="white" fill-opacity="0.3"/>
            <circle cx="32" cy="19" r="4" fill="white" fill-opacity="0.2"/>
            <text x="50" y="22" font-family="Plus Jakarta Sans, system-ui, sans-serif" font-size="17" font-weight="800" fill="#1F2937" letter-spacing="1">SMART</text>
            <text x="50" y="37" font-family="Plus Jakarta Sans, system-ui, sans-serif" font-size="11" font-weight="500" fill="#9CA3AF" letter-spacing="3">RAPOR</text>
        </svg>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 py-2 overflow-y-auto">

        {{-- Dashboard --}}
        <div class="px-2 mb-0.5">
            <a href="/dashboard"
               class="flex items-center gap-3 px-3 py-2 rounded text-xs font-medium transition-all duration-150
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
        <div class="px-2" x-data="{ open: {{ request()->is('data_siswa') || request()->is('data_guru') || request()->is('data_kelas') || request()->is('data_mapel') ? 'true' : 'false' }} }">
            <button @click="open = !open"
                    class="flex items-center gap-3 w-full px-3 py-2 rounded text-xs font-medium transition-all duration-150
                           {{ request()->is('data_siswa') || request()->is('data_guru') || request()->is('data_kelas') || request()->is('data_mapel')
                              ? 'bg-gray-900 text-white font-bold'
                              : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
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
                 class="mt-0.5 ml-4 pl-3 border-l-2 border-gray-200 space-y-0.5">
                <a href="data_siswa" class="block px-3 py-1.5 text-xs font-medium rounded transition-colors
                                   {{ request()->is('data_siswa') ? 'bg-gray-900 text-white font-bold' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-800' }}">
                    Data Siswa
                </a>
                <a href="data_guru" class="block px-3 py-1.5 text-xs font-medium rounded transition-colors
                                   {{ request()->is('data_guru') ? 'bg-gray-900 text-white font-bold' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-800' }}">
                    Data Guru
                </a>
                <a href="data_kelas" class="block px-3 py-1.5 text-xs font-medium rounded transition-colors
                                   {{ request()->is('data_kelas') ? 'bg-gray-900 text-white font-bold' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-800' }}">
                    Data Kelas
                </a>
                <a href="data_mapel" class="block px-3 py-1.5 text-xs font-medium rounded transition-colors
                                   {{ request()->is('data_mapel') ? 'bg-gray-900 text-white font-bold' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-800' }}">
                    Data Mapel
                </a>
            </div>
        </div>


        {{-- Akademik (Dropdown) --}}
        <div class="px-2" x-data="{ open: {{ request()->is('pengampu') || request()->is('rekap_nilai') || request()->is('input_nilai') || request()->is('presensi') ? 'true' : 'false' }} }">
            <button @click="open = !open"
                    class="flex items-center gap-3 w-full px-3 py-2 rounded text-xs font-medium transition-all duration-150
                           {{ request()->is('pengampu') || request()->is('rekap_nilai') || request()->is('input_nilai') || request()->is('presensi')
                              ? 'bg-gray-900 text-white font-bold'
                              : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
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
                 class="mt-0.5 ml-4 pl-3 border-l-2 border-gray-200 space-y-0.5">
                <a href="pengampu" class="block px-3 py-1.5 text-xs font-medium rounded transition-colors
                                   {{ request()->is('pengampu') ? 'bg-gray-900 text-white font-bold' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-800' }}">
                    Pengampu
                </a>
                <a href="rekap_nilai" class="block px-3 py-1.5 text-xs font-medium rounded transition-colors
                                   {{ request()->is('rekap_nilai') ? 'bg-gray-900 text-white font-bold' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-800' }}">
                    Rekap Nilai
                </a>
                 <a href="input_nilai" class="block px-3 py-1.5 text-xs font-medium rounded transition-colors
                                   {{ request()->is('input_nilai') ? 'bg-gray-900 text-white font-bold' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-800' }}">
                    Input nilai
                </a>
                 <a href="presensi" class="block px-3 py-1.5 text-xs font-medium rounded transition-colors
                                   {{ request()->is('presensi') ? 'bg-gray-900 text-white font-bold' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-800' }}">
                    Presensi
                </a>
            </div>
        </div>

        {{-- Rapor --}}
        <div class="px-2 mb-0.5">
            <a href="data_rapor"
               class="flex items-center gap-3 px-3 py-2 rounded text-xs font-medium transition-all duration-150
                      {{ request()->is('data_rapor')
                         ? 'bg-gray-900 text-white font-bold'
                         : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                <svg class="w-4 h-4 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                </svg>
                <span>Rapor</span>
            </a>
        </div>

        {{-- Ubah Kata Sandi --}}
        <div class="px-2">
            <a href="ubah_kata_sandi"
               class="flex items-center gap-3 px-3 py-2 rounded text-xs font-medium transition-all duration-150
                      {{ request()->is('ubah_kata_sandi')
                         ? 'bg-gray-900 text-white font-bold'
                         : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                <svg class="w-4 h-4 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 8a6 6 0 01-7.743 5.743L10 14l-1 1-1 1H6v2H2v-4l4.257-4.257A6 6 0 1118 8zm-6-4a1 1 0 100 2 2 2 0 012 2 1 1 0 102 0 4 4 0 00-4-4z" clip-rule="evenodd"/>
                </svg>
                <span>Ubah Kata Sandi</span>
            </a>
        </div>


    </nav>

    {{-- Logout --}}
    <div class="p-3 border-t border-gray-200">
        <form method="POST" action="/logout">
            @csrf
            <button type="submit"
                    class="w-full flex items-center justify-center gap-2 px-4 py-2.5 text-xs font-semibold text-white bg-red-600 rounded-lg
                           hover:bg-red-700 active:bg-red-800 transition-all duration-150 cursor-pointer shadow-sm hover:shadow-md">
                <svg class="w-4 h-4 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"/>
                </svg>
                <span>Logout</span>
            </button>
        </form>
    </div>

</aside>