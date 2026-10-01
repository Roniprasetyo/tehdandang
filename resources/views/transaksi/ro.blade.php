@extends('layouts.app')

@section('title', 'RO & ROA Dashboard')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
        <div>
            <h1 class="text-xl font-bold font-display text-slate-900">Repeat Order (RO) & RO Active Outlet (ROA)</h1>
            <p class="text-xs text-slate-500 mt-0.5">Monitoring frekuensi repeat order toko dan tingkat keaktifan outlet</p>
        </div>
    </div>

    <!-- 3 Big Metric Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs">
            <span class="text-xs font-bold uppercase text-slate-400 block">OVERALL REPEAT ORDER (RO)</span>
            <div class="text-3xl font-bold text-cyan-600 mt-2">{{ $roData['overall_ro_rate'] }}%</div>
            <div class="text-xs text-slate-500 mt-1">Pembelian ulang produk Teh Dandang</div>
            <div class="mt-4 w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                <div class="bg-cyan-500 h-full rounded-full" style="width: {{ $roData['overall_ro_rate'] }}%"></div>
            </div>
        </div>

        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs">
            <span class="text-xs font-bold uppercase text-slate-400 block">RO ACTIVE OUTLET (ROA)</span>
            <div class="text-3xl font-bold text-amber-600 mt-2">{{ $roData['overall_roa_rate'] }}%</div>
            <div class="text-xs text-slate-500 mt-1">{{ number_format($roData['active_outlets']) }} / {{ number_format($roData['total_outlets']) }} Active Outlets</div>
            <div class="mt-4 w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                <div class="bg-amber-500 h-full rounded-full" style="width: {{ $roData['overall_roa_rate'] }}%"></div>
            </div>
        </div>

        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs">
            <span class="text-xs font-bold uppercase text-slate-400 block">INACTIVE OUTLETS</span>
            <div class="text-3xl font-bold text-rose-600 mt-2">{{ number_format($roData['inactive_outlets']) }} Outlets</div>
            <div class="text-xs text-rose-600 mt-1">Tidak order > 30 hari (Needs follow up)</div>
            <div class="mt-4 w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                <div class="bg-rose-500 h-full rounded-full" style="width: 24%"></div>
            </div>
        </div>
    </div>

    <!-- Outlet Level RO Status Table -->
    <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs">
        <h3 class="text-sm font-bold text-slate-900 mb-4">Status Repeat Order Level Outlet</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-4">CARD CODE</th>
                        <th class="py-3 px-4">OUTLET NAME</th>
                        <th class="py-3 px-4">AREA</th>
                        <th class="py-3 px-4">SALES ASSIGNED</th>
                        <th class="py-3 px-4">LAST ORDER</th>
                        <th class="py-3 px-4 text-center">RO FREQUENCY</th>
                        <th class="py-3 px-4">ROA STATUS</th>
                        <th class="py-3 px-4 text-center">STATUS BADGE</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($roData['outlet_ro_list'] as $o)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="py-3 px-4 font-mono font-bold text-indigo-600">{{ $o['card_code'] }}</td>
                        <td class="py-3 px-4 font-bold text-slate-900">{{ $o['outlet_name'] }}</td>
                        <td class="py-3 px-4 text-slate-600">{{ $o['area'] }}</td>
                        <td class="py-3 px-4 text-slate-700">{{ $o['sales_name'] }}</td>
                        <td class="py-3 px-4 font-mono text-slate-600">{{ $o['last_order_date'] }}</td>
                        <td class="py-3 px-4 text-center font-bold text-cyan-600">{{ $o['ro_frequency_month'] }}x Order</td>
                        <td class="py-3 px-4 font-medium text-slate-700">{{ $o['roa_status'] }}</td>
                        <td class="py-3 px-4 text-center">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $o['status'] === 'Active' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : ($o['status'] === 'Warning' ? 'bg-amber-50 text-amber-700 border-amber-200' : 'bg-rose-50 text-rose-700 border-rose-200') }}">
                                {{ $o['status_color'] }} {{ $o['status'] }}
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
