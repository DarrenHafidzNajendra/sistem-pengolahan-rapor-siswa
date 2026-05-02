@extends('layouts.app')
@section('title', 'Input Nilai')

@section('content')
    <div class="max-w-full" x-data="inputNilai()">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            {{-- Toolbar & Header --}}
            <div class="p-6 border-b border-gray-100 bg-gray-50/30">
                <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                    <div class="space-y-1">
                        <h2 class="text-xl font-bold text-gray-900">Input Capaian Belajar</h2>
                        <p class="text-sm text-gray-500">Kelola nilai pengetahuan, keterampilan, dan sikap siswa.</p>
                    </div>
                    
                    <div class="flex flex-wrap items-center gap-3 w-full lg:w-auto">
                        <select class="px-4 py-2.5 text-sm font-semibold text-gray-700 border border-gray-300 rounded-xl bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all cursor-pointer">
                            <option>Matematika</option>
                            <option>Bahasa Indonesia</option>
                        </select>
                        <select class="px-4 py-2.5 text-sm font-semibold text-gray-700 border border-gray-300 rounded-xl bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all cursor-pointer">
                            <option>X-IPA-1</option>
                            <option>X-IPA-2</option>
                        </select>
                        <button @click="toggleEdit()" :class="isEditing ? 'bg-gray-900' : 'bg-blue-600'" class="px-5 py-2.5 text-white text-sm font-bold rounded-xl transition-all flex items-center gap-2 shadow-sm hover:shadow-md active:scale-95">
                            <i class="fa-solid" :class="isEditing ? 'fa-floppy-disk' : 'fa-pen-to-square'"></i>
                            <span x-text="isEditing ? 'Simpan Data' : 'Edit Nilai'"></span>
                        </button>
                    </div>
                </div>

                {{-- Tabs Selection --}}
                <div class="flex items-center gap-1 mt-8 p-1 bg-gray-100 rounded-xl w-fit border border-gray-200">
                    <button @click="activeTab = 'pengetahuan'" :class="activeTab === 'pengetahuan' ? 'bg-white text-blue-600 shadow-sm border-gray-200' : 'text-gray-500 hover:text-gray-700 border-transparent'" class="px-6 py-2.5 text-xs font-bold rounded-lg transition-all flex items-center gap-2 border">
                        <i class="fa-solid fa-book-open"></i> Pengetahuan
                    </button>
                    <button @click="activeTab = 'keterampilan'" :class="activeTab === 'keterampilan' ? 'bg-white text-blue-600 shadow-sm border-gray-200' : 'text-gray-500 hover:text-gray-700 border-transparent'" class="px-6 py-2.5 text-xs font-bold rounded-lg transition-all flex items-center gap-2 border">
                        <i class="fa-solid fa-screwdriver-wrench"></i> Keterampilan
                    </button>
                    <button @click="activeTab = 'sikap'" :class="activeTab === 'sikap' ? 'bg-white text-blue-600 shadow-sm border-gray-200' : 'text-gray-500 hover:text-gray-700 border-transparent'" class="px-6 py-2.5 text-xs font-bold rounded-lg transition-all flex items-center gap-2 border">
                        <i class="fa-solid fa-hands-praying"></i> Sikap & Spiritual
                    </button>
                </div>
            </div>

            {{-- Table Content --}}
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

                                <td x-show="activeTab === 'pengetahuan'" class="px-4 py-4 text-center"><input type="number" x-model.number="siswa.p_tugas" @input="updateAll(siswa)" :disabled="!isEditing" class="w-16 px-2 py-2 text-sm text-center border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all" :class="!isEditing ? 'bg-gray-50 border-transparent text-gray-500' : 'bg-white shadow-sm'"></td>
                                <td x-show="activeTab === 'pengetahuan'" class="px-4 py-4 text-center"><input type="number" x-model.number="siswa.p_uh" @input="updateAll(siswa)" :disabled="!isEditing" class="w-16 px-2 py-2 text-sm text-center border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all" :class="!isEditing ? 'bg-gray-50 border-transparent text-gray-500' : 'bg-white shadow-sm'"></td>
                                <td x-show="activeTab === 'pengetahuan'" class="px-4 py-4 text-center"><input type="number" x-model.number="siswa.p_uts" @input="updateAll(siswa)" :disabled="!isEditing" class="w-16 px-2 py-2 text-sm text-center border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all" :class="!isEditing ? 'bg-gray-50 border-transparent text-gray-500' : 'bg-white shadow-sm'"></td>
                                <td x-show="activeTab === 'pengetahuan'" class="px-4 py-4 text-center"><input type="number" x-model.number="siswa.p_uas" @input="updateAll(siswa)" :disabled="!isEditing" class="w-16 px-2 py-2 text-sm text-center border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all" :class="!isEditing ? 'bg-gray-50 border-transparent text-gray-500' : 'bg-white shadow-sm'"></td>

                                <td x-show="activeTab === 'keterampilan'" class="px-4 py-4 text-center"><input type="number" x-model.number="siswa.k_praktik" @input="updateAll(siswa)" :disabled="!isEditing" class="w-16 px-2 py-2 text-sm text-center border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all" :class="!isEditing ? 'bg-gray-50 border-transparent text-gray-500' : 'bg-white shadow-sm'"></td>
                                <td x-show="activeTab === 'keterampilan'" class="px-4 py-4 text-center"><input type="number" x-model.number="siswa.k_proyek" @input="updateAll(siswa)" :disabled="!isEditing" class="w-16 px-2 py-2 text-sm text-center border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all" :class="!isEditing ? 'bg-gray-50 border-transparent text-gray-500' : 'bg-white shadow-sm'"></td>
                                <td x-show="activeTab === 'keterampilan'" class="px-4 py-4 text-center"><input type="number" x-model.number="siswa.k_portofolio" @input="updateAll(siswa)" :disabled="!isEditing" class="w-16 px-2 py-2 text-sm text-center border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all" :class="!isEditing ? 'bg-gray-50 border-transparent text-gray-500' : 'bg-white shadow-sm'"></td>

                                <td x-show="activeTab === 'sikap'" class="px-4 py-4 text-center">
                                    <select x-model="siswa.s_spiritual" :disabled="!isEditing" class="px-3 py-2 text-xs font-bold rounded-lg border border-gray-200 outline-none focus:ring-2 focus:ring-blue-500/20 transition-all cursor-pointer" :class="!isEditing ? 'bg-gray-50 border-transparent text-gray-500' : 'bg-white shadow-sm'">
                                        <option value="A">Sangat Baik (A)</option><option value="B">Baik (B)</option><option value="C">Cukup (C)</option><option value="D">Kurang (D)</option>
                                    </select>
                                </td>
                                <td x-show="activeTab === 'sikap'" class="px-4 py-4 text-center">
                                    <select x-model="siswa.s_sosial" :disabled="!isEditing" class="px-3 py-2 text-xs font-bold rounded-lg border border-gray-200 outline-none focus:ring-2 focus:ring-blue-500/20 transition-all cursor-pointer" :class="!isEditing ? 'bg-gray-50 border-transparent text-gray-500' : 'bg-white shadow-sm'">
                                        <option value="A">Sangat Baik (A)</option><option value="B">Baik (B)</option><option value="C">Cukup (C)</option><option value="D">Kurang (D)</option>
                                    </select>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <span class="text-sm font-black text-gray-900" x-text="getDisplayAvg(siswa)"></span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="inline-block px-3 py-1.5 text-[10px] font-black rounded-lg shadow-sm" 
                                         :class="getPredikatClass(siswa)"
                                         x-text="getDisplayPredikat(siswa)"></div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
            
            <div class="p-6 bg-gray-50/30 border-t border-gray-100">
                <div class="flex items-center justify-between">
                    <p class="text-[11px] text-gray-400 font-medium italic">
                        <i class="fa-solid fa-circle-info mr-1"></i> Nilai dihitung otomatis berdasarkan bobot standar pendidikan.
                    </p>
                    <x-pagination :from="1" :to="5" :total="5" :lastPage="1" />
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
function inputNilai() {
    return {
        activeTab: 'pengetahuan',
        isEditing: true,
        siswaList: [
            { id: 1, nis: '1809599001', nama: 'Budi Santoso', p_tugas: 85, p_uh: 80, p_uts: 75, p_uas: 88, p_avg: 82, p_pred: 'B', k_praktik: 90, k_proyek: 85, k_portofolio: 88, k_avg: 87.7, k_pred: 'B', s_spiritual: 'A', s_sosial: 'B' },
            { id: 2, nis: '1809599002', nama: 'Siti Nurhaliza', p_tugas: 92, p_uh: 90, p_uts: 95, p_uas: 92, p_avg: 92.3, p_pred: 'A', k_praktik: 95, k_proyek: 94, k_portofolio: 92, k_avg: 93.7, k_pred: 'A', s_spiritual: 'A', s_sosial: 'A' },
            { id: 3, nis: '1809599003', nama: 'Ahmad Wijaya', p_tugas: 70, p_uh: 65, p_uts: 60, p_uas: 72, p_avg: 66.8, p_pred: 'D', k_praktik: 75, k_proyek: 70, k_portofolio: 72, k_avg: 72.3, k_pred: 'C', s_spiritual: 'B', s_sosial: 'B' },
            { id: 4, nis: '1809599004', nama: 'Ratna Kusuma', p_tugas: 88, p_uh: 85, p_uts: 80, p_uas: 82, p_avg: 83.8, p_pred: 'B', k_praktik: 85, k_proyek: 88, k_portofolio: 84, k_avg: 85.7, k_pred: 'B', s_spiritual: 'A', s_sosial: 'A' },
            { id: 5, nis: '1809599005', nama: 'Eka Prasetyo', p_tugas: 75, p_uh: 78, p_uts: 82, p_uas: 70, p_avg: 76.3, p_pred: 'C', k_praktik: 80, k_proyek: 75, k_portofolio: 78, k_avg: 77.7, k_pred: 'C', s_spiritual: 'B', s_sosial: 'B' },
        ],

        toggleEdit() {
            this.isEditing = !this.isEditing;
            if(!this.isEditing) {
                window.dispatchEvent(new CustomEvent('notify', { 
                    detail: { message: 'Data nilai siswa berhasil diperbarui dan disimpan.', type: 'success' } 
                }));
            }
        },

        updateAll(siswa) {
            const p = ( (siswa.p_tugas||0) + (siswa.p_uh||0) + (siswa.p_uts||0) + (siswa.p_uas||0) ) / 4;
            siswa.p_avg = p > 0 ? Math.round(p * 10) / 10 : null;
            siswa.p_pred = this.calcPredikat(p);

            const k = ( (siswa.k_praktik||0) + (siswa.k_proyek||0) + (siswa.k_portofolio||0) ) / 3;
            siswa.k_avg = k > 0 ? Math.round(k * 10) / 10 : null;
            siswa.k_pred = this.calcPredikat(k);
        },

        calcPredikat(n) {
            if(n >= 90) return 'A';
            if(n >= 80) return 'B';
            if(n >= 70) return 'C';
            if(n > 0) return 'D';
            return '';
        },

        getDisplayAvg(siswa) {
            if(this.activeTab === 'pengetahuan') return siswa.p_avg || '-';
            if(this.activeTab === 'keterampilan') return siswa.k_avg || '-';
            return '-';
        },

        getDisplayPredikat(siswa) {
            if(this.activeTab === 'pengetahuan') return siswa.p_pred || '-';
            if(this.activeTab === 'keterampilan') return siswa.k_pred || '-';
            if(this.activeTab === 'sikap') return siswa.s_spiritual;
            return '-';
        },

        getPredikatClass(siswa) {
            const p = this.getDisplayPredikat(siswa);
            if(p === 'A') return 'bg-green-100 text-green-700 ring-1 ring-green-200';
            if(p === 'B') return 'bg-blue-100 text-blue-700 ring-1 ring-blue-200';
            if(p === 'C') return 'bg-yellow-100 text-yellow-700 ring-1 ring-yellow-200';
            if(p === 'D') return 'bg-red-100 text-red-700 ring-1 ring-red-200';
            return 'bg-gray-100 text-gray-400';
        }
    }
}
</script>
@endpush