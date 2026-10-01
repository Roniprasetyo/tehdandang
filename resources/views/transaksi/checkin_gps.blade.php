@extends('layouts.app')

@section('title', 'GPS Live Map & Tracksolid Dashboard')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
        <div>
            <h1 class="text-xl font-bold font-display text-slate-900 flex items-center gap-2">
                <i data-lucide="radio" class="w-5 h-5 text-indigo-600"></i> Live Map Concox GT06N & Tracksolid Dashboard
            </h1>
            <p class="text-xs text-slate-500 mt-0.5">Monitoring posisi armada salesman, rute compliance, & alarm deviasi real-time</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="px-3 py-1.5 rounded-full bg-indigo-50 border border-indigo-200 text-indigo-700 text-xs font-mono font-bold flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-indigo-500 animate-ping"></span>
                <span>Concox GT06N Webhook: Active</span>
            </span>
        </div>
    </div>

    <!-- 5 Fleet KPI Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
        <div class="bg-white border border-slate-200/80 rounded-2xl p-4 shadow-xs">
            <span class="text-[10px] font-bold uppercase text-slate-400 block">TOTAL VEHICLES</span>
            <span class="text-2xl font-bold text-slate-900 mt-1 block">{{ number_format($gps['total_vehicles'], 0, ',', '.') }} Armada</span>
            <span class="text-[10px] text-slate-500 font-semibold">Motor & Box Van</span>
        </div>

        <div class="bg-white border border-slate-200/80 rounded-2xl p-4 shadow-xs">
            <span class="text-[10px] font-bold uppercase text-slate-400 block">ACTIVE GPS</span>
            <span class="text-2xl font-bold text-emerald-600 mt-1 block">{{ number_format($gps['active_gps'], 0, ',', '.') }} Online</span>
            <span class="text-[10px] text-emerald-600 font-semibold">Normal Signal</span>
        </div>

        <div class="bg-white border border-slate-200/80 rounded-2xl p-4 shadow-xs">
            <span class="text-[10px] font-bold uppercase text-slate-400 block">OFFLINE GPS</span>
            <span class="text-2xl font-bold text-rose-600 mt-1 block">{{ number_format($gps['offline_gps'], 0, ',', '.') }} Devices</span>
            <span class="text-[10px] text-rose-600 font-semibold">Signal Lost / Low Bat</span>
        </div>

        <div class="bg-white border border-slate-200/80 rounded-2xl p-4 shadow-xs">
            <span class="text-[10px] font-bold uppercase text-slate-400 block">SALES ON ROUTE</span>
            <span class="text-2xl font-bold text-indigo-600 mt-1 block">{{ number_format($gps['sales_on_route'], 0, ',', '.') }} Sales</span>
            <span class="text-[10px] text-indigo-600 font-semibold">Following Waypoints</span>
        </div>

        <div class="bg-white border border-slate-200/80 rounded-2xl p-4 shadow-xs">
            <span class="text-[10px] font-bold uppercase text-slate-400 block">ROUTE COMPLIANCE</span>
            <span class="text-2xl font-bold text-purple-600 mt-1 block">{{ $gps['route_compliance'] }}%</span>
            <span class="text-[10px] text-slate-500 font-semibold">Kepatuhan Rute</span>
        </div>
    </div>

    <!-- Map Container -->
    <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs space-y-4">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                <i data-lucide="map" class="w-4 h-4 text-emerald-600"></i> Tracksolid GPS Live Map Radar (Concox GT06N Protocol)
            </h3>
            <div class="flex items-center gap-4 text-xs">
                <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span> Sales A (On Route)</span>
                <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-indigo-600"></span> Sales B (Top Cepogo)</span>
                <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-rose-500 animate-ping"></span> Sales C (Deviation Alarm)</span>
            </div>
        </div>

        <!-- Simulated Map Canvas -->
        <div class="w-full h-80 bg-slate-50 rounded-2xl border border-slate-200 relative overflow-hidden flex items-center justify-center">
            <div class="absolute inset-0 bg-[radial-gradient(#cbd5e1_1px,transparent_1px)] [background-size:24px_24px] opacity-60"></div>
            
            <svg class="absolute inset-0 w-full h-full pointer-events-none">
                <path d="M 120 180 Q 250 80 450 200 T 750 140" stroke="#4f46e5" stroke-width="3" stroke-dasharray="6,6" fill="none" />
                <path d="M 150 220 Q 350 300 600 240" stroke="#e11d48" stroke-width="3" fill="none" />
            </svg>

            <!-- Map Markers -->
            <div class="absolute top-1/4 left-1/4 flex flex-col items-center group cursor-pointer">
                <div class="px-2 py-0.5 rounded bg-white text-emerald-700 text-[10px] font-bold border border-emerald-200 shadow-sm">🟢 Eko Prasetyo (Top Sales Cepogo)</div>
                <div class="w-4 h-4 rounded-full bg-emerald-500 ring-4 ring-emerald-500/20 animate-pulse mt-1"></div>
            </div>

            <div class="absolute bottom-1/3 left-1/2 flex flex-col items-center group cursor-pointer">
                <div class="px-2 py-0.5 rounded bg-white text-rose-700 text-[10px] font-bold border border-rose-200 shadow-sm">🔴 Budi (S002) - Deviasi 3.2km</div>
                <div class="w-4 h-4 rounded-full bg-rose-500 ring-4 ring-rose-500/20 animate-ping mt-1"></div>
            </div>

            <div class="absolute top-1/3 right-1/4 flex flex-col items-center group cursor-pointer">
                <div class="px-2 py-0.5 rounded bg-white text-indigo-700 text-[10px] font-bold border border-indigo-200 shadow-sm">🔵 Andi (S001)</div>
                <div class="w-4 h-4 rounded-full bg-indigo-600 ring-4 ring-indigo-600/20 mt-1"></div>
            </div>

            <div class="absolute bottom-4 right-4 bg-white/90 backdrop-blur border border-slate-200 p-3 rounded-xl text-[11px] space-y-1 shadow-xs">
                <div class="font-bold text-slate-900">Concox GT06N Live Status</div>
                <div class="text-slate-500">Koordinat: -7.5342, 110.5345 (Boyolali)</div>
                <div class="text-emerald-600 font-bold">ACC Ignition: ON (35 km/h)</div>
            </div>
        </div>
    </div>

    <!-- Vehicles Live Status Table -->
    <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs">
        <h3 class="text-sm font-bold text-slate-900 mb-4">Detail Status Fleet & Concox GT06N Tracksolid</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-4">PLATE NO</th>
                        <th class="py-3 px-4">SALES PERSON</th>
                        <th class="py-3 px-4">AREA</th>
                        <th class="py-3 px-4">SPEED</th>
                        <th class="py-3 px-4">BATTERY</th>
                        <th class="py-3 px-4">LAST LOCATION</th>
                        <th class="py-3 px-4">COMPLIANCE</th>
                        <th class="py-3 px-4 text-center">STATUS TRACKSOLID</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($gps['vehicles'] as $v)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="py-3 px-4 font-mono font-bold text-slate-900">{{ $v['plate_no'] }}</td>
                        <td class="py-3 px-4 font-bold text-indigo-600">{{ $v['sales_name'] }}</td>
                        <td class="py-3 px-4 text-slate-600">{{ $v['area'] }}</td>
                        <td class="py-3 px-4 font-mono text-slate-800 font-semibold">{{ $v['speed'] }}</td>
                        <td class="py-3 px-4 font-mono text-amber-600 font-bold">{{ $v['battery'] }}</td>
                        <td class="py-3 px-4 text-slate-600">{{ $v['last_location'] }}</td>
                        <td class="py-3 px-4 font-bold text-purple-600">{{ $v['compliance'] }}</td>
                        <td class="py-3 px-4 text-center">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $v['status'] === 'On Route' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-rose-50 text-rose-700 border-rose-200' }}">
                                {{ $v['status_color'] }} {{ $v['status'] }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
