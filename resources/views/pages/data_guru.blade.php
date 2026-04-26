<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Rapor — Data Guru</title>

    {{-- Google Fonts - Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.3.0/dist/flowbite.min.js"></script>

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>
<body class="bg-gray-50">

    {{-- Sidebar --}}
    @include('components.sidebar_admin')

    {{-- Main Content --}}
    <main class="ml-48 min-h-screen bg-gray-50 p-6">
        <div class="max-w-full">
            {{-- Card Container --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                {{-- Toolbar --}}
                <div class="p-6 border-b border-gray-200">
                    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                        {{-- Left: Search Input --}}
                        <div class="w-full md:w-auto md:max-w-xs">
                            <div class="relative group">
                                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                <input type="text" placeholder="Cari NIP, nama..." 
                                       class="w-full pl-10 pr-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all bg-white hover:border-gray-400">
                            </div>
                        </div>
                        
                        {{-- Right: Buttons --}}
                        <div class="flex items-center gap-3 w-full md:w-auto">
                            <select class="flex-1 md:flex-none px-4 py-2.5 text-sm font-medium text-gray-700 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all bg-white hover:border-gray-400">
                                <option>Filter Status</option>
                                <option>Aktif</option>
                                <option>Tidak Aktif</option>
                            </select>
                            
                            <button class="px-5 py-2.5 bg-gray-900 text-white text-sm font-semibold rounded-lg hover:bg-gray-800 active:bg-gray-700 transition-all flex items-center gap-2 whitespace-nowrap shadow-sm hover:shadow-md">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                <span>Tambah</span>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Table Section --}}
                <div class="overflow-x-auto">
                    <table class="w-full">
                        {{-- Table Head --}}
                        <thead class="bg-gradient-to-r from-gray-900 to-gray-800 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider cursor-pointer hover:opacity-80 transition-opacity">
                                    <div class="flex items-center gap-2">
                                        <span>NO</span>
                                        <svg class="w-3.5 h-3.5 opacity-60" fill="currentColor" viewBox="0 0 20 20"><path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3z"/></svg>
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider cursor-pointer hover:opacity-80 transition-opacity">
                                    <div class="flex items-center gap-2">
                                        <span>NIP</span>
                                        <svg class="w-3.5 h-3.5 opacity-60" fill="currentColor" viewBox="0 0 20 20"><path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3z"/></svg>
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider cursor-pointer hover:opacity-80 transition-opacity">
                                    <div class="flex items-center gap-2">
                                        <span>Nama</span>
                                        <svg class="w-3.5 h-3.5 opacity-60" fill="currentColor" viewBox="0 0 20 20"><path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3z"/></svg>
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider cursor-pointer hover:opacity-80 transition-opacity">
                                    <div class="flex items-center gap-2">
                                        <span>Jenis Kelamin</span>
                                        <svg class="w-3.5 h-3.5 opacity-60" fill="currentColor" viewBox="0 0 20 20"><path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3z"/></svg>
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">No. HP</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-white uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>

                        {{-- Table Body --}}
                        <tbody class="divide-y divide-gray-200">
                            {{-- Row 1 --}}
                            <tr class="hover:bg-blue-50 transition-colors duration-150 border-l-4 border-transparent hover:border-blue-500">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">1</td>
                                <td class="px-6 py-4 text-sm text-gray-700 font-semibold">19870305200901001</td>
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">Budi Santoso, S.Pd</td>
                                <td class="px-6 py-4 text-sm text-gray-700">Laki - Laki</td>
                                <td class="px-6 py-4 text-sm"><span class="px-3 py-1.5 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Aktif</span></td>
                                <td class="px-6 py-4 text-sm text-gray-600">0812345678901</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2 flex-wrap">
                                        <button title="Lihat Detail" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 active:bg-blue-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg><span>Lihat</span></button>
                                        <button title="Edit Data" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-amber-600 hover:bg-amber-700 active:bg-amber-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg><span>Edit</span></button>
                                        <button title="Hapus Data" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-red-600 hover:bg-red-700 active:bg-red-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg><span>Hapus</span></button>
                                    </div>
                                </td>
                            </tr>

                            {{-- Row 2 --}}
                            <tr class="hover:bg-blue-50 transition-colors duration-150 border-l-4 border-transparent hover:border-blue-500 bg-gray-50">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">2</td>
                                <td class="px-6 py-4 text-sm text-gray-700 font-semibold">19800812200812002</td>
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">Siti Nurhaliza, S.Pd</td>
                                <td class="px-6 py-4 text-sm text-gray-700">Perempuan</td>
                                <td class="px-6 py-4 text-sm"><span class="px-3 py-1.5 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Aktif</span></td>
                                <td class="px-6 py-4 text-sm text-gray-600">0812345678902</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2 flex-wrap">
                                        <button title="Lihat Detail" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 active:bg-blue-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg><span>Lihat</span></button>
                                        <button title="Edit Data" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-amber-600 hover:bg-amber-700 active:bg-amber-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg><span>Edit</span></button>
                                        <button title="Hapus Data" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-red-600 hover:bg-red-700 active:bg-red-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg><span>Hapus</span></button>
                                    </div>
                                </td>
                            </tr>

                            {{-- Row 3 --}}
                            <tr class="hover:bg-blue-50 transition-colors duration-150 border-l-4 border-transparent hover:border-blue-500">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">3</td>
                                <td class="px-6 py-4 text-sm text-gray-700 font-semibold">19900125200903003</td>
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">Ahmad Hidayat, S.Pd</td>
                                <td class="px-6 py-4 text-sm text-gray-700">Laki - Laki</td>
                                <td class="px-6 py-4 text-sm"><span class="px-3 py-1.5 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Aktif</span></td>
                                <td class="px-6 py-4 text-sm text-gray-600">0812345678903</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2 flex-wrap">
                                        <button title="Lihat Detail" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 active:bg-blue-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg><span>Lihat</span></button>
                                        <button title="Edit Data" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-amber-600 hover:bg-amber-700 active:bg-amber-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg><span>Edit</span></button>
                                        <button title="Hapus Data" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-red-600 hover:bg-red-700 active:bg-red-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg><span>Hapus</span></button>
                                    </div>
                                </td>
                            </tr>

                            {{-- Row 4 --}}
                            <tr class="hover:bg-blue-50 transition-colors duration-150 border-l-4 border-transparent hover:border-blue-500 bg-gray-50">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">4</td>
                                <td class="px-6 py-4 text-sm text-gray-700 font-semibold">19850620200804004</td>
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">Dewi Lestari, S.Pd</td>
                                <td class="px-6 py-4 text-sm text-gray-700">Perempuan</td>
                                <td class="px-6 py-4 text-sm"><span class="px-3 py-1.5 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Aktif</span></td>
                                <td class="px-6 py-4 text-sm text-gray-600">0812345678904</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2 flex-wrap">
                                        <button title="Lihat Detail" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 active:bg-blue-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg><span>Lihat</span></button>
                                        <button title="Edit Data" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-amber-600 hover:bg-amber-700 active:bg-amber-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg><span>Edit</span></button>
                                        <button title="Hapus Data" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-red-600 hover:bg-red-700 active:bg-red-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg><span>Hapus</span></button>
                                    </div>
                                </td>
                            </tr>

                            {{-- Row 5 --}}
                            <tr class="hover:bg-blue-50 transition-colors duration-150 border-l-4 border-transparent hover:border-blue-500">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">5</td>
                                <td class="px-6 py-4 text-sm text-gray-700 font-semibold">19920715200905005</td>
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">Rinto Harahap, S.Pd</td>
                                <td class="px-6 py-4 text-sm text-gray-700">Laki - Laki</td>
                                <td class="px-6 py-4 text-sm"><span class="px-3 py-1.5 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Aktif</span></td>
                                <td class="px-6 py-4 text-sm text-gray-600">0812345678905</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2 flex-wrap">
                                        <button title="Lihat Detail" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 active:bg-blue-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg><span>Lihat</span></button>
                                        <button title="Edit Data" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-amber-600 hover:bg-amber-700 active:bg-amber-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg><span>Edit</span></button>
                                        <button title="Hapus Data" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-red-600 hover:bg-red-700 active:bg-red-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg><span>Hapus</span></button>
                                    </div>
                                </td>
                            </tr>

                            {{-- Row 6 --}}
                            <tr class="hover:bg-blue-50 transition-colors duration-150 border-l-4 border-transparent hover:border-blue-500 bg-gray-50">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">6</td>
                                <td class="px-6 py-4 text-sm text-gray-700 font-semibold">19880402200806006</td>
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">Eka Putri, S.Pd</td>
                                <td class="px-6 py-4 text-sm text-gray-700">Perempuan</td>
                                <td class="px-6 py-4 text-sm"><span class="px-3 py-1.5 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Aktif</span></td>
                                <td class="px-6 py-4 text-sm text-gray-600">0812345678906</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2 flex-wrap">
                                        <button title="Lihat Detail" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 active:bg-blue-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg><span>Lihat</span></button>
                                        <button title="Edit Data" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-amber-600 hover:bg-amber-700 active:bg-amber-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg><span>Edit</span></button>
                                        <button title="Hapus Data" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-red-600 hover:bg-red-700 active:bg-red-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg><span>Hapus</span></button>
                                    </div>
                                </td>
                            </tr>

                            {{-- Row 7 --}}
                            <tr class="hover:bg-blue-50 transition-colors duration-150 border-l-4 border-transparent hover:border-blue-500">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">7</td>
                                <td class="px-6 py-4 text-sm text-gray-700 font-semibold">19910528200907007</td>
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">Riwan Praktama, S.Pd</td>
                                <td class="px-6 py-4 text-sm text-gray-700">Laki - Laki</td>
                                <td class="px-6 py-4 text-sm"><span class="px-3 py-1.5 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Aktif</span></td>
                                <td class="px-6 py-4 text-sm text-gray-600">0812345678907</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2 flex-wrap">
                                        <button title="Lihat Detail" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 active:bg-blue-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg><span>Lihat</span></button>
                                        <button title="Edit Data" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-amber-600 hover:bg-amber-700 active:bg-amber-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg><span>Edit</span></button>
                                        <button title="Hapus Data" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-red-600 hover:bg-red-700 active:bg-red-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg><span>Hapus</span></button>
                                    </div>
                                </td>
                            </tr>

                            {{-- Row 8 --}}
                            <tr class="hover:bg-blue-50 transition-colors duration-150 border-l-4 border-transparent hover:border-blue-500 bg-gray-50">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">8</td>
                                <td class="px-6 py-4 text-sm text-gray-700 font-semibold">19860913200808008</td>
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">Irma Wijaya, S.Pd</td>
                                <td class="px-6 py-4 text-sm text-gray-700">Perempuan</td>
                                <td class="px-6 py-4 text-sm"><span class="px-3 py-1.5 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Aktif</span></td>
                                <td class="px-6 py-4 text-sm text-gray-600">0812345678908</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2 flex-wrap">
                                        <button title="Lihat Detail" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 active:bg-blue-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg><span>Lihat</span></button>
                                        <button title="Edit Data" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-amber-600 hover:bg-amber-700 active:bg-amber-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg><span>Edit</span></button>
                                        <button title="Hapus Data" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-red-600 hover:bg-red-700 active:bg-red-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg><span>Hapus</span></button>
                                    </div>
                                </td>
                            </tr>

                            {{-- Row 9 --}}
                            <tr class="hover:bg-blue-50 transition-colors duration-150 border-l-4 border-transparent hover:border-blue-500">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">9</td>
                                <td class="px-6 py-4 text-sm text-gray-700 font-semibold">19930704200909009</td>
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">Fajar Nugroho, S.Pd</td>
                                <td class="px-6 py-4 text-sm text-gray-700">Laki - Laki</td>
                                <td class="px-6 py-4 text-sm"><span class="px-3 py-1.5 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Aktif</span></td>
                                <td class="px-6 py-4 text-sm text-gray-600">0812345678909</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2 flex-wrap">
                                        <button title="Lihat Detail" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 active:bg-blue-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg><span>Lihat</span></button>
                                        <button title="Edit Data" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-amber-600 hover:bg-amber-700 active:bg-amber-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg><span>Edit</span></button>
                                        <button title="Hapus Data" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-red-600 hover:bg-red-700 active:bg-red-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg><span>Hapus</span></button>
                                    </div>
                                </td>
                            </tr>

                            {{-- Row 10 --}}
                            <tr class="hover:bg-blue-50 transition-colors duration-150 border-l-4 border-transparent hover:border-blue-500 bg-gray-50">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">10</td>
                                <td class="px-6 py-4 text-sm text-gray-700 font-semibold">19870119200810010</td>
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">Tuti Handayani, S.Pd</td>
                                <td class="px-6 py-4 text-sm text-gray-700">Perempuan</td>
                                <td class="px-6 py-4 text-sm"><span class="px-3 py-1.5 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Aktif</span></td>
                                <td class="px-6 py-4 text-sm text-gray-600">0812345678910</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2 flex-wrap">
                                        <button title="Lihat Detail" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 active:bg-blue-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg><span>Lihat</span></button>
                                        <button title="Edit Data" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-amber-600 hover:bg-amber-700 active:bg-amber-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg><span>Edit</span></button>
                                        <button title="Hapus Data" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-red-600 hover:bg-red-700 active:bg-red-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg><span>Hapus</span></button>
                                    </div>
                                </td>
                            </tr>

                            {{-- Row 11 --}}
                            <tr class="hover:bg-blue-50 transition-colors duration-150 border-l-4 border-transparent hover:border-blue-500">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">11</td>
                                <td class="px-6 py-4 text-sm text-gray-700 font-semibold">19890626200811011</td>
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">Hendra Gunawan, S.Pd</td>
                                <td class="px-6 py-4 text-sm text-gray-700">Laki - Laki</td>
                                <td class="px-6 py-4 text-sm"><span class="px-3 py-1.5 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Aktif</span></td>
                                <td class="px-6 py-4 text-sm text-gray-600">0812345678911</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2 flex-wrap">
                                        <button title="Lihat Detail" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 active:bg-blue-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg><span>Lihat</span></button>
                                        <button title="Edit Data" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-amber-600 hover:bg-amber-700 active:bg-amber-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg><span>Edit</span></button>
                                        <button title="Hapus Data" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-red-600 hover:bg-red-700 active:bg-red-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg><span>Hapus</span></button>
                                    </div>
                                </td>
                            </tr>

                            {{-- Row 12 --}}
                            <tr class="hover:bg-blue-50 transition-colors duration-150 border-l-4 border-transparent hover:border-blue-500 bg-gray-50">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">12</td>
                                <td class="px-6 py-4 text-sm text-gray-700 font-semibold">19920211200812012</td>
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">Vina Angeline, S.Pd</td>
                                <td class="px-6 py-4 text-sm text-gray-700">Perempuan</td>
                                <td class="px-6 py-4 text-sm"><span class="px-3 py-1.5 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Aktif</span></td>
                                <td class="px-6 py-4 text-sm text-gray-600">0812345678912</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2 flex-wrap">
                                        <button title="Lihat Detail" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 active:bg-blue-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg><span>Lihat</span></button>
                                        <button title="Edit Data" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-amber-600 hover:bg-amber-700 active:bg-amber-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg><span>Edit</span></button>
                                        <button title="Hapus Data" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-red-600 hover:bg-red-700 active:bg-red-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg><span>Hapus</span></button>
                                    </div>
                                </td>
                            </tr>

                            {{-- Row 13 --}}
                            <tr class="hover:bg-blue-50 transition-colors duration-150 border-l-4 border-transparent hover:border-blue-500">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">13</td>
                                <td class="px-6 py-4 text-sm text-gray-700 font-semibold">19880915200813013</td>
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">Bambang Setiawan, S.Pd</td>
                                <td class="px-6 py-4 text-sm text-gray-700">Laki - Laki</td>
                                <td class="px-6 py-4 text-sm"><span class="px-3 py-1.5 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Aktif</span></td>
                                <td class="px-6 py-4 text-sm text-gray-600">0812345678913</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2 flex-wrap">
                                        <button title="Lihat Detail" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 active:bg-blue-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg><span>Lihat</span></button>
                                        <button title="Edit Data" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-amber-600 hover:bg-amber-700 active:bg-amber-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg><span>Edit</span></button>
                                        <button title="Hapus Data" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-red-600 hover:bg-red-700 active:bg-red-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg><span>Hapus</span></button>
                                    </div>
                                </td>
                            </tr>

                            {{-- Row 14 --}}
                            <tr class="hover:bg-blue-50 transition-colors duration-150 border-l-4 border-transparent hover:border-blue-500 bg-gray-50">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">14</td>
                                <td class="px-6 py-4 text-sm text-gray-700 font-semibold">19910322200814014</td>
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">Lisda Nurdin, S.Pd</td>
                                <td class="px-6 py-4 text-sm text-gray-700">Perempuan</td>
                                <td class="px-6 py-4 text-sm"><span class="px-3 py-1.5 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Aktif</span></td>
                                <td class="px-6 py-4 text-sm text-gray-600">0812345678914</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2 flex-wrap">
                                        <button title="Lihat Detail" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 active:bg-blue-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg><span>Lihat</span></button>
                                        <button title="Edit Data" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-amber-600 hover:bg-amber-700 active:bg-amber-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg><span>Edit</span></button>
                                        <button title="Hapus Data" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-red-600 hover:bg-red-700 active:bg-red-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg><span>Hapus</span></button>
                                    </div>
                                </td>
                            </tr>

                            {{-- Row 15 --}}
                            <tr class="hover:bg-blue-50 transition-colors duration-150 border-l-4 border-transparent hover:border-blue-500">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">15</td>
                                <td class="px-6 py-4 text-sm text-gray-700 font-semibold">19870508200815015</td>
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">Iwan Hartono, S.Pd</td>
                                <td class="px-6 py-4 text-sm text-gray-700">Laki - Laki</td>
                                <td class="px-6 py-4 text-sm"><span class="px-3 py-1.5 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Aktif</span></td>
                                <td class="px-6 py-4 text-sm text-gray-600">0812345678915</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2 flex-wrap">
                                        <button title="Lihat Detail" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 active:bg-blue-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg><span>Lihat</span></button>
                                        <button title="Edit Data" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-amber-600 hover:bg-amber-700 active:bg-amber-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg><span>Edit</span></button>
                                        <button title="Hapus Data" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-red-600 hover:bg-red-700 active:bg-red-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg><span>Hapus</span></button>
                                    </div>
                                </td>
                            </tr>

                            {{-- Row 16 --}}
                            <tr class="hover:bg-blue-50 transition-colors duration-150 border-l-4 border-transparent hover:border-blue-500 bg-gray-50">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">16</td>
                                <td class="px-6 py-4 text-sm text-gray-700 font-semibold">19930711200816016</td>
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">Citra Mustika, S.Pd</td>
                                <td class="px-6 py-4 text-sm text-gray-700">Perempuan</td>
                                <td class="px-6 py-4 text-sm"><span class="px-3 py-1.5 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Aktif</span></td>
                                <td class="px-6 py-4 text-sm text-gray-600">0812345678916</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2 flex-wrap">
                                        <button title="Lihat Detail" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 active:bg-blue-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg><span>Lihat</span></button>
                                        <button title="Edit Data" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-amber-600 hover:bg-amber-700 active:bg-amber-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg><span>Edit</span></button>
                                        <button title="Hapus Data" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-red-600 hover:bg-red-700 active:bg-red-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg><span>Hapus</span></button>
                                    </div>
                                </td>
                            </tr>

                            {{-- Row 17 --}}
                            <tr class="hover:bg-blue-50 transition-colors duration-150 border-l-4 border-transparent hover:border-blue-500">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">17</td>
                                <td class="px-6 py-4 text-sm text-gray-700 font-semibold">19860304200817017</td>
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">Arif Rahman, S.Pd</td>
                                <td class="px-6 py-4 text-sm text-gray-700">Laki - Laki</td>
                                <td class="px-6 py-4 text-sm"><span class="px-3 py-1.5 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Aktif</span></td>
                                <td class="px-6 py-4 text-sm text-gray-600">0812345678917</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2 flex-wrap">
                                        <button title="Lihat Detail" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 active:bg-blue-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg><span>Lihat</span></button>
                                        <button title="Edit Data" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-amber-600 hover:bg-amber-700 active:bg-amber-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg><span>Edit</span></button>
                                        <button title="Hapus Data" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-red-600 hover:bg-red-700 active:bg-red-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg><span>Hapus</span></button>
                                    </div>
                                </td>
                            </tr>

                            {{-- Row 18 --}}
                            <tr class="hover:bg-blue-50 transition-colors duration-150 border-l-4 border-transparent hover:border-blue-500 bg-gray-50">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">18</td>
                                <td class="px-6 py-4 text-sm text-gray-700 font-semibold">19920527200818018</td>
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">Dwi Astuti, S.Pd</td>
                                <td class="px-6 py-4 text-sm text-gray-700">Perempuan</td>
                                <td class="px-6 py-4 text-sm"><span class="px-3 py-1.5 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Aktif</span></td>
                                <td class="px-6 py-4 text-sm text-gray-600">0812345678918</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2 flex-wrap">
                                        <button title="Lihat Detail" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 active:bg-blue-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg><span>Lihat</span></button>
                                        <button title="Edit Data" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-amber-600 hover:bg-amber-700 active:bg-amber-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg><span>Edit</span></button>
                                        <button title="Hapus Data" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-red-600 hover:bg-red-700 active:bg-red-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg><span>Hapus</span></button>
                                    </div>
                                </td>
                            </tr>

                            {{-- Row 19 --}}
                            <tr class="hover:bg-blue-50 transition-colors duration-150 border-l-4 border-transparent hover:border-blue-500">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">19</td>
                                <td class="px-6 py-4 text-sm text-gray-700 font-semibold">19890819200819019</td>
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">Yupi Kusuma, S.Pd</td>
                                <td class="px-6 py-4 text-sm text-gray-700">Perempuan</td>
                                <td class="px-6 py-4 text-sm"><span class="px-3 py-1.5 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Aktif</span></td>
                                <td class="px-6 py-4 text-sm text-gray-600">0812345678919</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2 flex-wrap">
                                        <button title="Lihat Detail" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 active:bg-blue-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg><span>Lihat</span></button>
                                        <button title="Edit Data" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-amber-600 hover:bg-amber-700 active:bg-amber-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg><span>Edit</span></button>
                                        <button title="Hapus Data" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-red-600 hover:bg-red-700 active:bg-red-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg><span>Hapus</span></button>
                                    </div>
                                </td>
                            </tr>

                            {{-- Row 20 --}}
                            <tr class="hover:bg-blue-50 transition-colors duration-150 border-l-4 border-transparent hover:border-blue-500 bg-gray-50">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">20</td>
                                <td class="px-6 py-4 text-sm text-gray-700 font-semibold">19910606200820020</td>
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">Santoso Wijaya, S.Pd</td>
                                <td class="px-6 py-4 text-sm text-gray-700">Laki - Laki</td>
                                <td class="px-6 py-4 text-sm"><span class="px-3 py-1.5 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Aktif</span></td>
                                <td class="px-6 py-4 text-sm text-gray-600">0812345678920</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2 flex-wrap">
                                        <button title="Lihat Detail" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 active:bg-blue-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg><span>Lihat</span></button>
                                        <button title="Edit Data" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-amber-600 hover:bg-amber-700 active:bg-amber-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg><span>Edit</span></button>
                                        <button title="Hapus Data" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-red-600 hover:bg-red-700 active:bg-red-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg><span>Hapus</span></button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Pagination Footer --}}
                <div class="px-6 py-4 border-t border-gray-200 flex flex-col md:flex-row items-start md:items-center justify-between gap-4 bg-gray-50">
                    <span class="text-sm text-gray-600 font-medium">Menampilkan <span class="text-gray-900 font-bold">1 - 20</span> dari <span class="text-gray-900 font-bold">432</span> data</span>

                    <div class="flex items-center gap-2">
                        <button class="p-2 text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition-all disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </button>

                        <div class="flex items-center gap-1">
                            <button class="px-3 py-2 text-sm font-semibold text-white bg-gray-900 rounded-lg hover:bg-gray-800 transition-all shadow-sm">1</button>
                            <button class="px-3 py-2 text-sm font-medium text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition-all">2</button>
                            <button class="px-3 py-2 text-sm font-medium text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition-all">3</button>
                            <span class="px-2 text-gray-500">...</span>
                            <button class="px-3 py-2 text-sm font-medium text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition-all">22</button>
                        </div>

                        <button class="p-2 text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

</body>
</html>