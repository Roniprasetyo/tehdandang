<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50 text-slate-800">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PT. Kartini Teh Nasional (Teh Dandang)</title>
    <!-- Google Fonts: Poppins & JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Material Design Icons (MDI) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                    },
                    colors: {
                        primary: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            200: '#bbf7d0',
                            600: '#16a34a',
                            700: '#15803d',
                            800: '#166534',
                            DEFAULT: '#15803d',
                        },
                        secondary: {
                            50: '#fffbeb',
                            100: '#fef3c7',
                            200: '#fde68a',
                            600: '#d97706',
                            700: '#b45309',
                            800: '#92400e',
                            DEFAULT: '#b45309',
                        },
                        accent: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            600: '#0284c7',
                            700: '#0369a1',
                            DEFAULT: '#0284c7',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="h-full flex items-center justify-center p-4 font-sans bg-slate-100">

    <div class="w-full max-w-2xl bg-white border border-slate-200/90 rounded-3xl p-6 md:p-8 shadow-xl relative overflow-hidden">
        
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-primary p-0.5 shadow-md shadow-emerald-900/10 mb-4">
                <div class="w-full h-full bg-white rounded-[14px] flex items-center justify-center">
                    <i class="mdi mdi-tea text-3xl text-primary"></i>
                </div>
            </div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-wide font-normal">TEH DANDANG</h1>
            <p class="text-xs text-slate-500 mt-1 uppercase tracking-widest font-semibold">PT. Kartini Teh Nasional — Batang, Jawa Tengah</p>
            <div class="inline-flex items-center gap-2 mt-3 px-3 py-1 rounded-full bg-primary/10 border border-primary/20 text-primary text-xs font-semibold">
                <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                <span>Sales Monitoring System & Enterprise Portal</span>
            </div>
        </div>

        <div class="mb-6">
            <h2 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3 text-center">Pilih Akun Profil Untuk Akses:</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                @foreach($users as $u)
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <input type="hidden" name="username" value="{{ $u['username'] }}">
                        <button type="submit" class="w-full text-left p-3.5 rounded-2xl bg-slate-50 hover:bg-emerald-50/50 border border-slate-200 hover:border-primary/50 transition-all duration-150 active:translate-y-px group flex flex-col justify-between h-full shadow-xs cursor-pointer">
                            <div class="flex items-center space-x-3 mb-2">
                                <img src="{{ $u['avatar'] }}" class="w-8 h-8 rounded-lg object-cover ring-1 ring-slate-200" alt="Avatar">
                                <div class="overflow-hidden">
                                    <div class="font-bold text-xs text-slate-900 group-hover:text-primary transition-colors truncate">{{ $u['name'] }}</div>
                                    <div class="text-[10px] text-slate-500 font-mono tabular-nums">{{ $u['username'] }}</div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between mt-auto pt-2 border-t border-slate-200/60">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-primary/10 text-primary">
                                    {{ $u['role'] }}
                                </span>
                                <span class="text-[10px] text-slate-500 font-medium">{{ $u['area'] }}</span>
                            </div>
                        </button>
                    </form>
                @endforeach
            </div>
        </div>

        <div class="border-t border-slate-100 pt-4 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-2">
            <div class="flex items-center gap-2">
                <i class="mdi mdi-shield-check text-emerald-600 text-base"></i>
                <span class="font-medium">SAP B1 + Concox GT06N GPS Terintegrasi</span>
            </div>
            <div class="font-mono tabular-nums text-[11px] text-slate-400">Teh Dandang SFA v2.4</div>
        </div>
    </div>
</body>
</html>
