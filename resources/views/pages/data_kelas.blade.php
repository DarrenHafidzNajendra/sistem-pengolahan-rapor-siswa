@extends('layouts.app')

@section('title', 'Data Kelas')

@section('content')
    <div class="max-w-full" x-data="{ openTambah: false }">
        <x-modal name="openTambah" title="Tambah Kelas Baru">
            <form action="" method="">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="kode_kelas" class="block text-sm font-semibold text-gray-700 mb-1.5">Kode Kelas</label>
                        <input type="text" id="kode_kelas" name="kode_kelas" placeholder="Contoh: X-MIPA-1" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:border-gray-900 outline-none transition-colors">
                    </div>
                    <div>
                        <label for="nama_kelas" class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Kelas</label>
                        <input type="text" id="nama_kelas" name="nama_kelas" placeholder="Contoh: X MIPA 1" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:border-gray-900 outline-none transition-colors">
                    </div>
                    <div>
                        <label for="tingkat" class="block text-sm font-semibold text-gray-700 mb-1.5">Tingkat</label>
                        <select id="tingkat" name="tingkat" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:border-gray-900 outline-none transition-colors cursor-pointer">
                            <option value="X">X</option>
                            <option value="XI">XI</option>
                            <option value="XII">XII</option>
                        </select>
                    </div>
                </div>
                <div class="flex items-center gap-3 mt-8">
                    <button type="submit" @click.prevent="openTambah = false; $dispatch('notify', { message: 'Data kelas baru berhasil disimpan.' })" class="inline-flex items-center gap-2 px-6 py-2.5 bg-gray-900 text-white text-sm font-bold rounded-lg hover:bg-gray-800 transition-colors">
                        <i class="fa-solid fa-check"></i><span>Simpan Kelas</span>
                    </button>
                    <button type="button" @click="openTambah = false" class="px-6 py-2.5 text-sm font-bold text-gray-500 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">Batal</button>
                </div>
            </form>
        </x-modal>

        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <x-search-toolbar 
                placeholder="Cari kelas..." 
                :filters="[
                    ['name' => 'tingkat', 'label' => 'Filter Tingkat', 'options' => ['X' => 'X', 'XI' => 'XI', 'XII' => 'XII']]
                ]"
                :resetUrl="route('data_kelas')"
                tambahClick="openTambah = true" 
            />
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead class="bg-gray-900 border-b border-gray-800">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">NO</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Kode</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Nama Kelas</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Tingkat</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">Total Siswa</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($kelasData as $i => $k)
                        <tr class="hover:bg-blue-50/40 transition-colors">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $kelasData->firstItem() + $i }}</td>
                            <td class="px-6 py-4 text-sm text-gray-400 font-bold tracking-widest">{{ $k->kode_kelas }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900 font-bold uppercase tracking-tight">{{ $k->nama_kelas }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600 font-medium">{{ $k->tingkat }}</td>
                            <td class="px-6 py-4 text-center text-sm font-bold text-gray-700">{{ $k->kelas_siswa_count }} Siswa</td>
                            <td class="px-6 py-4 text-center"><x-action-buttons /></td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="px-6 py-8 text-center text-gray-500"><p class="text-sm font-medium">Tidak ada data kelas</p></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-6 bg-gray-50/30 border-t border-gray-100"><x-pagination :paginator="$kelasData" /></div>
        </div>
    </div>
@endsection