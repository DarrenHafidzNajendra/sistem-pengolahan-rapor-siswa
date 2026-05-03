@extends('layouts.app')

@section('title', 'Data Mapel')

@section('content')
    <div class="max-w-full" x-data="{ openTambah: false }">
        <x-modal name="openTambah" title="Tambah Mata Pelajaran">
            <form action="" method="">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="kode_mapel" class="block text-sm font-semibold text-gray-700 mb-1.5">Kode Mapel</label>
                        <input type="text" id="kode_mapel" name="kode_mapel" placeholder="Contoh: MTK-W" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:border-gray-900 outline-none transition-colors">
                    </div>
                    <div>
                        <label for="nama_mapel" class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Mata Pelajaran</label>
                        <input type="text" id="nama_mapel" name="nama_mapel" placeholder="Masukkan nama mapel" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:border-gray-900 outline-none transition-colors">
                    </div>
                    <div>
                        <label for="kelompok" class="block text-sm font-semibold text-gray-700 mb-1.5">Kelompok</label>
                        <select id="kelompok" name="kelompok" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:border-gray-900 outline-none transition-colors cursor-pointer">
                            <option value="Wajib">Wajib</option>
                            <option value="Peminatan">Peminatan</option>
                            <option value="Muatan Lokal">Muatan Lokal</option>
                        </select>
                    </div>
                </div>
                <div class="flex items-center gap-3 mt-8">
                    <button type="submit" @click.prevent="openTambah = false; $dispatch('notify', { message: 'Mata pelajaran baru berhasil ditambahkan.' })" class="inline-flex items-center gap-2 px-6 py-2.5 bg-gray-900 text-white text-sm font-bold rounded-lg hover:bg-gray-800 transition-colors">
                        <i class="fa-solid fa-check"></i><span>Simpan Mapel</span>
                    </button>
                    <button type="button" @click="openTambah = false" class="px-6 py-2.5 text-sm font-bold text-gray-500 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">Batal</button>
                </div>
            </form>
        </x-modal>

        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <x-search-toolbar placeholder="Cari mata pelajaran..." :showFilter="false" tambahClick="openTambah = true" />
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead class="bg-gray-900 border-b border-gray-800">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">NO</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Kode</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Mata Pelajaran</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Kelompok</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($mapelData as $i => $m)
                        <tr class="hover:bg-blue-50/40 transition-colors">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $mapelData->firstItem() + $i }}</td>
                            <td class="px-6 py-4 text-sm text-gray-400 font-bold tracking-widest">{{ $m->kode_mapel }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900 font-black tracking-tight">{{ $m->nama_mapel }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600 font-medium">{{ $m->kelompok }}</td>
                            <td class="px-6 py-4 text-sm"><x-badge :type="$m->status === 'Aktif' ? 'success' : 'danger'">{{ $m->status }}</x-badge></td>
                            <td class="px-6 py-4 text-center"><x-action-buttons /></td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="px-6 py-8 text-center text-gray-500"><p class="text-sm font-medium">Tidak ada data mapel</p></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-6 bg-gray-50/30 border-t border-gray-100"><x-pagination :paginator="$mapelData" /></div>
        </div>
    </div>
@endsection