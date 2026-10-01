<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50 text-slate-800">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PT. Kartini Teh Nasional (Teh Dandang)</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="h-full flex items-center justify-center p-4 font-sans bg-slate-100">

    <div class="w-full max-w-2xl bg-white border border-slate-200/80 rounded-3xl p-6 md:p-8 shadow-xl relative overflow-hidden">
        
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-indigo-600 p-0.5 shadow-md shadow-indigo-100 mb-4">
                <div class="w-full h-full bg-white rounded-[14px] flex items-center justify-center">
                    <i data-lucide="cup-soda" class="w-8 h-8 text-indigo-600"></i>
                </div>
            </div>
            <h1 class="text-2xl font-bold font-display text-slate-900 tracking-wide">TEH DANDANG</h1>
            <p class="text-xs text-slate-500 mt-1 uppercase tracking-widest font-bold">PT. Kartini Teh Nasional — Batang, Jawa Tengah</p>
            <div class="inline-flex items-center gap-2 mt-3 px-3 py-1 rounded-full bg-indigo-50 border border-indigo-200 text-indigo-700 text-xs font-semibold">
                <span class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></span>
                <span>Sales Monitoring System — Prototype Mode</span>
            </div>
        </div>

        <div class="mb-6">
            <h2 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3 text-center">Pilih Account Mock User Untuk Login:</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                @foreach($users as $u)
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <input type="hidden" name="username" value="{{ $u['username'] }}">
                        <button type="submit" class="w-full text-left p-3.5 rounded-2xl bg-slate-50 hover:bg-indigo-50/60 border border-slate-200/80 hover:border-indigo-300 transition-all group flex flex-col justify-between h-full shadow-xs">
                            <div class="flex items-center space-x-3 mb-2">
                                <img src="{{ $u['avatar'] }}" class="w-8 h-8 rounded-lg object-cover ring-1 ring-slate-200" alt="Avatar">
                                <div class="overflow-hidden">
                                    <div class="font-bold text-xs text-slate-900 group-hover:text-indigo-600 transition-colors truncate">{{ $u['name'] }}</div>
                                    <div class="text-[10px] text-slate-500 font-mono">{{ $u['username'] }}</div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between mt-auto pt-2 border-t border-slate-200/60">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-indigo-100 text-indigo-700">
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
                <i data-lucide="shield-check" class="w-4 h-4 text-emerald-600"></i>
                <span class="font-medium">SAP B1 + Concox GT06N GPS Ready</span>
            </div>
            <div class="font-mono text-[11px]">Laravel v9.x Metis Theme</div>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
