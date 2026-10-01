@extends('layouts.app')

@section('title', 'NOP (New Open Product)')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
        <div>
            <h1 class="text-xl font-bold font-display text-slate-900">NOP (New Open Product) Tracking</h1>
            <p class="text-xs text-slate-500 mt-0.5">Penambahan varian SKU Teh Dandang baru yang berhasil masuk ke outlet existing</p>
        </div>
    </div>

    <!-- NOP Comparison Table -->
    <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs">
        <h3 class="text-sm font-bold text-slate-900 mb-4">Tracking Penambahan SKU Baru per Outlet (Before vs After Expansion)</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-4">CARD CODE</th>
                        <th class="py-3 px-4">OUTLET NAME</th>
                        <th class="py-3 px-4">SALES ASSIGNED</th>
                        <th class="py-3 px-4">BEFORE PRODUCTS</th>
                        <th class="py-3 px-4">AFTER PRODUCTS</th>
                        <th class="py-3 px-4">NEW NOP ITEM</th>
                        <th class="py-3 px-4">DATE ADDED</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($nop as $np)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="py-3 px-4 font-mono font-bold text-indigo-600">{{ $np['card_code'] }}</td>
                        <td class="py-3 px-4 font-bold text-slate-900">{{ $np['outlet_name'] }}</td>
                        <td class="py-3 px-4 text-slate-700">{{ $np['sales_name'] }}</td>
                        <td class="py-3 px-4 text-slate-500">
                            {{ implode(', ', $np['before_products']) }}
                        </td>
                        <td class="py-3 px-4 text-slate-800 font-medium">
                            {{ implode(', ', $np['after_products']) }}
                        </td>
                        <td class="py-3 px-4">
                            <span class="px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 font-bold border border-emerald-200">
                                ✨ {{ $np['nop_item'] }} ({{ $np['item_code'] }})
                            </span>
                        </td>
                        <td class="py-3 px-4 font-mono text-slate-500">{{ $np['date_added'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
