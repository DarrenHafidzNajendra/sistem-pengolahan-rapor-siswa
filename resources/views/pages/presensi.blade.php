@extends('layouts.app')
@section('title', 'Data Presensi Kelas')

@section('content')
    <div class="max-w-full">
        <div x-data="{ mapel: 'Matematika Wajib', kelas: 'X MIPA 1', tanggal: '2023-10-15', formatTanggal() { if (!this.tanggal) return '-'; return new Date(this.tanggal).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }); } }" class="bg-white rounded-lg shadow-sm border border-gray-200">
            {{-- Toolbar --}}
            <div class="p-6 border-b border-gray-200">
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                    <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
                        <div class="relative">
                            <select x-model="mapel" class="appearance-none w-40 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-400 cursor-pointer">
                                <option value="Matematika Wajib">Matematika</option>
                                <option value="Bahasa Inggris">Bahasa Inggris</option>
                                <option value="Fisika Dasar">Fisika Dasar</option>
                            </select>
                            <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-xs text-gray-600 pointer-events-none"></i>
                        </div>
                        <div class="relative">
                            <select x-model="kelas" class="appearance-none w-32 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-400 cursor-pointer">
                                <option value="X MIPA 1">X MIPA 1</option>
                                <option value="X MIPA 2">X MIPA 2</option>
                                <option value="XI IPS 1">XI IPS 1</option>
                            </select>
                            <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-xs text-gray-600 pointer-events-none"></i>
                        </div>
                        <input type="date" x-model="tanggal" class="w-40 px-3 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-400 cursor-pointer">
                    </div>
                    <button class="px-4 py-2 bg-gray-700 text-white text-sm font-semibold rounded-lg hover:bg-gray-800 transition-all flex items-center gap-2 whitespace-nowrap shadow-sm hover:shadow-md">
                        <i class="fa-solid fa-floppy-disk text-lg"></i><span>Simpan Presensi</span>
                    </button>
                </div>
            </div>

            {{-- Context Header --}}
            <div class="px-6 py-4 bg-blue-50/50 border-b border-gray-200">
                <h2 class="text-base font-bold text-gray-900">Form Input Presensi Siswa</h2>
                <div class="flex flex-wrap items-center gap-x-6 gap-y-2 mt-2 text-sm">
                    <div class="flex items-center gap-2 text-gray-600"><i class="fa-solid fa-book text-blue-600 opacity-80"></i><span>Mata Pelajaran: <strong class="text-gray-900" x-text="mapel"></strong></span></div>
                    <div class="flex items-center gap-2 text-gray-600"><i class="fa-solid fa-users text-blue-600 opacity-80"></i><span>Kelas: <strong class="text-gray-900" x-text="kelas"></strong></span></div>
                    <div class="flex items-center gap-2 text-gray-600"><i class="fa-regular fa-calendar-days text-blue-600 opacity-80"></i><span>Tanggal: <strong class="text-gray-900" x-text="formatTanggal()"></strong></span></div>
                </div>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-gray-900 to-gray-800">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">NO</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">NIS</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider min-w-[200px]">Nama Siswa</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-white uppercase tracking-wider">Hadir</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-white uppercase tracking-wider">Tidak Hadir</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-white uppercase tracking-wider">Izin</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider min-w-[200px]">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @php
                            $presensiData = [
                                ['1809599001','Samuel Simorangkir','hadir',''],
                                ['1809599002','Budi Santoso','hadir',''],
                                ['1809599003','Citra Kirana','hadir',''],
                                ['1809599004','Dewi Lestari','izin','Izin keluarga'],
                                ['1809599005','Eka Saputra','hadir',''],
                                ['1809599006','Fitriani','hadir',''],
                                ['1809599007','Gilang Ramadan','hadir',''],
                                ['1809599008','Hesti Purwanti','tidak_hadir','Sakit demam'],
                                ['1809599009','Ivan Gunawan','hadir',''],
                                ['1809599010','Julia Perez','hadir',''],
                            ];
                        @endphp
                        @foreach($presensiData as $i => $p)
                        <tr class="hover:bg-blue-50 transition-colors duration-150 border-l-4 border-transparent hover:border-blue-500 {{ $i % 2 === 0 ? 'bg-white' : 'bg-gray-50' }}">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $i + 1 }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700 font-semibold">{{ $p[0] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900 font-medium whitespace-nowrap">{{ $p[1] }}</td>
                            <td class="px-6 py-4 text-center"><input type="radio" name="status_{{ $i+1 }}" value="hadir" class="w-5 h-5 text-gray-900 bg-gray-100 border-gray-400 focus:ring-gray-900 cursor-pointer" {{ $p[2]==='hadir'?'checked':'' }}></td>
                            <td class="px-6 py-4 text-center"><input type="radio" name="status_{{ $i+1 }}" value="tidak_hadir" class="w-5 h-5 text-gray-900 bg-gray-100 border-gray-400 focus:ring-gray-900 cursor-pointer" {{ $p[2]==='tidak_hadir'?'checked':'' }}></td>
                            <td class="px-6 py-4 text-center"><input type="radio" name="status_{{ $i+1 }}" value="izin" class="w-5 h-5 text-gray-900 bg-gray-100 border-gray-400 focus:ring-gray-900 cursor-pointer" {{ $p[2]==='izin'?'checked':'' }}></td>
                            <td class="px-6 py-4"><input type="text" class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-gray-900 shadow-sm bg-white" {{ $p[3] ? 'placeholder='.$p[3] : '' }}></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <x-pagination :from="1" :to="20" :total="45" :lastPage="9" />
        </div>
    </div>
@endsection