<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Rapor — Data Siswa</title>

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
<body class="bg-gray-50" x-data="{ openTambah: false }">

    {{-- Sidebar --}}
    @include('components.sidebar_admin')

    {{-- ===================== MODAL TAMBAH SISWA ===================== --}}
    <div
        x-show="openTambah"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4"
        @click.self="openTambah = false"
        style="display: none;"
    >
        <div
            x-show="openTambah"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="bg-white rounded-xl shadow-xl w-full max-w-lg"
        >
            {{-- Modal Header --}}
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
                <h2 class="text-base font-bold text-gray-900">Tambah Siswa</h2>
                <button
                    @click="openTambah = false"
                    class="p-1.5 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-all"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Modal Body --}}
            <div class="px-6 py-5">
                <form action="" method="">
                    @csrf

                    {{-- Row 1: NIS & Nama --}}
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="nis" class="block text-sm font-semibold text-gray-700 mb-1.5">NIS</label>
                            <input
                                type="text"
                                id="nis"
                                name="nis"
                                placeholder="Masukkan NIS"
                                class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all bg-white hover:border-gray-400"
                            >
                        </div>
                        <div>
                            <label for="nama" class="block text-sm font-semibold text-gray-700 mb-1.5">Nama</label>
                            <input
                                type="text"
                                id="nama"
                                name="nama"
                                placeholder="Masukkan nama lengkap"
                                class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all bg-white hover:border-gray-400"
                            >
                        </div>
                    </div>

                    {{-- Row 2: Tanggal Lahir & Jenis Kelamin --}}
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="tanggal_lahir" class="block text-sm font-semibold text-gray-700 mb-1.5">Tanggal Lahir</label>
                            <input
                                type="date"
                                id="tanggal_lahir"
                                name="tanggal_lahir"
                                class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all bg-white hover:border-gray-400 text-gray-700"
                            >
                        </div>
                        <div>
                            <label for="jenis_kelamin" class="block text-sm font-semibold text-gray-700 mb-1.5">Jenis Kelamin</label>
                            <select
                                id="jenis_kelamin"
                                name="jenis_kelamin"
                                class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all bg-gray-50 hover:border-gray-400 text-gray-700 appearance-none cursor-pointer"
                            >
                                <option value="">Pilih Jenis kelamin</option>
                                <option value="laki-laki">Laki - Laki</option>
                                <option value="perempuan">Perempuan</option>
                            </select>
                        </div>
                    </div>

                    {{-- Row 3: Kelas & Status --}}
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="kelas_id" class="block text-sm font-semibold text-gray-700 mb-1.5">Kelas</label>
                            <select
                                id="kelas_id"
                                name="kelas_id"
                                class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all bg-gray-50 hover:border-gray-400 text-gray-700 appearance-none cursor-pointer"
                            >
                                <option value="">Pilih Kelas</option>
                                @foreach($kelas ?? [] as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="status" class="block text-sm font-semibold text-gray-700 mb-1.5">Status</label>
                            <select
                                id="status"
                                name="status"
                                class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all bg-gray-50 hover:border-gray-400 text-gray-700 appearance-none cursor-pointer"
                            >
                                <option value="">Pilih Status</option>
                                <option value="aktif">Aktif</option>
                                <option value="tidak_aktif">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>

                    {{-- Row 4: No. HP (full width) --}}
                    <div class="mb-6">
                        <label for="no_hp" class="block text-sm font-semibold text-gray-700 mb-1.5">No. Hp</label>
                        <input
                            type="text"
                            id="no_hp"
                            name="no_hp"
                            placeholder="Contoh: 08xxxxxxxxxx"
                            class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all bg-white hover:border-gray-400"
                            style="max-width: calc(50% - 0.5rem);"
                        >
                    </div>

                    {{-- Modal Footer: Tombol --}}
                    <div class="flex items-center gap-3">
                        <button
                            type="submit"
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-900 text-white text-sm font-semibold rounded-lg hover:bg-gray-800 active:bg-gray-700 transition-all shadow-sm hover:shadow-md"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            <span>Tambah</span>
                        </button>
                        <button
                            type="button"
                            @click="openTambah = false"
                            class="px-5 py-2.5 text-sm font-semibold text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 active:bg-gray-100 transition-all"
                        >
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- ===================== END MODAL ===================== --}}

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
                                <input type="text" placeholder="Cari NIS, nama..."
                                       class="w-full pl-10 pr-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all bg-white hover:border-gray-400">
                            </div>
                        </div>

                        {{-- Right: Filter & Tombol Tambah --}}
                        <div class="flex items-center gap-3 w-full md:w-auto">
                            <select class="flex-1 md:flex-none px-4 py-2.5 text-sm font-medium text-gray-700 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all bg-white hover:border-gray-400">
                                <option>Filter Status</option>
                                <option>Aktif</option>
                                <option>Tidak Aktif</option>
                            </select>

                            {{-- Tombol Tambah — membuka modal --}}
                            <button
                                @click="openTambah = true"
                                class="px-5 py-2.5 bg-gray-900 text-white text-sm font-semibold rounded-lg hover:bg-gray-800 active:bg-gray-700 transition-all flex items-center gap-2 whitespace-nowrap shadow-sm hover:shadow-md"
                            >
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
                                        <span>NIS</span>
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
                                        <span>Tgl. Lahir</span>
                                        <svg class="w-3.5 h-3.5 opacity-60" fill="currentColor" viewBox="0 0 20 20"><path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3z"/></svg>
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider cursor-pointer hover:opacity-80 transition-opacity">
                                    <div class="flex items-center gap-2">
                                        <span>Jenis Kelamin</span>
                                        <svg class="w-3.5 h-3.5 opacity-60" fill="currentColor" viewBox="0 0 20 20"><path d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3z"/></svg>
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider cursor-pointer hover:opacity-80 transition-opacity">
                                    <div class="flex items-center gap-2">
                                        <span>Kelas</span>
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
                                <td class="px-6 py-4 text-sm text-gray-700 font-semibold">10039003</td>
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">Samuel Simamethak</td>
                                <td class="px-6 py-4 text-sm text-gray-600">10/03/2007</td>
                                <td class="px-6 py-4 text-sm text-gray-700">Laki - Laki</td>
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">X-IPA-1</td>
                                <td class="px-6 py-4 text-sm"><span class="px-3 py-1.5 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Aktif</span></td>
                                <td class="px-6 py-4 text-sm text-gray-600">0895868762323</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2 flex-wrap">
                                        <button title="Lihat Detail" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 active:bg-blue-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg><span>Lihat</span></button>
                                        <button title="Edit Data" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-amber-600 hover:bg-amber-700 active:bg-amber-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg><span>Edit</span></button>
                                        <button title="Hapus Data" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-red-600 hover:bg-red-700 active:bg-red-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg><span>Hapus</span></button>
                                    </div>
                                </td>
                            </tr>

                            {{-- Row 2 --}}
                            <tr class="hover:bg-blue-50 transition-colors duration-150 border-l-4 border-transparent hover:border-blue-500 bg-gray-50">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">2</td>
                                <td class="px-6 py-4 text-sm text-gray-700 font-semibold">10039004</td>
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">Damen hafiz Hendelo</td>
                                <td class="px-6 py-4 text-sm text-gray-600">16/03/2007</td>
                                <td class="px-6 py-4 text-sm text-gray-700">Laki - Laki</td>
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">X-IPA-2</td>
                                <td class="px-6 py-4 text-sm"><span class="px-3 py-1.5 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Aktif</span></td>
                                <td class="px-6 py-4 text-sm text-gray-600">0895868762323</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2 flex-wrap">
                                        <button title="Lihat Detail" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 active:bg-blue-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg><span>Lihat</span></button>
                                        <button title="Edit Data" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-amber-600 hover:bg-amber-700 active:bg-amber-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg><span>Edit</span></button>
                                        <button title="Hapus Data" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-red-600 hover:bg-red-700 active:bg-red-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg><span>Hapus</span></button>
                                    </div>
                                </td>
                            </tr>

                            {{-- Row 3 --}}
                            <tr class="hover:bg-blue-50 transition-colors duration-150 border-l-4 border-transparent hover:border-blue-500">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">3</td>
                                <td class="px-6 py-4 text-sm text-gray-700 font-semibold">10039005</td>
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">Samuel Assadi</td>
                                <td class="px-6 py-4 text-sm text-gray-600">10/03/2007</td>
                                <td class="px-6 py-4 text-sm text-gray-700">Laki - Laki</td>
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">X-IPA-1</td>
                                <td class="px-6 py-4 text-sm"><span class="px-3 py-1.5 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Aktif</span></td>
                                <td class="px-6 py-4 text-sm text-gray-600">0895868762323</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2 flex-wrap">
                                        <button title="Lihat Detail" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 active:bg-blue-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg><span>Lihat</span></button>
                                        <button title="Edit Data" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-amber-600 hover:bg-amber-700 active:bg-amber-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg><span>Edit</span></button>
                                        <button title="Hapus Data" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-red-600 hover:bg-red-700 active:bg-red-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg><span>Hapus</span></button>
                                    </div>
                                </td>
                            </tr>

                            {{-- Row 4 --}}
                            <tr class="hover:bg-blue-50 transition-colors duration-150 border-l-4 border-transparent hover:border-blue-500 bg-gray-50">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">4</td>
                                <td class="px-6 py-4 text-sm text-gray-700 font-semibold">10039006</td>
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">Badal Simago Ioga</td>
                                <td class="px-6 py-4 text-sm text-gray-600">10/03/2007</td>
                                <td class="px-6 py-4 text-sm text-gray-700">Perempuan</td>
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">X-IPA-2</td>
                                <td class="px-6 py-4 text-sm"><span class="px-3 py-1.5 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Aktif</span></td>
                                <td class="px-6 py-4 text-sm text-gray-600">0895868762323</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2 flex-wrap">
                                        <button title="Lihat Detail" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 active:bg-blue-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg><span>Lihat</span></button>
                                        <button title="Edit Data" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-amber-600 hover:bg-amber-700 active:bg-amber-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg><span>Edit</span></button>
                                        <button title="Hapus Data" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-red-600 hover:bg-red-700 active:bg-red-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg><span>Hapus</span></button>
                                    </div>
                                </td>
                            </tr>

                            {{-- Row 5 --}}
                            <tr class="hover:bg-blue-50 transition-colors duration-150 border-l-4 border-transparent hover:border-blue-500">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">5</td>
                                <td class="px-6 py-4 text-sm text-gray-700 font-semibold">10039007</td>
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">Samuel Assadi</td>
                                <td class="px-6 py-4 text-sm text-gray-600">10/03/2007</td>
                                <td class="px-6 py-4 text-sm text-gray-700">Laki - Laki</td>
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">X-IPA-1</td>
                                <td class="px-6 py-4 text-sm"><span class="px-3 py-1.5 bg-orange-100 text-orange-700 rounded-full text-xs font-semibold">Tidak Aktif</span></td>
                                <td class="px-6 py-4 text-sm text-gray-600">0895868762323</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2 flex-wrap">
                                        <button title="Lihat Detail" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 active:bg-blue-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg><span>Lihat</span></button>
                                        <button title="Edit Data" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-amber-600 hover:bg-amber-700 active:bg-amber-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg><span>Edit</span></button>
                                        <button title="Hapus Data" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-red-600 hover:bg-red-700 active:bg-red-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg><span>Hapus</span></button>
                                    </div>
                                </td>
                            </tr>

                            {{-- Row 6 --}}
                            <tr class="hover:bg-blue-50 transition-colors duration-150 border-l-4 border-transparent hover:border-blue-500 bg-gray-50">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">6</td>
                                <td class="px-6 py-4 text-sm text-gray-700 font-semibold">10039008</td>
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">Badal Simago Ioga</td>
                                <td class="px-6 py-4 text-sm text-gray-600">10/03/2007</td>
                                <td class="px-6 py-4 text-sm text-gray-700">Perempuan</td>
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">X-IPA-2</td>
                                <td class="px-6 py-4 text-sm"><span class="px-3 py-1.5 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Aktif</span></td>
                                <td class="px-6 py-4 text-sm text-gray-600">0895868762323</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2 flex-wrap">
                                        <button title="Lihat Detail" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 active:bg-blue-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg><span>Lihat</span></button>
                                        <button title="Edit Data" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-amber-600 hover:bg-amber-700 active:bg-amber-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg><span>Edit</span></button>
                                        <button title="Hapus Data" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-red-600 hover:bg-red-700 active:bg-red-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg><span>Hapus</span></button>
                                    </div>
                                </td>
                            </tr>

                            {{-- Rows 7-20 (Similar structure) --}}
                            @for ($i = 7; $i <= 20; $i++)
                                <tr class="hover:bg-blue-50 transition-colors duration-150 border-l-4 border-transparent hover:border-blue-500 {{ $i % 2 == 0 ? 'bg-gray-50' : '' }}">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $i }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700 font-semibold">1003900{{ $i }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ ['Samuel Simamethak', 'Damen hafiz Hendelo', 'Samuel Assadi', 'Badal Simago Ioga', 'Samuel Assadi', 'Badal Simago Ioga', 'Samuel Simamethak', 'Damen hafiz Hendelo', 'Samuel Assadi', 'Badal Simago Ioga', 'Samuel Assadi', 'Badal Simago Ioga', 'Samuel Simamethak'][$i - 7] ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ rand(1, 28) }}/{{ rand(1, 12) }}/2007</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $i % 2 == 0 ? 'Perempuan' : 'Laki - Laki' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $i % 3 == 0 ? 'X-IPA-1' : ($i % 3 == 1 ? 'X-IPA-2' : 'X-IPS-1') }}</td>
                                    <td class="px-6 py-4 text-sm"><span class="px-3 py-1.5 {{ $i % 5 == 0 ? 'bg-orange-100 text-orange-700' : 'bg-green-100 text-green-700' }} rounded-full text-xs font-semibold">{{ $i % 5 == 0 ? 'Tidak Aktif' : 'Aktif' }}</span></td>
                                    <td class="px-6 py-4 text-sm text-gray-600">0895868762323</td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex items-center justify-center gap-2 flex-wrap">
                                            <button title="Lihat Detail" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 active:bg-blue-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg><span>Lihat</span></button>
                                            <button title="Edit Data" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-amber-600 hover:bg-amber-700 active:bg-amber-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg><span>Edit</span></button>
                                            <button title="Hapus Data" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-red-600 hover:bg-red-700 active:bg-red-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg><span>Hapus</span></button>
                                        </div>
                                    </td>
                                </tr>
                            @endfor
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