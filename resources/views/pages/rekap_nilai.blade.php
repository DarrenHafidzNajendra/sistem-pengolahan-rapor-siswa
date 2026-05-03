@extends('layouts.app')
@section('title', 'Rekap Nilai')

@section('content')
    <div class="max-w-full">
        <div class="bg-white rounded-lg border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
                    <div class="w-full lg:w-80">
                        <div class="relative group">
                            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-blue-500 transition-colors"></i>
                            <input type="text" placeholder="Cari nama siswa..." class="w-full pl-10 pr-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:border-gray-900 outline-none transition-colors bg-white">
                        </div>
                    </div>
                    <div class="flex flex-wrap items-center gap-3 w-full lg:w-auto">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Filter:</span>
                            <select class="px-4 py-2.5 text-sm font-semibold text-gray-700 border border-gray-300 rounded-lg focus:border-gray-900 outline-none bg-white cursor-pointer transition-colors min-w-[140px]">
                                <option value="">Semua Kelas</option>
                                @foreach($kelasList as $k)
                                    <option>{{ $k->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <select class="px-4 py-2.5 text-sm font-semibold text-gray-700 border border-gray-300 rounded-lg focus:border-gray-900 outline-none bg-white cursor-pointer transition-colors min-w-[180px]">
                            <option value="">Semua Mata Pelajaran</option>
                            @foreach($mapelList as $m)
                                <option>{{ $m->nama_mapel }}</option>
                            @endforeach
                        </select>
                        <button class="px-5 py-2.5 bg-gray-900 text-white text-sm font-bold rounded-lg hover:bg-gray-800 transition-colors flex items-center gap-2 whitespace-nowrap">
                            <i class="fa-solid fa-magnifying-glass text-xs"></i><span>Cari</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-900">
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
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($nilaiData as $i => $n)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $nilaiData->firstItem() + $i }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900 font-semibold">{{ $n->siswa->nama_siswa }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $n->pengampu->kelas->nama_kelas }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $n->pengampu->mapel->nama_mapel }}</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-700 font-medium">{{ $n->tugas ?? '-' }}</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-700 font-medium">{{ $n->uts ?? '-' }}</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-700 font-medium">{{ $n->uas ?? '-' }}</td>
                            <td class="px-6 py-4 text-center text-sm font-bold text-gray-900">{{ $n->rata_pengetahuan ?? '-' }}</td>
                            @php $kkm = $n->pengampu->kkm; $tuntas = $n->rata_pengetahuan !== null && $n->rata_pengetahuan >= $kkm; @endphp
                            <td class="px-6 py-4 text-center"><x-badge :type="$tuntas ? 'success' : 'warning'">{{ $tuntas ? 'Tuntas' : 'Belum Tuntas' }}</x-badge></td>
                        </tr>
                        @empty
                        <tr><td colspan="9" class="px-6 py-8 text-center text-gray-500"><p class="text-sm font-medium">Tidak ada data nilai</p></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-6 bg-gray-50/30 border-t border-gray-100"><x-pagination :paginator="$nilaiData" /></div>
        </div>

        <div class="mt-6 bg-white rounded-lg border border-gray-200 p-6">
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