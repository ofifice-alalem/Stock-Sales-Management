@extends('layouts.admin')

@section('content')
<div>
    <div class="flex gap-2 mb-6">
        <a href="{{ route('marketer.invoices.pdf', $invoice->id) }}" class="flex-1 md:flex-none bg-gradient-to-r from-red-600 to-pink-600 hover:from-red-700 hover:to-pink-700 text-white px-6 py-3 rounded-xl transition-all shadow-lg flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            PDF
        </a>
        <a href="{{ route('marketer.invoices.edit', $invoice->id) }}" class="flex-1 md:flex-none bg-gradient-to-r from-yellow-600 to-orange-600 hover:from-yellow-700 hover:to-orange-700 text-white px-6 py-3 rounded-xl transition-all shadow-lg flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            تعديل
        </a>
        <a href="{{ route('marketer.invoices.index') }}" class="flex-1 md:flex-none bg-white/5 hover:bg-white/10 text-white px-6 py-3 rounded-xl transition-all border border-white/10 flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            رجوع
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-8">
        <div class="stat-card rounded-xl p-4 border border-white/5 shadow-xl">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-blue-800 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-1">رقم الفاتورة</p>
                    <p class="text-lg font-bold text-white">{{ $invoice->invoice_number }}</p>
                </div>
            </div>
        </div>
        <div class="stat-card rounded-xl p-4 border border-white/5 shadow-xl">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-purple-600 to-purple-800 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-1">التاريخ</p>
                    <p class="text-lg font-bold text-white">{{ $invoice->created_at->format('Y-m-d') }}</p>
                    <p class="text-xs text-gray-400">{{ $invoice->created_at->format('H:i') }}</p>
                </div>
            </div>
        </div>
        <div class="stat-card rounded-xl p-4 border border-white/5 shadow-xl">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-green-600 to-green-800 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-1">المحل</p>
                    <p class="text-lg font-bold text-white">{{ $invoice->store->name }}</p>
                </div>
            </div>
        </div>
        <div class="stat-card rounded-xl p-4 border border-white/5 shadow-xl">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-yellow-600 to-orange-600 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-1">المبلغ الإجمالي</p>
                    <p class="text-xl font-bold text-green-400">{{ number_format($invoice->total_amount ?? 0, 2) }}</p>
                    <p class="text-xs text-gray-400">جنيه</p>
                </div>
            </div>
        </div>
    </div>

    @if($invoice->items->count() > 0)
    <div class="stat-card rounded-2xl border border-white/5 shadow-xl overflow-hidden">
        <div class="p-6 bg-gradient-to-r from-purple-600/10 to-blue-600/10 border-b border-white/5">
            <h2 class="text-xl font-bold text-white flex items-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                المنتجات
            </h2>
        </div>
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full">
                <thead class="bg-white/5">
                    <tr>
                        <th class="px-6 py-4 text-right text-sm font-medium text-gray-400">المنتج</th>
                        <th class="px-6 py-4 text-right text-sm font-medium text-gray-400">الكمية</th>
                        <th class="px-6 py-4 text-right text-sm font-medium text-gray-400">السعر</th>
                        <th class="px-6 py-4 text-right text-sm font-medium text-gray-400">الإجمالي</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @foreach($invoice->items as $item)
                    <tr class="hover:bg-white/5 transition-colors">
                        <td class="px-6 py-4 text-white font-medium">{{ $item->product->name }}</td>
                        <td class="px-6 py-4 text-gray-400">{{ $item->quantity }}</td>
                        <td class="px-6 py-4 text-gray-400">{{ number_format($item->price ?? 0, 2) }} جنيه</td>
                        <td class="px-6 py-4 text-green-400 font-bold">{{ number_format(($item->price ?? 0) * $item->quantity, 2) }} جنيه</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="md:hidden divide-y divide-white/5">
            @foreach($invoice->items as $item)
            <div class="p-4 hover:bg-white/5 transition-colors">
                <div class="flex justify-between items-start mb-3">
                    <div class="font-medium text-white">{{ $item->product->name }}</div>
                    <div class="text-green-400 font-bold">{{ number_format(($item->price ?? 0) * $item->quantity, 2) }} جنيه</div>
                </div>
                <div class="grid grid-cols-2 gap-2 text-sm">
                    <div>
                        <span class="text-gray-400">الكمية:</span>
                        <span class="text-white mr-1">{{ $item->quantity }}</span>
                    </div>
                    <div>
                        <span class="text-gray-400">السعر:</span>
                        <span class="text-white mr-1">{{ number_format($item->price ?? 0, 2) }} جنيه</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
