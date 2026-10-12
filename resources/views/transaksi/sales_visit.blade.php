<!-- Hallmark & Anti-Slop Active · Theme: Tri-Tone Heritage (Tea Green, Amber Brew, Sky Accent) -->
@extends('layouts.app')

@section('title', 'Sales Visit & GPS Check-in')

@section('content')
<div class="space-y-6" x-data="{ showForm: false }">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/90 shadow-xs">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold tracking-wider uppercase bg-primary-50 text-primary-700 border border-primary-200">
                    <i class="mdi mdi-crosshairs-gps mr-1"></i> Concox GT06N
                </span>
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold tracking-wider uppercase bg-accent-50 text-accent-700 border border-accent-200">
                    Geofence Radius 100m
                </span>
            </div>
            <h1 class="text-xl font-bold font-display text-slate-900 tracking-tight">Sales Visit & Concox GT06N Verification</h1>
            <p class="text-xs text-slate-500 mt-1">Pencatatan kunjungan outlet, verifikasi radius geofence GPS, dan rekam audit waktu check-in/out</p>
        </div>
        <button 
            type="button" 
            @click="showForm = !showForm" 
            class="px-4 py-2 rounded-xl bg-primary hover:bg-primary-hover active:translate-y-px text-white text-xs font-semibold shadow-xs flex items-center gap-1.5 transition-all cursor-pointer"
        >
            <i class="mdi" :class="showForm ? 'mdi-close' : 'mdi-plus'"></i>
            <span x-text="showForm ? 'Tutup Form' : '+ Rekam Kunjungan Baru'">+ Rekam Kunjungan Baru</span>
        </button>
    </div>

    <!-- Visit Form -->
    <div x-show="showForm" x-cloak class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs space-y-4">
        <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-3">
            <i class="mdi mdi-map-marker-check text-primary text-base"></i> Form Check-in Sales Visit (Verifikasi Radius GT06N)
        </h3>
        <form @submit.prevent="notify('Kunjungan sales visit berhasil dicatat dan diverifikasi oleh sistem GPS.', 'success'); showForm = false" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-xs">
            <div>
                <label class="block text-slate-600 mb-1.5 font-semibold">Target Outlet:</label>
                <select required class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl p-2.5 hover:border-slate-300 focus:bg-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary-100 transition-all cursor-pointer">
                    <option value="">-- Pilih Outlet --</option>
                    @foreach($outlets as $o)
                    <option value="{{ $o['card_code'] }}">{{ $o['card_name'] }} ({{ $o['address'] }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-slate-600 mb-1.5 font-semibold">Waktu Check-in:</label>
                <input type="text" value="08:15 WIB" readonly class="w-full bg-slate-50 border border-slate-200 text-slate-500 rounded-xl p-2.5 font-mono">
            </div>
            <div>
                <label class="block text-slate-600 mb-1.5 font-semibold">Aktivitas Sales:</label>
                <select class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl p-2.5 hover:border-slate-300 focus:bg-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary-100 transition-all cursor-pointer">
                    <option>Order Taking & Merchandising</option>
                    <option>Payment Collection</option>
                    <option>Routine Check Stock</option>
                    <option>Account Proposal Followup</option>
                </select>
            </div>
            <div>
                <label class="block text-slate-600 mb-1.5 font-semibold">Hasil Kunjungan:</label>
                <input type="text" placeholder="Contoh: Order Dibuat (Rp 250.000)" class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl p-2.5 hover:border-slate-300 focus:bg-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary-100 transition-all">
            </div>
            <div>
                <label class="block text-slate-600 mb-1.5 font-semibold">Koordinat GPS GT06N:</label>
                <input type="text" value="-6.9218, 107.6071 (Jarak: 80m - Valid Geofence)" readonly class="w-full bg-slate-50 border border-slate-200 text-primary font-mono font-bold rounded-xl p-2.5">
            </div>
            <div class="md:col-span-2 lg:col-span-3 flex justify-end gap-2 pt-3 border-t border-slate-100">
                <button type="button" @click="showForm = false" class="px-4 py-2 bg-white border border-slate-200 text-slate-700 rounded-xl hover:bg-slate-50 active:translate-y-px font-semibold transition-all cursor-pointer">Batal</button>
                <button type="submit" class="px-4 py-2 bg-primary hover:bg-primary-hover active:translate-y-px text-white font-semibold rounded-xl shadow-xs transition-all cursor-pointer">Simpan Kunjungan</button>
            </div>
        </form>
    </div>

    <!-- Visits Table -->
    <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs space-y-4">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Daftar Sales Visit & Validasi Radius GPS</h3>
            <span class="text-xs text-slate-500 font-mono tabular-nums">{{ count($visits) }} Kunjungan Tercatat</span>
        </div>
        <div class="overflow-x-auto rounded-xl border border-slate-200/80">
            <table class="w-full text-left text-xs text-slate-700 divide-y divide-slate-200">
                <thead class="bg-slate-50/90 text-slate-600 uppercase text-[10px] font-bold tracking-wider">
                    <tr>
                        <th class="py-3 px-4">Tanggal</th>
                        <th class="py-3 px-4">Sales Person</th>
                        <th class="py-3 px-4">Nama Outlet</th>
                        <th class="py-3 px-4">Check-in</th>
                        <th class="py-3 px-4">Check-out</th>
                        <th class="py-3 px-4">Radius Jarak</th>
                        <th class="py-3 px-4">Aktivitas</th>
                        <th class="py-3 px-4">Hasil Visit</th>
                        <th class="py-3 px-4 text-center">Status GPS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @foreach($visits as $v)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="py-3 px-4 font-mono text-slate-500">{{ $v['date'] }}</td>
                        <td class="py-3 px-4 font-semibold text-slate-900">{{ $v['sales_name'] }}</td>
                        <td class="py-3 px-4 font-semibold text-primary">{{ $v['outlet_name'] }}</td>
                        <td class="py-3 px-4 font-mono text-slate-600">{{ $v['checkin_time'] }}</td>
                        <td class="py-3 px-4 font-mono text-slate-600">{{ $v['checkout_time'] }}</td>
                        <td class="py-3 px-4 font-mono font-bold {{ $v['distance_meters'] <= 100 ? 'text-primary' : 'text-rose-600' }}">
                            {{ $v['distance'] }}
                        </td>
                        <td class="py-3 px-4 text-slate-600">{{ $v['activity'] }}</td>
                        <td class="py-3 px-4 font-medium text-slate-800">{{ $v['result'] }}</td>
                        <td class="py-3 px-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $v['status'] === 'Valid' ? 'bg-primary-50 text-primary-700 border-primary-200' : 'bg-rose-50 text-rose-700 border-rose-200' }}">
                                <i class="mdi {{ $v['status'] === 'Valid' ? 'mdi-check-circle-outline' : 'mdi-alert-circle-outline' }} mr-1 text-xs"></i> {{ $v['status'] }}
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
