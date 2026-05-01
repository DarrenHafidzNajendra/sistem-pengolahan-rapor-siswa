@extends('layouts.guest')

@section('title', 'Login Smart Rapor')

@section('content')
    {{-- Judul --}}
    <h1 class="text-sm font-bold tracking-[0.25em] uppercase text-gray-500 mb-5">
        Login Smart Rapor
    </h1>

    {{-- Card --}}
    <div class="bg-white rounded-2xl shadow-md w-full max-w-md px-10 py-10">

        {{-- Logo SVG SmartRapor --}}
        <div class="flex flex-col items-center mb-8">
            <svg width="160" height="52" viewBox="0 0 160 52" fill="none" xmlns="http://www.w3.org/2000/svg">
                <!-- Ikon buku terbuka -->
                <rect x="0" y="8" width="22" height="28" rx="3" fill="#4B5563"/>
                <rect x="24" y="8" width="22" height="28" rx="3" fill="#6B7280"/>
                <line x1="23" y1="8" x2="23" y2="36" stroke="white" stroke-width="2"/>
                <!-- Tanda bintang / rapor -->
                <circle cx="11" cy="22" r="5" fill="white" fill-opacity="0.3"/>
                <circle cx="35" cy="22" r="5" fill="white" fill-opacity="0.2"/>
                <!-- Teks SMART -->
                <text x="54" y="26" font-family="Plus Jakarta Sans, sans-serif" font-size="18" font-weight="800" fill="#1F2937" letter-spacing="1">SMART</text>
                <!-- Teks RAPOR -->
                <text x="54" y="42" font-family="Plus Jakarta Sans, sans-serif" font-size="13" font-weight="500" fill="#6B7280" letter-spacing="3">RAPOR</text>
            </svg>
        </div>

        {{-- Form --}}
        <form method="GET" action="/dashboard">
            @csrf

            {{-- Username --}}
            <div class="mb-4">
                <label for="username" class="block text-sm font-semibold text-gray-700 mb-1.5">
                    Username
                </label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    value="{{ old('username') }}"
                    autofocus
                    autocomplete="username"
                    class="w-full border border-gray-400 rounded-lg px-4 py-2.5 text-sm text-gray-900 bg-white focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-gray-400 transition @error('username') border-red-400 @enderror"
                >
                @error('username')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mb-1">
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-1.5">
                    Password
                </label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    autocomplete="current-password"
                    class="w-full border border-gray-400 rounded-lg px-4 py-2.5 text-sm text-gray-900 bg-white focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-gray-400 transition @error('password') border-red-400 @enderror"
                >
                @error('password')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Lupa sandi --}}
            <div class="flex justify-end mt-2 mb-6">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-gray-500 hover:underline hover:text-gray-700">
                        Lupa sandi
                    </a>
                @else
                    <a href="/lupa_sandi" class="text-sm text-gray-500 hover:underline hover:text-gray-700">
                        Lupa sandi
                    </a>
                @endif
            </div>

            {{-- Error umum --}}
            @if ($errors->any() && !$errors->has('username') && !$errors->has('password'))
                <div class="mb-4 p-3 rounded-lg bg-red-50 border border-red-200">
                    <p class="text-sm text-red-600">{{ $errors->first() }}</p>
                </div>
            @endif

            {{-- Tombol Login --}}
            <button
                type="submit"
                class="w-full bg-[#4B5563] hover:bg-[#374151] active:bg-[#1F2937] text-white text-sm font-bold rounded-lg py-3 transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2"
            >
            <a href="{{url('/pages/dashboard')}}"></a>
                Login
            </button>

        </form>
    </div>
@endsection