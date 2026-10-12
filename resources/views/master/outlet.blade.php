@extends('layouts.app')

@section('title', 'Direktori Outlet & Pelanggan')

@section('content')
<div class="space-y-6">

    <!-- Header & Aksi Utama -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-xl border border-slate-200/90 shadow-xs">
        <div>
            <h1 class="text-xl font-semibold text-slate-900">Direktori Outlet & Pelanggan</h1>
            <p class="text-xs text-slate-500 mt-1">Kelola data pelanggan (SAP B1 OCRD), segmentasi kanal pasar GT/MT/HOREKA, dan kepatuhan Repeat Order</p>
        </div>
        <div class="flex items-center gap-2">
            <button 
                type="button"
                @click="notify('Direktori outlet berhasil diekspor ke Excel.', 'success')" 
                class="btn-secondary-outline"
            >
                <i class="mdi mdi-download text-base"></i>
                <span>Ekspor</span>
            </button>
            <button 
                type="button"
                @click="notify('Pilih berkas Excel untuk impor direktori outlet.', 'info')" 
                class="btn-secondary-outline"
            >
                <i class="mdi mdi-upload text-base"></i>
                <span>Impor</span>
            </button>
            <button 
                type="button"
                @click="notify('Formulir registrasi NOO / Outlet Baru (SAP OCRD) disiapkan.', 'info')" 
                class="btn-primary"
            >
                <i class="mdi mdi-account-plus text-base"></i>
                <span>Tambah Outlet (NOO)</span>
            </button>
        </div>
    </div>

    <!-- 4 Ringkasan Metrik Konsisten -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white border border-slate-200/90 rounded-xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-xs font-medium text-slate-500 block">Total Outlet</span>
                <span class="text-2xl font-semibold font-mono tabular-nums text-slate-900 mt-1 block">5.240</span>
                <span class="text-xs text-slate-500 mt-1 block">Terdaftar di SAP B1 (OCRD)</span>
            </div>
            <div class="w-9 h-9 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center text-lg flex-shrink-0">
                <i class="mdi mdi-store-outline"></i>
            </div>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-xs font-medium text-slate-500 block">Outlet Aktif (ROA)</span>
                <span class="text-2xl font-semibold font-mono tabular-nums text-primary mt-1 block">3.995</span>
                <span class="text-xs text-slate-500 mt-1 block">76.2% coverage aktif</span>
            </div>
            <div class="w-9 h-9 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center text-lg flex-shrink-0">
                <i class="mdi mdi-check-circle-outline"></i>
            </div>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-xs font-medium text-slate-500 block">Peringatan RO</span>
                <span class="text-2xl font-semibold font-mono tabular-nums text-secondary mt-1 block">482</span>
                <span class="text-xs text-slate-500 mt-1 block">Perlu tindak lanjut sales</span>
            </div>
            <div class="w-9 h-9 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center text-lg flex-shrink-0">
                <i class="mdi mdi-alert-circle-outline"></i>
            </div>
        </div>

        <div class="bg-white border border-slate-200/90 rounded-xl p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-xs font-medium text-slate-500 block">Outlet Inaktif</span>
                <span class="text-2xl font-semibold font-mono tabular-nums text-slate-900 mt-1 block">1.245</span>
                <span class="text-xs text-slate-500 mt-1 block">&gt; 30 hari tanpa pesanan</span>
            </div>
            <div class="w-9 h-9 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center text-lg flex-shrink-0">
                <i class="mdi mdi-account-off-outline"></i>
            </div>
        </div>
    </div>

    <!-- Outlet Table Container -->
    <div class="bg-white border border-slate-200/90 rounded-xl shadow-xs">
        
        <!-- Search & Filter Toolbar -->
        <form action="{{ route('master.outlet') }}" method="GET" class="p-4 border-b border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3">
            <h3 class="text-sm font-semibold text-slate-900 flex-shrink-0">Direktori Outlet Pelanggan</h3>

            <div class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
                <div class="relative flex-1 sm:w-64">
                    <i class="mdi mdi-magnify text-slate-400 text-base absolute left-3 top-1/2 -translate-y-1/2"></i>
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Cari outlet atau CardCode..." 
                        class="w-full bg-slate-50 border border-slate-200 text-xs rounded-lg pl-9 pr-4 h-9 text-slate-800 placeholder-slate-400 focus:outline-none focus:border-primary focus:bg-white transition-all"
                    >
                </div>

                <select name="market" onchange="this.form.submit()" class="bg-slate-50 border border-slate-200 text-xs text-slate-700 rounded-lg px-3 h-9 focus:outline-none focus:border-primary cursor-pointer transition-all">
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
                <thead class="bg-slate-50 text-slate-600 uppercase text-[11px] font-semibold tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-3.5 w-10">
                            <input type="checkbox" class="rounded border-slate-300 text-primary focus:ring-primary">
                        </th>
                        <th class="py-3 px-3.5">Kode SAP</th>
                        <th class="py-3 px-3.5">Nama Outlet</th>
                        <th class="py-3 px-3.5">Kanal</th>
                        <th class="py-3 px-3.5">Lokasi & Alamat</th>
                        <th class="py-3 px-3.5">Sales Person</th>
                        <th class="py-3 px-3.5 text-center">Status RO</th>
                        <th class="py-3 px-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($outlets as $o)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="py-3 px-3.5">
                            <input type="checkbox" class="rounded border-slate-300 text-primary focus:ring-primary">
                        </td>
                        <td class="py-3 px-3.5 font-mono tabular-nums font-medium text-primary">{{ $o['card_code'] }}</td>
                        <td class="py-3 px-3.5">
                            <div class="font-medium text-slate-900">{{ $o['card_name'] }}</div>
                            <div class="text-[11px] text-slate-500 font-mono">Pesanan terakhir: {{ $o['last_order_date'] }}</div>
                        </td>
                        <td class="py-3 px-3.5">
                            <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-700 border border-slate-200 text-[11px] font-medium">
                                {{ $o['market'] }}
                            </span>
                        </td>
                        <td class="py-3 px-3.5 text-slate-600">
                            <div>{{ $o['address'] }}</div>
                            <div class="text-[11px] text-slate-500">{{ $o['kecamatan'] }}, {{ $o['kabupaten'] }}</div>
                        </td>
                        <td class="py-3 px-3.5 font-medium text-slate-800">{{ $o['sales_name'] }}</td>
                        <td class="py-3 px-3.5 text-center">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium border {{ $o['ro_status'] === 'Active' ? 'bg-primary-50 text-primary-700 border-primary-200' : ($o['ro_status'] === 'Warning' ? 'bg-amber-50 text-amber-700 border-amber-200' : 'bg-rose-50 text-rose-700 border-rose-200') }}">
                                <i class="mdi {{ $o['ro_status'] === 'Active' ? 'mdi-check-circle-outline' : ($o['ro_status'] === 'Warning' ? 'mdi-alert-circle-outline' : 'mdi-close-circle-outline') }} mr-1"></i>
                                <span>{{ $o['ro_status'] === 'Active' ? 'Aktif' : ($o['ro_status'] === 'Warning' ? 'Peringatan' : 'Inaktif') }}</span>
                            </span>
                        </td>
                        <td class="py-3 px-3.5 text-right space-x-1">
                            <a href="{{ route('master.outlet.detail', $o['card_code']) }}" class="p-1.5 text-slate-400 hover:text-primary hover:bg-slate-100 rounded-lg inline-block transition-colors" title="Lihat Detail">
                                <i class="mdi mdi-eye-outline text-base"></i>
                            </a>
                            <button 
                                type="button"
                                @click="notify('Edit outlet: {{ $o['card_code'] }} disiapkan.', 'info')" 
                                class="p-1.5 text-slate-400 hover:text-slate-900 hover:bg-slate-100 rounded-lg transition-colors active:translate-y-px"
                                title="Ubah Data"
                            >
                                <i class="mdi mdi-pencil-outline text-base"></i>
                            </button>
                            <button 
                                type="button"
                                @click="notify('Konfirmasi penghapusan {{ $o['card_code'] }} memerlukan otorisasi GM.', 'warning')" 
                                class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors active:translate-y-px"
                                title="Hapus Outlet"
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
                <button class="px-3 py-1 bg-primary text-white font-medium rounded-lg shadow-xs">1</button>
                <button class="px-3 py-1 bg-white border border-slate-200 rounded-lg text-slate-600 hover:bg-slate-50">Berikutnya</button>
            </div>
        </div>

    </div>

</div>
@endsection
