@extends('layouts.app')
@section('title', 'Ubah Kata Sandi')

@section('content')
    <div class="max-w-4xl mx-auto" x-data="{ activeTab: localStorage.getItem('settingTab') || 'profil', showOld: false, showNew: false, showConfirm: false }" x-init="$watch('activeTab', val => localStorage.setItem('settingTab', val))">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Pengaturan Akun</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola informasi profil dan keamanan akun Anda.</p>
        </div>

        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden flex flex-col md:flex-row">
            {{-- Sidebar Tabs --}}
            <div class="w-full md:w-64 bg-gray-50 border-b md:border-b-0 md:border-r border-gray-200 flex flex-row md:flex-col p-4 md:p-6 gap-2 overflow-x-auto">
                <button @click="activeTab = 'profil'" 
                        :class="activeTab === 'profil' ? 'bg-white border-gray-200 shadow-sm text-blue-600' : 'border-transparent text-gray-600 hover:bg-gray-100'"
                        class="px-4 py-3 text-sm font-bold rounded-lg border transition-all flex items-center gap-3 text-left whitespace-nowrap md:whitespace-normal w-full">
                    <i class="fa-solid fa-user-circle text-lg"></i>
                    <span>Informasi Profil</span>
                </button>
                <button @click="activeTab = 'keamanan'" 
                        :class="activeTab === 'keamanan' ? 'bg-white border-gray-200 shadow-sm text-blue-600' : 'border-transparent text-gray-600 hover:bg-gray-100'"
                        class="px-4 py-3 text-sm font-bold rounded-lg border transition-all flex items-center gap-3 text-left whitespace-nowrap md:whitespace-normal w-full">
                    <i class="fa-solid fa-shield-halved text-lg"></i>
                    <span>Keamanan Akun</span>
                </button>
            </div>

            {{-- Content Area --}}
            <div class="flex-1 p-6 md:p-8">
                
                {{-- Tab: Informasi Profil --}}
                <div x-show="activeTab === 'profil'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                    <h2 class="text-lg font-bold text-gray-900 mb-6">Informasi Pribadi</h2>
                    
                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-gray-900">{{ auth()->user()->nama }}</h3>
                        <p class="text-sm text-blue-600 font-medium">Informasi Akun</p>
                    </div>

                    <form action="#" method="POST" @submit.prevent="$dispatch('notify', { message: 'Profil berhasil diperbarui.', type: 'success' })">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                                <input type="text" value="{{ auth()->user()->nama }}" class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:border-gray-900 outline-none transition-colors bg-gray-50" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">NIP / Username</label>
                                <input type="text" value="{{ auth()->user()->username }}" class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:border-gray-900 outline-none transition-colors bg-gray-50" readonly>
                            </div>
                        </div>
                        <div class="mb-8">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Email Kontak</label>
                            <input type="email" value="{{ auth()->user()->email }}" class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:border-gray-900 outline-none transition-colors bg-white">
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white text-sm font-bold rounded-lg hover:bg-blue-700 transition-colors">
                                Simpan Profil
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Tab: Keamanan --}}
                <div x-show="activeTab === 'keamanan'" style="display: none;" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                    <h2 class="text-lg font-bold text-gray-900 mb-2">Ubah Kata Sandi</h2>
                    <p class="text-sm text-gray-500 mb-6">Pastikan akun Anda menggunakan kata sandi yang panjang dan acak agar tetap aman.</p>

                    @if(session('status'))
                        <div class="mb-4 p-3 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-medium rounded-lg flex items-center gap-2">
                            <i class="fa-solid fa-circle-check"></i>
                            {{ session('status') }}
                        </div>
                    @endif

                    <form action="{{ route('password.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="space-y-5 mb-8">
                            {{-- Password Lama --}}
                            <div>
                                <label for="current_password" class="block text-sm font-semibold text-gray-700 mb-2">Kata Sandi Saat Ini</label>
                                <div class="relative group">
                                    <input :type="showOld ? 'text' : 'password'" id="current_password" name="current_password" required
                                           class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:border-gray-900 outline-none transition-colors bg-white @error('current_password') border-red-500 @enderror">
                                    <button type="button" @click="showOld = !showOld" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                                        <i class="fa-solid" :class="showOld ? 'fa-eye-slash' : 'fa-eye'"></i>
                                    </button>
                                </div>
                                @error('current_password')
                                    <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="h-px bg-gray-100 my-2"></div>

                            {{-- Password Baru --}}
                            <div>
                                <label for="new_password" class="block text-sm font-semibold text-gray-700 mb-2">Kata Sandi Baru</label>
                                <div class="relative group">
                                    <input :type="showNew ? 'text' : 'password'" id="new_password" name="new_password" required
                                           class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:border-gray-900 outline-none transition-colors bg-white @error('new_password') border-red-500 @enderror">
                                    <button type="button" @click="showNew = !showNew" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                                        <i class="fa-solid" :class="showNew ? 'fa-eye-slash' : 'fa-eye'"></i>
                                    </button>
                                </div>
                                @error('new_password')
                                    <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Konfirmasi Password --}}
                            <div>
                                <label for="new_password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Kata Sandi Baru</label>
                                <div class="relative group">
                                    <input :type="showConfirm ? 'text' : 'password'" id="new_password_confirmation" name="new_password_confirmation" required
                                           class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:border-gray-900 outline-none transition-colors bg-white">
                                    <button type="button" @click="showConfirm = !showConfirm" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                                        <i class="fa-solid" :class="showConfirm ? 'fa-eye-slash' : 'fa-eye'"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="px-6 py-2.5 bg-gray-900 text-white text-sm font-bold rounded-lg hover:bg-gray-800 transition-colors flex items-center gap-2">
                                <i class="fa-solid fa-lock"></i>
                                <span>Perbarui Sandi</span>
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
