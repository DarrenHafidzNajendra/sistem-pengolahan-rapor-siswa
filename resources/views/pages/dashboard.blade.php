@extends('layouts.app')

@section('title', 'Dashboard')

@section('body-attrs')
{{-- No extra body attrs needed --}}
@endsection

@push('head-scripts')
    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
    {{-- Dashboard Header --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Dashboard Overview</h1>
    </div>

    {{-- Statistics Cards --}}
    <div class="grid grid-cols-4 gap-6 mb-8">
        <x-stat-card label="Total Siswa" value="348"
            icon='<svg class="w-6 h-6 text-gray-500" fill="currentColor" viewBox="0 0 20 20"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path></svg>' />

        <x-stat-card label="Total Guru" value="98"
            icon='<svg class="w-6 h-6 text-gray-500" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path></svg>' />

        <x-stat-card label="Total Kelas" value="20"
            icon='<svg class="w-6 h-6 text-gray-500" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 012-2h4.586a2 2 0 011.414.586l7.071 7.071a2 2 0 010 2.828l-4.586 4.586a2 2 0 01-2.828 0l-7.071-7.071A2 2 0 014 9.586V4z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>' />

        <x-stat-card label="Total Mapel" value="38"
            icon='<svg class="w-6 h-6 text-gray-500" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"></path></svg>' />
    </div>

    {{-- Chart Cards --}}
    <div class="grid grid-cols-2 gap-6">
        <x-chart-card title="Tren Nilai rata - rata Siswa per Semester"
            icon='<svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20"><path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path></svg>'>
            <canvas id="trendChart" style="max-height: 250px;"></canvas>
        </x-chart-card>

        <x-chart-card title="Distribusi Nilai Siswa"
            icon='<svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>'>
            <canvas id="distribusiChart" style="max-height: 250px;"></canvas>
        </x-chart-card>

        <x-chart-card title="Kelengkapan Nilai"
            icon='<svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20"><path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path></svg>'>
            <canvas id="pieChart" style="max-height: 250px;"></canvas>
        </x-chart-card>

        <x-chart-card title="Nilai mapel per Kelas"
            icon='<svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>'>
            <div class="mb-4 flex gap-4">
                <select class="text-xs border border-gray-300 rounded px-3 py-2 text-gray-600">
                    <option>Pilih Jurusan</option>
                </select>
                <select class="text-xs border border-gray-300 rounded px-3 py-2 text-gray-600">
                    <option>Pilih Mapel</option>
                </select>
            </div>
            <canvas id="mapelChart" style="max-height: 200px;"></canvas>
        </x-chart-card>
    </div>
@endsection

@push('scripts')
    <script>
        // Trend Chart (Line Chart)
        const trendCtx = document.getElementById('trendChart').getContext('2d');
        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                datasets: [{
                    label: 'Rata-rata Nilai',
                    data: [30, 40, 35, 50, 75, 70, 65, 60, 55, 70, 85, 80],
                    borderColor: '#1f2937',
                    backgroundColor: 'rgba(31, 41, 55, 0.05)',
                    borderWidth: 2,
                    pointBackgroundColor: '#1f2937',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    tension: 0.3,
                    fill: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, max: 100, ticks: { stepSize: 10 }, grid: { drawBorder: false } },
                    x: { grid: { display: false } }
                }
            }
        });

        // Distribusi Chart (Bar Chart)
        const distribusiCtx = document.getElementById('distribusiChart').getContext('2d');
        new Chart(distribusiCtx, {
            type: 'bar',
            data: {
                labels: ['A', 'B', 'C', 'D', 'E'],
                datasets: [{ label: 'Jumlah Siswa', data: [40, 60, 70, 50, 25], backgroundColor: '#1f2937', borderRadius: 4 }]
            },
            options: {
                responsive: true, maintainAspectRatio: true,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, grid: { drawBorder: false } }, x: { grid: { display: false } } }
            }
        });

        // Pie Chart
        const pieCtx = document.getElementById('pieChart').getContext('2d');
        new Chart(pieCtx, {
            type: 'doughnut',
            data: {
                labels: ['Sudah di input', 'Belum di input'],
                datasets: [{ data: [70, 30], backgroundColor: ['#4b5563', '#d1d5db'], borderWidth: 0 }]
            },
            options: {
                responsive: true, maintainAspectRatio: true,
                plugins: { legend: { position: 'bottom', labels: { font: { size: 12 } } } }
            }
        });

        // Mapel Chart (Bar Chart)
        const mapelCtx = document.getElementById('mapelChart').getContext('2d');
        new Chart(mapelCtx, {
            type: 'bar',
            data: {
                labels: ['X IPA 1', 'X IPA 2', 'X IPA 3'],
                datasets: [{ label: 'Nilai', data: [65, 75, 85], backgroundColor: '#1f2937', borderRadius: 4 }]
            },
            options: {
                responsive: true, maintainAspectRatio: true, indexAxis: 'x',
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, grid: { drawBorder: false } }, x: { grid: { display: false } } }
            }
        });
    </script>
@endpush