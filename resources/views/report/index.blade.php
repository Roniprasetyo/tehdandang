@extends('layouts.app')

@section('title', 'Reporting Center')

@section('content')
<div class="space-y-6" x-data="{ 
    reportType: '{{ $type }}',
    dateFrom: '{{ date('Y-m-01') }}',
    dateTo: '{{ date('Y-m-d') }}'
}">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
        <div>
            <h1 class="text-xl font-bold font-display text-slate-900 flex items-center gap-2">
                <i data-lucide="bar-chart-3" class="w-5 h-5 text-indigo-600"></i> Reporting & Analytical Center (13 Reports)
            </h1>
            <p class="text-xs text-slate-500 mt-0.5">Filter universal laporan penjualan, outlet, produk, GPS, dan SAP B1</p>
        </div>
        <div class="flex items-center gap-2">
            <button @click="alert('Export Excel (' + reportType + ') generated!')" class="px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-emerald-700 text-xs font-bold hover:bg-slate-50 shadow-xs flex items-center gap-1.5">
                <i data-lucide="file-spreadsheet" class="w-4 h-4 text-emerald-600"></i> Export Excel
            </button>
            <button @click="alert('Export PDF (' + reportType + ') generated!')" class="px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-rose-700 text-xs font-bold hover:bg-slate-50 shadow-xs flex items-center gap-1.5">
                <i data-lucide="file-text" class="w-4 h-4 text-rose-600"></i> Export PDF
            </button>
        </div>
    </div>

    <!-- Universal Report Filter Form -->
    <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs space-y-4">
        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">Universal Report Filter:</h3>
        <form action="{{ route('report.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-3 text-xs">
            <div>
                <label class="block text-slate-600 mb-1 font-semibold">Jenis Laporan:</label>
                <select name="type" x-model="reportType" onchange="this.form.submit()" class="w-full bg-slate-50 border border-slate-200 text-indigo-600 font-bold rounded-xl p-2 focus:outline-none focus:border-indigo-500">
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
                <label class="block text-slate-600 mb-1 font-semibold">Date From:</label>
                <input type="date" name="date_from" x-model="dateFrom" class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl p-2">
            </div>

            <div>
                <label class="block text-slate-600 mb-1 font-semibold">Date To:</label>
                <input type="date" name="date_to" x-model="dateTo" class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl p-2">
            </div>

            <div>
                <label class="block text-slate-600 mb-1 font-semibold">Area:</label>
                <select name="area" class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl p-2">
                    <option value="">Semua Area</option>
                    <option value="Cepogo">Boyolali (Cepogo)</option>
                    <option value="Bandung">Bandung</option>
                    <option value="Cirebon">Cirebon</option>
                    <option value="Jakarta">Jakarta</option>
                    <option value="Bogor">Bogor</option>
                </select>
            </div>

            <div>
                <label class="block text-slate-600 mb-1 font-semibold">Sales:</label>
                <select name="sales_npk" class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl p-2">
                    <option value="">Semua Sales</option>
                    @foreach($salesList as $s)
                    <option value="{{ $s['npk'] }}">{{ $s['name'] }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-slate-600 mb-1 font-semibold">Market:</label>
                <select name="market" class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl p-2">
                    <option value="">Semua Channel</option>
                    <option value="GT">GT</option>
                    <option value="MT">MT</option>
                    <option value="HOREKA">HOREKA</option>
                </select>
            </div>

            <div>
                <label class="block text-slate-600 mb-1 font-semibold">SKU Product:</label>
                <select name="product_code" class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl p-2">
                    <option value="">Semua Product</option>
                    @foreach($products as $p)
                    <option value="{{ $p['item_code'] }}">{{ $p['item_name'] }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-end gap-1.5">
                <button type="submit" class="w-full py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-md shadow-indigo-200">Search</button>
                <a href="{{ route('report.index') }}" class="py-2 px-3 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-xl font-semibold">Reset</a>
            </div>
        </form>
    </div>

    <!-- Active Report Table Output -->
    <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs space-y-4">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">
                Hasil Laporan: <span class="text-indigo-600">{{ strtoupper($type) }} REPORT</span>
            </h3>
            <span class="text-xs text-slate-500">Total Record: {{ number_format(count($reportData[$type] ?? []), 0, ',', '.') }} Data Rows</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] tracking-wider border-b border-slate-200">
                    @if($type === 'sales' || $type === 'sap' || $type === 'closing')
                    <tr>
                        <th class="py-3 px-4">DOCNUM</th>
                        <th class="py-3 px-4">DOCDATE</th>
                        <th class="py-3 px-4">CARDCODE / CUSTOMER</th>
                        <th class="py-3 px-4">SALES PERSON</th>
                        <th class="py-3 px-4">AREA</th>
                        <th class="py-3 px-4">GRAND TOTAL</th>
                        <th class="py-3 px-4 text-center">SAP STATUS</th>
                    </tr>
                    @elseif($type === 'outlet')
                    <tr>
                        <th class="py-3 px-4">CARDCODE</th>
                        <th class="py-3 px-4">OUTLET NAME</th>
                        <th class="py-3 px-4">MARKET</th>
                        <th class="py-3 px-4">CITY</th>
                        <th class="py-3 px-4">SALES ASSIGNED</th>
                        <th class="py-3 px-4 text-center">RO STATUS</th>
                    </tr>
                    @elseif($type === 'performance')
                    <tr>
                        <th class="py-3 px-4">NPK</th>
                        <th class="py-3 px-4">SALES PERSON</th>
                        <th class="py-3 px-4">AREA</th>
                        <th class="py-3 px-4">TARGET MTD</th>
                        <th class="py-3 px-4">ACTUAL SALES</th>
                        <th class="py-3 px-4">ACHIEVEMENT</th>
                        <th class="py-3 px-4">RO RATE</th>
                    </tr>
                    @else
                    <tr>
                        <th class="py-3 px-4">ID / CODE</th>
                        <th class="py-3 px-4">NAME / DESCRIPTION</th>
                        <th class="py-3 px-4">AREA SCOPE</th>
                        <th class="py-3 px-4">METRIC VALUE</th>
                        <th class="py-3 px-4 text-center">STATUS</th>
                    </tr>
                    @endif
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($reportData[$type] ?? [] as $row)
                        @if($type === 'sales' || $type === 'sap' || $type === 'closing')
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-3 px-4 font-mono font-bold text-indigo-600">#{{ $row['doc_num'] }}</td>
                            <td class="py-3 px-4 font-mono text-slate-600">{{ $row['doc_date'] }}</td>
                            <td class="py-3 px-4 font-bold text-slate-900">{{ $row['card_name'] }}</td>
                            <td class="py-3 px-4 text-slate-700">{{ $row['slp_name'] }}</td>
                            <td class="py-3 px-4 text-slate-600">{{ $row['area'] }}</td>
                            <td class="py-3 px-4 font-bold text-emerald-600">Rp {{ number_format($row['doc_total'], 0, ',', '.') }}</td>
                            <td class="py-3 px-4 text-center font-bold text-emerald-600">{{ $row['sap_status'] }}</td>
                        </tr>
                        @elseif($type === 'outlet')
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-3 px-4 font-mono font-bold text-indigo-600">{{ $row['card_code'] }}</td>
                            <td class="py-3 px-4 font-bold text-slate-900">{{ $row['card_name'] }}</td>
                            <td class="py-3 px-4 text-indigo-600 font-bold">{{ $row['market'] }}</td>
                            <td class="py-3 px-4 text-slate-600">{{ $row['city'] }}</td>
                            <td class="py-3 px-4 text-slate-700">{{ $row['sales_name'] }}</td>
                            <td class="py-3 px-4 text-center font-bold">{{ $row['ro_status_color'] }} {{ $row['ro_status'] }}</td>
                        </tr>
                        @elseif($type === 'performance')
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-3 px-4 font-mono font-bold text-indigo-600">{{ $row['npk'] }}</td>
                            <td class="py-3 px-4 font-bold text-slate-900">{{ $row['name'] }}</td>
                            <td class="py-3 px-4 text-slate-600">{{ $row['area'] }}</td>
                            <td class="py-3 px-4">Rp {{ number_format($row['target'], 0, ',', '.') }}</td>
                            <td class="py-3 px-4 font-bold text-emerald-600">Rp {{ number_format($row['actual'], 0, ',', '.') }}</td>
                            <td class="py-3 px-4 font-bold text-indigo-600">{{ $row['achievement'] }}%</td>
                            <td class="py-3 px-4 font-bold text-amber-600">{{ $row['ro_rate'] }}%</td>
                        </tr>
                        @else
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-3 px-4 font-mono text-indigo-600 font-bold">REC-{{ rand(100, 999) }}</td>
                            <td class="py-3 px-4 font-bold text-slate-900">Record Laporan {{ ucfirst($type) }}</td>
                            <td class="py-3 px-4 text-slate-600">Nasional / Regional</td>
                            <td class="py-3 px-4 font-bold text-indigo-600">92.4% Compliance</td>
                            <td class="py-3 px-4 text-center font-bold text-emerald-600">Verified</td>
                        </tr>
                        @endif
                    @empty
                    <tr>
                        <td colspan="7" class="py-4 text-center text-slate-400">Tidak ada data laporan untuk filter yang dipilih.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
