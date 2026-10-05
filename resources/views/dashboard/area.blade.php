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
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
        <div>
            <h1 class="text-xl font-bold font-display text-slate-900 flex items-center gap-2">
                <i data-lucide="layers" class="w-5 h-5 text-indigo-600"></i> Area Performance & Multi-Level Hierarchy
            </h1>
            <p class="text-xs text-slate-500 mt-0.5">Hierarki Rantai Cabang: Region → Area → Kabupaten → Kecamatan → Sales → Outlet</p>
        </div>
        <div class="flex items-center gap-2 text-xs">
            <a href="{{ route('dashboard.drilldown') }}" class="px-3.5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold flex items-center gap-2 shadow-xs transition-all">
                <i data-lucide="bar-chart-2" class="w-4 h-4"></i>
                <span>Grafik Drilldown Interactive</span>
            </a>
        </div>
    </div>

    <!-- Top Cascading Multi-Level Navigation Bar -->
    <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs space-y-4">
        
        <!-- Level 1: Region Selection Tabs -->
        <div>
            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-2">1. PILIH REGION (PROVINSI):</span>
            <div class="flex flex-wrap gap-2">
                @foreach($areas as $r)
                <button 
                    @click="activeRegion = '{{ $r['region'] }}'; activeArea = '{{ $r['areas'][0]['name'] ?? '' }}'; activeKab = 'All'; activeKec = 'All'"
                    class="px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2"
                    :class="activeRegion === '{{ $r['region'] }}' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-200' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'"
                >
                    <i data-lucide="map-pin" class="w-3.5 h-3.5"></i>
                    <span>{{ $r['region'] }}</span>
                    <span class="px-1.5 py-0.5 rounded text-[10px]" :class="activeRegion === '{{ $r['region'] }}' ? 'bg-indigo-700 text-white' : 'bg-slate-200 text-slate-600'">{{ count($r['areas']) }} Area</span>
                </button>
                @endforeach
            </div>
        </div>

        <!-- Level 2: Area Selection Cards under Active Region -->
        @foreach($areas as $r)
        <div x-show="activeRegion === '{{ $r['region'] }}'" class="space-y-2 pt-2 border-t border-slate-100">
            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">2. PILIH AREA DI {{ strtoupper($r['region']) }}:</span>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2.5">
                @foreach($r['areas'] as $a)
                <button 
                    @click="activeArea = '{{ $a['name'] }}'; activeKab = 'All'; activeKec = 'All'"
                    class="p-3 rounded-xl border text-left transition-all flex flex-col justify-between"
                    :class="activeArea === '{{ $a['name'] }}' ? 'bg-indigo-50/80 border-indigo-500 ring-2 ring-indigo-500/20 shadow-xs' : 'bg-slate-50 border-slate-200/80 hover:bg-slate-100/80'"
                >
                    <div class="flex items-start justify-between gap-2">
                        <span class="text-xs font-bold text-slate-900 leading-snug">{{ $a['name'] }}</span>
                        <span class="text-base flex-shrink-0">{{ $a['status_color'] }}</span>
                    </div>
                    <div class="mt-2 flex items-center justify-between text-[11px]">
                        <span class="text-slate-500">Achievement:</span>
                        <span class="font-bold" :class="'{{ $a['achievement'] }}' >= 100 ? 'text-emerald-600' : 'text-indigo-600'">{{ $a['achievement'] }}%</span>
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
                        <label class="text-slate-500 font-bold">3. Kabupaten:</label>
                        <select x-model="activeKab" @change="activeKec = 'All'" class="bg-slate-50 border border-slate-200 text-slate-800 rounded-xl px-3 py-1.5 focus:outline-none focus:border-indigo-500 font-semibold">
                            <option value="All">Semua Kabupaten di {{ $a['name'] }}</option>
                            @foreach($a['kabupaten'] as $kab)
                            <option value="{{ $kab['name'] }}">{{ $kab['name'] }} ({{ count($kab['kecamatan']) }} Kec)</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Kecamatan Dropdown -->
                    <div class="flex items-center gap-2">
                        <label class="text-slate-500 font-bold">4. Kecamatan:</label>
                        <select x-model="activeKec" class="bg-slate-50 border border-slate-200 text-slate-800 rounded-xl px-3 py-1.5 focus:outline-none focus:border-indigo-500 font-semibold">
                            <option value="All">Semua Kecamatan</option>
                            @foreach($a['kabupaten'] as $kab)
                                @foreach($kab['kecamatan'] as $kec)
                                <option x-show="activeKab === 'All' || activeKab === '{{ $kab['name'] }}'" value="{{ $kec['name'] }}">{{ $kec['name'] }} ({{ $kab['name'] }})</option>
                                @endforeach
                            @endforeach
                        </select>
                    </div>
                </div>

                <button @click="activeKab = 'All'; activeKec = 'All'" class="px-3 py-1.5 rounded-xl bg-slate-100 text-slate-700 hover:bg-slate-200 font-semibold text-xs">
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
            <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between border-b border-slate-100 pb-3 gap-2">
                    <div>
                        <span class="text-[10px] text-indigo-600 font-bold uppercase tracking-widest">{{ $r['region'] }} → Area: {{ $a['name'] }}</span>
                        <h2 class="text-lg font-bold text-slate-900">{{ $a['name'] }}</h2>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="px-3 py-1 rounded-full text-xs font-bold border flex items-center gap-1.5" :class="'{{ $a['status'] }}'.includes('Good') ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : ('{{ $a['status'] }}'.includes('Warning') ? 'bg-amber-50 text-amber-700 border-amber-200' : 'bg-rose-50 text-rose-700 border-rose-200')">
                            <span>{{ $a['status_color'] }}</span>
                            <span>Status: {{ $a['status'] }}</span>
                        </span>
                    </div>
                </div>

                <!-- 4 Top KPI Stat Cards -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200/60">
                        <span class="text-[10px] text-slate-500 font-bold uppercase block">TARGET PENJUALAN</span>
                        <span class="text-sm sm:text-base font-bold text-slate-900 mt-1 block">
                            Rp {{ is_numeric($a['target']) ? number_format($a['target'], 0, ',', '.') : $a['target'] }}
                        </span>
                    </div>

                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200/60">
                        <span class="text-[10px] text-slate-500 font-bold uppercase block">CAPAIAN REALISASI</span>
                        <span class="text-sm sm:text-base font-bold text-emerald-600 mt-1 block">
                            Rp {{ is_numeric($a['actual']) ? number_format($a['actual'], 0, ',', '.') : $a['actual'] }}
                        </span>
                    </div>

                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200/60">
                        <span class="text-[10px] text-slate-500 font-bold uppercase block">ACHIEVEMENT RATE</span>
                        <span class="text-sm sm:text-base font-bold text-indigo-600 mt-1 block">{{ $a['achievement'] }}%</span>
                    </div>

                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200/60">
                        <span class="text-[10px] text-slate-500 font-bold uppercase block">GROWTH (MoM)</span>
                        <span class="text-sm sm:text-base font-bold mt-1 block {{ $a['growth'] >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                            {{ $a['growth'] >= 0 ? '+' : '' }}{{ $a['growth'] }}%
                        </span>
                    </div>
                </div>

                <!-- Multi-Level Metric Pills (RO, ROA, EC) -->
                <div class="grid grid-cols-3 gap-3 pt-2">
                    <div class="p-3 rounded-xl bg-cyan-50 border border-cyan-200 text-center">
                        <span class="text-[10px] text-slate-500 font-bold uppercase block">REPEAT ORDER (RO)</span>
                        <span class="text-base font-bold text-cyan-600 mt-0.5 block">{{ $a['ro'] }}%</span>
                    </div>

                    <div class="p-3 rounded-xl bg-amber-50 border border-amber-200 text-center">
                        <span class="text-[10px] text-slate-500 font-bold uppercase block">RO ACTIVE OUTLET (ROA)</span>
                        <span class="text-base font-bold text-amber-600 mt-0.5 block">{{ $a['roa'] }}%</span>
                    </div>

                    <div class="p-3 rounded-xl bg-purple-50 border border-purple-200 text-center">
                        <span class="text-[10px] text-slate-500 font-bold uppercase block">EFFECTIVE CALL (EC)</span>
                        <span class="text-base font-bold text-purple-600 mt-0.5 block">{{ $a['ec'] }}%</span>
                    </div>
                </div>

                <!-- Kecamatan Breakdown Table (Full Width) -->
                <div class="pt-3">
                    <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-3 flex items-center justify-between">
                        <span>Breakdown Outlet & Coverage per Kecamatan di {{ $a['name'] }}:</span>
                        <span class="text-indigo-600 font-normal">Filter: <span class="font-bold" x-text="activeKab"></span> / <span class="font-bold" x-text="activeKec"></span></span>
                    </h4>
                    <div class="overflow-x-auto border border-slate-200 rounded-xl">
                        <table class="w-full text-left text-xs text-slate-700">
                            <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] tracking-wider border-b border-slate-200">
                                <tr>
                                    <th class="py-3 px-4">KABUPATEN / KOTA</th>
                                    <th class="py-3 px-4">KECAMATAN</th>
                                    <th class="py-3 px-4 text-center">TARGET OUTLET</th>
                                    <th class="py-3 px-4 text-center">ACTUAL OUTLET TERDAFTAR</th>
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
                                        <td class="py-3 px-4 font-bold text-indigo-600 flex items-center gap-1.5">
                                            <i data-lucide="map-pin" class="w-3.5 h-3.5 text-indigo-500"></i>
                                            <span>{{ $kec['name'] }}</span>
                                        </td>
                                        <td class="py-3 px-4 text-center font-mono text-slate-600">{{ number_format($kec['target_outlets'], 0, ',', '.') }} Toko</td>
                                        <td class="py-3 px-4 text-center font-bold text-emerald-600 font-mono">{{ number_format($kec['actual_outlets'], 0, ',', '.') }} Toko</td>
                                        <td class="py-3 px-4 text-right font-bold text-indigo-600 font-mono">
                                            {{ round(($kec['actual_outlets'] / max(1, $kec['target_outlets'])) * 100, 1) }}%
                                        </td>
                                        <td class="py-3 px-4 text-center">
                                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ ($kec['actual_outlets'] / max(1, $kec['target_outlets'])) >= 0.9 ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-amber-50 text-amber-700 border-amber-200' }}">
                                                {{ ($kec['actual_outlets'] / max(1, $kec['target_outlets'])) >= 0.9 ? '🟢 Excellent' : '🟡 Fair' }}
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
    <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs space-y-4">
        <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
            <i data-lucide="users" class="w-4 h-4 text-indigo-600"></i> Sales Forces Assigned di Wilayah Ini
        </h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
            @foreach($salesList as $s)
            <div class="bg-slate-50 p-4 rounded-xl border border-slate-200/80 flex items-center justify-between hover:bg-slate-100/80 transition-all">
                <div>
                    <span class="text-xs font-bold text-slate-900 block">{{ $s['name'] }} ({{ $s['npk'] }})</span>
                    <span class="text-[10px] text-slate-500 block mt-0.5">Area: {{ $s['area'] }} | SlpCode: {{ $s['slp_code'] }}</span>
                    <span class="text-[11px] text-emerald-600 font-bold block mt-1">Target: Rp {{ number_format($s['target'], 0, ',', '.') }}</span>
                </div>
                <a href="{{ route('master.sales.detail', $s['npk']) }}" class="text-xs px-3 py-1.5 rounded-xl bg-white text-indigo-600 hover:bg-indigo-50 font-bold border border-slate-200 shadow-xs">
                    Detail
                </a>
            </div>
            @endforeach
        </div>
    </div>

</div>
@endsection
