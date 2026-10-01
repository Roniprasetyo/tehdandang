@extends('layouts.app')

@section('title', 'SAP & Concox Integration')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
        <div>
            <h1 class="text-xl font-bold font-display text-slate-900 flex items-center gap-2">
                <i data-lucide="cpu" class="w-5 h-5 text-indigo-600"></i> Integrasi Sistem SAP Business One & Concox GT06N GPS
            </h1>
            <p class="text-xs text-slate-500 mt-0.5">Kesiapan skema database SAP (OCRD, OITM, ORDR) & Webhook Tracksolid Concox GT06N</p>
        </div>
        <div class="flex items-center gap-2">
            <button @click="alert('Simulasi Ping API SAP Business One & Concox GT06N: Connection OK (200 OK)')" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-sm">
                Test API Connection
            </button>
        </div>
    </div>

    <!-- Corporate History & HQ Info Card -->
    <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs space-y-3">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                <i data-lucide="building-2" class="w-4 h-4 text-emerald-600"></i> Corporate Profile — PT. Kartini Teh Nasional
            </h3>
            <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">Est. 1957</span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs">
            <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200/60">
                <span class="font-bold text-slate-900 block mb-1">Alamat Kantor Pusat:</span>
                <p class="text-slate-600">
                    JL. URIP SUMOHARJO NO. 74 RT 02/01 KEL. SAMBONG, KEC. BATANG, JAWA TENGAH, INDONESIA 51212
                </p>
            </div>
            <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200/60">
                <span class="font-bold text-slate-900 block mb-1">Perkebunan Teh Sendiri:</span>
                <ul class="text-slate-600 list-disc pl-4 space-y-0.5">
                    <li>PT. Agrotea Bukit Daun (Prov. Bengkulu)</li>
                    <li>PT. Pecconina Baru (Prov. Sumatera Barat)</li>
                </ul>
            </div>
            <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200/60">
                <span class="font-bold text-slate-900 block mb-1">Pabrik Pengolahan Teh:</span>
                <p class="text-slate-600">
                    Bandung & Cianjur disupply oleh petani binaan lokal untuk menjaga mutu pucuk teh terbaik.
                </p>
            </div>
        </div>
    </div>

    <!-- Concox GT06N & SAP Integration Cards -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Concox GT06N GPS Webhook Monitoring -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                    <i data-lucide="radio" class="w-4 h-4 text-indigo-600"></i> Tracksolid GPS Integration — Concox GT06N
                </h3>
                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-200">
                    Concox GT06N Active
                </span>
            </div>

            <div class="space-y-3 text-xs">
                <div class="flex justify-between p-3 bg-slate-50 rounded-xl border border-slate-200/60">
                    <span class="text-slate-500">Perangkat GPS Model:</span>
                    <span class="font-bold text-slate-900">Concox GT06N (ACC Ignition & Cut-off)</span>
                </div>
                <div class="flex justify-between p-3 bg-slate-50 rounded-xl border border-slate-200/60">
                    <span class="text-slate-500">API Webhook Endpoint:</span>
                    <span class="font-mono text-indigo-600 font-bold">https://api.tracksolidpro.com/v2/gt06n/webhook</span>
                </div>
                <div class="flex justify-between p-3 bg-slate-50 rounded-xl border border-slate-200/60">
                    <span class="text-slate-500">Frekuensi Ping Data:</span>
                    <span class="font-semibold text-slate-700">Real-time Every 30 Seconds</span>
                </div>
                <div class="flex justify-between p-3 bg-slate-50 rounded-xl border border-slate-200/60">
                    <span class="text-slate-500">Total Unit Terpasang:</span>
                    <span class="font-bold text-emerald-600">48 Concox GT06N Devices</span>
                </div>
            </div>
        </div>

        <!-- SAP B1 Schema Mapping (PRD Section 24) -->
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs space-y-4">
            <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                <i data-lucide="database" class="w-4 h-4 text-emerald-600"></i> SAP Business One Data Field Mapping
            </h3>
            <div class="space-y-3">
                @foreach($sapMapping as $entityName => $map)
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200/60 space-y-2">
                    <div class="flex items-center justify-between text-xs">
                        <span class="font-bold text-slate-900">{{ $entityName }}</span>
                        <span class="font-mono text-indigo-600 text-[11px] font-bold">SAP Table: {{ $map['table'] }}</span>
                    </div>
                    <div class="flex flex-wrap gap-1">
                        @foreach($map['fields'] as $field)
                        <span class="px-2 py-0.5 rounded bg-white text-slate-700 font-mono text-[10px] border border-slate-200 shadow-xs">
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
