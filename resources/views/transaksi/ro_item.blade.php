@extends('layouts.app')

@section('title', 'RO Item Level Tracking')

@section('content')
<div class="space-y-6">

    <!-- Header Banner -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-xl border border-slate-200/90 shadow-xs">
        <div>
            @include('partials.breadcrumb')
            <h1 class="text-xl font-bold text-slate-900">RO Item Level Monitoring</h1>
            <p class="text-xs text-slate-500 mt-0.5">Analisis per SKU untuk mendeteksi varian Teh Dandang yang mulai menghilang dari toko</p>
        </div>
    </div>

    <!-- RO Item Table -->
    <div class="bg-white border border-slate-200/90 rounded-xl p-5 shadow-xs">
        <h2 class="text-sm font-bold text-slate-900 mb-4">Tracking Kuantitas Order per Product SKU di Outlet</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-4">KODE SAP</th>
                        <th class="py-3 px-4">NAMA OUTLET</th>
                        <th class="py-3 px-4">AREA</th>
                        <th class="py-3 px-4 text-center">TEH DANDANG BIRU (DP001)</th>
                        <th class="py-3 px-4 text-center">TEH DANDANG MERAH (DM001)</th>
                        <th class="py-3 px-4 text-center">TEH DANDANG JASMINE (DJ001)</th>
                        <th class="py-3 px-4">ORDER TERAKHIR</th>
                        <th class="py-3 px-4 text-center">STATUS VARIAN</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($roItems as $ri)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="py-3 px-4 font-mono font-bold text-primary tabular-nums">{{ $ri['card_code'] }}</td>
                        <td class="py-3 px-4 font-bold text-slate-900">{{ $ri['outlet_name'] }}</td>
                        <td class="py-3 px-4 text-slate-600">{{ $ri['area'] }}</td>
                        <td class="py-3 px-4 text-center font-bold font-mono tabular-nums {{ $ri['dandang_biru_qty'] > 0 ? 'text-primary' : 'text-rose-600' }}">
                            {{ number_format($ri['dandang_biru_qty'], 0, ',', '.') }} Box
                        </td>
                        <td class="py-3 px-4 text-center font-bold font-mono tabular-nums {{ $ri['dandang_merah_qty'] > 0 ? 'text-primary' : 'text-secondary' }}">
                            {{ number_format($ri['dandang_merah_qty'], 0, ',', '.') }} Pack
                        </td>
                        <td class="py-3 px-4 text-center font-bold font-mono tabular-nums {{ $ri['dandang_jasmine_qty'] > 0 ? 'text-primary' : 'text-slate-400' }}">
                            {{ number_format($ri['dandang_jasmine_qty'], 0, ',', '.') }} Box
                        </td>
                        <td class="py-3 px-4 font-mono tabular-nums text-slate-600">{{ $ri['last_order_date'] }}</td>
                        <td class="py-3 px-4 text-center">
                            @if($ri['status'] === 'Good')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Lengkap
                                </span>
                            @elseif($ri['status'] === 'Warning')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                    Sebagian
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                    Kritis
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
