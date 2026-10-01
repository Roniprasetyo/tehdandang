@extends('layouts.app')

@section('title', 'NOO (New Open Outlet)')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
        <div>
            <h1 class="text-xl font-bold font-display text-slate-900">NOO (New Open Outlet) Dashboard</h1>
            <p class="text-xs text-slate-500 mt-0.5">Penambahan outlet baru terdaftar & verifikasi ke SAP Business One</p>
        </div>
        <button @click="alert('Form Registrasi NOO Baru')" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-md shadow-indigo-200 flex items-center gap-1.5">
            <i data-lucide="user-plus" class="w-4 h-4"></i> + Registrasi NOO Baru
        </button>
    </div>

    <!-- 4 NOO Metric Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs">
            <span class="text-[10px] font-bold uppercase text-slate-400 block">NOO TODAY</span>
            <span class="text-2xl font-bold text-slate-900 mt-1 block">{{ number_format($noo['noo_today'], 0, ',', '.') }} Outlets</span>
            <span class="text-[11px] text-emerald-600 font-semibold">Terdaftar Hari Ini</span>
        </div>

        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs">
            <span class="text-[10px] font-bold uppercase text-slate-400 block">NOO MTD</span>
            <span class="text-2xl font-bold text-emerald-600 mt-1 block">{{ number_format($noo['noo_mtd'], 0, ',', '.') }} Outlets</span>
            <span class="text-[11px] text-slate-500 font-semibold">Akumulasi MTD</span>
        </div>

        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs">
            <span class="text-[10px] font-bold uppercase text-slate-400 block">TARGET MTD</span>
            <span class="text-2xl font-bold text-indigo-600 mt-1 block">{{ number_format($noo['target_mtd'], 0, ',', '.') }} Outlets</span>
            <span class="text-[11px] text-slate-500 font-semibold">Target Pembukaan</span>
        </div>

        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs">
            <span class="text-[10px] font-bold uppercase text-slate-400 block">ACHIEVEMENT RATE</span>
            <span class="text-2xl font-bold text-purple-600 mt-1 block">{{ $noo['achievement_rate'] }}%</span>
            <span class="text-[11px] text-emerald-600 font-semibold">On Track</span>
        </div>
    </div>

    <!-- NOO Registered List -->
    <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs">
        <h3 class="text-sm font-bold text-slate-900 mb-4">Pengajuan NOO Terbaru & Verifikasi SAP B1</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-4">CARD CODE</th>
                        <th class="py-3 px-4">OUTLET NAME</th>
                        <th class="py-3 px-4">SALES REGISTRANT</th>
                        <th class="py-3 px-4">AREA</th>
                        <th class="py-3 px-4">CHANNEL</th>
                        <th class="py-3 px-4">DATE REGISTERED</th>
                        <th class="py-3 px-4 text-center">SAP B1 STATUS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($noo['recent_noo'] as $n)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="py-3 px-4 font-mono font-bold text-indigo-600">{{ $n['card_code'] }}</td>
                        <td class="py-3 px-4 font-bold text-slate-900">{{ $n['card_name'] }}</td>
                        <td class="py-3 px-4 text-slate-700">{{ $n['sales_name'] }}</td>
                        <td class="py-3 px-4 text-slate-600">{{ $n['area'] }}</td>
                        <td class="py-3 px-4 font-semibold text-slate-700">{{ $n['market'] }}</td>
                        <td class="py-3 px-4 font-mono text-slate-500">{{ $n['date'] }}</td>
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
