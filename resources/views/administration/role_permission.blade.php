@extends('layouts.app')

@section('title', 'Role & Permission Matrix')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
        <div>
            <h1 class="text-xl font-bold font-display text-slate-900">Role & Permission Scope Matrix</h1>
            <p class="text-xs text-slate-500 mt-0.5">Matriks hak akses dan batasan cakupan data (Data Scope) 9 Role Pengguna</p>
        </div>
    </div>

    <!-- Role Scope Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($matrix as $roleName => $meta)
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs space-y-3">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                    <i data-lucide="shield-check" class="w-4 h-4 text-indigo-600"></i> Role: {{ $roleName }}
                </h3>
                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-200">
                    Active Scope
                </span>
            </div>
            <div class="space-y-2 text-xs">
                <div class="text-slate-600">
                    <strong class="text-slate-900 font-bold">Area Scope:</strong> {{ $meta['area_scope'] ?? 'Data Sendiri' }}
                </div>
                <div>
                    <strong class="text-slate-900 font-bold block mb-1">Master Access:</strong>
                    <div class="flex flex-wrap gap-1">
                        @foreach($meta['master'] as $mItem)
                        <span class="px-2 py-0.5 rounded-lg bg-slate-50 text-slate-700 border border-slate-200 text-[10px] font-medium">{{ $mItem }}</span>
                        @endforeach
                    </div>
                </div>
                <div>
                    <strong class="text-slate-900 font-bold block mb-1">Transaksi Access:</strong>
                    <div class="flex flex-wrap gap-1">
                        @foreach($meta['transaksi'] as $tItem)
                        <span class="px-2 py-0.5 rounded-lg bg-indigo-50 text-indigo-700 border border-indigo-200 text-[10px] font-bold">{{ $tItem }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

</div>
@endsection
