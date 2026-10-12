@extends('layouts.app')

@section('title', 'Area Performance & Hierarchy')

@section('content')
<div class="space-y-6" x-data="{ 
    activeRegion: 'Jawa Tengah', 
    activeArea: 'Solo Raya', 
    activeKab: 'All',
    activeKec: 'All'
}">

    <!-- Top Headline & Info -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-xl border border-slate-200/90 shadow-xs">
        <div>
            <h1 class="text-xl font-semibold text-slate-900 flex items-center gap-2">
                <i class="mdi mdi-layers-outline text-primary text-2xl"></i> Performa Wilayah
            </h1>
            <p class="text-xs text-slate-500 mt-1">Rincian performa penjualan dan distribusi per wilayah kerja</p>
        </div>
        <div class="flex items-center gap-2 text-xs">
            <a href="{{ route('dashboard.drilldown') }}" class="btn-primary">
                <i class="mdi mdi-chart-box-outline text-base"></i>
                <span>Grafik Drilldown</span>
            </a>
        </div>
    </div>

    <!-- Top Cascading Multi-Level Navigation Bar -->
    <div class="bg-white border border-slate-200/90 rounded-xl p-5 shadow-xs space-y-4">
        
        <!-- Level 1: Region Selection Tabs -->
        <div>
            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-2">REGION</span>
            <div class="flex flex-wrap gap-2">
                @foreach($areas as $r)
                <button 
                    type="button"
                    @click="activeRegion = '{{ $r['region'] }}'; activeArea = '{{ $r['areas'][0]['name'] ?? '' }}'; activeKab = 'All'; activeKec = 'All'"
                    class="px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2 active:translate-y-px"
                    :class="activeRegion === '{{ $r['region'] }}' ? 'bg-primary text-white shadow-md shadow-emerald-900/10' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'"
                >
                    <i class="mdi mdi-map-marker text-base"></i>
                    <span>{{ $r['region'] }}</span>
                    <span class="px-1.5 py-0.5 rounded text-[10px] font-mono tabular-nums" :class="activeRegion === '{{ $r['region'] }}' ? 'bg-emerald-800 text-white' : 'bg-slate-200 text-slate-600'">{{ count($r['areas']) }} Area</span>
                </button>
                @endforeach
            </div>
        </div>

        <!-- Level 2: Area Selection Cards under Active Region -->
        @foreach($areas as $r)
        <div x-show="activeRegion === '{{ $r['region'] }}'" class="space-y-2 pt-2 border-t border-slate-100">
            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">AREA ({{ strtoupper($r['region']) }})</span>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2.5">
                @foreach($r['areas'] as $a)
                <button 
                    type="button"
                    @click="activeArea = '{{ $a['name'] }}'; activeKab = 'All'; activeKec = 'All'"
                    class="p-3 rounded-xl border text-left transition-all flex flex-col justify-between active:translate-y-px"
                    :class="activeArea === '{{ $a['name'] }}' ? 'bg-primary/10 border-primary ring-2 ring-primary/20 shadow-xs' : 'bg-slate-50 border-slate-200/90 hover:bg-slate-100/80'"
                >
                    <div class="flex items-start justify-between gap-2">
                        <span class="text-xs font-semibold text-slate-900 leading-snug">{{ $a['name'] }}</span>
                        <span class="w-2 h-2 rounded-full mt-1 {{ ($a['achievement'] ?? 0) >= 100 ? 'bg-primary' : 'bg-amber-500' }}"></span>
                    </div>
                    <div class="mt-2 flex items-center justify-between text-[11px] font-mono tabular-nums">
                        <span class="text-slate-500 font-sans">Achievement:</span>
                        <span class="font-bold {{ ($a['achievement'] ?? 0) >= 100 ? 'text-emerald-700' : 'text-primary' }}">{{ $a['achievement'] }}%</span>
                    </div>
                </button>
                @endforeach
            </div>
        </div>
        @endforeach

        <!-- Level 3 & 4: Kabupaten & Kecamatan Filter Controls -->
        @foreach($areas as $r)
            @foreach($r['areas'] as $a)
            <div x-show="activeRegion === '{{ $r['region'] }}' && activeArea === '{{ $a['name'] }}'" class="pt-3 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3 text-xs">
                <div class="flex flex-wrap items-center gap-3">
                    <!-- Kabupaten Dropdown -->
                    <div class="flex items-center gap-2">
                        <label class="text-slate-500 font-bold">Kabupaten:</label>
                        <select x-model="activeKab" @change="activeKec = 'All'" class="bg-slate-50 border border-slate-200 text-slate-800 rounded-xl px-3 py-1.5 focus:outline-none focus:border-primary font-semibold">
                            <option value="All">Semua Kabupaten</option>
                            @foreach($a['kabupaten'] as $kab)
                            <option value="{{ $kab['name'] }}">{{ $kab['name'] }} ({{ count($kab['kecamatan']) }} Kec)</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Kecamatan Dropdown -->
                    <div class="flex items-center gap-2">
                        <label class="text-slate-500 font-bold">Kecamatan:</label>
                        <select x-model="activeKec" class="bg-slate-50 border border-slate-200 text-slate-800 rounded-xl px-3 py-1.5 focus:outline-none focus:border-primary font-semibold">
                            <option value="All">Semua Kecamatan</option>
                            @foreach($a['kabupaten'] as $kab)
                                @foreach($kab['kecamatan'] as $kec)
                                <option x-show="activeKab === 'All' || activeKab === '{{ $kab['name'] }}'" value="{{ $kec['name'] }}">{{ $kec['name'] }} ({{ $kab['name'] }})</option>
                                @endforeach
                            @endforeach
                        </select>
                    </div>
                </div>

                <button type="button" @click="activeKab = 'All'; activeKec = 'All'" class="px-3 py-1.5 rounded-xl bg-slate-100 text-slate-700 hover:bg-slate-200 font-semibold text-xs active:translate-y-px">
                    Reset Filter Wilayah
                </button>
            </div>
            @endforeach
        @endforeach

    </div>

    <!-- Active Area Summary Panel (Full Width) -->
    @foreach($areas as $r)
        @foreach($r['areas'] as $a)
        <div x-show="activeRegion === '{{ $r['region'] }}' && activeArea === '{{ $a['name'] }}'" class="space-y-6">
            
            <!-- Main Metrics Card -->
            <div class="bg-white border border-slate-200/90 rounded-xl p-5 shadow-xs space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between border-b border-slate-100 pb-3 gap-2">
                    <div>
                        <span class="text-[11px] text-slate-400 font-medium uppercase tracking-wider">{{ $r['region'] }} &rarr; Area: {{ $a['name'] }}</span>
                        <h2 class="text-lg font-semibold text-slate-900">{{ $a['name'] }}</h2>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium border {{ str_contains($a['status'] ?? '', 'Good') ? 'bg-primary-50 text-primary-700 border-primary-200' : (str_contains($a['status'] ?? '', 'Warning') ? 'bg-amber-50 text-amber-700 border-amber-200' : 'bg-rose-50 text-rose-700 border-rose-200') }}">
                            <i class="mdi {{ str_contains($a['status'] ?? '', 'Good') ? 'mdi-check-circle-outline' : 'mdi-alert-circle-outline' }} mr-1"></i>
                            <span>Status: {{ $a['status'] }}</span>
                        </span>
                    </div>
                </div>

                <!-- 4 Top KPI Stat Cards -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200/60">
                        <span class="text-[10px] text-slate-500 font-bold uppercase block">TARGET PENJUALAN</span>
                        <span class="text-sm sm:text-base font-bold text-slate-900 mt-1 block font-mono tabular-nums">
                            Rp {{ is_numeric($a['target']) ? number_format($a['target'], 0, ',', '.') : $a['target'] }}
                        </span>
                    </div>

                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200/60">
                        <span class="text-[10px] text-slate-500 font-bold uppercase block">CAPAIAN REALISASI</span>
                        <span class="text-sm sm:text-base font-bold text-emerald-700 mt-1 block font-mono tabular-nums">
                            Rp {{ is_numeric($a['actual']) ? number_format($a['actual'], 0, ',', '.') : $a['actual'] }}
                        </span>
                    </div>

                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200/60">
                        <span class="text-[10px] text-slate-500 font-bold uppercase block">ACHIEVEMENT RATE</span>
                        <span class="text-sm sm:text-base font-bold text-primary mt-1 block font-mono tabular-nums">{{ $a['achievement'] }}%</span>
                    </div>

                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200/60">
                        <span class="text-[10px] text-slate-500 font-bold uppercase block">GROWTH (MoM)</span>
                        <span class="text-sm sm:text-base font-bold mt-1 block font-mono tabular-nums {{ $a['growth'] >= 0 ? 'text-emerald-700' : 'text-rose-700' }}">
                            {{ $a['growth'] >= 0 ? '+' : '' }}{{ $a['growth'] }}%
                        </span>
                    </div>
                </div>

                <!-- Multi-Level Metric Pills (RO, ROA, EC) -->
                <div class="grid grid-cols-3 gap-3 pt-2">
                    <div class="p-3 rounded-xl bg-accent/10 border border-accent/20 text-center">
                        <span class="text-[10px] text-slate-500 font-bold uppercase block">REPEAT ORDER (RO)</span>
                        <span class="text-base font-bold text-accent mt-0.5 block font-mono tabular-nums">{{ $a['ro'] }}%</span>
                    </div>

                    <div class="p-3 rounded-xl bg-secondary/10 border border-secondary/20 text-center">
                        <span class="text-[10px] text-slate-500 font-bold uppercase block">RO ACTIVE OUTLET (ROA)</span>
                        <span class="text-base font-bold text-secondary mt-0.5 block font-mono tabular-nums">{{ $a['roa'] }}%</span>
                    </div>

                    <div class="p-3 rounded-xl bg-primary/10 border border-primary/20 text-center">
                        <span class="text-[10px] text-slate-500 font-bold uppercase block">EFFECTIVE CALL (EC)</span>
                        <span class="text-base font-bold text-primary mt-0.5 block font-mono tabular-nums">{{ $a['ec'] }}%</span>
                    </div>
                </div>

                <!-- Kecamatan Breakdown Table (Full Width) -->
                <div class="pt-3">
                    <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-3 flex items-center justify-between">
                        <span>Breakdown Outlet & Coverage per Kecamatan di {{ $a['name'] }}:</span>
                        <span class="text-primary font-normal">Filter: <span class="font-bold" x-text="activeKab"></span> / <span class="font-bold" x-text="activeKec"></span></span>
                    </h4>
                    <div class="overflow-x-auto border border-slate-200 rounded-xl">
                        <table class="w-full text-left text-xs text-slate-700">
                            <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] tracking-wider border-b border-slate-200">
                                <tr>
                                    <th class="py-3 px-4">KABUPATEN / KOTA</th>
                                    <th class="py-3 px-4">KECAMATAN</th>
                                    <th class="py-3 px-4 text-center">TARGET OUTLET</th>
                                    <th class="py-3 px-4 text-center">AKTUAL OUTLET TERDAFTAR</th>
                                    <th class="py-3 px-4 text-right">COVERAGE RATE (%)</th>
                                    <th class="py-3 px-4 text-center">STATUS COVERAGE</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($a['kabupaten'] as $kab)
                                    @foreach($kab['kecamatan'] as $kec)
                                    <tr 
                                        x-show="(activeKab === 'All' || activeKab === '{{ $kab['name'] }}') && (activeKec === 'All' || activeKec === '{{ $kec['name'] }}')"
                                        class="hover:bg-slate-50 transition-colors"
                                    >
                                        <td class="py-3 px-4 font-bold text-slate-900">{{ $kab['name'] }}</td>
                                        <td class="py-3 px-4 font-bold text-primary flex items-center gap-1.5">
                                            <i class="mdi mdi-map-marker text-primary text-sm"></i>
                                            <span>{{ $kec['name'] }}</span>
                                        </td>
                                        <td class="py-3 px-4 text-center font-mono tabular-nums text-slate-600">{{ number_format($kec['target_outlets'], 0, ',', '.') }} Toko</td>
                                        <td class="py-3 px-4 text-center font-bold text-emerald-700 font-mono tabular-nums">{{ number_format($kec['actual_outlets'], 0, ',', '.') }} Toko</td>
                                        <td class="py-3 px-4 text-right font-bold text-primary font-mono tabular-nums">
                                            {{ round(($kec['actual_outlets'] / max(1, $kec['target_outlets'])) * 100, 1) }}%
                                        </td>
                                        <td class="py-3 px-4 text-center">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium border {{ ($kec['actual_outlets'] / max(1, $kec['target_outlets'])) >= 0.9 ? 'bg-primary-50 text-primary-700 border-primary-200' : 'bg-amber-50 text-amber-700 border-amber-200' }}">
                                                <i class="mdi {{ ($kec['actual_outlets'] / max(1, $kec['target_outlets'])) >= 0.9 ? 'mdi-check-circle-outline' : 'mdi-alert-circle-outline' }} mr-1"></i>
                                                <span>{{ ($kec['actual_outlets'] / max(1, $kec['target_outlets'])) >= 0.9 ? 'Optimal' : 'Cukup' }}</span>
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
        @endforeach
    @endforeach

    <!-- Sales Representatives Assigned in Scope (Full Width) -->
    <div class="bg-white border border-slate-200/90 rounded-xl p-5 shadow-xs space-y-4">
        <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2 font-normal">
            <i class="mdi mdi-account-group-outline text-primary text-lg"></i> Sales Forces Assigned di Wilayah Ini
        </h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
            @foreach($salesList as $s)
            <div class="bg-slate-50 p-4 rounded-xl border border-slate-200/90 flex items-center justify-between hover:bg-slate-100/80 transition-all">
                <div>
                    <span class="text-xs font-bold text-slate-900 block">{{ $s['name'] }} ({{ $s['npk'] }})</span>
                    <span class="text-[10px] text-slate-500 block mt-0.5 font-mono tabular-nums">Area: {{ $s['area'] }} | SlpCode: {{ $s['slp_code'] }}</span>
                    <span class="text-[11px] text-emerald-700 font-bold block mt-1 font-mono tabular-nums">Target: Rp {{ number_format($s['target'], 0, ',', '.') }}</span>
                </div>
                <a href="{{ route('master.sales.detail', $s['npk']) }}" class="text-xs px-3 py-1.5 rounded-xl bg-white text-primary hover:bg-primary/10 font-bold border border-slate-200 shadow-xs active:translate-y-px transition-colors">
                    Detail
                </a>
            </div>
            @endforeach
        </div>
    </div>

</div>
@endsection
