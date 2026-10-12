@extends('layouts.app')

@section('title', 'Role & Permission Matrix')

@section('content')
<div class="space-y-6">

    <!-- Header Banner -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-xl border border-slate-200/90 shadow-xs">
        <div>
            <h1 class="text-xl font-bold text-slate-900">Matriks Peran & Otorisasi Pengguna</h1>
            <p class="text-xs text-slate-500 mt-0.5">Matriks hak akses dan batasan cakupan data (Data Scope) 9 Role Pengguna</p>
        </div>
    </div>

    <!-- Role Scope Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        @foreach($matrix as $roleName => $meta)
        <div class="bg-white border border-slate-200/90 rounded-xl p-5 shadow-xs space-y-3">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h2 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                    <i class="mdi mdi-shield-check text-primary text-lg"></i> Peran: {{ $roleName }}
                </h2>
                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-primary-50 text-primary-700 border border-primary-200">
                    Scope Aktif
                </span>
            </div>
            <div class="space-y-2 text-xs">
                <div class="text-slate-600">
                    <strong class="text-slate-900 font-bold">Cakupan Wilayah:</strong> {{ $meta['area_scope'] ?? 'Data Sendiri' }}
                </div>
                <div>
                    <strong class="text-slate-900 font-bold block mb-1">Akses Data Master:</strong>
                    <div class="flex flex-wrap gap-1">
                        @foreach($meta['master'] as $mItem)
                        <span class="px-2 py-0.5 rounded-md bg-slate-50 text-slate-700 border border-slate-200 text-[10px] font-medium">{{ $mItem }}</span>
                        @endforeach
                    </div>
                </div>
                <div>
                    <strong class="text-slate-900 font-bold block mb-1">Akses Transaksi:</strong>
                    <div class="flex flex-wrap gap-1">
                        @foreach($meta['transaksi'] as $tItem)
                        <span class="px-2 py-0.5 rounded-md bg-primary-50 text-primary-700 border border-primary-200 text-[10px] font-bold">{{ $tItem }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

</div>
@endsection
