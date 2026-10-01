@extends('layouts.app')

@section('title', 'Master Vehicle & GPS')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
        <div>
            <h1 class="text-xl font-bold font-display text-slate-900">Master Vehicle & Concox GT06N GPS Devices</h1>
            <p class="text-xs text-slate-500 mt-0.5">Daftar armada operasional, Sales assigned, status GPS, dan baterai Concox GT06N</p>
        </div>
        <a href="{{ route('transaksi.checkin-gps') }}" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-md shadow-indigo-200 flex items-center gap-2">
            <i data-lucide="map" class="w-4 h-4"></i> Live GPS Monitoring Map
        </a>
    </div>

    <!-- Vehicles Table Container -->
    <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-4">PLATE NO</th>
                        <th class="py-3 px-4">VEHICLE TYPE</th>
                        <th class="py-3 px-4">SALES ASSIGNED</th>
                        <th class="py-3 px-4">AREA</th>
                        <th class="py-3 px-4">GPS DEVICE MODEL</th>
                        <th class="py-3 px-4">CURRENT SPEED</th>
                        <th class="py-3 px-4">DEVICE BATTERY</th>
                        <th class="py-3 px-4 text-center">PING STATUS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($vehicles as $v)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="py-3 px-4 font-mono font-bold text-slate-900">{{ $v['plate_no'] }}</td>
                        <td class="py-3 px-4 text-slate-600 font-medium">{{ $v['type'] }}</td>
                        <td class="py-3 px-4 font-bold text-indigo-600">{{ $v['assigned_sales'] }}</td>
                        <td class="py-3 px-4 text-slate-600">{{ $v['area'] }}</td>
                        <td class="py-3 px-4 font-mono text-indigo-600 font-semibold">{{ $v['gps_device_id'] }} (Concox GT06N)</td>
                        <td class="py-3 px-4 font-mono text-slate-800 font-semibold">{{ $v['speed_kmh'] }} km/h</td>
                        <td class="py-3 px-4 font-mono text-amber-600 font-bold">{{ $v['battery'] }}%</td>
                        <td class="py-3 px-4 text-center">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $v['gps_status'] === 'Online' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-rose-50 text-rose-700 border-rose-200' }}">
                                {{ $v['gps_status'] }} ({{ $v['last_ping'] }})
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
