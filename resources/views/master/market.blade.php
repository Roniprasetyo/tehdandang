@extends('layouts.app')

@section('title', 'Master Market / Channel')

@section('content')
<div class="space-y-6">

    <!-- Header Banner -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-xl border border-slate-200/90 shadow-xs">
        <div>
            <h1 class="text-xl font-bold text-slate-900">Master Market & Kanal Distribusi</h1>
            <p class="text-xs text-slate-500 mt-0.5">Segmentasi Pasar Penjualan Teh Dandang: General Trade, Modern Trade, & HOREKA</p>
        </div>
    </div>

    <!-- Market Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        @foreach($markets as $m)
        <div class="bg-white border border-slate-200/90 rounded-xl p-5 shadow-xs space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <span class="px-2.5 py-1 rounded-lg bg-primary-50 text-primary-700 font-bold text-xs border border-primary-200">
                    Kode Kanal: {{ $m['code'] }}
                </span>
                <span class="text-xs font-bold font-mono tabular-nums text-emerald-700">{{ number_format($m['count'], 0, ',', '.') }} Outlet</span>
            </div>
            <div>
                <h2 class="text-sm font-bold text-slate-900">{{ $m['name'] }}</h2>
                <p class="text-xs text-slate-500 mt-1">Klasifikasi segmentasi pasar outlet penjualan produk Teh Dandang.</p>
            </div>
        </div>
        @endforeach
    </div>

</div>
@endsection
