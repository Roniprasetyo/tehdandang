@extends('layouts.app')

@section('title', 'Executive Dashboard')

@section('content')
<div class="space-y-6">

    <!-- Top Headline & Corporate Scope -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
        <div>
            <h1 class="text-xl font-bold font-display text-slate-900">Executive Dashboard</h1>
            <p class="text-xs text-slate-500 mt-0.5">Monitoring Penjualan Nasional, Sales Performance, RO/ROA/EC & Concox GT06N GPS</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="bg-slate-50 border border-slate-200 rounded-xl px-3 py-1.5 text-xs text-slate-700 font-medium flex items-center gap-2">
                <i data-lucide="calendar" class="w-4 h-4 text-emerald-600"></i>
                <span>Periode: September 2026</span>
            </div>
            <div class="bg-emerald-50 border border-emerald-200 rounded-xl px-3 py-1.5 text-xs text-emerald-700 font-bold flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                <span>Role: {{ $user['role'] }} ({{ $user['area'] }})</span>
            </div>
        </div>
    </div>

    <!-- Metis Style KPI Cards Grid (4 Top Cards like Metis + 2 Secondary) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
        
        <!-- KPI 1: Sales -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs hover:shadow-md transition-all">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">TOTAL SALES</span>
                <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <i data-lucide="dollar-sign" class="w-4 h-4"></i>
                </div>
            </div>
            <div class="text-2xl font-bold text-slate-900 mt-2">Rp 12.8 M</div>
            <div class="text-[11px] text-emerald-600 font-semibold mt-1">↑ +8.2% vs target</div>
        </div>

        <!-- KPI 2: Achievement -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs hover:shadow-md transition-all">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">ACHIEVEMENT</span>
                <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                    <i data-lucide="trending-up" class="w-4 h-4"></i>
                </div>
            </div>
            <div class="text-2xl font-bold text-indigo-600 mt-2">87.4%</div>
            <div class="text-[11px] text-slate-500 mt-1">Target MTD: 85%</div>
        </div>

        <!-- KPI 3: Growth -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs hover:shadow-md transition-all">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">GROWTH (MoM)</span>
                <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <i data-lucide="arrow-up-right" class="w-4 h-4"></i>
                </div>
            </div>
            <div class="text-2xl font-bold text-emerald-600 mt-2">+8.2%</div>
            <div class="text-[11px] text-slate-500 mt-1">Terbaik: Cepogo (115%)</div>
        </div>

        <!-- KPI 4: RO -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs hover:shadow-md transition-all">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">REPEAT ORDER (RO)</span>
                <div class="w-8 h-8 rounded-lg bg-cyan-50 text-cyan-600 flex items-center justify-center">
                    <i data-lucide="repeat" class="w-4 h-4"></i>
                </div>
            </div>
            <div class="text-2xl font-bold text-cyan-600 mt-2">82.4%</div>
            <div class="text-[11px] text-slate-500 mt-1">Target Min: 80%</div>
        </div>

        <!-- KPI 5: ROA -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs hover:shadow-md transition-all">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">RO ACTIVE (ROA)</span>
                <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                    <i data-lucide="store" class="w-4 h-4"></i>
                </div>
            </div>
            <div class="text-2xl font-bold text-amber-600 mt-2">76.2%</div>
            <div class="text-[11px] text-slate-500 mt-1">3.995 / 5.240 Outlets</div>
        </div>

        <!-- KPI 6: EC -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs hover:shadow-md transition-all">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">EFFECTIVE CALL</span>
                <div class="w-8 h-8 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center">
                    <i data-lucide="phone-call" class="w-4 h-4"></i>
                </div>
            </div>
            <div class="text-2xl font-bold text-purple-600 mt-2">91.5%</div>
            <div class="text-[11px] text-slate-500 mt-1">Call Compliance</div>
        </div>

    </div>

    <!-- Metis-Style Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Revenue Overview Line Chart -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Revenue Overview vs Target (Miliar Rp)</h3>
                    <p class="text-xs text-slate-500">Kinerja penjualan bulanan PT. Kartini Teh Nasional</p>
                </div>
                <div class="flex items-center gap-1 bg-slate-100 p-1 rounded-xl text-xs">
                    <button class="px-2.5 py-1 rounded-lg bg-white font-bold text-slate-900 shadow-xs">30D</button>
                    <button class="px-2.5 py-1 rounded-lg text-slate-500 hover:text-slate-900">90D</button>
                    <button class="px-2.5 py-1 rounded-lg text-slate-500 hover:text-slate-900">1Y</button>
                </div>
            </div>
            <div class="h-64">
                <canvas id="salesTrendChart"></canvas>
            </div>
        </div>

        <!-- RO & EC Donut / Trend Chart -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-sm font-bold text-slate-900">RO, ROA, & EC Trend (%)</h3>
                    <p class="text-xs text-slate-500">Efektivitas outlet & repeat order toko</p>
                </div>
                <span class="text-xs px-2.5 py-1 rounded-full bg-indigo-50 text-indigo-700 font-bold border border-indigo-200">Concox GT06N Verified</span>
            </div>
            <div class="h-64">
                <canvas id="roTrendChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Area Performance & Top Sales Highlight (PRD Section 8) -->
    <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-4 gap-2">
            <div>
                <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                    <i data-lucide="map" class="w-4 h-4 text-emerald-600"></i> Regional Performance & Multi-Level Drill Down
                </h3>
                <p class="text-xs text-slate-500">Klik area untuk drilldown: Region → Area → Kabupaten → Kecamatan → Sales → Outlet → Product</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-xs text-slate-500 font-medium">Status:</span>
                <span class="text-xs px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 font-bold border border-emerald-200">🟢 Good</span>
                <span class="text-xs px-2.5 py-0.5 rounded-full bg-amber-50 text-amber-700 font-bold border border-amber-200">🟡 Warning</span>
                <span class="text-xs px-2.5 py-0.5 rounded-full bg-rose-50 text-rose-700 font-bold border border-rose-200">🔴 Critical</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-4">Area</th>
                        <th class="py-3 px-4">Target</th>
                        <th class="py-3 px-4">Actual</th>
                        <th class="py-3 px-4">Achievement</th>
                        <th class="py-3 px-4">Growth</th>
                        <th class="py-3 px-4">RO</th>
                        <th class="py-3 px-4">ROA</th>
                        <th class="py-3 px-4">EC</th>
                        <th class="py-3 px-4 text-center">Status</th>
                        <th class="py-3 px-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr class="hover:bg-emerald-50/50 bg-emerald-50/20 font-semibold">
                        <td class="py-3 px-4 font-bold text-slate-900 flex items-center gap-2">
                            <span>Boyolali (Cepogo)</span>
                            <span class="px-2 py-0.5 rounded text-[10px] bg-emerald-600 text-white font-bold">Top Sales</span>
                        </td>
                        <td class="py-3 px-4">Rp 2.200.000.000</td>
                        <td class="py-3 px-4 font-bold text-emerald-700">Rp 2.530.000.000</td>
                        <td class="py-3 px-4 font-bold text-emerald-600">115%</td>
                        <td class="py-3 px-4 text-emerald-600 font-bold">+15.2%</td>
                        <td class="py-3 px-4">96%</td>
                        <td class="py-3 px-4">92%</td>
                        <td class="py-3 px-4">98%</td>
                        <td class="py-3 px-4 text-center text-lg">🟢</td>
                        <td class="py-3 px-4 text-right">
                            <a href="{{ route('dashboard.area') }}?select_area=boyolali" class="inline-flex items-center gap-1 text-xs px-2.5 py-1 rounded-xl bg-emerald-600 text-white hover:bg-emerald-700 font-bold shadow-xs">
                                <span>Drilldown</span>
                                <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                            </a>
                        </td>
                    </tr>
                    @foreach($dashboardData['executive']['area_performance'] as $area)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="py-3 px-4 font-bold text-slate-900">{{ $area['area'] }}</td>
                        <td class="py-3 px-4">Rp {{ is_numeric($area['target']) ? number_format($area['target'], 0, ',', '.') : $area['target'] }}</td>
                        <td class="py-3 px-4 font-semibold text-slate-800">Rp {{ is_numeric($area['actual']) ? number_format($area['actual'], 0, ',', '.') : $area['actual'] }}</td>
                        <td class="py-3 px-4">
                            <span class="font-bold {{ $area['achievement'] >= 90 ? 'text-emerald-600' : ($area['achievement'] >= 75 ? 'text-amber-600' : 'text-rose-600') }}">
                                {{ $area['achievement'] }}%
                            </span>
                        </td>
                        <td class="py-3 px-4">
                            <span class="{{ $area['growth'] >= 0 ? 'text-emerald-600' : 'text-rose-600' }} font-semibold">
                                {{ $area['growth'] >= 0 ? '+' : '' }}{{ $area['growth'] }}%
                            </span>
                        </td>
                        <td class="py-3 px-4">{{ $area['ro'] }}%</td>
                        <td class="py-3 px-4">{{ $area['roa'] }}%</td>
                        <td class="py-3 px-4">{{ $area['ec'] }}%</td>
                        <td class="py-3 px-4 text-center text-lg">{{ $area['color'] }}</td>
                        <td class="py-3 px-4 text-right">
                            <a href="{{ route('dashboard.area') }}?select_area={{ strtolower($area['area']) }}" class="inline-flex items-center gap-1 text-xs px-2.5 py-1 rounded-xl bg-slate-100 text-slate-700 hover:bg-slate-200 font-semibold border border-slate-200">
                                <span>Drilldown</span>
                                <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx1 = document.getElementById('salesTrendChart').getContext('2d');
        new Chart(ctx1, {
            type: 'line',
            data: {
                labels: {!! json_encode($dashboardData['executive']['sales_trend']['labels']) !!},
                datasets: [
                    {
                        label: 'Actual Sales (Miliar Rp)',
                        data: {!! json_encode($dashboardData['executive']['sales_trend']['actual']) !!},
                        borderColor: '#4f46e5',
                        backgroundColor: 'rgba(79, 70, 229, 0.08)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 3
                    },
                    {
                        label: 'Target Sales',
                        data: {!! json_encode($dashboardData['executive']['sales_trend']['target']) !!},
                        borderColor: '#94a3b8',
                        borderDash: [5, 5],
                        borderWidth: 2,
                        pointRadius: 0
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { labels: { color: '#475569', font: { size: 11, family: 'Plus Jakarta Sans' } } }
                },
                scales: {
                    x: { ticks: { color: '#64748b' }, grid: { color: '#f1f5f9' } },
                    y: { ticks: { color: '#64748b' }, grid: { color: '#f1f5f9' } }
                }
            }
        });

        const ctx2 = document.getElementById('roTrendChart').getContext('2d');
        new Chart(ctx2, {
            type: 'line',
            data: {
                labels: {!! json_encode($dashboardData['executive']['ro_trend']['labels']) !!},
                datasets: [
                    {
                        label: 'RO %',
                        data: {!! json_encode($dashboardData['executive']['ro_trend']['ro']) !!},
                        borderColor: '#0284c7',
                        tension: 0.3,
                        borderWidth: 2.5
                    },
                    {
                        label: 'ROA %',
                        data: {!! json_encode($dashboardData['executive']['ro_trend']['roa']) !!},
                        borderColor: '#d97706',
                        tension: 0.3,
                        borderWidth: 2.5
                    },
                    {
                        label: 'EC %',
                        data: {!! json_encode($dashboardData['executive']['ro_trend']['ec']) !!},
                        borderColor: '#9333ea',
                        tension: 0.3,
                        borderWidth: 2.5
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { labels: { color: '#475569', font: { size: 11, family: 'Plus Jakarta Sans' } } }
                },
                scales: {
                    x: { ticks: { color: '#64748b' }, grid: { color: '#f1f5f9' } },
                    y: { ticks: { color: '#64748b' }, grid: { color: '#f1f5f9' } }
                }
            }
        });
    });
</script>
@endpush
