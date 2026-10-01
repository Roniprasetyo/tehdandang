@extends('layouts.app')

@section('title', 'Account Proposal (AP)')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
        <div>
            <h1 class="text-xl font-bold font-display text-slate-900">Account Proposal (AP) & Program Effectiveness</h1>
            <p class="text-xs text-slate-500 mt-0.5">Evaluasi pertumbuhan omset outlet setelah pengajuan program Account Proposal</p>
        </div>
    </div>

    <!-- Account Proposal Table -->
    <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs">
        <h3 class="text-sm font-bold text-slate-900 mb-4">Ringkasan Efektivitas Account Proposal per Area</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-4">AREA</th>
                        <th class="py-3 px-4">AP PROPOSALS APPROVED</th>
                        <th class="py-3 px-4">REVENUE BEFORE AP</th>
                        <th class="py-3 px-4">REVENUE AFTER AP</th>
                        <th class="py-3 px-4">GROWTH (%)</th>
                        <th class="py-3 px-4 text-center">PROGRAM EFFECTIVENESS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($proposals as $ap)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="py-3 px-4 font-bold text-slate-900">{{ $ap['area'] }}</td>
                        <td class="py-3 px-4 font-bold text-indigo-600">{{ number_format($ap['ap_count'], 0, ',', '.') }} AP Proposals</td>
                        <td class="py-3 px-4 text-slate-500">Rp {{ number_format($ap['revenue_before'], 0, ',', '.') }}</td>
                        <td class="py-3 px-4 font-semibold text-slate-900">Rp {{ number_format($ap['revenue_after'], 0, ',', '.') }}</td>
                        <td class="py-3 px-4 font-bold {{ $ap['growth_percent'] >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                            {{ $ap['growth_percent'] >= 0 ? '+' : '' }}{{ $ap['growth_percent'] }}%
                        </td>
                        <td class="py-3 px-4 text-center">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $ap['effectiveness'] === 'Effective' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-amber-50 text-amber-700 border-amber-200' }}">
                                {{ $ap['effectiveness_color'] }} {{ $ap['effectiveness'] }}
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
