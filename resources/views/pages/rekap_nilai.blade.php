@extends('layouts.app')
@section('title', 'Rekap Nilai')

@section('content')
    <div class="max-w-full">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <x-search-toolbar placeholder="Cari nama siswa, mapel..." :filterOptions="['Kelas X', 'Kelas XI', 'Kelas XII']" filterLabel="Filter Kelas" :showTambah="false" />
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
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $r[0] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $r[1] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $r[2] }}</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-700 font-medium">{{ $r[3] }}</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-700 font-medium">{{ $r[4] }}</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-700 font-medium">{{ $r[5] }}</td>
                            <td class="px-6 py-4 text-center text-sm font-bold text-gray-900">{{ $r[6] }}</td>
                            <td class="px-6 py-4 text-center"><x-badge :type="$r[7] === 'Tuntas' ? 'success' : 'warning'">{{ $r[7] }}</x-badge></td>
                            <td class="px-6 py-4 text-center">
                                <button class="text-blue-600 hover:text-blue-900 font-medium text-xs" title="Lihat Detail">
                                    <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </button>
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