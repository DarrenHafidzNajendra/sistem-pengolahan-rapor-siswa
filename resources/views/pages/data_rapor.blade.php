@extends('layouts.app')
@section('title', 'Data Rapor')

@section('content')
    <div class="max-w-full">
        <div class="bg-white rounded-lg border border-gray-200">
            <x-search-toolbar placeholder="Cari nama siswa..." :filterOptions="['X A', 'X B', 'XI A', 'XI B', 'XII A', 'XII B']" filterLabel="Filter Kelas" :showTambah="false" />

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-900">
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
                            <td class="px-6 py-4 text-sm text-gray-900 font-semibold cursor-pointer hover:text-blue-600 hover:underline transition-colors">{{ $r[1] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $r[2] }}</td>
                            <td class="px-6 py-4 text-sm text-center font-bold text-{{ $r[6] }}-600">{{ $r[3] }}</td>
                            <td class="px-6 py-4 text-center"><x-badge :type="$r[4] === 'Lulus' ? 'success' : ($r[4] === 'Kondisional' ? 'warning' : 'danger')">{{ $r[4] }}</x-badge></td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center">
                                    <button title="Cetak Rapor (PDF)" class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors">
                                        <i class="fa-solid fa-print"></i><span>Cetak Rapor</span>
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