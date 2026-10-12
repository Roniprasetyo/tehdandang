@extends('layouts.app')

@section('title', 'Direktori Tenaga Penjual')

@section('content')
<div class="space-y-6">

    <!-- Header & Aksi Utama -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-xl border border-slate-200/90 shadow-xs">
        <div>
            <h1 class="text-xl font-semibold text-slate-900">Direktori Tenaga Penjual</h1>
            <p class="text-xs text-slate-500 mt-1">Data profil salesman, pemetaan SlpCode SAP Business One, dan target pencapaian MTD</p>
        </div>
        <div class="flex items-center gap-2">
            <button 
                type="button" 
                @click="notify('Data direktori sales berhasil diekspor ke Excel.', 'success')" 
                class="btn-secondary-outline"
            >
                <i class="mdi mdi-download text-base"></i>
                <span>Ekspor</span>
            </button>
            <button 
                type="button" 
                @click="notify('Pilih berkas Excel untuk impor pembaharuan data sales.', 'info')" 
                class="btn-secondary-outline"
            >
                <i class="mdi mdi-upload text-base"></i>
                <span>Impor</span>
            </button>
            @if(in_array($authUser['role'], ['Admin Pusat', 'IT', 'Admin Area', 'Manager', 'ASM']))
            <button 
                type="button" 
                @click="notify('Formulir registrasi tenaga penjual baru siap diisi.', 'info')" 
                class="btn-primary"
            >
                <i class="mdi mdi-account-plus text-base"></i>
                <span>Tambah Sales</span>
            </button>
            @endif
        </div>
    </div>

    <!-- 4 Ringkasan Metrik Konsisten -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white border border-slate-200/90 rounded-xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-xs font-medium text-slate-500 block">Total Tenaga Penjual</span>
                <span class="text-2xl font-semibold font-mono tabular-nums text-slate-900 mt-1 block">{{ count($salesList) }}</span>
                <span class="text-xs text-slate-500 mt-1 block">Aktif di 4 wilayah regional</span>
            </div>
            <div class="w-9 h-9 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center text-lg flex-shrink-0">
                <i class="mdi mdi-account-group-outline"></i>
            </div>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-xs font-medium text-slate-500 block">Pencapaian Tertinggi</span>
                <span class="text-2xl font-semibold font-mono tabular-nums text-primary mt-1 block">115.0%</span>
                <span class="text-xs text-slate-500 mt-1 block">Eko Prasetyo (Cepogo)</span>
            </div>
            <div class="w-9 h-9 rounded-lg bg-primary/10 text-primary flex items-center justify-center text-lg flex-shrink-0">
                <i class="mdi mdi-trophy-outline"></i>
            </div>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-xs font-medium text-slate-500 block">Rata-rata Pencapaian</span>
                <span class="text-2xl font-semibold font-mono tabular-nums text-secondary mt-1 block">89.8%</span>
                <span class="text-xs text-slate-500 mt-1 block">Target kuota MTD</span>
            </div>
            <div class="w-9 h-9 rounded-lg bg-secondary/10 text-secondary flex items-center justify-center text-lg flex-shrink-0">
                <i class="mdi mdi-chart-line"></i>
            </div>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-xs font-medium text-slate-500 block">Cakupan Outlet Aktif</span>
                <span class="text-2xl font-semibold font-mono tabular-nums text-accent mt-1 block">92.4%</span>
                <span class="text-xs text-slate-500 mt-1 block">Cakupan repeat order</span>
            </div>
            <div class="w-9 h-9 rounded-lg bg-accent/10 text-accent flex items-center justify-center text-lg flex-shrink-0">
                <i class="mdi mdi-storefront-outline"></i>
            </div>
        </div>
    </div>

    <!-- Tabel Data Tenaga Penjual -->
    <div class="bg-white border border-slate-200/90 rounded-xl shadow-xs overflow-hidden">
        
        <!-- Filter & Pencarian -->
        <form action="{{ route('master.sales') }}" method="GET" class="p-4 border-b border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3">
            <h2 class="text-sm font-semibold text-slate-900 flex-shrink-0">Daftar Tenaga Penjual</h2>

            <div class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
                <div class="relative flex-1 sm:w-64">
                    <i class="mdi mdi-magnify text-slate-400 text-base absolute left-3 top-1/2 -translate-y-1/2"></i>
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Cari nama, NPK, atau area..." 
                        class="w-full bg-slate-50 border border-slate-200 text-xs rounded-lg pl-9 pr-3 py-2 text-slate-800 placeholder-slate-400 focus:outline-none focus:border-primary focus:bg-white transition-colors"
                    >
                </div>

                <select name="area" onchange="this.form.submit()" class="bg-slate-50 border border-slate-200 text-xs text-slate-700 rounded-lg px-3 py-2 focus:outline-none focus:border-primary">
                    <option value="">Semua Wilayah Area</option>
                    <option value="Bandung" {{ request('area') === 'Bandung' ? 'selected' : '' }}>Bandung</option>
                    <option value="Cirebon" {{ request('area') === 'Cirebon' ? 'selected' : '' }}>Cirebon</option>
                    <option value="Jakarta" {{ request('area') === 'Jakarta' ? 'selected' : '' }}>Jakarta</option>
                    <option value="Bogor" {{ request('area') === 'Bogor' ? 'selected' : '' }}>Bogor</option>
                    <option value="Solo Raya" {{ request('area') === 'Solo Raya' ? 'selected' : '' }}>Solo Raya</option>
                    <option value="Cepogo" {{ request('area') === 'Cepogo' ? 'selected' : '' }}>Cepogo</option>
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
                        <th class="py-2.5 px-4">NPK & KODE SAP</th>
                        <th class="py-2.5 px-4">NAMA SALES</th>
                        <th class="py-2.5 px-4">WILAYAH OPERASIONAL</th>
                        <th class="py-2.5 px-4">TARGET PENJUALAN</th>
                        <th class="py-2.5 px-4">REALISASI</th>
                        <th class="py-2.5 px-4 text-center">PENCAPAIAN</th>
                        <th class="py-2.5 px-4 text-center">STATUS</th>
                        <th class="py-2.5 px-4 text-right">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($salesList as $s)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="py-3 px-4">
                            <input type="checkbox" class="rounded border-slate-300 text-primary focus:ring-primary">
                        </td>
                        <td class="py-3 px-4">
                            <div class="font-mono tabular-nums font-semibold text-slate-900">{{ $s['npk'] }}</div>
                            <div class="font-mono tabular-nums text-slate-400 text-[11px]">SlpCode: {{ $s['slp_code'] }}</div>
                        </td>
                        <td class="py-3 px-4">
                            <div class="font-semibold text-slate-900">{{ $s['name'] }}</div>
                            <div class="font-mono tabular-nums text-slate-400 text-[11px]">{{ $s['phone'] }}</div>
                        </td>
                        <td class="py-3 px-4">
                            <div class="font-medium text-slate-800">{{ $s['area'] }}</div>
                            <div class="text-slate-400 text-[11px]">{{ $s['region'] }}</div>
                        </td>
                        <td class="py-3 px-4 font-mono tabular-nums text-slate-600">
                            Rp {{ number_format($s['target'], 0, ',', '.') }}
                        </td>
                        <td class="py-3 px-4 font-mono tabular-nums font-semibold text-slate-900">
                            Rp {{ number_format($s['actual'], 0, ',', '.') }}
                        </td>
                        <td class="py-3 px-4 text-center">
                            <div class="font-mono tabular-nums font-semibold {{ $s['achievement'] >= 100 ? 'text-primary' : ($s['achievement'] >= 85 ? 'text-secondary' : 'text-rose-600') }}">
                                {{ number_format($s['achievement'], 1, ',', '.') }}%
                            </div>
                            <div class="w-16 bg-slate-100 h-1 rounded-full mx-auto mt-1 overflow-hidden">
                                <div class="h-full rounded-full {{ $s['achievement'] >= 100 ? 'bg-primary' : ($s['achievement'] >= 85 ? 'bg-secondary' : 'bg-rose-500') }}" style="width: {{ min(100, $s['achievement']) }}%"></div>
                            </div>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium border {{ $s['status'] === 'Active' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-slate-100 text-slate-600 border-slate-200' }}">
                                {{ $s['status'] === 'Active' ? 'Aktif' : 'Non-Aktif' }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-right space-x-1">
                            <a 
                                href="{{ route('master.sales.detail', $s['npk']) }}" 
                                class="p-1.5 text-slate-500 hover:text-primary hover:bg-slate-100 rounded-md inline-block transition-colors"
                                title="Lihat Profil Sales"
                            >
                                <i class="mdi mdi-eye-outline text-base"></i>
                            </a>
                            <button 
                                type="button" 
                                @click="notify('Data salesman {{ $s['name'] }} dibuka untuk penyuntingan.', 'info')" 
                                class="p-1.5 text-slate-500 hover:text-slate-800 hover:bg-slate-100 rounded-md transition-colors"
                                title="Edit Data"
                            >
                                <i class="mdi mdi-pencil-outline text-base"></i>
                            </button>
                            <button 
                                type="button" 
                                @click="notify('Penghapusan salesman {{ $s['name'] }} memerlukan otorisasi GM.', 'warning')" 
                                class="p-1.5 text-slate-500 hover:text-rose-600 hover:bg-rose-50 rounded-md transition-colors"
                                title="Hapus Sales"
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
            <span>Menampilkan {{ number_format(count($salesList), 0, ',', '.') }} tenaga penjual</span>
            <div class="flex items-center gap-1 font-mono tabular-nums">
                <button class="px-3 py-1 bg-white border border-slate-200 rounded-md text-slate-400 cursor-not-allowed">Sebelumnya</button>
                <button class="px-3 py-1 bg-primary text-white font-medium rounded-md">1</button>
                <button class="px-3 py-1 bg-white border border-slate-200 rounded-md text-slate-600 hover:bg-slate-50">Berikutnya</button>
            </div>
        </div>

    </div>

</div>
@endsection
