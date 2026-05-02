@extends('layouts.app')

@section('title', 'Data Mapel')

@section('content')
    <div class="max-w-full" x-data="{ openTambah: false }">
        {{-- Modal Tambah Mapel --}}
        <x-modal name="openTambah" title="Tambah Mata Pelajaran">
            <form action="" method="">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="kode_mapel" class="block text-sm font-semibold text-gray-700 mb-1.5">Kode Mapel</label>
                        <input type="text" id="kode_mapel" name="kode_mapel" placeholder="Contoh: MTK-X" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all">
                    </div>
                    <div>
                        <label for="nama_mapel" class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Mata Pelajaran</label>
                        <input type="text" id="nama_mapel" name="nama_mapel" placeholder="Masukkan nama mapel" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all">
                    </div>
                    <div>
                        <label for="beban_jam" class="block text-sm font-semibold text-gray-700 mb-1.5">Beban (Jam)</label>
                        <input type="number" id="beban_jam" name="beban_jam" placeholder="Contoh: 4" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all">
                    </div>
                </div>
                <div class="flex items-center gap-3 mt-8">
                    <button type="submit" 
                            @click.prevent="openTambah = false; $dispatch('notify', { message: 'Mata pelajaran baru berhasil ditambahkan.' })"
                            class="inline-flex items-center gap-2 px-6 py-2.5 bg-gray-900 text-white text-sm font-bold rounded-xl hover:bg-gray-800 active:scale-95 transition-all shadow-sm">
                        <i class="fa-solid fa-check"></i>
                        <span>Simpan Mapel</span>
                    </button>
                    <button type="button" @click="openTambah = false" class="px-6 py-2.5 text-sm font-bold text-gray-500 bg-gray-100 rounded-xl hover:bg-gray-200 transition-all">Batal</button>
                </div>
            </form>
        </x-modal>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <x-search-toolbar 
                placeholder="Cari mata pelajaran..." 
                :showFilter="false"
                tambahClick="openTambah = true"
            />

            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead class="bg-gray-900 border-b border-gray-800">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Kode</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Mata Pelajaran</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">Beban (Jam)</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @php
                            $mapelData = [
                                ['MTK','Matematika','4 Jam'],
                                ['BIN','Bahasa Indonesia','3 Jam'],
                                ['BIG','Bahasa Inggris','3 Jam'],
                                ['IPA','Ilmu Pengetahuan Alam','4 Jam'],
                                ['IPS','Ilmu Pengetahuan Sosial','4 Jam'],
                            ];
                        @endphp
                        @foreach($mapelData as $m)
                        <tr class="hover:bg-blue-50/40 transition-colors">
                            <td class="px-6 py-4 text-sm text-gray-400 font-bold tracking-widest">{{ $m[0] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900 font-black tracking-tight">{{ $m[1] }}</td>
                            <td class="px-6 py-4 text-center text-sm font-bold text-gray-500">{{ $m[2] }}</td>
                            <td class="px-6 py-4 text-center"><x-action-buttons /></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-6 bg-gray-50/30 border-t border-gray-100">
                <x-pagination :from="1" :to="5" :total="15" :lastPage="3" />
            </div>
        </div>
    </div>
@endsection