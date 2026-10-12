@extends('layouts.app')

@section('title', 'Detail Outlet - ' . $outlet['card_name'])

@section('content')
<div class="space-y-6">

    <!-- Header Breadcrumb -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
        <div>
            <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
                <a href="{{ route('master.outlet') }}" class="hover:underline hover:text-primary transition-colors">Manajemen Outlet</a>
                <i class="mdi mdi-chevron-right text-xs"></i>
                <span class="text-slate-700 font-semibold">Detail Outlet</span>
            </div>
            <h1 class="text-xl font-bold font-display text-slate-900 font-normal">{{ $outlet['card_name'] }}</h1>
            <p class="text-xs text-slate-500 font-mono tabular-nums">SAP CardCode: {{ $outlet['card_code'] }} | Kanal: {{ $outlet['market'] }} | Sales: {{ $outlet['sales_name'] }}</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="px-3 py-1.5 rounded-full text-xs font-bold border flex items-center gap-1.5 {{ $outlet['ro_status'] === 'Active' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-amber-50 text-amber-700 border-amber-200' }}">
                <span>{{ $outlet['ro_status_color'] }}</span>
                <span>Status RO: {{ $outlet['ro_status'] }}</span>
            </span>
            <a href="{{ route('master.outlet') }}" class="px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 text-xs font-semibold shadow-xs active:translate-y-px transition-all">
                Kembali ke Outlet
            </a>
        </div>
    </div>

    <!-- Top Info Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Outlet Profile & SAP Fields -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs space-y-4">
            <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2 font-normal">
                <i class="mdi mdi-office-building text-primary text-lg"></i> Profil Outlet & Kolom SAP OCRD
            </h3>
            <div class="space-y-3 text-xs divide-y divide-slate-100">
                <div class="pt-2 flex justify-between font-mono tabular-nums">
                    <span class="text-slate-500 font-sans">CardType:</span>
                    <span class="text-slate-900 font-bold">{{ $outlet['card_type'] }}</span>
                </div>
                <div class="pt-2 flex justify-between font-mono tabular-nums">
                    <span class="text-slate-500 font-sans">GroupCode:</span>
                    <span class="text-slate-900 font-bold">{{ $outlet['group_code'] }}</span>
                </div>
                <div class="pt-2 flex justify-between font-mono tabular-nums">
                    <span class="text-slate-500 font-sans">SlpCode Sales:</span>
                    <span class="text-primary font-bold">{{ $outlet['slp_code'] }} ({{ $outlet['sales_name'] }})</span>
                </div>
                <div class="pt-2 flex justify-between font-mono tabular-nums">
                    <span class="text-slate-500 font-sans">Telepon / Kontak:</span>
                    <span class="text-slate-700">{{ $outlet['phone'] }}</span>
                </div>
                <div class="pt-2 flex justify-between">
                    <span class="text-slate-500">Alamat Lengkap:</span>
                    <span class="text-slate-800 text-right">{{ $outlet['address'] }}, {{ $outlet['kecamatan'] }}, {{ $outlet['kabupaten'] }}</span>
                </div>
                <div class="pt-2 flex justify-between font-mono tabular-nums">
                    <span class="text-slate-500 font-sans">Pesanan Terakhir:</span>
                    <span class="font-bold text-emerald-700">{{ $outlet['last_order_date'] }}</span>
                </div>
            </div>
        </div>

        <!-- GPS Location & Map Mock -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs space-y-4">
            <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2 font-normal">
                <i class="mdi mdi-map-marker text-primary text-lg"></i> Lokasi & Koordinat GPS
            </h3>
            <div class="bg-slate-50 border border-slate-200/60 rounded-xl p-4 text-center space-y-3">
                <div class="w-full h-32 bg-white rounded-lg flex items-center justify-center border border-slate-200 relative overflow-hidden">
                    <div class="absolute inset-0 bg-[radial-gradient(#e2e8f0_1px,transparent_1px)] [background-size:16px_16px] opacity-60"></div>
                    <div class="relative z-10 flex flex-col items-center">
                        <i class="mdi mdi-map-marker text-primary text-3xl animate-bounce"></i>
                        <span class="text-xs font-bold text-slate-900 mt-1">{{ $outlet['card_name'] }}</span>
                    </div>
                </div>
                <div class="text-xs font-mono tabular-nums text-slate-700">
                    Lat: {{ $outlet['latitude'] }} | Lng: {{ $outlet['longitude'] }}
                </div>
                <a href="https://maps.google.com/?q={{ $outlet['latitude'] }},{{ $outlet['longitude'] }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs text-primary font-bold hover:underline active:translate-y-px">
                    <span>Buka di Google Maps</span>
                    <i class="mdi mdi-open-in-new text-xs"></i>
                </a>
            </div>
        </div>

        <!-- Purchased SKU History -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs space-y-4">
            <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2 font-normal">
                <i class="mdi mdi-package-variant-closed text-primary text-lg"></i> Riwayat Pembelian Produk (SKU)
            </h3>
            <div class="space-y-2">
                @foreach($outlet['products_purchased'] as $sku)
                <div class="p-3 bg-slate-50 border border-slate-200/60 rounded-xl flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold text-slate-900 block font-mono tabular-nums">SKU: {{ $sku }}</span>
                        <span class="text-[10px] text-emerald-700 font-semibold">Varian Aktif Teh Dandang</span>
                    </div>
                    <span class="px-2 py-0.5 rounded text-[10px] bg-emerald-50 text-emerald-700 font-bold border border-emerald-200">Aktif</span>
                </div>
                @endforeach
            </div>
        </div>

    </div>

    <!-- Order History (SAP ORDR / RDR1) -->
    <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs space-y-4">
        <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2 font-normal">
            <i class="mdi mdi-cart-outline text-primary text-lg"></i> Riwayat Sales Order (Pemetaan SAP ORDR / RDR1)
        </h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] border-b border-slate-200">
                    <tr>
                        <th class="py-2.5 px-3">NO DOKUMEN</th>
                        <th class="py-2.5 px-3">SAP DOCENTRY</th>
                        <th class="py-2.5 px-3">TANGGAL</th>
                        <th class="py-2.5 px-3">TENAGA PENJUAL</th>
                        <th class="py-2.5 px-3">SUBTOTAL</th>
                        <th class="py-2.5 px-3">GRAND TOTAL</th>
                        <th class="py-2.5 px-3 text-center">STATUS SINKRONISASI SAP</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($orders as $ord)
                    <tr class="hover:bg-slate-50">
                        <td class="py-2.5 px-3 font-mono tabular-nums font-bold text-primary">#{{ $ord['doc_num'] }}</td>
                        <td class="py-2.5 px-3 font-mono tabular-nums text-slate-500">{{ $ord['sap_doc_entry'] }}</td>
                        <td class="py-2.5 px-3 text-slate-600 font-mono tabular-nums">{{ $ord['doc_date'] }}</td>
                        <td class="py-2.5 px-3 font-semibold text-slate-800">{{ $ord['slp_name'] }}</td>
                        <td class="py-2.5 px-3 font-mono tabular-nums">Rp {{ number_format($ord['subtotal'], 0, ',', '.') }}</td>
                        <td class="py-2.5 px-3 font-bold text-emerald-700 font-mono tabular-nums">Rp {{ number_format($ord['doc_total'], 0, ',', '.') }}</td>
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
