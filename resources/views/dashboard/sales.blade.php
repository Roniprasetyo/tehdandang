@extends('layouts.app')

@section('title', 'Dashboard Tenaga Penjual')

@section('content')
<div class="space-y-6">

    <!-- Header & Info Utama -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-xl border border-slate-200/90 shadow-xs">
        <div>
            @include('partials.breadcrumb')
            <h1 class="text-xl font-semibold text-slate-900">Dashboard Tenaga Penjual &bull; {{ $salesData['name'] ?? $user['name'] }}</h1>
            <p class="text-xs text-slate-500 mt-1 font-mono tabular-nums">NPK: {{ $salesData['npk'] ?? 'S006' }} &bull; Area: {{ $salesData['area'] ?? $user['area'] }} &bull; Plat: {{ $salesData['vehicle_plate'] ?? 'AD 8899 TD' }}</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-primary-50 border border-primary-200 text-primary-700 text-xs font-medium">
                <span class="w-2 h-2 rounded-full bg-primary mr-1.5"></span>
                <span>Status: {{ $salesData['status'] ?? 'Aktif' }}</span>
            </span>
        </div>
    </div>

    <!-- 4 Ringkasan Metrik Personal -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white border border-slate-200/90 rounded-xl p-5 shadow-xs">
            <span class="text-xs font-medium text-slate-500 block">Pencapaian Omset (MTD)</span>
            <div class="text-2xl font-semibold font-mono tabular-nums text-slate-900 mt-1">Rp {{ number_format($salesData['actual'] ?? 632500000, 0, ',', '.') }}</div>
            <div class="text-xs text-primary font-medium mt-1 font-mono tabular-nums">Target: Rp {{ number_format($salesData['target'] ?? 550000000, 0, ',', '.') }}</div>
            <div class="mt-3 w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                <div class="bg-primary h-full rounded-full" style="width: {{ min(100, $salesData['achievement'] ?? 115) }}%"></div>
            </div>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-xl p-5 shadow-xs">
            <span class="text-xs font-medium text-slate-500 block">Repeat Order (RO)</span>
            <div class="text-2xl font-semibold font-mono tabular-nums text-accent mt-1">{{ $salesData['ro_rate'] ?? 96 }}%</div>
            <div class="text-xs text-slate-500 mt-1 font-mono tabular-nums">Target: &gt; 80%</div>
            <div class="mt-3 w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                <div class="bg-accent h-full rounded-full" style="width: {{ $salesData['ro_rate'] ?? 96 }}%"></div>
            </div>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-xl p-5 shadow-xs">
            <span class="text-xs font-medium text-slate-500 block">RO Active Outlet (ROA)</span>
            <div class="text-2xl font-semibold font-mono tabular-nums text-secondary mt-1">{{ $salesData['roa_rate'] ?? 92 }}%</div>
            <div class="text-xs text-slate-500 mt-1 font-mono tabular-nums">Target: &gt; 75%</div>
            <div class="mt-3 w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                <div class="bg-secondary h-full rounded-full" style="width: {{ $salesData['roa_rate'] ?? 92 }}%"></div>
            </div>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-xl p-5 shadow-xs">
            <span class="text-xs font-medium text-slate-500 block">Effective Call (EC)</span>
            <div class="text-2xl font-semibold font-mono tabular-nums text-primary mt-1">{{ $salesData['ec_rate'] ?? 98 }}%</div>
            <div class="text-xs text-slate-500 mt-1 font-mono tabular-nums">Target: &gt; 90%</div>
            <div class="mt-3 w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                <div class="bg-primary h-full rounded-full" style="width: {{ $salesData['ec_rate'] ?? 98 }}%"></div>
            </div>
        </div>
    </div>

    <!-- Today's Visits Table -->
    <div class="bg-white border border-slate-200/90 rounded-xl shadow-xs p-5 space-y-4">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <div>
                <h3 class="text-sm font-semibold text-slate-900 flex items-center gap-2">
                    <i class="mdi mdi-clipboard-check-outline text-primary text-base"></i> Kunjungan Sales Hari Ini
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">Daftar outlet yang dikunjungi dan validasi radius GPS Concox GT06N</p>
            </div>
            <a href="{{ route('transaksi.sales-visit') }}" class="text-xs text-primary font-medium hover:underline">Lihat Semua Kunjungan</a>
        </div>

        <div class="overflow-x-auto rounded-lg border border-slate-200">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-600 uppercase text-[11px] font-semibold tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-3.5">Nama Outlet</th>
                        <th class="py-3 px-3.5">Check-in</th>
                        <th class="py-3 px-3.5">Check-out</th>
                        <th class="py-3 px-3.5">Jarak GPS</th>
                        <th class="py-3 px-3.5">Aktivitas</th>
                        <th class="py-3 px-3.5">Hasil Kunjungan</th>
                        <th class="py-3 px-3.5 text-center">Status GPS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($visits as $v)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="py-3 px-3.5 font-medium text-slate-900">{{ $v['outlet_name'] }}</td>
                        <td class="py-3 px-3.5 text-slate-600 font-mono tabular-nums">{{ $v['checkin_time'] }}</td>
                        <td class="py-3 px-3.5 text-slate-600 font-mono tabular-nums">{{ $v['checkout_time'] }}</td>
                        <td class="py-3 px-3.5 font-mono tabular-nums font-semibold text-slate-700">{{ $v['distance'] }}</td>
                        <td class="py-3 px-3.5 text-slate-600">{{ $v['activity'] }}</td>
                        <td class="py-3 px-3.5 font-medium text-primary">{{ $v['result'] }}</td>
                        <td class="py-3 px-3.5 text-center">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium border {{ $v['status'] === 'Valid' ? 'bg-primary-50 text-primary-700 border-primary-200' : 'bg-rose-50 text-rose-700 border-rose-200' }}">
                                <i class="mdi {{ $v['status'] === 'Valid' ? 'mdi-check-circle-outline' : 'mdi-alert-circle-outline' }} mr-1"></i>
                                <span>{{ $v['status'] }}</span>
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
