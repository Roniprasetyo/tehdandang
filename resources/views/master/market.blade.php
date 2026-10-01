@extends('layouts.app')

@section('title', 'Master Market / Channel')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
        <div>
            <h1 class="text-xl font-bold font-display text-slate-900">Master Market & Distribution Channel</h1>
            <p class="text-xs text-slate-500 mt-0.5">Segmentasi Pasar Penjualan Teh Dandang: General Trade, Modern Trade, & HOREKA</p>
        </div>
    </div>

    <!-- Market Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($markets as $m)
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <span class="px-2.5 py-1 rounded-lg bg-indigo-50 text-indigo-700 font-bold text-xs border border-indigo-200">
                    Channel Code: {{ $m['code'] }}
                </span>
                <span class="text-xs font-bold text-emerald-600">{{ number_format($m['count'], 0, ',', '.') }} Outlets</span>
            </div>
            <div>
                <h3 class="text-sm font-bold text-slate-900">{{ $m['name'] }}</h3>
                <p class="text-xs text-slate-500 mt-1">Klasifikasi segmentasi pasar outlet penjualan produk Teh Dandang.</p>
            </div>
        </div>
        @endforeach
    </div>

</div>
@endsection
