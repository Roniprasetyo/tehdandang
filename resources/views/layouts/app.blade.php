<!DOCTYPE html>
<!-- Hallmark · pre-emit critique: P5 H5 E5 S5 R5 V5 · theme: Tri-Tone Heritage (Tea Green, Amber Brew, Sky Accent) · genre: modern-minimal -->
<html lang="id" class="h-full bg-slate-50 text-slate-800">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - PT. Kartini Teh Dandang SFA</title>
    
    <!-- Google Fonts: Poppins (Primary & Display) & JetBrains Mono (Financial Tabular) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    
    <!-- Material Design Icons (MDI) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css">
    
    <!-- Hallmark Design Tokens (Tokens canonical source) -->
    <link rel="stylesheet" href="/css/tokens.css">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                        display: ['Poppins', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                    },
                    colors: {
                        // 1. Warna Primer: Deep Forest Tea Green (Identity Teh Dandang)
                        primary: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            200: '#bbf7d0',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                            800: '#166534',
                            900: '#14532d',
                            DEFAULT: '#15803d',
                        },
                        // 2. Warna Sekunder: Warm Amber Brew (Seduhan teh kental harum)
                        secondary: {
                            50: '#fffbeb',
                            100: '#fef3c7',
                            200: '#fde68a',
                            500: '#f59e0b',
                            600: '#d97706',
                            700: '#b45309',
                            800: '#92400e',
                            900: '#78350f',
                            DEFAULT: '#b45309',
                        },
                        // 3. Warna Aksen: Sky Telemetry Blue (Data sync, GPS, analytical highlights)
                        accent: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                            DEFAULT: '#0284c7',
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Alpine.js & Chart.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        [x-cloak] { display: none !important; }
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: #f8fafc; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 9999px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        
        /* Non-negotiable mobile responsive integrity */
        html, body {
            overflow-x: clip;
            font-family: 'Poppins', sans-serif;
        }
    </style>
    @stack('styles')
