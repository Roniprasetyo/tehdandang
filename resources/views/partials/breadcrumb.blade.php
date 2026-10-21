@php
    $currentRoute = Route::currentRouteName();

    if (!isset($items) && isset($breadcrumbs)) {
        $items = $breadcrumbs;
    }

    if (!isset($items)) {
        $routeMap = [
            'dashboard' => [
                ['label' => 'Dashboard', 'url' => route('dashboard.executive')],
                ['label' => 'Eksekutif']
            ],
            'dashboard.executive' => [
                ['label' => 'Dashboard', 'url' => route('dashboard.executive')],
                ['label' => 'Eksekutif']
            ],
            'dashboard.sales' => [
                ['label' => 'Dashboard', 'url' => route('dashboard.executive')],
                ['label' => 'Sales']
            ],
            'dashboard.area' => [
                ['label' => 'Dashboard', 'url' => route('dashboard.executive')],
                ['label' => 'Wilayah']
            ],
            'dashboard.drilldown' => [
                ['label' => 'Dashboard', 'url' => route('dashboard.executive')],
                ['label' => 'Tren Penjualan']
            ],
            'dashboard.tren-penjualan' => [
                ['label' => 'Dashboard', 'url' => route('dashboard.executive')],
                ['label' => 'Tren Penjualan']
            ],
            'dashboard.early-warning' => [
                ['label' => 'Dashboard', 'url' => route('dashboard.executive')],
                ['label' => 'Peringatan Dini']
            ],
            'transaksi.checkin-gps' => [
                ['label' => 'Pelacakan', 'url' => route('transaksi.checkin-gps')],
                ['label' => 'GPS Armada']
            ],
            'tracking.live' => [
                ['label' => 'Pelacakan', 'url' => route('transaksi.checkin-gps')],
                ['label' => 'GPS Armada']
            ],
            'report.index' => [
                ['label' => 'Laporan', 'url' => route('report.index')],
                ['label' => 'Pusat Laporan']
            ],
            'master.sales' => [
                ['label' => 'Data Master', 'url' => route('master.sales')],
                ['label' => 'Direktori Sales']
            ],
            'master.sales.detail' => [
                ['label' => 'Data Master', 'url' => route('master.sales')],
                ['label' => 'Direktori Sales', 'url' => route('master.sales')],
                ['label' => 'Detail Sales']
            ],
            'master.outlet' => [
                ['label' => 'Data Master', 'url' => route('master.outlet')],
                ['label' => 'Outlet Pelanggan']
            ],
            'master.outlet.detail' => [
                ['label' => 'Data Master', 'url' => route('master.outlet')],
                ['label' => 'Outlet Pelanggan', 'url' => route('master.outlet')],
                ['label' => 'Detail Outlet']
            ],
            'master.product' => [
                ['label' => 'Data Master', 'url' => route('master.product')],
                ['label' => 'Katalog Produk']
            ],
            'master.area' => [
                ['label' => 'Data Master', 'url' => route('master.area')],
                ['label' => 'Hierarki Wilayah']
            ],
            'master.route' => [
                ['label' => 'Data Master', 'url' => route('master.route')],
                ['label' => 'Rute Sales']
            ],
            'master.vehicle' => [
                ['label' => 'Data Master', 'url' => route('master.vehicle')],
                ['label' => 'Armada GPS']
            ],
            'master.market' => [
                ['label' => 'Data Master', 'url' => route('master.market')],
                ['label' => 'Segmentasi Pasar']
            ],
            'transaksi.sales-visit' => [
                ['label' => 'Transaksi', 'url' => route('transaksi.sales-visit')],
                ['label' => 'Kunjungan Sales']
            ],
            'transaksi.sales-order' => [
                ['label' => 'Transaksi', 'url' => route('transaksi.sales-order')],
                ['label' => 'Pesanan Penjualan']
            ],
            'transaksi.noo' => [
                ['label' => 'Transaksi', 'url' => route('transaksi.noo')],
                ['label' => 'New Outlet Open']
            ],
            'transaksi.nop' => [
                ['label' => 'Transaksi', 'url' => route('transaksi.nop')],
                ['label' => 'New Open Product']
            ],
            'transaksi.ro' => [
                ['label' => 'Transaksi', 'url' => route('transaksi.ro')],
                ['label' => 'Repeat Order']
            ],
            'transaksi.ro-item' => [
                ['label' => 'Transaksi', 'url' => route('transaksi.ro-item')],
                ['label' => 'RO Item (ROA)']
            ],
            'transaksi.account-proposal' => [
                ['label' => 'Transaksi', 'url' => route('transaksi.account-proposal')],
                ['label' => 'Proposal Akun']
            ],
            'administration.user' => [
                ['label' => 'Administrasi', 'url' => route('administration.user')],
                ['label' => 'User Management']
            ],
            'administration.role-permission' => [
                ['label' => 'Administrasi', 'url' => route('administration.role-permission')],
                ['label' => 'Role & Permission']
            ],
            'administration.integration' => [
                ['label' => 'Administrasi', 'url' => route('administration.integration')],
                ['label' => 'SAP Integration']
            ],
            'administration.audit-log' => [
                ['label' => 'Administrasi', 'url' => route('administration.audit-log')],
                ['label' => 'Audit Log']
            ],
        ];

        $items = $routeMap[$currentRoute] ?? [];
    }
@endphp

@if(!empty($items))
<nav aria-label="Breadcrumb" class="flex items-center space-x-1.5 text-xs text-slate-400 mb-1.5 font-medium">
    <a href="{{ route('dashboard') }}" class="hover:text-primary transition-colors flex items-center gap-1">
        <i class="mdi mdi-home-outline text-sm"></i>
        <span>Beranda</span>
    </a>
    @foreach($items as $crumb)
        <i class="mdi mdi-chevron-right text-slate-300 text-xs"></i>
        @if(!empty($crumb['url']) && !$loop->last)
            <a href="{{ $crumb['url'] }}" class="hover:text-slate-700 transition-colors">
                {{ $crumb['label'] }}
            </a>
        @else
            <span class="text-primary font-semibold">
                {{ $crumb['label'] }}
            </span>
        @endif
    @endforeach
</nav>
@endif
