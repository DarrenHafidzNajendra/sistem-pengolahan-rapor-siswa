@extends('layouts.app')
@section('title', 'Data Presensi Kelas')

@section('content')
    <div class="max-w-full">
        <div x-data="presensiApp()" class="bg-white rounded border border-gray-200">
            <form action="{{ route('presensi.store') }}" method="POST" @submit="if(document.querySelectorAll('input[type=radio]:checked').length < {{ count($presensiList) }}) { $event.preventDefault(); alert('Mohon isi semua status kehadiran siswa terlebih dahulu!'); }">
                @csrf
                <input type="hidden" name="pengampu_id" value="{{ $selectedPengampu?->id }}">
                <input type="hidden" name="tanggal" value="{{ $tanggal }}">

                <div class="p-6 border-b border-gray-200">
                    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                        <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
                            <select @change="window.location.href = '{{ route('presensi') }}?mapel_id=' + $el.value + '&kelas_id={{ request('kelas_id') }}&tanggal={{ $tanggal }}'" class="appearance-none w-40 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-200 rounded focus:outline-none focus:border-gray-900 cursor-pointer">
                                @foreach($mapelList as $m)
                                    <option value="{{ $m->id }}" {{ ($selectedPengampu && $selectedPengampu->mapel_id == $m->id) || request('mapel_id') == $m->id ? 'selected' : '' }}>{{ $m->nama_mapel }}</option>
                                @endforeach
                            </select>
                            <select @change="window.location.href = '{{ route('presensi') }}?mapel_id={{ request('mapel_id') }}&kelas_id=' + $el.value + '&tanggal={{ $tanggal }}'" class="appearance-none w-32 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-200 rounded focus:outline-none focus:border-gray-900 cursor-pointer">
                                @foreach($kelasList as $k)
                                    <option value="{{ $k->id }}" {{ ($selectedPengampu && $selectedPengampu->kelas_id == $k->id) || request('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                                @endforeach
                            </select>
                            <input type="date" value="{{ $tanggal }}" @change="window.location.href = '{{ route('presensi') }}?mapel_id={{ request('mapel_id') }}&kelas_id={{ request('kelas_id') }}&tanggal=' + $el.value" class="w-40 px-3 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-200 rounded focus:outline-none focus:border-gray-900 cursor-pointer">
                        </div>
                        <div class="flex items-center gap-2 w-full md:w-auto">
                            <button type="button" x-show="isEditing" @click="markAllHadir()" class="px-4 py-2 bg-blue-50 text-blue-700 text-sm font-semibold rounded hover:bg-blue-100 border border-blue-200 transition-colors flex items-center gap-2 whitespace-nowrap">
                                <i class="fa-solid fa-check-double"></i><span>Hadir Semua</span>
                            </button>
                            <button type="button" x-show="!isEditing" @click="isEditing = true" class="w-[160px] justify-center px-4 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded transition-colors flex items-center gap-2 whitespace-nowrap">
                                <i class="fa-solid fa-pen-to-square"></i><span>Edit Presensi</span>
                            </button>
                            <button type="submit" x-show="isEditing" class="w-[160px] justify-center px-4 py-2.5 bg-gray-900 text-white text-sm font-semibold rounded transition-colors flex items-center gap-2 whitespace-nowrap">
                                <i class="fa-solid fa-floppy-disk"></i><span>Simpan Data</span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="px-6 py-4 bg-gray-50/50 border-b border-gray-200">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div>
                            <h2 class="text-base font-semibold text-gray-900">Form Input Presensi Siswa</h2>
                            <div class="flex flex-wrap items-center gap-x-6 gap-y-2 mt-2 text-sm">
                                <div class="flex items-center gap-2 text-gray-600"><i class="fa-solid fa-book text-blue-600 opacity-80"></i><span>Mata Pelajaran: <strong class="text-gray-900">{{ $selectedPengampu?->mapel?->nama_mapel ?? '-' }}</strong></span></div>
                                <div class="flex items-center gap-2 text-gray-600"><i class="fa-solid fa-users text-blue-600 opacity-80"></i><span>Kelas: <strong class="text-gray-900">{{ $selectedPengampu?->kelas?->nama_kelas ?? '-' }}</strong></span></div>
                                <div class="flex items-center gap-2 text-gray-600"><i class="fa-regular fa-calendar-days text-blue-600 opacity-80"></i><span>Tanggal: <strong class="text-gray-900">{{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}</strong></span></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-900">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white tracking-wider">No</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white tracking-wider">NIS</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white tracking-wider min-w-[200px]">Nama Siswa</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-white tracking-wider">Hadir</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-white tracking-wider">T. Hadir</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-white tracking-wider">Izin</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white tracking-wider min-w-[200px]">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($presensiList as $i => $p)
                                <tr>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $presensiList->firstItem() + $i }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700 font-semibold">{{ $p->nis }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 font-medium whitespace-nowrap">{{ $p->nama_siswa }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <label class="inline-flex items-center justify-center group" :class="isEditing ? 'cursor-pointer' : 'cursor-not-allowed opacity-70'">
                                            <input type="radio" name="presensi[{{ $p->id }}][status]" value="hadir" {{ ($p->presensi_status ?? '') == 'hadir' ? 'checked' : '' }} class="hidden radio-hadir" :disabled="!isEditing">
                                            <div class="status-box w-10 h-10 flex items-center justify-center rounded-full border transition-colors {{ ($p->presensi_status ?? '') == 'hadir' ? 'bg-green-500 text-white border-green-500' : 'bg-gray-100 text-gray-400 border-gray-200' }}"><i class="fa-solid fa-check"></i></div>
                                        </label>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <label class="inline-flex items-center justify-center group" :class="isEditing ? 'cursor-pointer' : 'cursor-not-allowed opacity-70'">
                                            <input type="radio" name="presensi[{{ $p->id }}][status]" value="tidak_hadir" {{ ($p->presensi_status ?? '') == 'tidak_hadir' ? 'checked' : '' }} class="hidden" :disabled="!isEditing">
                                            <div class="status-box w-10 h-10 flex items-center justify-center rounded-full border transition-colors {{ ($p->presensi_status ?? '') == 'tidak_hadir' ? 'bg-red-500 text-white border-red-500' : 'bg-gray-100 text-gray-400 border-gray-200' }}"><i class="fa-solid fa-xmark"></i></div>
                                        </label>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <label class="inline-flex items-center justify-center group" :class="isEditing ? 'cursor-pointer' : 'cursor-not-allowed opacity-70'">
                                            <input type="radio" name="presensi[{{ $p->id }}][status]" value="izin" {{ ($p->presensi_status ?? '') == 'izin' ? 'checked' : '' }} class="hidden" :disabled="!isEditing">
                                            <div class="status-box w-10 h-10 flex items-center justify-center rounded-full border transition-colors {{ ($p->presensi_status ?? '') == 'izin' ? 'bg-blue-500 text-white border-blue-500' : 'bg-gray-100 text-gray-400 border-gray-200' }}"><i class="fa-solid fa-info"></i></div>
                                        </label>
                                    </td>
                                    <td class="px-6 py-4">
                                        <input type="text" name="presensi[{{ $p->id }}][ket]" value="{{ $p->presensi_keterangan ?? '' }}" :disabled="!isEditing" class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded focus:outline-none focus:border-gray-900 transition-colors" :class="!isEditing ? 'bg-gray-50 text-gray-500' : 'bg-white'" placeholder="Alasan...">
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="px-6 py-8 text-center text-gray-500">Pilih Mata Pelajaran dan Kelas untuk melihat siswa.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </form>
            <div class="p-6 bg-gray-50/30 border-t border-gray-100 flex flex-col md:flex-row justify-end items-center gap-4">
                <div class="w-full md:w-auto">
                    <x-pagination :paginator="$presensiList" />
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
function presensiApp() {
    return {
        isEditing: false,
        markAllHadir() {
            document.querySelectorAll('.radio-hadir').forEach(input => {
                input.checked = true;
                // Update UI visually
                const row = input.closest('tr');
                row.querySelectorAll('.status-box').forEach(box => {
                    box.classList.remove('bg-green-500', 'bg-red-500', 'bg-blue-500', 'text-white', 'border-green-500', 'border-red-500', 'border-blue-500');
                    box.classList.add('bg-gray-100', 'text-gray-400', 'border-gray-200');
                });
                const hadirBox = input.nextElementSibling;
                hadirBox.classList.remove('bg-gray-100', 'text-gray-400', 'border-gray-200');
                hadirBox.classList.add('bg-green-500', 'text-white', 'border-green-500');
            });
        }
    }
}

// Tambahkan listener untuk update UI saat radio diklik manual
document.addEventListener('change', (e) => {
    if (e.target.type === 'radio' && e.target.name.startsWith('presensi')) {
        const row = e.target.closest('tr');
        row.querySelectorAll('.status-box').forEach(box => {
            box.classList.remove('bg-green-500', 'bg-red-500', 'bg-blue-500', 'text-white', 'border-green-500', 'border-red-500', 'border-blue-500');
            box.classList.add('bg-gray-100', 'text-gray-400', 'border-gray-200');
        });
        
        const selectedBox = e.target.nextElementSibling;
        const value = e.target.value;
        const colorClass = value === 'hadir' ? 'green-500' : (value === 'tidak_hadir' ? 'red-500' : 'blue-500');
        
        selectedBox.classList.remove('bg-gray-100', 'text-gray-400', 'border-gray-200');
        selectedBox.classList.add('bg-' + colorClass, 'text-white', 'border-' + colorClass);
    }
});
</script>
@endpush