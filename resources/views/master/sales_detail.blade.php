@extends('layouts.app')

@section('title', 'Detail Sales - ' . $sales['name'])

@section('content')
<div class="space-y-6">

    <!-- Header Breadcrumb & Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
        <div>
            <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
                <a href="{{ route('master.sales') }}" class="hover:underline">Sales Directory</a>
                <i data-lucide="chevron-right" class="w-3 h-3"></i>
                <span class="text-slate-700 font-semibold">Detail Sales</span>
            </div>
            <h1 class="text-xl font-bold font-display text-slate-900">{{ $sales['name'] }} (NPK: {{ $sales['npk'] }})</h1>
            <p class="text-xs text-slate-500">SAP SlpCode: {{ $sales['slp_code'] }} | Area: {{ $sales['area'] }} ({{ $sales['region'] }})</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('master.sales') }}" class="px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 text-xs font-semibold shadow-xs">
                Back to Directory
            </a>
        </div>
    </div>

    <!-- 4 KPI Performance Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">TARGET VS ACTUAL</span>
            <div class="text-xl font-bold text-slate-900 mt-1">Rp {{ number_format($sales['actual'], 0, ',', '.') }}</div>
            <div class="text-[11px] text-emerald-600 mt-0.5 font-bold">Achievement: {{ $sales['achievement'] }}%</div>
        </div>

        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">REPEAT ORDER (RO)</span>
            <div class="text-xl font-bold text-cyan-600 mt-1">{{ $sales['ro_rate'] }}%</div>
            <div class="text-[11px] text-slate-500 mt-0.5">Performance Rate</div>
        </div>

        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">RO ACTIVE OUTLET (ROA)</span>
            <div class="text-xl font-bold text-amber-600 mt-1">{{ $sales['roa_rate'] }}%</div>
            <div class="text-[11px] text-slate-500 mt-0.5">Active Outlet Coverage</div>
        </div>

        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">EFFECTIVE CALL (EC)</span>
            <div class="text-xl font-bold text-purple-600 mt-1">{{ $sales['ec_rate'] }}%</div>
            <div class="text-[11px] text-slate-500 mt-0.5">Call Compliance</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile & Route Information -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs space-y-4">
            <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                <i data-lucide="user" class="w-4 h-4 text-indigo-600"></i> Profile & Vehicle Info
            </h3>
            <div class="space-y-3 text-xs divide-y divide-slate-100">
                <div class="pt-2 flex justify-between">
                    <span class="text-slate-500">ASM Supervisor:</span>
                    <span class="font-semibold text-slate-900">{{ $sales['asm'] }}</span>
                </div>
                <div class="pt-2 flex justify-between">
                    <span class="text-slate-500">Manager:</span>
                    <span class="font-semibold text-slate-900">{{ $sales['manager'] }}</span>
                </div>
                <div class="pt-2 flex justify-between">
                    <span class="text-slate-500">Nomor Telepon:</span>
                    <span class="font-mono text-slate-700">{{ $sales['phone'] }}</span>
                </div>
                <div class="pt-2 flex justify-between">
                    <span class="text-slate-500">Plat Kendaraan:</span>
                    <span class="font-mono text-indigo-600 font-bold">{{ $sales['vehicle_plate'] }}</span>
                </div>
                <div class="pt-2 flex justify-between">
                    <span class="text-slate-500">Jumlah Outlet Assigned:</span>
                    <span class="font-bold text-emerald-600">{{ number_format(count($outlets), 0, ',', '.') }} Outlets</span>
                </div>
            </div>
        </div>

        <!-- Assigned Outlets Table -->
        <div class="lg:col-span-2 bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs space-y-4">
            <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                <i data-lucide="store" class="w-4 h-4 text-emerald-600"></i> Outlet Assigned ({{ number_format(count($outlets), 0, ',', '.') }})
            </h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] border-b border-slate-200">
                        <tr>
                            <th class="py-2.5 px-3">CARDCODE</th>
                            <th class="py-2.5 px-3">OUTLET NAME</th>
                            <th class="py-2.5 px-3">MARKET</th>
                            <th class="py-2.5 px-3">ADDRESS</th>
                            <th class="py-2.5 px-3 text-center">RO STATUS</th>
                            <th class="py-2.5 px-3 text-right">ACTION</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($outlets as $o)
                        <tr class="hover:bg-slate-50">
                            <td class="py-2.5 px-3 font-mono font-bold text-indigo-600">{{ $o['card_code'] }}</td>
                            <td class="py-2.5 px-3 font-bold text-slate-900">{{ $o['card_name'] }}</td>
                            <td class="py-2.5 px-3 font-semibold text-slate-700">{{ $o['market'] }}</td>
                            <td class="py-2.5 px-3 text-slate-500">{{ $o['address'] }}</td>
                            <td class="py-2.5 px-3 text-center">{{ $o['ro_status_color'] }} {{ $o['ro_status'] }}</td>
                            <td class="py-2.5 px-3 text-right">
                                <a href="{{ route('master.outlet.detail', $o['card_code']) }}" class="text-xs text-indigo-600 font-bold hover:underline">View</a>
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
