@extends('layouts.app')

@section('title', 'Master Route & Compliance')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
        <div>
            <h1 class="text-xl font-bold font-display text-slate-900">Master Route (Planned vs Actual GPS Route)</h1>
            <p class="text-xs text-slate-500 mt-0.5">Rute harian salesman, waypoint target outlet vs rute aktual dari GPS Concox GT06N</p>
        </div>
    </div>

    <!-- Route Cards -->
    <div class="space-y-4">
        @foreach($routes as $r)
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-100 pb-3">
                <div class="flex items-center gap-3">
                    <span class="px-2.5 py-1 rounded-lg bg-indigo-50 text-indigo-700 font-mono font-bold text-xs border border-indigo-200">
                        {{ $r['route_code'] }}
                    </span>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900">{{ $r['sales_name'] }} (NPK: {{ $r['sales_npk'] }})</h3>
                        <p class="text-xs text-slate-500">Hari: {{ $r['day'] }} | Area: {{ $r['area'] }} (Kecamatan {{ $r['kecamatan'] }})</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="text-right text-xs">
                        <span class="text-slate-500 block font-medium">Route Compliance:</span>
                        <span class="font-bold text-indigo-600 text-sm">{{ $r['compliance_rate'] }}%</span>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $r['status'] === 'Valid' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-rose-50 text-rose-700 border-rose-200' }}">
                        {{ $r['status'] }}
                    </span>
                </div>
            </div>

            <!-- Planned Waypoints vs Actual GPS Route -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                
                <!-- Planned Waypoints -->
                <div class="bg-slate-50 p-4 rounded-xl border border-slate-200/60 space-y-2">
                    <span class="text-xs font-bold text-slate-700 uppercase tracking-wider block">Target Planned Waypoints:</span>
                    <div class="space-y-1.5 text-xs">
                        @foreach($r['planned_waypoints'] as $wp)
                        <div class="p-2.5 bg-white rounded-lg flex items-center justify-between border border-slate-200/80 shadow-xs">
                            <div>
                                <span class="font-bold text-slate-900">#{{ $wp['order'] }} {{ $wp['name'] }}</span>
                                <span class="text-[10px] text-slate-400 block">Code: {{ $wp['card_code'] }}</span>
                            </div>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $wp['status'] === 'Visited' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-rose-50 text-rose-700 border border-rose-200' }}">
                                {{ $wp['status'] }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Actual GPS Concox GT06N Log -->
                <div class="bg-slate-50 p-4 rounded-xl border border-slate-200/60 space-y-2">
                    <span class="text-xs font-bold text-indigo-700 uppercase tracking-wider block flex items-center gap-1.5">
                        <i data-lucide="radio" class="w-3.5 h-3.5"></i> Actual Concox GT06N Ping:
                    </span>
                    <div class="space-y-1.5 text-xs">
                        @foreach($r['actual_gps_route'] as $ping)
                        <div class="p-2.5 bg-white rounded-lg flex items-center justify-between font-mono text-slate-700 border border-slate-200/80 shadow-xs">
                            <span>Jam {{ $ping['timestamp'] }}</span>
                            <span class="text-indigo-600 font-bold">Lat: {{ $ping['lat'] }}, Lng: {{ $ping['lng'] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
        @endforeach
    </div>

</div>
@endsection
