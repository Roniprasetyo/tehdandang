@extends('layouts.app')

@section('title', 'Detail Sales - ' . $sales['name'])

@section('content')
<div class="space-y-6">

    <!-- Header Breadcrumb & Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
        <div>
            <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
                <a href="{{ route('master.sales') }}" class="hover:underline hover:text-primary transition-colors">Direktori Sales</a>
                <i class="mdi mdi-chevron-right text-xs"></i>
                <span class="text-slate-700 font-semibold">Detail Tenaga Penjual</span>
            </div>
            <h1 class="text-xl font-bold font-display text-slate-900 font-normal">{{ $sales['name'] }} (NPK: {{ $sales['npk'] }})</h1>
            <p class="text-xs text-slate-500 font-mono tabular-nums">SAP SlpCode: {{ $sales['slp_code'] }} | Area: {{ $sales['area'] }} ({{ $sales['region'] }})</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('master.sales') }}" class="px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 text-xs font-semibold shadow-xs active:translate-y-px transition-all">
                Kembali ke Direktori
            </a>
        </div>
    </div>

    <!-- 4 KPI Performance Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">TARGET VS AKTUAL</span>
            <div class="text-xl font-bold font-mono tabular-nums text-slate-900 mt-1">Rp {{ number_format($sales['actual'], 0, ',', '.') }}</div>
            <div class="text-[11px] text-emerald-700 mt-0.5 font-bold font-mono tabular-nums">Pencapaian: {{ $sales['achievement'] }}%</div>
        </div>

        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">REPEAT ORDER (RO)</span>
            <div class="text-xl font-bold font-mono tabular-nums text-accent mt-1">{{ $sales['ro_rate'] }}%</div>
            <div class="text-[11px] text-slate-500 mt-0.5">Tingkat Repeat Order</div>
        </div>

        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">RO ACTIVE OUTLET (ROA)</span>
            <div class="text-xl font-bold font-mono tabular-nums text-secondary mt-1">{{ $sales['roa_rate'] }}%</div>
            <div class="text-[11px] text-slate-500 mt-0.5">Cakupan Outlet Aktif</div>
        </div>

        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">EFFECTIVE CALL (EC)</span>
            <div class="text-xl font-bold font-mono tabular-nums text-primary mt-1">{{ $sales['ec_rate'] }}%</div>
            <div class="text-[11px] text-slate-500 mt-0.5">Kepatuhan Kunjungan</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile & Route Information -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs space-y-4">
            <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2 font-normal">
                <i class="mdi mdi-account-outline text-primary text-lg"></i> Informasi Profil & Kendaraan
            </h3>
            <div class="space-y-3 text-xs divide-y divide-slate-100">
                <div class="pt-2 flex justify-between">
                    <span class="text-slate-500">Supervisor (ASM):</span>
                    <span class="font-semibold text-slate-900">{{ $sales['asm'] }}</span>
                </div>
                <div class="pt-2 flex justify-between">
                    <span class="text-slate-500">Manager Area:</span>
                    <span class="font-semibold text-slate-900">{{ $sales['manager'] }}</span>
                </div>
                <div class="pt-2 flex justify-between">
                    <span class="text-slate-500">Nomor Telepon:</span>
                    <span class="font-mono tabular-nums text-slate-700">{{ $sales['phone'] }}</span>
                </div>
                <div class="pt-2 flex justify-between">
                    <span class="text-slate-500">Plat Armada:</span>
                    <span class="font-mono tabular-nums text-primary font-bold">{{ $sales['vehicle_plate'] }}</span>
                </div>
                <div class="pt-2 flex justify-between">
                    <span class="text-slate-500">Outlet Dikelola:</span>
                    <span class="font-bold font-mono tabular-nums text-emerald-700">{{ number_format(count($outlets), 0, ',', '.') }} Outlet</span>
                </div>
            </div>
        </div>

        <!-- Assigned Outlets Table -->
        <div class="lg:col-span-2 bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs space-y-4">
            <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2 font-normal">
                <i class="mdi mdi-store-outline text-primary text-lg"></i> Outlet Assigned ({{ number_format(count($outlets), 0, ',', '.') }})
            </h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] border-b border-slate-200">
                        <tr>
                            <th class="py-2.5 px-3">KODE SAP</th>
                            <th class="py-2.5 px-3">NAMA OUTLET</th>
                            <th class="py-2.5 px-3">KANAL</th>
                            <th class="py-2.5 px-3">ALAMAT</th>
                            <th class="py-2.5 px-3 text-center">STATUS RO</th>
                            <th class="py-2.5 px-3 text-right">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($outlets as $o)
                        <tr class="hover:bg-slate-50">
                            <td class="py-2.5 px-3 font-mono tabular-nums font-bold text-primary">{{ $o['card_code'] }}</td>
                            <td class="py-2.5 px-3 font-bold text-slate-900">{{ $o['card_name'] }}</td>
                            <td class="py-2.5 px-3 font-semibold text-slate-700">
                                <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-700 text-[10px] border border-slate-200">
                                    {{ $o['market'] }}
                                </span>
                            </td>
                            <td class="py-2.5 px-3 text-slate-500">{{ $o['address'] }}</td>
                            <td class="py-2.5 px-3 text-center">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold border {{ $o['ro_status'] === 'Active' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : ($o['ro_status'] === 'Warning' ? 'bg-amber-50 text-amber-700 border-amber-200' : 'bg-rose-50 text-rose-700 border-rose-200') }}">
                                    {{ $o['ro_status'] }}
                                </span>
                            </td>
                            <td class="py-2.5 px-3 text-right">
                                <a href="{{ route('master.outlet.detail', $o['card_code']) }}" class="text-xs text-primary font-bold hover:underline">Lihat</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
