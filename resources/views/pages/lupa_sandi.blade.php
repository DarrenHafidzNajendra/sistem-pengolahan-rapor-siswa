@extends('layouts.guest')

@section('title', 'Lupa Sandi - Smart Rapor')

@section('content')
    {{-- Judul --}}
    <h1 class="text-sm font-semibold tracking-[0.25em] uppercase text-gray-500 mb-5">
        Lupa Sandi
    </h1>

    {{-- Card --}}
    <div class="bg-white rounded-2xl shadow-md w-full max-w-md px-10 py-10">

        {{-- Deskripsi --}}
        <p class="text-sm text-gray-500 text-center leading-relaxed mb-6">
            Silakan masukkan email Anda, sistem kami akan memverifikasi email tersebut
            dan mengirimkan tautan untuk mengatur ulang kata sandi Anda.
        </p>

        {{-- Session Status (sukses kirim email) --}}
        @if (session('status'))
            <div class="mb-5 p-3 rounded-lg bg-green-50 border border-green-200">
                <p class="text-sm text-green-700">{{ session('status') }}</p>
            </div>
        @endif

        {{-- Form --}}
        <form method="POST" action="{{ url('/forgot-password') }}">
            @csrf

            {{-- Email --}}
            <div class="mb-6">
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">
                    Email
                </label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    autofocus
                    autocomplete="email"
                    class="w-full border border-gray-400 rounded-lg px-4 py-2.5 text-sm text-gray-900 bg-white focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-gray-400 transition @error('email') border-red-400 @enderror"
                >
                @error('email')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol Kirim --}}
            <button
                type="submit"
                class="w-full bg-[#4B5563] hover:bg-[#374151] active:bg-[#1F2937] text-white text-sm font-semibold rounded-lg py-3 transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2"
            >
                Kirim tautan reset sandi
            </button>

        </form>

        {{-- Kembali ke Login --}}
        <div class="text-center mt-4">
            <a
                href="{{ url('/login') }}"
                class="text-sm text-gray-500 hover:underline hover:text-gray-700"
            >
                Kembali ke Login
            </a>
        </div>

    </div>
@endsection