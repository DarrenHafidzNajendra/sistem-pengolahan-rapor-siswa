@extends('layouts.app')

@section('title', 'Data Kelas')

@section('content')
    <div class="max-w-full" x-data="{ openTambah: false }">
        {{-- Modal Tambah Kelas --}}
        <x-modal name="openTambah" title="Tambah Kelas Baru">
            <form action="" method="">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="nama_kelas" class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Kelas</label>
                        <input type="text" id="nama_kelas" name="nama_kelas" placeholder="Contoh: X IPA 1" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all">
                    </div>
                    <div>
                        <label for="wali_kelas" class="block text-sm font-semibold text-gray-700 mb-1.5">Wali Kelas</label>
                        <select id="wali_kelas" name="wali_kelas" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all cursor-pointer">
                            <option value="">Pilih Guru Wali Kelas</option>
                            <option>Drs. Bambang Heru</option>
                            <option>Siti Aminah, S.Pd</option>
                        </select>
                    </div>
                </div>
                <div class="flex items-center gap-3 mt-8">
                    <button type="submit" 
                            @click.prevent="openTambah = false; $dispatch('notify', { message: 'Data kelas baru berhasil disimpan.' })"
                            class="inline-flex items-center gap-2 px-6 py-2.5 bg-gray-900 text-white text-sm font-bold rounded-xl hover:bg-gray-800 active:scale-95 transition-all shadow-sm">
                        <i class="fa-solid fa-check"></i>
                        <span>Simpan Kelas</span>
                    </button>
                    <button type="button" @click="openTambah = false" class="px-6 py-2.5 text-sm font-bold text-gray-500 bg-gray-100 rounded-xl hover:bg-gray-200 transition-all">Batal</button>
                </div>
            </form>
        </x-modal>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <x-search-toolbar 
                placeholder="Cari kelas..." 
                :showFilter="false"
                tambahClick="openTambah = true"
            />

            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead class="bg-gray-900 border-b border-gray-800">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">NO</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Nama Kelas</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Wali Kelas</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">Total Siswa</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @php
                            $kelasData = [
                                ['X IPA 1','Drs. Bambang Heru','32'],
                                ['X IPA 2','Siti Aminah, S.Pd','30'],
                                ['XI IPS 1','H. Mulyadi, M.Pd','35'],
                                ['XII IPA 1','Dra. Sulastri','28'],
                            ];
                        @endphp
                        @foreach($kelasData as $i => $k)
                        <tr class="hover:bg-blue-50/40 transition-colors">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $i + 1 }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900 font-bold uppercase tracking-tight">{{ $k[0] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600 font-medium">{{ $k[1] }}</td>
                            <td class="px-6 py-4 text-center text-sm font-bold text-gray-700">{{ $k[2] }} Siswa</td>
                            <td class="px-6 py-4 text-center"><x-action-buttons /></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-6 bg-gray-50/30 border-t border-gray-100">
                <x-pagination :from="1" :to="4" :total="12" :lastPage="1" />
            </div>
        </div>
    </div>
@endsection