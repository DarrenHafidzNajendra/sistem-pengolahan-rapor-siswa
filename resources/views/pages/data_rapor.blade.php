@extends('layouts.app')
@section('title', 'Data Rapor')

@section('content')
    <div class="max-w-full">
        <div class="bg-white rounded-lg border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <form action="{{ route('data_rapor') }}" method="GET" class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
                    <div class="w-full lg:w-80">
                        <div class="relative group">
                            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-blue-500 transition-colors"></i>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama siswa..." class="w-full pl-10 pr-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:border-gray-900 outline-none transition-colors bg-white">
                        </div>
                    </div>
                    <div class="flex flex-wrap items-center gap-3 w-full lg:w-auto">
                        <select name="kelas_id" class="px-4 py-2.5 text-sm font-semibold text-gray-700 border border-gray-300 rounded-lg bg-white focus:border-gray-900 outline-none transition-colors cursor-pointer">
                            <option value="">Semua Kelas</option>
                            @foreach($kelasList as $kelas)
                                <option value="{{ $kelas->id }}" {{ request('kelas_id') == $kelas->id ? 'selected' : '' }}>{{ $kelas->nama_kelas }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="px-5 py-2.5 bg-gray-900 text-white text-sm font-bold rounded-lg hover:bg-gray-800 transition-colors flex items-center gap-2 whitespace-nowrap">
                            <i class="fa-solid fa-magnifying-glass text-xs"></i><span>Cari</span>
                        </button>
                    </div>
                </form>
            </div>
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
            <div class="p-6 bg-gray-50/30 border-t border-gray-100"><x-pagination :paginator="$siswaData" /></div>
        </div>
    </div>
@endsection