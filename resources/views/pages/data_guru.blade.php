@extends('layouts.app')
@section('title', 'Data Guru')
@section('body-attrs') x-data="{ openTambah: false }" @endsection

@section('content')
    <x-modal name="openTambah" title="Tambah Guru">
        <form action="" method="">
            @csrf
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="nip" class="block text-sm font-semibold text-gray-700 mb-1.5">NIP</label>
                    <input type="text" id="nip" name="nip" placeholder="Masukkan NIP" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white hover:border-gray-400">
                </div>
                <div>
                    <label for="nama_guru" class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Guru</label>
                    <input type="text" id="nama_guru" name="nama_guru" placeholder="Masukkan nama guru" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white hover:border-gray-400">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="email_guru" class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
                    <input type="email" id="email_guru" name="email" placeholder="Masukkan email" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white hover:border-gray-400">
                </div>
                <div>
                    <label for="no_telp" class="block text-sm font-semibold text-gray-700 mb-1.5">No. Telepon</label>
                    <input type="text" id="no_telp" name="no_telp" placeholder="Masukkan no. telepon" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white hover:border-gray-400">
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
            <x-search-toolbar placeholder="Cari guru..." :filterOptions="['Aktif', 'Tidak Aktif']" filterLabel="Filter Status" />
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-gray-900 to-gray-800">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">NO</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">NIP</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Nama Guru</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Email</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">No. Telepon</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-white uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @php
                            $guruData = [
                                ['198501012010011001','Budi Santoso, S.Pd','budi@sekolah.id','081234567890','Aktif'],
                                ['198602022011012002','Siti Nurhaliza, S.Pd','siti@sekolah.id','081234567891','Aktif'],
                                ['198703032012013003','Ahmad Hidayat, S.Pd','ahmad@sekolah.id','081234567892','Aktif'],
                                ['198804042013014004','Dewi Lestari, S.Pd','dewi@sekolah.id','081234567893','Aktif'],
                                ['198905052014015005','Rinto Harahap, S.Pd','rinto@sekolah.id','081234567894','Tidak Aktif'],
                            ];
                        @endphp
                        @foreach($guruData as $i => $g)
                        <tr class="hover:bg-blue-50 transition-colors duration-150 border-l-4 border-transparent hover:border-blue-500 {{ $i % 2 !== 0 ? 'bg-gray-50' : '' }}">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $i + 1 }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900 font-semibold">{{ $g[0] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $g[1] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $g[2] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $g[3] }}</td>
                            <td class="px-6 py-4 text-sm"><x-badge :type="$g[4] === 'Aktif' ? 'success' : 'danger'">{{ $g[4] }}</x-badge></td>
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