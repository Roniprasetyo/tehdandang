@extends('layouts.app')

@section('title', 'Audit Log')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
        <div>
            <h1 class="text-xl font-bold font-display text-slate-900">System Audit Log</h1>
            <p class="text-xs text-slate-500 mt-0.5">Catatan aktivitas pengguna, timestamp, alamat IP, dan perubahan data</p>
        </div>
    </div>

    <!-- Audit Log Table Container -->
    <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-4">TIMESTAMP</th>
                        <th class="py-3 px-4">USERNAME</th>
                        <th class="py-3 px-4">ROLE</th>
                        <th class="py-3 px-4">ACTION</th>
                        <th class="py-3 px-4">CHANGE DETAILS</th>
                        <th class="py-3 px-4 text-right">IP ADDRESS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($logs as $l)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="py-3 px-4 font-mono text-slate-500">{{ $l['timestamp'] }}</td>
                        <td class="py-3 px-4 font-bold text-slate-900">{{ $l['username'] }}</td>
                        <td class="py-3 px-4">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-200">
                                {{ $l['role'] }}
                            </span>
                        </td>
                        <td class="py-3 px-4 font-bold text-slate-800">{{ $l['action'] }}</td>
                        <td class="py-3 px-4 text-slate-600">{{ $l['details'] }}</td>
                        <td class="py-3 px-4 text-right font-mono text-slate-500">{{ $l['ip'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
