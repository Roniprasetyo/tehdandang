@extends('layouts.app')

@section('title', 'Grafik Drilldown Bertingkat (Multi-Level Hierarchy)')

@section('content')
<div class="space-y-6" x-data="drilldownDashboard()">

    <!-- Top Headline & Info Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 font-bold text-[11px] border border-emerald-200">
                    Interactive Drill-Down Chart
                </span>
                <span class="px-2.5 py-0.5 rounded-full bg-indigo-50 text-indigo-700 font-bold text-[11px] border border-indigo-200" x-text="'Depth: Level ' + currentDepth + ' dari 7'">
                </span>
            </div>
            <h1 class="text-xl font-bold font-display text-slate-900 mt-1 flex items-center gap-2">
                <i data-lucide="bar-chart-2" class="w-6 h-6 text-emerald-600"></i> Grafik Sales Multi-Level Drilldown
            </h1>
            <p class="text-xs text-slate-500 mt-0.5">
                Klik pada batang grafik (bar chart) atau baris tabel untuk masuk ke grafik detail level di bawahnya (Nasional ➔ Region ➔ Area ➔ Kabupaten ➔ Kecamatan ➔ Sales ➔ Outlet ➔ Produk SKU).
            </p>
        </div>
        
        <div class="flex items-center gap-2">
            <button @click="goBack()" :disabled="stack.length <= 1" class="px-3.5 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 border" :class="stack.length > 1 ? 'bg-indigo-50 text-indigo-700 border-indigo-200 hover:bg-indigo-100 shadow-xs' : 'bg-slate-100 text-slate-400 border-slate-200 opacity-50 cursor-not-allowed'">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                <span>Kembali 1 Level</span>
            </button>

            <button @click="resetToTop()" :disabled="stack.length <= 1" class="px-3.5 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 border" :class="stack.length > 1 ? 'bg-slate-100 text-slate-700 border-slate-200 hover:bg-slate-200' : 'bg-slate-50 text-slate-400 border-slate-200 opacity-50 cursor-not-allowed'">
                <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                <span>Reset Level 1</span>
            </button>
        </div>
    </div>

    <!-- Dynamic Breadcrumb Navigation Bar -->
    <div class="bg-white border border-slate-200/80 rounded-2xl p-4 shadow-xs flex items-center flex-wrap gap-2 text-xs">
        <span class="font-bold text-slate-400 uppercase text-[10px] tracking-wider mr-1">Hierarki Wilayah:</span>
        <template x-for="(item, index) in stack" :key="index">
            <div class="flex items-center gap-2">
                <template x-if="index > 0">
                    <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-400"></i>
                </template>
                <button 
                    @click="jumpToStack(index)" 
                    class="px-3 py-1.5 rounded-xl font-bold transition-all flex items-center gap-1.5 border text-xs"
                    :class="index === stack.length - 1 ? 'bg-emerald-600 text-white border-emerald-600 shadow-xs ring-2 ring-emerald-600/20' : 'bg-slate-50 text-slate-700 border-slate-200 hover:bg-slate-100 hover:border-slate-300'"
                >
                    <i data-lucide="map-pin" class="w-3 h-3" :class="index === stack.length - 1 ? 'text-white' : 'text-slate-400'"></i>
                    <span x-text="item.title"></span>
                    <span class="text-[10px] px-1.5 py-0.5 rounded-full" :class="index === stack.length - 1 ? 'bg-emerald-700 text-white' : 'bg-slate-200 text-slate-600'" x-text="item.levelName"></span>
                </button>
            </div>
        </template>
    </div>

    <!-- Active Level KPI Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">LEVEL SAAT INI</span>
                <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                    <i data-lucide="layers" class="w-4 h-4"></i>
                </div>
            </div>
            <div class="text-xl font-bold text-slate-900 mt-2 truncate" x-text="currentLevelTitle"></div>
            <div class="text-[11px] text-indigo-600 font-semibold mt-1" x-text="currentLevelSubtitle"></div>
        </div>

        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">TOTAL TARGET PENJUALAN</span>
                <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center">
                    <i data-lucide="target" class="w-4 h-4"></i>
                </div>
            </div>
            <div class="text-xl font-bold text-slate-900 mt-2" x-text="formatCurrency(totalTarget)"></div>
            <div class="text-[11px] text-slate-500 mt-1" x-text="itemCount + ' item data'"></div>
        </div>

        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">REALISASI PENJUALAN</span>
                <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <i data-lucide="dollar-sign" class="w-4 h-4"></i>
                </div>
            </div>
            <div class="text-xl font-bold text-emerald-700 mt-2" x-text="formatCurrency(totalActual)"></div>
            <div class="text-[11px] font-bold mt-1" :class="avgAchievement >= 100 ? 'text-emerald-600' : 'text-amber-600'" x-text="'Capaian: ' + avgAchievement.toFixed(1) + '%'"></div>
        </div>

        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">STATUS HIERARKI</span>
                <div class="w-8 h-8 rounded-lg bg-cyan-50 text-cyan-600 flex items-center justify-center">
                    <i data-lucide="info" class="w-4 h-4"></i>
                </div>
            </div>
            <div class="text-lg font-bold mt-2 flex items-center gap-2">
                <span x-text="isLowestLevel ? '🏆 Level Terbawah' : '📊 Level ' + currentDepth + ' (Bisa Click Bar)'" :class="isLowestLevel ? 'text-amber-600' : 'text-indigo-600'"></span>
            </div>
            <div class="text-[11px] text-slate-500 mt-1" x-text="isLowestLevel ? 'Detail SKU Produk Selesai' : 'Klik batang bar untuk drill down'"></div>
        </div>

    </div>

    <!-- Main Chart Box -->
    <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs space-y-4">
        
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-4">
            <div>
                <div class="flex items-center gap-2">
                    <h3 class="text-base font-bold text-slate-900" x-text="'Grafik Penjualan: ' + currentLevelTitle"></h3>
                    <span x-show="!isLowestLevel" class="animate-pulse bg-emerald-100 text-emerald-700 text-[10px] px-2 py-0.5 rounded-full font-bold border border-emerald-200">
                        👉 Clickable Bar Active
                    </span>
                    <span x-show="isLowestLevel" class="bg-amber-100 text-amber-800 text-[10px] px-2 py-0.5 rounded-full font-bold border border-amber-200">
                        🔒 Level Terbawah (SKU Breakdown)
                    </span>
                </div>
                <p class="text-xs text-slate-500 mt-0.5" x-text="chartSubtitleInstruction"></p>
            </div>

            <!-- Controls: Chart Switcher & Search -->
            <div class="flex items-center gap-2">
                <div class="bg-slate-100 p-1 rounded-xl flex items-center gap-1 text-xs">
                    <button @click="setChartType('bar')" class="px-2.5 py-1 rounded-lg font-bold transition-all" :class="chartType === 'bar' ? 'bg-white text-indigo-600 shadow-xs' : 'text-slate-600 hover:text-slate-900'">
                        Bar Vertikal
                    </button>
                    <button @click="setChartType('horizontalBar')" class="px-2.5 py-1 rounded-lg font-bold transition-all" :class="chartType === 'horizontalBar' ? 'bg-white text-indigo-600 shadow-xs' : 'text-slate-600 hover:text-slate-900'">
                        Bar Horizontal
                    </button>
                    <button @click="setChartType('doughnut')" class="px-2.5 py-1 rounded-lg font-bold transition-all" :class="chartType === 'doughnut' ? 'bg-white text-indigo-600 shadow-xs' : 'text-slate-600 hover:text-slate-900'">
                        Donut
                    </button>
                </div>
            </div>
        </div>

        <!-- Interactive Canvas Area -->
        <div class="relative h-96 w-full">
            <canvas id="multiLevelDrilldownChart"></canvas>
        </div>

        <div class="bg-indigo-50/70 border border-indigo-100 rounded-xl p-3 text-xs text-indigo-800 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i data-lucide="pointer" class="w-4 h-4 text-indigo-600 animate-bounce"></i>
                <span class="font-medium">Petunjuk: Klik pada salah satu **batang grafik (Bar)** untuk menggali grafik detail ke tingkat lebih dalam!</span>
            </div>
            <span class="text-[11px] font-bold bg-white px-2.5 py-1 rounded-lg text-indigo-600 border border-indigo-200" x-text="'Tingkat: ' + stack[stack.length - 1].levelName"></span>
        </div>
    </div>

    <!-- Synchronized Detailed Data Table -->
    <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                    <i data-lucide="table" class="w-4 h-4 text-indigo-600"></i> Data Sinkronisasi Tabel Level: <span class="text-indigo-600" x-text="currentLevelTitle"></span>
                </h3>
                <p class="text-xs text-slate-500">Anda juga dapat mengklik tombol "Drill Down" atau baris tabel untuk menelusuri data.</p>
            </div>
            
            <div class="w-full sm:w-64">
                <input type="text" x-model="searchQuery" placeholder="Cari nama area/sales/outlet..." class="w-full bg-slate-50 border border-slate-200 text-xs text-slate-800 rounded-xl px-3 py-2 focus:outline-none focus:border-indigo-500 font-medium">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-4">Nama (Wilayah / Outlet / SKU)</th>
                        <th class="py-3 px-4">Target Penjualan</th>
                        <th class="py-3 px-4">Realisasi (Actual)</th>
                        <th class="py-3 px-4">Capaian (%)</th>
                        <th class="py-3 px-4">Growth (MoM)</th>
                        <th class="py-3 px-4 text-center">Status</th>
                        <th class="py-3 px-4 text-right">Aksi Drilldown</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <template x-for="(row, idx) in filteredRows" :key="idx">
                        <tr 
                            @click="!isLowestLevel ? drillDownTo(row.label) : null" 
                            class="transition-colors group"
                            :class="!isLowestLevel ? 'hover:bg-emerald-50/60 cursor-pointer' : 'hover:bg-slate-50'"
                        >
                            <td class="py-3 px-4 font-bold text-slate-900 flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full" :style="'background-color: ' + row.color"></span>
                                <span x-text="row.label"></span>
                                <template x-if="row.achievement >= 110">
                                    <span class="px-1.5 py-0.5 rounded text-[9px] bg-emerald-600 text-white font-bold">Top</span>
                                </template>
                            </td>
                            <td class="py-3 px-4 text-slate-600" x-text="formatCurrency(row.target)"></td>
                            <td class="py-3 px-4 font-bold text-slate-900" x-text="formatCurrency(row.actual)"></td>
                            <td class="py-3 px-4 font-bold" :class="row.achievement >= 100 ? 'text-emerald-600' : (row.achievement >= 85 ? 'text-indigo-600' : 'text-rose-600')">
                                <span x-text="row.achievement.toFixed(1) + '%'"></span>
                            </td>
                            <td class="py-3 px-4 font-semibold" :class="row.growth >= 0 ? 'text-emerald-600' : 'text-rose-600'">
                                <span x-text="(row.growth >= 0 ? '+' : '') + row.growth + '%'"></span>
                            </td>
                            <td class="py-3 px-4 text-center text-sm" x-text="row.statusEmoji"></td>
                            <td class="py-3 px-4 text-right">
                                <template x-if="!isLowestLevel">
                                    <button @click.stop="drillDownTo(row.label)" class="inline-flex items-center gap-1 text-xs px-3 py-1 rounded-xl bg-emerald-600 text-white hover:bg-emerald-700 font-bold shadow-xs transition-all group-hover:scale-105">
                                        <span>Drill Down</span>
                                        <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                                    </button>
                                </template>
                                <template x-if="isLowestLevel">
                                    <span class="text-[11px] text-slate-400 font-semibold px-2 py-1 rounded bg-slate-100">Lowest Reached</span>
                                </template>
                            </td>
                        </tr>
                    </template>
                    <template x-if="filteredRows.length === 0">
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400">
                                Tidak ada data yang sesuai dengan pencarian "{{ searchQuery }}".
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    function drilldownDashboard() {
        return {
            searchQuery: '',
            chartType: 'bar',
            chartInstance: null,

            // Multi-level Data Hierarchy Trees (Level 1 to Level 7)
            rawHierarchy: {
                title: 'Nasional (PT. Kartini Teh Nasional)',
                levelName: 'Nasional',
                depth: 1,
                items: [
                    { label: 'Jawa Tengah', target: 22500000000, actual: 24200000000, achievement: 107.5, growth: 14.2, statusEmoji: '🟢', color: '#10b981' },
                    { label: 'Jawa Timur', target: 18000000000, actual: 17100000000, achievement: 95.0, growth: 8.5, statusEmoji: '🟢', color: '#4f46e5' },
                    { label: 'Jawa Barat', target: 16500000000, actual: 14800000000, achievement: 89.7, growth: 4.1, statusEmoji: '🟡', color: '#f59e0b' },
                    { label: 'Banten & DKI Jakarta', target: 14000000000, actual: 13500000000, achievement: 96.4, growth: 7.8, statusEmoji: '🟢', color: '#06b6d4' },
                    { label: 'DIY Yogyakarta', target: 10000000000, actual: 8400000000, achievement: 84.0, growth: -2.3, statusEmoji: '🔴', color: '#ef4444' }
                ],
                children: {
                    'Jawa Tengah': {
                        title: 'Region Jawa Tengah',
                        levelName: 'Region',
                        depth: 2,
                        items: [
                            { label: 'Solo Raya', target: 7500000000, actual: 8250000000, achievement: 110.0, growth: 16.5, statusEmoji: '🟢', color: '#10b981' },
                            { label: 'Semarang Raya', target: 6000000000, actual: 6180000000, achievement: 103.0, growth: 11.2, statusEmoji: '🟢', color: '#6366f1' },
                            { label: 'Kedu Raya', target: 4500000000, actual: 4590000000, achievement: 102.0, growth: 9.8, statusEmoji: '🟢', color: '#0284c7' },
                            { label: 'Pati Raya', target: 2500000000, actual: 2900000000, achievement: 116.0, growth: 18.1, statusEmoji: '🟢', color: '#8b5cf6' },
                            { label: 'Banyumas Raya', target: 2000000000, actual: 2280000000, achievement: 114.0, growth: 15.0, statusEmoji: '🟢', color: '#14b8a6' }
                        ],
                        children: {
                            'Solo Raya': {
                                title: 'Area Solo Raya',
                                levelName: 'Area',
                                depth: 3,
                                items: [
                                    { label: 'Kab. Boyolali', target: 2200000000, actual: 2530000000, achievement: 115.0, growth: 18.5, statusEmoji: '🟢', color: '#10b981' },
                                    { label: 'Kota Surakarta (Solo)', target: 1800000000, actual: 1944000000, achievement: 108.0, growth: 12.0, statusEmoji: '🟢', color: '#4f46e5' },
                                    { label: 'Kab. Karanganyar', target: 1100000000, actual: 1177000000, achievement: 107.0, growth: 10.5, statusEmoji: '🟢', color: '#06b6d4' },
                                    { label: 'Kab. Sragen', target: 900000000, actual: 918000000, achievement: 102.0, growth: 8.2, statusEmoji: '🟢', color: '#8b5cf6' },
                                    { label: 'Kab. Sukoharjo', target: 800000000, actual: 848000000, achievement: 106.0, growth: 9.5, statusEmoji: '🟢', color: '#f59e0b' },
                                    { label: 'Kab. Klaten', target: 500000000, actual: 530000000, achievement: 106.0, growth: 7.0, statusEmoji: '🟢', color: '#ec4899' },
                                    { label: 'Kab. Wonogiri', target: 200000000, actual: 300000000, achievement: 150.0, growth: 35.0, statusEmoji: '🟢', color: '#84cc16' }
                                ],
                                children: {
                                    'Kab. Boyolali': {
                                        title: 'Kabupaten Boyolali',
                                        levelName: 'Kabupaten',
                                        depth: 4,
                                        items: [
                                            { label: 'Kec. Cepogo', target: 650000000, actual: 780000000, achievement: 120.0, growth: 22.0, statusEmoji: '🟢', color: '#10b981' },
                                            { label: 'Kec. Selo', target: 450000000, actual: 495000000, achievement: 110.0, growth: 14.5, statusEmoji: '🟢', color: '#3b82f6' },
                                            { label: 'Kec. Ampel', target: 400000000, actual: 440000000, achievement: 110.0, growth: 13.0, statusEmoji: '🟢', color: '#8b5cf6' },
                                            { label: 'Kec. Boyolali Kota', target: 350000000, actual: 385000000, achievement: 110.0, growth: 11.2, statusEmoji: '🟢', color: '#06b6d4' },
                                            { label: 'Kec. Musuk', target: 200000000, actual: 240000000, achievement: 120.0, growth: 19.0, statusEmoji: '🟢', color: '#f59e0b' },
                                            { label: 'Kec. Mojosongo', target: 150000000, actual: 190000000, achievement: 126.7, growth: 25.0, statusEmoji: '🟢', color: '#ec4899' }
                                        ],
                                        children: {
                                            'Kec. Cepogo': {
                                                title: 'Kecamatan Cepogo',
                                                levelName: 'Kecamatan',
                                                depth: 5,
                                                items: [
                                                    { label: 'Sales: Eko Prasetyo (Top)', target: 350000000, actual: 420000000, achievement: 120.0, growth: 24.0, statusEmoji: '🟢', color: '#10b981' },
                                                    { label: 'Sales: Agus Setiawan', target: 180000000, actual: 216000000, achievement: 120.0, growth: 18.0, statusEmoji: '🟢', color: '#6366f1' },
                                                    { label: 'Sales: Tri Widodo', target: 120000000, actual: 144000000, achievement: 120.0, growth: 15.0, statusEmoji: '🟢', color: '#f59e0b' }
                                                ],
                                                children: {
                                                    'Sales: Eko Prasetyo (Top)': {
                                                        title: 'Salesperson: Eko Prasetyo',
                                                        levelName: 'Salesperson',
                                                        depth: 6,
                                                        items: [
                                                            { label: 'Toko Berkah Cepogo', target: 120000000, actual: 150000000, achievement: 125.0, growth: 28.0, statusEmoji: '🟢', color: '#10b981' },
                                                            { label: 'UD Rezeki Subur', target: 90000000, actual: 105000000, achievement: 116.7, growth: 20.0, statusEmoji: '🟢', color: '#06b6d4' },
                                                            { label: 'Warung Makan Resto Bundo', target: 80000000, actual: 92000000, achievement: 115.0, growth: 16.0, statusEmoji: '🟢', color: '#8b5cf6' },
                                                            { label: 'Toko Sembako Barokah', target: 60000000, actual: 73000000, achievement: 121.7, growth: 22.0, statusEmoji: '🟢', color: '#f59e0b' }
                                                        ],
                                                        children: {
                                                            'Toko Berkah Cepogo': {
                                                                title: 'Outlet: Toko Berkah Cepogo',
                                                                levelName: 'Outlet (SKU)',
                                                                depth: 7,
                                                                isLowest: true,
                                                                items: [
                                                                    { label: 'Teh Dandang 2in1 25g', target: 45000000, actual: 55000000, achievement: 122.2, growth: 30.0, statusEmoji: '🟢', color: '#10b981' },
                                                                    { label: 'Teh Dandang Celup Black Tea', target: 35000000, actual: 40000000, achievement: 114.3, growth: 20.0, statusEmoji: '🟢', color: '#6366f1' },
                                                                    { label: 'Teh Dandang Hijau Jasmine', target: 25000000, actual: 30000000, achievement: 120.0, growth: 25.0, statusEmoji: '🟢', color: '#06b6d4' },
                                                                    { label: 'Teh Dandang Loose Leaf 500g', target: 10000000, actual: 15000000, achievement: 150.0, growth: 40.0, statusEmoji: '🟢', color: '#f59e0b' },
                                                                    { label: 'Teh Dandang Botol RTD 350ml', target: 5000000, actual: 10000000, achievement: 200.0, growth: 50.0, statusEmoji: '🟢', color: '#ec4899' }
                                                                ]
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    },
                    'Jawa Timur': {
                        title: 'Region Jawa Timur',
                        levelName: 'Region',
                        depth: 2,
                        items: [
                            { label: 'Surabaya Raya', target: 8000000000, actual: 7600000000, achievement: 95.0, growth: 8.0, statusEmoji: '🟢', color: '#4f46e5' },
                            { label: 'Malang Raya', target: 5000000000, actual: 4850000000, achievement: 97.0, growth: 9.2, statusEmoji: '🟢', color: '#10b981' },
                            { label: 'Kediri & Madiun', target: 5000000000, actual: 4650000000, achievement: 93.0, growth: 7.5, statusEmoji: '🟡', color: '#f59e0b' }
                        ]
                    },
                    'Jawa Barat': {
                        title: 'Region Jawa Barat',
                        levelName: 'Region',
                        depth: 2,
                        items: [
                            { label: 'Bandung Raya', target: 7000000000, actual: 6300000000, achievement: 90.0, growth: 5.0, statusEmoji: '🟢', color: '#06b6d4' },
                            { label: 'Bogor & Depok', target: 5500000000, actual: 4950000000, achievement: 90.0, growth: 4.5, statusEmoji: '🟢', color: '#6366f1' },
                            { label: 'Cirebon & Karawang', target: 4000000000, actual: 3550000000, achievement: 88.8, growth: 3.2, statusEmoji: '🟡', color: '#f59e0b' }
                        ]
                    }
                }
            },

            // Stack tracking path
            stack: [],

            init() {
                // Initialize level 1
                this.stack = [this.rawHierarchy];
                this.$nextTick(() => {
                    this.renderChart();
                });
            },

            get currentLevel() {
                return this.stack[this.stack.length - 1];
            },

            get currentDepth() {
                return this.currentLevel.depth || this.stack.length;
            },

            get currentLevelTitle() {
                return this.currentLevel.title;
            },

            get currentLevelSubtitle() {
                return 'Tingkat Hierarki: ' + this.currentLevel.levelName;
            },

            get chartSubtitleInstruction() {
                if (this.isLowestLevel) {
                    return 'Ini adalah level terbawah (Rincian Produk SKU). Anda sudah melihat detail paling spesifik.';
                }
                return 'Klik pada batang grafik (bar) untuk drilldown masuk ke level ' + (this.currentDepth + 1) + '.';
            },

            get isLowestLevel() {
                return !!this.currentLevel.isLowest || !this.currentLevel.children;
            },

            get totalTarget() {
                return this.currentLevel.items.reduce((acc, i) => acc + i.target, 0);
            },

            get totalActual() {
                return this.currentLevel.items.reduce((acc, i) => acc + i.actual, 0);
            },

            get avgAchievement() {
                if (this.totalTarget === 0) return 0;
                return (this.totalActual / this.totalTarget) * 100;
            },

            get itemCount() {
                return this.currentLevel.items.length;
            },

            get filteredRows() {
                if (!this.searchQuery.trim()) {
                    return this.currentLevel.items;
                }
                const q = this.searchQuery.toLowerCase();
                return this.currentLevel.items.filter(i => i.label.toLowerCase().includes(q));
            },

            formatCurrency(val) {
                if (val >= 1000000000) {
                    return 'Rp ' + (val / 1000000000).toFixed(2) + ' M';
                } else if (val >= 1000000) {
                    return 'Rp ' + (val / 1000000).toFixed(1) + ' Jt';
                }
                return 'Rp ' + val.toLocaleString('id-ID');
            },

            drillDownTo(label) {
                const node = this.currentLevel;
                if (!node.children || !node.children[label]) {
                    // Generates dynamic placeholder sub-level data if deep explicit tree node isn't defined
                    const dynamicChild = {
                        title: label,
                        levelName: this.getNextLevelName(node.levelName),
                        depth: node.depth + 1,
                        isLowest: node.depth >= 6,
                        items: [
                            { label: label + ' - Sektor A', target: 500000000, actual: 580000000, achievement: 116.0, growth: 14.0, statusEmoji: '🟢', color: '#10b981' },
                            { label: label + ' - Sektor B', target: 400000000, actual: 440000000, achievement: 110.0, growth: 12.0, statusEmoji: '🟢', color: '#6366f1' },
                            { label: label + ' - Sektor C', target: 300000000, actual: 315000000, achievement: 105.0, growth: 8.0, statusEmoji: '🟢', color: '#06b6d4' }
                        ]
                    };
                    this.stack.push(dynamicChild);
                } else {
                    this.stack.push(node.children[label]);
                }
                this.searchQuery = '';
                this.$nextTick(() => {
                    this.renderChart();
                });
            },

            getNextLevelName(currentName) {
                const levels = ['Nasional', 'Region', 'Area', 'Kabupaten', 'Kecamatan', 'Salesperson', 'Outlet (SKU)'];
                const idx = levels.indexOf(currentName);
                if (idx !== -1 && idx < levels.length - 1) {
                    return levels[idx + 1];
                }
                return 'Sub-Detail';
            },

            goBack() {
                if (this.stack.length > 1) {
                    this.stack.pop();
                    this.searchQuery = '';
                    this.$nextTick(() => {
                        this.renderChart();
                    });
                }
            },

            jumpToStack(index) {
                if (index >= 0 && index < this.stack.length) {
                    this.stack = this.stack.slice(0, index + 1);
                    this.searchQuery = '';
                    this.$nextTick(() => {
                        this.renderChart();
                    });
                }
            },

            resetToTop() {
                this.stack = [this.rawHierarchy];
                this.searchQuery = '';
                this.$nextTick(() => {
                    this.renderChart();
                });
            },

            setChartType(type) {
                this.chartType = type;
                this.renderChart();
            },

            renderChart() {
                const ctx = document.getElementById('multiLevelDrilldownChart').getContext('2d');
                if (this.chartInstance) {
                    this.chartInstance.destroy();
                }

                const items = this.currentLevel.items;
                const labels = items.map(i => i.label);
                const actualData = items.map(i => i.actual / 1000000); // in Millions
                const targetData = items.map(i => i.target / 1000000);
                const bgColors = items.map(i => i.color);

                const isHorizontal = this.chartType === 'horizontalBar';
                const effectiveType = isHorizontal ? 'bar' : this.chartType;

                const self = this;

                this.chartInstance = new Chart(ctx, {
                    type: effectiveType,
                    data: {
                        labels: labels,
                        datasets: effectiveType === 'doughnut' ? [
                            {
                                label: 'Realisasi Penjualan (Juta Rp)',
                                data: actualData,
                                backgroundColor: bgColors,
                                hoverOffset: 8
                            }
                        ] : [
                            {
                                label: 'Realisasi (Actual) Juta Rp',
                                data: actualData,
                                backgroundColor: bgColors,
                                borderRadius: 8,
                                borderWidth: 0
                            },
                            {
                                label: 'Target Penjualan (Juta Rp)',
                                data: targetData,
                                backgroundColor: 'rgba(148, 163, 184, 0.25)',
                                borderColor: '#94a3b8',
                                borderWidth: 1,
                                borderRadius: 8
                            }
                        ]
                    },
                    options: {
                        indexAxis: isHorizontal ? 'y' : 'x',
                        responsive: true,
                        maintainAspectRatio: false,
                        onClick: (evt, elements) => {
                            if (elements && elements.length > 0 && !self.isLowestLevel) {
                                const index = elements[0].index;
                                const clickedLabel = labels[index];
                                self.drillDownTo(clickedLabel);
                            }
                        },
                        plugins: {
                            legend: {
                                display: true,
                                labels: { color: '#475569', font: { size: 11, family: 'Plus Jakarta Sans' } }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        let label = context.dataset.label || '';
                                        if (label) {
                                            label += ': ';
                                        }
                                        if (context.parsed.y !== null || context.parsed.x !== null) {
                                            const val = isHorizontal ? context.parsed.x : (context.parsed.y ?? context.parsed);
                                            label += 'Rp ' + val.toLocaleString('id-ID') + ' Juta';
                                        }
                                        return label;
                                    }
                                }
                            }
                        },
                        scales: effectiveType === 'doughnut' ? {} : {
                            x: { ticks: { color: '#64748b', font: { size: 11 } }, grid: { color: '#f1f5f9' } },
                            y: { ticks: { color: '#64748b', font: { size: 11 } }, grid: { color: '#f1f5f9' } }
                        }
                    }
                });
            }
        }
    }
</script>
@endpush
