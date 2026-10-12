@extends('layouts.app')

@section('title', 'NOO (New Open Outlet)')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
        <div>
            <h1 class="text-xl font-bold font-display text-slate-900 font-normal">NOO (New Open Outlet) Dashboard</h1>
            <p class="text-xs text-slate-500 mt-0.5">Penambahan outlet baru terdaftar & verifikasi ke SAP Business One</p>
        </div>
        <button 
            type="button"
            @click="notify('Formulir pendaftaran NOO baru disiapkan.', 'info')" 
            class="btn-primary text-xs flex items-center gap-1.5 active:translate-y-px"
        >
            <i class="mdi mdi-account-plus text-base"></i> + Registrasi NOO Baru
        </button>
    </div>

    <!-- 4 NOO Metric Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs">
            <span class="text-[10px] font-bold uppercase text-slate-400 block">NOO HARI INI</span>
            <span class="text-2xl font-bold font-mono tabular-nums text-slate-900 mt-1 block">{{ number_format($noo['noo_today'], 0, ',', '.') }}</span>
            <span class="text-[11px] text-emerald-600 font-semibold">Terdaftar Hari Ini</span>
        </div>

        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs">
            <span class="text-[10px] font-bold uppercase text-slate-400 block">NOO MTD</span>
            <span class="text-2xl font-bold font-mono tabular-nums text-primary mt-1 block">{{ number_format($noo['noo_mtd'], 0, ',', '.') }}</span>
            <span class="text-[11px] text-slate-500 font-semibold">Akumulasi Bulan Berjalan</span>
        </div>

        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs">
            <span class="text-[10px] font-bold uppercase text-slate-400 block">TARGET MTD</span>
            <span class="text-2xl font-bold font-mono tabular-nums text-secondary mt-1 block">{{ number_format($noo['target_mtd'], 0, ',', '.') }}</span>
            <span class="text-[11px] text-slate-500 font-semibold">Target Pembukaan Outlet</span>
        </div>

        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs">
            <span class="text-[10px] font-bold uppercase text-slate-400 block">ACHIEVEMENT RATE</span>
            <span class="text-2xl font-bold font-mono tabular-nums text-accent mt-1 block">{{ $noo['achievement_rate'] }}%</span>
            <span class="text-[11px] text-emerald-600 font-semibold">On Track</span>
        </div>
    </div>

    <!-- NOO Registered List -->
    <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs">
        <h3 class="text-sm font-bold text-slate-900 mb-4 font-normal">Pengajuan NOO Terbaru & Verifikasi SAP B1</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-4">KODE SAP</th>
                        <th class="py-3 px-4">NAMA OUTLET</th>
                        <th class="py-3 px-4">SALES REGISTRANT</th>
                        <th class="py-3 px-4">AREA</th>
                        <th class="py-3 px-4">KANAL</th>
                        <th class="py-3 px-4">TANGGAL DAFTAR</th>
                        <th class="py-3 px-4 text-center">STATUS SAP B1</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($noo['recent_noo'] as $n)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="py-3 px-4 font-mono tabular-nums font-bold text-primary">{{ $n['card_code'] }}</td>
                        <td class="py-3 px-4 font-bold text-slate-900">{{ $n['card_name'] }}</td>
                        <td class="py-3 px-4 text-slate-700">{{ $n['sales_name'] }}</td>
                        <td class="py-3 px-4 text-slate-600">{{ $n['area'] }}</td>
                        <td class="py-3 px-4 font-semibold text-slate-700">
                            <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-700 border border-slate-200 text-[10px]">
                                {{ $n['market'] }}
                            </span>
                        </td>
                        <td class="py-3 px-4 font-mono tabular-nums text-slate-500">{{ $n['date'] }}</td>
                        <td class="py-3 px-4 text-center">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                {{ $n['status'] }} ({{ $n['sap_code'] }})
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
