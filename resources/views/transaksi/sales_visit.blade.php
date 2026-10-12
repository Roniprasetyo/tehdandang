@extends('layouts.app')

@section('title', 'Kunjungan Sales & Verifikasi GPS')

@section('content')
<div class="space-y-6" x-data="{ showForm: false }">

    <!-- Header & Aksi Utama -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-xl border border-slate-200/90 shadow-xs">
        <div>
            <h1 class="text-xl font-semibold text-slate-900">Kunjungan Sales & Verifikasi GPS</h1>
            <p class="text-xs text-slate-500 mt-1">Pencatatan kunjungan outlet, validasi radius geofence GPS, dan rekam audit waktu presensi</p>
        </div>
        <div class="flex items-center gap-2">
            <button 
                type="button" 
                @click="showForm = !showForm" 
                class="btn-primary"
            >
                <i class="mdi" :class="showForm ? 'mdi-close' : 'mdi-plus'"></i>
                <span x-text="showForm ? 'Tutup Form' : 'Rekam Kunjungan Baru'"></span>
            </button>
        </div>
    </div>

    <!-- 4 Ringkasan Metrik Konsisten -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white border border-slate-200/90 rounded-xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-xs font-medium text-slate-500 block">Total Kunjungan</span>
                <span class="text-2xl font-semibold font-mono tabular-nums text-slate-900 mt-1 block">{{ count($visits) }}</span>
                <span class="text-xs text-slate-500 mt-1 block">Hari ini tercatat</span>
            </div>
            <div class="w-9 h-9 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center text-lg flex-shrink-0">
                <i class="mdi mdi-map-marker-check-outline"></i>
            </div>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-xs font-medium text-slate-500 block">Valid Geofence (≤100m)</span>
                <span class="text-2xl font-semibold font-mono tabular-nums text-primary mt-1 block">{{ count(array_filter($visits, fn($v) => ($v['distance_meters'] ?? 0) <= 100)) }}</span>
                <span class="text-xs text-slate-500 mt-1 block">Lokasi terverifikasi</span>
            </div>
            <div class="w-9 h-9 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center text-lg flex-shrink-0">
                <i class="mdi mdi-crosshairs-gps"></i>
            </div>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-xs font-medium text-slate-500 block">Deviasi Radius (&gt;100m)</span>
                <span class="text-2xl font-semibold font-mono tabular-nums text-secondary mt-1 block">{{ count(array_filter($visits, fn($v) => ($v['distance_meters'] ?? 0) > 100)) }}</span>
                <span class="text-xs text-slate-500 mt-1 block">Perlu verifikasi SPV</span>
            </div>
            <div class="w-9 h-9 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center text-lg flex-shrink-0">
                <i class="mdi mdi-alert-circle-outline"></i>
            </div>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-xs font-medium text-slate-500 block">Kepatuhan Kunjungan</span>
                <span class="text-2xl font-semibold font-mono tabular-nums text-slate-900 mt-1 block">94.2%</span>
                <span class="text-xs text-slate-500 mt-1 block">Rata-rata kepatuhan armada</span>
            </div>
            <div class="w-9 h-9 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center text-lg flex-shrink-0">
                <i class="mdi mdi-shield-check-outline"></i>
            </div>
        </div>
    </div>

    <!-- Visit Form -->
    <div x-show="showForm" x-cloak class="bg-white border border-slate-200/90 rounded-xl p-5 shadow-xs space-y-4">
        <h3 class="text-sm font-semibold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-3">
            <i class="mdi mdi-map-marker-check text-primary text-base"></i> Formulir Rekam Kunjungan Sales
        </h3>
        <form @submit.prevent="notify('Kunjungan sales visit berhasil dicatat dan diverifikasi.', 'success'); showForm = false" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-xs">
            <div>
                <label class="block text-slate-600 mb-1.5 font-medium">Target Outlet</label>
                <select required class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-lg h-9 px-3 hover:border-slate-300 focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/20 transition-all cursor-pointer">
                    <option value="">Pilih Outlet</option>
                    @foreach($outlets as $o)
                    <option value="{{ $o['card_code'] }}">{{ $o['card_name'] }} ({{ $o['address'] }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-slate-600 mb-1.5 font-medium">Waktu Check-in</label>
                <input type="text" value="08:15 WIB" readonly class="w-full bg-slate-50 border border-slate-200 text-slate-500 rounded-lg h-9 px-3 font-mono">
            </div>
            <div>
                <label class="block text-slate-600 mb-1.5 font-medium">Aktivitas Sales</label>
                <select class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-lg h-9 px-3 hover:border-slate-300 focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/20 transition-all cursor-pointer">
                    <option>Order Taking & Merchandising</option>
                    <option>Penagihan Pembayaran</option>
                    <option>Pemeriksaan Stok Rutin</option>
                    <option>Tindak Lanjut Proposal Akun</option>
                </select>
            </div>
            <div>
                <label class="block text-slate-600 mb-1.5 font-medium">Hasil Kunjungan</label>
                <input type="text" placeholder="Contoh: Pesanan dibuat (Rp 250.000)" class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-lg h-9 px-3 hover:border-slate-300 focus:bg-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/20 transition-all">
            </div>
            <div>
                <label class="block text-slate-600 mb-1.5 font-medium">Koordinat GPS & Validasi</label>
                <input type="text" value="-6.9218, 107.6071 (Radius: 80m - Valid)" readonly class="w-full bg-slate-50 border border-slate-200 text-primary font-mono font-medium rounded-lg h-9 px-3">
            </div>
            <div class="md:col-span-2 lg:col-span-3 flex justify-end gap-2 pt-3 border-t border-slate-100">
                <button type="button" @click="showForm = false" class="btn-secondary-outline">Batal</button>
                <button type="submit" class="btn-primary">Simpan Kunjungan</button>
            </div>
        </form>
    </div>

    <!-- Visits Table -->
    <div class="bg-white border border-slate-200/90 rounded-xl p-5 shadow-xs space-y-4">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h3 class="text-sm font-semibold text-slate-900">Daftar Kunjungan & Validasi Presensi GPS</h3>
            <span class="text-xs text-slate-500 font-mono tabular-nums">{{ count($visits) }} Kunjungan</span>
        </div>
        <div class="overflow-x-auto rounded-lg border border-slate-200">
            <table class="w-full text-left text-xs text-slate-700 divide-y divide-slate-200">
                <thead class="bg-slate-50 text-slate-600 uppercase text-[11px] font-semibold tracking-wider">
                    <tr>
                        <th class="py-3 px-3.5">Tanggal</th>
                        <th class="py-3 px-3.5">Sales Person</th>
                        <th class="py-3 px-3.5">Nama Outlet</th>
                        <th class="py-3 px-3.5">Check-in</th>
                        <th class="py-3 px-3.5">Check-out</th>
                        <th class="py-3 px-3.5">Radius Jarak</th>
                        <th class="py-3 px-3.5">Aktivitas</th>
                        <th class="py-3 px-3.5">Hasil Kunjungan</th>
                        <th class="py-3 px-3.5 text-center">Status GPS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @foreach($visits as $v)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="py-3 px-3.5 font-mono text-slate-500">{{ $v['date'] }}</td>
                        <td class="py-3 px-3.5 font-medium text-slate-900">{{ $v['sales_name'] }}</td>
                        <td class="py-3 px-3.5 font-medium text-primary">{{ $v['outlet_name'] }}</td>
                        <td class="py-3 px-3.5 font-mono tabular-nums text-slate-600">{{ $v['checkin_time'] }}</td>
                        <td class="py-3 px-3.5 font-mono tabular-nums text-slate-600">{{ $v['checkout_time'] }}</td>
                        <td class="py-3 px-3.5 font-mono tabular-nums font-semibold {{ ($v['distance_meters'] ?? 0) <= 100 ? 'text-primary' : 'text-rose-600' }}">
                            {{ $v['distance'] }}
                        </td>
                        <td class="py-3 px-3.5 text-slate-600">{{ $v['activity'] }}</td>
                        <td class="py-3 px-3.5 text-slate-800">{{ $v['result'] }}</td>
                        <td class="py-3 px-3.5 text-center">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium border {{ $v['status'] === 'Valid' ? 'bg-primary-50 text-primary-700 border-primary-200' : 'bg-rose-50 text-rose-700 border-rose-200' }}">
                                <i class="mdi {{ $v['status'] === 'Valid' ? 'mdi-check-circle-outline' : 'mdi-alert-circle-outline' }} mr-1"></i> {{ $v['status'] }}
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
