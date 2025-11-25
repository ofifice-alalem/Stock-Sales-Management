@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-white">أرباحي</h1>
</div>

<div class="stat-card rounded-2xl p-6 border border-white/5 shadow-xl mb-6">
    <div class="flex items-center justify-between">
        <h2 class="text-lg font-semibold text-white">إجمالي البضاعة</h2>
        <div class="text-3xl font-bold text-green-400">{{ number_format($totalEarnings, 2) }} جنيه</div>
    </div>
</div>

<div class="stat-card rounded-2xl border border-white/5 shadow-xl">
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
                    <td class="px-6 py-4 text-gray-400">{{ number_format($item->price, 2) }} جنيه</td>
                    <td class="px-6 py-4 text-gray-400">{{ $item->quantity }}</td>
                    <td class="px-6 py-4 text-white font-medium">{{ number_format($item->total, 2) }} جنيه</td>
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
@endsection
