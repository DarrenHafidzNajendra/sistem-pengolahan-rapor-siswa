@extends('layouts.app')
@section('title', 'Data Rapor')

@section('content')
    <div class="max-w-full">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <x-search-toolbar placeholder="Cari nama siswa..." :filterOptions="['X A', 'X B', 'XI A', 'XI B', 'XII A', 'XII B']" filterLabel="Filter Kelas" :showTambah="false" />

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-gray-900 to-gray-800">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">NO</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">NIS</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Nama Siswa</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Kelas</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-white uppercase tracking-wider">Rata-Rata Nilai</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-white uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-white uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @php
                            $raporData = [
                                ['12001','Budi Santoso','X A',84.3,'Lulus','green','blue'],
                                ['12002','Siti Nurhaliza','X B',75,'Kondisional','yellow','orange'],
                                ['12003','Ahmad Riyadi','XI A',92.3,'Lulus','green','green'],
                                ['12004','Rina Wijaya','XI B',67.7,'Tidak Lulus','red','red'],
                                ['12005','Doni Hermawan','XII A',86.7,'Lulus','green','green'],
                                ['12006','Evy Kartika','XII B',82.3,'Lulus','green','green'],
                            ];
                        @endphp
                        @foreach($raporData as $i => $r)
                        <tr class="hover:bg-blue-50 transition-colors">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $i + 1 }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $r[0] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900 font-semibold">{{ $r[1] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $r[2] }}</td>
                            <td class="px-6 py-4 text-sm text-center font-bold text-{{ $r[6] }}-600">{{ $r[3] }}</td>
                            <td class="px-6 py-4 text-center"><x-badge :type="$r[4] === 'Lulus' ? 'success' : ($r[4] === 'Kondisional' ? 'warning' : 'danger')">{{ $r[4] }}</x-badge></td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <button title="Lihat Detail" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-all shadow-sm hover:shadow-md">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg><span>Lihat</span>
                                    </button>
                                    <button title="Export PDF" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-red-600 hover:bg-red-700 rounded-lg transition-all shadow-sm hover:shadow-md">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg><span>Export</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <x-pagination :from="1" :to="20" :total="432" :lastPage="22" />
        </div>
    </div>
@endsection