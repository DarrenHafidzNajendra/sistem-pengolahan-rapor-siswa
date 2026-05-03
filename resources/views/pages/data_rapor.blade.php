@extends('layouts.app')
@section('title', 'Data Rapor')

@section('content')
    <div class="max-w-full">
        <div class="bg-white rounded-lg border border-gray-200">
            <x-search-toolbar placeholder="Cari nama siswa..." :filterOptions="$kelasList->pluck('nama_kelas')->toArray()" filterLabel="Filter Kelas" :showTambah="false" />
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
                        @forelse($siswaData as $i => $r)
                        <tr class="hover:bg-blue-50 transition-colors">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $siswaData->firstItem() + $i }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $r->nis }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900 font-semibold cursor-pointer hover:text-blue-600 hover:underline transition-colors">{{ $r->nama_siswa }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $r->kelasSiswa->first()?->kelas?->nama_kelas ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-center font-bold {{ $r->rata_rata !== null ? ($r->rata_rata >= 80 ? 'text-green-600' : ($r->rata_rata >= 70 ? 'text-blue-600' : 'text-red-600')) : 'text-gray-400' }}">{{ $r->rata_rata ?? '-' }}</td>
                            <td class="px-6 py-4 text-center">
                                @if($r->status_lulus === 'Lulus')
                                    <x-badge type="success">Lulus</x-badge>
                                @elseif($r->status_lulus === 'Kondisional')
                                    <x-badge type="warning">Kondisional</x-badge>
                                @elseif($r->status_lulus === 'Tidak Lulus')
                                    <x-badge type="danger">Tidak Lulus</x-badge>
                                @else
                                    <span class="text-sm text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center">
                                    <button title="Cetak Rapor (PDF)" class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors">
                                        <i class="fa-solid fa-print"></i><span>Cetak Rapor</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="px-6 py-8 text-center text-gray-500"><p class="text-sm font-medium">Tidak ada data rapor</p></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-6 bg-gray-50/30 border-t border-gray-100">{{ $siswaData->links() }}</div>
        </div>
    </div>
@endsection