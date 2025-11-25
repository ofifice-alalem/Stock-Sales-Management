@extends('layouts.admin')

@section('content')
<div class="max-w-4xl">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-white">تفاصيل الفاتورة #{{ $invoice->invoice_number }}</h1>
        <div class="flex gap-2">
            <a href="{{ route('admin.invoices.edit', $invoice->id) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg transition-all">
                تعديل
            </a>
            <a href="{{ route('admin.invoices.index') }}" class="bg-white/5 hover:bg-white/10 text-white px-4 py-2 rounded-lg transition-all">
                رجوع
            </a>
        </div>
    </div>

    <div class="stat-card rounded-2xl p-6 border border-white/5 shadow-xl mb-6">
        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1">رقم الفاتورة</label>
                <p class="text-white text-lg">{{ $invoice->invoice_number }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1">التاريخ</label>
                <p class="text-white text-lg">{{ $invoice->created_at->format('Y-m-d H:i') }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1">المسوق</label>
                <p class="text-white text-lg">{{ $invoice->marketer->name }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1">المحل</label>
                <p class="text-white text-lg">{{ $invoice->store->name }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1">المبلغ الإجمالي</label>
                <p class="text-white text-lg font-bold">{{ number_format($invoice->total_amount ?? 0, 2) }} دينار</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1">حالة الإرسال</label>
                <p class="text-white text-lg">
                    @if($invoice->sent_to_whatsapp)
                        <span class="text-green-400">تم الإرسال</span>
                    @else
                        <span class="text-gray-400">لم يتم الإرسال</span>
                    @endif
                </p>
            </div>
        </div>
    </div>

    @if($invoice->items->count() > 0)
    <div class="stat-card rounded-2xl border border-white/5 shadow-xl overflow-hidden">
        <div class="p-6 bg-white/5">
            <h2 class="text-xl font-bold text-white">المنتجات</h2>
        </div>
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
                    <td class="px-6 py-4 text-white">{{ $item->product->name }}</td>
                    <td class="px-6 py-4 text-gray-400">{{ $item->quantity }}</td>
                    <td class="px-6 py-4 text-gray-400">{{ number_format($item->price ?? 0, 2) }} دينار</td>
                    <td class="px-6 py-4 text-white font-medium">{{ number_format(($item->price ?? 0) * $item->quantity, 2) }} دينار</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection
