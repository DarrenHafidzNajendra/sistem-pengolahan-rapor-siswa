@extends('layouts.guest')

@section('title', 'Login - Smart Rapor')

@section('content')
    <div class="w-full max-w-sm" x-data="{ showPass: false }">
        {{-- Ultra-Flat Card --}}
        <div class="bg-white border border-gray-200 p-10"> {{-- Tanpa Rounded Berlebihan & Tanpa Shadow --}}
            
            {{-- Simple Logo --}}
            <div class="flex items-center gap-2 mb-10 justify-center">
                <div class="w-8 h-8 bg-black flex items-center justify-center text-white">
                    <i class="fa-solid fa-graduation-cap text-xs"></i>
                </div>
                <h1 class="text-sm font-bold tracking-tight text-black">SMART RAPOR</h1>
            </div>

            {{-- Form --}}
            <form method="GET" action="{{ route('dashboard') }}" class="space-y-6">
                @csrf

                <div class="space-y-1">
                    <label for="username" class="text-[10px] font-bold text-gray-500 uppercase">Username</label>
                    <input type="text" id="username" name="username" required
                           class="w-full px-4 py-2 text-sm border border-gray-300 focus:border-black outline-none transition-none bg-white"
                           placeholder="Username Anda">
                </div>

                <div class="space-y-1">
                    <div class="flex justify-between items-center">
                        <label for="password" class="text-[10px] font-bold text-gray-500 uppercase">Password</label>
                        <a href="{{ route('lupa_sandi') }}" class="text-[10px] text-gray-400 hover:text-black">Lupa sandi?</a>
                    </div>
                    <div class="relative">
                        <input type="password" :type="showPass ? 'text' : 'password'" id="password" name="password" required
                               class="w-full px-4 py-2 text-sm border border-gray-300 focus:border-black outline-none transition-none bg-white"
                               placeholder="••••••••">
                        <button type="button" @click="showPass = !showPass" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-black">
                            <i class="fa-solid" :class="showPass ? 'fa-eye-slash' : 'fa-eye' shadow-none"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="w-full py-3 bg-black text-white text-xs font-bold uppercase tracking-widest hover:bg-gray-800 transition-none">
                    Login
                </button>
            </form>
        </div>

        <p class="text-center mt-6 text-[9px] text-gray-400 font-medium uppercase tracking-widest">
            Sistem Informasi Rapor Digital
        </p>
    </div>
@endsection