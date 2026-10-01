@extends('layouts.app')

@section('title', 'Sales Directory')

@section('content')
<div class="space-y-6">

    <!-- Top Header & Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold font-display text-slate-900">Sales Directory</h1>
            <p class="text-xs text-slate-500 mt-0.5">Manage sales force, NPK employee codes, SAP SlpCode mapping, and area targets</p>
        </div>
        <div class="flex items-center gap-2">
            <button @click="alert('Export Sales Directory (CSV/Excel)')" class="px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 text-xs font-semibold hover:bg-slate-50 shadow-xs flex items-center gap-1.5">
                <i data-lucide="download" class="w-4 h-4 text-slate-500"></i> Export
            </button>
            <button @click="alert('Import Sales Data via Excel')" class="px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 text-xs font-semibold hover:bg-slate-50 shadow-xs flex items-center gap-1.5">
                <i data-lucide="upload" class="w-4 h-4 text-slate-500"></i> Import
            </button>
            @if(in_array($authUser['role'], ['Admin Pusat', 'IT', 'Admin Area', 'Manager', 'ASM']))
            <button @click="alert('Form Tambah Salesman Baru')" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-md shadow-indigo-200 flex items-center gap-1.5">
                <i data-lucide="user-plus" class="w-4 h-4"></i> + Add Sales
            </button>
            @endif
        </div>
    </div>

    <!-- 4 Summary KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">TOTAL SALES FORCE</span>
                <span class="text-2xl font-bold text-slate-900 mt-1 block">{{ count($salesList) }} Salesmen</span>
                <span class="text-[11px] text-emerald-600 font-semibold">Active in 4 Regions</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center">
                <i data-lucide="users" class="w-5 h-5"></i>
            </div>
        </div>

        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">TOP SALES PERFORMER</span>
                <span class="text-2xl font-bold text-emerald-600 mt-1 block">115.0%</span>
                <span class="text-[11px] text-emerald-600 font-bold">★ Eko Prasetyo (Cepogo)</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <i data-lucide="award" class="w-5 h-5"></i>
            </div>
        </div>

        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">AVG ACHIEVEMENT</span>
                <span class="text-2xl font-bold text-indigo-600 mt-1 block">89.8%</span>
                <span class="text-[11px] text-indigo-600 font-semibold">MTD Target Rate</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                <i data-lucide="trending-up" class="w-5 h-5"></i>
            </div>
        </div>

        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">GPS VEHICLES</span>
                <span class="text-2xl font-bold text-cyan-600 mt-1 block">100%</span>
                <span class="text-[11px] text-slate-400">Concox GT06N Equipped</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-cyan-50 text-cyan-600 flex items-center justify-center">
                <i data-lucide="truck" class="w-5 h-5"></i>
            </div>
        </div>
    </div>

    <!-- Sales Table Container -->
    <div class="bg-white border border-slate-200/80 rounded-2xl shadow-xs">
        
        <!-- Search Toolbar -->
        <form action="{{ route('master.sales') }}" method="GET" class="p-4 border-b border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3">
            <h3 class="text-sm font-bold text-slate-900 flex-shrink-0">Sales Representatives</h3>

            <div class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
                <div class="relative flex-1 sm:w-64">
                    <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Search NPK or Sales name..." 
                        class="w-full bg-slate-50 border border-slate-200 text-xs rounded-xl pl-9 pr-4 py-2 text-slate-800 placeholder-slate-400 focus:outline-none focus:border-indigo-500 focus:bg-white"
                    >
                </div>

                <button type="submit" class="px-4 py-2 bg-indigo-50 text-indigo-600 border border-indigo-200 rounded-xl text-xs font-bold hover:bg-indigo-100">
                    Filter
                </button>
            </div>
        </form>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-4 w-10">
                            <input type="checkbox" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                        </th>
                        <th class="py-3 px-4">NPK</th>
                        <th class="py-3 px-4">SALES PERSON</th>
                        <th class="py-3 px-4">AREA / REGION</th>
                        <th class="py-3 px-4">SUPERVISOR (ASM)</th>
                        <th class="py-3 px-4">TARGET MTD</th>
                        <th class="py-3 px-4">ACHIEVEMENT</th>
                        <th class="py-3 px-4 text-center">STATUS</th>
                        <th class="py-3 px-4 text-right">ACTIONS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($salesList as $s)
                    <tr class="hover:bg-slate-50/80 transition-colors {{ str_contains($s['status'], 'Top Performer') ? 'bg-emerald-50/30' : '' }}">
                        <td class="py-3 px-4">
                            <input type="checkbox" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                        </td>
                        <td class="py-3 px-4 font-mono font-bold text-indigo-600">{{ $s['npk'] }}</td>
                        <td class="py-3 px-4 font-bold text-slate-900">
                            <div>{{ $s['name'] }}</div>
                            <div class="text-[10px] text-slate-400 font-normal">SlpCode: {{ $s['slp_code'] }} | Vehicle: {{ $s['vehicle_plate'] }}</div>
                        </td>
                        <td class="py-3 px-4 text-slate-600 font-medium">{{ $s['area'] }} ({{ $s['region'] }})</td>
                        <td class="py-3 px-4 text-slate-600">{{ $s['asm'] }}</td>
                        <td class="py-3 px-4 font-semibold text-slate-800">Rp {{ number_format($s['target'], 0, ',', '.') }}</td>
                        <td class="py-3 px-4">
                            <span class="font-bold {{ $s['achievement'] >= 100 ? 'text-emerald-600 font-extrabold' : ($s['achievement'] >= 80 ? 'text-indigo-600' : 'text-rose-600') }}">
                                {{ $s['achievement'] }}%
                            </span>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ str_contains($s['status'], 'Top Performer') ? 'bg-emerald-600 text-white' : 'bg-emerald-50 text-emerald-700 border border-emerald-200' }}">
                                {{ $s['status'] }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-right space-x-1">
                            <a href="{{ route('master.sales.detail', $s['npk']) }}" class="p-1.5 text-slate-400 hover:text-indigo-600 hover:bg-slate-100 rounded-lg inline-block">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                            </a>
                            <button @click="alert('Edit Sales: {{ $s['name'] }}')" class="p-1.5 text-slate-400 hover:text-slate-900 hover:bg-slate-100 rounded-lg">
                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                            </button>
                            <button @click="alert('Delete Sales: {{ $s['name'] }}')" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
            <span>Showing {{ number_format(count($salesList), 0, ',', '.') }} of {{ number_format(count($salesList), 0, ',', '.') }} salesmen</span>
            <div class="flex items-center gap-1">
                <button class="px-3 py-1 bg-white border border-slate-200 rounded-lg text-slate-400 cursor-not-allowed">Previous</button>
                <button class="px-3 py-1 bg-indigo-600 text-white font-bold rounded-lg shadow-xs">1</button>
                <button class="px-3 py-1 bg-white border border-slate-200 rounded-lg text-slate-600 hover:bg-slate-50">Next</button>
            </div>
        </div>

    </div>

</div>
@endsection
