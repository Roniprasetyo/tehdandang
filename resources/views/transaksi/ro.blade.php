@extends('layouts.app')

@section('title', 'RO & ROA Dashboard')

@section('content')
<div class="space-y-6">

    <!-- Header Banner -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-xl border border-slate-200/90 shadow-xs">
        <div>
            @include('partials.breadcrumb')
            <h1 class="text-xl font-bold text-slate-900">Repeat Order (RO) & RO Active Outlet (ROA)</h1>
            <p class="text-xs text-slate-500 mt-0.5">Monitoring frekuensi repeat order toko dan tingkat keaktifan outlet</p>
        </div>
    </div>

    <!-- 3 Big Metric Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <div class="bg-white border border-slate-200/90 rounded-xl p-5 shadow-xs">
            <span class="text-[10px] font-bold uppercase text-slate-400 block tracking-wider">Overall Repeat Order (RO)</span>
            <div class="text-3xl font-bold font-mono tabular-nums text-primary mt-2">{{ $roData['overall_ro_rate'] }}%</div>
            <div class="text-xs text-slate-500 mt-1">Pembelian ulang produk Teh Dandang</div>
            <div class="mt-4 w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                <div class="bg-primary h-full rounded-full" style="width: {{ $roData['overall_ro_rate'] }}%"></div>
            </div>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-xl p-5 shadow-xs">
            <span class="text-[10px] font-bold uppercase text-slate-400 block tracking-wider">RO Active Outlet (ROA)</span>
            <div class="text-3xl font-bold font-mono tabular-nums text-secondary mt-2">{{ $roData['overall_roa_rate'] }}%</div>
            <div class="text-xs text-slate-500 mt-1"><span class="font-mono tabular-nums">{{ number_format($roData['active_outlets']) }}</span> / <span class="font-mono tabular-nums">{{ number_format($roData['total_outlets']) }}</span> Outlet Aktif</div>
            <div class="mt-4 w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                <div class="bg-secondary h-full rounded-full" style="width: {{ $roData['overall_roa_rate'] }}%"></div>
            </div>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-xl p-5 shadow-xs">
            <span class="text-[10px] font-bold uppercase text-slate-400 block tracking-wider">Outlet Tidak Aktif</span>
            <div class="text-3xl font-bold font-mono tabular-nums text-rose-700 mt-2">{{ number_format($roData['inactive_outlets']) }} Outlet</div>
            <div class="text-xs text-rose-600 mt-1">Tidak order > 30 hari (Perlu tindak lanjut)</div>
            <div class="mt-4 w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                <div class="bg-rose-500 h-full rounded-full" style="width: 24%"></div>
            </div>
        </div>
    </div>

    <!-- Outlet Level RO Status Table -->
    <div class="bg-white border border-slate-200/90 rounded-xl p-5 shadow-xs">
        <h2 class="text-sm font-bold text-slate-900 mb-4">Status Repeat Order Level Outlet</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-4">KODE SAP</th>
                        <th class="py-3 px-4">NAMA OUTLET</th>
                        <th class="py-3 px-4">AREA</th>
                        <th class="py-3 px-4">SALES ASSIGNED</th>
                        <th class="py-3 px-4">ORDER TERAKHIR</th>
                        <th class="py-3 px-4 text-center">FREKUENSI RO</th>
                        <th class="py-3 px-4">STATUS ROA</th>
                        <th class="py-3 px-4 text-center">STATUS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($roData['outlet_ro_list'] as $o)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="py-3 px-4 font-mono font-bold text-primary tabular-nums">{{ $o['card_code'] }}</td>
                        <td class="py-3 px-4 font-bold text-slate-900">{{ $o['outlet_name'] }}</td>
                        <td class="py-3 px-4 text-slate-600">{{ $o['area'] }}</td>
                        <td class="py-3 px-4 text-slate-700 font-medium">{{ $o['sales_name'] }}</td>
                        <td class="py-3 px-4 font-mono tabular-nums text-slate-600">{{ $o['last_order_date'] }}</td>
                        <td class="py-3 px-4 text-center font-bold font-mono tabular-nums text-accent">{{ $o['ro_frequency_month'] }}x Order</td>
                        <td class="py-3 px-4 font-medium text-slate-700">{{ $o['roa_status'] }}</td>
                        <td class="py-3 px-4 text-center">
                            @if($o['status'] === 'Active')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Aktif
                                </span>
                            @elseif($o['status'] === 'Warning')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                    Peringatan
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                    Tidak Aktif
                                </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
