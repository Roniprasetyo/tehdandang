@extends('layouts.app')

@section('title', 'Product Management')

@section('content')
<div class="space-y-6">

    <!-- Top Header & Action Buttons (Metis Style: Title + Export/Import/+ New) -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold font-display text-slate-900">Product Management</h1>
            <p class="text-xs text-slate-500 mt-0.5">Manage your product catalog, SAP B1 OITM mapping, and inventory status</p>
        </div>
        <div class="flex items-center gap-2">
            <button @click="alert('Export Product Catalog (CSV/Excel)')" class="px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 text-xs font-semibold hover:bg-slate-50 shadow-xs flex items-center gap-1.5">
                <i data-lucide="download" class="w-4 h-4 text-slate-500"></i> Export
            </button>
            <button @click="alert('Import Product Catalog via Excel')" class="px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 text-xs font-semibold hover:bg-slate-50 shadow-xs flex items-center gap-1.5">
                <i data-lucide="upload" class="w-4 h-4 text-slate-500"></i> Import
            </button>
            @if(in_array($authUser['role'], ['Admin Pusat', 'IT', 'Admin Area', 'Manager']))
            <button @click="alert('Form Tambah Produk Baru (SAP OITM Entry)')" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-md shadow-indigo-200 flex items-center gap-1.5">
                <i data-lucide="plus" class="w-4 h-4"></i> + New Product
            </button>
            @endif
        </div>
    </div>

    <!-- 4 Summary KPI Cards (Metis Style Top Metric Banner) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">TOTAL PRODUCTS</span>
                <span class="text-2xl font-bold text-slate-900 mt-1 block">{{ count($products) }} SKU</span>
                <span class="text-[11px] text-emerald-600 font-semibold">↑ +5% from last month</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center">
                <i data-lucide="package" class="w-5 h-5"></i>
            </div>
        </div>

        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">IN STOCK</span>
                <span class="text-2xl font-bold text-emerald-600 mt-1 block">5 SKU</span>
                <span class="text-[11px] text-emerald-600 font-semibold">✓ Well stocked</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <i data-lucide="check-circle-2" class="w-5 h-5"></i>
            </div>
        </div>

        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">LOW STOCK ALERTS</span>
                <span class="text-2xl font-bold text-amber-600 mt-1 block">0 SKU</span>
                <span class="text-[11px] text-slate-400">Normal inventory level</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                <i data-lucide="alert-triangle" class="w-5 h-5"></i>
            </div>
        </div>

        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">SAP OITM SYNC</span>
                <span class="text-2xl font-bold text-indigo-600 mt-1 block">100%</span>
                <span class="text-[11px] text-indigo-600 font-semibold">Synced with SAP B1</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                <i data-lucide="database" class="w-5 h-5"></i>
            </div>
        </div>
    </div>

    <!-- Product Catalog Table Container (Metis Style: Search + Filters + Action Table) -->
    <div class="bg-white border border-slate-200/80 rounded-2xl shadow-xs">
        
        <!-- Table Search & Filter Toolbar -->
        <form action="{{ route('master.product') }}" method="GET" class="p-4 border-b border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3">
            <h3 class="text-sm font-bold text-slate-900 flex-shrink-0">Product Catalog</h3>

            <div class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
                <div class="relative flex-1 sm:w-64">
                    <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Search products..." 
                        class="w-full bg-slate-50 border border-slate-200 text-xs rounded-xl pl-9 pr-4 py-2 text-slate-800 placeholder-slate-400 focus:outline-none focus:border-indigo-500 focus:bg-white"
                    >
                </div>

                <select name="category" onchange="this.form.submit()" class="bg-slate-50 border border-slate-200 text-xs text-slate-700 rounded-xl px-3 py-2 focus:outline-none">
                    <option value="">All Categories</option>
                    <option value="Teh Celup">Teh Celup</option>
                    <option value="Teh Tubruk">Teh Tubruk</option>
                    <option value="Premium Tea">Premium Tea</option>
                    <option value="Herbal Tea">Herbal Tea</option>
                </select>

                <select name="status" onchange="this.form.submit()" class="bg-slate-50 border border-slate-200 text-xs text-slate-700 rounded-xl px-3 py-2 focus:outline-none">
                    <option value="">All Status</option>
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
            </div>
        </form>

        <!-- Standard Data Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-4 w-10">
                            <input type="checkbox" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                        </th>
                        <th class="py-3 px-4">PRODUCT CODE</th>
                        <th class="py-3 px-4">PRODUCT NAME</th>
                        <th class="py-3 px-4">CATEGORY</th>
                        <th class="py-3 px-4">UOM</th>
                        <th class="py-3 px-4">SAP PRICE</th>
                        <th class="py-3 px-4 text-center">STATUS</th>
                        <th class="py-3 px-4 text-right">ACTIONS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($products as $p)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="py-3 px-4">
                            <input type="checkbox" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                        </td>
                        <td class="py-3 px-4 font-mono font-bold text-indigo-600">{{ $p['item_code'] }}</td>
                        <td class="py-3 px-4 font-bold text-slate-900">
                            <div>{{ $p['item_name'] }}</div>
                            <div class="text-[10px] text-slate-400 font-normal">OITB Group: {{ $p['itms_grp_cod'] }}</div>
                        </td>
                        <td class="py-3 px-4 text-slate-600 font-medium">{{ $p['category'] }}</td>
                        <td class="py-3 px-4 font-semibold text-slate-700">{{ $p['invntry_uom'] }}</td>
                        <td class="py-3 px-4 font-bold text-emerald-600">{{ $p['price_formatted'] }}</td>
                        <td class="py-3 px-4 text-center">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                {{ $p['status'] }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-right space-x-1">
                            <button @click="alert('View Product SAP Details: {{ $p['item_code'] }}')" class="p-1.5 text-slate-400 hover:text-indigo-600 hover:bg-slate-100 rounded-lg">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                            </button>
                            <button @click="alert('Edit Product: {{ $p['item_code'] }}')" class="p-1.5 text-slate-400 hover:text-slate-900 hover:bg-slate-100 rounded-lg">
                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                            </button>
                            <button @click="alert('Delete Product: {{ $p['item_code'] }}')" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Table Pagination Footer -->
        <div class="p-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
            <span>Showing {{ number_format(count($products), 0, ',', '.') }} of {{ number_format(count($products), 0, ',', '.') }} products</span>
            <div class="flex items-center gap-1">
                <button class="px-3 py-1 bg-white border border-slate-200 rounded-lg text-slate-400 cursor-not-allowed">Previous</button>
                <button class="px-3 py-1 bg-indigo-600 text-white font-bold rounded-lg shadow-xs">1</button>
                <button class="px-3 py-1 bg-white border border-slate-200 rounded-lg text-slate-600 hover:bg-slate-50">Next</button>
            </div>
        </div>

    </div>

</div>
@endsection
