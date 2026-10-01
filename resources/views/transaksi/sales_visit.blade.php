@extends('layouts.app')

@section('title', 'Sales Visit & GPS Check-in')

@section('content')
<div class="space-y-6" x-data="{ showForm: false }">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
        <div>
            <h1 class="text-xl font-bold font-display text-slate-900">Sales Visit & Concox GT06N Verification</h1>
            <p class="text-xs text-slate-500 mt-0.5">Pencatatan kunjungan outlet, verifikasi radius GPS, waktu check-in/out</p>
        </div>
        <button @click="showForm = !showForm" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-md shadow-indigo-200 flex items-center gap-1.5">
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span x-text="showForm ? 'Close Form' : '+ Record New Visit'">+ Record New Visit</span>
        </button>
    </div>

    <!-- Visit Form -->
    <div x-show="showForm" x-cloak class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-sm space-y-4">
        <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-3">
            <i data-lucide="navigation" class="w-4 h-4 text-indigo-600"></i> Form Check-in Sales Visit (Concox GT06N Radius)
        </h3>
        <form @submit.prevent="alert('Visit recorded successfully!'); showForm = false" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-xs">
            <div>
                <label class="block text-slate-600 mb-1 font-semibold">Target Outlet:</label>
                <select required class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl p-2.5 focus:outline-none focus:border-indigo-500">
                    <option value="">-- Select Outlet --</option>
                    @foreach($outlets as $o)
                    <option value="{{ $o['card_code'] }}">{{ $o['card_name'] }} ({{ $o['address'] }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-slate-600 mb-1 font-semibold">Check-in Time:</label>
                <input type="text" value="08:15" readonly class="w-full bg-slate-50 border border-slate-200 text-slate-500 rounded-xl p-2.5 font-mono">
            </div>
            <div>
                <label class="block text-slate-600 mb-1 font-semibold">Sales Activity:</label>
                <select class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl p-2.5 focus:outline-none focus:border-indigo-500">
                    <option>Order Taking & Merchandising</option>
                    <option>Payment Collection</option>
                    <option>Routine Check Stock</option>
                    <option>Account Proposal Followup</option>
                </select>
            </div>
            <div>
                <label class="block text-slate-600 mb-1 font-semibold">Visit Result:</label>
                <input type="text" placeholder="e.g.: Order Created (Rp 250.000)" class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl p-2.5 focus:outline-none focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-slate-600 mb-1 font-semibold">Concox GT06N GPS Coordinate:</label>
                <input type="text" value="-6.9218, 107.6071 (Distance: 80m - Valid)" readonly class="w-full bg-slate-50 border border-slate-200 text-indigo-600 font-mono font-bold rounded-xl p-2.5">
            </div>
            <div class="md:col-span-2 lg:col-span-3 flex justify-end gap-2 pt-2 border-t border-slate-100">
                <button type="button" @click="showForm = false" class="px-4 py-2 bg-white border border-slate-200 text-slate-700 rounded-xl hover:bg-slate-50 font-semibold">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 shadow-md shadow-indigo-200">Save Visit</button>
            </div>
        </form>
    </div>

    <!-- Visits Table -->
    <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-xs">
        <h3 class="text-sm font-bold text-slate-900 mb-4">Daftar Sales Visit & Validasi Radius GPS</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-4">DATE</th>
                        <th class="py-3 px-4">SALES PERSON</th>
                        <th class="py-3 px-4">OUTLET NAME</th>
                        <th class="py-3 px-4">CHECK-IN</th>
                        <th class="py-3 px-4">CHECK-OUT</th>
                        <th class="py-3 px-4">RADIUS DISTANCE</th>
                        <th class="py-3 px-4">ACTIVITY</th>
                        <th class="py-3 px-4">RESULT</th>
                        <th class="py-3 px-4 text-center">GPS STATUS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($visits as $v)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="py-3 px-4 font-mono text-slate-500">{{ $v['date'] }}</td>
                        <td class="py-3 px-4 font-bold text-slate-900">{{ $v['sales_name'] }}</td>
                        <td class="py-3 px-4 font-bold text-indigo-600">{{ $v['outlet_name'] }}</td>
                        <td class="py-3 px-4 font-mono text-slate-600">{{ $v['checkin_time'] }}</td>
                        <td class="py-3 px-4 font-mono text-slate-600">{{ $v['checkout_time'] }}</td>
                        <td class="py-3 px-4 font-mono font-bold {{ $v['distance_meters'] <= 100 ? 'text-emerald-600' : 'text-rose-600' }}">
                            {{ $v['distance'] }}
                        </td>
                        <td class="py-3 px-4 text-slate-600">{{ $v['activity'] }}</td>
                        <td class="py-3 px-4 font-semibold text-slate-800">{{ $v['result'] }}</td>
                        <td class="py-3 px-4 text-center">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $v['status'] === 'Valid' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-rose-50 text-rose-700 border-rose-200' }}">
                                {{ $v['status_color'] }} {{ $v['status'] }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
