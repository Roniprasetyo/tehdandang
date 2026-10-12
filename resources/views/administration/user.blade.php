@extends('layouts.app')

@section('title', 'User Management')

@section('content')
<div class="space-y-6">

    <!-- Header Banner -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-xl border border-slate-200/90 shadow-xs">
        <div>
            <h1 class="text-xl font-bold text-slate-900">Manajemen Pengguna (User Management)</h1>
            <p class="text-xs text-slate-500 mt-0.5">Kelola pengguna sistem, NPK, role hak akses, dan scope wilayah</p>
        </div>
    </div>

    <!-- Users Table -->
    <div class="bg-white border border-slate-200/90 rounded-xl p-5 shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-4">NPK</th>
                        <th class="py-3 px-4">USERNAME</th>
                        <th class="py-3 px-4">NAMA LENGKAP</th>
                        <th class="py-3 px-4">PERAN SISTEM</th>
                        <th class="py-3 px-4">CAKUPAN WILAYAH</th>
                        <th class="py-3 px-4">KODE SAP SLP</th>
                        <th class="py-3 px-4 text-right">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($users as $u)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="py-3 px-4 font-mono font-bold text-primary tabular-nums">{{ $u['npk'] }}</td>
                        <td class="py-3 px-4 font-mono text-slate-600">{{ $u['username'] }}</td>
                        <td class="py-3 px-4 font-bold text-slate-900 flex items-center gap-2">
                            <img src="{{ $u['avatar'] }}" class="w-6 h-6 rounded-full object-cover ring-1 ring-slate-200" alt="Avatar">
                            <span>{{ $u['name'] }}</span>
                        </td>
                        <td class="py-3 px-4">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-primary-50 text-primary-700 border border-primary-200">
                                {{ $u['role'] }}
                            </span>
                        </td>
                        <td class="py-3 px-4 font-medium text-slate-700">{{ $u['area'] }} ({{ $u['region'] }})</td>
                        <td class="py-3 px-4 font-mono text-emerald-700 font-bold tabular-nums">{{ $u['slp_code'] ?? '-' }}</td>
                        <td class="py-3 px-4 text-right">
                            <a href="?switch_user={{ $u['username'] }}" class="btn-secondary-outline text-xs inline-flex items-center gap-1 active:translate-y-px">
                                Login Sebagai User
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
