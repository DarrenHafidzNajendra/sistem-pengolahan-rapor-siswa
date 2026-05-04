@extends('layouts.app')
@section('title', 'Input Nilai')

@section('content')
    <div class="max-w-full" x-data="inputNilai()">
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="p-6 border-b border-gray-100 bg-gray-50/30">
                <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                    <div class="space-y-1">
                        <h2 class="text-xl font-bold text-gray-900">Input Capaian Belajar</h2>
                        <p class="text-sm text-gray-500">Kelola nilai pengetahuan, keterampilan, dan sikap siswa.</p>
                    </div>
                    <div class="flex flex-wrap items-center gap-3 w-full lg:w-auto">
                        <form action="{{ route('input_nilai') }}" method="GET" class="flex flex-wrap items-center gap-3">
                            <select name="mapel_id" class="px-4 py-2.5 text-sm font-semibold text-gray-700 border border-gray-300 rounded-lg bg-white focus:border-gray-900 outline-none transition-colors cursor-pointer">
                                @foreach($mapelList as $mapel)
                                    <option value="{{ $mapel->id }}" {{ ($selectedPengampu && $selectedPengampu->mapel_id == $mapel->id) || request('mapel_id') == $mapel->id ? 'selected' : '' }}>{{ $mapel->nama_mapel }}</option>
                                @endforeach
                            </select>
                            <select name="kelas_id" class="px-4 py-2.5 text-sm font-semibold text-gray-700 border border-gray-300 rounded-lg bg-white focus:border-gray-900 outline-none transition-colors cursor-pointer">
                                @foreach($kelasList as $kelas)
                                    <option value="{{ $kelas->id }}" {{ ($selectedPengampu && $selectedPengampu->kelas_id == $kelas->id) || request('kelas_id') == $kelas->id ? 'selected' : '' }}>{{ $kelas->nama_kelas }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="px-5 py-2.5 bg-gray-900 text-white text-sm font-bold rounded-lg hover:bg-gray-800 transition-colors flex items-center gap-2 whitespace-nowrap">
                                <i class="fa-solid fa-magnifying-glass text-xs"></i><span>Cari</span>
                            </button>
                        </form>
                        <button type="button" @click="toggleEdit()" :class="isEditing ? 'bg-gray-900' : 'bg-blue-600'" class="w-[140px] justify-center px-5 py-2.5 text-white text-sm font-bold rounded-lg transition-colors flex items-center gap-2">
                            <i class="fa-solid" :class="isEditing ? 'fa-floppy-disk' : 'fa-pen-to-square'"></i>
                            <span x-text="isEditing ? 'Simpan Data' : 'Edit Nilai'"></span>
                        </button>
                    </div>
                </div>
                <div class="flex items-center gap-1 mt-8 p-1 bg-gray-100 rounded-lg w-fit border border-gray-200">
                    <button @click="activeTab = 'pengetahuan'" :class="activeTab === 'pengetahuan' ? 'bg-white text-blue-600 border-gray-200' : 'text-gray-500 hover:text-gray-700 border-transparent'" class="px-6 py-2.5 text-xs font-bold rounded-lg transition-colors flex items-center gap-2 border">
                        <i class="fa-solid fa-book-open"></i> Pengetahuan
                    </button>
                    <button @click="activeTab = 'keterampilan'" :class="activeTab === 'keterampilan' ? 'bg-white text-blue-600 border-gray-200' : 'text-gray-500 hover:text-gray-700 border-transparent'" class="px-6 py-2.5 text-xs font-bold rounded-lg transition-colors flex items-center gap-2 border">
                        <i class="fa-solid fa-screwdriver-wrench"></i> Keterampilan
                    </button>
                    <button @click="activeTab = 'sikap'" :class="activeTab === 'sikap' ? 'bg-white text-blue-600 border-gray-200' : 'text-gray-500 hover:text-gray-700 border-transparent'" class="px-6 py-2.5 text-xs font-bold rounded-lg transition-colors flex items-center gap-2 border">
                        <i class="fa-solid fa-hands-praying"></i> Sikap & Spiritual
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead class="bg-gray-900 border-b border-gray-800">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Data Siswa</th>
                            <th x-show="activeTab === 'pengetahuan'" class="px-4 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">Tugas</th>
                            <th x-show="activeTab === 'pengetahuan'" class="px-4 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">UH</th>
                            <th x-show="activeTab === 'pengetahuan'" class="px-4 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">UTS</th>
                            <th x-show="activeTab === 'pengetahuan'" class="px-4 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">UAS</th>
                            <th x-show="activeTab === 'keterampilan'" class="px-4 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">Praktik</th>
                            <th x-show="activeTab === 'keterampilan'" class="px-4 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">Proyek</th>
                            <th x-show="activeTab === 'keterampilan'" class="px-4 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">Portofolio</th>
                            <th x-show="activeTab === 'sikap'" class="px-4 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">Spiritual</th>
                            <th x-show="activeTab === 'sikap'" class="px-4 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">Sosial</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">Nilai Akhir</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">Predikat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <template x-for="(siswa, index) in siswaList" :key="siswa.id">
                            <tr class="hover:bg-blue-50/40 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-gray-900" x-text="siswa.nama"></span>
                                        <span class="text-[11px] text-gray-400 font-medium" x-text="siswa.nis"></span>
                                    </div>
                                </td>
                                <td x-show="activeTab === 'pengetahuan'" class="px-4 py-4 text-center"><input type="number" x-model.number="siswa.p_tugas" @input="updateAll(siswa)" :disabled="!isEditing" class="w-16 px-2 py-2 text-sm text-center border border-gray-200 rounded-lg focus:border-gray-900 outline-none transition-colors" :class="!isEditing ? 'bg-gray-50 border-transparent text-gray-500' : 'bg-white'"></td>
                                <td x-show="activeTab === 'pengetahuan'" class="px-4 py-4 text-center"><input type="number" x-model.number="siswa.p_uh" @input="updateAll(siswa)" :disabled="!isEditing" class="w-16 px-2 py-2 text-sm text-center border border-gray-200 rounded-lg focus:border-gray-900 outline-none transition-colors" :class="!isEditing ? 'bg-gray-50 border-transparent text-gray-500' : 'bg-white'"></td>
                                <td x-show="activeTab === 'pengetahuan'" class="px-4 py-4 text-center"><input type="number" x-model.number="siswa.p_uts" @input="updateAll(siswa)" :disabled="!isEditing" class="w-16 px-2 py-2 text-sm text-center border border-gray-200 rounded-lg focus:border-gray-900 outline-none transition-colors" :class="!isEditing ? 'bg-gray-50 border-transparent text-gray-500' : 'bg-white'"></td>
                                <td x-show="activeTab === 'pengetahuan'" class="px-4 py-4 text-center"><input type="number" x-model.number="siswa.p_uas" @input="updateAll(siswa)" :disabled="!isEditing" class="w-16 px-2 py-2 text-sm text-center border border-gray-200 rounded-lg focus:border-gray-900 outline-none transition-colors" :class="!isEditing ? 'bg-gray-50 border-transparent text-gray-500' : 'bg-white'"></td>
                                <td x-show="activeTab === 'keterampilan'" class="px-4 py-4 text-center"><input type="number" x-model.number="siswa.k_praktik" @input="updateAll(siswa)" :disabled="!isEditing" class="w-16 px-2 py-2 text-sm text-center border border-gray-200 rounded-lg focus:border-gray-900 outline-none transition-colors" :class="!isEditing ? 'bg-gray-50 border-transparent text-gray-500' : 'bg-white'"></td>
                                <td x-show="activeTab === 'keterampilan'" class="px-4 py-4 text-center"><input type="number" x-model.number="siswa.k_proyek" @input="updateAll(siswa)" :disabled="!isEditing" class="w-16 px-2 py-2 text-sm text-center border border-gray-200 rounded-lg focus:border-gray-900 outline-none transition-colors" :class="!isEditing ? 'bg-gray-50 border-transparent text-gray-500' : 'bg-white'"></td>
                                <td x-show="activeTab === 'keterampilan'" class="px-4 py-4 text-center"><input type="number" x-model.number="siswa.k_portofolio" @input="updateAll(siswa)" :disabled="!isEditing" class="w-16 px-2 py-2 text-sm text-center border border-gray-200 rounded-lg focus:border-gray-900 outline-none transition-colors" :class="!isEditing ? 'bg-gray-50 border-transparent text-gray-500' : 'bg-white'"></td>
                                <td x-show="activeTab === 'sikap'" class="px-4 py-4 text-center">
                                    <select x-model="siswa.s_spiritual" :disabled="!isEditing" class="px-3 py-2 text-xs font-bold rounded-lg border border-gray-200 outline-none focus:border-gray-900 transition-colors cursor-pointer" :class="!isEditing ? 'bg-gray-50 border-transparent text-gray-500' : 'bg-white'">
                                        <option value="A">Sangat Baik (A)</option><option value="B">Baik (B)</option><option value="C">Cukup (C)</option><option value="D">Kurang (D)</option>
                                    </select>
                                </td>
                                <td x-show="activeTab === 'sikap'" class="px-4 py-4 text-center">
                                    <select x-model="siswa.s_sosial" :disabled="!isEditing" class="px-3 py-2 text-xs font-bold rounded-lg border border-gray-200 outline-none focus:border-gray-900 transition-colors cursor-pointer" :class="!isEditing ? 'bg-gray-50 border-transparent text-gray-500' : 'bg-white'">
                                        <option value="A">Sangat Baik (A)</option><option value="B">Baik (B)</option><option value="C">Cukup (C)</option><option value="D">Kurang (D)</option>
                                    </select>
                                </td>
                                <td class="px-6 py-4 text-center"><span class="text-sm font-black text-gray-900" x-text="getDisplayAvg(siswa)"></span></td>
                                <td class="px-6 py-4 text-center">
                                    <div class="inline-block px-3 py-1.5 text-[10px] font-black rounded-lg" :class="getPredikatClass(siswa)" x-text="getDisplayPredikat(siswa)"></div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
            <div class="p-6 bg-gray-50/30 border-t border-gray-100">
                <p class="text-[11px] text-gray-400 font-medium italic">
                    <i class="fa-solid fa-circle-info mr-1"></i> Nilai dihitung otomatis berdasarkan bobot standar pendidikan.
                </p>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
function inputNilai() {
    return {
        activeTab: 'pengetahuan',
        isEditing: false,
        siswaList: @json($siswaJsonData),

        toggleEdit() {
            this.isEditing = !this.isEditing;
            if(!this.isEditing) {
                window.dispatchEvent(new CustomEvent('notify', {
                    detail: { message: 'Data nilai siswa berhasil diperbarui dan disimpan.', type: 'success' }
                }));
            }
        },
        updateAll(siswa) {
            const p = ((siswa.p_tugas||0) + (siswa.p_uh||0) + (siswa.p_uts||0) + (siswa.p_uas||0)) / 4;
            siswa.p_avg = p > 0 ? Math.round(p * 10) / 10 : null;
            siswa.p_pred = this.calcPredikat(p);
            const k = ((siswa.k_praktik||0) + (siswa.k_proyek||0) + (siswa.k_portofolio||0)) / 3;
            siswa.k_avg = k > 0 ? Math.round(k * 10) / 10 : null;
            siswa.k_pred = this.calcPredikat(k);
        },
        calcPredikat(n) { if(n >= 90) return 'A'; if(n >= 80) return 'B'; if(n >= 70) return 'C'; if(n > 0) return 'D'; return ''; },
        getDisplayAvg(siswa) { if(this.activeTab === 'pengetahuan') return siswa.p_avg || '-'; if(this.activeTab === 'keterampilan') return siswa.k_avg || '-'; return '-'; },
        getDisplayPredikat(siswa) { if(this.activeTab === 'pengetahuan') return siswa.p_pred || '-'; if(this.activeTab === 'keterampilan') return siswa.k_pred || '-'; if(this.activeTab === 'sikap') return siswa.s_spiritual; return '-'; },
        getPredikatClass(siswa) {
            const p = this.getDisplayPredikat(siswa);
            if(p === 'A') return 'bg-green-100 text-green-700'; if(p === 'B') return 'bg-blue-100 text-blue-700';
            if(p === 'C') return 'bg-yellow-100 text-yellow-700'; if(p === 'D') return 'bg-red-100 text-red-700';
            return 'bg-gray-100 text-gray-400';
        }
    }
}
</script>
@endpush