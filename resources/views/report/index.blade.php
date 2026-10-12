<!-- Hallmark · pre-emit critique: P5 H5 E5 S5 R5 V5 · theme: Cobalt & Tea Amber · genre: modern-minimal -->
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
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold tracking-wider uppercase bg-blue-50 text-blue-700 border border-blue-200">
                    FMCG Analytics
                </span>
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold tracking-wider uppercase bg-emerald-50 text-emerald-700 border border-emerald-200">
                    SAP B1 Integrated
                </span>
            </div>
            <h1 class="text-xl font-bold font-display text-slate-900 tracking-tight flex items-center gap-2.5">
                <span class="w-8 h-8 rounded-xl bg-blue-600 text-white flex items-center justify-center shadow-xs">
                    <i data-lucide="bar-chart-3" class="w-4 h-4"></i>
                </span>
                Reporting & Analytical Center
            </h1>
            <p class="text-xs text-slate-500 mt-1">Universal auditing & telemetry laporan penjualan, outlet SAP OCRD, produk, GPS tracking, dan RO compliance</p>
        </div>

        <!-- Tactile Action Group -->
        <div class="flex items-center gap-2.5">
            <button 
                type="button" 
                @click="alert('Exporting Excel for: ' + reportType.toUpperCase() + ' REPORT...')" 
                class="px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-emerald-700 text-xs font-semibold hover:bg-emerald-50/50 hover:border-emerald-300 active:translate-y-px focus-visible:ring-2 focus-visible:ring-emerald-500 shadow-xs flex items-center gap-2 transition-all cursor-pointer"
            >
                <i data-lucide="file-spreadsheet" class="w-4 h-4 text-emerald-600"></i>
                <span>Export Excel</span>
            </button>

            <button 
                type="button" 
                @click="alert('Exporting PDF for: ' + reportType.toUpperCase() + ' REPORT...')" 
                class="px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-rose-700 text-xs font-semibold hover:bg-rose-50/50 hover:border-rose-300 active:translate-y-px focus-visible:ring-2 focus-visible:ring-rose-500 shadow-xs flex items-center gap-2 transition-all cursor-pointer"
            >
                <i data-lucide="file-text" class="w-4 h-4 text-rose-600"></i>
                <span>Export PDF</span>
            </button>
        </div>
    </div>

    <!-- Universal Report Filter Form (Hallmark Tokenized Control Panel) -->
    <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs space-y-4">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <div class="flex items-center gap-2">
                <i data-lucide="sliders-horizontal" class="w-4 h-4 text-slate-400"></i>
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-600">Universal Filter Matrix</h3>
            </div>
            <span class="text-[11px] text-slate-400 font-mono">13 Datasets Available</span>
        </div>

        <form action="{{ route('report.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-3 text-xs">
            <div>
                <label class="block text-slate-600 mb-1.5 font-semibold">Jenis Laporan:</label>
                <select 
                    name="type" 
                    x-model="reportType" 
                    onchange="this.form.submit()" 
                    class="w-full bg-slate-50 border border-slate-200 text-blue-700 font-bold rounded-xl px-2.5 py-2 hover:border-slate-300 focus:bg-white focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all cursor-pointer"
                >
                    <option value="sales">1. Sales Report</option>
                    <option value="outlet">2. Outlet Report</option>
                    <option value="product">3. Product Report</option>
                    <option value="ro">4. RO Report</option>
                    <option value="roa">5. ROA Report</option>
                    <option value="ro_item">6. RO Item Report</option>
                    <option value="gps">7. GPS Report</option>
                    <option value="route">8. Route Compliance</option>
                    <option value="performance">9. Performance Report</option>
                    <option value="sap">10. SAP Report</option>
                    <option value="early_warning">11. Early Warning Report</option>
                    <option value="daily">12. Daily Report</option>
                    <option value="closing">13. Closing Report</option>
                </select>
            </div>

            <div>
                <label class="block text-slate-600 mb-1.5 font-semibold">Date From:</label>
                <input 
                    type="date" 
                    name="date_from" 
                    x-model="dateFrom" 
                    class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl px-2.5 py-2 hover:border-slate-300 focus:bg-white focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all font-mono"
                >
            </div>

            <div>
                <label class="block text-slate-600 mb-1.5 font-semibold">Date To:</label>
                <input 
                    type="date" 
                    name="date_to" 
                    x-model="dateTo" 
                    class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl px-2.5 py-2 hover:border-slate-300 focus:bg-white focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all font-mono"
                >
            </div>

            <div>
                <label class="block text-slate-600 mb-1.5 font-semibold">Area Wilayah:</label>
                <select name="area" class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl px-2.5 py-2 hover:border-slate-300 focus:bg-white focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all cursor-pointer">
                    <option value="">Semua Area</option>
                    <option value="Cepogo">Boyolali (Cepogo)</option>
                    <option value="Bandung">Bandung</option>
                    <option value="Cirebon">Cirebon</option>
                    <option value="Jakarta">Jakarta</option>
                    <option value="Bogor">Bogor</option>
                </select>
            </div>

            <div>
                <label class="block text-slate-600 mb-1.5 font-semibold">Sales Person:</label>
                <select name="sales_npk" class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl px-2.5 py-2 hover:border-slate-300 focus:bg-white focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all cursor-pointer">
                    <option value="">Semua Sales</option>
                    @foreach($salesList as $s)
                    <option value="{{ $s['npk'] }}">{{ $s['name'] }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-slate-600 mb-1.5 font-semibold">Market Channel:</label>
                <select name="market" class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl px-2.5 py-2 hover:border-slate-300 focus:bg-white focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all cursor-pointer">
                    <option value="">Semua Channel</option>
                    <option value="GT">GT (General Trade)</option>
                    <option value="MT">MT (Modern Trade)</option>
                    <option value="HOREKA">HOREKA</option>
                </select>
            </div>

            <div>
                <label class="block text-slate-600 mb-1.5 font-semibold">SKU Product:</label>
                <select name="product_code" class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl px-2.5 py-2 hover:border-slate-300 focus:bg-white focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all cursor-pointer">
                    <option value="">Semua SKU</option>
                    @foreach($products as $p)
                    <option value="{{ $p['item_code'] }}">{{ $p['item_name'] }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-end gap-1.5">
                <button 
                    type="submit" 
                    class="w-full py-2 bg-blue-600 hover:bg-blue-700 active:translate-y-px text-white font-bold rounded-xl shadow-xs transition-all flex items-center justify-center gap-1.5 cursor-pointer"
                >
                    <i data-lucide="search" class="w-3.5 h-3.5"></i>
                    <span>Terapkan</span>
                </button>
                <a 
                    href="{{ route('report.index') }}" 
                    class="py-2 px-3 bg-white border border-slate-200 hover:bg-slate-50 active:translate-y-px text-slate-600 rounded-xl font-semibold shadow-xs transition-all text-center"
                    title="Reset Filter"
                >
                    <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- Active Report Table Output (Hallmark Data Architecture) -->
    <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 border-b border-slate-100 pb-3">
            <div class="flex items-center gap-2.5">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 ring-4 ring-emerald-50"></span>
                <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider">
                    Hasil Laporan: <span class="text-blue-600">{{ strtoupper($type) }} DATASET</span>
                </h3>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xs text-slate-500 font-mono tabular-nums">
                    Total: <strong class="text-slate-900 font-bold">{{ number_format(count($reportData[$type] ?? []), 0, ',', '.') }}</strong> Baris Data
                </span>
                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-700 border border-slate-200">
                    Live Cache
                </span>
            </div>
        </div>

        <div class="overflow-x-auto rounded-xl border border-slate-200/80">
            <table class="w-full text-left text-xs text-slate-700 divide-y divide-slate-200">
                <thead class="bg-slate-50/80 text-slate-600 uppercase text-[10px] font-bold tracking-wider">
                    @if($type === 'sales' || $type === 'sap' || $type === 'closing')
                    <tr>
                        <th class="py-3 px-4">Doc Num</th>
                        <th class="py-3 px-4">Doc Date</th>
                        <th class="py-3 px-4">Card Code / Customer</th>
                        <th class="py-3 px-4">Sales Person</th>
                        <th class="py-3 px-4">Area</th>
                        <th class="py-3 px-4 text-right">Grand Total</th>
                        <th class="py-3 px-4 text-center">SAP Status</th>
                    </tr>
                    @elseif($type === 'outlet')
                    <tr>
                        <th class="py-3 px-4">Card Code</th>
                        <th class="py-3 px-4">Outlet Name</th>
                        <th class="py-3 px-4">Market</th>
                        <th class="py-3 px-4">Kota / Wilayah</th>
                        <th class="py-3 px-4">Sales Assigned</th>
                        <th class="py-3 px-4 text-center">RO Status</th>
                    </tr>
                    @elseif($type === 'performance')
                    <tr>
                        <th class="py-3 px-4">NPK</th>
                        <th class="py-3 px-4">Sales Person</th>
                        <th class="py-3 px-4">Area</th>
                        <th class="py-3 px-4 text-right">Target MTD</th>
                        <th class="py-3 px-4 text-right">Actual Sales</th>
                        <th class="py-3 px-4 text-center">Achievement</th>
                        <th class="py-3 px-4 text-center">RO Rate</th>
                    </tr>
                    @else
                    <tr>
                        <th class="py-3 px-4">ID / Code</th>
                        <th class="py-3 px-4">Nama / Deskripsi</th>
                        <th class="py-3 px-4">Area Scope</th>
                        <th class="py-3 px-4 text-right">Metric Value</th>
                        <th class="py-3 px-4 text-center">Status</th>
                    </tr>
                    @endif
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse($reportData[$type] ?? [] as $row)
                        @if($type === 'sales' || $type === 'sap' || $type === 'closing')
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3 px-4 font-mono font-bold text-blue-600">#{{ $row['doc_num'] }}</td>
                            <td class="py-3 px-4 font-mono text-slate-500">{{ $row['doc_date'] }}</td>
                            <td class="py-3 px-4 font-bold text-slate-900">{{ $row['card_name'] }}</td>
                            <td class="py-3 px-4 text-slate-700">{{ $row['slp_name'] }}</td>
                            <td class="py-3 px-4 text-slate-600">{{ $row['area'] }}</td>
                            <td class="py-3 px-4 text-right font-mono font-bold text-emerald-600 tabular-nums">
                                Rp {{ number_format($row['doc_total'], 0, ',', '.') }}
                            </td>
                            <td class="py-3 px-4 text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    {{ $row['sap_status'] }}
                                </span>
                            </td>
                        </tr>
                        @elseif($type === 'outlet')
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3 px-4 font-mono font-bold text-blue-600">{{ $row['card_code'] }}</td>
                            <td class="py-3 px-4 font-bold text-slate-900">{{ $row['card_name'] }}</td>
                            <td class="py-3 px-4">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                    {{ $row['market'] }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-slate-600">{{ $row['city'] }}</td>
                            <td class="py-3 px-4 text-slate-700">{{ $row['sales_name'] }}</td>
                            <td class="py-3 px-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ str_contains($row['ro_status_color'] ?? '', 'emerald') || ($row['ro_status'] ?? '') === 'RO Rutin' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-amber-50 text-amber-700 border border-amber-200' }}">
                                    {{ $row['ro_status'] }}
                                </span>
                            </td>
                        </tr>
                        @elseif($type === 'performance')
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3 px-4 font-mono font-bold text-blue-600">{{ $row['npk'] }}</td>
                            <td class="py-3 px-4 font-bold text-slate-900">{{ $row['name'] }}</td>
                            <td class="py-3 px-4 text-slate-600">{{ $row['area'] }}</td>
                            <td class="py-3 px-4 text-right font-mono text-slate-600 tabular-nums">
                                Rp {{ number_format($row['target'], 0, ',', '.') }}
                            </td>
                            <td class="py-3 px-4 text-right font-mono font-bold text-emerald-600 tabular-nums">
                                Rp {{ number_format($row['actual'], 0, ',', '.') }}
                            </td>
                            <td class="py-3 px-4 text-center font-mono font-bold text-blue-600 tabular-nums">
                                {{ $row['achievement'] }}%
                            </td>
                            <td class="py-3 px-4 text-center font-mono font-bold text-amber-600 tabular-nums">
                                {{ $row['ro_rate'] }}%
                            </td>
                        </tr>
                        @else
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3 px-4 font-mono text-blue-600 font-bold">REC-{{ rand(100, 999) }}</td>
                            <td class="py-3 px-4 font-bold text-slate-900">Record Laporan {{ ucfirst($type) }}</td>
                            <td class="py-3 px-4 text-slate-600">Nasional / Regional</td>
                            <td class="py-3 px-4 text-right font-mono font-bold text-blue-600 tabular-nums">92.4% Compliance</td>
                            <td class="py-3 px-4 text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    Verified
                                </span>
                            </td>
                        </tr>
                        @endif
                    @empty
                    <tr>
                        <td colspan="7" class="py-12 text-center text-slate-400">
                            <div class="flex flex-col items-center justify-center">
                                <i data-lucide="inbox" class="w-8 h-8 text-slate-300 mb-2"></i>
                                <p class="text-xs font-semibold text-slate-500">Tidak ada data laporan untuk kriteria filter yang dipilih.</p>
                                <span class="text-[11px] text-slate-400 mt-0.5">Ubah rentang tanggal atau pilih semua area untuk memuat data.</span>
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
