@extends('layouts.app')

@section('title', 'Outlet Management')

@section('content')
<div class="space-y-6">

    <!-- Top Header & Action Buttons -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold font-display text-slate-900">Outlet Management</h1>
            <p class="text-xs text-slate-500 mt-0.5">Manage customer directory, SAP B1 OCRD fields, GT/MT/HOREKA channels, and RO status</p>
        </div>
        <div class="flex items-center gap-2">
            <button @click="alert('Export Outlet Directory (CSV/Excel)')" class="px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 text-xs font-semibold hover:bg-slate-50 shadow-xs flex items-center gap-1.5">
                <i data-lucide="download" class="w-4 h-4 text-slate-500"></i> Export
            </button>
            <button @click="alert('Import Outlet Data via Excel')" class="px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 text-xs font-semibold hover:bg-slate-50 shadow-xs flex items-center gap-1.5">
                <i data-lucide="upload" class="w-4 h-4 text-slate-500"></i> Import
            </button>
            <button @click="alert('Form Registrasi NOO / Outlet Baru (SAP OCRD)')" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-md shadow-indigo-200 flex items-center gap-1.5">
                <i data-lucide="user-plus" class="w-4 h-4"></i> + Registrasi NOO Baru
            </button>
        </div>
    </div>

    <!-- 4 Summary KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">TOTAL OUTLETS</span>
                <span class="text-2xl font-bold text-slate-900 mt-1 block">5.240 Outlets</span>
                <span class="text-[11px] text-emerald-600 font-semibold">Registered in SAP B1</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center">
                <i data-lucide="store" class="w-5 h-5"></i>
            </div>
        </div>

        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">ACTIVE OUTLETS (ROA)</span>
                <span class="text-2xl font-bold text-emerald-600 mt-1 block">3.995 Outlets</span>
                <span class="text-[11px] text-emerald-600 font-semibold">76.2% Active Coverage</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <i data-lucide="check-circle-2" class="w-5 h-5"></i>
            </div>
        </div>

        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">RO WARNING</span>
                <span class="text-2xl font-bold text-amber-600 mt-1 block">482 Outlets</span>
                <span class="text-[11px] text-amber-600 font-semibold">Needs follow up</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                <i data-lucide="alert-triangle" class="w-5 h-5"></i>
            </div>
        </div>

        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">INACTIVE OUTLETS</span>
                <span class="text-2xl font-bold text-rose-600 mt-1 block">1.245 Outlets</span>
                <span class="text-[11px] text-rose-600 font-semibold">> 30 days no order</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center">
                <i data-lucide="user-x" class="w-5 h-5"></i>
            </div>
        </div>
    </div>

    <!-- Outlet Table Container -->
    <div class="bg-white border border-slate-200/80 rounded-2xl shadow-xs">
        
        <!-- Search & Filter Toolbar -->
        <form action="{{ route('master.outlet') }}" method="GET" class="p-4 border-b border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3">
            <h3 class="text-sm font-bold text-slate-900 flex-shrink-0">Outlet Directory</h3>

            <div class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
                <div class="relative flex-1 sm:w-64">
                    <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Search outlet or CardCode..." 
                        class="w-full bg-slate-50 border border-slate-200 text-xs rounded-xl pl-9 pr-4 py-2 text-slate-800 placeholder-slate-400 focus:outline-none focus:border-indigo-500 focus:bg-white"
                    >
                </div>

                <select name="market" onchange="this.form.submit()" class="bg-slate-50 border border-slate-200 text-xs text-slate-700 rounded-xl px-3 py-2 focus:outline-none">
                    <option value="">All Market Channels</option>
                    <option value="GT" {{ request('market') === 'GT' ? 'selected' : '' }}>General Trade (GT)</option>
                    <option value="MT" {{ request('market') === 'MT' ? 'selected' : '' }}>Modern Trade (MT)</option>
                    <option value="HOREKA" {{ request('market') === 'HOREKA' ? 'selected' : '' }}>HOREKA</option>
                </select>
            </div>
        </form>

        <!-- Standard Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-4 w-10">
                            <input type="checkbox" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                        </th>
                        <th class="py-3 px-4">CARD CODE</th>
                        <th class="py-3 px-4">OUTLET NAME</th>
                        <th class="py-3 px-4">CHANNEL</th>
                        <th class="py-3 px-4">LOCATION</th>
                        <th class="py-3 px-4">SALES ASSIGNED</th>
                        <th class="py-3 px-4 text-center">RO STATUS</th>
                        <th class="py-3 px-4 text-right">ACTIONS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($outlets as $o)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="py-3 px-4">
                            <input type="checkbox" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                        </td>
                        <td class="py-3 px-4 font-mono font-bold text-indigo-600">{{ $o['card_code'] }}</td>
                        <td class="py-3 px-4 font-bold text-slate-900">
                            <div>{{ $o['card_name'] }}</div>
                            <div class="text-[10px] text-slate-400 font-normal">Last order: {{ $o['last_order_date'] }}</div>
                        </td>
                        <td class="py-3 px-4 font-semibold text-slate-700">
                            <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-700 border border-slate-200">
                                {{ $o['market'] }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-slate-600">
                            <div>{{ $o['address'] }}</div>
                            <div class="text-[10px] text-slate-400">{{ $o['kecamatan'] }}, {{ $o['kabupaten'] }}</div>
                        </td>
                        <td class="py-3 px-4 font-semibold text-slate-800">{{ $o['sales_name'] }}</td>
                        <td class="py-3 px-4 text-center">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $o['ro_status'] === 'Active' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : ($o['ro_status'] === 'Warning' ? 'bg-amber-50 text-amber-700 border-amber-200' : 'bg-rose-50 text-rose-700 border-rose-200') }}">
                                {{ $o['ro_status_color'] }} {{ $o['ro_status'] }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-right space-x-1">
                            <a href="{{ route('master.outlet.detail', $o['card_code']) }}" class="p-1.5 text-slate-400 hover:text-indigo-600 hover:bg-slate-100 rounded-lg inline-block">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                            </a>
                            <button @click="alert('Edit Outlet: {{ $o['card_code'] }}')" class="p-1.5 text-slate-400 hover:text-slate-900 hover:bg-slate-100 rounded-lg">
                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                            </button>
                            <button @click="alert('Delete Outlet: {{ $o['card_code'] }}')" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
            <span>Showing {{ number_format(count($outlets), 0, ',', '.') }} of {{ number_format(count($outlets), 0, ',', '.') }} outlets</span>
            <div class="flex items-center gap-1">
                <button class="px-3 py-1 bg-white border border-slate-200 rounded-lg text-slate-400 cursor-not-allowed">Previous</button>
                <button class="px-3 py-1 bg-indigo-600 text-white font-bold rounded-lg shadow-xs">1</button>
                <button class="px-3 py-1 bg-white border border-slate-200 rounded-lg text-slate-600 hover:bg-slate-50">Next</button>
            </div>
        </div>

    </div>

</div>
@endsection
