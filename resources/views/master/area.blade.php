@extends('layouts.app')

@section('title', 'Master Area Hierarki')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
        <div>
            <h1 class="text-xl font-bold font-display text-slate-900">Master Area & Regional Hierarchy</h1>
            <p class="text-xs text-slate-500 mt-0.5">Struktur wilayah: Region → Area → Kabupaten → Kecamatan → Outlet Coverage</p>
        </div>
        <a href="{{ route('dashboard.area') }}" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-md shadow-indigo-200 flex items-center gap-2">
            <i data-lucide="bar-chart-2" class="w-4 h-4"></i> View Area Dashboard
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($areas as $r)
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <i data-lucide="map" class="w-5 h-5 text-indigo-600"></i> Region: {{ $r['region'] }}
                </h3>
                <span class="text-xs px-2.5 py-1 rounded-full bg-indigo-50 text-indigo-700 font-bold border border-indigo-200">
                    {{ count($r['areas']) }} Area
                </span>
            </div>

            <div class="space-y-4">
                @foreach($r['areas'] as $a)
                <div class="bg-slate-50 p-4 rounded-xl border border-slate-200/60 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-bold text-indigo-700 flex items-center gap-2">
                            <i data-lucide="building-2" class="w-4 h-4 text-indigo-600"></i> {{ $a['name'] }}
                        </span>
                        <span class="text-xs font-bold text-slate-700">Target: Rp {{ is_numeric($a['target']) ? number_format($a['target'], 0, ',', '.') : $a['target'] }}</span>
                    </div>

                    <div class="pl-4 border-l-2 border-slate-200 space-y-2 text-xs">
                        @foreach($a['kabupaten'] as $kab)
                        <div>
                            <span class="font-bold text-slate-800 block">▪ {{ $kab['name'] }}</span>
                            <div class="pl-3 mt-1 flex flex-wrap gap-2">
                                @foreach($kab['kecamatan'] as $kec)
                                <span class="px-2.5 py-1 rounded-lg bg-white text-slate-600 border border-slate-200 text-[10px] font-medium shadow-xs">
                                    {{ $kec['name'] }} ({{ number_format($kec['actual_outlets'], 0, ',', '.') }}/{{ number_format($kec['target_outlets'], 0, ',', '.') }} Outlets)
                                </span>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>

</div>
@endsection
