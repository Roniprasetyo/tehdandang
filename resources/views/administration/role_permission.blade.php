@extends('layouts.app')

@section('title', 'Matriks Peran & Hak Akses Final - 46 Task Sistem')

@section('content')
<div class="space-y-6" x-data="roleMatrixManager(@js($tasks))">

    <!-- Header Banner -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/90 shadow-xs">
        <div>
            @include('partials.breadcrumb')
            <h1 class="text-xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                <i class="mdi mdi-shield-account-variant-outline text-primary text-2xl"></i>
                <span>Matriks Otorisasi Akses & 6 Peran Final Sistem</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">Standarisasi hak akses operasional (V, CRUD, CE, VA) untuk 46 Task Aplikasi PT. Kartini Teh Dandang SFA</p>
        </div>

        <!-- Quick Summary Stats Pills -->
        <div class="flex flex-wrap items-center gap-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-purple-50 text-purple-800 border border-purple-200 text-xs font-semibold">
                <i class="mdi mdi-account-group text-base text-purple-600"></i>
                <span>6 Role Final</span>
            </span>
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-800 border border-emerald-200 text-xs font-semibold">
                <i class="mdi mdi-database-cog text-base text-emerald-600"></i>
                <span>18 Master</span>
            </span>
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-amber-50 text-amber-800 border border-amber-200 text-xs font-semibold">
                <i class="mdi mdi-swap-horizontal-bold text-base text-amber-600"></i>
                <span>22 Transaksi</span>
            </span>
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-sky-50 text-sky-800 border border-sky-200 text-xs font-semibold">
                <i class="mdi mdi-view-dashboard-variant text-base text-sky-600"></i>
                <span>6 Dashboard</span>
            </span>
        </div>
    </div>

    <!-- 3 Lapisan Pengamanan Banner (Security Architecture) -->
    <div class="bg-gradient-to-r from-emerald-50/80 via-white to-sky-50/80 border border-slate-200/90 rounded-2xl p-4 shadow-xs">
        <div class="flex items-center gap-2 mb-2">
            <div class="w-6 h-6 rounded-lg bg-primary text-white flex items-center justify-center text-xs font-bold">
                <i class="mdi mdi-layers-triple"></i>
            </div>
            <h2 class="text-xs font-bold text-slate-900 uppercase tracking-wider">3 Lapisan Pengamanan Implementasi Hak Akses</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 text-xs">
            <div class="bg-white/90 p-3 rounded-xl border border-slate-200/70">
                <span class="font-bold text-primary block mb-0.5">1. Hak Akses Menu</span>
                <p class="text-slate-600 text-[11px] leading-relaxed">Menentukan apakah role diizinkan membuka menu navigasi di antarmuka sistem.</p>
            </div>
            <div class="bg-white/90 p-3 rounded-xl border border-slate-200/70">
                <span class="font-bold text-amber-700 block mb-0.5">2. Hak Akses Aksi (Action Type)</span>
                <p class="text-slate-600 text-[11px] leading-relaxed">Memvalidasi izin operasi spesifik: Melihat (<strong class="text-sky-700">V</strong>), Input/Koreksi (<strong class="text-emerald-700">CE</strong>), Persetujuan (<strong class="text-amber-700">VA</strong>), atau Kelola Penuh (<strong class="text-purple-700">CRUD</strong>).</p>
            </div>
            <div class="bg-white/90 p-3 rounded-xl border border-slate-200/70">
                <span class="font-bold text-sky-700 block mb-0.5">3. Hak Akses Data (Data Scope)</span>
                <p class="text-slate-600 text-[11px] leading-relaxed">Partisi data ketat: Sales (Data Sendiri), ASM (Area Binaan), RSM (Regional), GM & Owner (Nasional), Admin (Sistem).</p>
            </div>
        </div>
    </div>

    <!-- Action Legend Toolbar -->
    <div class="bg-white p-3.5 rounded-2xl border border-slate-200/90 shadow-xs flex flex-wrap items-center justify-between gap-3 text-xs">
        <span class="text-slate-500 font-semibold flex items-center gap-1.5 text-[11px] uppercase tracking-wider">
            <i class="mdi mdi-information-outline text-base text-slate-400"></i>
            <span>Legenda Hak Akses Aksi:</span>
        </span>
        <div class="flex flex-wrap items-center gap-2">
            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-purple-50 text-purple-800 border border-purple-200 font-mono font-bold text-[11px]">
                <span>CRUD</span> <span class="font-sans font-normal text-slate-500 text-[10px]">= Kelola Penuh (Create, Read, Update, Delete)</span>
            </span>
            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-amber-50 text-amber-800 border border-amber-200 font-mono font-bold text-[11px]">
                <span>VA</span> <span class="font-sans font-normal text-slate-500 text-[10px]">= View & Approve (Melihat & Menyetujui)</span>
            </span>
            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-800 border border-emerald-200 font-mono font-bold text-[11px]">
                <span>CE</span> <span class="font-sans font-normal text-slate-500 text-[10px]">= Create & Edit (Pencatatan & Edit)</span>
            </span>
            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-sky-50 text-sky-800 border border-sky-200 font-mono font-bold text-[11px]">
                <span>V</span> <span class="font-sans font-normal text-slate-500 text-[10px]">= View Only (Melihat Saja)</span>
            </span>
            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-slate-100 text-slate-600 border border-slate-200 font-mono font-bold text-[11px]">
                <span>—</span> <span class="font-sans font-normal text-slate-500 text-[10px]">= Tanpa Akses</span>
            </span>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="flex items-center gap-2 border-b border-slate-200 pb-2">
        <button 
            type="button" 
            @click="activeTab = 'matrix'" 
            class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2 cursor-pointer active:translate-y-px"
            :class="activeTab === 'matrix' ? 'bg-primary text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100'"
        >
            <i class="mdi mdi-table-large text-base"></i>
            <span>Matriks Otorisasi 46 Task x 6 Role</span>
            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold" :class="activeTab === 'matrix' ? 'bg-white/25 text-white' : 'bg-slate-200 text-slate-700'">46 Task</span>
        </button>

        <button 
            type="button" 
            @click="activeTab = 'roles'" 
            class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2 cursor-pointer active:translate-y-px"
            :class="activeTab === 'roles' ? 'bg-primary text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100'"
        >
            <i class="mdi mdi-account-tie text-base"></i>
            <span>Daftar 6 Role Final & Tanggung Jawab Utama</span>
            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold" :class="activeTab === 'roles' ? 'bg-white/25 text-white' : 'bg-slate-200 text-slate-700'">6 Role</span>
        </button>
    </div>

    <!-- TAB 1: MATRIKS 46 TASK x 6 ROLE -->
    <div x-show="activeTab === 'matrix'" class="space-y-4">
        
        <!-- Filter and Search Toolbar -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200/90 shadow-xs flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            
            <!-- Category Pills Filter -->
            <div class="flex flex-wrap items-center gap-1.5">
                <button 
                    type="button" 
                    @click="selectedCategory = 'All'" 
                    class="px-3 py-1.5 rounded-xl text-xs font-bold transition-all cursor-pointer active:translate-y-px"
                    :class="selectedCategory === 'All' ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                >
                    Semua Task (46)
                </button>
                <button 
                    type="button" 
                    @click="selectedCategory = 'Master Data'" 
                    class="px-3 py-1.5 rounded-xl text-xs font-bold transition-all cursor-pointer active:translate-y-px"
                    :class="selectedCategory === 'Master Data' ? 'bg-emerald-700 text-white' : 'bg-emerald-50 text-emerald-800 border border-emerald-200 hover:bg-emerald-100'"
                >
                    1. Master Data (18)
                </button>
                <button 
                    type="button" 
                    @click="selectedCategory = 'Transaksi Data'" 
                    class="px-3 py-1.5 rounded-xl text-xs font-bold transition-all cursor-pointer active:translate-y-px"
                    :class="selectedCategory === 'Transaksi Data' ? 'bg-amber-700 text-white' : 'bg-amber-50 text-amber-800 border border-amber-200 hover:bg-amber-100'"
                >
                    2. Transaksi Data (22)
                </button>
                <button 
                    type="button" 
                    @click="selectedCategory = 'Dashboard Data'" 
                    class="px-3 py-1.5 rounded-xl text-xs font-bold transition-all cursor-pointer active:translate-y-px"
                    :class="selectedCategory === 'Dashboard Data' ? 'bg-sky-700 text-white' : 'bg-sky-50 text-sky-800 border border-sky-200 hover:bg-sky-100'"
                >
                    3. Dashboard Data (6)
                </button>
            </div>

            <!-- Action Code Filter & Instant Search -->
            <div class="flex items-center gap-2">
                <select 
                    x-model="selectedAction" 
                    class="bg-slate-50 border border-slate-200 rounded-xl px-3 py-1.5 text-xs font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/20"
                >
                    <option value="All">Semua Tipe Aksi</option>
                    <option value="CRUD">Khusus CRUD</option>
                    <option value="VA">Khusus VA (View & Approve)</option>
                    <option value="CE">Khusus CE (Create & Edit)</option>
                    <option value="V">Khusus V (View)</option>
                </select>

                <div class="relative min-w-[200px] sm:min-w-[240px]">
                    <i class="mdi mdi-magnify absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                    <input 
                        type="text" 
                        x-model="searchQuery" 
                        placeholder="Cari nama task modul..." 
                        class="w-full pl-9 pr-3 py-1.5 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all"
                    >
                </div>
            </div>

        </div>

        <!-- Matriks Table -->
        <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50/90 border-b border-slate-200 text-slate-600 font-bold uppercase tracking-wider text-[11px]">
                            <th class="py-3 px-3 w-12 text-center">No</th>
                            <th class="py-3 px-4 min-w-[220px]">Task / Modul</th>
                            <th class="py-3 px-3 w-32">Kategori</th>
                            <th class="py-3 px-3 text-center w-20 bg-slate-100/50">Owner</th>
                            <th class="py-3 px-3 text-center w-20">GM</th>
                            <th class="py-3 px-3 text-center w-20 bg-slate-100/50">RSM</th>
                            <th class="py-3 px-3 text-center w-20">ASM</th>
                            <th class="py-3 px-3 text-center w-20 bg-slate-100/50">Sales</th>
                            <th class="py-3 px-3 text-center w-24 bg-purple-50/50 text-purple-900 border-l border-purple-100">Admin</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <template x-for="item in filteredTasks" :key="item.no">
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <!-- No -->
                                <td class="py-3 px-3 text-center font-mono font-bold text-slate-400" x-text="item.no"></td>

                                <!-- Task Name & Icon -->
                                <td class="py-3 px-4">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-7 h-7 rounded-lg flex items-center justify-center flex-shrink-0 text-slate-700"
                                            :class="{
                                                'bg-emerald-100 text-emerald-800': item.kategori === 'Master Data',
                                                'bg-amber-100 text-amber-800': item.kategori === 'Transaksi Data',
                                                'bg-sky-100 text-sky-800': item.kategori === 'Dashboard Data'
                                            }">
                                            <i class="mdi text-base" :class="item.icon || 'mdi-file-document-outline'"></i>
                                        </div>
                                        <div>
                                            <span class="font-bold text-slate-900 block" x-text="item.task"></span>
                                            <span class="text-[10px] text-slate-400 block line-clamp-1" x-text="item.keterangan"></span>
                                        </div>
                                    </div>
                                </td>

                                <!-- Kategori -->
                                <td class="py-3 px-3 whitespace-nowrap">
                                    <span 
                                        class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold border"
                                        :class="{
                                            'bg-emerald-50 text-emerald-700 border-emerald-200': item.kategori === 'Master Data',
                                            'bg-amber-50 text-amber-700 border-amber-200': item.kategori === 'Transaksi Data',
                                            'bg-sky-50 text-sky-700 border-sky-200': item.kategori === 'Dashboard Data'
                                        }"
                                    >
                                        <span x-text="item.kategori.replace(' Data', '')"></span>
                                    </span>
                                </td>

                                <!-- Role: Owner -->
                                <td class="py-3 px-3 text-center bg-slate-50/40">
                                    <span :class="badgeClass(item.access.Owner)" x-text="item.access.Owner"></span>
                                </td>

                                <!-- Role: GM -->
                                <td class="py-3 px-3 text-center">
                                    <span :class="badgeClass(item.access.GM)" x-text="item.access.GM"></span>
                                </td>

                                <!-- Role: RSM -->
                                <td class="py-3 px-3 text-center bg-slate-50/40">
                                    <span :class="badgeClass(item.access.RSM)" x-text="item.access.RSM"></span>
                                </td>

                                <!-- Role: ASM -->
                                <td class="py-3 px-3 text-center">
                                    <span :class="badgeClass(item.access.ASM)" x-text="item.access.ASM"></span>
                                </td>

                                <!-- Role: Sales -->
                                <td class="py-3 px-3 text-center bg-slate-50/40">
                                    <span :class="badgeClass(item.access.Sales)" x-text="item.access.Sales"></span>
                                </td>

                                <!-- Role: Admin -->
                                <td class="py-3 px-3 text-center bg-purple-50/30 border-l border-purple-100">
                                    <span :class="badgeClass(item.access.Admin)" x-text="item.access.Admin"></span>
                                </td>
                            </tr>
                        </template>

                        <!-- Empty State -->
                        <tr x-show="filteredTasks.length === 0">
                            <td colspan="9" class="py-12 text-center text-slate-400">
                                <i class="mdi mdi-clipboard-text-search-outline text-4xl block mb-2"></i>
                                <p class="text-sm font-semibold text-slate-700">Tidak ada modul yang cocok dengan kriteria pencarian</p>
                                <p class="text-xs text-slate-400 mt-0.5">Coba gunakan kata kunci lain atau reset pilihan filter</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Table Footer -->
            <div class="px-5 py-3.5 bg-slate-50/70 border-t border-slate-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 text-xs text-slate-500">
                <div>
                    Menampilkan <span class="font-bold text-slate-900 font-mono" x-text="filteredTasks.length"></span> dari 46 task modul
                </div>
                <div class="text-[11px] text-slate-400 font-mono">
                    Matriks ACL Resmi PT. Kartini Teh Dandang SFA
                </div>
            </div>
        </div>

        <!-- Catatan Penerapan Transaksi Card -->
        <div class="bg-amber-50/60 border border-amber-200/80 rounded-2xl p-4 text-xs text-amber-900 space-y-1.5">
            <h3 class="font-bold flex items-center gap-1.5 text-amber-800">
                <i class="mdi mdi-alert-circle-outline text-base"></i> Catatan Khusus Penerapan Transaksi:
            </h3>
            <ul class="list-disc list-inside space-y-1 text-[11px] text-amber-800/90 leading-relaxed pl-1">
                <li><strong>ROA (Registered Outlet Active)</strong>: Dihitung secara otomatis oleh sistem dari data pembelian outlet, bukan dibuat atau diubah manual (akses <code class="font-mono bg-amber-100 px-1 rounded">V</code> untuk seluruh peran).</li>
                <li><strong>Sinkronisasi GPS & SAP</strong>: Berjalan otomatis di latar belakang. Hak <code class="font-mono bg-amber-100 px-1 rounded">CRUD</code> Admin berarti mengelola atau memantau konfigurasi integrasi, bukan bebas mengubah data sumber transaksi.</li>
                <li><strong>VA (View & Approve)</strong>: Melihat dan memberikan persetujuan operasional; kewenangan persetujuan akhir mengikuti alur bisnis (Sales $\rightarrow$ ASM $\rightarrow$ RSM $\rightarrow$ GM).</li>
                <li><strong>Hak Admin untuk Transaksi Operasional</strong>: Dibatasi pada koreksi data administratif yang diizinkan dan tidak otomatis berarti boleh menyetujui semua transaksi komersial.</li>
            </ul>
        </div>

    </div>

    <!-- TAB 2: DAFTAR 6 ROLE FINAL & TANGGUNG JAWAB UTAMA -->
    <div x-show="activeTab === 'roles'" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($matrix as $roleKey => $meta)
            <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs space-y-4 flex flex-col justify-between hover:border-primary-300 transition-all">
                <div class="space-y-3">
                    <!-- Role Card Header -->
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center font-bold text-white shadow-xs"
                                 class="{{ $loop->iteration === 1 ? 'bg-amber-600' : ($loop->iteration === 6 ? 'bg-purple-600' : 'bg-primary') }}">
                                <span class="font-mono text-sm font-bold">{{ $loop->iteration }}</span>
                            </div>
                            <div>
                                <h2 class="text-sm font-bold text-slate-900 leading-tight">{{ $meta['title'] }}</h2>
                                <span class="text-[10px] font-mono text-primary font-semibold">Kode: {{ $meta['code'] }}</span>
                            </div>
                        </div>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-primary-50 text-primary-700 border border-primary-200 font-mono">
                            Final Active
                        </span>
                    </div>

                    <!-- Tanggung Jawab Utama -->
                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 text-xs">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Tanggung Jawab Utama</span>
                        <p class="text-slate-800 font-medium leading-relaxed">{{ $meta['responsibility'] }}</p>
                    </div>

                    <!-- Cakupan Wilayah Data (Data Scope) -->
                    <div class="space-y-1 text-xs">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Cakupan Wilayah Data (Data Scope)</span>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-sky-50 text-sky-800 border border-sky-200 text-xs font-semibold">
                            <i class="mdi mdi-map-marker-radius text-sky-600"></i>
                            {{ $meta['area_scope'] }}
                        </span>
                    </div>

                    <!-- Kewenangan Aksi Khusus -->
                    <div class="space-y-1 text-xs">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Kewenangan Aksi Khusus</span>
                        <p class="text-slate-600 text-[11px] leading-relaxed">{{ $meta['action_rights'] }}</p>
                    </div>
                </div>

                <!-- Footer Quick Action -->
                <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                    <span class="text-slate-400 text-[11px]">Simulasi Akses:</span>
                    <a href="?switch_user={{ strtolower($meta['code']) === 'sales' ? 'sales01' : (strtolower($meta['code']) === 'rsm' ? 'rsm-jabar' : (strtolower($meta['code']) === 'asm' ? 'asm-bandung' : strtolower($meta['code']))) }}" 
                       class="btn-secondary-outline text-[11px] inline-flex items-center gap-1 active:translate-y-px">
                        <i class="mdi mdi-login text-xs"></i> Masuk Sebagai {{ $meta['code'] }}
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>

