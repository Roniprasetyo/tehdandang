@extends('layouts.app')

@section('title', 'User Management')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
        <div>
            <h1 class="text-xl font-bold font-display text-slate-900">Administration — User Management</h1>
            <p class="text-xs text-slate-500 mt-0.5">Kelola pengguna sistem, NPK, role hak akses, dan scope wilayah</p>
        </div>
    </div>

    <!-- Users Table -->
    <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-4">NPK</th>
                        <th class="py-3 px-4">USERNAME</th>
                        <th class="py-3 px-4">FULL NAME</th>
                        <th class="py-3 px-4">SYSTEM ROLE</th>
                        <th class="py-3 px-4">AREA SCOPE</th>
                        <th class="py-3 px-4">SAP SLPCODE</th>
                        <th class="py-3 px-4 text-right">SWITCH / ACTIONS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($users as $u)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="py-3 px-4 font-mono font-bold text-indigo-600">{{ $u['npk'] }}</td>
                        <td class="py-3 px-4 font-mono text-slate-600">{{ $u['username'] }}</td>
                        <td class="py-3 px-4 font-bold text-slate-900 flex items-center gap-2">
                            <img src="{{ $u['avatar'] }}" class="w-6 h-6 rounded-full object-cover" alt="Avatar">
                            <span>{{ $u['name'] }}</span>
                        </td>
                        <td class="py-3 px-4">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-200">
                                {{ $u['role'] }}
                            </span>
                        </td>
                        <td class="py-3 px-4 font-medium text-slate-700">{{ $u['area'] }} ({{ $u['region'] }})</td>
                        <td class="py-3 px-4 font-mono text-emerald-600 font-bold">{{ $u['slp_code'] ?? '-' }}</td>
                        <td class="py-3 px-4 text-right">
                            <a href="?switch_user={{ $u['username'] }}" class="px-3 py-1.5 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold shadow-xs">
                                Login as User
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