</head>
<body class="h-full font-sans antialiased bg-slate-50 text-slate-800 flex flex-col lg:flex-row overflow-hidden selection:bg-emerald-100 selection:text-emerald-900" x-data="{ sidebarOpen: window.innerWidth >= 1024, roleMenuOpen: false }">

    <!-- Mobile Backdrop Overlay -->
    <div 
        x-show="sidebarOpen" 
        @click="sidebarOpen = false" 
        x-cloak
        class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs z-30 lg:hidden transition-opacity"
    ></div>

    <!-- Clean White Sidebar with MDI Icons & Primary Green Accents -->
    <aside 
        class="bg-white border-r border-slate-200/90 w-64 flex-shrink-0 flex flex-col transition-all duration-300 z-40 fixed lg:static inset-y-0 left-0 shadow-xl lg:shadow-xs"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0 lg:w-20'"
    >
        <!-- Brand Header (PT. Kartini Teh Dandang) -->
        <div class="h-16 px-5 border-b border-slate-100 flex items-center justify-between">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 overflow-hidden">
                <div class="w-9 h-9 rounded-xl bg-primary text-white flex items-center justify-center flex-shrink-0 shadow-xs ring-2 ring-primary-100">
                    <i class="mdi mdi-tea text-xl"></i>
                </div>
                <div class="leading-tight transition-opacity duration-200" x-show="sidebarOpen">
                    <span class="font-display font-bold text-sm tracking-tight text-slate-900 block">TEH DANDANG</span>
                    <span class="text-[9px] tracking-wider text-primary font-semibold uppercase block">Sales Force Automation</span>
                </div>
            </a>
        </div>

        <!-- Role Badge Banner (Clean FMCG Profile Card) -->
        <div class="mx-3 my-3 p-3 rounded-xl bg-slate-50 border border-slate-200/90 flex items-center justify-between" x-show="sidebarOpen">
            <div class="flex items-center space-x-3 overflow-hidden">
                <img src="{{ $authUser['avatar'] ?? 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150' }}" class="w-8 h-8 rounded-full object-cover ring-2 ring-primary/20 flex-shrink-0" alt="Avatar">
                <div class="overflow-hidden">
                    <p class="text-xs font-bold text-slate-900 truncate">{{ $authUser['name'] ?? 'Bapak/Ibu Owner' }}</p>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-primary-50 text-primary-700 border border-primary-200">
                        <i class="mdi mdi-shield-account-outline text-xs mr-1"></i> {{ $authUser['role'] ?? 'Owner' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Navigation Menu Filtered strictly per Role with MDI Icons -->
        <nav class="flex-1 overflow-y-auto px-3 py-2 space-y-1">
            @php
                $role = $authUser['role'] ?? 'Owner';
                $currentRoute = Route::currentRouteName();
                $isOwner = in_array($role, ['Owner', 'GM']);
            @endphp

            <!-- DASHBOARD & MONITORING SECTION -->
            <div class="pt-2 pb-1 px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider" x-show="sidebarOpen">
                {{ $isOwner ? 'Monitoring & Executive' : 'Dashboard' }}
            </div>
            
            @if(in_array($role, ['Owner', 'GM', 'Manager', 'ASM', 'Admin Pusat', 'Finance', 'IT']))
                <a href="{{ route('dashboard.executive') }}" class="flex items-center px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ str_contains($currentRoute, 'dashboard.executive') || $currentRoute === 'dashboard' ? 'bg-primary text-white shadow-xs font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <i class="mdi mdi-view-dashboard-outline text-lg mr-2.5 flex-shrink-0"></i>
                    <span x-show="sidebarOpen">Executive Dashboard</span>
                </a>
            @endif

            @if(in_array($role, ['Sales', 'Admin Area', 'ASM', 'Manager', 'GM', 'Admin Pusat', 'Owner']))
                <a href="{{ route('dashboard.sales') }}" class="flex items-center px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ str_contains($currentRoute, 'dashboard.sales') ? 'bg-primary text-white shadow-xs font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <i class="mdi mdi-account-tie-outline text-lg mr-2.5 flex-shrink-0"></i>
                    <span x-show="sidebarOpen">Sales Dashboard</span>
                </a>
            @endif

            @if(in_array($role, ['Admin Area', 'ASM', 'Manager', 'GM', 'Fleet Admin', 'Admin Pusat', 'Owner', 'IT']))
                <a href="{{ route('dashboard.area') }}" class="flex items-center px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ str_contains($currentRoute, 'dashboard.area') ? 'bg-primary text-white shadow-xs font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <i class="mdi mdi-map-marker-radius-outline text-lg mr-2.5 flex-shrink-0"></i>
                    <span x-show="sidebarOpen">Area Dashboard</span>
                </a>
            @endif

            <a href="{{ route('dashboard.drilldown') }}" class="flex items-center px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ str_contains($currentRoute, 'dashboard.drilldown') ? 'bg-primary text-white shadow-xs font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                <i class="mdi mdi-chart-timeline-variant text-lg mr-2.5 flex-shrink-0 text-primary"></i>
                <span x-show="sidebarOpen">Grafik Drilldown 7 Level</span>
            </a>

            @if(in_array($role, ['Owner', 'GM', 'Manager', 'ASM', 'Admin Area', 'Admin Pusat', 'IT', 'Fleet Admin']))
                <a href="{{ route('dashboard.early-warning') }}" class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ str_contains($currentRoute, 'dashboard.early-warning') ? 'bg-rose-50 text-rose-700 border border-rose-200 font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <div class="flex items-center">
                        <i class="mdi mdi-shield-alert-outline text-lg mr-2.5 flex-shrink-0 text-rose-500"></i>
                        <span x-show="sidebarOpen">Risk & Fraud (Early Warning)</span>
                    </div>
                    <span x-show="sidebarOpen" class="bg-rose-100 text-rose-700 text-[10px] px-2 py-0.5 rounded-full font-bold">12</span>
                </a>
            @endif

            <!-- TRACKING & FIELD MONITORING -->
            <div class="pt-3 pb-1 px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider" x-show="sidebarOpen">Tracking</div>

            <a href="{{ route('transaksi.checkin-gps') }}" class="flex items-center px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ str_contains($currentRoute, 'transaksi.checkin-gps') ? 'bg-primary text-white shadow-xs font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                <i class="mdi mdi-crosshairs-gps text-lg mr-2.5 flex-shrink-0 text-accent"></i>
                <span x-show="sidebarOpen">Live Tracking GPS</span>
            </a>

            <!-- EXECUTIVE REPORT SECTION -->
            <div class="pt-3 pb-1 px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider" x-show="sidebarOpen">Report</div>
            <a href="{{ route('report.index') }}" class="flex items-center px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ str_contains($currentRoute, 'report') ? 'bg-primary text-white shadow-xs font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                <i class="mdi mdi-file-chart-outline text-lg mr-2.5 flex-shrink-0"></i>
                <span x-show="sidebarOpen">Reporting Center</span>
            </a>

            <!-- OPERATIONAL MASTER DATA -->
            @if(!$isOwner)
                <div class="pt-3 pb-1 px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider" x-show="sidebarOpen">Master Data</div>

                @if(in_array($role, ['GM', 'Manager', 'ASM', 'Admin Area', 'Admin Pusat', 'IT']))
                    <a href="{{ route('master.sales') }}" class="flex items-center px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ str_contains($currentRoute, 'master.sales') ? 'bg-primary text-white shadow-xs font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        <i class="mdi mdi-account-group-outline text-lg mr-2.5 flex-shrink-0"></i>
                        <span x-show="sidebarOpen">Sales Directory</span>
                    </a>
                @endif

                <a href="{{ route('master.outlet') }}" class="flex items-center px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ str_contains($currentRoute, 'master.outlet') ? 'bg-primary text-white shadow-xs font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <i class="mdi mdi-storefront-outline text-lg mr-2.5 flex-shrink-0"></i>
                    <span x-show="sidebarOpen">Outlet (SAP OCRD)</span>
                </a>

                @if(in_array($role, ['GM', 'Manager', 'ASM', 'Admin Area', 'Finance', 'Admin Pusat', 'IT']))
                    <a href="{{ route('master.product') }}" class="flex items-center px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ str_contains($currentRoute, 'master.product') ? 'bg-primary text-white shadow-xs font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        <i class="mdi mdi-package-variant-closed text-lg mr-2.5 flex-shrink-0"></i>
                        <span x-show="sidebarOpen">Product (SAP OITM)</span>
                    </a>
                    <a href="{{ route('master.area') }}" class="flex items-center px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ str_contains($currentRoute, 'master.area') ? 'bg-primary text-white shadow-xs font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        <i class="mdi mdi-layers-triple-outline text-lg mr-2.5 flex-shrink-0"></i>
                        <span x-show="sidebarOpen">Area Hierarki</span>
                    </a>
                @endif

                <a href="{{ route('master.route') }}" class="flex items-center px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ str_contains($currentRoute, 'master.route') ? 'bg-primary text-white shadow-xs font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <i class="mdi mdi-routes text-lg mr-2.5 flex-shrink-0"></i>
                    <span x-show="sidebarOpen">Master Route</span>
                </a>

                @if(in_array($role, ['Fleet Admin', 'Admin Pusat', 'IT']))
                    <a href="{{ route('master.vehicle') }}" class="flex items-center px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ str_contains($currentRoute, 'master.vehicle') ? 'bg-primary text-white shadow-xs font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        <i class="mdi mdi-truck-delivery-outline text-lg mr-2.5 flex-shrink-0"></i>
                        <span x-show="sidebarOpen">Fleet (Concox GT06N)</span>
                    </a>
                @endif
            @endif

            <!-- OPERATIONAL TRANSACTIONS -->
            @if(!$isOwner)
                <div class="pt-3 pb-1 px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider" x-show="sidebarOpen">Transaksi</div>

                <a href="{{ route('transaksi.sales-visit') }}" class="flex items-center px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ str_contains($currentRoute, 'transaksi.sales-visit') ? 'bg-primary text-white shadow-xs font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <i class="mdi mdi-clipboard-check-outline text-lg mr-2.5 flex-shrink-0"></i>
                    <span x-show="sidebarOpen">Sales Visit GPS</span>
                </a>

                <a href="{{ route('transaksi.sales-order') }}" class="flex items-center px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ str_contains($currentRoute, 'transaksi.sales-order') ? 'bg-primary text-white shadow-xs font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <i class="mdi mdi-cart-outline text-lg mr-2.5 flex-shrink-0"></i>
                    <span x-show="sidebarOpen">Sales Order (SAP)</span>
                </a>

                <a href="{{ route('transaksi.noo') }}" class="flex items-center px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ str_contains($currentRoute, 'transaksi.noo') ? 'bg-primary text-white shadow-xs font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <i class="mdi mdi-account-plus-outline text-lg mr-2.5 flex-shrink-0"></i>
                    <span x-show="sidebarOpen">NOO (New Outlet)</span>
                </a>

                <a href="{{ route('transaksi.nop') }}" class="flex items-center px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ str_contains($currentRoute, 'transaksi.nop') ? 'bg-primary text-white shadow-xs font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <i class="mdi mdi-archive-plus-outline text-lg mr-2.5 flex-shrink-0"></i>
                    <span x-show="sidebarOpen">NOP (New Product)</span>
                </a>

                <a href="{{ route('transaksi.ro') }}" class="flex items-center px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ str_contains($currentRoute, 'transaksi.ro') ? 'bg-primary text-white shadow-xs font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <i class="mdi mdi-repeat-variant text-lg mr-2.5 flex-shrink-0"></i>
                    <span x-show="sidebarOpen">RO / ROA</span>
                </a>
            @endif

            <!-- ADMINISTRATION SECTION -->
            @if(in_array($role, ['Admin Pusat', 'IT']))
                <div class="pt-3 pb-1 px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider" x-show="sidebarOpen">Administration</div>
                <a href="{{ route('administration.user') }}" class="flex items-center px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ str_contains($currentRoute, 'administration.user') ? 'bg-primary text-white shadow-xs font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <i class="mdi mdi-shield-account-outline text-lg mr-2.5 flex-shrink-0"></i>
                    <span x-show="sidebarOpen">User Management</span>
                </a>
                <a href="{{ route('administration.role-permission') }}" class="flex items-center px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ str_contains($currentRoute, 'administration.role-permission') ? 'bg-primary text-white shadow-xs font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <i class="mdi mdi-key-variant text-lg mr-2.5 flex-shrink-0"></i>
                    <span x-show="sidebarOpen">Role & Permission</span>
                </a>
                <a href="{{ route('administration.integration') }}" class="flex items-center px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ str_contains($currentRoute, 'administration.integration') ? 'bg-primary text-white shadow-xs font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <i class="mdi mdi-api text-lg mr-2.5 flex-shrink-0"></i>
                    <span x-show="sidebarOpen">SAP Integration</span>
                </a>
                <a href="{{ route('administration.audit-log') }}" class="flex items-center px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ str_contains($currentRoute, 'administration.audit-log') ? 'bg-primary text-white shadow-xs font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    <i class="mdi mdi-history text-lg mr-2.5 flex-shrink-0"></i>
                    <span x-show="sidebarOpen">Audit Log</span>
                </a>
            @endif
        </nav>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-slate-50">
        
        <!-- Header -->
        <header class="h-16 bg-white border-b border-slate-200/90 px-4 md:px-6 flex items-center justify-between z-20 shadow-xs">
            
            <div class="flex items-center space-x-3 md:space-x-4">
                <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-xl text-slate-500 hover:text-slate-900 hover:bg-slate-100 focus:outline-none cursor-pointer">
                    <i class="mdi mdi-menu text-xl"></i>
                </button>

                <!-- Current Scope Info -->
                <div class="hidden sm:flex items-center gap-2">
                    <span class="text-xs font-bold text-slate-900">PT. Kartini Teh Dandang</span>
                    <span class="text-[10px] px-2.5 py-0.5 rounded-full bg-primary-50 text-primary-700 font-bold border border-primary-200">
                        {{ $authUser['role'] ?? 'Owner' }} Mode
                    </span>
                </div>
            </div>

            <!-- Right Header Controls: Role Switcher Dropdown -->
            <div class="flex items-center space-x-3 md:space-x-4">
                
                <!-- Quick Role Switcher Pill Dropdown -->
                <div class="relative" x-data="{ userMenu: false }">
                    <button @click="userMenu = !userMenu" class="flex items-center space-x-2.5 px-3 py-1.5 rounded-xl bg-slate-50 hover:bg-slate-100 transition-all border border-slate-200/90 cursor-pointer">
                        <img src="{{ $authUser['avatar'] ?? 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150' }}" class="w-7 h-7 rounded-full object-cover ring-2 ring-primary/20" alt="User">
                        <div class="text-left">
                            <span class="text-xs font-bold text-slate-900 block leading-tight">{{ $authUser['name'] ?? 'Owner' }}</span>
                            <span class="text-[10px] text-primary font-semibold block">{{ $authUser['role'] ?? 'Owner' }}</span>
                        </div>
                        <i class="mdi mdi-chevron-down text-slate-400"></i>
                    </button>

                    <!-- Role Selector Dropdown -->
                    <div x-show="userMenu" @click.outside="userMenu = false" x-cloak class="absolute right-0 mt-2 w-72 bg-white border border-slate-200 rounded-2xl shadow-xl p-3 z-50">
                        <div class="border-b border-slate-100 pb-2 mb-2">
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Simulasi Sesi Pengguna:</p>
                            <p class="text-xs font-bold text-slate-900">{{ $authUser['name'] }}</p>
                            <p class="text-[11px] text-primary font-medium">Role: {{ $authUser['role'] }}</p>
                        </div>
                        
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Ganti Akun & Hak Akses:</p>
                        <div class="space-y-1 max-h-60 overflow-y-auto">
                            @foreach($allUsers as $u)
                                <a 
                                    href="?switch_user={{ $u['username'] }}"
                                    class="w-full flex items-center justify-between p-2 rounded-xl text-xs transition-all {{ $u['username'] === ($authUser['username'] ?? 'owner') ? 'bg-primary-50 text-primary-700 font-bold border border-primary-200' : 'text-slate-700 hover:bg-slate-100' }}"
                                >
                                    <span>{{ $u['name'] }}</span>
                                    <span class="text-[10px] px-2 py-0.5 rounded bg-slate-100 text-slate-700 font-semibold">{{ $u['role'] }}</span>
                                </a>
                            @endforeach
                        </div>

                        <div class="border-t border-slate-100 pt-2 mt-2">
                            <a href="{{ route('logout') }}" class="w-full text-left text-xs text-rose-600 hover:text-rose-700 flex items-center gap-2 p-1.5 rounded-xl hover:bg-rose-50 font-semibold">
                                <i class="mdi mdi-logout-variant"></i> Reset Session
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

    <!-- Clean Professional Toast Container (Replaces browser alert hacks) -->
    <div 
        x-data="toastManager()" 
        @notify.window="add($event.detail)" 
        class="fixed bottom-5 right-5 z-50 flex flex-col gap-2 max-w-sm pointer-events-none"
    >
        <template x-for="toast in toasts" :key="toast.id">
            <div 
                x-show="toast.visible" 
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-2"
                class="pointer-events-auto flex items-center gap-3 p-3.5 rounded-xl bg-white border border-slate-200/90 shadow-lg text-xs"
            >
                <div class="w-7 h-7 rounded-lg flex items-center justify-center flex-shrink-0"
                     :class="{
                        'bg-emerald-50 text-emerald-600': toast.type === 'success',
                        'bg-amber-50 text-amber-600': toast.type === 'warning',
                        'bg-rose-50 text-rose-600': toast.type === 'error',
                        'bg-blue-50 text-blue-600': toast.type === 'info'
                     }">
                    <i class="mdi text-base" :class="{
                        'mdi-check-circle-outline': toast.type === 'success',
                        'mdi-alert-outline': toast.type === 'warning',
                        'mdi-close-circle-outline': toast.type === 'error',
                        'mdi-information-outline': toast.type === 'info'
                    }"></i>
                </div>
                <div class="flex-1 text-slate-800 font-medium leading-snug" x-text="toast.message"></div>
                <button @click="dismiss(toast.id)" class="text-slate-400 hover:text-slate-600 p-1">
                    <i class="mdi mdi-close text-sm"></i>
                </button>
            </div>
        </template>
    </div>

    <script>
        // Global helper for sleek toast notifications
        window.notify = function(message, type = 'success') {
            window.dispatchEvent(new CustomEvent('notify', { detail: { message, type } }));
        };

        function toastManager() {
            return {
                toasts: [],
                add(detail) {
                    const id = Date.now();
                    const toast = {
                        id,
                        message: typeof detail === 'string' ? detail : detail.message,
                        type: (typeof detail === 'object' && detail.type) ? detail.type : 'success',
                        visible: true
                    };
                    this.toasts.push(toast);
                    setTimeout(() => { this.dismiss(id); }, 3500);
                },
                dismiss(id) {
                    const idx = this.toasts.findIndex(t => t.id === id);
                    if (idx !== -1) {
                        this.toasts[idx].visible = false;
                        setTimeout(() => {
                            this.toasts = this.toasts.filter(t => t.id !== id);
                        }, 200);
                    }
                }
            };
        }

    </script>
    @stack('scripts')
</body>
</html>
