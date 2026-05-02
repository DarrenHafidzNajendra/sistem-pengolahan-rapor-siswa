@extends('layouts.app')

@section('title', 'Data Guru')

@section('content')
    <div class="max-w-full" x-data="{ openTambah: false }">
        {{-- Modal Tambah Guru --}}
        <x-modal name="openTambah" title="Tambah Guru Baru">
            <form action="" method="">
                @csrf
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="nip" class="block text-sm font-semibold text-gray-700 mb-1.5">NIP / ID Guru</label>
                        <input type="text" id="nip" name="nip" placeholder="Masukkan NIP" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all bg-white hover:border-gray-400 outline-none">
                    </div>
                    <div>
                        <label for="nama_guru" class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Lengkap</label>
                        <input type="text" id="nama_guru" name="nama_guru" placeholder="Masukkan nama lengkap" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all bg-white hover:border-gray-400 outline-none">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="mapel" class="block text-sm font-semibold text-gray-700 mb-1.5">Mata Pelajaran Utama</label>
                        <select id="mapel" name="mapel" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all bg-white hover:border-gray-400 cursor-pointer outline-none">
                            <option value="">Pilih Mapel</option>
                            <option>Matematika</option>
                            <option>Bahasa Indonesia</option>
                        </select>
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-semibold text-gray-700 mb-1.5">Status Pegawai</label>
                        <select id="status" name="status" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all bg-white hover:border-gray-400 cursor-pointer outline-none">
                            <option value="PNS">PNS</option>
                            <option value="Honorer">Honorer</option>
                        </select>
                    </div>
                </div>
                <div class="flex items-center gap-3 mt-6">
                    <button type="submit" 
                            @click.prevent="openTambah = false; $dispatch('notify', { message: 'Data guru baru berhasil ditambahkan.' })"
                            class="inline-flex items-center gap-2 px-6 py-2.5 bg-gray-900 text-white text-sm font-bold rounded-xl hover:bg-gray-800 active:scale-95 transition-all shadow-sm">
                        <i class="fa-solid fa-check"></i>
                        <span>Simpan Data Guru</span>
                    </button>
                    <button type="button" @click="openTambah = false" class="px-6 py-2.5 text-sm font-bold text-gray-500 bg-gray-100 rounded-xl hover:bg-gray-200 transition-all">Batal</button>
                </div>
            </form>
        </x-modal>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <x-search-toolbar 
                placeholder="Cari guru berdasarkan NIP atau Nama..." 
                :filterOptions="['PNS', 'Honorer']" 
                filterLabel="Status Guru"
                tambahClick="openTambah = true"
            />

            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead class="bg-gray-900 border-b border-gray-800">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">NIP</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Nama Guru</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Mapel</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @php
                            $guruData = [
                                ['198001012005011001','Drs. Bambang Heru','Matematika','PNS'],
                                ['198505122010022005','Siti Aminah, S.Pd','Bahasa Indonesia','PNS'],
                                ['-','Rizky Pratama, S.Kom','Informatika','Honorer'],
                                ['197812152003121002','H. Mulyadi, M.Pd','Pendidikan Agama','PNS'],
                            ];
                        @endphp
                        @foreach($guruData as $g)
                        <tr class="hover:bg-blue-50/40 transition-colors">
                            <td class="px-6 py-4 text-sm text-gray-400 font-medium tracking-tighter">{{ $g[0] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900 font-bold">{{ $g[1] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600 font-medium">{{ $g[2] }}</td>
                            <td class="px-6 py-4 text-sm"><x-badge :type="$g[3] === 'PNS' ? 'success' : 'warning'">{{ $g[3] }}</x-badge></td>
                            <td class="px-6 py-4 text-center"><x-action-buttons /></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-6 bg-gray-50/30 border-t border-gray-100">
                <x-pagination :from="1" :to="4" :total="48" :lastPage="12" />
            </div>
        </div>
    </div>
@endsection