@extends('layouts.app')
@section('title', 'Ubah Kata Sandi')

@section('content')
    <div class="max-w-xl mx-auto" x-data="{ showOld: false, showNew: false, showConfirm: false }">
        {{-- Header Section --}}
        <div class="mb-8 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-50 rounded-2xl mb-4 shadow-sm border border-blue-100">
                <i class="fa-solid fa-shield-halved text-2xl text-blue-600"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-900">Keamanan Akun</h1>
            <p class="text-sm text-gray-500 mt-2">Perbarui kata sandi Anda secara berkala untuk menjaga keamanan data.</p>
        </div>

        {{-- Form Card --}}
        <div class="bg-white rounded-2xl shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
            <div class="p-8">
                <form action="#" method="POST" @submit.prevent="$dispatch('notify', { message: 'Kata sandi Anda berhasil diperbarui.' })">
                    @csrf
                    
                    {{-- Password Lama --}}
                    <div class="mb-6">
                        <label for="current_password" class="block text-sm font-bold text-gray-700 mb-2">Kata Sandi Saat Ini</label>
                        <div class="relative group">
                            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-blue-500 transition-colors">
                                <i class="fa-solid fa-lock text-sm"></i>
                            </div>
                            <input :type="showOld ? 'text' : 'password'" id="current_password" name="current_password" 
                                   class="w-full pl-11 pr-12 py-3.5 text-sm border border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all bg-gray-50/30 hover:bg-white"
                                   placeholder="••••••••">
                            <button type="button" @click="showOld = !showOld" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                                <i class="fa-solid" :class="showOld ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                    </div>

                    <div class="h-px bg-gray-100 mb-6"></div>

                    {{-- Password Baru --}}
                    <div class="mb-6">
                        <label for="new_password" class="block text-sm font-bold text-gray-700 mb-2">Kata Sandi Baru</label>
                        <div class="relative group">
                            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-blue-500 transition-colors">
                                <i class="fa-solid fa-key text-sm"></i>
                            </div>
                            <input :type="showNew ? 'text' : 'password'" id="new_password" name="new_password" 
                                   class="w-full pl-11 pr-12 py-3.5 text-sm border border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all bg-gray-50/30 hover:bg-white"
                                   placeholder="Minimal 8 karakter">
                            <button type="button" @click="showNew = !showNew" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                                <i class="fa-solid" :class="showNew ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                        <p class="mt-2 text-[11px] text-gray-400 flex items-center gap-1.5 px-1">
                            <i class="fa-solid fa-circle-info"></i> Gunakan kombinasi huruf, angka, dan simbol.
                        </p>
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div class="mb-8">
                        <label for="confirm_password" class="block text-sm font-bold text-gray-700 mb-2">Konfirmasi Kata Sandi Baru</label>
                        <div class="relative group">
                            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-blue-500 transition-colors">
                                <i class="fa-solid fa-circle-check text-sm"></i>
                            </div>
                            <input :type="showConfirm ? 'text' : 'password'" id="confirm_password" name="confirm_password" 
                                   class="w-full pl-11 pr-12 py-3.5 text-sm border border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all bg-gray-50/30 hover:bg-white"
                                   placeholder="Ulangi kata sandi baru">
                            <button type="button" @click="showConfirm = !showConfirm" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                                <i class="fa-solid" :class="showConfirm ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit" class="w-full py-4 bg-gray-900 text-white font-bold rounded-xl hover:bg-gray-800 active:scale-[0.98] transition-all shadow-lg shadow-gray-200 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-rotate"></i>
                        <span>Perbarui Kata Sandi</span>
                    </button>
                </form>
            </div>
            
            {{-- Footer Note --}}
            <div class="px-8 py-5 bg-gray-50 border-t border-gray-100 flex items-center gap-3">
                <i class="fa-solid fa-triangle-exclamation text-amber-500"></i>
                <p class="text-[11px] text-gray-500 font-medium">Anda akan diminta untuk login kembali setelah mengganti kata sandi demi alasan keamanan.</p>
            </div>
        </div>

        {{-- Help Card --}}
        <div class="mt-8 p-4 bg-blue-50/50 rounded-2xl border border-blue-100 flex items-center gap-4">
            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                <i class="fa-solid fa-question text-sm"></i>
            </div>
            <div>
                <h4 class="text-sm font-bold text-gray-900">Butuh bantuan?</h4>
                <p class="text-xs text-gray-500">Hubungi Admin jika Anda lupa kata sandi saat ini.</p>
            </div>
        </div>
    </div>
@endsection
