@extends('layouts.app')
@section('title', 'Ubah Kata Sandi')

@section('content')
    <div class="max-w-2xl">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Ubah Kata Sandi</h1>
            <p class="text-gray-600 mt-1">Perbarui kata sandi akun Anda untuk keamanan yang lebih baik</p>
        </div>

        @if ($errors->any())
            <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200">
                <p class="text-sm font-semibold text-red-700 mb-2">Terjadi kesalahan:</p>
                <ul class="space-y-1">
                    @foreach ($errors->all() as $error)
                        <li class="text-sm text-red-600">• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('status'))
            <div class="mb-6 p-4 rounded-lg bg-green-50 border border-green-200">
                <p class="text-sm text-green-700 font-semibold">✓ {{ session('status') }}</p>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="p-6">
                <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <div>
                        <label for="current_password" class="block text-sm font-semibold text-gray-900 mb-2">Kata Sandi Saat Ini</label>
                        <input type="password" id="current_password" name="current_password" required autocomplete="current-password" class="w-full px-4 py-3 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white hover:border-gray-400" placeholder="Masukkan kata sandi saat ini">
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-900 mb-2">Kata Sandi Baru</label>
                        <input type="password" id="password" name="password" required autocomplete="new-password" class="w-full px-4 py-3 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white hover:border-gray-400" placeholder="Masukkan kata sandi baru (minimal 8 karakter)">
                        <div class="mt-2">
                            <p class="text-xs text-gray-600 mb-2">Persyaratan kata sandi:</p>
                            <ul class="space-y-1 text-xs text-gray-600">
                                <li id="length-check" class="flex items-center gap-2"><span class="w-4 h-4 rounded-full border border-gray-300 flex items-center justify-center text-[10px]">✓</span> Minimal 8 karakter</li>
                                <li id="uppercase-check" class="flex items-center gap-2"><span class="w-4 h-4 rounded-full border border-gray-300 flex items-center justify-center text-[10px]">✓</span> Mengandung huruf besar (A-Z)</li>
                                <li id="lowercase-check" class="flex items-center gap-2"><span class="w-4 h-4 rounded-full border border-gray-300 flex items-center justify-center text-[10px]">✓</span> Mengandung huruf kecil (a-z)</li>
                                <li id="number-check" class="flex items-center gap-2"><span class="w-4 h-4 rounded-full border border-gray-300 flex items-center justify-center text-[10px]">✓</span> Mengandung angka (0-9)</li>
                            </ul>
                        </div>
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-900 mb-2">Konfirmasi Kata Sandi Baru</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password" class="w-full px-4 py-3 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white hover:border-gray-400" placeholder="Konfirmasi kata sandi baru">
                    </div>
                    <div class="flex gap-3 pt-6 border-t border-gray-200">
                        <button type="submit" class="flex-1 px-6 py-3 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-all shadow-sm hover:shadow-md flex items-center justify-center gap-2">Simpan Kata Sandi Baru</button>
                        <a href="{{ route('dashboard') }}" class="flex-1 px-6 py-3 bg-gray-100 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-200 transition-all flex items-center justify-center gap-2 border border-gray-300">Batal</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="mt-6 p-4 rounded-lg bg-blue-50 border border-blue-200">
            <div class="flex gap-3">
                <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                <div>
                    <p class="text-sm font-semibold text-blue-900 mb-1">Tips Keamanan</p>
                    <ul class="text-sm text-blue-800 space-y-1">
                        <li>• Gunakan kombinasi huruf besar, kecil, angka, dan simbol</li>
                        <li>• Jangan bagikan kata sandi Anda kepada siapapun</li>
                        <li>• Ubah kata sandi secara berkala untuk keamanan maksimal</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    const passwordField = document.getElementById('password');
    if (passwordField) {
        passwordField.addEventListener('input', function() {
            const pw = this.value;
            const checks = [
                ['length-check', pw.length >= 8],
                ['uppercase-check', /[A-Z]/.test(pw)],
                ['lowercase-check', /[a-z]/.test(pw)],
                ['number-check', /[0-9]/.test(pw)]
            ];
            checks.forEach(([id, pass]) => {
                const el = document.getElementById(id);
                el.querySelector('span').className = pass
                    ? 'w-4 h-4 rounded-full bg-green-500 flex items-center justify-center text-white text-[10px]'
                    : 'w-4 h-4 rounded-full border border-gray-300 flex items-center justify-center text-[10px]';
            });
        });
    }
</script>
@endpush
