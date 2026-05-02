@extends('layouts.app')
@section('title', 'Pengampu')
@section('body-attrs') x-data="{ openTambah: false }" @endsection

@section('content')
    {{-- Modal Tambah Pengampu --}}
    <x-modal name="openTambah" title="Tambah Pengampu">
        <form action="{{ route('pengampu.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Mapel</label>
                    <select name="mapel_id" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:border-gray-900 bg-white text-gray-700 appearance-none cursor-pointer">
                        @foreach($mapels as $mapel)
                            <option value="{{ $mapel->id }}">{{ $mapel->nama_mapel }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Minimum KKM</label>
                    <input type="number" name="minimum_kkm" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:border-gray-900 bg-white">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Guru</label>
                    <select name="guru_id" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:border-gray-900 bg-white text-gray-700 appearance-none cursor-pointer">
                        @foreach($gurus as $guru)
                            <option value="{{ $guru->id }}">{{ $guru->nama_guru }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kelas</label>
                    <select name="kelas_id" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:border-gray-900 bg-white text-gray-700 appearance-none cursor-pointer">
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="flex items-center gap-3 mt-6">
                <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-900 text-white text-sm font-semibold rounded-lg hover:bg-gray-800 transition-colors">Tambah</button>
                <button type="button" @click="openTambah = false" class="px-5 py-2.5 text-sm font-semibold text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-all">Batal</button>
            </div>
        </form>
    </x-modal>

    <div class="max-w-full">
        <div class="bg-white rounded-lg border border-gray-200">
            <x-search-toolbar placeholder="Cari pengampu, guru..." :filterOptions="['Aktif', 'Tidak Aktif']" filterLabel="Filter Status" />
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-900">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">NO</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Kode Mapel</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Nama Mapel</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Minimum KKM</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Pengampu</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Kelas</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Tahun Ajaran</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-white uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($pengampus as $key => $p)
                        <tr class="hover:bg-blue-50 transition-colors duration-150 border-l-4 border-transparent hover:border-blue-500 {{ $key % 2 === 0 ? 'bg-white' : 'bg-gray-50' }}">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $key + 1 }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900 font-semibold">{{ $p->mapel->kode_mapel }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $p->mapel->nama_mapel }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $p->mapel->minimum_kkm }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $p->guru->nama_guru }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $p->kelas->nama_kelas }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $p->tahun_ajaran }}</td>
                            <td class="px-6 py-4 text-center"><x-action-buttons /></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <p class="text-sm font-medium">Tidak ada data pengampu</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <x-pagination :from="1" :to="20" :total="count($pengampus)" :lastPage="1" />
        </div>
    </div>
@endsection