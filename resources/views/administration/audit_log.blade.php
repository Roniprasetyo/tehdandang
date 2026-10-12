@extends('layouts.app')

@section('title', 'Audit Log')

@section('content')
<div class="space-y-6">

    <!-- Header Banner -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-xl border border-slate-200/90 shadow-xs">
        <div>
            @include('partials.breadcrumb')
            <h1 class="text-xl font-bold text-slate-900">Audit Log Sistem</h1>
            <p class="text-xs text-slate-500 mt-0.5">Catatan aktivitas pengguna, timestamp, alamat IP, dan perubahan data</p>
        </div>
    </div>

    <!-- Audit Log Table Container -->
    <div class="bg-white border border-slate-200/90 rounded-xl p-5 shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-4">WAKTU</th>
                        <th class="py-3 px-4">USERNAME</th>
                        <th class="py-3 px-4">PERAN</th>
                        <th class="py-3 px-4">AKSI</th>
                        <th class="py-3 px-4">RINCIAN PERUBAHAN</th>
                        <th class="py-3 px-4 text-right">ALAMAT IP</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($logs as $l)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="py-3 px-4 font-mono tabular-nums text-slate-500">{{ $l['timestamp'] }}</td>
                        <td class="py-3 px-4 font-bold text-slate-900">{{ $l['username'] }}</td>
                        <td class="py-3 px-4">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-primary-50 text-primary-700 border border-primary-200">
                                {{ $l['role'] }}
                            </span>
                        </td>
                        <td class="py-3 px-4 font-bold text-slate-800">{{ $l['action'] }}</td>
                        <td class="py-3 px-4 text-slate-600">{{ $l['details'] }}</td>
                        <td class="py-3 px-4 text-right font-mono tabular-nums text-slate-500">{{ $l['ip'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
