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
                        <input type="text" id="nip" name="nip" placeholder="Masukkan NIP" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:border-gray-900 transition-colors bg-white">
                    </div>
                    <div>
                        <label for="nama_guru" class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Lengkap</label>
                        <input type="text" id="nama_guru" name="nama_guru" placeholder="Masukkan nama lengkap" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:border-gray-900 transition-colors bg-white">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="jenis_kelamin_guru" class="block text-sm font-semibold text-gray-700 mb-1.5">Jenis Kelamin</label>
                        <select id="jenis_kelamin_guru" name="jenis_kelamin" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:border-gray-900 transition-colors bg-white cursor-pointer">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label for="no_telp" class="block text-sm font-semibold text-gray-700 mb-1.5">No. Telepon</label>
                        <input type="text" id="no_telp" name="no_hp" placeholder="08xxxxxxxxxx" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:border-gray-900 transition-colors bg-white">
                    </div>
                </div>
                <div class="mb-4">
                    <label for="status" class="block text-sm font-semibold text-gray-700 mb-1.5">Status</label>
                    <select id="status" name="status" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:border-gray-900 transition-colors bg-white cursor-pointer">
                        <option value="Aktif">Aktif</option>
                        <option value="Tidak Aktif">Tidak Aktif</option>
                    </select>
                </div>
                <div class="flex items-center gap-3 mt-6">
                    <button type="submit" 
                            @click.prevent="openTambah = false; $dispatch('notify', { message: 'Data guru baru berhasil ditambahkan.' })"
                            class="inline-flex items-center gap-2 px-6 py-2.5 bg-gray-900 text-white text-sm font-bold rounded-lg hover:bg-gray-800 transition-colors">
                        <i class="fa-solid fa-check"></i>
                        <span>Simpan Data Guru</span>
                    </button>
                    <button type="button" @click="openTambah = false" class="px-6 py-2.5 text-sm font-bold text-gray-500 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">Batal</button>
                </div>
            </form>
        </x-modal>

        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <x-search-toolbar 
                placeholder="Cari guru berdasarkan NIP atau Nama..." 
                :filterOptions="['Aktif', 'Tidak Aktif']" 
                filterLabel="Status Guru"
                tambahClick="openTambah = true"
            />

            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead class="bg-gray-900 border-b border-gray-800">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">NO</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">NIP</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Nama Guru</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Jenis Kelamin</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">No. Telepon</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($guruData as $i => $g)
                        <tr class="hover:bg-blue-50/40 transition-colors">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $guruData->firstItem() + $i }}</td>
                            <td class="px-6 py-4 text-sm text-gray-400 font-medium tracking-tighter">{{ $g->nip }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900 font-bold">{{ $g->nama_guru }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700 font-medium">{{ $g->jenis_kelamin }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600 font-medium">{{ $g->no_hp ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm"><x-badge :type="$g->status === 'Aktif' ? 'success' : 'danger'">{{ $g->status }}</x-badge></td>
                            <td class="px-6 py-4 text-center"><x-action-buttons /></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                <p class="text-sm font-medium">Tidak ada data guru</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-6 bg-gray-50/30 border-t border-gray-100">
                {{ $guruData->links() }}
            </div>
        </div>
    </div>
@endsection