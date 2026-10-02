@extends('layouts.app')

@section('title', 'NOP (New Open Product) Tracking')

@section('content')
<div class="space-y-6" x-data="nopApp()">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
        <div>
            <div class="flex items-center space-x-2 text-xs text-slate-400 mb-1 font-medium">
                <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 transition-colors">Beranda</a>
                <span>/</span>
                <span>Transaksi</span>
                <span>/</span>
                <span class="text-indigo-600 font-semibold">NOP Tracking</span>
            </div>
            <h1 class="text-xl font-bold font-display text-slate-900 flex items-center gap-2">
                <i data-lucide="box" class="w-5 h-5 text-indigo-600"></i> NOP (New Open Product) Expansion Tracking
            </h1>
            <p class="text-xs text-slate-500 mt-0.5">Penambahan varian SKU Teh Dandang baru yang berhasil masuk ke outlet existing (Before vs After Expansion)</p>
        </div>
        <div class="flex items-center gap-2">
            <button 
                @click="openAddModal = true"
                class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-md shadow-indigo-200 flex items-center gap-2 transition-all">
                <i data-lucide="plus-circle" class="w-4 h-4"></i> Tambah NOP SKU Baru
            </button>
        </div>
    </div>

    <!-- 3 Summary Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white border border-slate-200/80 rounded-2xl p-4 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[10px] font-bold uppercase text-slate-400 block">TOTAL NOP EXPANSIONS</span>
                <span class="text-2xl font-bold text-slate-900 mt-1 block">{{ count($nop) }} Outlet SKU</span>
                <span class="text-[10px] text-emerald-600 font-semibold">+18% MTD SKU Penetration</span>
            </div>
            <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                <i data-lucide="trending-up" class="w-5 h-5"></i>
            </div>
        </div>

        <div class="bg-white border border-slate-200/80 rounded-2xl p-4 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[10px] font-bold uppercase text-slate-400 block">TOP NEW SKU ITEM</span>
                <span class="text-xl font-bold text-indigo-600 mt-1 block">Teh Dandang Merah</span>
                <span class="text-[10px] text-slate-500 font-semibold">Code: DM001 (18 Outlets)</span>
            </div>
            <div class="w-11 h-11 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold">
                <i data-lucide="package-check" class="w-5 h-5"></i>
            </div>
        </div>

        <div class="bg-white border border-slate-200/80 rounded-2xl p-4 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[10px] font-bold uppercase text-slate-400 block">AVG SKU PER OUTLET</span>
                <span class="text-2xl font-bold text-purple-600 mt-1 block">2.8 Varian SKU</span>
                <span class="text-[10px] text-purple-600 font-semibold">Naik dari 1.6 SKU/Outlet</span>
            </div>
            <div class="w-11 h-11 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center font-bold">
                <i data-lucide="layers" class="w-5 h-5"></i>
            </div>
        </div>
    </div>

    <!-- NOP Comparison Table Container -->
    <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-4">
            <h3 class="text-sm font-bold text-slate-900">Tracking Penambahan SKU Baru per Outlet (Before vs After Expansion)</h3>
            
            <!-- Search & Filter Input -->
            <div class="relative w-full sm:w-72">
                <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                <input 
                    type="text" 
                    x-model="searchQuery" 
                    placeholder="Cari outlet, sales, atau SKU..." 
                    class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3.5 px-4">CARD CODE</th>
                        <th class="py-3.5 px-4">OUTLET NAME</th>
                        <th class="py-3.5 px-4">SALES ASSIGNED</th>
                        <th class="py-3.5 px-4">BEFORE PRODUCTS</th>
                        <th class="py-3.5 px-4">AFTER PRODUCTS</th>
                        <th class="py-3.5 px-4">NEW NOP ITEM</th>
                        <th class="py-3.5 px-4">DATE ADDED</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <template x-for="np in filteredNop" :key="np.card_code + np.item_code">
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-3.5 px-4 font-mono font-bold text-indigo-600" x-text="np.card_code"></td>
                            <td class="py-3.5 px-4 font-bold text-slate-900" x-text="np.outlet_name"></td>
                            <td class="py-3.5 px-4 text-slate-700 font-medium" x-text="np.sales_name"></td>
                            <td class="py-3.5 px-4 text-slate-500">
                                <span x-text="Array.isArray(np.before_products) ? np.before_products.join(', ') : np.before_products"></span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-800 font-medium">
                                <span x-text="Array.isArray(np.after_products) ? np.after_products.join(', ') : np.after_products"></span>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-800 font-bold border border-emerald-200 shadow-2xs">
                                    <span>✨</span>
                                    <span x-text="np.nop_item + ' (' + np.item_code + ')'"></span>
                                </span>
                            </td>
                            <td class="py-3.5 px-4 font-mono text-slate-500" x-text="np.date_added"></td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL TAMBAH NOP SKU BARU -->
    <div x-show="openAddModal" x-cloak class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs z-[500] flex items-center justify-center p-4">
        <div @click.outside="openAddModal = false" class="bg-white rounded-2xl border border-slate-200 shadow-2xl max-w-lg w-full p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div class="flex items-center gap-2">
                    <i data-lucide="box" class="w-5 h-5 text-indigo-600"></i>
                    <h3 class="text-base font-bold text-slate-900">Form Penambahan NOP SKU Baru</h3>
                </div>
                <button @click="openAddModal = false" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form @submit.prevent="submitNop()" class="space-y-3 text-xs">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Pilih Outlet (SAP OCRD):</label>
                    <select x-model="form.card_code" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl font-semibold text-slate-800 focus:outline-none focus:border-indigo-500">
                        <option value="C10001">C10001 - Toko Berkah Utama (Bandung)</option>
                        <option value="C10002">C10002 - Warung Makan Resto Bundo (Cirebon)</option>
                        <option value="C10005">C10005 - Supermarket Grand City (Jakarta)</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Pilih Varian SKU Baru (SAP OITM):</label>
                    <select x-model="form.item_code" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl font-semibold text-indigo-600 focus:outline-none focus:border-indigo-500">
                        <option value="DM001">DM001 - Teh Dandang Merah</option>
                        <option value="DJ001">DJ001 - Teh Dandang Jasmine Box</option>
                        <option value="DH002">DH002 - Teh Dandang Hijau Celup</option>
                        <option value="DP003">DP003 - Teh Dandang Premium Tubruk</option>
                        <option value="DV004">DV004 - Teh Dandang Vanilla Special</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Target Order Awal (Dus / Karton):</label>
                    <input type="number" value="5" min="1" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl font-mono text-slate-800">
                </div>

                <div class="p-3 bg-emerald-50 border border-emerald-100 rounded-xl text-emerald-900 space-y-1">
                    <div class="font-bold flex items-center gap-1.5">
                        <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-600"></i> Penetrasi Outlet Existing
                    </div>
                    <p class="text-[11px] text-emerald-700">Penambahan SKU ini akan secara otomatis memperbarui katalog produk di outlet terkait pada SAP Business One.</p>
                </div>

                <div class="flex justify-end gap-2 pt-2 border-t border-slate-100">
                    <button type="button" @click="openAddModal = false" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold">Batal</button>
                    <button type="submit" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold shadow-md shadow-indigo-200 flex items-center gap-1.5">
                        <i data-lucide="check" class="w-4 h-4"></i> Simpan NOP SKU
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    function nopApp() {
        return {
            nopList: @json($nop ?? []),
            searchQuery: '',
            openAddModal: false,
            form: {
                card_code: 'C10001',
                item_code: 'DM001'
            },

            get filteredNop() {
                return this.nopList.filter(n => {
                    const q = this.searchQuery.toLowerCase().trim();
                    if (!q) return true;
                    return n.card_code.toLowerCase().includes(q) ||
                           n.outlet_name.toLowerCase().includes(q) ||
                           n.sales_name.toLowerCase().includes(q) ||
                           n.nop_item.toLowerCase().includes(q);
                });
            },

            submitNop() {
                alert('Penambahan NOP SKU berhasil disimpan!');
                this.openAddModal = false;
            }
        }
    }
</script>
@endpush
