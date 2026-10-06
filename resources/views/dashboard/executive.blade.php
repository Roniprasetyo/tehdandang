@extends('layouts.app')

@section('title', 'Executive Dashboard - Sales Force Management')

@section('content')
<div class="space-y-6" x-data="executiveDashboard()">

    <!-- Header Section -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
        <div>
            <h1 class="text-xl font-bold font-display text-slate-900">Selamat datang, Bapak/Ibu Owner</h1>
            <p class="text-xs text-slate-500 mt-0.5">Berikut ringkasan kinerja bisnis Anda hari ini</p>
        </div>
        
        <div class="flex items-center flex-wrap gap-3">
            <!-- Date Picker Filter -->
            <div class="flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-xl px-3 py-1.5 text-xs font-semibold text-slate-700">
                <i data-lucide="calendar" class="w-4 h-4 text-slate-500"></i>
                <input type="text" value="06 Oktober 2026" readonly class="bg-transparent border-none p-0 text-xs font-bold text-slate-800 focus:outline-none w-28 cursor-pointer">
            </div>

            <!-- Region Filter -->
            <div class="flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-xl px-3 py-1.5 text-xs font-semibold text-slate-700">
                <i data-lucide="globe" class="w-4 h-4 text-slate-500"></i>
                <select x-model="selectedRegion" @change="filterByRegion()" class="bg-transparent border-none p-0 text-xs font-bold text-slate-800 focus:outline-none cursor-pointer">
                    <option value="all">Semua Wilayah</option>
                    <option value="Region 1">Region 1 (Solo Raya)</option>
                    <option value="Region 2">Region 2 (Semarang)</option>
                    <option value="Region 3">Region 3 (Kedu)</option>
                    <option value="Region 4">Region 4 (Pati)</option>
                    <option value="Region 5">Region 5 (Banyumas)</option>
                </select>
            </div>

            <!-- Owner Badge -->
            <div class="flex items-center gap-2 bg-indigo-50 border border-indigo-200/80 rounded-xl px-3 py-1.5 text-xs text-indigo-700 font-bold">
                <div class="w-6 h-6 rounded-full bg-indigo-600 text-white font-bold text-[10px] flex items-center justify-center">OW</div>
                <span>Owner</span>
            </div>

            <!-- Drilldown Quick Link -->
            <a href="{{ route('dashboard.drilldown') }}" class="px-3.5 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-xs transition-all flex items-center gap-1.5">
                <i data-lucide="bar-chart-2" class="w-4 h-4"></i>
                <span>Grafik Drilldown 7 Level</span>
            </a>
        </div>
    </div>

    <!-- Top 6 KPI Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
        
        <!-- Card 1: Penjualan (Sales) -->
        <div @click="openModal('sales')" class="bg-white border border-slate-200/80 rounded-2xl p-4 shadow-xs hover:shadow-md transition-all cursor-pointer group">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-slate-700">Penjualan (Sales)</span>
                <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i data-lucide="trending-up" class="w-4 h-4"></i>
                </div>
            </div>
            <div class="text-2xl font-extrabold font-display text-emerald-600 mt-2">Rp 2,8 M</div>
            <div class="text-[11px] text-slate-500 mt-1">Target Rp 3,10 M | <span class="font-bold text-slate-700">92,6%</span></div>
            <div class="mt-2 text-[10px] font-bold text-emerald-600 bg-emerald-50 border border-emerald-100 rounded-lg px-2 py-0.5 inline-flex items-center gap-1">
                <i data-lucide="arrow-up" class="w-3 h-3"></i> +8,2% vs periode lalu
            </div>
        </div>

        <!-- Card 2: Sales Aktif -->
        <div @click="openModal('sales_active')" class="bg-white border border-slate-200/80 rounded-2xl p-4 shadow-xs hover:shadow-md transition-all cursor-pointer group">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-slate-700">Sales Aktif</span>
                <div class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i data-lucide="users" class="w-4 h-4"></i>
                </div>
            </div>
            <div class="text-2xl font-extrabold font-display text-slate-900 mt-2">876 <span class="text-xs text-slate-400 font-normal">/ 920</span></div>
            <div class="text-[11px] text-indigo-600 font-bold mt-1">95,2% aktif</div>
            <div class="mt-2 text-[10px] font-bold text-emerald-600 bg-emerald-50 border border-emerald-100 rounded-lg px-2 py-0.5 inline-flex items-center gap-1">
                <i data-lucide="arrow-up" class="w-3 h-3"></i> +2,1% vs bulan lalu
            </div>
        </div>

        <!-- Card 3: Visit Compliance -->
        <div @click="openModal('visit_compliance')" class="bg-white border border-slate-200/80 rounded-2xl p-4 shadow-xs hover:shadow-md transition-all cursor-pointer group">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-slate-700">Visit Compliance</span>
                <div class="w-8 h-8 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i data-lucide="map-pin" class="w-4 h-4"></i>
                </div>
            </div>
            <div class="text-2xl font-extrabold font-display text-slate-900 mt-2">91%</div>
            <div class="text-[11px] text-slate-500 mt-1">7.735 / 8.500 visit</div>
            <div class="mt-2 text-[10px] font-bold text-rose-600 bg-rose-50 border border-rose-100 rounded-lg px-2 py-0.5 inline-flex items-center gap-1">
                <i data-lucide="arrow-down" class="w-3 h-3"></i> -3,4% vs kemarin
            </div>
        </div>

        <!-- Card 4: Outlet Baru -->
        <div @click="openModal('new_outlet')" class="bg-white border border-slate-200/80 rounded-2xl p-4 shadow-xs hover:shadow-md transition-all cursor-pointer group">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-slate-700">Outlet Baru</span>
                <div class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i data-lucide="store" class="w-4 h-4"></i>
                </div>
            </div>
            <div class="text-2xl font-extrabold font-display text-slate-900 mt-2">132</div>
            <div class="text-[11px] text-slate-500 mt-1">Target 150</div>
            <div class="mt-2 text-[10px] font-bold text-emerald-600 bg-emerald-50 border border-emerald-100 rounded-lg px-2 py-0.5 inline-flex items-center gap-1">
                <i data-lucide="arrow-up" class="w-3 h-3"></i> +15% vs bulan lalu
            </div>
        </div>

        <!-- Card 5: Outlet Aktif -->
        <div @click="openModal('active_outlet')" class="bg-white border border-slate-200/80 rounded-2xl p-4 shadow-xs hover:shadow-md transition-all cursor-pointer group">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-slate-700">Outlet Aktif</span>
                <div class="w-8 h-8 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i data-lucide="shopping-bag" class="w-4 h-4"></i>
                </div>
            </div>
            <div class="text-2xl font-extrabold font-display text-slate-900 mt-2">7.850</div>
            <div class="text-[11px] text-slate-500 mt-1">vs bulan lalu</div>
            <div class="mt-2 text-[10px] font-bold text-emerald-600 bg-emerald-50 border border-emerald-100 rounded-lg px-2 py-0.5 inline-flex items-center gap-1">
                <i data-lucide="arrow-up" class="w-3 h-3"></i> +4,2%
            </div>
        </div>

        <!-- Card 6: Order -->
        <div @click="openModal('order')" class="bg-white border border-slate-200/80 rounded-2xl p-4 shadow-xs hover:shadow-md transition-all cursor-pointer group">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-slate-700">Order</span>
                <div class="w-8 h-8 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i data-lucide="shopping-cart" class="w-4 h-4"></i>
                </div>
            </div>
            <div class="text-2xl font-extrabold font-display text-slate-900 mt-2">4.821</div>
            <div class="text-[11px] text-slate-500 mt-1">vs periode lalu</div>
            <div class="mt-2 text-[10px] font-bold text-emerald-600 bg-emerald-50 border border-emerald-100 rounded-lg px-2 py-0.5 inline-flex items-center gap-1">
                <i data-lucide="arrow-up" class="w-3 h-3"></i> +8,2%
            </div>
        </div>

    </div>

    <!-- Middle Section: 3 Columns Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- Tren Penjualan Chart (Col 5) -->
        <div class="lg:col-span-5 bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-2">
                    <div>
                        <h3 class="text-sm font-bold text-slate-900">Tren Penjualan</h3>
                        <p class="text-xs text-slate-500">Perbandingan Realisasi vs Target (dalam Miliar Rupiah)</p>
                    </div>
                    <button @click="openModal('sales_trend')" class="text-xs text-indigo-600 font-bold hover:underline">
                        Detail ➔
                    </button>
                </div>
                <!-- Callout Badge -->
                <div class="bg-indigo-50/80 border border-indigo-100 rounded-xl p-2.5 flex items-center justify-between my-2 text-xs">
                    <span class="font-bold text-indigo-900">Okt 2026</span>
                    <span class="font-extrabold text-indigo-700">Rp 2,87 M <span class="text-[11px] font-medium text-indigo-600">(92,6%)</span></span>
                </div>
            </div>

            <div class="h-56 relative w-full mt-2">
                <canvas id="mainSalesTrendChart"></canvas>
            </div>
        </div>

        <!-- Performa 5 Wilayah Table (Col 4) -->
        <div class="lg:col-span-4 bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-sm font-bold text-slate-900">Performa 5 Wilayah</h3>
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Score Overall</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] font-bold border-b border-slate-200">
                        <tr>
                            <th class="py-2 px-2">Wilayah</th>
                            <th class="py-2 px-1 text-center">Sales</th>
                            <th class="py-2 px-1 text-center">Visit</th>
                            <th class="py-2 px-1 text-center">New Outlet</th>
                            <th class="py-2 px-1 text-center">SKU</th>
                            <th class="py-2 px-2 text-right">Score</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-[11px]">
                        <tr @click="openRegionDetail('Region 1')" class="hover:bg-slate-50 cursor-pointer transition-colors">
                            <td class="py-2.5 px-2 font-bold text-slate-800 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Region 1
                            </td>
                            <td class="py-2.5 px-1 text-center font-medium">96%</td>
                            <td class="py-2.5 px-1 text-center font-medium">94%</td>
                            <td class="py-2.5 px-1 text-center font-medium">102%</td>
                            <td class="py-2.5 px-1 text-center font-medium">88%</td>
                            <td class="py-2.5 px-2 text-right">
                                <span class="px-2 py-0.5 rounded-lg bg-emerald-100 text-emerald-800 font-extrabold text-xs">91</span>
                            </td>
                        </tr>
                        <tr @click="openRegionDetail('Region 2')" class="hover:bg-slate-50 cursor-pointer transition-colors">
                            <td class="py-2.5 px-2 font-bold text-slate-800 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-amber-500"></span> Region 2
                            </td>
                            <td class="py-2.5 px-1 text-center font-medium">81%</td>
                            <td class="py-2.5 px-1 text-center font-medium">86%</td>
                            <td class="py-2.5 px-1 text-center font-medium">78%</td>
                            <td class="py-2.5 px-1 text-center font-medium">71%</td>
                            <td class="py-2.5 px-2 text-right">
                                <span class="px-2 py-0.5 rounded-lg bg-amber-100 text-amber-800 font-extrabold text-xs">75</span>
                            </td>
                        </tr>
                        <tr @click="openRegionDetail('Region 3')" class="hover:bg-slate-50 cursor-pointer transition-colors">
                            <td class="py-2.5 px-2 font-bold text-slate-800 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Region 3
                            </td>
                            <td class="py-2.5 px-1 text-center font-medium">103%</td>
                            <td class="py-2.5 px-1 text-center font-medium">97%</td>
                            <td class="py-2.5 px-1 text-center font-medium">110%</td>
                            <td class="py-2.5 px-1 text-center font-medium">94%</td>
                            <td class="py-2.5 px-2 text-right">
                                <span class="px-2 py-0.5 rounded-lg bg-emerald-100 text-emerald-800 font-extrabold text-xs">96</span>
                            </td>
                        </tr>
                        <tr @click="openRegionDetail('Region 4')" class="hover:bg-slate-50 cursor-pointer transition-colors">
                            <td class="py-2.5 px-2 font-bold text-slate-800 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-rose-500"></span> Region 4
                            </td>
                            <td class="py-2.5 px-1 text-center font-medium">72%</td>
                            <td class="py-2.5 px-1 text-center font-medium">79%</td>
                            <td class="py-2.5 px-1 text-center font-medium">65%</td>
                            <td class="py-2.5 px-1 text-center font-medium">62%</td>
                            <td class="py-2.5 px-2 text-right">
                                <span class="px-2 py-0.5 rounded-lg bg-rose-100 text-rose-800 font-extrabold text-xs">64</span>
                            </td>
                        </tr>
                        <tr @click="openRegionDetail('Region 5')" class="hover:bg-slate-50 cursor-pointer transition-colors">
                            <td class="py-2.5 px-2 font-bold text-slate-800 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Region 5
                            </td>
                            <td class="py-2.5 px-1 text-center font-medium">94%</td>
                            <td class="py-2.5 px-1 text-center font-medium">91%</td>
                            <td class="py-2.5 px-1 text-center font-medium">98%</td>
                            <td class="py-2.5 px-1 text-center font-medium">85%</td>
                            <td class="py-2.5 px-2 text-right">
                                <span class="px-2 py-0.5 rounded-lg bg-emerald-100 text-emerald-800 font-extrabold text-xs">89</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Sales Quality Index Gauge (Col 3) -->
        <div @click="openModal('sqi')" class="lg:col-span-3 bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs flex flex-col justify-between cursor-pointer hover:shadow-md transition-all">
            <div>
                <h3 class="text-sm font-bold text-slate-900">Sales Quality Index</h3>
                <p class="text-xs text-slate-500 mt-0.5">Indeks Kualitas Penjualan</p>
            </div>

            <div class="flex items-center justify-center my-3">
                <div class="relative w-36 h-36 flex items-center justify-center">
                    <canvas id="sqiDonutChart"></canvas>
                    <div class="absolute inset-0 flex flex-col items-center justify-center text-center">
                        <span class="text-2xl font-extrabold font-display text-slate-900">78</span>
                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">/100</span>
                    </div>
                </div>
            </div>

            <div class="space-y-1 text-[10px] font-semibold text-slate-600 border-t border-slate-100 pt-3">
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-blue-500"></span> Sales Achievement</span>
                    <span class="font-bold text-slate-900">30%</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-emerald-500"></span> Outlet Growth</span>
                    <span class="font-bold text-slate-900">20%</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-amber-500"></span> SKU Penetration</span>
                    <span class="font-bold text-slate-900">15%</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-indigo-500"></span> Visit Compliance</span>
                    <span class="font-bold text-slate-900">15%</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-teal-500"></span> New Outlet</span>
                    <span class="font-bold text-slate-900">10%</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-purple-500"></span> SOP Compliance</span>
                    <span class="font-bold text-slate-900">10%</span>
                </div>
            </div>
        </div>

    </div>

    <!-- Bottom Section Row 1: 5 Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">

        <!-- Outlet Health Card -->
        <div @click="openModal('outlet_health')" class="bg-white border border-slate-200/80 rounded-2xl p-4 shadow-xs hover:shadow-md transition-all cursor-pointer flex flex-col justify-between">
            <div>
                <h3 class="text-xs font-bold text-slate-900">Outlet Health</h3>
                
                <div class="relative w-28 h-28 mx-auto my-3 flex items-center justify-center">
                    <canvas id="outletHealthChart"></canvas>
                    <div class="absolute inset-0 flex flex-col items-center justify-center text-center">
                        <span class="text-sm font-extrabold font-display text-slate-900">7.850</span>
                        <span class="text-[9px] text-slate-400 font-bold">Total Outlet</span>
                    </div>
                </div>
            </div>

            <div class="space-y-1.5 text-[10px]">
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-1 font-medium"><span class="w-2 h-2 rounded-full bg-emerald-500"></span> Healthy</span>
                    <span class="font-bold text-slate-800">5.760 <span class="text-slate-400">(72%)</span></span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-1 font-medium"><span class="w-2 h-2 rounded-full bg-amber-500"></span> At Risk</span>
                    <span class="font-bold text-slate-800">1.520 <span class="text-slate-400">(19%)</span></span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-1 font-medium"><span class="w-2 h-2 rounded-full bg-rose-500"></span> Critical</span>
                    <span class="font-bold text-slate-800">720 <span class="text-slate-400">(9%)</span></span>
                </div>
            </div>
        </div>

        <!-- Outlet At Risk Card -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-4 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-xs font-bold text-slate-900 flex items-center gap-1.5">
                        <i data-lucide="alert-triangle" class="w-3.5 h-3.5 text-rose-500"></i> Outlet At Risk
                    </h3>
                </div>

                <div class="bg-rose-50 border border-rose-100 rounded-xl p-2 mb-3">
                    <span class="font-extrabold text-rose-700 text-xs">127</span>
                    <span class="text-[10px] text-rose-600 font-medium"> outlet berisiko kehilangan penjualan</span>
                </div>

                <div class="text-[10px] text-slate-500 font-bold uppercase mb-1">Penyebab utama:</div>
                <ul class="space-y-1 text-[11px] text-slate-700">
                    <li class="flex items-center justify-between"><span class="text-slate-600">• Tidak dikunjungi &gt; 14 hari</span> <span class="font-bold text-slate-900">48</span></li>
                    <li class="flex items-center justify-between"><span class="text-slate-600">• Tidak order &gt; 14 hari</span> <span class="font-bold text-slate-900">32</span></li>
                    <li class="flex items-center justify-between"><span class="text-slate-600">• Omzet turun &gt; 30%</span> <span class="font-bold text-slate-900">21</span></li>
                    <li class="flex items-center justify-between"><span class="text-slate-600">• SKU berkurang</span> <span class="font-bold text-slate-900">14</span></li>
                    <li class="flex items-center justify-between"><span class="text-slate-600">• Stok kosong</span> <span class="font-bold text-slate-900">8</span></li>
                    <li class="flex items-center justify-between"><span class="text-slate-600">• Kompetitor terdeteksi</span> <span class="font-bold text-slate-900">4</span></li>
                </ul>
            </div>

            <div class="mt-3 text-right">
                <button @click="openModal('outlet_risk')" class="text-[11px] font-bold text-indigo-600 hover:text-indigo-800 flex items-center justify-end gap-1 ml-auto">
                    <span>Lihat semua</span>
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                </button>
            </div>
        </div>

        <!-- Product Expiry Risk Card -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-4 shadow-xs flex flex-col justify-between">
            <div>
                <h3 class="text-xs font-bold text-slate-900 flex items-center gap-1.5 mb-3">
                    <i data-lucide="package-x" class="w-3.5 h-3.5 text-amber-500"></i> Product Expiry Risk
                </h3>

                <div class="space-y-2 text-[11px]">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-600">Near expiry &lt; 30 hari</span>
                        <span class="font-bold text-slate-900">1.280 <span class="text-[9px] text-slate-400 font-normal">case</span></span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-600">Near expiry &lt; 14 hari</span>
                        <span class="font-bold text-slate-900">420 <span class="text-[9px] text-slate-400 font-normal">case</span></span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-600 font-bold text-rose-600">Already expired</span>
                        <span class="font-bold text-rose-600">37 <span class="text-[9px] text-rose-500 font-normal">case</span></span>
                    </div>
                </div>

                <div class="mt-4 bg-amber-50 border border-amber-200 rounded-xl p-2 text-[10px] text-amber-800 font-bold flex items-center gap-1.5">
                    <i data-lucide="alert-circle" class="w-3.5 h-3.5 text-amber-600 flex-shrink-0"></i>
                    <span>Top 10 Outlet Risiko Expiry</span>
                </div>
            </div>

            <div class="mt-3 text-right">
                <button @click="openModal('expiry_risk')" class="text-[11px] font-bold text-indigo-600 hover:text-indigo-800 flex items-center justify-end gap-1 ml-auto">
                    <span>Lihat detail</span>
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                </button>
            </div>
        </div>

        <!-- Company Asset Card -->
        <div @click="openModal('company_asset')" class="bg-white border border-slate-200/80 rounded-2xl p-4 shadow-xs hover:shadow-md transition-all cursor-pointer flex flex-col justify-between">
            <div>
                <h3 class="text-xs font-bold text-slate-900 mb-1">Company Asset</h3>
                <div class="text-[10px] text-slate-400 font-medium">Total Deployed</div>
                <div class="text-xl font-extrabold font-display text-slate-900 mt-0.5">8.420</div>

                <div class="space-y-1.5 mt-3 text-[10px]">
                    <div class="flex items-center justify-between">
                        <span class="flex items-center gap-1 font-medium"><span class="w-2 h-2 rounded-full bg-emerald-500"></span> Good</span>
                        <span class="font-bold text-slate-800">6.930 <span class="text-slate-400">(82%)</span></span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="flex items-center gap-1 font-medium"><span class="w-2 h-2 rounded-full bg-amber-500"></span> Damaged</span>
                        <span class="font-bold text-slate-800">970 <span class="text-slate-400">(12%)</span></span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="flex items-center gap-1 font-medium"><span class="w-2 h-2 rounded-full bg-rose-500"></span> Missing</span>
                        <span class="font-bold text-slate-800">320 <span class="text-slate-400">(4%)</span></span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="flex items-center gap-1 font-medium"><span class="w-2 h-2 rounded-full bg-slate-400"></span> Retired</span>
                        <span class="font-bold text-slate-800">200 <span class="text-slate-400">(2%)</span></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fleet Card -->
        <div @click="openModal('fleet')" class="bg-white border border-slate-200/80 rounded-2xl p-4 shadow-xs hover:shadow-md transition-all cursor-pointer flex flex-col justify-between">
            <div>
                <h3 class="text-xs font-bold text-slate-900 mb-1 flex items-center gap-1.5">
                    <i data-lucide="truck" class="w-3.5 h-3.5 text-indigo-600"></i> Fleet
                </h3>
                <div class="text-xl font-extrabold font-display text-slate-900 mt-1">185 <span class="text-xs text-slate-400 font-normal">Kendaraan</span></div>

                <div class="space-y-2 mt-4 text-[10px]">
                    <div class="flex items-center justify-between">
                        <span class="flex items-center gap-1 font-medium"><span class="w-2 h-2 rounded-full bg-emerald-500"></span> Normal</span>
                        <span class="font-bold text-slate-800">163</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="flex items-center gap-1 font-medium"><span class="w-2 h-2 rounded-full bg-amber-500"></span> Outside Route</span>
                        <span class="font-bold text-slate-800">15</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="flex items-center gap-1 font-medium"><span class="w-2 h-2 rounded-full bg-rose-500"></span> Suspected Misuse</span>
                        <span class="font-bold text-slate-800">7</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bottom Section Row 2: 4 Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-6">

        <!-- Peta Persebaran Sales (Col 3) -->
        <div @click="openModal('sales_map')" class="lg:col-span-3 bg-white border border-slate-200/80 rounded-2xl p-4 shadow-xs hover:shadow-md transition-all cursor-pointer flex flex-col justify-between">
            <div>
                <h3 class="text-xs font-bold text-slate-900 mb-2">Peta Persebaran Sales</h3>
                
                <!-- Map Graphic Container -->
                <div class="bg-indigo-50/50 border border-indigo-100 rounded-xl p-3 h-36 relative overflow-hidden flex items-center justify-center">
                    <svg class="w-full h-full text-indigo-200" viewBox="0 0 200 100" fill="currentColor">
                        <path d="M20,40 Q40,25 70,35 T120,40 T170,30 T190,50 Q160,70 120,65 T60,70 Z" opacity="0.4"/>
                        <circle cx="50" cy="45" r="4" class="fill-emerald-500 animate-ping"/>
                        <circle cx="50" cy="45" r="4" class="fill-emerald-600"/>
                        <circle cx="85" cy="40" r="4" class="fill-amber-500"/>
                        <circle cx="115" cy="50" r="4" class="fill-emerald-500"/>
                        <circle cx="145" cy="42" r="4" class="fill-rose-500"/>
                        <circle cx="170" cy="48" r="4" class="fill-emerald-500"/>
                    </svg>
                    <div class="absolute bottom-2 left-2 text-[9px] font-bold bg-white/90 px-2 py-0.5 rounded shadow-xs text-indigo-900">
                        GPS Live Concox GT06N Active
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-x-2 gap-y-1 text-[10px] mt-3 font-semibold">
                <div class="flex items-center justify-between"><span class="text-slate-500">Region 1</span> <span class="text-slate-900">96%</span></div>
                <div class="flex items-center justify-between"><span class="text-slate-500">Region 2</span> <span class="text-slate-900">81%</span></div>
                <div class="flex items-center justify-between"><span class="text-slate-500">Region 3</span> <span class="text-slate-900">103%</span></div>
                <div class="flex items-center justify-between"><span class="text-slate-500">Region 4</span> <span class="text-slate-900">72%</span></div>
                <div class="flex items-center justify-between col-span-2"><span class="text-slate-500">Region 5</span> <span class="text-slate-900">94%</span></div>
            </div>
        </div>

        <!-- Daily Plan Compliance (Col 3) -->
        <div @click="openModal('daily_plan')" class="lg:col-span-3 bg-white border border-slate-200/80 rounded-2xl p-4 shadow-xs hover:shadow-md transition-all cursor-pointer flex flex-col justify-between">
            <div>
                <h3 class="text-xs font-bold text-slate-900 mb-2">Daily Plan Compliance</h3>

                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-extrabold font-display text-emerald-600">88%</span>
                    <span class="text-[10px] font-bold text-slate-400 uppercase">Completion Rate</span>
                </div>

                <div class="grid grid-cols-2 gap-2 text-[10px] my-3">
                    <div class="bg-slate-50 p-1.5 rounded-lg border border-slate-100">
                        <span class="text-slate-400 block">Planned</span>
                        <span class="font-bold text-slate-800">8.920</span>
                    </div>
                    <div class="bg-slate-50 p-1.5 rounded-lg border border-slate-100">
                        <span class="text-slate-400 block">Completed</span>
                        <span class="font-bold text-emerald-600">7.850</span>
                    </div>
                    <div class="bg-slate-50 p-1.5 rounded-lg border border-slate-100">
                        <span class="text-slate-400 block">Missed</span>
                        <span class="font-bold text-rose-600">620</span>
                    </div>
                    <div class="bg-slate-50 p-1.5 rounded-lg border border-slate-100">
                        <span class="text-slate-400 block">Rescheduled</span>
                        <span class="font-bold text-amber-600">450</span>
                    </div>
                </div>
            </div>

            <div class="space-y-1 text-[9px] font-semibold">
                <div class="text-slate-400 uppercase font-bold text-[9px] mb-1">Per Wilayah:</div>
                <div class="flex items-center gap-2">
                    <span class="w-4 text-slate-500">R1</span>
                    <div class="flex-1 bg-slate-100 rounded-full h-1.5 overflow-hidden">
                        <div class="bg-emerald-500 h-1.5 rounded-full" style="width: 94%"></div>
                    </div>
                    <span class="w-6 text-right font-bold text-slate-700">94%</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-4 text-slate-500">R2</span>
                    <div class="flex-1 bg-slate-100 rounded-full h-1.5 overflow-hidden">
                        <div class="bg-teal-500 h-1.5 rounded-full" style="width: 91%"></div>
                    </div>
                    <span class="w-6 text-right font-bold text-slate-700">91%</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-4 text-slate-500">R3</span>
                    <div class="flex-1 bg-slate-100 rounded-full h-1.5 overflow-hidden">
                        <div class="bg-emerald-500 h-1.5 rounded-full" style="width: 96%"></div>
                    </div>
                    <span class="w-6 text-right font-bold text-slate-700">96%</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-4 text-slate-500">R4</span>
                    <div class="flex-1 bg-slate-100 rounded-full h-1.5 overflow-hidden">
                        <div class="bg-rose-500 h-1.5 rounded-full" style="width: 73%"></div>
                    </div>
                    <span class="w-6 text-right font-bold text-slate-700">73%</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-4 text-slate-500">R5</span>
                    <div class="flex-1 bg-slate-100 rounded-full h-1.5 overflow-hidden">
                        <div class="bg-emerald-500 h-1.5 rounded-full" style="width: 89%"></div>
                    </div>
                    <span class="w-6 text-right font-bold text-slate-700">89%</span>
                </div>
            </div>
        </div>

        <!-- Alert Center (Col 3) -->
        <div class="lg:col-span-3 bg-white border border-slate-200/80 rounded-2xl p-4 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-xs font-bold text-slate-900 flex items-center gap-1.5">
                        <i data-lucide="bell" class="w-3.5 h-3.5 text-rose-500"></i> Alert Center
                    </h3>
                </div>

                <div class="bg-rose-50 border border-rose-100 rounded-xl p-2 mb-3">
                    <span class="font-extrabold text-rose-700 text-xs">17</span>
                    <span class="text-[10px] text-rose-600 font-bold"> High Risk</span>
                </div>

                <ul class="space-y-1.5 text-[11px] text-slate-700">
                    <li class="flex items-center gap-2">
                        <span class="w-4 h-4 rounded bg-rose-100 text-rose-700 font-bold text-[9px] flex items-center justify-center flex-shrink-0">7</span>
                        <span class="text-slate-600 truncate">Suspicious orders</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="w-4 h-4 rounded bg-amber-100 text-amber-700 font-bold text-[9px] flex items-center justify-center flex-shrink-0">4</span>
                        <span class="text-slate-600 truncate">Duplicate outlet suspected</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="w-4 h-4 rounded bg-amber-100 text-amber-700 font-bold text-[9px] flex items-center justify-center flex-shrink-0">3</span>
                        <span class="text-slate-600 truncate">Cross-area transaction</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="w-4 h-4 rounded bg-rose-100 text-rose-700 font-bold text-[9px] flex items-center justify-center flex-shrink-0">2</span>
                        <span class="text-slate-600 truncate">Vehicle misuse</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="w-4 h-4 rounded bg-amber-100 text-amber-700 font-bold text-[9px] flex items-center justify-center flex-shrink-0">1</span>
                        <span class="text-slate-600 truncate">Abnormal promo purchase</span>
                    </li>
                </ul>
            </div>

            <div class="mt-3 text-right">
                <button @click="openModal('alert_center')" class="text-[11px] font-bold text-indigo-600 hover:text-indigo-800 flex items-center justify-end gap-1 ml-auto">
                    <span>Lihat semua</span>
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                </button>
            </div>
        </div>

        <!-- What needs my attention today? (Col 3) -->
        <div class="lg:col-span-3 bg-rose-50/40 border border-rose-100 rounded-2xl p-4 shadow-xs flex flex-col justify-between">
            <div>
                <h3 class="text-xs font-bold text-rose-900 flex items-center gap-1.5 mb-3">
                    <i data-lucide="target" class="w-3.5 h-3.5 text-rose-600"></i> What needs my attention today?
                </h3>

                <ul class="space-y-2 text-[10px] text-slate-700">
                    <li @click="openModal('attention_region')" class="flex items-center justify-between bg-white p-2 rounded-xl border border-rose-100 shadow-2xs hover:bg-rose-50 cursor-pointer">
                        <span class="text-slate-700 font-medium truncate">• Region 4 achievement rendah</span>
                        <span class="font-bold text-rose-600 flex items-center gap-1">72% <i data-lucide="chevron-right" class="w-3 h-3"></i></span>
                    </li>
                    <li @click="openModal('outlet_risk')" class="flex items-center justify-between bg-white p-2 rounded-xl border border-rose-100 shadow-2xs hover:bg-rose-50 cursor-pointer">
                        <span class="text-slate-700 font-medium truncate">• 127 outlet belum dikunjungi &gt;14 hari</span>
                        <span class="font-bold text-rose-600 flex items-center gap-1">12% <i data-lucide="chevron-right" class="w-3 h-3"></i></span>
                    </li>
                    <li @click="openModal('expiry_risk')" class="flex items-center justify-between bg-white p-2 rounded-xl border border-rose-100 shadow-2xs hover:bg-rose-50 cursor-pointer">
                        <span class="text-slate-700 font-medium truncate">• 23 outlet risiko near-expiry</span>
                        <span class="font-bold text-rose-600 flex items-center gap-1">3 <i data-lucide="chevron-right" class="w-3 h-3"></i></span>
                    </li>
                    <li @click="openModal('alert_center')" class="flex items-center justify-between bg-white p-2 rounded-xl border border-rose-100 shadow-2xs hover:bg-rose-50 cursor-pointer">
                        <span class="text-slate-700 font-medium truncate">• 17 transaksi terindikasi anomaly</span>
                        <span class="font-bold text-rose-600 flex items-center gap-1">3 <i data-lucide="chevron-right" class="w-3 h-3"></i></span>
                    </li>
                    <li @click="openModal('company_asset')" class="flex items-center justify-between bg-white p-2 rounded-xl border border-rose-100 shadow-2xs hover:bg-rose-50 cursor-pointer">
                        <span class="text-slate-700 font-medium truncate">• 41 asset rusak/hilang</span>
                        <span class="font-bold text-rose-600 flex items-center gap-1">3 <i data-lucide="chevron-right" class="w-3 h-3"></i></span>
                    </li>
                    <li @click="openModal('fleet')" class="flex items-center justify-between bg-white p-2 rounded-xl border border-rose-100 shadow-2xs hover:bg-rose-50 cursor-pointer">
                        <span class="text-slate-700 font-medium truncate">• 7 kendaraan keluar dari area penugasan</span>
                        <span class="font-bold text-rose-600 flex items-center gap-1">3 <i data-lucide="chevron-right" class="w-3 h-3"></i></span>
                    </li>
                </ul>
            </div>

            <div class="mt-3 text-right">
                <button @click="openModal('attention')" class="text-[11px] font-bold text-rose-700 hover:text-rose-900 flex items-center justify-end gap-1 ml-auto">
                    <span>Lihat detail</span>
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                </button>
            </div>
        </div>

    </div>

    <!-- Universal Interactive Detail Modal Overlay -->
    <div 
        x-show="activeModal !== null" 
        x-cloak 
        class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 flex items-center justify-center p-4"
        @keydown.escape.window="closeModal()"
    >
        <div 
            @click.away="closeModal()"
            class="bg-white rounded-2xl max-w-4xl w-full max-h-[90vh] flex flex-col shadow-2xl border border-slate-200 overflow-hidden transform transition-all"
        >
            <!-- Modal Header -->
            <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <i data-lucide="bar-chart-2" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h2 class="text-base font-bold font-display text-slate-900" x-text="modalTitle"></h2>
                        <p class="text-xs text-slate-500" x-text="modalSubtitle"></p>
                    </div>
                </div>

                <button @click="closeModal()" class="p-2 rounded-xl text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-colors">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <!-- Modal Content Body -->
            <div class="p-6 overflow-y-auto space-y-4 text-xs">
                
                <!-- Dynamic KPI Header Cards inside Modal -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <template x-for="(kpi, idx) in modalKpis" :key="idx">
                        <div class="bg-slate-50 border border-slate-200/80 rounded-xl p-3">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block" x-text="kpi.label"></span>
                            <span class="text-lg font-bold text-slate-900 mt-1 block" x-text="kpi.value"></span>
                            <span class="text-[10px] font-semibold mt-0.5 block" :class="kpi.trend >= 0 ? 'text-emerald-600' : 'text-rose-600'" x-text="kpi.subtext"></span>
                        </div>
                    </template>
                </div>

                <!-- Detailed Data Table -->
                <div class="border border-slate-200 rounded-xl overflow-hidden">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] font-bold border-b border-slate-200">
                            <tr>
                                <template x-for="col in modalColumns" :key="col">
                                    <th class="py-2.5 px-3" x-text="col"></th>
                                </template>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <template x-for="(row, rIdx) in modalRows" :key="rIdx">
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <template x-for="(cell, cIdx) in row" :key="cIdx">
                                        <td class="py-2.5 px-3" :class="cIdx === 0 ? 'font-bold text-slate-900' : 'text-slate-700'" x-html="cell"></td>
                                    </template>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>

            </div>

            <!-- Modal Footer Actions -->
            <div class="p-4 border-t border-slate-100 bg-slate-50 flex items-center justify-between">
                <span class="text-[11px] text-slate-500 font-medium">Klik Grafik Drilldown 7 Level untuk visualisasi mendalam.</span>
                <div class="flex items-center gap-2">
                    <a href="{{ route('dashboard.drilldown') }}" class="px-4 py-2 bg-emerald-600 text-white rounded-xl font-bold text-xs hover:bg-emerald-700 transition-all flex items-center gap-1.5">
                        <i data-lucide="bar-chart-2" class="w-4 h-4"></i>
                        <span>Buka Grafik Drilldown</span>
                    </a>
                    <button @click="closeModal()" class="px-4 py-2 bg-slate-200 text-slate-700 rounded-xl font-bold text-xs hover:bg-slate-300 transition-all">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    function executiveDashboard() {
        return {
            selectedRegion: 'all',
            activeModal: null,
            modalTitle: '',
            modalSubtitle: '',
            modalKpis: [],
            modalColumns: [],
            modalRows: [],

            filterByRegion() {
                console.log("Filtered region:", this.selectedRegion);
            },

            closeModal() {
                this.activeModal = null;
            },

            openModal(type) {
                this.activeModal = type;
                if (type === 'sales') {
                    this.modalTitle = 'Detail Penjualan (Sales)';
                    this.modalSubtitle = 'Breakdown Realisasi vs Target Penjualan Nasional & Channel';
                    this.modalKpis = [
                        { label: 'Total Sales Realisasi', value: 'Rp 2,87 Miliar', trend: 1, subtext: '↑ +8,2% vs periode lalu' },
                        { label: 'Target Penjualan', value: 'Rp 3,10 Miliar', trend: 0, subtext: 'Achievement 92,6%' },
                        { label: 'Kategori Top Sales', value: 'Teh Dandang 2in1 25g', trend: 1, subtext: 'Kontribusi 45%' }
                    ];
                    this.modalColumns = ['Channel / Region', 'Target', 'Realisasi', 'Achievement', 'Status'];
                    this.modalRows = [
                        ['General Trade (GT)', 'Rp 2.100.000.000', 'Rp 1.980.000.000', '94,3%', '<span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 rounded font-bold text-[10px]">🟢 Good</span>'],
                        ['Modern Trade (MT)', 'Rp 700.000.000', 'Rp 650.000.000', '92,8%', '<span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 rounded font-bold text-[10px]">🟢 Good</span>'],
                        ['Horeca & Corporate', 'Rp 300.000.000', 'Rp 240.000.000', '80,0%', '<span class="px-2 py-0.5 bg-amber-100 text-amber-800 rounded font-bold text-[10px]">🟡 Warning</span>'],
                        ['Region 1 Solo Raya', 'Rp 800.000.000', 'Rp 768.000.000', '96,0%', '<span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 rounded font-bold text-[10px]">🟢 Good</span>'],
                        ['Region 4 Pati', 'Rp 500.000.000', 'Rp 360.000.000', '72,0%', '<span class="px-2 py-0.5 bg-rose-100 text-rose-800 rounded font-bold text-[10px]">🔴 Critical</span>']
                    ];
                } else if (type === 'sales_active') {
                    this.modalTitle = 'Detail Sales Aktif';
                    this.modalSubtitle = 'Status Kehadiran & Aktivitas Check-in Tim Field Sales Hari Ini';
                    this.modalKpis = [
                        { label: 'Total Salesperson', value: '920 Orang', trend: 1, subtext: 'Tersebar di 5 Region' },
                        { label: 'Aktif Check-in GPS', value: '876 Orang', trend: 1, subtext: '95,2% Aktif' },
                        { label: 'Belum Check-in', value: '44 Orang', trend: -1, subtext: '4,8% Absen / Izin' }
                    ];
                    this.modalColumns = ['Nama Sales', 'Region / Branch', 'Check-in Time', 'Kunjungan', 'Status GPS'];
                    this.modalRows = [
                        ['Eko Prasetyo', 'Region 1 - Solo', '07:45 WIB', '14 Outlet', '<span class="text-emerald-600 font-bold">🟢 Active (Concox GT06N)</span>'],
                        ['Agus Setiawan', 'Region 1 - Boyolali', '08:02 WIB', '12 Outlet', '<span class="text-emerald-600 font-bold">🟢 Active</span>'],
                        ['Budi Santoso', 'Region 2 - Semarang', '08:15 WIB', '10 Outlet', '<span class="text-emerald-600 font-bold">🟢 Active</span>'],
                        ['Rudi Hermawan', 'Region 4 - Pati', 'Belum Check-in', '0 Outlet', '<span class="text-rose-600 font-bold">🔴 No Signal</span>']
                    ];
                } else if (type === 'visit_compliance') {
                    this.modalTitle = 'Detail Visit Compliance (91%)';
                    this.modalSubtitle = 'Kepatuhan Rencana Kunjungan Sales vs Realisasi Field Visit';
                    this.modalKpis = [
                        { label: 'Total Target Visit', value: '8.500 Visit', trend: 1, subtext: 'Planned Call' },
                        { label: 'Realisasi Visit', value: '7.735 Visit', trend: 1, subtext: '91,0% Compliance' },
                        { label: 'Missed Visit', value: '765 Visit', trend: -1, subtext: '9,0% Missed' }
                    ];
                    this.modalColumns = ['Region', 'Target Visit', 'Actual Visit', 'Compliance %', 'Avg Duration'];
                    this.modalRows = [
                        ['Region 1 - Solo', '2.000', '1.880', '94,0%', '18 menit / outlet'],
                        ['Region 2 - Semarang', '1.800', '1.548', '86,0%', '15 menit / outlet'],
                        ['Region 3 - Kedu', '1.700', '1.649', '97,0%', '22 menit / outlet'],
                        ['Region 4 - Pati', '1.500', '1.185', '79,0%', '12 menit / outlet'],
                        ['Region 5 - Banyumas', '1.500', '1.365', '91,0%', '16 menit / outlet']
                    ];
                } else if (type === 'new_outlet' || type === 'active_outlet') {
                    this.modalTitle = type === 'new_outlet' ? 'Detail Outlet Baru (NOO)' : 'Detail Outlet Aktif (7.850 Toko)';
                    this.modalSubtitle = 'Persebaran & Pertumbuhan Akun Outlet Teh Dandang';
                    this.modalKpis = [
                        { label: 'Outlet Aktif', value: '7.850 Toko', trend: 1, subtext: '↑ +4,2% vs bulan lalu' },
                        { label: 'Outlet Baru (NOO)', value: '132 Toko', trend: 1, subtext: 'Target 150 (88%)' },
                        { label: 'Repeat Order Rate', value: '82,4%', trend: 1, subtext: 'Target minimum 80%' }
                    ];
                    this.modalColumns = ['Segmentasi Outlet', 'Jumlah Toko', 'Kontribusi Sales', 'Rata-rata Order', 'Status'];
                    this.modalRows = [
                        ['Toko Kelontong Besar (Gold)', '2.450 Toko', '42%', 'Rp 3.500.000', '<span class="text-emerald-600 font-bold">🟢 High RO</span>'],
                        ['Warung Makan & Horeca', '3.100 Toko', '35%', 'Rp 1.800.000', '<span class="text-emerald-600 font-bold">🟢 Active</span>'],
                        ['Mini Market Independen', '1.200 Toko', '15%', 'Rp 4.200.000', '<span class="text-emerald-600 font-bold">🟢 Active</span>'],
                        ['Toko Grosir & Distributor', '1.100 Toko', '8%', 'Rp 12.000.000', '<span class="text-emerald-600 font-bold">🟢 Active</span>']
                    ];
                } else if (type === 'order') {
                    this.modalTitle = 'Detail Order & Penjualan (4.821 Transaksi)';
                    this.modalSubtitle = 'Volume Pemesanan & Status Sales Order Terkini';
                    this.modalKpis = [
                        { label: 'Total Transaksi Order', value: '4.821 Order', trend: 1, subtext: '↑ +8,2% vs kemarin' },
                        { label: 'Nilai Total Order', value: 'Rp 2,87 Miliar', trend: 1, subtext: 'Avg Rp 595.000 / Order' },
                        { label: 'Fulfilled / Sent', value: '4.520 Order', trend: 1, subtext: '93,7% Fulfillment' }
                    ];
                    this.modalColumns = ['No Sales Order', 'Outlet', 'Salesperson', 'Nilai Order', 'Status'];
                    this.modalRows = [
                        ['SO-20261006-001', 'Toko Berkah Cepogo', 'Eko Prasetyo', 'Rp 2.450.000', '<span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 rounded font-bold text-[10px]">Approved</span>'],
                        ['SO-20261006-002', 'UD Rezeki Subur', 'Agus Setiawan', 'Rp 1.850.000', '<span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 rounded font-bold text-[10px]">Approved</span>'],
                        ['SO-20261006-003', 'Warung Makan Bundo', 'Eko Prasetyo', 'Rp 950.000', '<span class="px-2 py-0.5 bg-blue-100 text-blue-800 rounded font-bold text-[10px]">Delivered</span>']
                    ];
                } else if (type === 'outlet_risk' || type === 'expiry_risk') {
                    this.modalTitle = type === 'outlet_risk' ? 'Detail 127 Outlet At Risk' : 'Detail Product Expiry Risk';
                    this.modalSubtitle = 'Daftar Outlet Berisiko Kehilangan Penjualan & Produk Near Expiry';
                    this.modalKpis = [
                        { label: 'Outlet At Risk', value: '127 Outlet', trend: -1, subtext: 'Memerlukan Intervensi' },
                        { label: 'Near Expiry < 30 Hari', value: '1.280 Case', trend: -1, subtext: 'Perlu Retur / Promo' },
                        { label: 'Expired Product', value: '37 Case', trend: -1, subtext: 'Siap Disetujui Retur' }
                    ];
                    this.modalColumns = ['Nama Outlet', 'Wilayah', 'Kendala / Risiko', 'Nilai Potensi Loss', 'Tindakan Disarankan'];
                    this.modalRows = [
                        ['Toko Sumber Rezeki', 'Region 4 - Pati', 'Tidak dikunjungi >14 hari', 'Rp 8.500.000', '<span class="text-rose-600 font-bold">Jadwalkan Visit Ulang</span>'],
                        ['UD Maju Bersama', 'Region 2 - Semarang', 'Omzet turun >30%', 'Rp 12.000.000', '<span class="text-amber-600 font-bold">Berikan Promo Diskon</span>'],
                        ['Toko Barokah Solo', 'Region 1 - Solo', 'Near Expiry <14 hari (45 case)', 'Rp 4.500.000', '<span class="text-rose-600 font-bold">Tukar Batch Baru</span>']
                    ];
                } else if (type === 'company_asset' || type === 'fleet') {
                    this.modalTitle = type === 'company_asset' ? 'Detail Company Asset (8.420 Unit)' : 'Detail Operational Fleet (185 Vehicle)';
                    this.modalSubtitle = 'Status Monitoring Aset POSM & Kendaraan Operasional (Concox GT06N)';
                    this.modalKpis = [
                        { label: 'Total Fleet Active', value: '185 Unit', trend: 1, subtext: 'Concox GT06N Live' },
                        { label: 'Aset Kondisi Baik', value: '6.930 Unit', trend: 1, subtext: '82% Good Condition' },
                        { label: 'Aset Damaged / Missing', value: '1.290 Unit', trend: -1, subtext: 'Perlu Maintenance' }
                    ];
                    this.modalColumns = ['No Polisi / ID Aset', 'Pengemudi / Sales', 'Tipe Kendaraan', 'Status GPS', 'Status Kondisi'];
                    this.modalRows = [
                        ['AD 8942 CE', 'Eko Prasetyo', 'Motor Box Honda Supra', '🟢 Normal (Inside Route)', '<span class="text-emerald-600 font-bold">Good</span>'],
                        ['AD 1452 BC', 'Agus Setiawan', 'Blind Van Grand Max', '🟢 Normal (Inside Route)', '<span class="text-emerald-600 font-bold">Good</span>'],
                        ['K 7812 DF', 'Rudi Hermawan', 'Truck Canter Box', '🔴 Outside Route (Alert)', '<span class="text-rose-600 font-bold">Suspected Misuse</span>']
                    ];
                } else {
                    this.modalTitle = 'Detail Analytics & Operational Performance';
                    this.modalSubtitle = 'Informasi Rinci Kinerja Operasional Sales Force';
                    this.modalKpis = [
                        { label: 'Target Key Metric', value: '100%', trend: 1, subtext: 'Standard SOP' },
                        { label: 'Actual Score', value: '88,4%', trend: 1, subtext: 'Good Performance' },
                        { label: 'Alert Flag', value: '17 Notice', trend: -1, subtext: 'High Priority' }
                    ];
                    this.modalColumns = ['Indikator', 'Target', 'Realisasi', 'Penyimpangan', 'Rekomendasi'];
                    this.modalRows = [
                        ['Plan Compliance', '95%', '88%', '-7%', 'Evaluasi Rute Sales'],
                        ['EC Rate', '90%', '91,5%', '+1,5%', 'Pertahankan Performance'],
                        ['SKU Penetration', '80%', '75%', '-5%', 'Dorong SKU Teh Celup 25s']
                    ];
                }
            },

            openRegionDetail(regionName) {
                this.modalTitle = 'Detail Performa ' + regionName;
                this.modalSubtitle = 'Rincian Kinerja Sales, Visit, & Distribution di ' + regionName;
                this.modalKpis = [
                    { label: 'Region Target', value: 'Rp 4,50 Miliar', trend: 1, subtext: 'Quarterly Plan' },
                    { label: 'Region Sales', value: 'Rp 4,32 Miliar', trend: 1, subtext: '96,0% Achievement' },
                    { label: 'Overall Quality Score', value: '91 / 100', trend: 1, subtext: 'Top Regional Performance' }
                ];
                this.modalColumns = ['Kabupaten / Area', 'Target Penjualan', 'Realisasi Sales', 'Visit %', 'SKU Penetration'];
                this.modalRows = [
                    ['Kab. Boyolali (Cepogo)', 'Rp 2.200.000.000', 'Rp 2.530.000.000', '98%', '92%'],
                    ['Kota Surakarta (Solo)', 'Rp 1.800.000.000', 'Rp 1.944.000.000', '94%', '88%'],
                    ['Kab. Karanganyar', 'Rp 1.100.000.000', 'Rp 1.177.000.000', '92%', '85%'],
                    ['Kab. Sragen', 'Rp 900.000.000', 'Rp 918.000.000', '90%', '82%']
                ];
                this.activeModal = 'region_detail';
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        // 1. Sales Trend Chart
        const ctxTrend = document.getElementById('mainSalesTrendChart').getContext('2d');
        new Chart(ctxTrend, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt'],
                datasets: [
                    {
                        type: 'bar',
                        label: 'Realisasi (Miliar Rp)',
                        data: [1.5, 1.7, 2.1, 2.0, 2.3, 2.5, 2.6, 2.8, 3.0, 2.87],
                        backgroundColor: '#3b82f6',
                        borderRadius: 6,
                        barThickness: 16
                    },
                    {
                        type: 'line',
                        label: 'Target',
                        data: [1.6, 1.8, 2.0, 2.2, 2.4, 2.6, 2.7, 2.9, 3.0, 3.10],
                        borderColor: '#64748b',
                        borderDash: [4, 4],
                        borderWidth: 2,
                        pointRadius: 3,
                        fill: false
                    },
                    {
                        type: 'line',
                        label: 'Tahun Lalu',
                        data: [1.2, 1.4, 1.6, 1.7, 1.9, 2.0, 2.1, 2.2, 2.4, 2.5],
                        borderColor: '#94a3b8',
                        borderWidth: 1.5,
                        pointRadius: 0,
                        fill: false
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: { ticks: { color: '#94a3b8', font: { size: 9 } }, grid: { display: false } },
                    y: { ticks: { color: '#94a3b8', font: { size: 9 } }, grid: { color: '#f1f5f9' }, min: 0, max: 4 }
                }
            }
        });

        // 2. Sales Quality Index Donut Chart
        const ctxSqi = document.getElementById('sqiDonutChart').getContext('2d');
        new Chart(ctxSqi, {
            type: 'doughnut',
            data: {
                labels: ['Sales Achievement', 'Outlet Growth', 'SKU Penetration', 'Visit Compliance', 'New Outlet', 'SOP Compliance'],
                datasets: [{
                    data: [30, 20, 15, 15, 10, 10],
                    backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#6366f1', '#14b8a6', '#a855f7'],
                    borderWidth: 0,
                    cutout: '75%'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } }
            }
        });

        // 3. Outlet Health Donut Chart
        const ctxHealth = document.getElementById('outletHealthChart').getContext('2d');
        new Chart(ctxHealth, {
            type: 'doughnut',
            data: {
                labels: ['Healthy', 'At Risk', 'Critical'],
                datasets: [{
                    data: [5760, 1520, 720],
                    backgroundColor: ['#10b981', '#f59e0b', '#ef4444'],
                    borderWidth: 0,
                    cutout: '75%'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } }
            }
        });
    });
</script>
@endpush
