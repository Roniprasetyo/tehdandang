@extends('layouts.app')

@section('title', 'Early Warning Dashboard')

@section('content')
<div class="space-y-6" x-data="{ severityFilter: 'All', areaFilter: 'All' }">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
        <div>
            <h1 class="text-xl font-bold font-display text-slate-900 flex items-center gap-2 font-normal">
                <i class="mdi mdi-alert text-secondary text-2xl"></i> Early Warning System Dashboard
            </h1>
            <p class="text-xs text-slate-500 mt-0.5">Deteksi dini RO Inactive, Deviasi Rute GPS, EC Rendah, dan penurunan RO Item</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="px-3 py-1.5 rounded-full bg-rose-50 border border-rose-200 text-rose-700 text-xs font-bold flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-rose-500 animate-ping"></span>
                <span>Active Alerts: 158 Total</span>
            </span>
        </div>
    </div>

    <!-- 4 Severity Counter Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <button type="button" @click="severityFilter = 'Critical'" class="bg-white border border-rose-200 hover:border-rose-400 rounded-2xl p-5 text-left transition-all shadow-xs group cursor-pointer active:translate-y-px">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase text-rose-600">CRITICAL</span>
                <i class="mdi mdi-alert-circle text-rose-600 text-lg"></i>
            </div>
            <div class="text-2xl font-bold font-mono tabular-nums text-slate-900 mt-2 group-hover:scale-105 transition-transform">{{ number_format($warnings['summary']['critical'], 0, ',', '.') }}</div>
            <div class="text-[11px] text-rose-600 font-semibold mt-1">Perlu tindakan segera</div>
        </button>

        <button type="button" @click="severityFilter = 'High'" class="bg-white border border-amber-200 hover:border-amber-400 rounded-2xl p-5 text-left transition-all shadow-xs group cursor-pointer active:translate-y-px">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase text-amber-600">HIGH</span>
                <i class="mdi mdi-alert text-amber-600 text-lg"></i>
            </div>
            <div class="text-2xl font-bold font-mono tabular-nums text-slate-900 mt-2 group-hover:scale-105 transition-transform">{{ number_format($warnings['summary']['high'], 0, ',', '.') }}</div>
            <div class="text-[11px] text-amber-600 font-semibold mt-1">Perhatian 24 jam</div>
        </button>

        <button type="button" @click="severityFilter = 'Medium'" class="bg-white border border-yellow-200 hover:border-yellow-400 rounded-2xl p-5 text-left transition-all shadow-xs group cursor-pointer active:translate-y-px">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase text-yellow-600">MEDIUM</span>
                <i class="mdi mdi-alert-outline text-yellow-600 text-lg"></i>
            </div>
            <div class="text-2xl font-bold font-mono tabular-nums text-slate-900 mt-2 group-hover:scale-105 transition-transform">{{ number_format($warnings['summary']['medium'], 0, ',', '.') }}</div>
            <div class="text-[11px] text-yellow-600 font-semibold mt-1">Evaluasi mingguan</div>
        </button>

        <button type="button" @click="severityFilter = 'Low'" class="bg-white border border-slate-200 hover:border-slate-400 rounded-2xl p-5 text-left transition-all shadow-xs group cursor-pointer active:translate-y-px">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase text-slate-400">LOW</span>
                <i class="mdi mdi-information-outline text-slate-400 text-lg"></i>
            </div>
            <div class="text-2xl font-bold font-mono tabular-nums text-slate-900 mt-2 group-hover:scale-105 transition-transform">{{ number_format($warnings['summary']['low'], 0, ',', '.') }}</div>
            <div class="text-[11px] text-slate-500 mt-1">Monitoring umum</div>
        </button>
    </div>

    <!-- Filters Bar -->
    <div class="bg-white border border-slate-200/80 rounded-2xl p-4 flex flex-wrap items-center justify-between gap-3 text-xs shadow-xs">
        <div class="flex flex-wrap items-center gap-3">
            <div class="flex items-center gap-2">
                <label class="text-slate-500 font-semibold">Tingkat Bahaya:</label>
                <select x-model="severityFilter" class="bg-slate-50 border border-slate-200 text-slate-800 rounded-xl px-3 py-1.5 focus:outline-none focus:border-primary">
                    <option value="All">Semua Severity</option>
                    <option value="Critical">🔴 Critical</option>
                    <option value="High">🟠 High</option>
                    <option value="Medium">🟡 Medium</option>
                    <option value="Low">⚪ Low</option>
                </select>
            </div>

            <div class="flex items-center gap-2">
                <label class="text-slate-500 font-semibold">Wilayah Operasional:</label>
                <select x-model="areaFilter" class="bg-slate-50 border border-slate-200 text-slate-800 rounded-xl px-3 py-1.5 focus:outline-none focus:border-primary">
                    <option value="All">Semua Area</option>
                    <option value="Bandung">Bandung</option>
                    <option value="Cirebon">Cirebon</option>
                    <option value="Jakarta">Jakarta</option>
                    <option value="Bogor">Bogor</option>
                </select>
            </div>
        </div>

        <button type="button" @click="severityFilter = 'All'; areaFilter = 'All'" class="text-xs px-3 py-1.5 rounded-xl bg-slate-100 text-slate-700 hover:bg-slate-200 font-semibold active:translate-y-px">
            Reset Filter
        </button>
    </div>

    <!-- Warning Alerts Table -->
    <div class="bg-white border border-slate-200/80 rounded-2xl shadow-xs p-5">
        <h3 class="text-sm font-bold text-slate-900 mb-4 font-normal">Daftar Peringatan Dini (Early Warning Alerts)</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-4">SEVERITY</th>
                        <th class="py-3 px-4">JENIS PERINGATAN</th>
                        <th class="py-3 px-4">DETAIL PESAN</th>
                        <th class="py-3 px-4">AREA</th>
                        <th class="py-3 px-4">SALES ASSIGNED</th>
                        <th class="py-3 px-4">OUTLET TARGET</th>
                        <th class="py-3 px-4 text-center">STATUS</th>
                        <th class="py-3 px-4 text-right">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($warnings['warnings'] as $w)
                    <tr 
                        x-show="(severityFilter === 'All' || severityFilter === '{{ $w['severity'] }}') && (areaFilter === 'All' || areaFilter === '{{ $w['area'] }}')"
                        class="hover:bg-slate-50 transition-colors"
                    >
                        <td class="py-3 px-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold {{ $w['severity'] === 'Critical' ? 'bg-rose-50 text-rose-700 border border-rose-200' : ($w['severity'] === 'High' ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'bg-yellow-50 text-yellow-700 border border-yellow-200') }}">
                                {{ $w['severity_color'] }} {{ $w['severity'] }}
                            </span>
                        </td>
                        <td class="py-3 px-4 font-bold text-slate-900">{{ $w['warning_type'] }}</td>
                        <td class="py-3 px-4 text-slate-600">{{ $w['message'] }}</td>
                        <td class="py-3 px-4 font-semibold text-slate-700">{{ $w['area'] }}</td>
                        <td class="py-3 px-4 text-slate-700">{{ $w['sales'] }}</td>
                        <td class="py-3 px-4 font-bold text-primary">{{ $w['outlet'] }}</td>
                        <td class="py-3 px-4 text-center">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                {{ $w['status'] }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-right">
                            <button 
                                type="button"
                                @click="notify('Aksi investigasi untuk tiket #{{ $w['id'] }} telah dipicu.', 'info')" 
                                class="text-xs px-3 py-1 rounded-xl bg-primary/10 text-primary hover:bg-primary/20 border border-primary/20 font-bold active:translate-y-px transition-colors"
                            >
                                Tindak Lanjut
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
