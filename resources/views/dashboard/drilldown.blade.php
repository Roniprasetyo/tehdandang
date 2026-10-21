@extends('layouts.app')

@section('title', 'Tren Penjualan Bertingkat (Multi-Level Hierarchy)')

@section('content')
<div class="space-y-6" x-data="drilldownDashboard()">

    <!-- Top Headline & Info Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-xl border border-slate-200/90 shadow-xs">
        <div>
            @include('partials.breadcrumb')
            <h1 class="text-xl font-semibold text-slate-900">Tren Penjualan</h1>
            <p class="text-xs text-slate-500 mt-1">Analisis tren dan hierarki penjualan berjenjang dari tingkat nasional hingga produk</p>
        </div>
        
        <div class="flex items-center gap-2">
            <button 
                type="button"
                @click="goBack()" 
                :disabled="stack.length <= 1" 
                class="btn-secondary-outline" 
                :class="stack.length <= 1 ? 'opacity-50 cursor-not-allowed' : ''"
            >
                <i class="mdi mdi-arrow-left text-base"></i>
                <span>Kembali</span>
            </button>

            <button 
                type="button"
                @click="resetToTop()" 
                :disabled="stack.length <= 1" 
                class="btn-secondary-outline" 
                :class="stack.length <= 1 ? 'opacity-50 cursor-not-allowed' : ''"
            >
                <i class="mdi mdi-refresh text-base"></i>
                <span>Reset</span>
            </button>
        </div>
    </div>

    <!-- Breadcrumb Navigation Bar -->
    <nav aria-label="Breadcrumb" class="bg-white border border-slate-200/90 rounded-xl px-4 py-3 shadow-xs flex items-center flex-wrap gap-1.5 text-xs">
        <span class="text-slate-400 font-medium text-xs mr-1 flex items-center gap-1.5">
            <i class="mdi mdi-map-marker-path text-slate-400 text-sm"></i>
            <span>Hierarki:</span>
        </span>
        <template x-for="(item, index) in stack" :key="index">
            <div class="flex items-center gap-1.5">
                <template x-if="index > 0">
                    <i class="mdi mdi-chevron-right text-slate-300 text-sm"></i>
                </template>
                <button 
                    type="button"
                    @click="jumpToStack(index)" 
                    class="px-2.5 py-1 rounded-lg text-xs font-medium transition-colors flex items-center gap-1.5 active:translate-y-px"
                    :class="index === stack.length - 1 
                        ? 'bg-slate-100 text-slate-900 font-semibold border border-slate-200' 
                        : 'text-slate-600 hover:text-primary hover:bg-slate-50'"
                >
                    <span x-text="item.title"></span>
                    <span class="text-[10px] px-1.5 py-0.5 rounded font-mono tabular-nums"
                        :class="index === stack.length - 1 ? 'bg-slate-200 text-slate-700 font-semibold' : 'bg-slate-100 text-slate-500'" 
                        x-text="item.levelName"></span>
                </button>
            </div>
        </template>
    </nav>

    <!-- Active Level KPI Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <div class="bg-white border border-slate-200/90 rounded-xl p-5 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">LEVEL SAAT INI</span>
                <div class="w-8 h-8 rounded-lg bg-primary/10 text-primary flex items-center justify-center">
                    <i class="mdi mdi-layers-outline text-base"></i>
                </div>
            </div>
            <div class="text-xl font-bold text-slate-900 mt-2 truncate font-normal" x-text="currentLevelTitle"></div>
            <div class="text-[11px] text-primary font-semibold mt-1" x-text="currentLevelSubtitle"></div>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-xl p-5 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">TOTAL TARGET PENJUALAN</span>
                <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center">
                    <i class="mdi mdi-target text-base"></i>
                </div>
            </div>
            <div class="text-xl font-bold font-mono tabular-nums text-slate-900 mt-2" x-text="formatCurrency(totalTarget)"></div>
            <div class="text-[11px] text-slate-500 mt-1 font-mono tabular-nums" x-text="itemCount + ' item data'"></div>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-xl p-5 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">REALISASI PENJUALAN</span>
                <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center">
                    <i class="mdi mdi-cash text-base"></i>
                </div>
            </div>
            <div class="text-xl font-bold font-mono tabular-nums text-emerald-700 mt-2" x-text="formatCurrency(totalActual)"></div>
            <div class="text-[11px] font-bold mt-1 font-mono tabular-nums" :class="avgAchievement >= 100 ? 'text-emerald-700' : 'text-secondary'" x-text="'Capaian: ' + avgAchievement.toFixed(1) + '%'"></div>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-xl p-5 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">STATUS HIERARKI</span>
                <div class="w-8 h-8 rounded-lg bg-accent/10 text-accent flex items-center justify-center">
                    <i class="mdi mdi-layers-outline text-base"></i>
                </div>
            </div>
            <div class="text-xl font-bold font-mono tabular-nums text-slate-900 mt-2 flex items-center gap-2">
                <span x-text="'Tingkat ' + currentDepth + ' dari 7'"></span>
            </div>
            <div class="text-[11px] text-slate-500 mt-1 font-medium" x-text="isLowestLevel ? 'Level SKU Produk (Final)' : 'Level ' + stack[stack.length - 1].levelName"></div>
        </div>

    </div>

    <!-- Main Chart Box -->
    <div class="bg-white border border-slate-200/90 rounded-xl p-5 shadow-xs space-y-4">
        
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-4">
            <div>
                <h3 class="text-base font-semibold text-slate-900" x-text="'Grafik Penjualan: ' + currentLevelTitle"></h3>
                <p class="text-xs text-slate-500 mt-0.5" x-text="'Distribusi target dan realisasi penjualan tingkat ' + stack[stack.length - 1].levelName.toLowerCase()"></p>
            </div>

            <!-- Controls: Chart Switcher & Search -->
            <div class="flex items-center gap-2">
                <div class="bg-slate-100 p-1 rounded-xl flex items-center gap-1 text-xs">
                    <button type="button" @click="setChartType('bar')" class="px-2.5 py-1 rounded-lg font-bold transition-all active:translate-y-px" :class="chartType === 'bar' ? 'bg-white text-primary shadow-xs' : 'text-slate-600 hover:text-slate-900'">
                        Bar Vertikal
                    </button>
                    <button type="button" @click="setChartType('horizontalBar')" class="px-2.5 py-1 rounded-lg font-bold transition-all active:translate-y-px" :class="chartType === 'horizontalBar' ? 'bg-white text-primary shadow-xs' : 'text-slate-600 hover:text-slate-900'">
                        Bar Horizontal
                    </button>
                    <button type="button" @click="setChartType('doughnut')" class="px-2.5 py-1 rounded-lg font-bold transition-all active:translate-y-px" :class="chartType === 'doughnut' ? 'bg-white text-primary shadow-xs' : 'text-slate-600 hover:text-slate-900'">
                        Donut
                    </button>
                </div>
            </div>
        </div>

        <!-- Interactive Canvas Area -->
        <div class="relative h-96 w-full">
            <canvas id="multiLevelDrilldownChart"></canvas>
        </div>
    </div>

    <!-- Synchronized Detailed Data Table -->
    <div class="bg-white border border-slate-200/90 rounded-xl p-5 shadow-xs space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h3 class="text-sm font-semibold text-slate-900 flex items-center gap-2">
                    <i class="mdi mdi-table text-primary text-base"></i> Rincian Data: <span class="text-primary font-bold" x-text="currentLevelTitle"></span>
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">Metrik penjualan dan pertumbuhan per entitas</p>
            </div>
            
            <div class="w-full sm:w-64">
                <input type="text" x-model="searchQuery" placeholder="Cari nama area/sales/outlet..." class="w-full bg-slate-50 border border-slate-200 text-xs text-slate-800 rounded-xl px-3 py-2 focus:outline-none focus:border-primary font-medium">
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
                        <th class="py-3 px-4 text-right">Aksi</th>
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
                            <td class="py-3 px-4 text-slate-600 font-mono tabular-nums" x-text="formatCurrency(row.target)"></td>
                            <td class="py-3 px-4 font-bold text-slate-900 font-mono tabular-nums" x-text="formatCurrency(row.actual)"></td>
                            <td class="py-3 px-4 font-bold font-mono tabular-nums" :class="row.achievement >= 100 ? 'text-emerald-700' : (row.achievement >= 85 ? 'text-primary' : 'text-rose-700')">
                                <span x-text="row.achievement.toFixed(1) + '%'"></span>
                            </td>
                            <td class="py-3 px-4 font-semibold font-mono tabular-nums" :class="row.growth >= 0 ? 'text-emerald-700' : 'text-rose-700'">
                                <span x-text="(row.growth >= 0 ? '+' : '') + row.growth + '%'"></span>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium"
                                    :class="row.achievement >= 100 ? 'bg-primary-50 text-primary-700 border border-primary-200' : (row.achievement >= 85 ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'bg-rose-50 text-rose-700 border border-rose-200')">
                                    <span class="w-1.5 h-1.5 rounded-full mr-1.5"
                                        :class="row.achievement >= 100 ? 'bg-primary' : (row.achievement >= 85 ? 'bg-amber-500' : 'bg-rose-500')"></span>
                                    <span x-text="row.achievement >= 100 ? 'Tercapai' : (row.achievement >= 85 ? 'Waspada' : 'Kurang')"></span>
                                </span>
                            </td>
                            <td class="py-3 px-4 text-right">
                                <template x-if="!isLowestLevel">
                                    <button type="button" @click.stop="drillDownTo(row.label)" class="btn-primary text-xs inline-flex items-center gap-1 active:translate-y-px">
                                        <span>Drill Down</span>
                                        <i class="mdi mdi-chevron-right text-sm"></i>
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
                                Tidak ada data yang sesuai dengan pencarian "<span x-text="searchQuery"></span>".
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
                    { label: 'Jawa Tengah', target: 22500000000, actual: 24200000000, achievement: 107.5, growth: 14.2, color: '#10b981' },
                    { label: 'Jawa Timur', target: 18000000000, actual: 17100000000, achievement: 95.0, growth: 8.5, color: '#4f46e5' },
                    { label: 'Jawa Barat', target: 16500000000, actual: 14800000000, achievement: 89.7, growth: 4.1, color: '#f59e0b' },
                    { label: 'Banten & DKI Jakarta', target: 14000000000, actual: 13500000000, achievement: 96.4, growth: 7.8, color: '#06b6d4' },
                    { label: 'DIY Yogyakarta', target: 10000000000, actual: 8400000000, achievement: 84.0, growth: -2.3, color: '#ef4444' }
                ],
                children: {
                    'Jawa Tengah': {
                        title: 'Region Jawa Tengah',
                        levelName: 'Region',
                        depth: 2,
                        items: [
                            { label: 'Solo Raya', target: 7500000000, actual: 8250000000, achievement: 110.0, growth: 16.5, color: '#10b981' },
                            { label: 'Semarang Raya', target: 6000000000, actual: 6180000000, achievement: 103.0, growth: 11.2, color: '#6366f1' },
                            { label: 'Kedu Raya', target: 4500000000, actual: 4590000000, achievement: 102.0, growth: 9.8, color: '#0284c7' },
                            { label: 'Pati Raya', target: 2500000000, actual: 2900000000, achievement: 116.0, growth: 18.1, color: '#8b5cf6' },
                            { label: 'Banyumas Raya', target: 2000000000, actual: 2280000000, achievement: 114.0, growth: 15.0, color: '#14b8a6' }
                        ],
                        children: {
                            'Solo Raya': {
                                title: 'Area Solo Raya',
                                levelName: 'Area',
                                depth: 3,
                                items: [
                                    { label: 'Kab. Boyolali', target: 2200000000, actual: 2530000000, achievement: 115.0, growth: 18.5, color: '#10b981' },
                                    { label: 'Kota Surakarta (Solo)', target: 1800000000, actual: 1944000000, achievement: 108.0, growth: 12.0, color: '#4f46e5' },
                                    { label: 'Kab. Karanganyar', target: 1100000000, actual: 1177000000, achievement: 107.0, growth: 10.5, color: '#06b6d4' },
                                    { label: 'Kab. Sragen', target: 900000000, actual: 918000000, achievement: 102.0, growth: 8.2, color: '#8b5cf6' },
                                    { label: 'Kab. Sukoharjo', target: 800000000, actual: 848000000, achievement: 106.0, growth: 9.5, color: '#f59e0b' },
                                    { label: 'Kab. Klaten', target: 500000000, actual: 530000000, achievement: 106.0, growth: 7.0, color: '#ec4899' },
                                    { label: 'Kab. Wonogiri', target: 200000000, actual: 300000000, achievement: 150.0, growth: 35.0, color: '#84cc16' }
                                ],
                                children: {
                                    'Kab. Boyolali': {
                                        title: 'Kabupaten Boyolali',
                                        levelName: 'Kabupaten',
                                        depth: 4,
                                        items: [
                                            { label: 'Kec. Cepogo', target: 650000000, actual: 780000000, achievement: 120.0, growth: 22.0, color: '#10b981' },
                                            { label: 'Kec. Selo', target: 450000000, actual: 495000000, achievement: 110.0, growth: 14.5, color: '#3b82f6' },
                                            { label: 'Kec. Ampel', target: 400000000, actual: 440000000, achievement: 110.0, growth: 13.0, color: '#8b5cf6' },
                                            { label: 'Kec. Boyolali Kota', target: 350000000, actual: 385000000, achievement: 110.0, growth: 11.2, color: '#06b6d4' },
                                            { label: 'Kec. Musuk', target: 200000000, actual: 240000000, achievement: 120.0, growth: 19.0, color: '#f59e0b' },
                                            { label: 'Kec. Mojosongo', target: 150000000, actual: 190000000, achievement: 126.7, growth: 25.0, color: '#ec4899' }
                                        ],
                                        children: {
                                            'Kec. Cepogo': {
                                                title: 'Kecamatan Cepogo',
                                                levelName: 'Kecamatan',
                                                depth: 5,
                                                items: [
                                                    { label: 'Sales: Eko Prasetyo (Top)', target: 350000000, actual: 420000000, achievement: 120.0, growth: 24.0, color: '#10b981' },
                                                    { label: 'Sales: Agus Setiawan', target: 180000000, actual: 216000000, achievement: 120.0, growth: 18.0, color: '#6366f1' },
                                                    { label: 'Sales: Tri Widodo', target: 120000000, actual: 144000000, achievement: 120.0, growth: 15.0, color: '#f59e0b' }
                                                ],
                                                children: {
                                                    'Sales: Eko Prasetyo (Top)': {
                                                        title: 'Salesperson: Eko Prasetyo',
                                                        levelName: 'Salesperson',
                                                        depth: 6,
                                                        items: [
                                                            { label: 'Toko Berkah Cepogo', target: 120000000, actual: 150000000, achievement: 125.0, growth: 28.0, color: '#10b981' },
                                                            { label: 'UD Rezeki Subur', target: 90000000, actual: 105000000, achievement: 116.7, growth: 20.0, color: '#06b6d4' },
                                                            { label: 'Warung Makan Resto Bundo', target: 80000000, actual: 92000000, achievement: 115.0, growth: 16.0, color: '#8b5cf6' },
                                                            { label: 'Toko Sembako Barokah', target: 60000000, actual: 73000000, achievement: 121.7, growth: 22.0, color: '#f59e0b' }
                                                        ],
                                                        children: {
                                                            'Toko Berkah Cepogo': {
                                                                title: 'Outlet: Toko Berkah Cepogo',
                                                                levelName: 'Outlet (SKU)',
                                                                depth: 7,
                                                                isLowest: true,
                                                                items: [
                                                                    { label: 'Teh Dandang 2in1 25g', target: 45000000, actual: 55000000, achievement: 122.2, growth: 30.0, color: '#10b981' },
                                                                    { label: 'Teh Dandang Celup Black Tea', target: 35000000, actual: 40000000, achievement: 114.3, growth: 20.0, color: '#6366f1' },
                                                                    { label: 'Teh Dandang Hijau Jasmine', target: 25000000, actual: 30000000, achievement: 120.0, growth: 25.0, color: '#06b6d4' },
                                                                    { label: 'Teh Dandang Loose Leaf 500g', target: 10000000, actual: 15000000, achievement: 150.0, growth: 40.0, color: '#f59e0b' },
                                                                    { label: 'Teh Dandang Botol RTD 350ml', target: 5000000, actual: 10000000, achievement: 200.0, growth: 50.0, color: '#ec4899' }
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
                    }
                }
            },

            // Stack tracking path
            stack: [],

            init() {
                this.stack = [this.rawHierarchy];
                this.$nextTick(() => {
                    setTimeout(() => {
                        this.renderChart();
                    }, 50);
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
                return 'Klik pada batang grafik (bar) untuk melihat rincian tren penjualan level ' + (this.currentDepth + 1) + '.';
            },

            get isLowestLevel() {
                return !!this.currentLevel.isLowest || this.currentDepth >= 7;
            },

            get totalTarget() {
                return (this.currentLevel.items || []).reduce((acc, i) => acc + (i.target || 0), 0);
            },

            get totalActual() {
                return (this.currentLevel.items || []).reduce((acc, i) => acc + (i.actual || 0), 0);
            },

            get avgAchievement() {
                if (this.totalTarget === 0) return 0;
                return (this.totalActual / this.totalTarget) * 100;
            },

            get itemCount() {
                return (this.currentLevel.items || []).length;
            },

            get filteredRows() {
                const items = this.currentLevel.items || [];
                if (!this.searchQuery.trim()) {
                    return items;
                }
                const q = this.searchQuery.toLowerCase();
                return items.filter(i => i.label.toLowerCase().includes(q));
            },

            formatCurrency(val) {
                if (!val) return 'Rp 0';
                if (val >= 1000000000) {
                    return 'Rp ' + (val / 1000000000).toFixed(2) + ' M';
                } else if (val >= 1000000) {
                    return 'Rp ' + (val / 1000000).toFixed(1) + ' Jt';
                }
                return 'Rp ' + val.toLocaleString('id-ID');
            },

            getNextLevelName(currentName) {
                const levels = ['Nasional', 'Region', 'Area', 'Kabupaten', 'Kecamatan', 'Salesperson', 'Outlet (SKU)', 'Produk SKU'];
                const idx = levels.indexOf(currentName);
                if (idx !== -1 && idx < levels.length - 1) {
                    return levels[idx + 1];
                }
                return 'Detail SKU';
            },

            generateSubItems(parentLabel, nextLevelName, isLowest) {
                if (isLowest) {
                    return [
                        { label: 'Teh Dandang 2in1 25g', target: 45000000, actual: 55000000, achievement: 122.2, growth: 30.0, color: '#10b981' },
                        { label: 'Teh Dandang Celup Black Tea', target: 35000000, actual: 40000000, achievement: 114.3, growth: 20.0, color: '#6366f1' },
                        { label: 'Teh Dandang Hijau Jasmine', target: 25000000, actual: 30000000, achievement: 120.0, growth: 25.0, color: '#06b6d4' },
                        { label: 'Teh Dandang Loose Leaf 500g', target: 10000000, actual: 15000000, achievement: 150.0, growth: 40.0, color: '#f59e0b' },
                        { label: 'Teh Dandang Botol RTD 350ml', target: 5000000, actual: 10000000, achievement: 200.0, growth: 50.0, color: '#ec4899' }
                    ];
                }

                return [
                    { label: parentLabel + ' - Sektor Utara', target: 1200000000, actual: 1380000000, achievement: 115.0, growth: 14.0, color: '#10b981' },
                    { label: parentLabel + ' - Sektor Selatan', target: 950000000, actual: 1045000000, achievement: 110.0, growth: 12.0, color: '#6366f1' },
                    { label: parentLabel + ' - Sektor Timur', target: 800000000, actual: 840000000, achievement: 105.0, growth: 8.0, color: '#06b6d4' },
                    { label: parentLabel + ' - Sektor Barat', target: 600000000, actual: 630000000, achievement: 105.0, growth: 7.0, color: '#f59e0b' }
                ];
            },

            drillDownTo(label) {
                if (this.isLowestLevel) return;

                const node = this.currentLevel;
                let child = null;

                if (node && node.children && node.children[label]) {
                    child = node.children[label];
                } else {
                    const nextLevel = this.getNextLevelName(node.levelName);
                    const nextDepth = (node.depth || 1) + 1;
                    const isLowest = nextDepth >= 7;

                    child = {
                        title: node.levelName + ': ' + label,
                        levelName: nextLevel,
                        depth: nextDepth,
                        isLowest: isLowest,
                        items: this.generateSubItems(label, nextLevel, isLowest)
                    };
                }

                this.stack.push(child);
                this.searchQuery = '';

                this.$nextTick(() => {
                    setTimeout(() => {
                        this.renderChart();
                    }, 50);
                });
            },

            goBack() {
                if (this.stack.length > 1) {
                    this.stack.pop();
                    this.searchQuery = '';
                    this.$nextTick(() => {
                        setTimeout(() => {
                            this.renderChart();
                        }, 50);
                    });
                }
            },

            jumpToStack(index) {
                if (index >= 0 && index < this.stack.length) {
                    this.stack = this.stack.slice(0, index + 1);
                    this.searchQuery = '';
                    this.$nextTick(() => {
                        setTimeout(() => {
                            this.renderChart();
                        }, 50);
                    });
                }
            },

            resetToTop() {
                this.stack = [this.rawHierarchy];
                this.searchQuery = '';
                this.$nextTick(() => {
                    setTimeout(() => {
                        this.renderChart();
                    }, 50);
                });
            },

            setChartType(type) {
                this.chartType = type;
                this.$nextTick(() => {
                    setTimeout(() => {
                        this.renderChart();
                    }, 50);
                });
            },

            renderChart() {
                const canvas = document.getElementById('multiLevelDrilldownChart');
                if (!canvas) return;

                if (this.chartInstance) {
                    this.chartInstance.destroy();
                    this.chartInstance = null;
                }

                const items = this.currentLevel.items || [];
                if (items.length === 0) return;

                const labels = items.map(i => i.label);
                const actualData = items.map(i => i.actual / 1000000); // in Millions
                const targetData = items.map(i => i.target / 1000000);
                const bgColors = items.map(i => i.color || '#4f46e5');

                const isHorizontal = this.chartType === 'horizontalBar';
                const effectiveType = isHorizontal ? 'bar' : this.chartType;
                const self = this;

                const ctx = canvas.getContext('2d');

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
                                if (clickedLabel) {
                                    setTimeout(() => {
                                        self.drillDownTo(clickedLabel);
                                    }, 50);
                                }
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
                                        if (label) label += ': ';
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
