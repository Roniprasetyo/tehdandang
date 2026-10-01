@extends('layouts.app')

@section('title', 'Detail Outlet - ' . $outlet['card_name'])

@section('content')
<div class="space-y-6">

    <!-- Header Breadcrumb -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
        <div>
            <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
                <a href="{{ route('master.outlet') }}" class="hover:underline">Outlet Management</a>
                <i data-lucide="chevron-right" class="w-3 h-3"></i>
                <span class="text-slate-700 font-semibold">Detail Outlet</span>
            </div>
            <h1 class="text-xl font-bold font-display text-slate-900">{{ $outlet['card_name'] }}</h1>
            <p class="text-xs text-slate-500">SAP CardCode: {{ $outlet['card_code'] }} | Market: {{ $outlet['market'] }} | Sales: {{ $outlet['sales_name'] }}</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="px-3 py-1.5 rounded-full text-xs font-bold border flex items-center gap-1.5 {{ $outlet['ro_status'] === 'Active' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-amber-50 text-amber-700 border-amber-200' }}">
                <span>{{ $outlet['ro_status_color'] }}</span>
                <span>RO Status: {{ $outlet['ro_status'] }}</span>
            </span>
            <a href="{{ route('master.outlet') }}" class="px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 text-xs font-semibold shadow-xs">
                Back to Outlets
            </a>
        </div>
    </div>

    <!-- Top Info Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Outlet Profile & SAP Fields -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs space-y-4">
            <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                <i data-lucide="building" class="w-4 h-4 text-indigo-600"></i> Outlet Profile & SAP OCRD Fields
            </h3>
            <div class="space-y-3 text-xs divide-y divide-slate-100">
                <div class="pt-2 flex justify-between">
                    <span class="text-slate-500">CardType:</span>
                    <span class="font-mono text-slate-900 font-bold">{{ $outlet['card_type'] }}</span>
                </div>
                <div class="pt-2 flex justify-between">
                    <span class="text-slate-500">GroupCode:</span>
                    <span class="font-mono text-slate-900 font-bold">{{ $outlet['group_code'] }}</span>
                </div>
                <div class="pt-2 flex justify-between">
                    <span class="text-slate-500">SlpCode Sales:</span>
                    <span class="font-mono text-indigo-600 font-bold">{{ $outlet['slp_code'] }} ({{ $outlet['sales_name'] }})</span>
                </div>
                <div class="pt-2 flex justify-between">
                    <span class="text-slate-500">Telepon / Email:</span>
                    <span class="font-mono text-slate-700">{{ $outlet['phone'] }}</span>
                </div>
                <div class="pt-2 flex justify-between">
                    <span class="text-slate-500">Alamat Lengkap:</span>
                    <span class="text-slate-800 text-right">{{ $outlet['address'] }}, {{ $outlet['kecamatan'] }}, {{ $outlet['kabupaten'] }}</span>
                </div>
                <div class="pt-2 flex justify-between">
                    <span class="text-slate-500">Last Order Date:</span>
                    <span class="font-bold text-emerald-600">{{ $outlet['last_order_date'] }}</span>
                </div>
            </div>
        </div>

        <!-- GPS Location & Map Mock -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs space-y-4">
            <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                <i data-lucide="map-pin" class="w-4 h-4 text-indigo-600"></i> Location & GPS Coordinate
            </h3>
            <div class="bg-slate-50 border border-slate-200/60 rounded-xl p-4 text-center space-y-3">
                <div class="w-full h-32 bg-white rounded-lg flex items-center justify-center border border-slate-200 relative overflow-hidden">
                    <div class="absolute inset-0 bg-[radial-gradient(#e2e8f0_1px,transparent_1px)] [background-size:16px_16px] opacity-60"></div>
                    <div class="relative z-10 flex flex-col items-center">
                        <i data-lucide="map-pin" class="w-8 h-8 text-indigo-600 animate-bounce"></i>
                        <span class="text-xs font-bold text-slate-900 mt-1">{{ $outlet['card_name'] }}</span>
                    </div>
                </div>
                <div class="text-xs font-mono text-slate-700">
                    Lat: {{ $outlet['latitude'] }} | Lng: {{ $outlet['longitude'] }}
                </div>
                <a href="https://maps.google.com/?q={{ $outlet['latitude'] }},{{ $outlet['longitude'] }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs text-indigo-600 font-bold hover:underline">
                    <span>Buka di Google Maps</span>
                    <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                </a>
            </div>
        </div>

        <!-- Purchased SKU History -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs space-y-4">
            <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                <i data-lucide="box" class="w-4 h-4 text-emerald-600"></i> Products Purchased (SKU History)
            </h3>
            <div class="space-y-2">
                @foreach($outlet['products_purchased'] as $sku)
                <div class="p-3 bg-slate-50 border border-slate-200/60 rounded-xl flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold text-slate-900 block">SKU Code: {{ $sku }}</span>
                        <span class="text-[10px] text-emerald-600 font-semibold">Teh Dandang Active Item</span>
                    </div>
                    <span class="px-2 py-0.5 rounded text-[10px] bg-emerald-50 text-emerald-700 font-bold border border-emerald-200">Active</span>
                </div>
                @endforeach
            </div>
        </div>

    </div>

    <!-- Order History (SAP ORDR / RDR1) -->
    <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs space-y-4">
        <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
            <i data-lucide="shopping-cart" class="w-4 h-4 text-indigo-600"></i> Riwayat Sales Order (SAP ORDR / RDR1 Mapped)
        </h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] border-b border-slate-200">
                    <tr>
                        <th class="py-2.5 px-3">DOCNUM</th>
                        <th class="py-2.5 px-3">SAP DOCENTRY</th>
                        <th class="py-2.5 px-3">DOCDATE</th>
                        <th class="py-2.5 px-3">SALES PERSON</th>
                        <th class="py-2.5 px-3">SUBTOTAL</th>
                        <th class="py-2.5 px-3">GRAND TOTAL</th>
                        <th class="py-2.5 px-3 text-center">SAP SYNC STATUS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($orders as $ord)
                    <tr class="hover:bg-slate-50">
                        <td class="py-2.5 px-3 font-mono font-bold text-indigo-600">#{{ $ord['doc_num'] }}</td>
                        <td class="py-2.5 px-3 font-mono text-slate-500">{{ $ord['sap_doc_entry'] }}</td>
                        <td class="py-2.5 px-3 text-slate-600">{{ $ord['doc_date'] }}</td>
                        <td class="py-2.5 px-3 font-semibold text-slate-800">{{ $ord['slp_name'] }}</td>
                        <td class="py-2.5 px-3">Rp {{ number_format($ord['subtotal'], 0, ',', '.') }}</td>
                        <td class="py-2.5 px-3 font-bold text-emerald-600">Rp {{ number_format($ord['doc_total'], 0, ',', '.') }}</td>
                        <td class="py-2.5 px-3 text-center">
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                {{ $ord['sap_status'] }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-4 text-center text-slate-400">Belum ada transaksi Sales Order untuk outlet ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
