@extends('layouts.app')

@section('title', 'Outlet Management')

@section('content')
<div class="space-y-6">

    <!-- Top Header & Action Buttons -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold font-display text-slate-900 font-normal">Outlet Management</h1>
            <p class="text-xs text-slate-500 mt-0.5">Kelola direktori pelanggan, bidang SAP B1 OCRD, kanal GT/MT/HOREKA, dan status Repeat Order</p>
        </div>
        <div class="flex items-center gap-2">
            <button 
                type="button"
                @click="notify('Direktori outlet berhasil diekspor ke format Excel/CSV.', 'success')" 
                class="px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 text-xs font-semibold hover:bg-slate-50 shadow-xs flex items-center gap-1.5 transition-all active:translate-y-px"
            >
                <i class="mdi mdi-download text-slate-500 text-base"></i> Ekspor
            </button>
            <button 
                type="button"
                @click="notify('Silakan pilih berkas Excel direktori outlet untuk impor.', 'info')" 
                class="px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 text-xs font-semibold hover:bg-slate-50 shadow-xs flex items-center gap-1.5 transition-all active:translate-y-px"
            >
                <i class="mdi mdi-upload text-slate-500 text-base"></i> Impor
            </button>
            <button 
                type="button"
                @click="notify('Formulir registrasi NOO / Outlet Baru (SAP OCRD) disiapkan.', 'info')" 
                class="btn-primary text-xs flex items-center gap-1.5 active:translate-y-px"
            >
                <i class="mdi mdi-account-plus text-base"></i> Registrasi NOO Baru
            </button>
        </div>
    </div>

    <!-- 4 Summary KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">TOTAL OUTLET</span>
                <span class="text-2xl font-bold font-mono tabular-nums text-slate-900 mt-1 block">5.240</span>
                <span class="text-[11px] text-primary font-semibold">Terdaftar di SAP B1</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center">
                <i class="mdi mdi-store text-xl"></i>
            </div>
        </div>

        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">OUTLET AKTIF (ROA)</span>
                <span class="text-2xl font-bold font-mono tabular-nums text-emerald-700 mt-1 block">3.995</span>
                <span class="text-[11px] text-emerald-600 font-semibold">76.2% Coverage Aktif</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <i class="mdi mdi-check-circle-outline text-xl"></i>
            </div>
        </div>

        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">PERINGATAN RO</span>
                <span class="text-2xl font-bold font-mono tabular-nums text-secondary mt-1 block">482</span>
                <span class="text-[11px] text-secondary font-semibold">Perlu Follow-up Sales</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-secondary/10 text-secondary flex items-center justify-center">
                <i class="mdi mdi-alert-circle-outline text-xl"></i>
            </div>
        </div>

        <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">OUTLET INAKTIF</span>
                <span class="text-2xl font-bold font-mono tabular-nums text-rose-700 mt-1 block">1.245</span>
                <span class="text-[11px] text-rose-600 font-semibold">> 30 hari tanpa pesanan</span>
            </div>
            <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center">
                <i class="mdi mdi-account-off-outline text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Outlet Table Container -->
    <div class="bg-white border border-slate-200/80 rounded-2xl shadow-xs">
        
        <!-- Search & Filter Toolbar -->
        <form action="{{ route('master.outlet') }}" method="GET" class="p-4 border-b border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3">
            <h3 class="text-sm font-bold text-slate-900 flex-shrink-0 font-normal">Direktori Outlet Pelanggan</h3>

            <div class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
                <div class="relative flex-1 sm:w-64">
                    <i class="mdi mdi-magnify text-slate-400 text-base absolute left-3 top-1/2 -translate-y-1/2"></i>
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Cari outlet atau CardCode..." 
                        class="w-full bg-slate-50 border border-slate-200 text-xs rounded-xl pl-9 pr-4 py-2 text-slate-800 placeholder-slate-400 focus:outline-none focus:border-primary focus:bg-white"
                    >
                </div>

                <select name="market" onchange="this.form.submit()" class="bg-slate-50 border border-slate-200 text-xs text-slate-700 rounded-xl px-3 py-2 focus:outline-none focus:border-primary">
                    <option value="">Semua Kanal Pasar</option>
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
                            <input type="checkbox" class="rounded border-slate-300 text-primary focus:ring-primary">
                        </th>
                        <th class="py-3 px-4">KODE SAP</th>
                        <th class="py-3 px-4">NAMA OUTLET</th>
                        <th class="py-3 px-4">KANAL</th>
                        <th class="py-3 px-4">LOKASI & ALAMAT</th>
                        <th class="py-3 px-4">SALES ASSIGNED</th>
                        <th class="py-3 px-4 text-center">STATUS RO</th>
                        <th class="py-3 px-4 text-right">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($outlets as $o)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="py-3 px-4">
                            <input type="checkbox" class="rounded border-slate-300 text-primary focus:ring-primary">
                        </td>
                        <td class="py-3 px-4 font-mono tabular-nums font-bold text-primary">{{ $o['card_code'] }}</td>
                        <td class="py-3 px-4 font-bold text-slate-900">
                            <div>{{ $o['card_name'] }}</div>
                            <div class="text-[10px] text-slate-400 font-normal">Pesanan terakhir: {{ $o['last_order_date'] }}</div>
                        </td>
                        <td class="py-3 px-4 font-semibold text-slate-700">
                            <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-700 border border-slate-200 text-[10px]">
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
                            <a href="{{ route('master.outlet.detail', $o['card_code']) }}" class="p-1.5 text-slate-400 hover:text-primary hover:bg-slate-100 rounded-lg inline-block transition-colors">
                                <i class="mdi mdi-eye-outline text-base"></i>
                            </a>
                            <button 
                                type="button"
                                @click="notify('Edit outlet: {{ $o['card_code'] }} disiapkan.', 'info')" 
                                class="p-1.5 text-slate-400 hover:text-slate-900 hover:bg-slate-100 rounded-lg transition-colors active:translate-y-px"
                            >
                                <i class="mdi mdi-pencil-outline text-base"></i>
                            </button>
                            <button 
                                type="button"
                                @click="notify('Konfirmasi penghapusan {{ $o['card_code'] }} memerlukan otorisasi GM.', 'warning')" 
                                class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors active:translate-y-px"
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
            <span>Menampilkan {{ number_format(count($outlets), 0, ',', '.') }} outlet</span>
            <div class="flex items-center gap-1 font-mono tabular-nums">
                <button class="px-3 py-1 bg-white border border-slate-200 rounded-lg text-slate-400 cursor-not-allowed">Sebelumnya</button>
                <button class="px-3 py-1 bg-primary text-white font-bold rounded-lg shadow-xs">1</button>
                <button class="px-3 py-1 bg-white border border-slate-200 rounded-lg text-slate-600 hover:bg-slate-50">Berikutnya</button>
            </div>
        </div>

    </div>

</div>
@endsection
