@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-white">مخزوني</h1>
</div>

<div class="stat-card rounded-2xl p-6 border border-white/5 shadow-xl mb-6">
    <div class="flex items-center justify-between">
        <h2 class="text-lg font-semibold text-white">إجمالي قيمة المخزون</h2>
        <div class="text-3xl font-bold text-green-400">{{ number_format($totalValue, 2) }} دينار</div>
    </div>
</div>

<div class="hidden md:block stat-card rounded-2xl border border-white/5 shadow-xl">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-white/5">
                <tr>
                    <th class="px-6 py-4 text-right text-sm font-medium text-gray-400">الرقم</th>
                    <th class="px-6 py-4 text-right text-sm font-medium text-gray-400">اسم المنتج</th>
                    <th class="px-6 py-4 text-right text-sm font-medium text-gray-400">الكمية</th>
                    <th class="px-6 py-4 text-right text-sm font-medium text-gray-400">السعر</th>
                    <th class="px-6 py-4 text-right text-sm font-medium text-gray-400">الإجمالي</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($products as $index => $product)
                <tr class="hover:bg-white/5 transition-colors">
                    <td class="px-6 py-4 text-white">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 text-white">{{ $product->name }}</td>
                    <td class="px-6 py-4 text-gray-400">{{ $product->quantity }}</td>
                    <td class="px-6 py-4 text-gray-400">{{ number_format($product->price, 2) }} دينار</td>
                    <td class="px-6 py-4 text-white font-medium">{{ number_format($product->quantity * $product->price, 2) }} دينار</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-400">لا توجد منتجات في المخزون</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="md:hidden space-y-4 pb-24">
    @forelse($products as $index => $product)
    <div class="stat-card rounded-2xl p-4 border border-white/5 shadow-xl">
        <div class="flex justify-between items-start mb-3">
            <div>
                <div class="text-xs text-gray-400 mb-1">المنتج {{ $index + 1 }}</div>
                <div class="text-white font-medium">{{ $product->name }}</div>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-3 mb-3">
            <div>
                <div class="text-xs text-gray-400 mb-1">الكمية</div>
                <div class="text-blue-400 font-medium">{{ $product->quantity }}</div>
            </div>
            <div class="text-left">
                <div class="text-xs text-gray-400 mb-1">السعر</div>
                <div class="text-gray-300 font-medium">{{ number_format($product->price, 2) }} دينار</div>
            </div>
        </div>
        <div class="flex justify-between items-center pt-3 border-t border-white/5">
            <div class="text-gray-400 text-sm">الإجمالي</div>
            <div class="text-green-400 font-bold text-lg">{{ number_format($product->quantity * $product->price, 2) }} دينار</div>
        </div>
    </div>
    @empty
    <div class="stat-card rounded-2xl p-8 border border-white/5 shadow-xl text-center">
        <div class="text-gray-400">لا توجد منتجات في المخزون</div>
    </div>
    @endforelse
</div>
@endsection
