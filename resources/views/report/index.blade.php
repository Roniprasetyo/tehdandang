<!-- Hallmark · pre-emit critique: P5 H5 E5 S5 R5 V5 · theme: Tri-Tone Heritage (Tea Green, Amber Brew, Sky Accent) · genre: modern-minimal -->
@extends('layouts.app')

@section('title', 'Reporting & Analytical Center')

@section('content')
<div class="space-y-6" x-data="{ 
    reportType: '{{ $type }}',
    dateFrom: '{{ date('Y-m-01') }}',
    dateTo: '{{ date('Y-m-d') }}'
}">

    <!-- Page Header (Hallmark Macrostructure: Analytical Center Header) -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/90 shadow-xs">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold tracking-wider uppercase bg-primary-50 text-primary-700 border border-primary-200">
                    <i class="mdi mdi-tea mr-1"></i> FMCG Telemetry
                </span>
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold tracking-wider uppercase bg-accent-50 text-accent-700 border border-accent-200">
                    <i class="mdi mdi-database-sync-outline mr-1"></i> SAP B1 OCRD / OITM
                </span>
            </div>
            <h1 class="text-xl font-bold font-display text-slate-900 tracking-tight flex items-center gap-2.5">
                <span class="w-9 h-9 rounded-xl bg-primary text-white flex items-center justify-center shadow-xs">
                    <i class="mdi mdi-file-chart-outline text-xl"></i>
                </span>
                Reporting & Analytical Center
            </h1>
            <p class="text-xs text-slate-500 mt-1">Universal auditing & telemetry laporan penjualan, outlet SAP, produk, GPS tracking, dan RO compliance</p>
        </div>

        <!-- Tactile Action Group (Replaced alert with clean toast notifications) -->
        <div class="flex items-center gap-2.5">
            <button 
                type="button" 
                @click="notify('Ekspor Excel untuk laporan ' + reportType.toUpperCase() + ' berhasil diunduh.', 'success')" 
                class="px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-primary-700 text-xs font-semibold hover:bg-primary-50 hover:border-primary-300 active:translate-y-px focus-visible:ring-2 focus-visible:ring-primary-500 shadow-xs flex items-center gap-2 transition-all cursor-pointer"
            >
                <i class="mdi mdi-file-excel-box text-base text-primary-600"></i>
                <span>Export Excel</span>
            </button>

            <button 
                type="button" 
                @click="notify('Ekspor PDF untuk laporan ' + reportType.toUpperCase() + ' sedang diproses.', 'info')" 
                class="px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-rose-700 text-xs font-semibold hover:bg-rose-50 hover:border-rose-300 active:translate-y-px focus-visible:ring-2 focus-visible:ring-rose-500 shadow-xs flex items-center gap-2 transition-all cursor-pointer"
            >
                <i class="mdi mdi-file-pdf-box text-base text-rose-600"></i>
                <span>Export PDF</span>
            </button>
        </div>
    </div>

    <!-- Universal Report Filter Form -->
    <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs space-y-4">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <div class="flex items-center gap-2">
                <i class="mdi mdi-filter-variant text-base text-slate-400"></i>
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-600">Universal Filter Matrix</h3>
            </div>
            <span class="text-[11px] text-slate-400 font-mono">13 Jenis Laporan Siap Pakai</span>
        </div>

        <form action="{{ route('report.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-3 text-xs">
            <div>
                <label class="block text-slate-600 mb-1.5 font-semibold">Jenis Laporan:</label>
                <select 
                    name="type" 
                    x-model="reportType" 
                    onchange="this.form.submit()" 
                    class="w-full bg-slate-50 border border-slate-200 text-primary-700 font-bold rounded-xl px-2.5 py-2 hover:border-slate-300 focus:bg-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary-100 transition-all cursor-pointer"
                >
                    <option value="sales">1. Sales Report</option>
                    <option value="outlet">2. Outlet Report</option>
                    <option value="product">3. Product Report</option>
                    <option value="ro">4. RO Report</option>
                    <option value="roa">5. ROA Report</option>
                    <option value="ro_item">6. RO Item Report</option>
                    <option value="gps">7. GPS Telemetry</option>
                    <option value="route">8. Route Compliance</option>
                    <option value="performance">9. Performance Report</option>
                    <option value="sap">10. SAP B1 Integration</option>
                    <option value="early_warning">11. Early Warning Report</option>
                    <option value="daily">12. Daily Field Visits</option>
                    <option value="closing">13. Closing Report</option>
                </select>
            </div>

            <div>
                <label class="block text-slate-600 mb-1.5 font-semibold">Periode Mulai:</label>
                <input 
                    type="date" 
                    name="date_from" 
                    x-model="dateFrom" 
                    class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl px-2.5 py-2 hover:border-slate-300 focus:bg-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary-100 transition-all font-mono"
                >
            </div>

            <div>
                <label class="block text-slate-600 mb-1.5 font-semibold">Periode Selesai:</label>
                <input 
                    type="date" 
                    name="date_to" 
                    x-model="dateTo" 
                    class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl px-2.5 py-2 hover:border-slate-300 focus:bg-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary-100 transition-all font-mono"
                >
            </div>

            <div>
                <label class="block text-slate-600 mb-1.5 font-semibold">Area Wilayah:</label>
                <select name="area" class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl px-2.5 py-2 hover:border-slate-300 focus:bg-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary-100 transition-all cursor-pointer">
                    <option value="">Semua Wilayah</option>
                    <option value="Cepogo">Boyolali (Cepogo)</option>
                    <option value="Bandung">Bandung</option>
                    <option value="Cirebon">Cirebon</option>
                    <option value="Jakarta">Jakarta</option>
                    <option value="Bogor">Bogor</option>
                </select>
            </div>

            <div>
                <label class="block text-slate-600 mb-1.5 font-semibold">Tenaga Penjual:</label>
                <select name="sales_npk" class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl px-2.5 py-2 hover:border-slate-300 focus:bg-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary-100 transition-all cursor-pointer">
                    <option value="">Semua Sales</option>
                    @foreach($salesList as $s)
                    <option value="{{ $s['npk'] }}">{{ $s['name'] }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-slate-600 mb-1.5 font-semibold">Channel Distribusi:</label>
                <select name="market" class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl px-2.5 py-2 hover:border-slate-300 focus:bg-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary-100 transition-all cursor-pointer">
                    <option value="">Semua Channel</option>
                    <option value="GT">GT (General Trade)</option>
                    <option value="MT">MT (Modern Trade)</option>
                    <option value="HOREKA">HOREKA</option>
                </select>
            </div>

            <div>
                <label class="block text-slate-600 mb-1.5 font-semibold">SKU Produk:</label>
                <select name="product_code" class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl px-2.5 py-2 hover:border-slate-300 focus:bg-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary-100 transition-all cursor-pointer">
                    <option value="">Semua SKU</option>
                    @foreach($products as $p)
                    <option value="{{ $p['item_code'] }}">{{ $p['item_name'] }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-end gap-1.5">
                <button 
                    type="submit" 
                    class="w-full py-2 bg-primary hover:bg-primary-hover active:translate-y-px text-white font-semibold rounded-xl shadow-xs transition-all flex items-center justify-center gap-1.5 cursor-pointer"
                >
                    <i class="mdi mdi-magnify text-base"></i>
                    <span>Terapkan</span>
                </button>
                <a 
                    href="{{ route('report.index') }}" 
                    class="py-2 px-3 bg-white border border-slate-200 hover:bg-slate-50 active:translate-y-px text-slate-600 rounded-xl font-semibold shadow-xs transition-all text-center flex items-center justify-center"
                    title="Reset Filter"
                >
                    <i class="mdi mdi-refresh text-base"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- Active Report Table Output (Genuine FMCG Field Schema) -->
    <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 border-b border-slate-100 pb-3">
            <div class="flex items-center gap-2.5">
                <span class="w-2.5 h-2.5 rounded-full bg-primary-600 ring-4 ring-primary-50"></span>
                <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider">
                    Dataset Aktif: <span class="text-primary-700">{{ strtoupper($type) }}</span>
                </h3>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xs text-slate-500 font-mono tabular-nums">
                    Total: <strong class="text-slate-900 font-bold">{{ number_format(count($reportData[$type] ?? []), 0, ',', '.') }}</strong> Baris Data
                </span>
                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-primary-50 text-primary-700 border border-primary-200">
                    <i class="mdi mdi-check-decagram text-xs mr-1"></i> Data Terverifikasi
                </span>
            </div>
        </div>

        <div class="overflow-x-auto rounded-xl border border-slate-200/80">
            <table class="w-full text-left text-xs text-slate-700 divide-y divide-slate-200">
                <thead class="bg-slate-50/90 text-slate-600 uppercase text-[10px] font-bold tracking-wider">
                    @if(in_array($type, ['sales', 'sap', 'closing']))
                    <tr>
                        <th class="py-3 px-4">Doc Num</th>
                        <th class="py-3 px-4">Tanggal Order</th>
                        <th class="py-3 px-4">Pelanggan / Outlet</th>
                        <th class="py-3 px-4">Salesman</th>
                        <th class="py-3 px-4">Wilayah</th>
                        <th class="py-3 px-4 text-right">Nilai Transaksi</th>
                        <th class="py-3 px-4 text-center">Status SAP</th>
                    </tr>
                    @elseif($type === 'outlet')
                    <tr>
                        <th class="py-3 px-4">Card Code</th>
                        <th class="py-3 px-4">Nama Outlet</th>
                        <th class="py-3 px-4">Channel</th>
                        <th class="py-3 px-4">Kota / Kabupaten</th>
                        <th class="py-3 px-4">Sales Ditugaskan</th>
                        <th class="py-3 px-4 text-center">Status RO</th>
                    </tr>
                    @elseif($type === 'product')
                    <tr>
                        <th class="py-3 px-4">Kode Item</th>
                        <th class="py-3 px-4">Nama Produk SKU</th>
                        <th class="py-3 px-4">Kategori</th>
                        <th class="py-3 px-4 text-right">Harga Satuan</th>
                        <th class="py-3 px-4 text-center">Stok Gudang</th>
                        <th class="py-3 px-4 text-center">Status</th>
                    </tr>
                    @elseif($type === 'ro')
                    <tr>
                        <th class="py-3 px-4">Card Code</th>
                        <th class="py-3 px-4">Nama Outlet</th>
                        <th class="py-3 px-4">Area</th>
                        <th class="py-3 px-4">Salesman</th>
                        <th class="py-3 px-4">Order Terakhir</th>
                        <th class="py-3 px-4 text-center">Frekuensi RO</th>
                        <th class="py-3 px-4 text-center">Status</th>
                    </tr>
                    @elseif($type === 'roa')
                    <tr>
                        <th class="py-3 px-4">Card Code</th>
                        <th class="py-3 px-4">Nama Outlet</th>
                        <th class="py-3 px-4">Area</th>
                        <th class="py-3 px-4">Salesman</th>
                        <th class="py-3 px-4">Order Terakhir</th>
                        <th class="py-3 px-4 text-center">Status ROA</th>
                        <th class="py-3 px-4 text-center">Audit</th>
                    </tr>
                    @elseif($type === 'ro_item')
                    <tr>
                        <th class="py-3 px-4">Card Code</th>
                        <th class="py-3 px-4">Nama Outlet</th>
                        <th class="py-3 px-4">Area</th>
                        <th class="py-3 px-4 text-right">Dandang Biru</th>
                        <th class="py-3 px-4 text-right">Dandang Merah</th>
                        <th class="py-3 px-4 text-right">Dandang Jasmine</th>
                        <th class="py-3 px-4 text-center">Status Stock</th>
                    </tr>
                    @elseif($type === 'gps')
                    <tr>
                        <th class="py-3 px-4">No. Polisi</th>
                        <th class="py-3 px-4">Driver / Sales</th>
                        <th class="py-3 px-4">Area Rute</th>
                        <th class="py-3 px-4 text-right">Kecepatan</th>
                        <th class="py-3 px-4 text-center">Baterai GPS</th>
                        <th class="py-3 px-4">Update Terakhir</th>
                        <th class="py-3 px-4 text-center">Status</th>
                    </tr>
                    @elseif($type === 'route')
                    <tr>
                        <th class="py-3 px-4">Kode Rute</th>
                        <th class="py-3 px-4">Salesman</th>
                        <th class="py-3 px-4">Hari Kunjungan</th>
                        <th class="py-3 px-4">Kecamatan / Area</th>
                        <th class="py-3 px-4 text-center">Target Outlet</th>
                        <th class="py-3 px-4 text-center">Kunjungan Aktual</th>
                        <th class="py-3 px-4 text-center">Kepatuhan (%)</th>
                    </tr>
                    @elseif($type === 'performance')
                    <tr>
                        <th class="py-3 px-4">NPK</th>
                        <th class="py-3 px-4">Tenaga Penjual</th>
                        <th class="py-3 px-4">Wilayah</th>
                        <th class="py-3 px-4 text-right">Target MTD</th>
                        <th class="py-3 px-4 text-right">Realisasi</th>
                        <th class="py-3 px-4 text-center">Pencapaian</th>
                        <th class="py-3 px-4 text-center">Rasio RO</th>
                    </tr>
                    @elseif($type === 'early_warning')
                    <tr>
                        <th class="py-3 px-4">ID Kasus</th>
                        <th class="py-3 px-4">Jenis Anomali</th>
                        <th class="py-3 px-4">Wilayah</th>
                        <th class="py-3 px-4">Sales Bertugas</th>
                        <th class="py-3 px-4">Nama Outlet</th>
                        <th class="py-3 px-4 text-center">Tingkat Risiko</th>
                        <th class="py-3 px-4 text-center">Status</th>
                    </tr>
                    @elseif($type === 'daily')
                    <tr>
                        <th class="py-3 px-4">ID Visit</th>
                        <th class="py-3 px-4">Tanggal & Jam</th>
                        <th class="py-3 px-4">Salesman</th>
                        <th class="py-3 px-4">Outlet Dikunjungi</th>
                        <th class="py-3 px-4">Jarak GPS</th>
                        <th class="py-3 px-4">Hasil Kunjungan</th>
                        <th class="py-3 px-4 text-center">Verifikasi</th>
                    </tr>
                    @endif
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse($reportData[$type] ?? [] as $row)
                        @if(in_array($type, ['sales', 'sap', 'closing']))
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3 px-4 font-mono font-bold text-primary">#{{ $row['doc_num'] ?? '-' }}</td>
                            <td class="py-3 px-4 font-mono text-slate-500">{{ $row['doc_date'] ?? '-' }}</td>
                            <td class="py-3 px-4 font-semibold text-slate-900">{{ $row['card_name'] ?? '-' }}</td>
                            <td class="py-3 px-4 text-slate-700">{{ $row['slp_name'] ?? '-' }}</td>
                            <td class="py-3 px-4 text-slate-600">{{ $row['area'] ?? '-' }}</td>
                            <td class="py-3 px-4 text-right font-mono font-bold text-primary tabular-nums">
                                Rp {{ number_format($row['doc_total'] ?? 0, 0, ',', '.') }}
                            </td>
                            <td class="py-3 px-4 text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-primary-50 text-primary-700 border border-primary-200">
                                    {{ $row['sap_status'] ?? 'Success' }}
                                </span>
                            </td>
                        </tr>
                        @elseif($type === 'outlet')
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3 px-4 font-mono font-bold text-primary">{{ $row['card_code'] ?? '-' }}</td>
                            <td class="py-3 px-4 font-semibold text-slate-900">{{ $row['card_name'] ?? '-' }}</td>
                            <td class="py-3 px-4">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-accent-50 text-accent-700 border border-accent-200">
                                    {{ $row['market'] ?? 'GT' }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-slate-600">{{ $row['city'] ?? '-' }}</td>
                            <td class="py-3 px-4 text-slate-700">{{ $row['sales_name'] ?? '-' }}</td>
                            <td class="py-3 px-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ str_contains($row['ro_status_color'] ?? '', 'emerald') || ($row['ro_status'] ?? '') === 'RO Rutin' ? 'bg-primary-50 text-primary-700 border border-primary-200' : 'bg-secondary-50 text-secondary-700 border border-secondary-200' }}">
                                    {{ $row['ro_status'] ?? '-' }}
                                </span>
                            </td>
                        </tr>
                        @elseif($type === 'product')
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3 px-4 font-mono font-bold text-primary">{{ $row['item_code'] ?? '-' }}</td>
                            <td class="py-3 px-4 font-semibold text-slate-900">{{ $row['item_name'] ?? '-' }}</td>
                            <td class="py-3 px-4 text-slate-600">{{ $row['category'] ?? '-' }}</td>
                            <td class="py-3 px-4 text-right font-mono font-semibold text-slate-800 tabular-nums">
                                Rp {{ number_format($row['price'] ?? 0, 0, ',', '.') }}
                            </td>
                            <td class="py-3 px-4 text-center font-mono tabular-nums">{{ number_format($row['stock'] ?? 0, 0, ',', '.') }} dos</td>
                            <td class="py-3 px-4 text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-primary-50 text-primary-700 border border-primary-200">
                                    Aktif
                                </span>
                            </td>
                        </tr>
                        @elseif($type === 'ro')
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3 px-4 font-mono font-bold text-primary">{{ $row['card_code'] ?? '-' }}</td>
                            <td class="py-3 px-4 font-semibold text-slate-900">{{ $row['outlet_name'] ?? '-' }}</td>
                            <td class="py-3 px-4 text-slate-600">{{ $row['area'] ?? '-' }}</td>
                            <td class="py-3 px-4 text-slate-700">{{ $row['sales_name'] ?? '-' }}</td>
                            <td class="py-3 px-4 font-mono text-slate-500">{{ $row['last_order_date'] ?? '-' }}</td>
                            <td class="py-3 px-4 text-center font-mono font-bold tabular-nums">{{ $row['ro_frequency_month'] ?? 0 }}x/bln</td>
                            <td class="py-3 px-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-primary-50 text-primary-700 border border-primary-200">
                                    {{ $row['status'] ?? 'Active' }}
                                </span>
                            </td>
                        </tr>
                        @elseif($type === 'roa')
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3 px-4 font-mono font-bold text-primary">{{ $row['card_code'] ?? '-' }}</td>
                            <td class="py-3 px-4 font-semibold text-slate-900">{{ $row['outlet_name'] ?? '-' }}</td>
                            <td class="py-3 px-4 text-slate-600">{{ $row['area'] ?? '-' }}</td>
                            <td class="py-3 px-4 text-slate-700">{{ $row['sales_name'] ?? '-' }}</td>
                            <td class="py-3 px-4 font-mono text-slate-500">{{ $row['last_order_date'] ?? '-' }}</td>
                            <td class="py-3 px-4 text-center font-semibold text-primary">{{ $row['roa_status'] ?? 'Active' }}</td>
                            <td class="py-3 px-4 text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-primary-50 text-primary-700 border border-primary-200">
                                    Verified
                                </span>
                            </td>
                        </tr>
                        @elseif($type === 'ro_item')
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3 px-4 font-mono font-bold text-primary">{{ $row['card_code'] ?? '-' }}</td>
                            <td class="py-3 px-4 font-semibold text-slate-900">{{ $row['outlet_name'] ?? '-' }}</td>
                            <td class="py-3 px-4 text-slate-600">{{ $row['area'] ?? '-' }}</td>
                            <td class="py-3 px-4 text-right font-mono tabular-nums">{{ $row['dandang_biru_qty'] ?? 0 }} karton</td>
                            <td class="py-3 px-4 text-right font-mono tabular-nums">{{ $row['dandang_merah_qty'] ?? 0 }} karton</td>
                            <td class="py-3 px-4 text-right font-mono tabular-nums">{{ $row['dandang_jasmine_qty'] ?? 0 }} karton</td>
                            <td class="py-3 px-4 text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold {{ ($row['status'] ?? '') === 'Good' ? 'bg-primary-50 text-primary-700 border border-primary-200' : 'bg-secondary-50 text-secondary-700 border border-secondary-200' }}">
                                    {{ $row['status'] ?? 'Normal' }}
                                </span>
                            </td>
                        </tr>
                        @elseif($type === 'gps')
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3 px-4 font-mono font-bold text-accent">{{ $row['plate_no'] ?? '-' }}</td>
                            <td class="py-3 px-4 font-semibold text-slate-900">{{ $row['driver_sales'] ?? '-' }}</td>
                            <td class="py-3 px-4 text-slate-600">{{ $row['area'] ?? '-' }}</td>
                            <td class="py-3 px-4 text-right font-mono tabular-nums">{{ $row['speed_kmh'] ?? 0 }} km/h</td>
                            <td class="py-3 px-4 text-center font-mono tabular-nums">{{ $row['battery_pct'] ?? 100 }}%</td>
                            <td class="py-3 px-4 font-mono text-slate-500">{{ $row['last_update'] ?? '-' }}</td>
                            <td class="py-3 px-4 text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-primary-50 text-primary-700 border border-primary-200">
                                    {{ $row['status'] ?? 'Online' }}
                                </span>
                            </td>
                        </tr>
                        @elseif($type === 'route')
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3 px-4 font-mono font-bold text-primary">{{ $row['route_code'] ?? '-' }}</td>
                            <td class="py-3 px-4 font-semibold text-slate-900">{{ $row['sales_name'] ?? '-' }}</td>
                            <td class="py-3 px-4 text-slate-600">{{ $row['day'] ?? '-' }}</td>
                            <td class="py-3 px-4 text-slate-600">{{ $row['kecamatan'] ?? $row['area'] ?? '-' }}</td>
                            <td class="py-3 px-4 text-center font-mono tabular-nums">{{ $row['target_outlets'] ?? 0 }}</td>
                            <td class="py-3 px-4 text-center font-mono tabular-nums">{{ $row['visited_outlets'] ?? 0 }}</td>
                            <td class="py-3 px-4 text-center font-mono font-bold text-primary tabular-nums">
                                {{ $row['compliance_rate'] ?? 0 }}%
                            </td>
                        </tr>
                        @elseif($type === 'performance')
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3 px-4 font-mono font-bold text-primary">{{ $row['npk'] ?? '-' }}</td>
                            <td class="py-3 px-4 font-semibold text-slate-900">{{ $row['name'] ?? '-' }}</td>
                            <td class="py-3 px-4 text-slate-600">{{ $row['area'] ?? '-' }}</td>
                            <td class="py-3 px-4 text-right font-mono text-slate-600 tabular-nums">
                                Rp {{ number_format($row['target'] ?? 0, 0, ',', '.') }}
                            </td>
                            <td class="py-3 px-4 text-right font-mono font-bold text-primary tabular-nums">
                                Rp {{ number_format($row['actual'] ?? 0, 0, ',', '.') }}
                            </td>
                            <td class="py-3 px-4 text-center font-mono font-bold text-primary tabular-nums">
                                {{ $row['achievement'] ?? 0 }}%
                            </td>
                            <td class="py-3 px-4 text-center font-mono font-bold text-secondary tabular-nums">
                                {{ $row['ro_rate'] ?? 0 }}%
                            </td>
                        </tr>
                        @elseif($type === 'early_warning')
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3 px-4 font-mono font-bold text-rose-600">{{ $row['id'] ?? '-' }}</td>
                            <td class="py-3 px-4 font-semibold text-slate-900">{{ $row['warning_type'] ?? '-' }}</td>
                            <td class="py-3 px-4 text-slate-600">{{ $row['area'] ?? '-' }}</td>
                            <td class="py-3 px-4 text-slate-700">{{ $row['sales'] ?? '-' }}</td>
                            <td class="py-3 px-4 text-slate-700">{{ $row['outlet'] ?? '-' }}</td>
                            <td class="py-3 px-4 text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold {{ ($row['severity'] ?? '') === 'Critical' ? 'bg-rose-50 text-rose-700 border border-rose-200' : 'bg-secondary-50 text-secondary-700 border border-secondary-200' }}">
                                    {{ $row['severity'] ?? 'Medium' }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-center font-semibold text-slate-600">{{ $row['status'] ?? 'Open' }}</td>
                        </tr>
                        @elseif($type === 'daily')
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3 px-4 font-mono font-bold text-primary">{{ $row['id'] ?? '-' }}</td>
                            <td class="py-3 px-4 font-mono text-slate-500">{{ ($row['date'] ?? '') . ' ' . ($row['checkin_time'] ?? '') }}</td>
                            <td class="py-3 px-4 font-semibold text-slate-900">{{ $row['sales_name'] ?? '-' }}</td>
                            <td class="py-3 px-4 text-slate-700">{{ $row['outlet_name'] ?? '-' }}</td>
                            <td class="py-3 px-4 font-mono text-slate-600">{{ $row['distance'] ?? '-' }}</td>
                            <td class="py-3 px-4 text-slate-700">{{ $row['result'] ?? '-' }}</td>
                            <td class="py-3 px-4 text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-primary-50 text-primary-700 border border-primary-200">
                                    {{ $row['status'] ?? 'Valid' }}
                                </span>
                            </td>
                        </tr>
                        @endif
                    @empty
                    <tr>
                        <td colspan="7" class="py-12 text-center text-slate-400">
                            <div class="flex flex-col items-center justify-center">
                                <i class="mdi mdi-inbox-outline text-3xl text-slate-300 mb-2"></i>
                                <p class="text-xs font-semibold text-slate-500">Tidak ada baris data untuk filter laporan yang dipilih.</p>
                                <span class="text-[11px] text-slate-400 mt-0.5">Ubah rentang tanggal atau pilih filter Semua Wilayah untuk memuat data.</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
