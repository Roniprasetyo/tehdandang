@extends('layouts.app')

@section('title', 'Master Rute & Kepatuhan GPS')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-xl border border-slate-200/90 shadow-xs">
        <div>
            @include('partials.breadcrumb')
            <h1 class="text-xl font-semibold text-slate-900">Master Rute & Kepatuhan GPS</h1>
            <p class="text-xs text-slate-500 mt-1">Perbandingan waypoint target rencana kunjungan vs rute aktual dari GPS Concox GT06N</p>
        </div>
    </div>

    <!-- Route Cards -->
    <div class="space-y-4">
        @foreach($routes as $r)
        <div class="bg-white border border-slate-200/90 rounded-xl p-5 shadow-xs space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-100 pb-3">
                <div class="flex items-center gap-3">
                    <span class="px-2.5 py-1 rounded bg-primary-50 text-primary-700 font-mono tabular-nums font-medium text-xs border border-primary-200">
                        {{ $r['route_code'] }}
                    </span>
                    <div>
                        <h3 class="text-sm font-semibold text-slate-900">{{ $r['sales_name'] }} (NPK: {{ $r['sales_npk'] }})</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Hari: {{ $r['day'] }} &bull; Area: {{ $r['area'] }} (Kecamatan {{ $r['kecamatan'] }})</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="text-right text-xs">
                        <span class="text-slate-500 block font-medium">Kepatuhan Rute</span>
                        <span class="font-semibold text-primary text-sm font-mono tabular-nums">{{ $r['compliance_rate'] }}%</span>
                    </div>
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium border {{ $r['status'] === 'Valid' ? 'bg-primary-50 text-primary-700 border-primary-200' : 'bg-rose-50 text-rose-700 border-rose-200' }}">
                        <i class="mdi {{ $r['status'] === 'Valid' ? 'mdi-check-circle-outline' : 'mdi-alert-circle-outline' }} mr-1"></i>
                        <span>{{ $r['status'] }}</span>
                    </span>
                </div>
            </div>

            <!-- Planned Waypoints vs Actual GPS Route -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                
                <!-- Planned Waypoints -->
                <div class="bg-slate-50 p-4 rounded-xl border border-slate-200/60 space-y-2">
                    <span class="text-xs font-bold text-slate-700 uppercase tracking-wider block">Target Waypoints Rencana:</span>
                    <div class="space-y-1.5 text-xs">
                        @foreach($r['planned_waypoints'] as $wp)
                        <div class="p-2.5 bg-white rounded-lg flex items-center justify-between border border-slate-200/80 shadow-xs">
                            <div>
                                <span class="font-bold text-slate-900">#{{ $wp['order'] }} {{ $wp['name'] }}</span>
                                <span class="text-[10px] text-slate-400 block font-mono tabular-nums">Kode: {{ $wp['card_code'] }}</span>
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
                    <span class="text-xs font-bold text-primary uppercase tracking-wider block flex items-center gap-1.5">
                        <i class="mdi mdi-access-point text-base"></i> Ping Aktual Concox GT06N:
                    </span>
                    <div class="space-y-1.5 text-xs font-mono tabular-nums">
                        @foreach($r['actual_gps_route'] as $ping)
                        <div class="p-2.5 bg-white rounded-lg flex items-center justify-between text-slate-700 border border-slate-200/80 shadow-xs">
                            <span>Jam {{ $ping['timestamp'] }}</span>
                            <span class="text-primary font-bold">Lat: {{ $ping['lat'] }}, Lng: {{ $ping['lng'] }}</span>
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
