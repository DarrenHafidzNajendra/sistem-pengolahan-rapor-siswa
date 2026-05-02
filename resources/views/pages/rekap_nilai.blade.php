@extends('layouts.app')
@section('title', 'Rekap Nilai')

@section('content')
    <div class="max-w-full">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            {{-- Custom Multi-Filter Toolbar --}}
            <div class="p-6 border-b border-gray-200">
                <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
                    {{-- Pencarian --}}
                    <div class="w-full lg:w-80">
                        <div class="relative group">
                            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-blue-500 transition-colors"></i>
                            <input type="text" placeholder="Cari nama siswa..." 
                                   class="w-full pl-10 pr-4 py-2.5 text-sm border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all bg-gray-50/50 focus:bg-white">
                        </div>
                    </div>
                    
                    {{-- Filter Groups --}}
                    <div class="flex flex-wrap items-center gap-3 w-full lg:w-auto">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Filter:</span>
                            <select class="px-4 py-2.5 text-sm font-semibold text-gray-700 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none bg-white cursor-pointer hover:border-gray-400 transition-all min-w-[140px]">
                                <option value="">Semua Kelas</option>
                                <option>X A</option>
                                <option>X B</option>
                                <option>XI A</option>
                                <option>XII A</option>
                            </select>
                        </div>
                        
                        <select class="px-4 py-2.5 text-sm font-semibold text-gray-700 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none bg-white cursor-pointer hover:border-gray-400 transition-all min-w-[180px]">
                            <option value="">Semua Mata Pelajaran</option>
                            <option>Matematika</option>
                            <option>Bahasa Indonesia</option>
                            <option>Bahasa Inggris</option>
                            <option>Fisika</option>
                            <option>Kimia</option>
                        </select>

                        <button class="px-5 py-2.5 bg-gray-900 text-white text-sm font-bold rounded-xl hover:bg-gray-800 active:scale-95 transition-all flex items-center gap-2 shadow-sm whitespace-nowrap">
                            <i class="fa-solid fa-magnifying-glass text-xs"></i>
                            <span>Cari</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-gray-900 to-gray-800">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">No</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Nama Siswa</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Kelas</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Mapel</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-white uppercase tracking-wider">Tugas</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-white uppercase tracking-wider">UTS</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-white uppercase tracking-wider">UAS</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-white uppercase tracking-wider">Nilai Akhir</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-white uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-white uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @php
                            $rekapData = [
                                ['Budi Santoso','Kelas X-A','Matematika',85,80,90,85,'Tuntas'],
                                ['Siti Nurhaliza','Kelas X-B','Bahasa Indonesia',75,70,68,71,'Belum Tuntas'],
                                ['Ahmad Wijaya','Kelas X-A','Matematika',92,88,95,91.5,'Tuntas'],
                                ['Ratna Kusuma','Kelas X-B','Bahasa Inggris',80,82,85,82.3,'Tuntas'],
                                ['Eka Prasetyo','Kelas XI-A','Matematika',65,60,58,61,'Belum Tuntas'],
                                ['Maya Saleha','Kelas XI-B','Bahasa Indonesia',88,90,92,90,'Tuntas'],
                                ['Fajar Ramadhan','Kelas XII-A','Bahasa Inggris',78,75,80,77.7,'Tuntas'],
                                ['Putri Ayu Lestari','Kelas XII-B','Matematika',95,94,96,95,'Tuntas'],
                            ];
                        @endphp
                        @foreach($rekapData as $i => $r)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $i + 1 }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900 font-semibold cursor-pointer hover:text-blue-600 hover:underline transition-colors">{{ $r[0] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $r[1] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $r[2] }}</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-700 font-medium">{{ $r[3] }}</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-700 font-medium">{{ $r[4] }}</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-700 font-medium">{{ $r[5] }}</td>
                            <td class="px-6 py-4 text-center text-sm font-bold text-gray-900">{{ $r[6] }}</td>
                            <td class="px-6 py-4 text-center"><x-badge :type="$r[7] === 'Tuntas' ? 'success' : 'warning'">{{ $r[7] }}</x-badge></td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center">
                                    <button title="Cetak Rekap Siswa" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-[11px] font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-all shadow-sm active:scale-95">
                                        <i class="fa-solid fa-print"></i><span>Cetak</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <x-pagination :from="1" :to="8" :total="124" :lastPage="1" />
        </div>

        {{-- Footer Info --}}
        <div class="mt-6 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-sm font-semibold text-gray-900 mb-4">Keterangan Status</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex items-center gap-3">
                    <x-badge type="success">Tuntas</x-badge>
                    <p class="text-sm text-gray-600">Siswa telah mencapai standar ketuntasan minimum</p>
                </div>
                <div class="flex items-center gap-3">
                    <x-badge type="warning">Belum Tuntas</x-badge>
                    <p class="text-sm text-gray-600">Siswa masih perlu perhatian dan remediasi</p>
                </div>
            </div>
        </div>
    </div>
@endsection