@extends('layouts.app')

@section('title', 'Pengaturan Akademik')

@section('content')
<div x-data="{ openTA: false, openSemester: false, taId: null, taNama: '' }">
    <div class="space-y-6">
    {{-- Toolbar --}}
    <div class="bg-white border border-gray-200 rounded p-4 flex items-center justify-between shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 bg-gray-900 rounded flex items-center justify-center text-white shadow-sm">
                <i class="fa-solid fa-calendar-check text-xs"></i>
            </div>
            <div>
                <h1 class="text-sm font-bold text-gray-900 leading-none">Manajemen Periode Akademik</h1>
                <p class="text-[10px] text-gray-500 font-medium mt-1">Kelola tahun ajaran dan aktifkan semester berjalan.</p>
            </div>
        </div>
        <button @click="openTA = true" 
                class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-900 text-white text-xs font-bold rounded hover:bg-gray-800 transition-all shadow-sm">
            <i class="fa-solid fa-plus text-[10px]"></i>
            <span>Tambah Tahun Ajaran</span>
        </button>
    </div>

    {{-- Grid Content --}}
    <div class="grid grid-cols-1 gap-6">
        @forelse($tahunAjaran as $ta)
        <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
            {{-- TA Header --}}
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white border border-gray-200 rounded flex items-center justify-center text-gray-900 shadow-sm">
                        <i class="fa-solid fa-calendar-days text-sm"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900">Tahun Ajaran {{ $ta->nama }}</h3>
                        <p class="text-[10px] text-gray-500 font-medium tracking-wide">
                            Periode: {{ $ta->tanggal_mulai->format('d M Y') }} — {{ $ta->tanggal_selesai->format('d M Y') }}
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    @if($ta->is_aktif)
                        <div class="flex items-center gap-2">
                            <span class="px-2 py-1 bg-emerald-100 text-emerald-700 text-[10px] font-bold rounded uppercase tracking-wider border border-emerald-200">
                                <i class="fa-solid fa-circle-check mr-1"></i> Sedang Berjalan
                            </span>
                            <form action="{{ route('akademik.ta.nonaktifkan', $ta->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" 
                                        class="px-3 py-1.5 bg-red-600 text-white text-[10px] font-bold rounded hover:bg-red-700 transition-all shadow-sm flex items-center gap-1"
                                        onclick="return confirm('Tutup periode tahun ajaran ini? Semua akses input data akan dikunci.')">
                                    <i class="fa-solid fa-lock"></i> Tutup Periode
                                </button>
                            </form>
                        </div>
                    @else
                        <form action="{{ route('akademik.ta.set_aktif', $ta->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" 
                                    class="px-3 py-1.5 bg-blue-600 text-white text-[10px] font-bold rounded hover:bg-blue-700 transition-all shadow-sm flex items-center gap-1">
                                <i class="fa-solid fa-play"></i> Aktifkan Tahun Ajaran
                            </button>
                        </form>
                    @endif
                    <button @click="taId = {{ $ta->id }}; taNama = '{{ $ta->nama }}'; openSemester = true" 
                            class="px-3 py-1.5 bg-white border border-gray-300 text-gray-700 text-[10px] font-bold rounded hover:bg-gray-50 transition-all flex items-center gap-1">
                        <i class="fa-solid fa-plus text-[8px]"></i> Semester
                    </button>
                </div>
            </div>

            {{-- Semesters Table --}}
            <div class="p-0">
                <table class="w-full text-left">
                    <thead class="bg-white border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-[10px] font-bold text-gray-400 tracking-wider">Semester</th>
                            <th class="px-6 py-3 text-[10px] font-bold text-gray-400 tracking-wider text-center">Status</th>
                            <th class="px-6 py-3 text-[10px] font-bold text-gray-400 tracking-wider text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($ta->semester as $smt)
                        <tr class="{{ $smt->is_aktif ? 'bg-blue-50/30' : '' }}">
                            <td class="px-6 py-4">
                                <span class="text-sm font-semibold text-gray-900">{{ $smt->semester }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($smt->is_aktif)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-blue-600 text-white text-[9px] font-bold rounded shadow-sm">
                                        <span class="w-1.5 h-1.5 bg-white rounded-full animate-pulse"></span>
                                        Semester Aktif
                                    </span>
                                @else
                                    <span class="text-[10px] font-medium text-gray-400">Tidak Aktif</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if(!$smt->is_aktif)
                                <form action="{{ route('akademik.set_aktif', $smt->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" 
                                            class="px-3 py-1.5 bg-gray-900 text-white text-[10px] font-semibold rounded hover:bg-blue-600 transition-all shadow-sm"
                                            onclick="return confirm('Aktifkan semester ini? Semua akses input nilai dan rapor akan dialihkan ke periode ini.')">
                                        Aktifkan
                                    </button>
                                </form>
                                @else
                                <span class="text-[10px] font-medium text-emerald-600 italic">Sedang Digunakan</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center">
                                <p class="text-xs text-gray-400 font-medium">Belum ada semester ditambahkan.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @empty
        <div class="bg-white border-2 border-dashed border-gray-200 rounded-xl p-12 text-center">
            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-calendar-xmark text-gray-300 text-xl"></i>
            </div>
            <h3 class="text-sm font-bold text-gray-900">Belum ada data akademik</h3>
            <p class="text-xs text-gray-500 mt-1 mb-6">Silakan tambah tahun ajaran pertama Anda untuk memulai.</p>
            <button @click="openTA = true" class="px-4 py-2 bg-gray-900 text-white text-xs font-bold rounded">
                Tambah Tahun Ajaran
            </button>
        </div>
        @endforelse
    </div>
</div>

    {{-- Modal Tahun Ajaran --}}
    <x-modal name="openTA" title="Tambah Tahun Ajaran">
        <form action="{{ route('akademik.ta.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Tahun Ajaran</label>
                    <input type="text" name="nama" placeholder="Contoh: 2026/2027" required
                           class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded focus:border-gray-900 outline-none transition-colors">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" required
                               class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded focus:border-gray-900 outline-none transition-colors">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" required
                               class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded focus:border-gray-900 outline-none transition-colors">
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-3 mt-8">
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-gray-900 text-white text-sm font-semibold rounded hover:bg-gray-800 transition-colors">
                    <i class="fa-solid fa-check"></i><span>Simpan Tahun Ajaran</span>
                </button>
                <button type="button" @click="openTA = false" class="px-6 py-2.5 text-sm font-semibold text-gray-500 bg-gray-100 rounded hover:bg-gray-200 transition-colors">Batal</button>
            </div>
        </form>
    </x-modal>

    {{-- Modal Semester --}}
    <x-modal name="openSemester" title="Tambah Semester">
        <form action="{{ route('akademik.smt.store') }}" method="POST">
            @csrf
            <input type="hidden" name="tahun_ajaran_id" x-bind:value="taId">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tahun Ajaran</label>
                    <input type="text" x-bind:value="taNama" readonly
                           class="w-full px-3 py-2.5 text-sm bg-gray-100 border border-gray-300 rounded text-gray-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Pilih Semester</label>
                    <select name="semester" required
                            class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded focus:border-gray-900 outline-none transition-colors cursor-pointer">
                        <option value="Ganjil">Semester Ganjil</option>
                        <option value="Genap">Semester Genap</option>
                    </select>
                </div>
            </div>
            <div class="flex items-center gap-3 mt-8">
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-gray-900 text-white text-sm font-semibold rounded hover:bg-gray-800 transition-colors">
                    <i class="fa-solid fa-check"></i><span>Tambah Semester Baru</span>
                </button>
                <button type="button" @click="openSemester = false" class="px-6 py-2.5 text-sm font-semibold text-gray-500 bg-gray-100 rounded hover:bg-gray-200 transition-colors">Batal</button>
            </div>
        </form>
    </x-modal>
</div>
@endsection
