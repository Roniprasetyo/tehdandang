@extends('layouts.app')

@section('title', 'Katalog Produk')

@section('content')
<div class="space-y-6">

    <!-- Header & Aksi Utama -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-xl border border-slate-200/90 shadow-xs">
        <div>
            @include('partials.breadcrumb')
            <h1 class="text-xl font-semibold text-slate-900">Katalog Produk & SAP OITM</h1>
            <p class="text-xs text-slate-500 mt-1">Master data produk Teh Dandang, penetapan harga SAP Business One, dan status ketersediaan stok</p>
        </div>
        <div class="flex items-center gap-2">
            <button 
                type="button" 
                @click="notify('Katalog produk SKU berhasil diekspor ke Excel.', 'success')" 
                class="btn-secondary-outline"
            >
                <i class="mdi mdi-download text-base"></i>
                <span>Ekspor</span>
            </button>
            <button 
                type="button" 
                @click="notify('Pilih berkas Excel untuk impor pembaharuan harga SAP OITM.', 'info')" 
                class="btn-secondary-outline"
            >
                <i class="mdi mdi-upload text-base"></i>
                <span>Impor</span>
            </button>
            @if(in_array($authUser['role'] ?? '', ['Admin', 'Admin Pusat', 'IT', 'General Manager', 'GM']))
            <button 
                type="button" 
                @click="notify('Formulir entri produk baru (SAP OITM) siap diisi.', 'info')" 
                class="btn-primary"
            >
                <i class="mdi mdi-plus text-base"></i>
                <span>Tambah Produk</span>
            </button>
            @endif
        </div>
    </div>

    <!-- 4 Ringkasan Metrik Konsisten -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white border border-slate-200/90 rounded-xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-xs font-medium text-slate-500 block">Total SKU Aktif</span>
                <span class="text-2xl font-semibold font-mono tabular-nums text-slate-900 mt-1 block">{{ count($products) }}</span>
                <span class="text-xs text-slate-500 mt-1 block">Tersinkronisasi SAP OITM</span>
            </div>
            <div class="w-9 h-9 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center text-lg flex-shrink-0">
                <i class="mdi mdi-package-variant-closed"></i>
            </div>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-xs font-medium text-slate-500 block">Kategori Terbanyak</span>
                <span class="text-2xl font-semibold text-primary mt-1 block">Teh Tubruk</span>
                <span class="text-xs text-slate-500 mt-1 block">Produk unggulan ritel</span>
            </div>
            <div class="w-9 h-9 rounded-lg bg-primary/10 text-primary flex items-center justify-center text-lg flex-shrink-0">
                <i class="mdi mdi-tea"></i>
            </div>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-xs font-medium text-slate-500 block">Rata-rata Harga Satuan</span>
                <span class="text-2xl font-semibold font-mono tabular-nums text-secondary mt-1 block">Rp 18.500</span>
                <span class="text-xs text-slate-500 mt-1 block">Harga price list standar</span>
            </div>
            <div class="w-9 h-9 rounded-lg bg-secondary/10 text-secondary flex items-center justify-center text-lg flex-shrink-0">
                <i class="mdi mdi-tag-outline"></i>
            </div>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-xs font-medium text-slate-500 block">Ketersediaan Stok</span>
                <span class="text-2xl font-semibold font-mono tabular-nums text-accent mt-1 block">98.2%</span>
                <span class="text-xs text-slate-500 mt-1 block">Stok gudang aman</span>
            </div>
            <div class="w-9 h-9 rounded-lg bg-accent/10 text-accent flex items-center justify-center text-lg flex-shrink-0">
                <i class="mdi mdi-warehouse"></i>
            </div>
        </div>
    </div>

    <!-- Tabel Master Produk -->
    <div class="bg-white border border-slate-200/90 rounded-xl shadow-xs overflow-hidden">
        
        <!-- Filter Toolbar -->
        <form action="{{ route('master.product') }}" method="GET" class="p-4 border-b border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3">
            <h2 class="text-sm font-semibold text-slate-900 flex-shrink-0">Katalog Produk SKU</h2>

            <div class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
                <div class="relative flex-1 sm:w-64">
                    <i class="mdi mdi-magnify text-slate-400 text-base absolute left-3 top-1/2 -translate-y-1/2"></i>
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Cari kode SKU atau nama teh..." 
                        class="w-full bg-slate-50 border border-slate-200 text-xs rounded-lg pl-9 pr-3 py-2 text-slate-800 placeholder-slate-400 focus:outline-none focus:border-primary focus:bg-white transition-colors"
                    >
                </div>

                <select name="category" onchange="this.form.submit()" class="bg-slate-50 border border-slate-200 text-xs text-slate-700 rounded-lg px-3 py-2 focus:outline-none focus:border-primary">
                    <option value="">Semua Kategori Produk</option>
                    <option value="Teh Celup" {{ request('category') === 'Teh Celup' ? 'selected' : '' }}>Teh Celup</option>
                    <option value="Teh Tubruk" {{ request('category') === 'Teh Tubruk' ? 'selected' : '' }}>Teh Tubruk</option>
                    <option value="Specialty" {{ request('category') === 'Specialty' ? 'selected' : '' }}>Specialty Tea</option>
                </select>
            </div>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-600 uppercase text-xs font-semibold tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-2.5 px-4 w-10">
                            <input type="checkbox" class="rounded border-slate-300 text-primary focus:ring-primary">
                        </th>
                        <th class="py-2.5 px-4">KODE SKU (OITM)</th>
                        <th class="py-2.5 px-4">NAMA PRODUK</th>
                        <th class="py-2.5 px-4">KATEGORI</th>
                        <th class="py-2.5 px-4">SATUAN (UOM)</th>
                        <th class="py-2.5 px-4">HARGA DISTRIBUTOR</th>
                        <th class="py-2.5 px-4 text-center">STATUS STOK</th>
                        <th class="py-2.5 px-4 text-right">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($products as $p)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="py-3 px-4">
                            <input type="checkbox" class="rounded border-slate-300 text-primary focus:ring-primary">
                        </td>
                        <td class="py-3 px-4 font-mono tabular-nums font-semibold text-primary">
                            {{ $p['item_code'] }}
                        </td>
                        <td class="py-3 px-4 font-semibold text-slate-900">
                            <div>{{ $p['item_name'] }}</div>
                            <div class="text-[11px] text-slate-400 font-normal">Kemasan: {{ $p['packaging'] ?? 'Standar Pack' }}</div>
                        </td>
                        <td class="py-3 px-4">
                            <span class="inline-flex px-2 py-0.5 rounded-md text-xs font-medium bg-slate-100 text-slate-700 border border-slate-200">
                                {{ $p['category'] }}
                            </span>
                        </td>
                        <td class="py-3 px-4 font-medium text-slate-700">
                            {{ $p['uom'] ?? 'Karton' }}
                        </td>
                        <td class="py-3 px-4 font-mono tabular-nums font-semibold text-slate-900">
                            Rp {{ number_format($p['price'], 0, ',', '.') }}
                        </td>
                        <td class="py-3 px-4 text-center">
                            <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium border {{ ($p['status'] ?? 'Available') === 'Available' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-amber-50 text-amber-700 border-amber-200' }}">
                                {{ ($p['status'] ?? 'Available') === 'Available' ? 'Tersedia' : 'Stok Menipis' }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-right space-x-1">
                            <button 
                                type="button" 
                                @click="notify('Detail SAP B1 untuk SKU {{ $p['item_code'] }} berhasil dimuat.', 'info')" 
                                class="p-1.5 text-slate-500 hover:text-primary hover:bg-slate-100 rounded-md transition-colors"
                                title="Lihat Detail SKU"
                            >
                                <i class="mdi mdi-eye-outline text-base"></i>
                            </button>
                            <button 
                                type="button" 
                                @click="notify('Penyuntingan data produk {{ $p['item_name'] }} dibuka.', 'info')" 
                                class="p-1.5 text-slate-500 hover:text-slate-800 hover:bg-slate-100 rounded-md transition-colors"
                                title="Edit Produk"
                            >
                                <i class="mdi mdi-pencil-outline text-base"></i>
                            </button>
                            <button 
                                type="button" 
                                @click="notify('Penghapusan SKU {{ $p['item_code'] }} diblokir karena terikat transaksi SAP.', 'warning')" 
                                class="p-1.5 text-slate-500 hover:text-rose-600 hover:bg-rose-50 rounded-md transition-colors"
                                title="Hapus SKU"
                            >
                                <i class="mdi mdi-trash-can-outline text-base"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
            <span>Menampilkan {{ number_format(count($products), 0, ',', '.') }} varian produk SKU</span>
            <div class="flex items-center gap-1 font-mono tabular-nums">
                <button class="px-3 py-1 bg-white border border-slate-200 rounded-md text-slate-400 cursor-not-allowed">Sebelumnya</button>
                <button class="px-3 py-1 bg-primary text-white font-medium rounded-md">1</button>
                <button class="px-3 py-1 bg-white border border-slate-200 rounded-md text-slate-600 hover:bg-slate-50">Berikutnya</button>
            </div>
        </div>

    </div>

</div>
@endsection
