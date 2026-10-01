@extends('layouts.app')

@section('title', 'Sales Order (SAP B1 Form)')

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

    <!-- Top Header & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold font-display text-slate-900">Sales Order Management (SAP B1 Form)</h1>
            <p class="text-xs text-slate-500 mt-0.5">Input order penjualan dengan skema field dan struktur ORDR / RDR1 SAP Business One</p>
        </div>
        <div class="flex items-center gap-2">
            <button @click="alert('Export Sales Orders (CSV/Excel)')" class="px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 text-xs font-semibold hover:bg-slate-50 shadow-xs flex items-center gap-1.5">
                <i data-lucide="download" class="w-4 h-4 text-slate-500"></i> Export
            </button>
            <button @click="showForm = !showForm" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-md shadow-indigo-200 flex items-center gap-1.5">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span x-text="showForm ? 'Close Form' : '+ New Sales Order'">+ New Sales Order</span>
            </button>
        </div>
    </div>

    <!-- SAP-style Sales Order Entry Form (Clean White Container) -->
    <div x-show="showForm" x-cloak class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-sm space-y-6">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <div>
                <span class="text-[10px] text-indigo-600 font-bold uppercase tracking-widest">SAP B1 ORDR Header</span>
                <h3 class="text-sm font-bold text-slate-900">Entry Sales Order — Standard SAP Matrix</h3>
            </div>
            <span class="px-3 py-1 rounded-full bg-indigo-50 text-indigo-700 border border-indigo-200 text-xs font-mono font-bold">ORDR/RDR1 Ready</span>
        </div>

        <!-- Header Fields -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-xs">
            <div>
                <label class="block text-slate-600 mb-1 font-semibold">Customer (CardCode / CardName):</label>
                <select x-model="selectedCustomer" required class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl p-2.5 focus:outline-none focus:border-indigo-500">
                    <option value="">-- Select Customer --</option>
                    @foreach($outlets as $o)
                    <option value="{{ $o['card_code'] }}">{{ $o['card_code'] }} - {{ $o['card_name'] }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-slate-600 mb-1 font-semibold">Sales Employee (SlpCode):</label>
                <select class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl p-2.5 focus:outline-none focus:border-indigo-500">
                    @foreach($salesList as $s)
                    <option value="{{ $s['slp_code'] }}">{{ $s['name'] }} (SlpCode: {{ $s['slp_code'] }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-slate-600 mb-1 font-semibold">Document Date (DocDate):</label>
                <input type="date" value="{{ date('Y-m-d') }}" class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl p-2.5">
            </div>

            <div>
                <label class="block text-slate-600 mb-1 font-semibold">Delivery Date (DocDueDate):</label>
                <input type="date" value="{{ date('Y-m-d', strtotime('+2 days')) }}" class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl p-2.5">
            </div>
        </div>

        <!-- Item Lines Table (RDR1 Matrix) -->
        <div class="space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-700 uppercase tracking-wider">Item Lines (RDR1 Detail Matrix):</span>
                <button type="button" @click="addItem()" class="px-3 py-1.5 rounded-xl bg-indigo-50 text-indigo-600 hover:bg-indigo-100 text-xs font-bold border border-indigo-200 flex items-center gap-1">
                    <i data-lucide="plus" class="w-3.5 h-3.5"></i> Add Item Line
                </button>
            </div>

            <div class="overflow-x-auto border border-slate-200 rounded-xl bg-slate-50">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-white text-slate-500 uppercase text-[10px] border-b border-slate-200">
                        <tr>
                            <th class="py-2.5 px-3">Item Code</th>
                            <th class="py-2.5 px-3">Item Description</th>
                            <th class="py-2.5 px-3 w-20">Qty</th>
                            <th class="py-2.5 px-3 w-20">UoM</th>
                            <th class="py-2.5 px-3">Price</th>
                            <th class="py-2.5 px-3 w-20">Disc %</th>
                            <th class="py-2.5 px-3">Line Total</th>
                            <th class="py-2.5 px-3 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200/80">
                        <template x-for="(item, index) in items" :key="index">
                            <tr>
                                <td class="py-2 px-3">
                                    <input type="text" x-model="item.item_code" class="w-full bg-white border border-slate-200 rounded-lg p-1.5 font-mono text-indigo-600 font-bold">
                                </td>
                                <td class="py-2 px-3">
                                    <input type="text" x-model="item.name" class="w-full bg-white border border-slate-200 rounded-lg p-1.5 font-bold text-slate-900">
                                </td>
                                <td class="py-2 px-3">
                                    <input type="number" x-model.number="item.qty" class="w-full bg-white border border-slate-200 rounded-lg p-1.5 text-center">
                                </td>
                                <td class="py-2 px-3">
                                    <input type="text" x-model="item.uom" class="w-full bg-white border border-slate-200 rounded-lg p-1.5 text-center">
                                </td>
                                <td class="py-2 px-3">
                                    <input type="number" x-model.number="item.price" class="w-full bg-white border border-slate-200 rounded-lg p-1.5">
                                </td>
                                <td class="py-2 px-3">
                                    <input type="number" x-model.number="item.discount" class="w-full bg-white border border-slate-200 rounded-lg p-1.5 text-center">
                                </td>
                                <td class="py-2 px-3 font-bold text-emerald-600">
                                    Rp <span x-text="Math.round(item.qty * item.price * (1 - item.discount/100)).toLocaleString('id-ID')"></span>
                                </td>
                                <td class="py-2 px-3 text-center">
                                    <button type="button" @click="removeItem(index)" class="text-rose-600 hover:text-rose-700">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
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
                <span class="block font-semibold">SAP B1 Mapping Status: <strong class="text-emerald-600">Ready for SAP API POST /ORDR</strong></span>
                <span class="block text-[11px]">Subtotal, Discount, & Tax calculated automatically.</span>
            </div>
            <div class="w-64 space-y-1.5 bg-slate-50 p-4 rounded-xl border border-slate-200/80">
                <div class="flex justify-between">
                    <span class="text-slate-500">Subtotal:</span>
                    <span class="font-bold text-slate-900">Rp <span x-text="Math.round(getSubtotal()).toLocaleString('id-ID')"></span></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Tax (PPN 11%):</span>
                    <span class="font-bold text-slate-700">Rp <span x-text="Math.round(getSubtotal() * 0.11).toLocaleString('id-ID')"></span></span>
                </div>
                <div class="flex justify-between border-t border-slate-200 pt-2 text-sm">
                    <span class="font-bold text-indigo-600">Grand Total:</span>
                    <span class="font-bold text-indigo-600">Rp <span x-text="Math.round(getSubtotal() * 1.11).toLocaleString('id-ID')"></span></span>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-2 pt-2">
            <button type="button" @click="showForm = false" class="px-4 py-2 bg-white border border-slate-200 text-slate-700 rounded-xl hover:bg-slate-50 text-xs font-semibold">Cancel</button>
            <button type="button" @click="alert('Sales Order created & synced to SAP B1!'); showForm = false" class="px-5 py-2 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 text-xs shadow-md shadow-indigo-200">
                Save & Sync SAP B1
            </button>
        </div>
    </div>

    <!-- Orders List Container -->
    <div class="bg-white border border-slate-200/80 rounded-2xl shadow-xs p-5">
        <h3 class="text-sm font-bold text-slate-900 mb-4">Daftar Transaksi Sales Order (ORDR Document List)</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-4">DOCNUM</th>
                        <th class="py-3 px-4">SAP ENTRY</th>
                        <th class="py-3 px-4">DOCDATE</th>
                        <th class="py-3 px-4">CUSTOMER</th>
                        <th class="py-3 px-4">SALES PERSON</th>
                        <th class="py-3 px-4">SUBTOTAL</th>
                        <th class="py-3 px-4">GRAND TOTAL</th>
                        <th class="py-3 px-4 text-center">SAP STATUS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($orders as $ord)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="py-3 px-4 font-mono font-bold text-indigo-600">#{{ $ord['doc_num'] }}</td>
                        <td class="py-3 px-4 font-mono text-slate-500">{{ $ord['sap_doc_entry'] }}</td>
                        <td class="py-3 px-4 text-slate-600">{{ $ord['doc_date'] }}</td>
                        <td class="py-3 px-4 font-bold text-slate-900">{{ $ord['card_name'] }}</td>
                        <td class="py-3 px-4 text-slate-700">{{ $ord['slp_name'] }}</td>
                        <td class="py-3 px-4">Rp {{ number_format($ord['subtotal'], 0, ',', '.') }}</td>
                        <td class="py-3 px-4 font-bold text-emerald-600">Rp {{ number_format($ord['doc_total'], 0, ',', '.') }}</td>
                        <td class="py-3 px-4 text-center">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                {{ $ord['sap_status'] }}
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
