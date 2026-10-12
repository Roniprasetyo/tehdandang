<!-- Hallmark & Anti-Slop Active · Theme: Tri-Tone Heritage (Tea Green, Amber Brew, Sky Accent) -->
@extends('layouts.app')

@section('title', 'Product Management')

@section('content')
<div class="space-y-6">

    <!-- Top Header & Action Buttons -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/90 shadow-xs">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold tracking-wider uppercase bg-primary-50 text-primary-700 border border-primary-200">
                    <i class="mdi mdi-tea mr-1"></i> Teh Dandang SKUs
                </span>
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold tracking-wider uppercase bg-accent-50 text-accent-700 border border-accent-200">
                    SAP B1 OITM Synced
                </span>
            </div>
            <h1 class="text-xl font-bold font-display text-slate-900 tracking-tight">Katalog Produk & SAP OITM</h1>
            <p class="text-xs text-slate-500 mt-1">Kelola master data produk, pemetaan harga OITM SAP Business One, dan status ketersediaan stok</p>
        </div>
        <div class="flex items-center gap-2">
            <button 
                type="button" 
                @click="notify('Katalog produk SKU berhasil diekspor ke format Excel.', 'success')" 
                class="px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 text-xs font-semibold hover:bg-slate-50 active:translate-y-px shadow-xs flex items-center gap-1.5 transition-all cursor-pointer"
            >
                <i class="mdi mdi-file-excel-box text-base text-primary-600"></i>
                <span>Export</span>
            </button>
            <button 
                type="button" 
                @click="notify('Pilih berkas Excel untuk impor pembaharuan harga SAP OITM.', 'info')" 
                class="px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 text-xs font-semibold hover:bg-slate-50 active:translate-y-px shadow-xs flex items-center gap-1.5 transition-all cursor-pointer"
            >
                <i class="mdi mdi-upload text-base text-slate-500"></i>
                <span>Import</span>
            </button>
            @if(in_array($authUser['role'], ['Admin Pusat', 'IT', 'Admin Area', 'Manager']))
            <button 
                type="button" 
                @click="notify('Formulir entri produk baru (SAP OITM) siap diisi.', 'info')" 
                class="px-4 py-2 rounded-xl bg-primary hover:bg-primary-hover active:translate-y-px text-white text-xs font-semibold shadow-xs flex items-center gap-1.5 transition-all cursor-pointer"
            >
                <i class="mdi mdi-plus text-base"></i>
                <span>+ Produk Baru</span>
            </button>
            @endif
        </div>
    </div>

    <!-- 4 Summary KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Total SKU Aktif</span>
                <span class="text-2xl font-bold font-display text-slate-900 mt-1 block tabular-nums">{{ count($products) }} SKU</span>
                <span class="text-[11px] text-primary font-semibold">Tersinkronisasi SAP</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-primary-50 text-primary flex items-center justify-center">
                <i class="mdi mdi-package-variant-closed text-xl"></i>
            </div>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Stok Aman Gudang</span>
                <span class="text-2xl font-bold font-display text-primary mt-1 block tabular-nums">5 SKU</span>
                <span class="text-[11px] text-primary font-semibold">✓ Persediaan mencukupi</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-primary-50 text-primary flex items-center justify-center">
                <i class="mdi mdi-check-circle-outline text-xl"></i>
            </div>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Peringatan Stok Rendah</span>
                <span class="text-2xl font-bold font-display text-secondary mt-1 block tabular-nums">0 SKU</span>
                <span class="text-[11px] text-slate-400">Tingkat persediaan normal</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-secondary-50 text-secondary flex items-center justify-center">
                <i class="mdi mdi-alert-circle-outline text-xl"></i>
            </div>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Sinkronisasi SAP OITM</span>
                <span class="text-2xl font-bold font-display text-accent mt-1 block tabular-nums">100%</span>
                <span class="text-[11px] text-accent font-semibold">Terkoneksi Real-time</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-accent-50 text-accent flex items-center justify-center">
                <i class="mdi mdi-database-sync-outline text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Product Catalog Table Container -->
    <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs">
        
        <!-- Table Search & Filter Toolbar -->
        <form action="{{ route('master.product') }}" method="GET" class="p-4 border-b border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3">
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900 flex-shrink-0">Daftar SKU Teh Dandang</h3>

            <div class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
                <div class="relative flex-1 sm:w-64">
                    <i class="mdi mdi-magnify text-slate-400 absolute left-3 top-1/2 -translate-y-1/2 text-base"></i>
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Cari kode atau nama SKU..." 
                        class="w-full bg-slate-50 border border-slate-200 text-xs rounded-xl pl-9 pr-4 py-2 text-slate-800 placeholder-slate-400 hover:border-slate-300 focus:bg-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary-100 transition-all"
                    >
                </div>

                <select name="category" onchange="this.form.submit()" class="bg-slate-50 border border-slate-200 text-xs text-slate-700 rounded-xl px-3 py-2 hover:border-slate-300 focus:bg-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary-100 transition-all cursor-pointer">
                    <option value="">Semua Kategori</option>
                    <option value="Teh Celup">Teh Celup</option>
                    <option value="Teh Tubruk">Teh Tubruk</option>
                    <option value="Premium Tea">Premium Tea</option>
                    <option value="Herbal Tea">Herbal Tea</option>
                </select>

                <select name="status" onchange="this.form.submit()" class="bg-slate-50 border border-slate-200 text-xs text-slate-700 rounded-xl px-3 py-2 hover:border-slate-300 focus:bg-white focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary-100 transition-all cursor-pointer">
                    <option value="">Semua Status</option>
                    <option value="Active">Aktif</option>
                    <option value="Inactive">Non-aktif</option>
                </select>
            </div>
        </form>

        <!-- Standard Data Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700 divide-y divide-slate-200">
                <thead class="bg-slate-50/90 text-slate-600 uppercase text-[10px] font-bold tracking-wider">
                    <tr>
                        <th class="py-3 px-4 w-10">
                            <input type="checkbox" class="rounded border-slate-300 text-primary focus:ring-primary">
                        </th>
                        <th class="py-3 px-4">Kode Item</th>
                        <th class="py-3 px-4">Nama Produk SKU</th>
                        <th class="py-3 px-4">Kategori</th>
                        <th class="py-3 px-4">Satuan (UOM)</th>
                        <th class="py-3 px-4 text-right">Harga SAP</th>
                        <th class="py-3 px-4 text-center">Status</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @foreach($products as $p)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="py-3 px-4">
                            <input type="checkbox" class="rounded border-slate-300 text-primary focus:ring-primary">
                        </td>
                        <td class="py-3 px-4 font-mono font-bold text-primary">{{ $p['item_code'] }}</td>
                        <td class="py-3 px-4 font-semibold text-slate-900">
                            <div>{{ $p['item_name'] }}</div>
                            <div class="text-[10px] text-slate-400 font-normal">Grup OITB: {{ $p['itms_grp_cod'] }}</div>
                        </td>
                        <td class="py-3 px-4 text-slate-600 font-medium">{{ $p['category'] }}</td>
                        <td class="py-3 px-4 font-semibold text-slate-700">{{ $p['invntry_uom'] }}</td>
                        <td class="py-3 px-4 text-right font-mono font-bold text-primary tabular-nums">{{ $p['price_formatted'] }}</td>
                        <td class="py-3 px-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-primary-50 text-primary-700 border border-primary-200">
                                {{ $p['status'] }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-right space-x-1">
                            <button 
                                type="button" 
                                @click="notify('Detail SAP B1 untuk SKU {{ $p['item_code'] }} berhasil dimuat.', 'info')" 
                                class="p-1.5 text-slate-400 hover:text-primary hover:bg-slate-100 rounded-lg transition-colors cursor-pointer" 
                                title="Lihat SAP Details"
                            >
                                <i class="mdi mdi-eye-outline text-base"></i>
                            </button>
                            <button 
                                type="button" 
                                @click="notify('Penyuntingan data produk {{ $p['item_name'] }} dibuka.', 'info')" 
                                class="p-1.5 text-slate-400 hover:text-slate-900 hover:bg-slate-100 rounded-lg transition-colors cursor-pointer" 
                                title="Edit"
                            >
                                <i class="mdi mdi-pencil-outline text-base"></i>
                            </button>
                            <button 
                                type="button" 
                                @click="notify('Penghapusan SKU {{ $p['item_code'] }} diblokir karena terikat transaksi SAP.', 'warning')" 
                                class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors cursor-pointer" 
                                title="Hapus"
                            >
                                <i class="mdi mdi-delete-outline text-base"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Table Pagination Footer -->
        <div class="p-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
            <span>Menampilkan {{ number_format(count($products), 0, ',', '.') }} dari {{ number_format(count($products), 0, ',', '.') }} produk</span>
            <div class="flex items-center gap-1">
                <button class="px-3 py-1 bg-white border border-slate-200 rounded-lg text-slate-400 cursor-not-allowed">Sebelumnya</button>
                <button class="px-3 py-1 bg-primary text-white font-bold rounded-lg shadow-xs">1</button>
                <button class="px-3 py-1 bg-white border border-slate-200 rounded-lg text-slate-600 hover:bg-slate-50 cursor-pointer">Selanjutnya</button>
            </div>
        </div>

    </div>

</div>
@endsection
