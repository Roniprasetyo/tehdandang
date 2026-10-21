@extends('layouts.app')

@section('title', 'Role & Permission Matrix - Modul Sistem')

@section('content')
<div class="space-y-6" x-data="rolePermissionManager(@js($tasks))">

    <!-- Header Banner -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/90 shadow-xs">
        <div>
            @include('partials.breadcrumb')
            <h1 class="text-xl font-bold text-slate-900 tracking-tight">Katalog Modul & Matriks Otorisasi Pengguna</h1>
            <p class="text-xs text-slate-500 mt-1">Standarisasi 46 Task Aplikasi Teh Dandang SFA terbagi atas Master Data, Transaksi Data, dan Dashboard Data</p>
        </div>

        <!-- Quick Summary Stats Pills -->
        <div class="flex flex-wrap items-center gap-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-800 border border-emerald-200 text-xs font-semibold">
                <i class="mdi mdi-database-cog text-base text-emerald-600"></i>
                <span>18 Master Data</span>
            </span>
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-amber-50 text-amber-800 border border-amber-200 text-xs font-semibold">
                <i class="mdi mdi-swap-horizontal-bold text-base text-amber-600"></i>
                <span>22 Transaksi Data</span>
            </span>
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-sky-50 text-sky-800 border border-sky-200 text-xs font-semibold">
                <i class="mdi mdi-view-dashboard-variant text-base text-sky-600"></i>
                <span>6 Dashboard Data</span>
            </span>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="flex items-center gap-2 border-b border-slate-200 pb-2">
        <button 
            type="button" 
            @click="activeTab = 'catalog'" 
            class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2 cursor-pointer active:translate-y-px"
            :class="activeTab === 'catalog' ? 'bg-primary text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100'"
        >
            <i class="mdi mdi-table-large text-base"></i>
            <span>Daftar 46 Master Task & Modul</span>
            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold" :class="activeTab === 'catalog' ? 'bg-white/25 text-white' : 'bg-slate-200 text-slate-700'">46</span>
        </button>

        <button 
            type="button" 
            @click="activeTab = 'roles'" 
            class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2 cursor-pointer active:translate-y-px"
            :class="activeTab === 'roles' ? 'bg-primary text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100'"
        >
            <i class="mdi mdi-shield-account-outline text-base"></i>
            <span>Matriks Peran Pengguna (Role Scope)</span>
            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold" :class="activeTab === 'roles' ? 'bg-white/25 text-white' : 'bg-slate-200 text-slate-700'">5 Role</span>
        </button>
    </div>

    <!-- TAB 1: DAFTAR 46 MASTER TASK & MODUL SISTEM -->
    <div x-show="activeTab === 'catalog'" class="space-y-4">
        
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
                    Semua Kategori (<span x-text="tasks.length"></span>)
                </button>
                <button 
                    type="button" 
                    @click="selectedCategory = 'Master Data'" 
                    class="px-3 py-1.5 rounded-xl text-xs font-bold transition-all cursor-pointer active:translate-y-px"
                    :class="selectedCategory === 'Master Data' ? 'bg-emerald-700 text-white' : 'bg-emerald-50 text-emerald-800 border border-emerald-200 hover:bg-emerald-100'"
                >
                    Master Data (18)
                </button>
                <button 
                    type="button" 
                    @click="selectedCategory = 'Transaksi Data'" 
                    class="px-3 py-1.5 rounded-xl text-xs font-bold transition-all cursor-pointer active:translate-y-px"
                    :class="selectedCategory === 'Transaksi Data' ? 'bg-amber-700 text-white' : 'bg-amber-50 text-amber-800 border border-amber-200 hover:bg-amber-100'"
                >
                    Transaksi Data (22)
                </button>
                <button 
                    type="button" 
                    @click="selectedCategory = 'Dashboard Data'" 
                    class="px-3 py-1.5 rounded-xl text-xs font-bold transition-all cursor-pointer active:translate-y-px"
                    :class="selectedCategory === 'Dashboard Data' ? 'bg-sky-700 text-white' : 'bg-sky-50 text-sky-800 border border-sky-200 hover:bg-sky-100'"
                >
                    Dashboard Data (6)
                </button>
            </div>

            <!-- Search & Platform Dropdown -->
            <div class="flex items-center gap-2">
                <select 
                    x-model="selectedJenis" 
                    class="bg-slate-50 border border-slate-200 rounded-xl px-3 py-1.5 text-xs font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary/20"
                >
                    <option value="All">Semua Platform</option>
                    <option value="Web">Web</option>
                    <option value="Web & Mobile">Web & Mobile</option>
                    <option value="Lainnya">Lainnya</option>
                </select>

                <div class="relative min-w-[200px] sm:min-w-[240px]">
                    <i class="mdi mdi-magnify absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                    <input 
                        type="text" 
                        x-model="searchQuery" 
                        placeholder="Cari modul atau keterangan..." 
                        class="w-full pl-9 pr-3 py-1.5 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all"
                    >
                </div>
            </div>

        </div>

        <!-- Task Table -->
        <div class="bg-white border border-slate-200/90 rounded-2xl shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-200 text-slate-500 font-bold uppercase tracking-wider text-[11px]">
                            <th class="py-3 px-4 w-12 text-center">No</th>
                            <th class="py-3 px-4 w-40">Kategori</th>
                            <th class="py-3 px-4 min-w-[220px]">Task</th>
                            <th class="py-3 px-4 w-32">Jenis Platform</th>
                            <th class="py-3 px-4 min-w-[280px]">Keterangan</th>
                            <th class="py-3 px-4 min-w-[220px]">Peran Terotorisasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <template x-for="(item, idx) in filteredTasks" :key="item.task">
                            <tr class="hover:bg-slate-50/70 transition-colors">
                                <td class="py-3 px-4 text-center font-mono font-bold text-slate-400" x-text="idx + 1"></td>
                                
                                <td class="py-3 px-4 whitespace-nowrap">
                                    <span 
                                        class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold border"
                                        :class="{
                                            'bg-emerald-50 text-emerald-700 border-emerald-200': item.kategori === 'Master Data',
                                            'bg-amber-50 text-amber-700 border-amber-200': item.kategori === 'Transaksi Data',
                                            'bg-sky-50 text-sky-700 border-sky-200': item.kategori === 'Dashboard Data'
                                        }"
                                    >
                                        <i class="mdi" :class="{
                                            'mdi-database-outline': item.kategori === 'Master Data',
                                            'mdi-swap-horizontal': item.kategori === 'Transaksi Data',
                                            'mdi-chart-bar': item.kategori === 'Dashboard Data'
                                        }"></i>
                                        <span x-text="item.kategori"></span>
                                    </span>
                                </td>

                                <td class="py-3 px-4 font-semibold text-slate-900">
                                    <div class="flex items-center gap-2">
                                        <div class="w-7 h-7 rounded-lg flex items-center justify-center flex-shrink-0"
                                            :class="{
                                                'bg-emerald-100 text-emerald-800': item.kategori === 'Master Data',
                                                'bg-amber-100 text-amber-800': item.kategori === 'Transaksi Data',
                                                'bg-sky-100 text-sky-800': item.kategori === 'Dashboard Data'
                                            }">
                                            <i class="mdi text-base" :class="item.icon || 'mdi-file-document-outline'"></i>
                                        </div>
                                        <span class="font-bold text-slate-900" x-text="item.task"></span>
                                    </div>
                                </td>

                                <td class="py-3 px-4 whitespace-nowrap">
                                    <span 
                                        class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[10px] font-bold border font-mono"
                                        :class="{
                                            'bg-slate-100 text-slate-700 border-slate-200': item.jenis === 'Web',
                                            'bg-blue-50 text-blue-700 border-blue-200': item.jenis === 'Web & Mobile',
                                            'bg-purple-50 text-purple-700 border-purple-200': item.jenis === 'Lainnya'
                                        }"
                                    >
                                        <i class="mdi" :class="{
                                            'mdi-monitor': item.jenis === 'Web',
                                            'mdi-cellphone-link': item.jenis === 'Web & Mobile',
                                            'mdi-cloud-cog-outline': item.jenis === 'Lainnya'
                                        }"></i>
                                        <span x-text="item.jenis"></span>
                                    </span>
                                </td>

                                <td class="py-3 px-4 text-slate-600 leading-relaxed" x-text="item.keterangan"></td>

                                <td class="py-3 px-4">
                                    <div class="flex flex-wrap gap-1 max-w-sm">
                                        <template x-for="r in item.roles" :key="r">
                                            <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-700 border border-slate-200 text-[10px] font-semibold" x-text="r"></span>
                                        </template>
                                    </div>
                                </td>
                            </tr>
                        </template>

                        <!-- Empty State -->
                        <tr x-show="filteredTasks.length === 0">
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                <i class="mdi mdi-clipboard-text-search-outline text-4xl block mb-2"></i>
                                <p class="text-sm font-semibold text-slate-700">Tidak ada modul yang cocok dengan kriteria pencarian</p>
                                <p class="text-xs text-slate-400 mt-0.5">Coba gunakan kata kunci lain atau reset pilihan kategori</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Table Footer -->
            <div class="px-5 py-3.5 bg-slate-50/70 border-t border-slate-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 text-xs text-slate-500">
                <div>
                    Menampilkan <span class="font-bold text-slate-900 font-mono" x-text="filteredTasks.length"></span> dari <span class="font-bold text-slate-900 font-mono" x-text="tasks.length"></span> task terdaftar
                </div>
                <div class="text-[11px] text-slate-400">
                    Standar Arsitektur PT. Kartini Teh Dandang SFA
                </div>
            </div>
        </div>

    </div>

    <!-- TAB 2: MATRIKS PERAN & CAKUPAN DATA (ROLE SCOPE) -->
    <div x-show="activeTab === 'roles'" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($matrix as $roleName => $meta)
            <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs space-y-3.5 flex flex-col justify-between hover:border-primary-200 transition-colors">
                <div class="space-y-3">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                        <h2 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                            <div class="w-8 h-8 rounded-xl bg-primary-50 text-primary flex items-center justify-center font-bold">
                                <i class="mdi mdi-shield-account text-lg"></i>
                            </div>
                            <span>{{ $roleName }}</span>
                        </h2>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-primary-50 text-primary-700 border border-primary-200 font-mono">
                            Scope Aktif
                        </span>
                    </div>

                    <p class="text-xs text-slate-500 leading-relaxed italic">
                        "{{ $meta['keterangan'] ?? 'Pengelolaan operasional peran sistem.' }}"
                    </p>

                    <div class="space-y-2.5 text-xs">
                        <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-0.5">Cakupan Wilayah Data</span>
                            <span class="text-xs font-bold text-slate-800 flex items-center gap-1.5">
                                <i class="mdi mdi-map-marker-radius text-primary"></i>
                                {{ $meta['area_scope'] ?? 'Data Sendiri' }}
                            </span>
                        </div>

                        <div>
                            <strong class="text-slate-800 font-bold block mb-1 text-[11px] flex items-center gap-1 text-sky-700">
                                <i class="mdi mdi-view-dashboard-outline"></i> Otorisasi Dashboard:
                            </strong>
                            <div class="flex flex-wrap gap-1">
                                @foreach($meta['dashboard'] ?? [] as $dItem)
                                <span class="px-2 py-0.5 rounded-md bg-sky-50 text-sky-700 border border-sky-200 text-[10px] font-semibold">{{ $dItem }}</span>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <strong class="text-slate-800 font-bold block mb-1 text-[11px] flex items-center gap-1 text-emerald-700">
                                <i class="mdi mdi-database-outline"></i> Otorisasi Master Data:
                            </strong>
                            <div class="flex flex-wrap gap-1">
                                @foreach($meta['master'] ?? [] as $mItem)
                                <span class="px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-800 border border-emerald-200 text-[10px] font-medium">{{ $mItem }}</span>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <strong class="text-slate-800 font-bold block mb-1 text-[11px] flex items-center gap-1 text-amber-700">
                                <i class="mdi mdi-swap-horizontal"></i> Otorisasi Transaksi Data:
                            </strong>
                            <div class="flex flex-wrap gap-1">
                                @foreach($meta['transaksi'] ?? [] as $tItem)
                                <span class="px-2 py-0.5 rounded-md bg-amber-50 text-amber-800 border border-amber-200 text-[10px] font-semibold">{{ $tItem }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-[11px]">
                    <span class="text-slate-400 font-medium">Status Hak Akses:</span>
                    <span class="text-emerald-700 font-bold flex items-center gap-1">
                        <i class="mdi mdi-check-decagram text-xs"></i> Terotorisasi Penuh
                    </span>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>

@push('scripts')
<script>
function rolePermissionManager(initialTasks) {
    return {
        activeTab: 'catalog',
        selectedCategory: 'All',
        selectedJenis: 'All',
        searchQuery: '',
        tasks: initialTasks || [],
        
        get filteredTasks() {
            return this.tasks.filter(t => {
                const matchCategory = this.selectedCategory === 'All' || t.kategori === this.selectedCategory;
                const matchJenis = this.selectedJenis === 'All' || t.jenis === this.selectedJenis;
                const q = this.searchQuery.toLowerCase().trim();
                const matchQuery = !q || 
                    t.task.toLowerCase().includes(q) || 
                    t.keterangan.toLowerCase().includes(q) ||
                    t.kategori.toLowerCase().includes(q);
                return matchCategory && matchJenis && matchQuery;
            });
        }
    };
}
</script>
@endpush
@endsection
