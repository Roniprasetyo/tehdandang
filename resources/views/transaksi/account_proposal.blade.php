@extends('layouts.app')

@section('title', 'Account Proposal (AP)')

@section('content')
<div class="space-y-6">

    <!-- Header Banner -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-xl border border-slate-200/90 shadow-xs">
        <div>
            <h1 class="text-xl font-bold text-slate-900">Account Proposal (AP) & Efektivitas Program</h1>
            <p class="text-xs text-slate-500 mt-0.5">Evaluasi pertumbuhan omset outlet setelah pengajuan program Account Proposal</p>
        </div>
    </div>

    <!-- Account Proposal Table -->
    <div class="bg-white border border-slate-200/90 rounded-xl p-5 shadow-xs">
        <h2 class="text-sm font-bold text-slate-900 mb-4">Ringkasan Efektivitas Account Proposal per Area</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-4">AREA</th>
                        <th class="py-3 px-4">PROPOSAL AP DISETUJUI</th>
                        <th class="py-3 px-4">OMSET SEBELUM AP</th>
                        <th class="py-3 px-4">OMSET SETELAH AP</th>
                        <th class="py-3 px-4">PERTUMBUHAN (%)</th>
                        <th class="py-3 px-4 text-center">EFEKTIVITAS PROGRAM</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($proposals as $ap)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="py-3 px-4 font-bold text-slate-900">{{ $ap['area'] }}</td>
                        <td class="py-3 px-4 font-bold font-mono tabular-nums text-primary">{{ number_format($ap['ap_count'], 0, ',', '.') }} Proposal</td>
                        <td class="py-3 px-4 font-mono tabular-nums text-slate-500">Rp {{ number_format($ap['revenue_before'], 0, ',', '.') }}</td>
                        <td class="py-3 px-4 font-mono tabular-nums font-semibold text-slate-900">Rp {{ number_format($ap['revenue_after'], 0, ',', '.') }}</td>
                        <td class="py-3 px-4 font-mono tabular-nums font-bold {{ $ap['growth_percent'] >= 0 ? 'text-primary' : 'text-rose-600' }}">
                            {{ $ap['growth_percent'] >= 0 ? '+' : '' }}{{ $ap['growth_percent'] }}%
                        </td>
                        <td class="py-3 px-4 text-center">
                            @if($ap['effectiveness'] === 'Effective')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Efektif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                    Perlu Evaluasi
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
