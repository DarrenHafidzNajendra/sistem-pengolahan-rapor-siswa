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
                        <input type="text" id="kode_mapel" name="kode_mapel" placeholder="Contoh: MTK-W" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded focus:border-gray-900 outline-none transition-colors">
                    </div>
                    <div>
                        <label for="nama_mapel" class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Mata Pelajaran</label>
                        <input type="text" id="nama_mapel" name="nama_mapel" placeholder="Masukkan nama mapel" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded focus:border-gray-900 outline-none transition-colors">
                    </div>
                    <div>
                        <label for="kelompok" class="block text-sm font-semibold text-gray-700 mb-1.5">Kelompok</label>
                        <select id="kelompok" name="kelompok" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded focus:border-gray-900 outline-none transition-colors cursor-pointer">
                            <option value="Wajib">Wajib</option>
                            <option value="Peminatan">Peminatan</option>
                            <option value="Muatan Lokal">Muatan Lokal</option>
                        </select>
                    </div>
                </div>
                <div class="flex items-center gap-3 mt-8">
                    <button type="submit" @click.prevent="openTambah = false; $dispatch('notify', { message: 'Mata pelajaran baru berhasil ditambahkan.', type: 'success' })" class="inline-flex items-center gap-2 px-6 py-2.5 bg-gray-900 text-white text-sm font-semibold rounded hover:bg-gray-800 transition-colors">
                        <i class="fa-solid fa-check"></i><span>Simpan Mapel</span>
                    </button>
                    <button type="button" @click="openTambah = false" class="px-6 py-2.5 text-sm font-semibold text-gray-500 bg-gray-100 rounded hover:bg-gray-200 transition-colors">Batal</button>
                </div>
            </form>
        </x-modal>

        <div class="bg-white rounded border border-gray-200 overflow-hidden">
            <x-search-toolbar 
                placeholder="Cari mata pelajaran..." 
                :filters="[
                    ['name' => 'kelompok', 'label' => 'Kelompok', 'options' => ['Wajib' => 'Wajib', 'Peminatan' => 'Peminatan', 'Muatan Lokal' => 'Muatan Lokal']],
                    ['name' => 'status', 'label' => 'Status', 'options' => ['Aktif' => 'Aktif', 'Tidak Aktif' => 'Tidak Aktif']]
                ]"
                :resetUrl="route('data_mapel')"
                tambahClick="openTambah = true" 
            />
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead class="bg-gray-900 border-b border-gray-800">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white tracking-wider">No</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white tracking-wider">Kode Mapel</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white tracking-wider">Nama Mapel</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white tracking-wider">Kelompok</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white tracking-wider">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-white tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($mapelData as $i => $m)
                        <tr>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $mapelData->firstItem() + $i }}</td>
                            <td class="px-6 py-4 text-sm text-gray-400 font-medium tracking-tight">{{ $m->kode_mapel }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900 font-semibold tracking-tight">{{ $m->nama_mapel }}</td>
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