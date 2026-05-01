@extends('layouts.app')
@section('title', 'Data Kelas')
@section('body-attrs') x-data="{ openTambah: false }" @endsection

@section('content')
    <x-modal name="openTambah" title="Tambah Kelas">
        <form action="" method="">
            @csrf
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="kode_kelas" class="block text-sm font-semibold text-gray-700 mb-1.5">Kode Kelas</label>
                    <input type="text" id="kode_kelas" name="kode_kelas" placeholder="Contoh: X-IPA-1" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white hover:border-gray-400">
                </div>
                <div>
                    <label for="nama_kelas" class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Kelas</label>
                    <input type="text" id="nama_kelas" name="nama_kelas" placeholder="Masukkan nama kelas" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white hover:border-gray-400">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="tingkat" class="block text-sm font-semibold text-gray-700 mb-1.5">Tingkat</label>
                    <select id="tingkat" name="tingkat" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-gray-50 hover:border-gray-400 text-gray-700 appearance-none cursor-pointer">
                        <option value="">Pilih Tingkat</option>
                        <option value="X">X</option><option value="XI">XI</option><option value="XII">XII</option>
                    </select>
                </div>
                <div>
                    <label for="tahun_ajaran" class="block text-sm font-semibold text-gray-700 mb-1.5">Tahun Ajaran</label>
                    <input type="text" id="tahun_ajaran" name="tahun_ajaran" placeholder="Contoh: 2024/2025" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white hover:border-gray-400">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="jurusan" class="block text-sm font-semibold text-gray-700 mb-1.5">Jurusan</label>
                    <select id="jurusan" name="jurusan" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-gray-50 hover:border-gray-400 text-gray-700 appearance-none cursor-pointer">
                        <option value="">Pilih Jurusan</option>
                        <option value="IPA">IPA</option><option value="IPS">IPS</option><option value="Bahasa">Bahasa</option>
                    </select>
                </div>
                <div>
                    <label for="wali_kelas_id" class="block text-sm font-semibold text-gray-700 mb-1.5">Wali Kelas</label>
                    <select id="wali_kelas_id" name="wali_kelas_id" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-gray-50 hover:border-gray-400 text-gray-700 appearance-none cursor-pointer">
                        <option value="">Pilih Wali Kelas</option>
                        @foreach($gurus ?? [] as $guru)
                            <option value="{{ $guru->id }}">{{ $guru->nama_guru }}</option>
                        @endforeach
                    </select>
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
            <x-search-toolbar placeholder="Cari kelas..." :filterOptions="['X', 'XI', 'XII']" filterLabel="Filter Kelas" />
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-gray-900 to-gray-800">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">NO</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Nama Kelas</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Tingkat</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Tahun Ajaran</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Jurusan</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Wali Kelas</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Jumlah Siswa</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-white uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @php
                            $kelasData = [
                                ['X-IPA-1','X','2024/2025','IPA','Budi Santoso, S.Pd',32],
                                ['X-IPA-2','X','2024/2025','IPA','Siti Nurhaliza, S.Pd',31],
                                ['X-IPS-1','X','2024/2025','IPS','Ahmad Hidayat, S.Pd',33],
                                ['XI-IPA-1','XI','2024/2025','IPA','Rinto Harahap, S.Pd',30],
                                ['XII-IPA-1','XII','2024/2025','IPA','Fajar Nugroho, S.Pd',29],
                            ];
                        @endphp
                        @foreach($kelasData as $i => $k)
                        <tr class="hover:bg-blue-50 transition-colors duration-150 border-l-4 border-transparent hover:border-blue-500 {{ $i % 2 !== 0 ? 'bg-gray-50' : '' }}">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $i + 1 }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900 font-semibold">{{ $k[0] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $k[1] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $k[2] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $k[3] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $k[4] }}</td>
                            <td class="px-6 py-4 text-sm"><x-badge type="info" :dot="false">{{ $k[5] }}</x-badge></td>
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