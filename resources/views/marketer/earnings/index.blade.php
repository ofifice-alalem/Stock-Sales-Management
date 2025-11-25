@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-white">أرباحي</h1>
</div>

<div class="stat-card rounded-2xl p-6 border border-white/5 shadow-xl mb-6">
    <div class="flex items-center justify-between">
        <h2 class="text-lg font-semibold text-white">إجمالي البضاعة</h2>
        <div class="text-3xl font-bold text-green-400">{{ number_format($totalEarnings, 2) }} دينار</div>
    </div>
</div>

<div class="hidden md:block stat-card rounded-2xl border border-white/5 shadow-xl">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-white/5">
                <tr>
                    <th class="px-6 py-4 text-right text-sm font-medium text-gray-400">الرقم</th>
                    <th class="px-6 py-4 text-right text-sm font-medium text-gray-400">اسم الصنف</th>
                    <th class="px-6 py-4 text-right text-sm font-medium text-gray-400">السعر</th>
                    <th class="px-6 py-4 text-right text-sm font-medium text-gray-400">الكمية</th>
                    <th class="px-6 py-4 text-right text-sm font-medium text-gray-400">الإجمالي</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($items as $index => $item)
                <tr class="hover:bg-white/5 transition-colors">
                    <td class="px-6 py-4 text-white">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 text-white">{{ $item->productName }}</td>
                    <td class="px-6 py-4 text-gray-400">{{ number_format($item->price, 2) }} دينار</td>
                    <td class="px-6 py-4 text-gray-400">{{ $item->quantity }}</td>
                    <td class="px-6 py-4 text-white font-medium">{{ number_format($item->total, 2) }} دينار</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-400">لا توجد مبيعات حتى الآن</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="md:hidden space-y-4 pb-24">
    @forelse($items as $index => $item)
    <div class="stat-card rounded-2xl p-4 border border-white/5 shadow-xl">
        <div class="flex justify-between items-start mb-3">
            <div>
                <div class="text-xs text-gray-400 mb-1">الرقم</div>
                <div class="text-white font-bold">{{ $index + 1 }}</div>
            </div>
            <div class="text-left">
                <div class="text-xs text-gray-400 mb-1">الكمية</div>
                <div class="text-gray-300 text-sm">{{ $item->quantity }}</div>
            </div>
        </div>
        <div class="mb-3 pb-3 border-b border-white/5">
            <div class="text-xs text-gray-400 mb-1">اسم الصنف</div>
            <div class="text-white font-medium">{{ $item->productName }}</div>
        </div>
        <div class="grid grid-cols-2 gap-3 mb-3">
            <div>
                <div class="text-xs text-gray-400 mb-1">السعر</div>
                <div class="text-blue-400 font-medium">{{ number_format($item->price, 2) }} دينار</div>
            </div>
            <div class="text-left">
                <div class="text-xs text-gray-400 mb-1">الإجمالي</div>
                <div class="text-green-400 font-bold text-lg">{{ number_format($item->total, 2) }} دينار</div>
            </div>
        </div>
    </div>
    @empty
    <div class="stat-card rounded-2xl p-8 border border-white/5 shadow-xl text-center">
        <div class="text-gray-400">لا توجد مبيعات حتى الآن</div>
    </div>
    @endforelse
</div>
@endsection
