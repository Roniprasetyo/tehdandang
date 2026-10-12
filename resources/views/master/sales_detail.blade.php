@extends('layouts.app')

@section('title', 'Detail Tenaga Penjual - ' . $sales['name'])

@section('content')
<div class="space-y-6">

    <!-- Header & Aksi Utama -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-xl border border-slate-200/90 shadow-xs">
        <div>
            @include('partials.breadcrumb')
            <h1 class="text-xl font-semibold text-slate-900">{{ $sales['name'] }}</h1>
            <p class="text-xs text-slate-500 mt-1 font-mono tabular-nums">NPK: {{ $sales['npk'] }} &bull; SAP SlpCode: {{ $sales['slp_code'] }} &bull; Area: {{ $sales['area'] }} ({{ $sales['region'] }})</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('master.sales') }}" class="btn-secondary-outline">
                <i class="mdi mdi-arrow-left text-base"></i>
                <span>Kembali ke Direktori</span>
            </a>
        </div>
    </div>

    <!-- 4 Ringkasan Metrik Konsisten -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white border border-slate-200/90 rounded-xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-xs font-medium text-slate-500 block">Target vs Aktual</span>
                <span class="text-2xl font-semibold font-mono tabular-nums text-slate-900 mt-1 block">Rp {{ number_format($sales['actual'], 0, ',', '.') }}</span>
                <span class="text-xs text-primary font-medium mt-1 block font-mono">Pencapaian: {{ $sales['achievement'] }}%</span>
            </div>
            <div class="w-9 h-9 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center text-lg flex-shrink-0">
                <i class="mdi mdi-target"></i>
            </div>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-xs font-medium text-slate-500 block">Repeat Order (RO)</span>
                <span class="text-2xl font-semibold font-mono tabular-nums text-accent mt-1 block">{{ $sales['ro_rate'] }}%</span>
                <span class="text-xs text-slate-500 mt-1 block">Tingkat repeat order</span>
            </div>
            <div class="w-9 h-9 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center text-lg flex-shrink-0">
                <i class="mdi mdi-repeat"></i>
            </div>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-xs font-medium text-slate-500 block">RO Active Outlet (ROA)</span>
                <span class="text-2xl font-semibold font-mono tabular-nums text-secondary mt-1 block">{{ $sales['roa_rate'] }}%</span>
                <span class="text-xs text-slate-500 mt-1 block">Cakupan outlet aktif</span>
            </div>
            <div class="w-9 h-9 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center text-lg flex-shrink-0">
                <i class="mdi mdi-store-check-outline"></i>
            </div>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-xs font-medium text-slate-500 block">Effective Call (EC)</span>
                <span class="text-2xl font-semibold font-mono tabular-nums text-primary mt-1 block">{{ $sales['ec_rate'] }}%</span>
                <span class="text-xs text-slate-500 mt-1 block">Kepatuhan kunjungan</span>
            </div>
            <div class="w-9 h-9 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center text-lg flex-shrink-0">
                <i class="mdi mdi-phone-check-outline"></i>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile & Route Information -->
        <div class="bg-white border border-slate-200/90 rounded-xl p-5 shadow-xs space-y-4">
            <h3 class="text-sm font-semibold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-3">
                <i class="mdi mdi-account-outline text-primary text-base"></i> Profil & Armada Sales
            </h3>
            <div class="space-y-3 text-xs divide-y divide-slate-100">
                <div class="pt-2 flex justify-between">
                    <span class="text-slate-500">Supervisor (ASM)</span>
                    <span class="font-medium text-slate-900">{{ $sales['asm'] }}</span>
                </div>
                <div class="pt-2 flex justify-between">
                    <span class="text-slate-500">Manager Area</span>
                    <span class="font-medium text-slate-900">{{ $sales['manager'] }}</span>
                </div>
                <div class="pt-2 flex justify-between">
                    <span class="text-slate-500">Nomor Telepon</span>
                    <span class="font-mono tabular-nums text-slate-700">{{ $sales['phone'] }}</span>
                </div>
                <div class="pt-2 flex justify-between">
                    <span class="text-slate-500">Plat Armada</span>
                    <span class="font-mono tabular-nums text-primary font-medium">{{ $sales['vehicle_plate'] }}</span>
                </div>
                <div class="pt-2 flex justify-between">
                    <span class="text-slate-500">Outlet Dikelola</span>
                    <span class="font-medium font-mono tabular-nums text-slate-900">{{ number_format(count($outlets), 0, ',', '.') }} Outlet</span>
                </div>
            </div>
        </div>

        <!-- Assigned Outlets Table -->
        <div class="lg:col-span-2 bg-white border border-slate-200/90 rounded-xl p-5 shadow-xs space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="text-sm font-semibold text-slate-900 flex items-center gap-2">
                    <i class="mdi mdi-store-outline text-primary text-base"></i> Outlet Dikelola ({{ number_format(count($outlets), 0, ',', '.') }})
                </h3>
            </div>
            <div class="overflow-x-auto rounded-lg border border-slate-200">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-50 text-slate-600 uppercase text-[11px] font-semibold tracking-wider border-b border-slate-200">
                        <tr>
                            <th class="py-3 px-3.5">Kode SAP</th>
                            <th class="py-3 px-3.5">Nama Outlet</th>
                            <th class="py-3 px-3.5">Kanal</th>
                            <th class="py-3 px-3.5">Alamat</th>
                            <th class="py-3 px-3.5 text-center">Status RO</th>
                            <th class="py-3 px-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($outlets as $o)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3 px-3.5 font-mono tabular-nums font-medium text-primary">{{ $o['card_code'] }}</td>
                            <td class="py-3 px-3.5 font-medium text-slate-900">{{ $o['card_name'] }}</td>
                            <td class="py-3 px-3.5">
                                <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-700 text-[11px] font-medium border border-slate-200">
                                    {{ $o['market'] }}
                                </span>
                            </td>
                            <td class="py-3 px-3.5 text-slate-500">{{ $o['address'] }}</td>
                            <td class="py-3 px-3.5 text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium border {{ $o['ro_status'] === 'Active' ? 'bg-primary-50 text-primary-700 border-primary-200' : ($o['ro_status'] === 'Warning' ? 'bg-amber-50 text-amber-700 border-amber-200' : 'bg-rose-50 text-rose-700 border-rose-200') }}">
                                    <i class="mdi {{ $o['ro_status'] === 'Active' ? 'mdi-check-circle-outline' : ($o['ro_status'] === 'Warning' ? 'mdi-alert-circle-outline' : 'mdi-close-circle-outline') }} mr-1"></i>
                                    <span>{{ $o['ro_status'] === 'Active' ? 'Aktif' : ($o['ro_status'] === 'Warning' ? 'Peringatan' : 'Inaktif') }}</span>
                                </span>
                            </td>
                            <td class="py-3 px-3.5 text-right">
                                <a href="{{ route('master.outlet.detail', $o['card_code']) }}" class="text-xs text-primary font-medium hover:underline">Lihat</a>
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
