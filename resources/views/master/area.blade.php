@extends('layouts.app')

@section('title', 'Master Area Hierarki')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
        <div>
            <h1 class="text-xl font-bold font-display text-slate-900 font-normal">Master Area & Hierarki Regional</h1>
            <p class="text-xs text-slate-500 mt-0.5">Struktur wilayah: Region → Area → Kabupaten → Kecamatan → Outlet Coverage</p>
        </div>
        <a href="{{ route('dashboard.area') }}" class="btn-primary text-xs flex items-center gap-2 active:translate-y-px">
            <i class="mdi mdi-chart-box-outline text-base"></i> Lihat Dashboard Area
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($areas as $r)
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="text-base font-bold text-slate-900 flex items-center gap-2 font-normal">
                    <i class="mdi mdi-map text-primary text-xl"></i> Region: {{ $r['region'] }}
                </h3>
                <span class="text-xs px-2.5 py-1 rounded-full bg-primary/10 text-primary font-bold border border-primary/20 font-mono tabular-nums">
                    {{ count($r['areas']) }} Area
                </span>
            </div>

            <div class="space-y-4">
                @foreach($r['areas'] as $a)
                <div class="bg-slate-50 p-4 rounded-xl border border-slate-200/60 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-bold text-primary flex items-center gap-2">
                            <i class="mdi mdi-office-building text-primary text-base"></i> {{ $a['name'] }}
                        </span>
                        <span class="text-xs font-bold text-slate-700 font-mono tabular-nums">Target: Rp {{ is_numeric($a['target']) ? number_format($a['target'], 0, ',', '.') : $a['target'] }}</span>
                    </div>

                    <div class="pl-4 border-l-2 border-slate-200 space-y-2 text-xs">
                        @foreach($a['kabupaten'] as $kab)
                        <div>
                            <span class="font-bold text-slate-800 block">▪ {{ $kab['name'] }}</span>
                            <div class="pl-3 mt-1 flex flex-wrap gap-2">
                                @foreach($kab['kecamatan'] as $kec)
                                <span class="px-2.5 py-1 rounded-lg bg-white text-slate-600 border border-slate-200 text-[10px] font-medium shadow-xs font-mono tabular-nums">
                                    {{ $kec['name'] }} ({{ number_format($kec['actual_outlets'], 0, ',', '.') }}/{{ number_format($kec['target_outlets'], 0, ',', '.') }} Outlet)
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
