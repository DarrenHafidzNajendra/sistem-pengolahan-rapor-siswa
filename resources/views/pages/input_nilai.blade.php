@extends('layouts.app')
@section('title', 'Input Nilai')

@section('content')
    <div class="max-w-full" x-data="inputNilai()">
        <!-- Header Section - Flat & Clean -->
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Input Capaian Belajar</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola nilai akademik siswa untuk mata pelajaran dan kelas yang diampu.</p>
        </div>

        <div class="bg-white rounded border border-gray-200 overflow-hidden shadow-sm">
            <!-- Form Filter (GET) -->
            <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                    <form action="{{ route('input_nilai') }}" method="GET" class="flex flex-wrap items-center gap-3">
                        <input type="hidden" name="tab" :value="activeTab">
                        <select name="mapel_id" class="px-4 py-2 text-sm font-semibold text-gray-700 border border-gray-300 rounded bg-white focus:border-gray-900 outline-none transition-colors cursor-pointer">
                            @foreach($mapelList as $mapel)
                                <option value="{{ $mapel->id }}" {{ ($selectedPengampu && $selectedPengampu->mapel_id == $mapel->id) || request('mapel_id') == $mapel->id ? 'selected' : '' }}>{{ $mapel->nama_mapel }}</option>
                            @endforeach
                        </select>
                        <select name="kelas_id" class="px-4 py-2 text-sm font-semibold text-gray-700 border border-gray-300 rounded bg-white focus:border-gray-900 outline-none transition-colors cursor-pointer">
                            @foreach($kelasList as $kelas)
                                <option value="{{ $kelas->id }}" {{ ($selectedPengampu && $selectedPengampu->kelas_id == $kelas->id) || request('kelas_id') == $kelas->id ? 'selected' : '' }}>{{ $kelas->nama_kelas }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="px-5 py-2 bg-gray-900 text-white text-sm font-semibold rounded hover:bg-gray-800 transition-colors flex items-center gap-2">
                            <i class="fa-solid fa-magnifying-glass text-xs"></i><span>Tampilkan</span>
                        </button>
                    </form>

                    <div class="flex items-center gap-3 w-full lg:w-auto">
                        <button type="button" 
                                @click="isEditing = !isEditing"
                                :class="isEditing ? 'bg-amber-600' : 'bg-blue-600'" 
                                class="px-5 py-2 text-white text-sm font-semibold rounded transition-colors flex items-center gap-2">
                            <i class="fa-solid" :class="isEditing ? 'fa-xmark' : 'fa-pen-to-square'"></i>
                            <span x-text="isEditing ? 'Batal Edit' : 'Edit Nilai'"></span>
                        </button>
                        
                        <button type="submit" form="formSimpanNilai" x-show="isEditing"
                                class="px-5 py-2 bg-gray-900 text-white text-sm font-semibold rounded transition-colors flex items-center gap-2">
                            <i class="fa-solid fa-floppy-disk"></i>
                            <span>Simpan Perubahan</span>
                        </button>
                    </div>
                </div>

                <!-- Tabs Selector -->
                <div class="flex items-center gap-1 mt-6 p-1 bg-gray-100 rounded w-fit border border-gray-200">
                    <button type="button" @click="activeTab = 'pengetahuan'" :class="activeTab === 'pengetahuan' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700'" class="px-5 py-2 text-xs font-semibold rounded transition-all">Pengetahuan</button>
                    <button type="button" @click="activeTab = 'keterampilan'" :class="activeTab === 'keterampilan' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700'" class="px-5 py-2 text-xs font-semibold rounded transition-all">Keterampilan</button>
                    <button type="button" @click="activeTab = 'sikap'" :class="activeTab === 'sikap' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700'" class="px-5 py-2 text-xs font-semibold rounded transition-all">Sikap & Karakter</button>
                    <button type="button" @click="activeTab = 'catatan'" :class="activeTab === 'catatan' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700'" class="px-5 py-2 text-xs font-semibold rounded transition-all">Catatan Guru</button>
                </div>
            </div>

            <!-- Form Simpan (POST) -->
            <form action="{{ route('input_nilai.store') }}" method="POST" id="formSimpanNilai">
                @csrf
                <input type="hidden" name="pengampu_id" value="{{ $selectedPengampu?->id }}">
                <input type="hidden" name="active_tab" :value="activeTab">

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead class="bg-gray-900">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white tracking-tight">Nama Siswa</th>
                                <th x-show="activeTab === 'pengetahuan'" class="px-4 py-4 text-center text-xs font-bold text-white tracking-tight">Tugas</th>
                                <th x-show="activeTab === 'pengetahuan'" class="px-4 py-4 text-center text-xs font-bold text-white tracking-tight">UH</th>
                                <th x-show="activeTab === 'pengetahuan'" class="px-4 py-4 text-center text-xs font-bold text-white tracking-tight">UTS</th>
                                <th x-show="activeTab === 'pengetahuan'" class="px-4 py-4 text-center text-xs font-bold text-white tracking-tight">UAS</th>
                                <th x-show="activeTab === 'keterampilan'" class="px-4 py-4 text-center text-xs font-bold text-white tracking-tight">Praktik</th>
                                <th x-show="activeTab === 'keterampilan'" class="px-4 py-4 text-center text-xs font-bold text-white tracking-tight">Proyek</th>
                                <th x-show="activeTab === 'keterampilan'" class="px-4 py-4 text-center text-xs font-bold text-white tracking-tight">Portofolio</th>
                                <th x-show="activeTab === 'sikap'" class="px-4 py-4 text-center text-xs font-bold text-white tracking-tight">Spiritual</th>
                                <th x-show="activeTab === 'sikap'" class="px-4 py-4 text-center text-xs font-bold text-white tracking-tight">Sosial</th>
                                <th x-show="activeTab === 'catatan'" class="px-6 py-4 text-left text-xs font-bold text-white tracking-tight">Catatan Capaian</th>
                                <th x-show="activeTab !== 'catatan'" class="px-6 py-4 text-center text-xs font-bold text-white tracking-tight">Nilai Akhir</th>
                                <th x-show="activeTab !== 'catatan'" class="px-6 py-4 text-center text-xs font-bold text-white tracking-tight">Predikat</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($siswaJsonData as $index => $siswa)
                                <tr class="">
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold text-gray-900">{{ $siswa['nama'] }}</span>
                                            <span class="text-[11px] text-gray-400 font-medium">{{ $siswa['nis'] }}</span>
                                        </div>
                                    </td>
                                    <td x-show="activeTab === 'pengetahuan'" class="px-4 py-4 text-center">
                                        <input type="number" name="nilai[{{ $siswa['id'] }}][p_tugas]" x-model.number="siswaList[{{ $index }}].p_tugas" @input="updateAll(siswaList[{{ $index }}])" :disabled="!isEditing" class="w-16 px-2 py-2 text-sm text-center border border-gray-200 rounded-lg focus:border-gray-900 outline-none transition-colors" :class="!isEditing ? 'bg-gray-50 border-transparent text-gray-500' : 'bg-white'">
                                    </td>
                                    <td x-show="activeTab === 'pengetahuan'" class="px-4 py-4 text-center">
                                        <input type="number" name="nilai[{{ $siswa['id'] }}][p_uh]" x-model.number="siswaList[{{ $index }}].p_uh" @input="updateAll(siswaList[{{ $index }}])" :disabled="!isEditing" class="w-16 px-2 py-2 text-sm text-center border border-gray-200 rounded-lg focus:border-gray-900 outline-none transition-colors" :class="!isEditing ? 'bg-gray-50 border-transparent text-gray-500' : 'bg-white'">
                                    </td>
                                    <td x-show="activeTab === 'pengetahuan'" class="px-4 py-4 text-center">
                                        <input type="number" name="nilai[{{ $siswa['id'] }}][p_uts]" x-model.number="siswaList[{{ $index }}].p_uts" @input="updateAll(siswaList[{{ $index }}])" :disabled="!isEditing" class="w-16 px-2 py-2 text-sm text-center border border-gray-200 rounded-lg focus:border-gray-900 outline-none transition-colors" :class="!isEditing ? 'bg-gray-50 border-transparent text-gray-500' : 'bg-white'">
                                    </td>
                                    <td x-show="activeTab === 'pengetahuan'" class="px-4 py-4 text-center">
                                        <input type="number" name="nilai[{{ $siswa['id'] }}][p_uas]" x-model.number="siswaList[{{ $index }}].p_uas" @input="updateAll(siswaList[{{ $index }}])" :disabled="!isEditing" class="w-16 px-2 py-2 text-sm text-center border border-gray-200 rounded-lg focus:border-gray-900 outline-none transition-colors" :class="!isEditing ? 'bg-gray-50 border-transparent text-gray-500' : 'bg-white'">
                                    </td>
                                    <td x-show="activeTab === 'keterampilan'" class="px-4 py-4 text-center">
                                        <input type="number" name="nilai[{{ $siswa['id'] }}][k_praktik]" x-model.number="siswaList[{{ $index }}].k_praktik" @input="updateAll(siswaList[{{ $index }}])" :disabled="!isEditing" class="w-16 px-2 py-2 text-sm text-center border border-gray-200 rounded-lg focus:border-gray-900 outline-none transition-colors" :class="!isEditing ? 'bg-gray-50 border-transparent text-gray-500' : 'bg-white'">
                                    </td>
                                    <td x-show="activeTab === 'keterampilan'" class="px-4 py-4 text-center">
                                        <input type="number" name="nilai[{{ $siswa['id'] }}][k_proyek]" x-model.number="siswaList[{{ $index }}].k_proyek" @input="updateAll(siswaList[{{ $index }}])" :disabled="!isEditing" class="w-16 px-2 py-2 text-sm text-center border border-gray-200 rounded-lg focus:border-gray-900 outline-none transition-colors" :class="!isEditing ? 'bg-gray-50 border-transparent text-gray-500' : 'bg-white'">
                                    </td>
                                    <td x-show="activeTab === 'keterampilan'" class="px-4 py-4 text-center">
                                        <input type="number" name="nilai[{{ $siswa['id'] }}][k_portofolio]" x-model.number="siswaList[{{ $index }}].k_portofolio" @input="updateAll(siswaList[{{ $index }}])" :disabled="!isEditing" class="w-16 px-2 py-2 text-sm text-center border border-gray-200 rounded-lg focus:border-gray-900 outline-none transition-colors" :class="!isEditing ? 'bg-gray-50 border-transparent text-gray-500' : 'bg-white'">
                                    </td>
                                    <td x-show="activeTab === 'sikap'" class="px-4 py-4 text-center">
                                        <select name="nilai[{{ $siswa['id'] }}][s_spiritual]" x-model="siswaList[{{ $index }}].s_spiritual" :disabled="!isEditing" class="px-3 py-2 text-xs font-bold rounded-lg border border-gray-200 outline-none focus:border-gray-900 transition-colors cursor-pointer" :class="!isEditing ? 'bg-gray-50 border-transparent text-gray-500' : 'bg-white'">
                                            <option value="A">SB (A)</option><option value="B">B (B)</option><option value="C">C (C)</option><option value="D">K (D)</option>
                                        </select>
                                    </td>
                                    <td x-show="activeTab === 'sikap'" class="px-4 py-4 text-center">
                                        <select name="nilai[{{ $siswa['id'] }}][s_sosial]" x-model="siswaList[{{ $index }}].s_sosial" :disabled="!isEditing" class="px-3 py-2 text-xs font-bold rounded-lg border border-gray-200 outline-none focus:border-gray-900 transition-colors cursor-pointer" :class="!isEditing ? 'bg-gray-50 border-transparent text-gray-500' : 'bg-white'">
                                            <option value="A">SB (A)</option><option value="B">B (B)</option><option value="C">C (C)</option><option value="D">K (D)</option>
                                        </select>
                                    </td>
                                    <td x-show="activeTab === 'catatan'" class="px-6 py-4">
                                        <textarea name="nilai[{{ $siswa['id'] }}][catatan]" x-model="siswaList[{{ $index }}].catatan" :disabled="!isEditing" rows="1" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:border-gray-900 outline-none transition-colors resize-none" :class="!isEditing ? 'bg-gray-50 border-transparent text-gray-500' : 'bg-white'" placeholder="Catatan..."></textarea>
                                    </td>
                                    <td x-show="activeTab !== 'catatan'" class="px-6 py-4 text-center">
                                        <span class="text-sm font-bold text-gray-900" x-text="getDisplayAvg(siswaList[{{ $index }}])"></span>
                                    </td>
                                    <td x-show="activeTab !== 'catatan'" class="px-6 py-4 text-center">
                                        <div class="inline-block px-3 py-1 text-[10px] font-bold rounded-lg" :class="getPredikatClass(siswaList[{{ $index }}])" x-text="getDisplayPredikat(siswaList[{{ $index }}])"></div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </form>

            <div class="p-6 bg-gray-50/30 border-t border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-[11px] text-gray-400 font-medium italic"><i class="fa-solid fa-circle-info mr-1"></i> Nilai akhir dihitung otomatis berdasarkan rata-rata murni.</p>
                <div class="w-full md:w-auto">
                    <x-pagination :paginator="$siswaList" />
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
function inputNilai() {
    return {
        activeTab: '{{ session('active_tab', request('tab', 'pengetahuan')) }}',
        isEditing: false,
        siswaList: @json($siswaJsonData),

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