@extends('layouts.app')

@section('title', 'Live Map Concox GT06N & Tracksolid Dashboard')

@push('styles')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<style>
    .leaflet-popup-content-wrapper {
        border-radius: 1rem;
        padding: 4px;
        box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
    }
    .leaflet-container {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .gps-marker-container {
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }
    .gps-marker-pulse {
        position: absolute;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        animation: pulse-ring 2s cubic-bezier(0.215, 0.61, 0.355, 1) infinite;
    }
    .gps-marker-pulse.moving { background-color: rgba(16, 185, 129, 0.35); }
    .gps-marker-pulse.idle { background-color: rgba(245, 158, 11, 0.35); }
    .gps-marker-pulse.parked { background-color: rgba(59, 130, 246, 0.35); }
    .gps-marker-pulse.offline { background-color: rgba(100, 116, 139, 0.25); }

    @keyframes pulse-ring {
        0% { transform: scale(0.6); opacity: 0.8; }
        100% { transform: scale(1.6); opacity: 0; }
    }
</style>
@endpush

@section('content')
<div class="space-y-6" x-data="liveTrackingApp()">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
        <div>
            <!-- Breadcrumbs -->
            <div class="flex items-center space-x-2 text-xs text-slate-400 mb-1 font-medium">
                <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 transition-colors">Beranda</a>
                <span>/</span>
                <span>Tracking</span>
                <span>/</span>
                <span class="text-indigo-600 font-semibold">Live Tracking</span>
            </div>
            <h1 class="text-xl font-bold font-display text-slate-900 flex items-center gap-2">
                <i data-lucide="radio" class="w-5 h-5 text-indigo-600"></i> Live Map Concox GT06N & Tracksolid Dashboard
            </h1>
            <p class="text-xs text-slate-500 mt-0.5">Monitoring posisi armada salesman, rute compliance, & alarm deviasi real-time</p>
        </div>

        <div class="flex flex-wrap items-center gap-2.5">
            <span class="px-3 py-1.5 rounded-full bg-indigo-50 border border-indigo-200 text-indigo-700 text-xs font-mono font-bold flex items-center gap-1.5 shadow-xs">
                <span class="w-2.5 h-2.5 rounded-full bg-indigo-500 animate-ping"></span>
                <span>Concox GT06N Webhook: Active</span>
            </span>
            <button 
                @click="openHistoryModal = true"
                class="px-3 py-1.5 rounded-xl bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 text-xs font-semibold shadow-xs flex items-center gap-1.5 transition-all hover:border-indigo-300">
                <i data-lucide="history" class="w-3.5 h-3.5 text-indigo-600"></i>
                <span>Riwayat Rute</span>
            </button>
            <button 
                @click="openDeviceModal = true"
                class="px-3 py-1.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-md shadow-indigo-200 flex items-center gap-1.5 transition-all">
                <i data-lucide="cpu" class="w-3.5 h-3.5"></i>
                <span>Manajemen Device</span>
            </button>
        </div>
    </div>

    <!-- 5 Fleet KPI Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
        <div class="bg-white border border-slate-200/80 rounded-2xl p-4 shadow-xs">
            <span class="text-[10px] font-bold uppercase text-slate-400 block">TOTAL VEHICLES</span>
            <span class="text-2xl font-bold text-slate-900 mt-1 block">{{ number_format($gps['total_vehicles'] ?? 48, 0, ',', '.') }} Armada</span>
            <span class="text-[10px] text-slate-500 font-semibold">Motor & Box Van</span>
        </div>

        <div class="bg-white border border-slate-200/80 rounded-2xl p-4 shadow-xs">
            <span class="text-[10px] font-bold uppercase text-slate-400 block">ACTIVE GPS</span>
            <span class="text-2xl font-bold text-emerald-600 mt-1 block">{{ number_format($gps['active_gps'] ?? 42, 0, ',', '.') }} Online</span>
            <span class="text-[10px] text-emerald-600 font-semibold">Normal Signal</span>
        </div>

        <div class="bg-white border border-slate-200/80 rounded-2xl p-4 shadow-xs">
            <span class="text-[10px] font-bold uppercase text-slate-400 block">OFFLINE GPS</span>
            <span class="text-2xl font-bold text-rose-600 mt-1 block">{{ number_format($gps['offline_gps'] ?? 6, 0, ',', '.') }} Devices</span>
            <span class="text-[10px] text-rose-600 font-semibold">Signal Lost / Low Bat</span>
        </div>

        <div class="bg-white border border-slate-200/80 rounded-2xl p-4 shadow-xs">
            <span class="text-[10px] font-bold uppercase text-slate-400 block">SALES ON ROUTE</span>
            <span class="text-2xl font-bold text-indigo-600 mt-1 block">{{ number_format($gps['sales_on_route'] ?? 38, 0, ',', '.') }} Sales</span>
            <span class="text-[10px] text-indigo-600 font-semibold">Following Waypoints</span>
        </div>

        <div class="bg-white border border-slate-200/80 rounded-2xl p-4 shadow-xs">
            <span class="text-[10px] font-bold uppercase text-slate-400 block">ROUTE COMPLIANCE</span>
            <span class="text-2xl font-bold text-purple-600 mt-1 block">{{ $gps['route_compliance'] ?? 90.5 }}%</span>
            <span class="text-[10px] text-slate-500 font-semibold">Kepatuhan Rute</span>
        </div>
    </div>

    <!-- Main Split Section: Left Leaflet Map & Right Panel "Armada Kendaraan" -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 h-[620px]">

        <!-- MAP CONTAINER (Left 8 Cols) -->
        <div class="lg:col-span-8 bg-white border border-slate-200/80 rounded-2xl overflow-hidden shadow-xs relative flex flex-col">
            
            <!-- Map Toolbar Top Overlay -->
            <div class="absolute top-3 left-3 right-3 z-[400] flex items-center justify-between pointer-events-none">
                <div class="bg-white/95 backdrop-blur border border-slate-200/80 shadow-md rounded-xl px-3 py-1.5 flex items-center space-x-3 text-xs pointer-events-auto">
                    <span class="font-bold text-slate-800 flex items-center gap-1.5">
                        <i data-lucide="layers" class="w-3.5 h-3.5 text-indigo-600"></i> Tracksolid Live Radar
                    </span>
                    <span class="text-slate-300">|</span>
                    <button @click="fitAllMarkers()" class="text-indigo-600 hover:underline font-semibold flex items-center gap-1">
                        <i data-lucide="maximize-2" class="w-3 h-3"></i> Zoom Semua
                    </button>
                    <button @click="togglePolylines()" class="text-slate-600 hover:text-indigo-600 font-semibold flex items-center gap-1">
                        <i data-lucide="route" class="w-3 h-3"></i> <span x-text="showRoutes ? 'Sembunyikan Rute' : 'Tampilkan Rute'"></span>
                    </button>
                </div>

                <div class="bg-slate-900/80 text-white backdrop-blur shadow-md rounded-xl px-3 py-1.5 text-[11px] font-mono font-medium pointer-events-auto hidden sm:block">
                    📡 Concox GT06N Protocol v2.4
                </div>
            </div>

            <!-- Leaflet Container -->
            <div id="liveGpsMap" class="w-full h-full flex-1 z-10 bg-slate-100"></div>

            <!-- Bottom Floating Telemetry Overlay -->
            <div class="absolute bottom-4 left-4 z-[400] bg-white/95 backdrop-blur border border-slate-200 shadow-lg p-3 rounded-xl max-w-xs sm:max-w-sm text-xs space-y-1.5 pointer-events-auto" x-show="selectedVehicle">
                <div class="flex items-center justify-between border-b border-slate-100 pb-1.5">
                    <div class="font-bold text-slate-900 flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-full" :class="getDotColor(selectedVehicle?.status_code)"></span>
                        <span x-text="selectedVehicle?.plate_no"></span>
                    </div>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full" :class="getBadgeClass(selectedVehicle?.status_code)" x-text="selectedVehicle?.status"></span>
                </div>
                <div class="text-slate-600 text-[11px] leading-tight" x-text="selectedVehicle?.brand_type"></div>
                <div class="text-indigo-600 text-[11px] font-semibold" x-text="selectedVehicle?.driver_sales"></div>
                <div class="grid grid-cols-3 gap-1 pt-1 text-[10px] font-mono text-slate-700 bg-slate-50 p-1.5 rounded-lg border border-slate-100">
                    <div>
                        <span class="text-slate-400 block text-[9px]">KECEPATAN</span>
                        <strong class="text-slate-900" x-text="selectedVehicle?.speed"></strong>
                    </div>
                    <div>
                        <span class="text-slate-400 block text-[9px]">TEGANGAN</span>
                        <strong class="text-amber-600" x-text="selectedVehicle?.battery_v"></strong>
                    </div>
                    <div>
                        <span class="text-slate-400 block text-[9px]">SATELIT</span>
                        <strong class="text-emerald-600" x-text="selectedVehicle?.satellites + ' Sats'"></strong>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT SIDEBAR PANEL ("Armada Kendaraan") (Right 4 Cols) -->
        <div class="lg:col-span-4 bg-white border border-slate-200/80 rounded-2xl flex flex-col shadow-xs overflow-hidden h-full">
            
            <!-- Panel Header -->
            <div class="p-4 border-b border-slate-100 space-y-3">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-base font-bold text-slate-900">Armada Kendaraan</h2>
                        <p class="text-xs text-slate-500 font-medium">
                            <span x-text="vehicles.length">7</span> Perangkat GPS Terhubung
                        </p>
                    </div>
                    <button 
                        @click="refreshData()"
                        class="p-2 rounded-xl text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 transition-all border border-slate-200"
                        title="Refresh Data">
                        <i data-lucide="refresh-cw" class="w-4 h-4" :class="isRefreshing ? 'animate-spin text-indigo-600' : ''"></i>
                    </button>
                </div>

                <!-- Filter Tabs (Semua, Bergerak, Idle, Parkir, Offline) -->
                <div class="flex items-center gap-1 overflow-x-auto pb-1 scrollbar-none text-[11px] font-semibold">
                    <button 
                        @click="filterStatus = 'all'"
                        class="px-2.5 py-1 rounded-lg transition-all flex-shrink-0"
                        :class="filterStatus === 'all' ? 'bg-slate-900 text-white font-bold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'">
                        Semua (<span x-text="vehicles.length">7</span>)
                    </button>
                    <button 
                        @click="filterStatus = 'moving'"
                        class="px-2.5 py-1 rounded-lg transition-all flex-shrink-0"
                        :class="filterStatus === 'moving' ? 'bg-emerald-600 text-white font-bold' : 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100'">
                        Bergerak (<span x-text="countStatus('moving')">2</span>)
                    </button>
                    <button 
                        @click="filterStatus = 'idle'"
                        class="px-2.5 py-1 rounded-lg transition-all flex-shrink-0"
                        :class="filterStatus === 'idle' ? 'bg-amber-500 text-white font-bold' : 'bg-amber-50 text-amber-700 hover:bg-amber-100'">
                        Idle (<span x-text="countStatus('idle')">1</span>)
                    </button>
                    <button 
                        @click="filterStatus = 'parked'"
                        class="px-2.5 py-1 rounded-lg transition-all flex-shrink-0"
                        :class="filterStatus === 'parked' ? 'bg-blue-600 text-white font-bold' : 'bg-blue-50 text-blue-700 hover:bg-blue-100'">
                        Parkir (<span x-text="countStatus('parked')">1</span>)
                    </button>
                    <button 
                        @click="filterStatus = 'offline'"
                        class="px-2.5 py-1 rounded-lg transition-all flex-shrink-0"
                        :class="filterStatus === 'offline' ? 'bg-slate-600 text-white font-bold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'">
                        Offline (<span x-text="countStatus('offline')">3</span>)
                    </button>
                </div>

                <!-- Search Input -->
                <div class="relative">
                    <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                    <input 
                        type="text" 
                        x-model="searchQuery"
                        placeholder="Cari plat, merek, peminjam..." 
                        class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                </div>
            </div>

            <!-- Scrollable Vehicle Card List -->
            <div class="flex-1 overflow-y-auto p-3 space-y-2.5">
                <template x-for="v in filteredVehicles" :key="v.vehicle_id">
                    <div 
                        @click="selectVehicle(v)"
                        class="p-3.5 rounded-xl border transition-all cursor-pointer relative"
                        :class="selectedVehicle?.vehicle_id === v.vehicle_id 
                            ? 'bg-indigo-50/70 border-indigo-500 ring-2 ring-indigo-500/20 shadow-xs' 
                            : 'bg-white border-slate-200/80 hover:border-slate-300 hover:bg-slate-50/50'">
                        
                        <!-- Top Row: Plate Number & Status Badge -->
                        <div class="flex items-center justify-between mb-1">
                            <span class="font-mono font-extrabold text-sm text-slate-900 tracking-tight" x-text="v.plate_no"></span>
                            <span class="px-2.5 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wider border" :class="getBadgeClass(v.status_code)" x-text="v.status"></span>
                        </div>

                        <!-- Vehicle Brand / Type -->
                        <div class="text-xs font-semibold text-slate-600 tracking-tight" x-text="v.brand_type"></div>
                        
                        <!-- Driver / Sales Person -->
                        <div class="text-[11px] text-indigo-600 font-medium truncate mt-0.5" x-text="v.driver_sales"></div>

                        <!-- Telemetry Stats Row -->
                        <div class="flex items-center justify-between mt-3 pt-2 border-t border-slate-100 text-[11px]">
                            <div class="flex items-center space-x-3 text-slate-500 font-mono">
                                <span class="flex items-center gap-1 font-semibold text-amber-600">
                                    <i data-lucide="zap" class="w-3 h-3 text-amber-500"></i>
                                    <span x-text="v.battery_v"></span>
                                </span>
                                <span class="flex items-center gap-1 font-semibold text-emerald-600">
                                    <i data-lucide="radio" class="w-3 h-3 text-emerald-500"></i>
                                    <span x-text="v.satellites + ' Sats'"></span>
                                </span>
                                <template x-if="v.speed !== '0 km/h'">
                                    <span class="flex items-center gap-1 font-semibold text-indigo-600">
                                        <i data-lucide="gauge" class="w-3 h-3 text-indigo-500"></i>
                                        <span x-text="v.speed"></span>
                                    </span>
                                </template>
                            </div>

                            <div class="text-[10px] text-slate-400 font-semibold font-mono" x-text="v.last_time"></div>
                        </div>

                    </div>
                </template>

                <!-- Empty Search State -->
                <div x-show="filteredVehicles.length === 0" class="py-12 text-center text-slate-400 text-xs">
                    <i data-lucide="search-x" class="w-8 h-8 mx-auto mb-2 text-slate-300"></i>
                    <p class="font-semibold">Armada tidak ditemukan</p>
                    <p class="text-[11px]">Coba ubah filter atau kata kunci pencarian</p>
                </div>
            </div>

            <!-- Panel Footer Status Summary -->
            <div class="p-3 bg-slate-50 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500 font-medium">
                <span>Total: <strong class="text-slate-800" x-text="vehicles.length">7</strong> armada</span>
                <span class="text-emerald-600 font-bold flex items-center gap-1">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span> 5 Online
                </span>
            </div>

        </div>

    </div>

    <!-- Vehicles Live Status Table -->
    <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs">
        <h3 class="text-sm font-bold text-slate-900 mb-4 flex items-center gap-2">
            <i data-lucide="list" class="w-4 h-4 text-indigo-600"></i> Detail Status Fleet & Concox GT06N Tracksolid
        </h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-4">PLATE NO</th>
                        <th class="py-3 px-4">SALES PERSON / DRIVER</th>
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
                        <td class="py-3 px-4 font-bold text-indigo-600">{{ $v['driver_sales'] ?? $v['sales_name'] }}</td>
                        <td class="py-3 px-4 text-slate-600">{{ $v['area'] }}</td>
                        <td class="py-3 px-4 font-mono text-slate-800 font-semibold">{{ $v['speed'] }}</td>
                        <td class="py-3 px-4 font-mono text-amber-600 font-bold">{{ $v['battery_v'] ?? $v['battery'] }}</td>
                        <td class="py-3 px-4 text-slate-600">{{ $v['last_location'] }}</td>
                        <td class="py-3 px-4 font-bold text-purple-600">{{ $v['compliance'] }}</td>
                        <td class="py-3 px-4 text-center">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold border {{ strtolower($v['status']) === 'bergerak' || strtolower($v['status']) === 'on route' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : (strtolower($v['status']) === 'idle' ? 'bg-amber-50 text-amber-700 border-amber-200' : 'bg-rose-50 text-rose-700 border-rose-200') }}">
                                {{ $v['status_color'] ?? '🟢' }} {{ $v['status'] }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL 1: RIWAYAT RUTE (ROUTE PLAYBACK) -->
    <div x-show="openHistoryModal" x-cloak class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs z-[500] flex items-center justify-center p-4">
        <div @click.outside="openHistoryModal = false" class="bg-white rounded-2xl border border-slate-200 shadow-2xl max-w-xl w-full p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div class="flex items-center gap-2">
                    <i data-lucide="history" class="w-5 h-5 text-indigo-600"></i>
                    <h3 class="text-base font-bold text-slate-900">Riwayat Rute Perjalanan (Route Playback)</h3>
                </div>
                <button @click="openHistoryModal = false" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <div class="space-y-3 text-xs">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Pilih Armada Kendaraan:</label>
                    <select class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl font-semibold text-slate-800">
                        <template x-for="v in vehicles" :key="v.vehicle_id">
                            <option :value="v.vehicle_id" x-text="v.plate_no + ' - ' + v.brand_type + ' (' + v.driver_sales + ')'"></option>
                        </template>
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Tanggal Mulai:</label>
                        <input type="date" value="2026-10-02" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl font-medium">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Tanggal Selesai:</label>
                        <input type="date" value="2026-10-02" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl font-medium">
                    </div>
                </div>

                <div class="p-3 bg-indigo-50 border border-indigo-100 rounded-xl text-indigo-900 space-y-1">
                    <div class="font-bold flex items-center gap-1.5">
                        <i data-lucide="info" class="w-4 h-4 text-indigo-600"></i> Fitur Playback Tracksolid
                    </div>
                    <p class="text-[11px] text-indigo-700">Menampilkan rekam jejak koordinat GPS 24 jam terakhir beserta alarm overspeed dan titik pemberhentian (parkir).</p>
                </div>
            </div>

            <div class="flex justify-end gap-2 pt-2 border-t border-slate-100">
                <button @click="openHistoryModal = false" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs">Tutup</button>
                <button @click="openHistoryModal = false; alert('Memuat riwayat rute kendaraan...')" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-md shadow-indigo-200 flex items-center gap-1.5">
                    <i data-lucide="play" class="w-4 h-4"></i> Putar Simulasi Rute
                </button>
            </div>
        </div>
    </div>

    <!-- MODAL 2: MANAJEMEN DEVICE (DEVICE MANAGEMENT) -->
    <div x-show="openDeviceModal" x-cloak class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs z-[500] flex items-center justify-center p-4">
        <div @click.outside="openDeviceModal = false" class="bg-white rounded-2xl border border-slate-200 shadow-2xl max-w-3xl w-full p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div class="flex items-center gap-2">
                    <i data-lucide="cpu" class="w-5 h-5 text-indigo-600"></i>
                    <h3 class="text-base font-bold text-slate-900">Manajemen Perangkat Concox GT06N & Teltonika FMC003</h3>
                </div>
                <button @click="openDeviceModal = false" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <div class="overflow-x-auto max-h-96">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] tracking-wider border-b border-slate-200">
                        <tr>
                            <th class="py-2.5 px-3">PLAT / ARMADA</th>
                            <th class="py-2.5 px-3">DEVICE ID / IMEI</th>
                            <th class="py-2.5 px-3">PROTOKOL GATEWAY</th>
                            <th class="py-2.5 px-3">SIM CARD</th>
                            <th class="py-2.5 px-3">ACC IGNITION</th>
                            <th class="py-2.5 px-3 text-center">AKSI REMOTE</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <template x-for="v in vehicles" :key="v.vehicle_id">
                            <tr class="hover:bg-slate-50">
                                <td class="py-2.5 px-3 font-mono font-bold text-slate-900" x-text="v.plate_no"></td>
                                <td class="py-2.5 px-3 font-mono text-indigo-600 font-semibold" x-text="v.gps_device_id"></td>
                                <td class="py-2.5 px-3 font-medium text-slate-600" x-text="v.gps_device_id.startsWith('FMC') ? 'Teltonika FMC003 (OBD-II)' : 'Concox GT06N (ACC)'"></td>
                                <td class="py-2.5 px-3 font-mono text-slate-500">+62812998877x</td>
                                <td class="py-2.5 px-3">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold" :class="v.acc_status === 'ON' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600'" x-text="'ACC ' + v.acc_status"></span>
                                </td>
                                <td class="py-2.5 px-3 text-center">
                                    <button @click="alert('Mengirim sinyal Remote Engine Cut-off ke ' + v.plate_no)" class="px-2.5 py-1 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 font-bold text-[10px] flex items-center gap-1 mx-auto">
                                        <i data-lucide="power" class="w-3 h-3"></i> Cut Engine
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <div class="flex justify-end pt-2 border-t border-slate-100">
                <button @click="openDeviceModal = false" class="px-4 py-2 rounded-xl bg-slate-900 text-white font-bold text-xs">Tutup</button>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<script>
    function liveTrackingApp() {
        return {
            vehicles: @json($gps['vehicles'] ?? []),
            filterStatus: 'all',
            searchQuery: '',
            selectedVehicle: null,
            openHistoryModal: false,
            openDeviceModal: false,
            isRefreshing: false,
            lastSyncTime: '{{ $gps["tracksolid_last_sync"] ?? "14.20.50" }}',
            map: null,
            markers: {},
            polylines: {},
            showRoutes: true,

            init() {
                if (this.vehicles.length > 0) {
                    this.selectedVehicle = this.vehicles[0];
                }

                this.$nextTick(() => {
                    this.initMap();
                });
            },

            initMap() {
                const defaultLat = this.vehicles[0]?.lat || -7.5342;
                const defaultLng = this.vehicles[0]?.lng || 110.5345;

                this.map = L.map('liveGpsMap', {
                    zoomControl: true,
                    attributionControl: false
                }).setView([defaultLat, defaultLng], 11);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    subdomains: ['a', 'b', 'c']
                }).addTo(this.map);

                this.vehicles.forEach(v => {
                    this.addVehicleMarker(v);
                    this.addVehicleRoute(v);
                });

                this.fitAllMarkers();
            },

            addVehicleMarker(v) {
                const colorClass = this.getMarkerColorClass(v.status_code);
                
                const customIcon = L.divIcon({
                    className: 'custom-gps-icon',
                    html: `
                        <div class="gps-marker-container">
                            <div class="gps-marker-pulse ${v.status_code}"></div>
                            <div class="w-9 h-9 rounded-full bg-white border-2 border-${colorClass}-500 shadow-lg flex items-center justify-center relative z-10 text-slate-800">
                                <svg class="w-5 h-5 text-${colorClass}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                                </svg>
                            </div>
                        </div>
                    `,
                    iconSize: [38, 38],
                    iconAnchor: [19, 19],
                    popupAnchor: [0, -19]
                });

                const marker = L.marker([v.lat, v.lng], { icon: customIcon }).addTo(this.map);

                const popupContent = `
                    <div class="p-3 space-y-2 min-w-[200px]">
                        <div class="flex items-center justify-between border-b pb-1.5">
                            <span class="font-mono font-extrabold text-slate-900 text-sm">${v.plate_no}</span>
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-slate-100 text-slate-700">${v.status}</span>
                        </div>
                        <div class="text-xs text-slate-600 font-semibold">${v.brand_type}</div>
                        <div class="text-[11px] text-indigo-600 font-medium">${v.driver_sales}</div>
                        <div class="text-[10px] text-slate-500 font-mono">${v.last_location}</div>
                        <div class="flex items-center justify-between text-[10px] font-mono text-slate-700 bg-slate-50 p-1.5 rounded">
                            <span>⚡ ${v.battery_v}</span>
                            <span>📡 ${v.satellites} Sats</span>
                            <span>💨 ${v.speed}</span>
                        </div>
                    </div>
                `;

                marker.bindPopup(popupContent);

                marker.on('click', () => {
                    this.selectedVehicle = v;
                });

                this.markers[v.vehicle_id] = marker;
            },

            addVehicleRoute(v) {
                const pathCoords = [
                    [v.lat - 0.015, v.lng - 0.02],
                    [v.lat - 0.008, v.lng - 0.01],
                    [v.lat - 0.003, v.lng - 0.004],
                    [v.lat, v.lng]
                ];

                const colorHex = v.status_code === 'moving' ? '#10b981' : (v.status_code === 'idle' ? '#f59e0b' : '#64748b');

                const polyline = L.polyline(pathCoords, {
                    color: colorHex,
                    weight: 3,
                    opacity: 0.7,
                    dashArray: '6, 8'
                }).addTo(this.map);

                this.polylines[v.vehicle_id] = polyline;
            },

            selectVehicle(v) {
                this.selectedVehicle = v;
                if (this.map && this.markers[v.vehicle_id]) {
                    this.map.flyTo([v.lat, v.lng], 15, { duration: 1.2 });
                    this.markers[v.vehicle_id].openPopup();
                }
            },

            fitAllMarkers() {
                if (!this.map || this.vehicles.length === 0) return;
                const bounds = L.latLngBounds(this.vehicles.map(v => [v.lat, v.lng]));
                this.map.fitBounds(bounds, { padding: [50, 50] });
            },

            togglePolylines() {
                this.showRoutes = !this.showRoutes;
                Object.values(this.polylines).forEach(p => {
                    if (this.showRoutes) {
                        this.map.addLayer(p);
                    } else {
                        this.map.removeLayer(p);
                    }
                });
            },

            countStatus(code) {
                return this.vehicles.filter(v => v.status_code === code).length;
            },

            get filteredVehicles() {
                return this.vehicles.filter(v => {
                    const matchesStatus = this.filterStatus === 'all' || v.status_code === this.filterStatus;
                    const q = this.searchQuery.toLowerCase().trim();
                    const matchesSearch = !q || 
                        v.plate_no.toLowerCase().includes(q) ||
                        v.brand_type.toLowerCase().includes(q) ||
                        v.driver_sales.toLowerCase().includes(q) ||
                        v.area.toLowerCase().includes(q);
                    return matchesStatus && matchesSearch;
                });
            },

            getBadgeClass(code) {
                switch(code) {
                    case 'moving': return 'bg-emerald-50 text-emerald-700 border-emerald-200';
                    case 'idle': return 'bg-amber-50 text-amber-700 border-amber-200';
                    case 'parked': return 'bg-blue-50 text-blue-700 border-blue-200';
                    default: return 'bg-slate-100 text-slate-700 border-slate-200';
                }
            },

            getDotColor(code) {
                switch(code) {
                    case 'moving': return 'bg-emerald-500';
                    case 'idle': return 'bg-amber-500';
                    case 'parked': return 'bg-blue-500';
                    default: return 'bg-slate-400';
                }
            },

            getMarkerColorClass(code) {
                switch(code) {
                    case 'moving': return 'emerald';
                    case 'idle': return 'amber';
                    case 'parked': return 'blue';
                    default: return 'slate';
                }
            },

            refreshData() {
                this.isRefreshing = true;
                const now = new Date();
                this.lastSyncTime = now.getHours().toString().padStart(2, '0') + '.' + 
                                  now.getMinutes().toString().padStart(2, '0') + '.' + 
                                  now.getSeconds().toString().padStart(2, '0');
                
                setTimeout(() => {
                    this.isRefreshing = false;
                }, 700);
            }
        }
    }
</script>
@endpush
