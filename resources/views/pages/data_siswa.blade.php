@extends('layouts.app')

@section('title', 'Data Siswa')

@section('body-attrs')
x-data="{ openTambah: false }"
@endsection

@section('content')
    {{-- Modal Tambah Siswa --}}
    <x-modal name="openTambah" title="Tambah Siswa">
        <form action="" method="">
            @csrf
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="nis" class="block text-sm font-semibold text-gray-700 mb-1.5">NIS</label>
                    <input type="text" id="nis" name="nis" placeholder="Masukkan NIS" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all bg-white hover:border-gray-400">
                </div>
                <div>
                    <label for="nama_siswa" class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Siswa</label>
                    <input type="text" id="nama_siswa" name="nama_siswa" placeholder="Masukkan nama siswa" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all bg-white hover:border-gray-400">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="kelas" class="block text-sm font-semibold text-gray-700 mb-1.5">Kelas</label>
                    <select id="kelas" name="kelas" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all bg-gray-50 hover:border-gray-400 text-gray-700 appearance-none cursor-pointer">
                        <option value="">Pilih Kelas</option>
                    </select>
                </div>
                <div>
                    <label for="jenis_kelamin" class="block text-sm font-semibold text-gray-700 mb-1.5">Jenis Kelamin</label>
                    <select id="jenis_kelamin" name="jenis_kelamin" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all bg-gray-50 hover:border-gray-400 text-gray-700 appearance-none cursor-pointer">
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
            </div>
            <div class="mb-6">
                <label for="status_siswa" class="block text-sm font-semibold text-gray-700 mb-1.5">Status</label>
                <select id="status_siswa" name="status" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all bg-gray-50 hover:border-gray-400 text-gray-700 appearance-none cursor-pointer">
                    <option value="">Pilih Status</option>
                    <option value="aktif">Aktif</option>
                    <option value="tidak_aktif">Tidak Aktif</option>
                </select>
            </div>
            <div class="flex items-center gap-3">
                <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-900 text-white text-sm font-semibold rounded-lg hover:bg-gray-800 active:bg-gray-700 transition-all shadow-sm hover:shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Tambah</span>
                </button>
                <button type="button" @click="openTambah = false" class="px-5 py-2.5 text-sm font-semibold text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 active:bg-gray-100 transition-all">Batal</button>
            </div>
        </form>
    </x-modal>

    <div class="max-w-full">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <x-search-toolbar placeholder="Cari siswa..." :filterOptions="['Aktif', 'Tidak Aktif']" filterLabel="Filter Status" />

            {{-- Table Section --}}
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-gray-900 to-gray-800 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">NO</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">NIS</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Nama Siswa</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Kelas</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Jenis Kelamin</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-white uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @php
                            $siswaData = [
                                ['1809599001','Budi Santoso','X IPA 1','L','Aktif'],
                                ['1809599002','Siti Nurhaliza','X IPA 2','P','Aktif'],
                                ['1809599003','Ahmad Hidayat','X IPS 1','L','Aktif'],
                                ['1809599004','Dewi Lestari','XI IPA 1','P','Aktif'],
                                ['1809599005','Rinto Harahap','XI IPS 1','L','Tidak Aktif'],
                            ];
                        @endphp
                        @foreach($siswaData as $i => $s)
                        <tr class="hover:bg-blue-50 transition-colors duration-150 border-l-4 border-transparent hover:border-blue-500 {{ $i % 2 !== 0 ? 'bg-gray-50' : '' }}">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $i + 1 }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900 font-semibold">{{ $s[0] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $s[1] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $s[2] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $s[3] === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                            <td class="px-6 py-4 text-sm"><x-badge :type="$s[4] === 'Aktif' ? 'success' : 'danger'">{{ $s[4] }}</x-badge></td>
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