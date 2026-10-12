<!-- Hallmark & Anti-Slop Active · Theme: Tri-Tone Heritage (Tea Green, Amber Brew, Sky Accent) -->
@extends('layouts.app')

@section('title', 'Sales Directory')

@section('content')
<div class="space-y-6">

    <!-- Top Header & Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/90 shadow-xs">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold tracking-wider uppercase bg-primary-50 text-primary-700 border border-primary-200">
                    <i class="mdi mdi-account-group-outline mr-1"></i> Sales Force SFA
                </span>
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold tracking-wider uppercase bg-accent-50 text-accent-700 border border-accent-200">
                    SAP SlpCode Mapped
                </span>
            </div>
            <h1 class="text-xl font-bold font-display text-slate-900 tracking-tight">Sales Directory & Target MTD</h1>
            <p class="text-xs text-slate-500 mt-1">Kelola data tenaga penjualan, pemetaan SlpCode SAP B1, alokasi armada, dan target pencapaian area</p>
        </div>
        <div class="flex items-center gap-2">
            <button 
                type="button" 
                @click="notify('Data direktori sales berhasil diekspor ke format Excel/CSV.', 'success')" 
                class="px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 text-xs font-semibold hover:bg-slate-50 active:translate-y-px shadow-xs flex items-center gap-1.5 transition-all cursor-pointer"
            >
                <i class="mdi mdi-file-excel-box text-base text-primary-600"></i>
                <span>Export</span>
            </button>
            <button 
                type="button" 
                @click="notify('Silakan pilih berkas Excel direktori sales untuk sinkronisasi SAP.', 'info')" 
                class="px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 text-xs font-semibold hover:bg-slate-50 active:translate-y-px shadow-xs flex items-center gap-1.5 transition-all cursor-pointer"
            >
                <i class="mdi mdi-upload text-base text-slate-500"></i>
                <span>Import</span>
            </button>
            @if(in_array($authUser['role'], ['Admin Pusat', 'IT', 'Admin Area', 'Manager', 'ASM']))
            <button 
                type="button" 
                @click="notify('Formulir registrasi tenaga penjual baru siap diisi.', 'info')" 
                class="px-4 py-2 rounded-xl bg-primary hover:bg-primary-hover active:translate-y-px text-white text-xs font-semibold shadow-xs flex items-center gap-1.5 transition-all cursor-pointer"
            >
                <i class="mdi mdi-account-plus text-base"></i>
                <span>+ Tambah Sales</span>
            </button>
            @endif
        </div>
    </div>

    <!-- 4 Summary KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Total Sales Force</span>
                <span class="text-2xl font-bold font-display text-slate-900 mt-1 block tabular-nums">{{ count($salesList) }} Tenaga Penjual</span>
                <span class="text-[11px] text-primary font-semibold">Aktif di 4 Wilayah Regional</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-primary-50 text-primary flex items-center justify-center">
                <i class="mdi mdi-account-group-outline text-xl"></i>
            </div>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Top Sales Performer</span>
                <span class="text-2xl font-bold font-display text-primary mt-1 block tabular-nums">115.0%</span>
                <span class="text-[11px] text-primary font-semibold">★ Eko Prasetyo (Cepogo)</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-primary-50 text-primary flex items-center justify-center">
                <i class="mdi mdi-trophy-award text-xl"></i>
            </div>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Rata-rata Pencapaian</span>
                <span class="text-2xl font-bold font-display text-secondary mt-1 block tabular-nums">89.8%</span>
                <span class="text-[11px] text-secondary font-semibold">Target MTD Nasional</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-secondary-50 text-secondary flex items-center justify-center">
                <i class="mdi mdi-chart-areaspline text-xl"></i>
            </div>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Armada Ber-GPS</span>
                <span class="text-2xl font-bold font-display text-accent mt-1 block tabular-nums">100%</span>
                <span class="text-[11px] text-slate-400">Terintegrasi Concox GT06N</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-accent-50 text-accent flex items-center justify-center">
                <i class="mdi mdi-truck-delivery-outline text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Sales Table Container -->
    <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs">
        
        <!-- Search Toolbar -->
        <form action="{{ route('master.sales') }}" method="GET" class="p-4 border-b border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3">
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900 flex-shrink-0">Daftar Tenaga Penjual Terdaftar</h3>

            <div class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
                <div class="relative flex-1 sm:w-64">
                    <i class="mdi mdi-magnify text-slate-400 absolute left-3 top-1/2 -translate-y-1/2 text-base"></i>
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Cari NPK atau nama sales..." 
                        class="w-full bg-slate-50 border border-slate-200 text-xs rounded-xl pl-9 pr-4 py-2 text-slate-800 placeholder-slate-400 hover:border-slate-300 focus:bg-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary-100 transition-all"
                    >
                </div>

                <button type="submit" class="px-4 py-2 bg-primary-50 text-primary-700 border border-primary-200 rounded-xl text-xs font-bold hover:bg-primary-100 active:translate-y-px transition-all cursor-pointer">
                    Filter
                </button>
            </div>
        </form>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700 divide-y divide-slate-200">
                <thead class="bg-slate-50/90 text-slate-600 uppercase text-[10px] font-bold tracking-wider">
                    <tr>
                        <th class="py-3 px-4 w-10">
                            <input type="checkbox" class="rounded border-slate-300 text-primary focus:ring-primary">
                        </th>
                        <th class="py-3 px-4">NPK</th>
                        <th class="py-3 px-4">Tenaga Penjual</th>
                        <th class="py-3 px-4">Wilayah / Area</th>
                        <th class="py-3 px-4">Supervisor (ASM)</th>
                        <th class="py-3 px-4 text-right">Target MTD</th>
                        <th class="py-3 px-4 text-center">Pencapaian</th>
                        <th class="py-3 px-4 text-center">Status</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @foreach($salesList as $s)
                    <tr class="hover:bg-slate-50/80 transition-colors {{ str_contains($s['status'], 'Top Performer') ? 'bg-primary-50/20' : '' }}">
                        <td class="py-3 px-4">
                            <input type="checkbox" class="rounded border-slate-300 text-primary focus:ring-primary">
                        </td>
                        <td class="py-3 px-4 font-mono font-bold text-primary">{{ $s['npk'] }}</td>
                        <td class="py-3 px-4 font-semibold text-slate-900">
                            <div>{{ $s['name'] }}</div>
                            <div class="text-[10px] text-slate-400 font-normal">SlpCode: {{ $s['slp_code'] }} | Plat: {{ $s['vehicle_plate'] }}</div>
                        </td>
                        <td class="py-3 px-4 text-slate-600 font-medium">{{ $s['area'] }} ({{ $s['region'] }})</td>
                        <td class="py-3 px-4 text-slate-600">{{ $s['asm'] }}</td>
                        <td class="py-3 px-4 text-right font-mono text-slate-700 tabular-nums">Rp {{ number_format($s['target'], 0, ',', '.') }}</td>
                        <td class="py-3 px-4 text-center">
                            <span class="font-bold tabular-nums {{ $s['achievement'] >= 100 ? 'text-primary font-extrabold' : ($s['achievement'] >= 80 ? 'text-accent' : 'text-rose-600') }}">
                                {{ $s['achievement'] }}%
                            </span>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ str_contains($s['status'], 'Top Performer') ? 'bg-primary text-white' : 'bg-primary-50 text-primary-700 border border-primary-200' }}">
                                {{ $s['status'] }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-right space-x-1">
                            <a href="{{ route('master.sales.detail', $s['npk']) }}" class="p-1.5 text-slate-400 hover:text-primary hover:bg-slate-100 rounded-lg inline-block transition-colors" title="Lihat Profil">
                                <i class="mdi mdi-eye-outline text-base"></i>
                            </a>
                            <button 
                                type="button" 
                                @click="notify('Data salesman {{ $s['name'] }} dibuka untuk penyuntingan.', 'info')" 
                                class="p-1.5 text-slate-400 hover:text-slate-900 hover:bg-slate-100 rounded-lg transition-colors cursor-pointer" 
                                title="Edit"
                            >
                                <i class="mdi mdi-pencil-outline text-base"></i>
                            </button>
                            <button 
                                type="button" 
                                @click="notify('Konfirmasi penghapusan salesman {{ $s['name'] }} memerlukan otorisasi IT / GM.', 'warning')" 
                                class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors cursor-pointer" 
                                title="Hapus"
                            >
                                <i class="mdi mdi-delete-outline text-base"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
            <span>Menampilkan {{ number_format(count($salesList), 0, ',', '.') }} dari {{ number_format(count($salesList), 0, ',', '.') }} tenaga penjual</span>
            <div class="flex items-center gap-1">
                <button class="px-3 py-1 bg-white border border-slate-200 rounded-lg text-slate-400 cursor-not-allowed">Sebelumnya</button>
                <button class="px-3 py-1 bg-primary text-white font-bold rounded-lg shadow-xs">1</button>
                <button class="px-3 py-1 bg-white border border-slate-200 rounded-lg text-slate-600 hover:bg-slate-50 cursor-pointer">Selanjutnya</button>
            </div>
        </div>

    </div>

</div>
@endsection
