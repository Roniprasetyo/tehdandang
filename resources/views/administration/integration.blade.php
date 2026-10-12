@extends('layouts.app')

@section('title', 'SAP & Concox Integration')

@section('content')
<div class="space-y-6">

    <!-- Header Banner -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-xl border border-slate-200/90 shadow-xs">
        <div>
            @include('partials.breadcrumb')
            <h1 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                <i class="mdi mdi-chip text-primary text-2xl"></i> Integrasi Sistem SAP Business One & Concox GT06N GPS
            </h1>
            <p class="text-xs text-slate-500 mt-0.5">Kesiapan skema database SAP (OCRD, OITM, ORDR) & Webhook Tracksolid Concox GT06N</p>
        </div>
        <div class="flex items-center gap-2">
            <button 
                type="button"
                @click="notify('Simulasi Ping API SAP Business One & Concox GT06N: Koneksi Berhasil (200 OK)', 'success')" 
                class="btn-primary text-xs shadow-sm active:translate-y-px"
            >
                Uji Koneksi API (Ping)
            </button>
        </div>
    </div>

    <!-- Corporate History & HQ Info Card -->
    <div class="bg-white border border-slate-200/90 rounded-xl p-5 shadow-xs space-y-3">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h2 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                <i class="mdi mdi-office-building text-primary text-lg"></i> Profil Korporasi — PT. Kartini Teh Nasional
            </h2>
            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-primary-50 text-primary-700 border border-primary-200 font-mono tabular-nums">Est. 1957</span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs">
            <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200/60">
                <span class="font-bold text-slate-900 block mb-1">Alamat Kantor Pusat:</span>
                <p class="text-slate-600 leading-relaxed">
                    JL. URIP SUMOHARJO NO. 74 RT 02/01 KEL. SAMBONG, KEC. BATANG, JAWA TENGAH, INDONESIA 51212
                </p>
            </div>
            <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200/60">
                <span class="font-bold text-slate-900 block mb-1">Perkebunan Teh Mandiri:</span>
                <ul class="text-slate-600 list-disc pl-4 space-y-0.5">
                    <li>PT. Agrotea Bukit Daun (Prov. Bengkulu)</li>
                    <li>PT. Pecconina Baru (Prov. Sumatera Barat)</li>
                </ul>
            </div>
            <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200/60">
                <span class="font-bold text-slate-900 block mb-1">Pabrik & Sentra Petani Binaan:</span>
                <p class="text-slate-600 leading-relaxed">
                    Bandung & Cianjur disupply oleh petani binaan lokal untuk menjaga mutu pucuk teh terbaik.
                </p>
            </div>
        </div>
    </div>

    <!-- Concox GT06N & SAP Integration Cards -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        
        <!-- Concox GT06N GPS Webhook Monitoring -->
        <div class="bg-white border border-slate-200/90 rounded-xl p-5 shadow-xs space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h2 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                    <i class="mdi mdi-access-point text-primary text-lg"></i> Integrasi GPS Tracksolid — Concox GT06N
                </h2>
                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-primary-50 text-primary-700 border border-primary-200">
                    Concox GT06N Aktif
                </span>
            </div>

            <div class="space-y-3 text-xs">
                <div class="flex justify-between p-3 bg-slate-50 rounded-xl border border-slate-200/60">
                    <span class="text-slate-500">Perangkat GPS Model:</span>
                    <span class="font-bold text-slate-900">Concox GT06N (ACC Ignition & Cut-off)</span>
                </div>
                <div class="flex justify-between p-3 bg-slate-50 rounded-xl border border-slate-200/60">
                    <span class="text-slate-500">Endpoint Webhook API:</span>
                    <span class="font-mono tabular-nums text-primary font-bold">https://api.tracksolidpro.com/v2/gt06n/webhook</span>
                </div>
                <div class="flex justify-between p-3 bg-slate-50 rounded-xl border border-slate-200/60">
                    <span class="text-slate-500">Frekuensi Ping Data:</span>
                    <span class="font-semibold text-slate-700">Real-time Setiap 30 Detik</span>
                </div>
                <div class="flex justify-between p-3 bg-slate-50 rounded-xl border border-slate-200/60">
                    <span class="text-slate-500">Total Unit Terpasang:</span>
                    <span class="font-bold font-mono tabular-nums text-emerald-700">48 Unit Concox GT06N</span>
                </div>
            </div>
        </div>

        <!-- SAP B1 Schema Mapping (PRD Section 24) -->
        <div class="bg-white border border-slate-200/90 rounded-xl p-5 shadow-xs space-y-4">
            <h2 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                <i class="mdi mdi-database text-primary text-lg"></i> Pemetaan Kolom Data SAP Business One
            </h2>
            <div class="space-y-3">
                @foreach($sapMapping as $entityName => $map)
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200/60 space-y-2">
                    <div class="flex items-center justify-between text-xs">
                        <span class="font-bold text-slate-900">{{ $entityName }}</span>
                        <span class="font-mono tabular-nums text-primary text-[11px] font-bold">Tabel SAP: {{ $map['table'] }}</span>
                    </div>
                    <div class="flex flex-wrap gap-1">
                        @foreach($map['fields'] as $field)
                        <span class="px-2 py-0.5 rounded bg-white text-slate-700 font-mono tabular-nums text-[10px] border border-slate-200 shadow-xs">
                            {{ $field }}
                        </span>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>

</div>
@endsection
