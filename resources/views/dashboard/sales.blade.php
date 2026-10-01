@extends('layouts.app')

@section('title', 'Sales Dashboard')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
        <div>
            <h1 class="text-xl font-bold font-display text-slate-900">Sales Dashboard — {{ $salesData['name'] ?? $user['name'] }}</h1>
            <p class="text-xs text-slate-500 mt-0.5">NPK: {{ $salesData['npk'] ?? 'S006' }} | Area: {{ $salesData['area'] ?? $user['area'] }} | Kendaraan: {{ $salesData['vehicle_plate'] ?? 'AD 8899 TD' }}</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="px-3 py-1.5 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-bold">
                Status: {{ $salesData['status'] ?? 'Active' }}
            </span>
        </div>
    </div>

    <!-- Personal KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">PENCAPAIAN OMSET (MTD)</span>
            <div class="text-2xl font-bold text-slate-900 mt-2">Rp {{ number_format($salesData['actual'] ?? 632500000, 0, ',', '.') }}</div>
            <div class="text-[11px] text-emerald-600 font-semibold mt-1">Target: Rp {{ number_format($salesData['target'] ?? 550000000, 0, ',', '.') }}</div>
            <div class="mt-3 w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                <div class="bg-emerald-500 h-full rounded-full" style="width: {{ min(100, $salesData['achievement'] ?? 115) }}%"></div>
            </div>
        </div>

        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">REPEAT ORDER (RO)</span>
            <div class="text-2xl font-bold text-cyan-600 mt-2">{{ $salesData['ro_rate'] ?? 96 }}%</div>
            <div class="text-[11px] text-slate-500 mt-1">Target: > 80%</div>
            <div class="mt-3 w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                <div class="bg-cyan-500 h-full rounded-full" style="width: {{ $salesData['ro_rate'] ?? 96 }}%"></div>
            </div>
        </div>

        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">RO ACTIVE OUTLET (ROA)</span>
            <div class="text-2xl font-bold text-amber-600 mt-2">{{ $salesData['roa_rate'] ?? 92 }}%</div>
            <div class="text-[11px] text-slate-500 mt-1">Target: > 75%</div>
            <div class="mt-3 w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                <div class="bg-amber-500 h-full rounded-full" style="width: {{ $salesData['roa_rate'] ?? 92 }}%"></div>
            </div>
        </div>

        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">EFFECTIVE CALL (EC)</span>
            <div class="text-2xl font-bold text-purple-600 mt-2">{{ $salesData['ec_rate'] ?? 98 }}%</div>
            <div class="text-[11px] text-slate-500 mt-1">Target: > 90%</div>
            <div class="mt-3 w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                <div class="bg-purple-500 h-full rounded-full" style="width: {{ $salesData['ec_rate'] ?? 98 }}%"></div>
            </div>
        </div>
    </div>

    <!-- Today's Visits Table -->
    <div class="bg-white border border-slate-200/80 rounded-2xl shadow-xs p-5">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                    <i data-lucide="clipboard-check" class="w-4 h-4 text-emerald-600"></i> Kunjungan Sales Hari Ini (Sales Visit & GPS)
                </h3>
                <p class="text-xs text-slate-500">Daftar toko yang dikunjungi & validasi radius Concox GT06N GPS</p>
            </div>
            <a href="{{ route('transaksi.sales-visit') }}" class="text-xs text-indigo-600 font-bold hover:underline">Lihat Semua Visit</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-4">NAMA OUTLET</th>
                        <th class="py-3 px-4">CHECK-IN</th>
                        <th class="py-3 px-4">CHECK-OUT</th>
                        <th class="py-3 px-4">JARAK GPS</th>
                        <th class="py-3 px-4">AKTIVITAS</th>
                        <th class="py-3 px-4">HASIL / ORDER</th>
                        <th class="py-3 px-4 text-center">STATUS GPS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($visits as $v)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="py-3 px-4 font-bold text-slate-900">{{ $v['outlet_name'] }}</td>
                        <td class="py-3 px-4 text-slate-600 font-mono">{{ $v['checkin_time'] }}</td>
                        <td class="py-3 px-4 text-slate-600 font-mono">{{ $v['checkout_time'] }}</td>
                        <td class="py-3 px-4 font-mono font-bold text-slate-700">{{ $v['distance'] }}</td>
                        <td class="py-3 px-4 text-slate-600">{{ $v['activity'] }}</td>
                        <td class="py-3 px-4 font-bold text-emerald-600">{{ $v['result'] }}</td>
                        <td class="py-3 px-4 text-center">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $v['status'] === 'Valid' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-rose-50 text-rose-700 border-rose-200' }}">
                                {{ $v['status_color'] }} {{ $v['status'] }}
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
