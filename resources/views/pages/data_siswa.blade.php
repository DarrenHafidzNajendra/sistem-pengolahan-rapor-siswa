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
                        <input type="text" id="nis" name="nis" placeholder="Masukkan NIS" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:border-gray-900 transition-colors bg-white">
                    </div>
                    <div>
                        <label for="nama_siswa" class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Siswa</label>
                        <input type="text" id="nama_siswa" name="nama_siswa" placeholder="Masukkan nama siswa" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:border-gray-900 transition-colors bg-white">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="kelas" class="block text-sm font-semibold text-gray-700 mb-1.5">Kelas</label>
                        <select id="kelas" name="kelas_id" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:border-gray-900 transition-colors bg-white text-gray-700 appearance-none cursor-pointer">
                            <option value="">Pilih Kelas</option>
                            @foreach($kelasList as $kelas)
                                <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="jenis_kelamin" class="block text-sm font-semibold text-gray-700 mb-1.5">Jenis Kelamin</label>
                        <select id="jenis_kelamin" name="jenis_kelamin" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:border-gray-900 transition-colors bg-white text-gray-700 appearance-none cursor-pointer">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                </div>
                <div class="mb-6">
                    <label for="status_siswa" class="block text-sm font-semibold text-gray-700 mb-1.5">Status</label>
                    <select id="status_siswa" name="status" class="w-full px-3 py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:border-gray-900 transition-colors bg-white text-gray-700 appearance-none cursor-pointer">
                        <option value="">Pilih Status</option>
                        <option value="Aktif">Aktif</option>
                        <option value="Tidak Aktif">Tidak Aktif</option>
                    </select>
                </div>
                <div class="flex items-center gap-3 mt-8">
                    <button type="submit" 
                            @click.prevent="openTambah = false; $dispatch('notify', { message: 'Data siswa baru berhasil ditambahkan ke sistem.' })"
                            class="inline-flex items-center gap-2 px-6 py-2.5 bg-gray-900 text-white text-sm font-bold rounded-lg hover:bg-gray-800 transition-colors">
                        <i class="fa-solid fa-check"></i>
                        <span>Simpan Data</span>
                    </button>
                    <button type="button" @click="openTambah = false" class="px-6 py-2.5 text-sm font-bold text-gray-500 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">Batal</button>
                </div>
            </form>
        </x-modal>

        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            {{-- Toolbar Section --}}
            <x-search-toolbar 
                placeholder="Cari siswa berdasarkan NIS atau Nama..." 
                :filters="[
                    ['name' => 'status', 'label' => 'Status Siswa', 'options' => ['Aktif' => 'Aktif', 'Tidak Aktif' => 'Tidak Aktif']],
                    ['name' => 'kelas_id', 'label' => 'Filter Kelas', 'options' => $kelasList->pluck('nama_kelas', 'id')->toArray()]
                ]"
                :resetUrl="route('data_siswa')"
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
                        @forelse($siswaData as $i => $s)
                        <tr class="hover:bg-blue-50/40 transition-colors">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $siswaData->firstItem() + $i }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900 font-semibold">{{ $s->nis }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700 font-bold">{{ $s->nama_siswa }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $s->kelasSiswa->first()?->kelas?->nama_kelas ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700 font-medium">{{ $s->jenis_kelamin }}</td>
                            <td class="px-6 py-4 text-sm"><x-badge :type="$s->status === 'Aktif' ? 'success' : 'danger'">{{ $s->status }}</x-badge></td>
                            <td class="px-6 py-4 text-center"><x-action-buttons /></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                <p class="text-sm font-medium">Tidak ada data siswa</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-6 bg-gray-50/30 border-t border-gray-100">
                <x-pagination :paginator="$siswaData" />
            </div>
        </div>
    </div>
@endsection