@extends('layouts.guest')

@section('title', 'Lupa Sandi - Smart Rapor')

@section('content')
    <div class="w-full max-w-sm">
        {{-- Ultra-Flat Card --}}
        <div class="bg-white border border-gray-200 p-10 text-center rounded-2xl">
            
            <div class="mb-6">
                <h2 class="text-sm font-bold text-black uppercase tracking-widest">Lupa Sandi</h2>
                <p class="text-[11px] text-gray-500 mt-2">Masukkan email Anda untuk instruksi pemulihan.</p>
            </div>

            {{-- Form --}}
            <div x-data="{ loading: false, sent: false }">
                <form method="POST" action="#" @submit.prevent="loading = true; setTimeout(() => { loading = false; sent = true; }, 1500)" class="space-y-6 text-left" x-show="!sent">
                    @csrf

                    <div class="space-y-1">
                        <label for="email" class="text-[10px] font-bold text-gray-500 uppercase">Email</label>
                        <input type="email" id="email" name="email" required
                               class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg focus:border-black outline-none transition-none bg-white"
                               placeholder="email@sekolah.sch.id">
                    </div>

                    <button type="submit" :disabled="loading" class="w-full py-3 bg-black text-white text-xs font-bold uppercase tracking-widest rounded-lg hover:bg-gray-800 transition-none disabled:opacity-50">
                        <span x-show="!loading">Kirim Link Reset</span>
                        <span x-show="loading" style="display: none;"><i class="fa-solid fa-spinner fa-spin mr-2"></i> Mengirim...</span>
                    </button>
                </form>

                {{-- Success Message --}}
                <div x-show="sent" style="display: none;" class="text-center p-4 bg-green-50 rounded-lg border border-green-100">
                    <i class="fa-solid fa-envelope-circle-check text-2xl text-green-600 mb-2"></i>
                    <h3 class="text-sm font-bold text-gray-900 mb-1">Email Terkirim!</h3>
                    <p class="text-[11px] text-gray-600">Periksa kotak masuk email Anda untuk instruksi reset kata sandi.</p>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-100 text-[10px]">
                <a href="{{ route('login') }}" class="font-bold text-gray-400 hover:text-black">KEMBALI KE LOGIN</a>
            </div>
        </div>
    </div>
@endsection