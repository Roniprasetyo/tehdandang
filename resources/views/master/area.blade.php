@extends('layouts.app')

@section('title', 'Master Wilayah & Hierarki Regional')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-xl border border-slate-200/90 shadow-xs">
        <div>
            <h1 class="text-xl font-semibold text-slate-900">Master Wilayah & Hierarki Regional</h1>
            <p class="text-xs text-slate-500 mt-1">Struktur wilayah: Region &rarr; Area &rarr; Kabupaten &rarr; Kecamatan &rarr; Cakupan Outlet</p>
        </div>
        <a href="{{ route('dashboard.area') }}" class="btn-primary">
            <i class="mdi mdi-chart-box-outline text-base"></i>
            <span>Lihat Dashboard Area</span>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($areas as $r)
        <div class="bg-white border border-slate-200/90 rounded-xl p-5 shadow-xs space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="text-base font-semibold text-slate-900 flex items-center gap-2">
                    <i class="mdi mdi-map text-primary text-xl"></i> Region: {{ $r['region'] }}
                </h3>
                <span class="text-xs px-2.5 py-1 rounded-full bg-primary-50 text-primary-700 font-medium border border-primary-200 font-mono tabular-nums">
                    {{ count($r['areas']) }} Area
                </span>
            </div>

            <div class="space-y-4">
                @foreach($r['areas'] as $a)
                <div class="bg-slate-50 p-4 rounded-lg border border-slate-200/80 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-semibold text-primary flex items-center gap-2">
                            <i class="mdi mdi-office-building text-primary text-base"></i> {{ $a['name'] }}
                        </span>
                        <span class="text-xs font-medium text-slate-700 font-mono tabular-nums">Target: Rp {{ is_numeric($a['target']) ? number_format($a['target'], 0, ',', '.') : $a['target'] }}</span>
                    </div>

                    <div class="pl-4 border-l-2 border-slate-200 space-y-2 text-xs">
                        @foreach($a['kabupaten'] as $kab)
                        <div>
                            <span class="font-medium text-slate-800 flex items-center gap-1">
                                <i class="mdi mdi-map-marker text-slate-400 text-sm"></i>
                                <span>{{ $kab['name'] }}</span>
                            </span>
                            <div class="pl-4 mt-1.5 flex flex-wrap gap-2">
                                @foreach($kab['kecamatan'] as $kec)
                                <span class="px-2.5 py-1 rounded bg-white text-slate-600 border border-slate-200 text-[11px] font-medium shadow-xs font-mono tabular-nums">
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
