@extends('layouts.app')
@section('title', 'Data Mapel')
@section('body-attrs') x-data="{ openTambah: false }" @endsection

@section('content')
    <x-modal name="openTambah" title="Tambah Mata Pelajaran">
        <form action="" method="">
            @csrf
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="kode_mapel" class="block text-sm font-semibold text-gray-700 mb-1.5">Kode Mapel</label>
                    <input type="text" id="kode_mapel" name="kode_mapel" placeholder="Contoh: BIN" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white hover:border-gray-400">
                </div>
                <div>
                    <label for="nama_mapel" class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Mapel</label>
                    <input type="text" id="nama_mapel" name="nama_mapel" placeholder="Contoh: Bahasa Indonesia" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white hover:border-gray-400">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="kelompok" class="block text-sm font-semibold text-gray-700 mb-1.5">Kelompok</label>
                    <select id="kelompok" name="kelompok" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-gray-50 hover:border-gray-400 text-gray-700 appearance-none cursor-pointer">
                        <option value="">Pilih Kelompok</option>
                        <option value="Wajib">Wajib</option><option value="Peminatan">Peminatan</option><option value="Lintas Minat">Lintas Minat</option>
                    </select>
                </div>
                <div>
                    <label for="jam_pelajaran" class="block text-sm font-semibold text-gray-700 mb-1.5">Jam Pelajaran</label>
                    <input type="number" id="jam_pelajaran" name="jam_pelajaran" placeholder="Contoh: 4" min="1" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white hover:border-gray-400">
                </div>
            </div>
            <div class="flex items-center gap-3">
                <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-900 text-white text-sm font-semibold rounded-lg hover:bg-gray-800 transition-all shadow-sm hover:shadow-md">Tambah</button>
                <button type="button" @click="openTambah = false" class="px-5 py-2.5 text-sm font-semibold text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-all">Batal</button>
            </div>
        </form>
    </x-modal>

    <div class="max-w-full">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <x-search-toolbar placeholder="Cari mapel..." :filterOptions="['Wajib', 'Peminatan', 'Lintas Minat']" filterLabel="Filter Mapel" />
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-gray-900 to-gray-800">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">NO</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Kode Mapel</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Nama Mapel</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Kelompok</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Jam Pelajaran</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-white uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @php
                            $mapelData = [
                                ['BIN','Bahasa Indonesia','Wajib','4 Jam','Aktif'],
                                ['BIG','Bahasa Inggris','Wajib','3 Jam','Aktif'],
                                ['MTK','Matematika','Wajib','4 Jam','Aktif'],
                                ['IPA','Ilmu Pengetahuan Alam','Wajib','3 Jam','Aktif'],
                                ['FISIKA','Fisika','Peminatan','3 Jam','Aktif'],
                            ];
                        @endphp
                        @foreach($mapelData as $i => $m)
                        <tr class="hover:bg-blue-50 transition-colors duration-150 border-l-4 border-transparent hover:border-blue-500 {{ $i % 2 !== 0 ? 'bg-gray-50' : '' }}">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $i + 1 }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900 font-semibold">{{ $m[0] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $m[1] }}</td>
                            <td class="px-6 py-4 text-sm"><x-badge :type="$m[2] === 'Wajib' ? 'purple' : 'info'">{{ $m[2] }}</x-badge></td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $m[3] }}</td>
                            <td class="px-6 py-4 text-sm"><x-badge type="success">{{ $m[4] }}</x-badge></td>
                            <td class="px-6 py-4 text-center"><x-action-buttons /></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <x-pagination :from="1" :to="20" :total="432" :lastPage="22" />
        </div>
    </div>
@endsection