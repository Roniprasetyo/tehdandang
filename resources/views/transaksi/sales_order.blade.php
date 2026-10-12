@extends('layouts.app')

@section('title', 'Manajemen Pesanan Penjualan (SAP B1)')

@section('content')
<div class="space-y-6" x-data="{ 
    showForm: false,
    selectedCustomer: '',
    items: [
        { item_code: 'DP001', name: 'Teh Dandang Biru Celup 25s', qty: 20, uom: 'Box', price: 8500, discount: 5, total: 161500 }
    ],
    addItem() {
        this.items.push({ item_code: 'DM001', name: 'Teh Dandang Merah Tubruk 40g', qty: 10, uom: 'Pack', price: 4500, discount: 0, total: 45000 });
    },
    removeItem(index) {
        this.items.splice(index, 1);
    },
    getSubtotal() {
        return this.items.reduce((sum, item) => sum + (item.qty * item.price * (1 - item.discount/100)), 0);
    }
}">

    <!-- Header & Aksi Utama -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-xl border border-slate-200/90 shadow-xs">
        <div>
            @include('partials.breadcrumb')
            <h1 class="text-xl font-semibold text-slate-900">Manajemen Pesanan Penjualan (SAP B1)</h1>
            <p class="text-xs text-slate-500 mt-1">Pencatatan order penjualan dengan struktur data dokumen ORDR / RDR1 SAP Business One</p>
        </div>
        <div class="flex items-center gap-2">
            <button 
                type="button"
                @click="notify('Data transaksi Sales Order berhasil diekspor.', 'success')" 
                class="btn-secondary-outline"
            >
                <i class="mdi mdi-download text-base"></i>
                <span>Ekspor</span>
            </button>
            <button 
                type="button"
                @click="showForm = !showForm" 
                class="btn-primary"
            >
                <i class="mdi" :class="showForm ? 'mdi-close' : 'mdi-plus'"></i>
                <span x-text="showForm ? 'Tutup Formulir' : 'Buat Pesanan Baru'"></span>
            </button>
        </div>
    </div>

    <!-- SAP-style Sales Order Entry Form -->
    <div x-show="showForm" x-cloak class="bg-white border border-slate-200/90 rounded-xl p-5 shadow-xs space-y-5">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <div>
                <h3 class="text-sm font-semibold text-slate-900">Formulir Pesanan Penjualan (ORDR)</h3>
                <p class="text-xs text-slate-500 mt-0.5">Integrasi langsung dengan modul Sales & Distribution SAP Business One</p>
            </div>
            <span class="px-2.5 py-1 rounded bg-primary-50 text-primary-700 border border-primary-200 text-xs font-mono font-medium">Dokumen ORDR/RDR1</span>
        </div>

        <!-- Header Fields -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-xs">
            <div>
                <label class="block text-slate-600 mb-1.5 font-medium">Pelanggan (CardCode / CardName)</label>
                <select x-model="selectedCustomer" required class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-lg h-9 px-3 focus:outline-none focus:border-primary focus:bg-white transition-all cursor-pointer">
                    <option value="">Pilih Outlet Pelanggan</option>
                    @foreach($outlets as $o)
                    <option value="{{ $o['card_code'] }}">{{ $o['card_code'] }} - {{ $o['card_name'] }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-slate-600 mb-1.5 font-medium">Tenaga Penjual (SlpCode)</label>
                <select class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-lg h-9 px-3 focus:outline-none focus:border-primary focus:bg-white transition-all cursor-pointer">
                    @foreach($salesList as $s)
                    <option value="{{ $s['slp_code'] }}">{{ $s['name'] }} (SlpCode: {{ $s['slp_code'] }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-slate-600 mb-1.5 font-medium">Tanggal Dokumen (DocDate)</label>
                <input type="date" value="{{ date('Y-m-d') }}" class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-lg h-9 px-3 focus:outline-none focus:border-primary focus:bg-white font-mono transition-all">
            </div>

            <div>
                <label class="block text-slate-600 mb-1.5 font-medium">Jadwal Pengiriman (DocDueDate)</label>
                <input type="date" value="{{ date('Y-m-d', strtotime('+2 days')) }}" class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-lg h-9 px-3 focus:outline-none focus:border-primary focus:bg-white font-mono transition-all">
            </div>
        </div>

        <!-- Item Lines Table (RDR1 Matrix) -->
        <div class="space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-700">Rincian Baris Barang (Matriks RDR1)</span>
                <button type="button" @click="addItem()" class="h-8 px-3 rounded-lg bg-primary-50 text-primary-700 hover:bg-primary-100 text-xs font-medium border border-primary-200 flex items-center gap-1 active:translate-y-px transition-colors cursor-pointer">
                    <i class="mdi mdi-plus text-base"></i> Tambah Baris Barang
                </button>
            </div>

            <div class="overflow-x-auto border border-slate-200 rounded-lg bg-slate-50">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-white text-slate-600 uppercase text-[11px] font-semibold border-b border-slate-200">
                        <tr>
                            <th class="py-2.5 px-3">Kode SKU</th>
                            <th class="py-2.5 px-3">Nama Produk</th>
                            <th class="py-2.5 px-3 w-24">Kuantitas</th>
                            <th class="py-2.5 px-3 w-20">Satuan</th>
                            <th class="py-2.5 px-3">Harga Satuan</th>
                            <th class="py-2.5 px-3 w-24">Diskon %</th>
                            <th class="py-2.5 px-3">Total Baris</th>
                            <th class="py-2.5 px-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200/80">
                        <template x-for="(item, index) in items" :key="index">
                            <tr>
                                <td class="py-2 px-3">
                                    <input type="text" x-model="item.item_code" class="w-full bg-white border border-slate-200 rounded-lg h-8 px-2.5 font-mono tabular-nums text-primary font-medium">
                                </td>
                                <td class="py-2 px-3">
                                    <input type="text" x-model="item.name" class="w-full bg-white border border-slate-200 rounded-lg h-8 px-2.5 font-medium text-slate-900">
                                </td>
                                <td class="py-2 px-3">
                                    <input type="number" x-model.number="item.qty" class="w-full bg-white border border-slate-200 rounded-lg h-8 px-2.5 text-center font-mono tabular-nums">
                                </td>
                                <td class="py-2 px-3">
                                    <input type="text" x-model="item.uom" class="w-full bg-white border border-slate-200 rounded-lg h-8 px-2.5 text-center">
                                </td>
                                <td class="py-2 px-3">
                                    <input type="number" x-model.number="item.price" class="w-full bg-white border border-slate-200 rounded-lg h-8 px-2.5 font-mono tabular-nums">
                                </td>
                                <td class="py-2 px-3">
                                    <input type="number" x-model.number="item.discount" class="w-full bg-white border border-slate-200 rounded-lg h-8 px-2.5 text-center font-mono tabular-nums">
                                </td>
                                <td class="py-2 px-3 font-medium text-primary font-mono tabular-nums">
                                    Rp <span x-text="Math.round(item.qty * item.price * (1 - item.discount/100)).toLocaleString('id-ID')"></span>
                                </td>
                                <td class="py-2 px-3 text-center">
                                    <button type="button" @click="removeItem(index)" class="text-rose-600 hover:text-rose-700 p-1 cursor-pointer">
                                        <i class="mdi mdi-trash-can-outline text-base"></i>
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Totals Footer -->
        <div class="flex flex-col sm:flex-row items-end justify-between border-t border-slate-100 pt-4 gap-4 text-xs">
            <div class="text-slate-500">
                <span class="block font-medium">Status Pemetaan SAP B1: <strong class="text-primary font-semibold">Siap Sinkronisasi POST /ORDR</strong></span>
                <span class="block text-[11px] text-slate-400 mt-0.5">Subtotal, Pajak PPN 11%, dan potongan harga terhitung otomatis</span>
            </div>
            <div class="w-72 space-y-2 bg-slate-50 p-4 rounded-xl border border-slate-200/80">
                <div class="flex justify-between font-mono tabular-nums text-slate-600">
                    <span class="font-sans">Subtotal:</span>
                    <span class="font-medium text-slate-900">Rp <span x-text="Math.round(getSubtotal()).toLocaleString('id-ID')"></span></span>
                </div>
                <div class="flex justify-between font-mono tabular-nums text-slate-600">
                    <span class="font-sans">PPN (11%):</span>
                    <span class="font-medium text-slate-700">Rp <span x-text="Math.round(getSubtotal() * 0.11).toLocaleString('id-ID')"></span></span>
                </div>
                <div class="flex justify-between border-t border-slate-200 pt-2 text-sm font-mono tabular-nums">
                    <span class="font-semibold text-primary font-sans">Total Akhir:</span>
                    <span class="font-semibold text-primary">Rp <span x-text="Math.round(getSubtotal() * 1.11).toLocaleString('id-ID')"></span></span>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-2 pt-2 border-t border-slate-100">
            <button type="button" @click="showForm = false" class="btn-secondary-outline">Batal</button>
            <button 
                type="button" 
                @click="notify('Sales Order berhasil dibuat & disinkronkan ke SAP B1!', 'success'); showForm = false" 
                class="btn-primary"
            >
                Simpan & Sinkronkan SAP B1
            </button>
        </div>
    </div>

    <!-- Orders List Container -->
    <div class="bg-white border border-slate-200/90 rounded-xl shadow-xs p-5">
        <h3 class="text-sm font-semibold text-slate-900 mb-4">Daftar Transaksi Pesanan Penjualan (ORDR)</h3>
        <div class="overflow-x-auto rounded-lg border border-slate-200">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-600 uppercase text-[11px] font-semibold tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-3.5">No Dokumen</th>
                        <th class="py-3 px-3.5">SAP Entry</th>
                        <th class="py-3 px-3.5">Tanggal</th>
                        <th class="py-3 px-3.5">Pelanggan / Outlet</th>
                        <th class="py-3 px-3.5">Sales Person</th>
                        <th class="py-3 px-3.5">Subtotal</th>
                        <th class="py-3 px-3.5">Total Akhir</th>
                        <th class="py-3 px-3.5 text-center">Status SAP</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($orders as $ord)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="py-3 px-3.5 font-mono tabular-nums font-medium text-primary">#{{ $ord['doc_num'] }}</td>
                        <td class="py-3 px-3.5 font-mono tabular-nums text-slate-500">{{ $ord['sap_doc_entry'] }}</td>
                        <td class="py-3 px-3.5 text-slate-600 font-mono tabular-nums">{{ $ord['doc_date'] }}</td>
                        <td class="py-3 px-3.5 font-medium text-slate-900">{{ $ord['card_name'] }}</td>
                        <td class="py-3 px-3.5 text-slate-700">{{ $ord['slp_name'] }}</td>
                        <td class="py-3 px-3.5 font-mono tabular-nums">Rp {{ number_format($ord['subtotal'], 0, ',', '.') }}</td>
                        <td class="py-3 px-3.5 font-medium text-primary font-mono tabular-nums">Rp {{ number_format($ord['doc_total'], 0, ',', '.') }}</td>
                        <td class="py-3 px-3.5 text-center">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium bg-primary-50 text-primary-700 border border-primary-200">
                                <i class="mdi mdi-check-circle-outline mr-1"></i> {{ $ord['sap_status'] }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
