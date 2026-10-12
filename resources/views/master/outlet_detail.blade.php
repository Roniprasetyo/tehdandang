@extends('layouts.app')

@section('title', 'Detail Outlet - ' . $outlet['card_name'])

@section('content')
<div class="space-y-6">

    <!-- Header & Aksi Utama -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-xl border border-slate-200/90 shadow-xs">
        <div>
            <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
                <a href="{{ route('master.outlet') }}" class="hover:underline hover:text-primary transition-colors">Manajemen Outlet</a>
                <i class="mdi mdi-chevron-right text-xs"></i>
                <span class="text-slate-700 font-medium">Detail Outlet</span>
            </div>
            <h1 class="text-xl font-semibold text-slate-900">{{ $outlet['card_name'] }}</h1>
            <p class="text-xs text-slate-500 mt-1 font-mono tabular-nums">SAP CardCode: {{ $outlet['card_code'] }} &bull; Kanal: {{ $outlet['market'] }} &bull; Sales: {{ $outlet['sales_name'] }}</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium border {{ $outlet['ro_status'] === 'Active' ? 'bg-primary-50 text-primary-700 border-primary-200' : 'bg-amber-50 text-amber-700 border-amber-200' }}">
                <i class="mdi {{ $outlet['ro_status'] === 'Active' ? 'mdi-check-circle-outline' : 'mdi-alert-circle-outline' }} mr-1"></i>
                <span>Status RO: {{ $outlet['ro_status'] === 'Active' ? 'Aktif' : 'Peringatan' }}</span>
            </span>
            <a href="{{ route('master.outlet') }}" class="btn-secondary-outline">
                <i class="mdi mdi-arrow-left text-base"></i>
                <span>Kembali ke Outlet</span>
            </a>
        </div>
    </div>

    <!-- Top Info Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Outlet Profile & SAP Fields -->
        <div class="bg-white border border-slate-200/90 rounded-xl p-5 shadow-xs space-y-4">
            <h3 class="text-sm font-semibold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-3">
                <i class="mdi mdi-office-building text-primary text-base"></i> Profil Outlet & Data SAP OCRD
            </h3>
            <div class="space-y-3 text-xs divide-y divide-slate-100">
                <div class="pt-2 flex justify-between font-mono tabular-nums">
                    <span class="text-slate-500 font-sans">CardType</span>
                    <span class="text-slate-900 font-medium">{{ $outlet['card_type'] }}</span>
                </div>
                <div class="pt-2 flex justify-between font-mono tabular-nums">
                    <span class="text-slate-500 font-sans">GroupCode</span>
                    <span class="text-slate-900 font-medium">{{ $outlet['group_code'] }}</span>
                </div>
                <div class="pt-2 flex justify-between font-mono tabular-nums">
                    <span class="text-slate-500 font-sans">SlpCode Sales</span>
                    <span class="text-primary font-medium">{{ $outlet['slp_code'] }} ({{ $outlet['sales_name'] }})</span>
                </div>
                <div class="pt-2 flex justify-between font-mono tabular-nums">
                    <span class="text-slate-500 font-sans">Telepon / Kontak</span>
                    <span class="text-slate-700">{{ $outlet['phone'] }}</span>
                </div>
                <div class="pt-2 flex justify-between">
                    <span class="text-slate-500">Alamat Lengkap</span>
                    <span class="text-slate-800 text-right">{{ $outlet['address'] }}, {{ $outlet['kecamatan'] }}, {{ $outlet['kabupaten'] }}</span>
                </div>
                <div class="pt-2 flex justify-between font-mono tabular-nums">
                    <span class="text-slate-500 font-sans">Pesanan Terakhir</span>
                    <span class="font-medium text-primary">{{ $outlet['last_order_date'] }}</span>
                </div>
            </div>
        </div>

        <!-- GPS Location & Map Mock -->
        <div class="bg-white border border-slate-200/90 rounded-xl p-5 shadow-xs space-y-4">
            <h3 class="text-sm font-semibold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-3">
                <i class="mdi mdi-map-marker text-primary text-base"></i> Lokasi & Titik GPS
            </h3>
            <div class="bg-slate-50 border border-slate-200/60 rounded-lg p-4 text-center space-y-3">
                <div class="w-full h-32 bg-white rounded-lg flex items-center justify-center border border-slate-200 relative overflow-hidden">
                    <div class="absolute inset-0 bg-[radial-gradient(#e2e8f0_1px,transparent_1px)] [background-size:16px_16px] opacity-60"></div>
                    <div class="relative z-10 flex flex-col items-center">
                        <i class="mdi mdi-map-marker text-primary text-3xl"></i>
                        <span class="text-xs font-medium text-slate-900 mt-1">{{ $outlet['card_name'] }}</span>
                    </div>
                </div>
                <div class="text-xs font-mono tabular-nums text-slate-600">
                    Lat: {{ $outlet['latitude'] }} &bull; Lng: {{ $outlet['longitude'] }}
                </div>
                <a href="https://maps.google.com/?q={{ $outlet['latitude'] }},{{ $outlet['longitude'] }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs text-primary font-medium hover:underline">
                    <span>Buka di Google Maps</span>
                    <i class="mdi mdi-open-in-new text-xs"></i>
                </a>
            </div>
        </div>

        <!-- Purchased SKU History -->
        <div class="bg-white border border-slate-200/90 rounded-xl p-5 shadow-xs space-y-4">
            <h3 class="text-sm font-semibold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-3">
                <i class="mdi mdi-package-variant-closed text-primary text-base"></i> Riwayat SKU Dibeli
            </h3>
            <div class="space-y-2">
                @foreach($outlet['products_purchased'] as $sku)
                <div class="p-3 bg-slate-50 border border-slate-200/60 rounded-lg flex items-center justify-between">
                    <div>
                        <span class="text-xs font-medium text-slate-900 block font-mono tabular-nums">SKU: {{ $sku }}</span>
                        <span class="text-[11px] text-slate-500">Varian Teh Dandang</span>
                    </div>
                    <span class="px-2 py-0.5 rounded text-[11px] bg-primary-50 text-primary-700 font-medium border border-primary-200">Aktif</span>
                </div>
                @endforeach
            </div>
        </div>

    </div>

    <!-- Order History (SAP ORDR / RDR1) -->
    <div class="bg-white border border-slate-200/90 rounded-xl p-5 shadow-xs space-y-4">
        <h3 class="text-sm font-semibold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-3">
            <i class="mdi mdi-cart-outline text-primary text-base"></i> Riwayat Pesanan Penjualan (SAP ORDR)
        </h3>
        <div class="overflow-x-auto rounded-lg border border-slate-200">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-600 uppercase text-[11px] font-semibold tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-3.5">No Dokumen</th>
                        <th class="py-3 px-3.5">SAP DocEntry</th>
                        <th class="py-3 px-3.5">Tanggal</th>
                        <th class="py-3 px-3.5">Sales Person</th>
                        <th class="py-3 px-3.5">Subtotal</th>
                        <th class="py-3 px-3.5">Total Akhir</th>
                        <th class="py-3 px-3.5 text-center">Status SAP</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($orders as $ord)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="py-3 px-3.5 font-mono tabular-nums font-medium text-primary">#{{ $ord['doc_num'] }}</td>
                        <td class="py-3 px-3.5 font-mono tabular-nums text-slate-500">{{ $ord['sap_doc_entry'] }}</td>
                        <td class="py-3 px-3.5 text-slate-600 font-mono tabular-nums">{{ $ord['doc_date'] }}</td>
                        <td class="py-3 px-3.5 text-slate-800 font-medium">{{ $ord['slp_name'] }}</td>
                        <td class="py-3 px-3.5 font-mono tabular-nums">Rp {{ number_format($ord['subtotal'], 0, ',', '.') }}</td>
                        <td class="py-3 px-3.5 font-medium text-primary font-mono tabular-nums">Rp {{ number_format($ord['doc_total'], 0, ',', '.') }}</td>
                        <td class="py-3 px-3.5 text-center">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium bg-primary-50 text-primary-700 border border-primary-200">
                                <i class="mdi mdi-check-circle-outline mr-1"></i> {{ $ord['sap_status'] }}
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
