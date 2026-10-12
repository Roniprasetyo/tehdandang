@extends('layouts.app')

@section('title', 'Sistem Peringatan Dini')

@section('content')
<div class="space-y-6" x-data="{ severityFilter: 'All', areaFilter: 'All' }">

    <!-- Header & Info Utama -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-xl border border-slate-200/90 shadow-xs">
        <div>
            @include('partials.breadcrumb')
            <h1 class="text-xl font-semibold text-slate-900 flex items-center gap-2">
                <i class="mdi mdi-alert-outline text-secondary text-2xl"></i> Sistem Peringatan Dini
            </h1>
            <p class="text-xs text-slate-500 mt-1">Pemantauan deviasi rute armada, kepatuhan repeat order, dan anomali penjualan</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-rose-50 border border-rose-200 text-rose-700 text-xs font-medium gap-1.5">
                <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                <span>158 Peringatan Aktif</span>
            </span>
        </div>
    </div>

    <!-- 4 Severity Counter Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <button type="button" @click="severityFilter = 'Critical'" class="bg-white border border-rose-200 hover:border-rose-300 rounded-xl p-5 text-left transition-all shadow-xs group cursor-pointer active:translate-y-px">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold uppercase text-rose-600">Kritis</span>
                <i class="mdi mdi-alert-circle text-rose-600 text-lg"></i>
            </div>
            <div class="text-2xl font-semibold font-mono tabular-nums text-slate-900 mt-2">{{ number_format($warnings['summary']['critical'], 0, ',', '.') }}</div>
            <div class="text-xs text-rose-600 font-medium mt-1">Perlu tindakan segera</div>
        </button>

        <button type="button" @click="severityFilter = 'High'" class="bg-white border border-amber-200 hover:border-amber-300 rounded-xl p-5 text-left transition-all shadow-xs group cursor-pointer active:translate-y-px">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold uppercase text-amber-600">Tinggi</span>
                <i class="mdi mdi-alert text-amber-600 text-lg"></i>
            </div>
            <div class="text-2xl font-semibold font-mono tabular-nums text-slate-900 mt-2">{{ number_format($warnings['summary']['high'], 0, ',', '.') }}</div>
            <div class="text-xs text-amber-600 font-medium mt-1">Perhatian 24 jam</div>
        </button>

        <button type="button" @click="severityFilter = 'Medium'" class="bg-white border border-yellow-200 hover:border-yellow-300 rounded-xl p-5 text-left transition-all shadow-xs group cursor-pointer active:translate-y-px">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold uppercase text-yellow-700">Sedang</span>
                <i class="mdi mdi-alert-outline text-yellow-700 text-lg"></i>
            </div>
            <div class="text-2xl font-semibold font-mono tabular-nums text-slate-900 mt-2">{{ number_format($warnings['summary']['medium'], 0, ',', '.') }}</div>
            <div class="text-xs text-yellow-700 font-medium mt-1">Evaluasi mingguan</div>
        </button>

        <button type="button" @click="severityFilter = 'Low'" class="bg-white border border-slate-200 hover:border-slate-300 rounded-xl p-5 text-left transition-all shadow-xs group cursor-pointer active:translate-y-px">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold uppercase text-slate-500">Rendah</span>
                <i class="mdi mdi-information-outline text-slate-400 text-lg"></i>
            </div>
            <div class="text-2xl font-semibold font-mono tabular-nums text-slate-900 mt-2">{{ number_format($warnings['summary']['low'], 0, ',', '.') }}</div>
            <div class="text-xs text-slate-500 font-medium mt-1">Monitoring rutin</div>
        </button>
    </div>

    <!-- Filters Bar -->
    <div class="bg-white border border-slate-200/90 rounded-xl p-4 flex flex-wrap items-center justify-between gap-3 text-xs shadow-xs">
        <div class="flex flex-wrap items-center gap-3">
            <div class="flex items-center gap-2">
                <label class="text-slate-500 font-medium">Tingkat Urgensi:</label>
                <select x-model="severityFilter" class="bg-slate-50 border border-slate-200 text-slate-800 rounded-lg h-9 px-3 focus:outline-none focus:border-primary cursor-pointer transition-all">
                    <option value="All">Semua Tingkat</option>
                    <option value="Critical">Kritis</option>
                    <option value="High">Tinggi</option>
                    <option value="Medium">Sedang</option>
                    <option value="Low">Rendah</option>
                </select>
            </div>

            <div class="flex items-center gap-2">
                <label class="text-slate-500 font-medium">Wilayah Operasional:</label>
                <select x-model="areaFilter" class="bg-slate-50 border border-slate-200 text-slate-800 rounded-lg h-9 px-3 focus:outline-none focus:border-primary cursor-pointer transition-all">
                    <option value="All">Semua Area</option>
                    <option value="Bandung">Bandung</option>
                    <option value="Cirebon">Cirebon</option>
                    <option value="Jakarta">Jakarta</option>
                    <option value="Bogor">Bogor</option>
                </select>
            </div>
        </div>

        <button type="button" @click="severityFilter = 'All'; areaFilter = 'All'" class="btn-secondary-outline">
            <i class="mdi mdi-refresh text-base"></i>
            <span>Reset Filter</span>
        </button>
    </div>

    <!-- Warning Alerts Table -->
    <div class="bg-white border border-slate-200/90 rounded-xl shadow-xs p-5 space-y-4">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h3 class="text-sm font-semibold text-slate-900">Daftar Peringatan Dini Sistem</h3>
        </div>
        <div class="overflow-x-auto rounded-lg border border-slate-200">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-600 uppercase text-[11px] font-semibold tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-3.5">Severity</th>
                        <th class="py-3 px-3.5">Jenis Peringatan</th>
                        <th class="py-3 px-3.5">Detail Pesan</th>
                        <th class="py-3 px-3.5">Area</th>
                        <th class="py-3 px-3.5">Sales Person</th>
                        <th class="py-3 px-3.5">Outlet Target</th>
                        <th class="py-3 px-3.5 text-center">Status</th>
                        <th class="py-3 px-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($warnings['warnings'] as $w)
                    <tr 
                        x-show="(severityFilter === 'All' || severityFilter === '{{ $w['severity'] }}') && (areaFilter === 'All' || areaFilter === '{{ $w['area'] }}')"
                        class="hover:bg-slate-50/80 transition-colors"
                    >
                        <td class="py-3 px-3.5">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium border {{ $w['severity'] === 'Critical' ? 'bg-rose-50 text-rose-700 border-rose-200' : ($w['severity'] === 'High' ? 'bg-amber-50 text-amber-700 border-amber-200' : 'bg-yellow-50 text-yellow-700 border-yellow-200') }}">
                                <i class="mdi {{ $w['severity'] === 'Critical' ? 'mdi-alert-circle-outline' : 'mdi-alert-outline' }} mr-1"></i>
                                <span>{{ $w['severity'] }}</span>
                            </span>
                        </td>
                        <td class="py-3 px-3.5 font-medium text-slate-900">{{ $w['warning_type'] }}</td>
                        <td class="py-3 px-3.5 text-slate-600">{{ $w['message'] }}</td>
                        <td class="py-3 px-3.5 font-medium text-slate-700">{{ $w['area'] }}</td>
                        <td class="py-3 px-3.5 text-slate-700">{{ $w['sales'] }}</td>
                        <td class="py-3 px-3.5 font-medium text-primary">{{ $w['outlet'] }}</td>
                        <td class="py-3 px-3.5 text-center">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium bg-slate-100 text-slate-700 border border-slate-200">
                                {{ $w['status'] }}
                            </span>
                        </td>
                        <td class="py-3 px-3.5 text-right">
                            <button 
                                type="button"
                                @click="notify('Investigasi untuk peringatan #{{ $w['id'] }} telah diproses.', 'info')" 
                                class="text-xs px-2.5 py-1 rounded-lg bg-primary-50 text-primary-700 hover:bg-primary-100 border border-primary-200 font-medium active:translate-y-px transition-colors cursor-pointer"
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