@push('scripts')
<script>
function roleMatrixManager(initialTasks) {
    return {
        activeTab: 'matrix',
        selectedCategory: 'All',
        selectedAction: 'All',
        searchQuery: '',
        tasks: initialTasks || [],
        
        get filteredTasks() {
            return this.tasks.filter(t => {
                const matchCategory = this.selectedCategory === 'All' || t.kategori === this.selectedCategory;
                
                let matchAction = true;
                if (this.selectedAction !== 'All') {
                    const acts = Object.values(t.access || {});
                    matchAction = acts.includes(this.selectedAction);
                }

                const q = this.searchQuery.toLowerCase().trim();
                const matchQuery = !q || 
                    t.task.toLowerCase().includes(q) || 
                    t.keterangan.toLowerCase().includes(q) ||
                    t.kategori.toLowerCase().includes(q);

                return matchCategory && matchAction && matchQuery;
            });
        },

        badgeClass(action) {
            if (action === 'CRUD') {
                return 'px-2 py-0.5 rounded font-mono font-bold text-[10px] bg-purple-100 text-purple-800 border border-purple-200 inline-block min-w-[36px]';
            }
            if (action === 'VA') {
                return 'px-2 py-0.5 rounded font-mono font-bold text-[10px] bg-amber-100 text-amber-800 border border-amber-200 inline-block min-w-[36px]';
            }
            if (action === 'CE') {
                return 'px-2 py-0.5 rounded font-mono font-bold text-[10px] bg-emerald-100 text-emerald-800 border border-emerald-200 inline-block min-w-[36px]';
            }
            if (action === 'V') {
                return 'px-2 py-0.5 rounded font-mono font-bold text-[10px] bg-sky-100 text-sky-800 border border-sky-200 inline-block min-w-[36px]';
            }
            return 'text-slate-300 font-mono font-bold text-xs select-none';
        }
    };
}
</script>
@endpush
@endsection
