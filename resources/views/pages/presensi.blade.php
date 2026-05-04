@extends('layouts.app')
@section('title', 'Data Presensi Kelas')

@section('content')
    <div class="max-w-full">
        <div x-data="presensiApp()" class="bg-white rounded-lg border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                    <form action="{{ route('presensi') }}" method="GET" class="flex flex-wrap items-center gap-3 w-full md:w-auto">
                        <select name="mapel_id" class="appearance-none w-40 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-200 rounded-lg focus:outline-none focus:border-gray-900 cursor-pointer">
                            @foreach($mapelList as $m)
                                <option value="{{ $m->id }}" {{ ($selectedPengampu && $selectedPengampu->mapel_id == $m->id) || request('mapel_id') == $m->id ? 'selected' : '' }}>{{ $m->nama_mapel }}</option>
                            @endforeach
                        </select>
                        <select name="kelas_id" class="appearance-none w-32 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-200 rounded-lg focus:outline-none focus:border-gray-900 cursor-pointer">
                            @foreach($kelasList as $k)
                                <option value="{{ $k->id }}" {{ ($selectedPengampu && $selectedPengampu->kelas_id == $k->id) || request('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                        <input type="date" name="tanggal" x-model="tanggal" class="w-40 px-3 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-200 rounded-lg focus:outline-none focus:border-gray-900 cursor-pointer">
                        <button type="submit" class="px-4 py-2 bg-gray-900 text-white text-sm font-semibold rounded-lg hover:bg-gray-800 transition-colors flex items-center gap-2 whitespace-nowrap">
                            <i class="fa-solid fa-magnifying-glass text-xs"></i><span>Cari</span>
                        </button>
                    </form>
                    <div class="flex items-center gap-2 w-full md:w-auto">
                        <button @click="markAllHadir()" class="px-4 py-2 bg-blue-50 text-blue-700 text-sm font-semibold rounded-lg hover:bg-blue-100 border border-blue-200 transition-colors flex items-center gap-2 whitespace-nowrap">
                            <i class="fa-solid fa-check-double"></i><span>Hadir Semua</span>
                        </button>
                        <button class="px-4 py-2 bg-gray-700 text-white text-sm font-semibold rounded-lg hover:bg-gray-800 transition-colors flex items-center gap-2 whitespace-nowrap">
                            <i class="fa-solid fa-floppy-disk text-lg"></i><span>Simpan Presensi</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="px-6 py-4 bg-gray-50/50 border-b border-gray-200">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-base font-bold text-gray-900">Form Input Presensi Siswa</h2>
                        <div class="flex flex-wrap items-center gap-x-6 gap-y-2 mt-2 text-sm">
                            <div class="flex items-center gap-2 text-gray-600"><i class="fa-solid fa-book text-blue-600 opacity-80"></i><span>Mata Pelajaran: <strong class="text-gray-900">{{ $selectedPengampu?->mapel?->nama_mapel ?? '-' }}</strong></span></div>
                            <div class="flex items-center gap-2 text-gray-600"><i class="fa-solid fa-users text-blue-600 opacity-80"></i><span>Kelas: <strong class="text-gray-900">{{ $selectedPengampu?->kelas?->nama_kelas ?? '-' }}</strong></span></div>
                            <div class="flex items-center gap-2 text-gray-600"><i class="fa-regular fa-calendar-days text-blue-600 opacity-80"></i><span>Tanggal: <strong class="text-gray-900" x-text="formatTanggal()"></strong></span></div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="px-4 py-2 bg-green-50 border border-green-100 rounded-lg text-center min-w-[80px]">
                            <div class="text-[10px] font-bold text-green-600 uppercase tracking-wider">Hadir</div>
                            <div class="text-lg font-black text-green-700" x-text="stats.hadir"></div>
                        </div>
                        <div class="px-4 py-2 bg-red-50 border border-red-100 rounded-lg text-center min-w-[80px]">
                            <div class="text-[10px] font-bold text-red-600 uppercase tracking-wider">Absen</div>
                            <div class="text-lg font-black text-red-700" x-text="stats.tidakHadir"></div>
                        </div>
                        <div class="px-4 py-2 bg-blue-50 border border-blue-100 rounded-lg text-center min-w-[80px]">
                            <div class="text-[10px] font-bold text-blue-600 uppercase tracking-wider">Izin</div>
                            <div class="text-lg font-black text-blue-700" x-text="stats.izin"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-900">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">NO</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">NIS</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider min-w-[200px]">Nama Siswa</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-white uppercase tracking-wider">Hadir</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-white uppercase tracking-wider">Tidak Hadir</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-white uppercase tracking-wider">Izin</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider min-w-[200px]">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <template x-for="(p, index) in presensiList" :key="p.nis">
                            <tr class="hover:bg-blue-50 transition-colors duration-150 border-l-4 border-transparent hover:border-blue-500" :class="index % 2 !== 0 ? 'bg-gray-50' : 'bg-white'">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900" x-text="index + 1"></td>
                                <td class="px-6 py-4 text-sm text-gray-700 font-semibold" x-text="p.nis"></td>
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium whitespace-nowrap" x-text="p.nama"></td>
                                <td class="px-6 py-4 text-center">
                                    <label class="inline-flex items-center justify-center cursor-pointer group">
                                        <input type="radio" :name="'status_'+p.nis" value="hadir" x-model="p.status" class="hidden">
                                        <div :class="p.status === 'hadir' ? 'bg-green-500 text-white border-green-500' : 'bg-gray-100 text-gray-400 border-gray-200'" class="w-10 h-10 flex items-center justify-center rounded-full border transition-colors"><i class="fa-solid fa-check"></i></div>
                                    </label>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <label class="inline-flex items-center justify-center cursor-pointer group">
                                        <input type="radio" :name="'status_'+p.nis" value="tidak_hadir" x-model="p.status" class="hidden">
                                        <div :class="p.status === 'tidak_hadir' ? 'bg-red-500 text-white border-red-500' : 'bg-gray-100 text-gray-400 border-gray-200'" class="w-10 h-10 flex items-center justify-center rounded-full border transition-colors"><i class="fa-solid fa-xmark"></i></div>
                                    </label>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <label class="inline-flex items-center justify-center cursor-pointer group">
                                        <input type="radio" :name="'status_'+p.nis" value="izin" x-model="p.status" class="hidden">
                                        <div :class="p.status === 'izin' ? 'bg-blue-500 text-white border-blue-500' : 'bg-gray-100 text-gray-400 border-gray-200'" class="w-10 h-10 flex items-center justify-center rounded-full border transition-colors"><i class="fa-solid fa-info"></i></div>
                                    </label>
                                </td>
                                <td class="px-6 py-4">
                                    <input type="text" x-model="p.ket" class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:border-gray-900 bg-white transition-colors" :placeholder="p.status !== 'hadir' ? 'Alasan...' : ''">
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
function presensiApp() {
    return {
        tanggal: @json($tanggal),
        presensiList: @json($presensiJsonData),
        formatTanggal() {
            if (!this.tanggal) return '-';
            return new Date(this.tanggal).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
        },
        get stats() {
            return {
                hadir: this.presensiList.filter(s => s.status === 'hadir').length,
                tidakHadir: this.presensiList.filter(s => s.status === 'tidak_hadir').length,
                izin: this.presensiList.filter(s => s.status === 'izin' || s.status === 'sakit').length
            }
        },
        markAllHadir() { this.presensiList.forEach(s => s.status = 'hadir'); }
    }
}
</script>
@endpush