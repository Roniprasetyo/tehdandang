@extends('layouts.app')

@section('title', 'Master Armada & GPS')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-xl border border-slate-200/90 shadow-xs">
        <div>
            <h1 class="text-xl font-semibold text-slate-900">Master Armada & GPS Concox GT06N</h1>
            <p class="text-xs text-slate-500 mt-1">Daftar armada operasional, sales person assigned, status telemetri GPS, dan daya baterai</p>
        </div>
        <a href="{{ route('transaksi.checkin-gps') }}" class="btn-primary">
            <i class="mdi mdi-map-marker-radius text-base"></i>
            <span>Peta Monitoring GPS Langsung</span>
        </a>
    </div>

    <!-- Vehicles Table Container -->
    <div class="bg-white border border-slate-200/90 rounded-xl p-5 shadow-xs">
        <div class="overflow-x-auto rounded-lg border border-slate-200">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-600 uppercase text-[11px] font-semibold tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-3.5">Plat Nomor</th>
                        <th class="py-3 px-3.5">Tipe Kendaraan</th>
                        <th class="py-3 px-3.5">Sales Person</th>
                        <th class="py-3 px-3.5">Area Operasional</th>
                        <th class="py-3 px-3.5">Perangkat GPS</th>
                        <th class="py-3 px-3.5">Kecepatan</th>
                        <th class="py-3 px-3.5">Baterai</th>
                        <th class="py-3 px-3.5 text-center">Status Ping</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($vehicles as $v)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="py-3 px-3.5 font-mono tabular-nums font-medium text-slate-900">{{ $v['plate_no'] }}</td>
                        <td class="py-3 px-3.5 text-slate-600">{{ $v['type'] }}</td>
                        <td class="py-3 px-3.5 font-medium text-primary">{{ $v['assigned_sales'] }}</td>
                        <td class="py-3 px-3.5 text-slate-600">{{ $v['area'] }}</td>
                        <td class="py-3 px-3.5 font-mono tabular-nums text-primary font-medium">{{ $v['gps_device_id'] }} (Concox GT06N)</td>
                        <td class="py-3 px-3.5 font-mono tabular-nums text-slate-800">{{ $v['speed_kmh'] }} km/h</td>
                        <td class="py-3 px-3.5 font-mono tabular-nums text-secondary font-medium">{{ $v['battery'] }}%</td>
                        <td class="py-3 px-3.5 text-center">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium border {{ $v['gps_status'] === 'Online' ? 'bg-primary-50 text-primary-700 border-primary-200' : 'bg-rose-50 text-rose-700 border-rose-200' }}">
                                <i class="mdi {{ $v['gps_status'] === 'Online' ? 'mdi-check-circle-outline' : 'mdi-alert-circle-outline' }} mr-1"></i>
                                <span>{{ $v['gps_status'] }} ({{ $v['last_ping'] }})</span>
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
