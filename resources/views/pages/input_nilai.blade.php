@extends('layouts.app')
@section('title', 'Input Nilai')

@section('content')
    <div class="max-w-full" x-data="inputNilai()">
        <!-- Modal Tambah Komponen -->
        <x-modal name="openTambahKomponen" title="Tambah Komponen Nilai">
            <form action="{{ route('komponen_nilai.store') }}" method="POST">
                @csrf
                <input type="hidden" name="pengampu_id" value="{{ $selectedPengampu?->id }}">
                <input type="hidden" name="tipe" id="komponenTipe">
                
                <div class="mb-4">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nama Komponen (Contoh: Tugas Pantun, UH 1)</label>
                    <input type="text" name="nama_komponen" required class="w-full px-3 py-2 text-sm border border-gray-300 rounded focus:border-gray-900 outline-none transition-colors" placeholder="Masukkan nama komponen...">
                </div>
                
                <div class="flex items-center gap-3 mt-6">
                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-gray-900 text-white text-sm font-semibold rounded hover:bg-gray-800 transition-colors">
                        <i class="fa-solid fa-save"></i><span>Simpan Komponen</span>
                    </button>
                    <button type="button" @click="openTambahKomponen = false" class="px-6 py-2.5 text-sm font-semibold text-gray-500 bg-gray-100 rounded hover:bg-gray-200 transition-colors">Batal</button>
                </div>
            </form>
        </x-modal>

        <!-- Header Section - Flat & Clean -->
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Input Capaian Belajar</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola nilai akademik siswa untuk mata pelajaran dan kelas yang diampu.</p>
        </div>

        <div class="bg-white rounded border border-gray-200 overflow-hidden shadow-sm">
            <!-- Form Simpan (POST) - Wrapping everything for safety -->
            <form action="{{ route('input_nilai.store') }}" method="POST" id="formSimpanNilai">
                @csrf
                <input type="hidden" name="pengampu_id" value="{{ $selectedPengampu?->id }}">
                <input type="hidden" name="active_tab" :value="activeTab">

                <!-- Toolbar & Filter -->
                <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                    <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                        <div class="flex flex-wrap items-center gap-3">
                            <select name="mapel_id_filter" @change="location.href='{{ route('input_nilai') }}?mapel_id='+$event.target.value+'&kelas_id={{ request('kelas_id') }}&tab='+activeTab" class="px-4 py-2 text-sm font-semibold text-gray-700 border border-gray-300 rounded bg-white focus:border-gray-900 outline-none transition-colors cursor-pointer">
                                @foreach($mapelList as $mapel)
                                    <option value="{{ $mapel->id }}" {{ ($selectedPengampu && $selectedPengampu->mapel_id == $mapel->id) || request('mapel_id') == $mapel->id ? 'selected' : '' }}>{{ $mapel->nama_mapel }}</option>
                                @endforeach
                            </select>
                            <select name="kelas_id_filter" @change="location.href='{{ route('input_nilai') }}?mapel_id={{ request('mapel_id') }}&kelas_id='+$event.target.value+'&tab='+activeTab" class="px-4 py-2 text-sm font-semibold text-gray-700 border border-gray-300 rounded bg-white focus:border-gray-900 outline-none transition-colors cursor-pointer">
                                @foreach($kelasList as $kelas)
                                    <option value="{{ $kelas->id }}" {{ ($selectedPengampu && $selectedPengampu->kelas_id == $kelas->id) || request('kelas_id') == $kelas->id ? 'selected' : '' }}>{{ $kelas->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-center gap-3 w-full lg:w-auto">
                            <button type="button" 
                                    @click="isEditing = !isEditing"
                                    :class="isEditing ? 'bg-amber-600' : 'bg-blue-600'" 
                                    class="px-5 py-2 text-white text-sm font-semibold rounded transition-colors flex items-center gap-2">
                                <i class="fa-solid" :class="isEditing ? 'fa-xmark' : 'fa-pen-to-square'"></i>
                                <span x-text="isEditing ? 'Batal Edit' : 'Edit Nilai'"></span>
                            </button>
                            
                            <button type="submit" x-show="isEditing"
                                    class="px-5 py-2 bg-gray-900 text-white text-sm font-semibold rounded transition-colors flex items-center gap-2">
                                <i class="fa-solid fa-floppy-disk"></i>
                                <span>Simpan Perubahan</span>
                            </button>
                        </div>
                    </div>

                    <!-- Tabs Selector & Dynamic Add -->
                    <div class="flex flex-wrap items-center justify-between gap-4 mt-6">
                        <div class="flex items-center gap-1 p-1 bg-gray-100 rounded border border-gray-200">
                            <button type="button" @click="activeTab = 'pengetahuan'" :class="activeTab === 'pengetahuan' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700'" class="px-5 py-2 text-xs font-semibold rounded transition-all">Pengetahuan</button>
                            <button type="button" @click="activeTab = 'keterampilan'" :class="activeTab === 'keterampilan' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700'" class="px-5 py-2 text-xs font-semibold rounded transition-all">Keterampilan</button>
                            <button type="button" @click="activeTab = 'sikap'" :class="activeTab === 'sikap' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700'" class="px-5 py-2 text-xs font-semibold rounded transition-all">Sikap & Karakter</button>
                        </div>

                        <div class="flex items-center gap-2" x-show="activeTab === 'pengetahuan'">
                            <button type="button" @click="addKomponen('p_tugas')" class="px-4 py-2 bg-white text-gray-700 text-[11px] font-bold border border-gray-200 rounded hover:bg-gray-50 transition-all flex items-center gap-1.5">
                                <i class="fa-solid fa-plus text-blue-500"></i><span>Tambah Tugas</span>
                            </button>
                            <button type="button" @click="addKomponen('p_uh')" class="px-4 py-2 bg-white text-gray-700 text-[11px] font-bold border border-gray-200 rounded hover:bg-gray-50 transition-all flex items-center gap-1.5">
                                <i class="fa-solid fa-plus text-green-500"></i><span>Tambah UH</span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead class="bg-gray-900">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white tracking-tight">Nama Siswa</th>
                                
                                {{-- Render Komponen Tugas --}}
                                @foreach($komponenList->where('tipe', 'p_tugas') as $komp)
                                    <th x-show="activeTab === 'pengetahuan'" class="px-2 py-4 text-center text-xs font-bold text-white tracking-tight border-r border-gray-800">
                                        <div class="flex flex-col gap-1 items-center">
                                            <span>{{ $komp->nama_komponen }}</span>
                                            <button type="button" @click="deleteKomponen('{{ $komp->id }}')" class="text-[9px] text-red-400 hover:text-red-300">Hapus</button>
                                        </div>
                                    </th>
                                @endforeach

                                {{-- Render Komponen UH --}}
                                @foreach($komponenList->where('tipe', 'p_uh') as $komp)
                                    <th x-show="activeTab === 'pengetahuan'" class="px-2 py-4 text-center text-xs font-bold text-white tracking-tight border-r border-gray-800">
                                        <div class="flex flex-col gap-1 items-center">
                                            <span>{{ $komp->nama_komponen }}</span>
                                            <button type="button" @click="deleteKomponen('{{ $komp->id }}')" class="text-[9px] text-red-400 hover:text-red-300">Hapus</button>
                                        </div>
                                    </th>
                                @endforeach

                                <th x-show="activeTab === 'pengetahuan'" class="px-4 py-4 text-center text-xs font-bold text-white tracking-tight">UTS</th>
                                <th x-show="activeTab === 'pengetahuan'" class="px-4 py-4 text-center text-xs font-bold text-white tracking-tight">UAS</th>
                                <th x-show="activeTab === 'keterampilan'" class="px-4 py-4 text-center text-xs font-bold text-white tracking-tight">Praktik</th>
                                <th x-show="activeTab === 'keterampilan'" class="px-4 py-4 text-center text-xs font-bold text-white tracking-tight">Proyek</th>
                                <th x-show="activeTab === 'keterampilan'" class="px-4 py-4 text-center text-xs font-bold text-white tracking-tight">Portofolio</th>
                                <th x-show="activeTab === 'sikap'" class="px-4 py-4 text-center text-xs font-bold text-white tracking-tight">Spiritual</th>
                                <th x-show="activeTab === 'sikap'" class="px-4 py-4 text-center text-xs font-bold text-white tracking-tight">Sosial</th>
                                <th x-show="activeTab !== 'sikap'" class="px-6 py-4 text-center text-xs font-bold text-white tracking-tight">Nilai Akhir</th>
                                <th x-show="activeTab !== 'sikap'" class="px-6 py-4 text-center text-xs font-bold text-white tracking-tight">Predikat</th>
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

                                    {{-- Render Input Komponen Dinamis --}}
                                    @foreach($komponenList as $komp)
                                        <td x-show="activeTab === 'pengetahuan'" class="px-2 py-4 text-center border-r border-gray-50">
                                            <input type="number" name="nilai[{{ $siswa['id'] }}][comp_{{ $komp->id }}]" x-model.number="siswaList[{{ $index }}].comp_{{ $komp->id }}" @input="updateAll(siswaList[{{ $index }}])" :disabled="!isEditing" class="w-12 px-1 py-2 text-xs text-center border border-gray-200 rounded focus:border-gray-900 outline-none transition-colors" :class="!isEditing ? 'bg-gray-50 border-transparent text-gray-500' : 'bg-white'">
                                        </td>
                                    @endforeach

                                    <td x-show="activeTab === 'pengetahuan'" class="px-2 py-4 text-center">
                                        <input type="number" name="nilai[{{ $siswa['id'] }}][p_uts]" x-model.number="siswaList[{{ $index }}].p_uts" @input="updateAll(siswaList[{{ $index }}])" :disabled="!isEditing" class="w-12 px-1 py-2 text-xs text-center border border-gray-200 rounded focus:border-gray-900 outline-none transition-colors" :class="!isEditing ? 'bg-gray-50 border-transparent text-gray-500' : 'bg-white'">
                                    </td>
                                    <td x-show="activeTab === 'pengetahuan'" class="px-2 py-4 text-center">
                                        <input type="number" name="nilai[{{ $siswa['id'] }}][p_uas]" x-model.number="siswaList[{{ $index }}].p_uas" @input="updateAll(siswaList[{{ $index }}])" :disabled="!isEditing" class="w-12 px-1 py-2 text-xs text-center border border-gray-200 rounded focus:border-gray-900 outline-none transition-colors" :class="!isEditing ? 'bg-gray-50 border-transparent text-gray-500' : 'bg-white'">
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
                                            <option value="">- Pilih -</option>
                                            <option value="A">SB (A)</option><option value="B">B (B)</option><option value="C">C (C)</option><option value="D">K (D)</option>
                                        </select>
                                    </td>
                                    <td x-show="activeTab === 'sikap'" class="px-4 py-4 text-center">
                                        <select name="nilai[{{ $siswa['id'] }}][s_sosial]" x-model="siswaList[{{ $index }}].s_sosial" :disabled="!isEditing" class="px-3 py-2 text-xs font-bold rounded-lg border border-gray-200 outline-none focus:border-gray-900 transition-colors cursor-pointer" :class="!isEditing ? 'bg-gray-50 border-transparent text-gray-500' : 'bg-white'">
                                            <option value="">- Pilih -</option>
                                            <option value="A">SB (A)</option><option value="B">B (B)</option><option value="C">C (C)</option><option value="D">K (D)</option>
                                        </select>
                                    </td>

                                    <td x-show="activeTab !== 'sikap'" class="px-6 py-4 text-center">
                                        <span class="text-sm font-bold text-gray-900" x-text="getDisplayAvg(siswaList[{{ $index }}])"></span>
                                    </td>
                                    <td x-show="activeTab !== 'sikap'" class="px-6 py-4 text-center">
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
        openTambahKomponen: false,
        komponenList: @json($komponenList),
        siswaList: @json($siswaJsonData),

        addKomponen(tipe) {
            document.getElementById('komponenTipe').value = tipe;
            this.openTambahKomponen = true;
        },

        deleteKomponen(id) {
            Swal.fire({
                title: 'Hapus Komponen?',
                text: "Semua nilai siswa pada komponen ini akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#111827',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-xl border border-gray-100 shadow-2xl',
                    confirmButton: 'px-6 py-2.5 text-xs font-bold uppercase tracking-widest rounded transition-all',
                    cancelButton: 'px-6 py-2.5 text-xs font-bold uppercase tracking-widest rounded transition-all'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Buat form dinamis agar tidak mengganggu form lain di halaman
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/komponen_nilai/${id}`;
                    
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = csrfToken;
                    
                    const methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'DELETE';
                    
                    form.appendChild(csrfInput);
                    form.appendChild(methodInput);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        },

        updateAll(siswa) {
            // Rata-rata Tugas Dinamis
            const t_ids = this.komponenList.filter(k => k.tipe === 'p_tugas').map(k => 'comp_' + k.id);
            const t_vals = t_ids.map(id => siswa[id]).filter(v => v !== null && v !== '');
            const t_avg = t_vals.length > 0 ? t_vals.reduce((a,b) => a+b, 0) / t_vals.length : null;
            
            // Rata-rata UH Dinamis
            const uh_ids = this.komponenList.filter(k => k.tipe === 'p_uh').map(k => 'comp_' + k.id);
            const uh_vals = uh_ids.map(id => siswa[id]).filter(v => v !== null && v !== '');
            const uh_avg = uh_vals.length > 0 ? uh_vals.reduce((a,b) => a+b, 0) / uh_vals.length : null;

            // Nilai Harian (NH)
            const nh_components = [t_avg, uh_avg].filter(v => v !== null);
            const nh = nh_components.length > 0 ? nh_components.reduce((a,b) => a+b, 0) / nh_components.length : 0;

            const p_uts = siswa.p_uts || 0;
            const p_uas = siswa.p_uas || 0;
            
            if (nh_components.length > 0 || siswa.p_uts || siswa.p_uas) {
                const p = ((2 * nh) + p_uts + p_uas) / 4;
                siswa.p_avg = Math.round(p * 10) / 10;
            } else {
                siswa.p_avg = null;
            }
            siswa.p_pred = this.calcPredikat(siswa.p_avg);
            const k = ((siswa.k_praktik||0) + (siswa.k_proyek||0) + (siswa.k_portofolio||0)) / 3;
            siswa.k_avg = k > 0 ? Math.round(k * 10) / 10 : null;
            siswa.k_pred = this.calcPredikat(k);
        },
        calcPredikat(n) { if(n >= 90) return 'A'; if(n >= 80) return 'B'; if(n >= 70) return 'C'; if(n > 0) return 'D'; return ''; },
        getDisplayAvg(siswa) { if(this.activeTab === 'pengetahuan') return siswa.p_avg || '-'; if(this.activeTab === 'keterampilan') return siswa.k_avg || '-'; return '-'; },
        getDisplayPredikat(siswa) { if(this.activeTab === 'pengetahuan') return siswa.p_pred || '-'; if(this.activeTab === 'keterampilan') return siswa.k_pred || '-'; return '-'; },
        getPredikatClass(siswa) {
            if(this.activeTab === 'sikap') return 'bg-gray-100 text-gray-400';
            const p = this.getDisplayPredikat(siswa);
            if(p === 'A') return 'bg-green-100 text-green-700'; if(p === 'B') return 'bg-blue-100 text-blue-700';
            if(p === 'C') return 'bg-yellow-100 text-yellow-700'; if(p === 'D') return 'bg-red-100 text-red-700';
            return 'bg-gray-100 text-gray-400';
        }
    }
}
</script>
@endpush