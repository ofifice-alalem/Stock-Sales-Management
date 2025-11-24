@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-white">إدارة ديون المحلات</h1>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="stat-card rounded-2xl p-6 border border-white/5 shadow-xl">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-400 text-sm mb-1">إجمالي المبلغ</p>
                <p class="text-2xl font-bold text-white">{{ number_format($stores->sum('total_debt'), 2) }} جنيه</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-blue-500/20 flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="stat-card rounded-2xl p-6 border border-white/5 shadow-xl">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-400 text-sm mb-1">إجمالي المدفوع</p>
                <p class="text-2xl font-bold text-green-400">{{ number_format($stores->sum('total_paid'), 2) }} جنيه</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-green-500/20 flex items-center justify-center">
                <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="stat-card rounded-2xl p-6 border border-white/5 shadow-xl">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-400 text-sm mb-1">إجمالي الديون</p>
                <p class="text-2xl font-bold text-red-400">{{ number_format($stores->sum('remaining'), 2) }} جنيه</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-red-500/20 flex items-center justify-center">
                <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<div class="stat-card rounded-2xl p-6 border border-white/5 shadow-xl mb-6">
    <form method="GET" action="{{ route('admin.store-debts.index') }}" class="flex gap-4">
        <div class="flex-1">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="ابحث باسم المحل..." class="w-full h-[42px] px-4 bg-white/5 border border-white/10 rounded-lg text-white focus:ring-2 focus:ring-blue-500">
        </div>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-all h-[42px]">
            <svg class="w-5 h-5 inline-block ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            بحث
        </button>
        <a href="{{ route('admin.store-debts.index') }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition-all h-[42px] flex items-center">
            إعادة تعيين
        </a>
    </form>
</div>

<div class="stat-card rounded-2xl border border-white/5 shadow-xl">
    <div class="overflow-x-auto">
    <table class="w-full">
        <thead class="bg-white/5">
            <tr>
                <th class="px-6 py-4 text-right text-sm font-medium text-gray-400">اسم المحل</th>
                <th class="px-6 py-4 text-right text-sm font-medium text-gray-400">
                    <a href="?sort=total_debt&direction={{ request('sort') == 'total_debt' && request('direction') == 'asc' ? 'desc' : 'asc' }}{{ request('search') ? '&search=' . request('search') : '' }}" class="flex items-center gap-2 hover:text-white transition-colors">
                        إجمالي المبلغ
                        @if(request('sort') == 'total_debt')
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                @if(request('direction') == 'asc')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                @endif
                            </svg>
                        @endif
                    </a>
                </th>
                <th class="px-6 py-4 text-right text-sm font-medium text-gray-400">
                    <a href="?sort=total_paid&direction={{ request('sort') == 'total_paid' && request('direction') == 'asc' ? 'desc' : 'asc' }}{{ request('search') ? '&search=' . request('search') : '' }}" class="flex items-center gap-2 hover:text-white transition-colors">
                        المدفوع
                        @if(request('sort') == 'total_paid')
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                @if(request('direction') == 'asc')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                @endif
                            </svg>
                        @endif
                    </a>
                </th>
                <th class="px-6 py-4 text-right text-sm font-medium text-gray-400">
                    <a href="?sort=remaining&direction={{ request('sort') == 'remaining' && request('direction') == 'asc' ? 'desc' : 'asc' }}{{ request('search') ? '&search=' . request('search') : '' }}" class="flex items-center gap-2 hover:text-white transition-colors">
                        المتبقي (الدين)
                        @if(request('sort') == 'remaining')
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                @if(request('direction') == 'asc')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                @endif
                            </svg>
                        @endif
                    </a>
                </th>
                <th class="px-6 py-4 text-right text-sm font-medium text-gray-400">
                    <a href="?sort=invoices_count&direction={{ request('sort') == 'invoices_count' && request('direction') == 'asc' ? 'desc' : 'asc' }}{{ request('search') ? '&search=' . request('search') : '' }}" class="flex items-center gap-2 hover:text-white transition-colors">
                        عدد الفواتير
                        @if(request('sort') == 'invoices_count')
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                @if(request('direction') == 'asc')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                @endif
                            </svg>
                        @endif
                    </a>
                </th>
                <th class="px-6 py-4 text-right text-sm font-medium text-gray-400">الإجراءات</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/5">
            @foreach($stores as $store)
            <tr class="hover:bg-white/5 transition-colors">
                <td class="px-6 py-4 text-white font-medium">{{ $store->name }}</td>
                <td class="px-6 py-4 text-white">{{ number_format($store->total_debt, 2) }} جنيه</td>
                <td class="px-6 py-4 text-green-400">{{ number_format($store->total_paid, 2) }} جنيه</td>
                <td class="px-6 py-4 text-red-400 font-bold">{{ number_format($store->remaining, 2) }} جنيه</td>
                <td class="px-6 py-4 text-gray-400">{{ $store->invoices->count() }}</td>
                <td class="px-6 py-4">
                    <a href="{{ route('admin.store-debts.show', $store->id) }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        عرض التفاصيل
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>
@endsection
