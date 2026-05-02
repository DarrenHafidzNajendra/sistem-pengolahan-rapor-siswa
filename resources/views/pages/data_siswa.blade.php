@extends('layouts.app')

@section('title', 'Data Siswa')

@section('content')
    <div class="max-w-full" x-data="{ openTambah: false }">
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
                    <button type="submit" 
                            @click.prevent="openTambah = false; $dispatch('notify', { message: 'Data siswa baru berhasil ditambahkan ke sistem.' })"
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-900 text-white text-sm font-semibold rounded-lg hover:bg-gray-800 active:bg-gray-700 transition-all shadow-sm hover:shadow-md">
                        <i class="fa-solid fa-plus text-xs"></i>
                        <span>Tambah Siswa</span>
                    </button>
                    <button type="button" @click="openTambah = false" class="px-5 py-2.5 text-sm font-semibold text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 active:bg-gray-100 transition-all">Batal</button>
                </div>
            </form>
        </x-modal>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            {{-- Toolbar Section --}}
            <x-search-toolbar 
                placeholder="Cari siswa berdasarkan NIS atau Nama..." 
                :filterOptions="['Aktif', 'Tidak Aktif']" 
                filterLabel="Status Siswa"
                tambahClick="openTambah = true"
            />

            {{-- Table Section --}}
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-900 border-b border-gray-800">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">NO</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">NIS</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Nama Siswa</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Kelas</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Jenis Kelamin</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
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
                        <tr class="hover:bg-blue-50/40 transition-colors">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $i + 1 }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900 font-semibold">{{ $s[0] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700 font-bold">{{ $s[1] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $s[2] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700 font-medium">{{ $s[3] === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                            <td class="px-6 py-4 text-sm"><x-badge :type="$s[4] === 'Aktif' ? 'success' : 'danger'">{{ $s[4] }}</x-badge></td>
                            <td class="px-6 py-4 text-center"><x-action-buttons /></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-6 bg-gray-50/30 border-t border-gray-100">
                <x-pagination :from="1" :to="5" :total="432" :lastPage="22" />
            </div>
        </div>
    </div>
@endsection