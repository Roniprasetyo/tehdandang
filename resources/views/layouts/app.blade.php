<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50 text-slate-800">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - PT. Kartini Teh Nasional (Teh Dandang)</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        display: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        indigo: {
                            50: '#eef2ff',
                            100: '#e0e7ff',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                        },
                        dandang: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            600: '#16a34a',
                            700: '#15803d',
                            800: '#166534',
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Alpine.js & Chart.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <style>
        [x-cloak] { display: none !important; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
    @stack('styles')
</head>
<body class="h-full font-sans antialiased bg-slate-50 text-slate-800 flex flex-col lg:flex-row overflow-hidden" x-data="{ sidebarOpen: window.innerWidth >= 1024, roleMenuOpen: false }">

    <!-- Mobile Backdrop Overlay -->
    <div 
        x-show="sidebarOpen" 
        @click="sidebarOpen = false" 
        x-cloak
        class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs z-30 lg:hidden transition-opacity"
    ></div>

    <!-- Metis-Style Clean Light Sidebar -->
    <aside 
        class="bg-white border-r border-slate-200/80 w-72 flex-shrink-0 flex flex-col transition-all duration-300 z-40 fixed lg:static inset-y-0 left-0 shadow-xl lg:shadow-xs"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0 lg:w-20'"
    >
        <!-- Brand Header -->
        <div class="h-16 px-5 border-b border-slate-100 flex items-center justify-between">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 overflow-hidden">
                <div class="w-10 h-10 rounded-xl bg-indigo-600 p-0.5 shadow-sm flex items-center justify-center flex-shrink-0">
                    <div class="w-full h-full bg-white rounded-[10px] flex items-center justify-center">
                        <i data-lucide="cup-soda" class="w-5 h-5 text-indigo-600"></i>
                    </div>
                </div>
                <div class="leading-tight transition-opacity duration-200" x-show="sidebarOpen">
                    <span class="font-display font-bold text-base text-slate-900 tracking-tight block">TEH DANDANG</span>
                    <span class="text-[9px] tracking-wider text-slate-500 font-bold uppercase block">PT. Kartini Teh Nasional</span>
                </div>
            </a>
        </div>

        <!-- Corporate Profile Badge Banner -->
        <div class="mx-3 my-3 p-3 rounded-xl bg-slate-50 border border-slate-200/80 flex items-center justify-between" x-show="sidebarOpen">
            <div class="flex items-center space-x-3">
                <img src="{{ $authUser['avatar'] ?? 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=150' }}" class="w-9 h-9 rounded-lg object-cover ring-2 ring-indigo-500/20 shadow-xs" alt="Avatar">
                <div class="overflow-hidden">
                    <p class="text-xs font-bold text-slate-900 truncate">{{ $authUser['name'] }}</p>
                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200/60">
                        {{ $authUser['role'] }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 overflow-y-auto px-3 py-2 space-y-1">
            @php
                $role = $authUser['role'] ?? 'Admin Pusat';
                $currentRoute = Route::currentRouteName();
            @endphp

            <!-- Dashboard Section -->
            <div class="pt-2 pb-1 px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider" x-show="sidebarOpen">Dashboard</div>
            
            @if(in_array($role, ['Admin Pusat', 'GM', 'Manager', 'ASM', 'Finance', 'IT']))
                <a href="{{ route('dashboard.executive') }}" class="flex items-center px-3 py-2.5 rounded-xl text-xs font-medium transition-all {{ str_contains($currentRoute, 'dashboard.executive') || $currentRoute === 'dashboard' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-200 font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <i data-lucide="layout-dashboard" class="w-4 h-4 mr-3 flex-shrink-0"></i>
                    <span x-show="sidebarOpen">Executive Dashboard</span>
                </a>
            @endif

            @if(in_array($role, ['Sales', 'Admin Pusat', 'ASM', 'Manager', 'Admin Area']))
                <a href="{{ route('dashboard.sales') }}" class="flex items-center px-3 py-2.5 rounded-xl text-xs font-medium transition-all {{ str_contains($currentRoute, 'dashboard.sales') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-200 font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <i data-lucide="user-check" class="w-4 h-4 mr-3 flex-shrink-0"></i>
                    <span x-show="sidebarOpen">Sales Dashboard</span>
                </a>
            @endif

            @if(in_array($role, ['Admin Pusat', 'GM', 'Manager', 'ASM', 'Admin Area']))
                <a href="{{ route('dashboard.area') }}" class="flex items-center px-3 py-2.5 rounded-xl text-xs font-medium transition-all {{ str_contains($currentRoute, 'dashboard.area') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-200 font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <i data-lucide="map-pin" class="w-4 h-4 mr-3 flex-shrink-0"></i>
                    <span x-show="sidebarOpen">Area Dashboard</span>
                </a>
            @endif

            @if(in_array($role, ['Admin Pusat', 'GM', 'Manager', 'ASM', 'Admin Area', 'IT']))
                <a href="{{ route('dashboard.early-warning') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-medium transition-all {{ str_contains($currentRoute, 'dashboard.early-warning') ? 'bg-rose-50 text-rose-700 border border-rose-200 font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <div class="flex items-center">
                        <i data-lucide="alert-triangle" class="w-4 h-4 mr-3 flex-shrink-0 text-amber-500"></i>
                        <span x-show="sidebarOpen">Early Warning</span>
                    </div>
                    <span x-show="sidebarOpen" class="bg-rose-100 text-rose-700 text-[10px] px-2 py-0.5 rounded-full font-bold">12</span>
                </a>
            @endif

            <!-- Master Section -->
            <div class="pt-4 pb-1 px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider" x-show="sidebarOpen">Master Data</div>

            @if(in_array($role, ['Admin Pusat', 'Admin Area', 'ASM', 'Manager', 'GM', 'IT']))
                <a href="{{ route('master.sales') }}" class="flex items-center px-3 py-2.5 rounded-xl text-xs font-medium transition-all {{ str_contains($currentRoute, 'master.sales') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-200 font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <i data-lucide="users" class="w-4 h-4 mr-3 flex-shrink-0"></i>
                    <span x-show="sidebarOpen">Sales Directory</span>
                </a>
            @endif

            <a href="{{ route('master.outlet') }}" class="flex items-center px-3 py-2.5 rounded-xl text-xs font-medium transition-all {{ str_contains($currentRoute, 'master.outlet') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-200 font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                <i data-lucide="store" class="w-4 h-4 mr-3 flex-shrink-0"></i>
                <span x-show="sidebarOpen">Outlet (SAP OCRD)</span>
            </a>

            @if(!in_array($role, ['Sales']))
                <a href="{{ route('master.product') }}" class="flex items-center px-3 py-2.5 rounded-xl text-xs font-medium transition-all {{ str_contains($currentRoute, 'master.product') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-200 font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <i data-lucide="package" class="w-4 h-4 mr-3 flex-shrink-0"></i>
                    <span x-show="sidebarOpen">Product (SAP OITM)</span>
                </a>
                <a href="{{ route('master.area') }}" class="flex items-center px-3 py-2.5 rounded-xl text-xs font-medium transition-all {{ str_contains($currentRoute, 'master.area') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-200 font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <i data-lucide="layers" class="w-4 h-4 mr-3 flex-shrink-0"></i>
                    <span x-show="sidebarOpen">Area Hierarki</span>
                </a>
            @endif

            @if(in_array($role, ['Admin Pusat', 'Admin Area', 'Fleet Admin', 'ASM', 'IT']))
                <a href="{{ route('master.route') }}" class="flex items-center px-3 py-2.5 rounded-xl text-xs font-medium transition-all {{ str_contains($currentRoute, 'master.route') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-200 font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <i data-lucide="route" class="w-4 h-4 mr-3 flex-shrink-0"></i>
                    <span x-show="sidebarOpen">Master Route</span>
                </a>
            @endif

            @if(in_array($role, ['Admin Pusat', 'Fleet Admin', 'IT']))
                <a href="{{ route('master.vehicle') }}" class="flex items-center px-3 py-2.5 rounded-xl text-xs font-medium transition-all {{ str_contains($currentRoute, 'master.vehicle') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-200 font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <i data-lucide="truck" class="w-4 h-4 mr-3 flex-shrink-0"></i>
                    <span x-show="sidebarOpen">Vehicle (Concox GT06N)</span>
                </a>
                <a href="{{ route('master.market') }}" class="flex items-center px-3 py-2.5 rounded-xl text-xs font-medium transition-all {{ str_contains($currentRoute, 'master.market') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-200 font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <i data-lucide="shopping-bag" class="w-4 h-4 mr-3 flex-shrink-0"></i>
                    <span x-show="sidebarOpen">Market / Channel</span>
                </a>
            @endif

            <!-- Tracking Section -->
            <div class="pt-4 pb-1 px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider" x-show="sidebarOpen">Tracking</div>

            <div x-data="{ trackingOpen: {{ str_contains($currentRoute, 'checkin-gps') || str_contains($currentRoute, 'tracking') ? 'true' : 'false' }} }">
                <button @click="trackingOpen = !trackingOpen" class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-medium text-slate-600 hover:bg-slate-100 transition-all">
                    <div class="flex items-center">
                        <i data-lucide="compass" class="w-4 h-4 mr-3 flex-shrink-0 text-indigo-600"></i>
                        <span x-show="sidebarOpen">Tracking</span>
                    </div>
                    <i data-lucide="chevron-down" class="w-3.5 h-3.5 transition-transform" :class="trackingOpen ? 'rotate-180' : ''" x-show="sidebarOpen"></i>
                </button>
                <div x-show="trackingOpen && sidebarOpen" x-cloak class="mt-1 ml-4 pl-3 border-l-2 border-indigo-100 space-y-1">
                    <a href="{{ route('transaksi.checkin-gps') }}" class="flex items-center px-3 py-2 rounded-lg text-xs {{ str_contains($currentRoute, 'transaksi.checkin-gps') ? 'bg-indigo-600 text-white font-bold shadow-xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        <i data-lucide="radio" class="w-3.5 h-3.5 mr-2"></i> Live Tracking
                    </a>
                    <a href="{{ route('master.vehicle') }}" class="flex items-center px-3 py-2 rounded-lg text-xs {{ str_contains($currentRoute, 'master.vehicle') ? 'bg-indigo-600 text-white font-bold shadow-xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        <i data-lucide="cpu" class="w-3.5 h-3.5 mr-2"></i> Perangkat Concox GT06N
                    </a>
                    <a href="{{ route('administration.integration') }}" class="flex items-center px-3 py-2 rounded-lg text-xs {{ str_contains($currentRoute, 'administration.integration') ? 'bg-indigo-600 text-white font-bold shadow-xs' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        <i data-lucide="wifi" class="w-3.5 h-3.5 mr-2"></i> Koneksi Tracksolid
                    </a>
                </div>
            </div>

            <!-- Transaksi Section -->
            <div class="pt-4 pb-1 px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider" x-show="sidebarOpen">Transaksi</div>

            <a href="{{ route('transaksi.sales-visit') }}" class="flex items-center px-3 py-2.5 rounded-xl text-xs font-medium transition-all {{ str_contains($currentRoute, 'transaksi.sales-visit') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-200 font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                <i data-lucide="clipboard-check" class="w-4 h-4 mr-3 flex-shrink-0"></i>
                <span x-show="sidebarOpen">Sales Visit GPS</span>
            </a>

            <a href="{{ route('transaksi.sales-order') }}" class="flex items-center px-3 py-2.5 rounded-xl text-xs font-medium transition-all {{ str_contains($currentRoute, 'transaksi.sales-order') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-200 font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                <i data-lucide="shopping-cart" class="w-4 h-4 mr-3 flex-shrink-0"></i>
                <span x-show="sidebarOpen">Sales Order (SAP)</span>
            </a>

            <a href="{{ route('transaksi.noo') }}" class="flex items-center px-3 py-2.5 rounded-xl text-xs font-medium transition-all {{ str_contains($currentRoute, 'transaksi.noo') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-200 font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                <i data-lucide="user-plus" class="w-4 h-4 mr-3 flex-shrink-0"></i>
                <span x-show="sidebarOpen">NOO (New Outlet)</span>
            </a>

            <a href="{{ route('transaksi.nop') }}" class="flex items-center px-3 py-2.5 rounded-xl text-xs font-medium transition-all {{ str_contains($currentRoute, 'transaksi.nop') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-200 font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                <i data-lucide="box" class="w-4 h-4 mr-3 flex-shrink-0"></i>
                <span x-show="sidebarOpen">NOP (New Product)</span>
            </a>

            <a href="{{ route('transaksi.ro') }}" class="flex items-center px-3 py-2.5 rounded-xl text-xs font-medium transition-all {{ str_contains($currentRoute, 'transaksi.ro') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-200 font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                <i data-lucide="repeat" class="w-4 h-4 mr-3 flex-shrink-0"></i>
                <span x-show="sidebarOpen">RO / ROA</span>
            </a>

            <a href="{{ route('transaksi.ro-item') }}" class="flex items-center px-3 py-2.5 rounded-xl text-xs font-medium transition-all {{ str_contains($currentRoute, 'transaksi.ro-item') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-200 font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                <i data-lucide="list-checks" class="w-4 h-4 mr-3 flex-shrink-0"></i>
                <span x-show="sidebarOpen">RO Item</span>
            </a>

            @if(!in_array($role, ['Sales']))
                <a href="{{ route('transaksi.account-proposal') }}" class="flex items-center px-3 py-2.5 rounded-xl text-xs font-medium transition-all {{ str_contains($currentRoute, 'transaksi.account-proposal') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-200 font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <i data-lucide="file-text" class="w-4 h-4 mr-3 flex-shrink-0"></i>
                    <span x-show="sidebarOpen">Account Proposal</span>
                </a>
            @endif

            <!-- Report Section -->
            <div class="pt-4 pb-1 px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider" x-show="sidebarOpen">Report</div>
            <a href="{{ route('report.index') }}" class="flex items-center px-3 py-2.5 rounded-xl text-xs font-medium transition-all {{ str_contains($currentRoute, 'report') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-200 font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                <i data-lucide="bar-chart-3" class="w-4 h-4 mr-3 flex-shrink-0"></i>
                <span x-show="sidebarOpen">Reporting Center</span>
            </a>

            <!-- Administration Section -->
            @if(in_array($role, ['Admin Pusat', 'IT']))
                <div class="pt-4 pb-1 px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider" x-show="sidebarOpen">Administration</div>
                <a href="{{ route('administration.user') }}" class="flex items-center px-3 py-2.5 rounded-xl text-xs font-medium transition-all {{ str_contains($currentRoute, 'administration.user') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-200 font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <i data-lucide="shield-check" class="w-4 h-4 mr-3 flex-shrink-0"></i>
                    <span x-show="sidebarOpen">User Management</span>
                </a>
                <a href="{{ route('administration.role-permission') }}" class="flex items-center px-3 py-2.5 rounded-xl text-xs font-medium transition-all {{ str_contains($currentRoute, 'administration.role-permission') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-200 font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <i data-lucide="key" class="w-4 h-4 mr-3 flex-shrink-0"></i>
                    <span x-show="sidebarOpen">Role & Permission</span>
                </a>
                <a href="{{ route('administration.integration') }}" class="flex items-center px-3 py-2.5 rounded-xl text-xs font-medium transition-all {{ str_contains($currentRoute, 'administration.integration') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-200 font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <i data-lucide="cpu" class="w-4 h-4 mr-3 flex-shrink-0"></i>
                    <span x-show="sidebarOpen">SAP & Concox Integration</span>
                </a>
                <a href="{{ route('administration.audit-log') }}" class="flex items-center px-3 py-2.5 rounded-xl text-xs font-medium transition-all {{ str_contains($currentRoute, 'administration.audit-log') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-200 font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <i data-lucide="activity" class="w-4 h-4 mr-3 flex-shrink-0"></i>
                    <span x-show="sidebarOpen">Audit Log</span>
                </a>
            @endif
        </nav>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-slate-50">
        
        <!-- Clean Header (No Header Status Badges) -->
        <header class="h-16 bg-white border-b border-slate-200/80 px-4 md:px-6 flex items-center justify-between z-20 shadow-xs">
            
            <div class="flex items-center space-x-3 md:space-x-4">
                <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-xl text-slate-500 hover:text-slate-900 hover:bg-slate-100 focus:outline-none">
                    <i data-lucide="menu" class="w-5 h-5"></i>
                </button>
            </div>

            <!-- Right Header Controls -->
            <div class="flex items-center space-x-3 md:space-x-4">
                
                <!-- Notifications -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="p-2 rounded-xl text-slate-500 hover:text-slate-900 hover:bg-slate-100 relative">
                        <i data-lucide="bell" class="w-5 h-5"></i>
                        <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-rose-500 rounded-full ring-2 ring-white"></span>
                    </button>
                    <div x-show="open" @click.outside="open = false" x-cloak class="absolute right-0 mt-2 w-80 bg-white border border-slate-200 rounded-2xl shadow-xl py-2 z-50">
                        <div class="px-4 py-2 border-b border-slate-100 flex justify-between items-center">
                            <span class="text-xs font-bold text-slate-900">Early Warning Alerts (12)</span>
                            <a href="{{ route('dashboard.early-warning') }}" class="text-[11px] text-indigo-600 font-semibold hover:underline">View All</a>
                        </div>
                        <div class="max-h-64 overflow-y-auto divide-y divide-slate-100">
                            <div class="p-3 hover:bg-slate-50 text-xs">
                                <span class="font-bold text-rose-600 block">🔴 Critical: RO Inactive</span>
                                <p class="text-slate-500 mt-0.5">Outlet Warung Makan Resto Bundo 60 hari tidak RO.</p>
                            </div>
                            <div class="p-3 hover:bg-slate-50 text-xs">
                                <span class="font-bold text-emerald-600 block">🟢 Top Sales Performer: Eko Prasetyo</span>
                                <p class="text-slate-500 mt-0.5">Cepogo, Boyolali mencatatkan omset 115% target MTD!</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Role Switcher & Profile -->
                <div class="relative" x-data="{ userMenu: false }">
                    <button @click="userMenu = !userMenu" class="flex items-center space-x-2 p-1 rounded-xl hover:bg-slate-100 transition-all border border-slate-200">
                        <img src="{{ $authUser['avatar'] ?? 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=150' }}" class="w-8 h-8 rounded-lg object-cover" alt="User">
                        <div class="text-left hidden sm:block pr-1">
                            <span class="text-xs font-bold text-slate-900 block leading-tight">{{ $authUser['name'] }}</span>
                            <span class="text-[10px] text-indigo-600 font-semibold block">{{ $authUser['role'] }}</span>
                        </div>
                        <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400"></i>
                    </button>

                    <!-- Dropdown -->
                    <div x-show="userMenu" @click.outside="userMenu = false" x-cloak class="absolute right-0 mt-2 w-72 bg-white border border-slate-200 rounded-2xl shadow-2xl p-3 z-50">
                        <div class="border-b border-slate-100 pb-2 mb-2">
                            <p class="text-[10px] text-slate-400 font-bold uppercase">Login Profile</p>
                            <p class="text-xs font-bold text-slate-900">{{ $authUser['name'] }} ({{ $authUser['username'] }})</p>
                            <p class="text-[11px] text-indigo-600 font-medium">Scope: {{ $authUser['area'] }} ({{ $authUser['region'] }})</p>
                        </div>
                        
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Switch Mock Role:</p>
                        <div class="space-y-1 max-h-56 overflow-y-auto">
                            @foreach($allUsers as $u)
                                <a 
                                    href="?switch_user={{ $u['username'] }}"
                                    class="w-full flex items-center justify-between p-2 rounded-xl text-xs transition-all {{ $u['username'] === $authUser['username'] ? 'bg-indigo-50 text-indigo-600 font-bold border border-indigo-200' : 'text-slate-700 hover:bg-slate-100' }}"
                                >
                                    <span>{{ $u['name'] }}</span>
                                    <span class="text-[10px] px-2 py-0.5 rounded bg-slate-100 text-slate-600 font-medium">{{ $u['role'] }}</span>
                                </a>
                            @endforeach
                        </div>

                        <div class="border-t border-slate-100 pt-2 mt-2">
                            <a href="{{ route('logout') }}" class="w-full text-left text-xs text-rose-600 hover:text-rose-700 flex items-center gap-2 p-1.5 rounded-xl hover:bg-rose-50 font-semibold">
                                <i data-lucide="log-out" class="w-4 h-4"></i> Logout Session
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </header>

        <!-- Main Body -->
        <main class="flex-1 overflow-y-auto p-3 sm:p-5 md:p-6 space-y-4 sm:space-y-6 min-w-0 w-full max-w-full">
            @yield('content')
        </main>
    </div>

    <script>
        lucide.createIcons();
    </script>
    @stack('scripts')
</body>
</html>
