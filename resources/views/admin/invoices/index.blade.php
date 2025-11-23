@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-white">إدارة الفواتير</h1>
    <a href="{{ route('admin.invoices.create') }}" class="bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white px-6 py-3 rounded-lg transition-all shadow-lg">
        <svg class="w-5 h-5 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        إضافة فاتورة جديدة
    </a>
</div>

@if(session('success'))
<div class="bg-green-500/20 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg mb-6">
    {{ session('success') }}
</div>
@endif

<div class="stat-card rounded-2xl border border-white/5 shadow-xl overflow-hidden">
    <table class="w-full">
        <thead class="bg-white/5">
            <tr>
                <th class="px-6 py-4 text-right text-sm font-medium text-gray-400">رقم الفاتورة</th>
                <th class="px-6 py-4 text-right text-sm font-medium text-gray-400">المسوق</th>
                <th class="px-6 py-4 text-right text-sm font-medium text-gray-400">المحل</th>
                <th class="px-6 py-4 text-right text-sm font-medium text-gray-400">المبلغ</th>
                <th class="px-6 py-4 text-right text-sm font-medium text-gray-400">التاريخ</th>
                <th class="px-6 py-4 text-right text-sm font-medium text-gray-400">الإجراءات</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/5">
            @foreach($invoices as $invoice)
            <tr class="hover:bg-white/5 transition-colors">
                <td class="px-6 py-4 text-white font-medium">{{ $invoice->invoice_number }}</td>
                <td class="px-6 py-4 text-gray-400">{{ $invoice->marketer->name }}</td>
                <td class="px-6 py-4 text-gray-400">{{ $invoice->store->name }}</td>
                <td class="px-6 py-4 text-white">{{ number_format($invoice->total_amount ?? 0, 2) }} جنيه</td>
                <td class="px-6 py-4 text-gray-400">{{ $invoice->created_at->format('Y-m-d') }}</td>
                <td class="px-6 py-4">
                    <div class="flex gap-2">
                        <a href="{{ route('admin.invoices.show', $invoice->id) }}" class="text-blue-400 hover:text-blue-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </a>
                        <a href="{{ route('admin.invoices.edit', $invoice->id) }}" class="text-yellow-400 hover:text-yellow-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </a>
                        <form action="{{ route('admin.invoices.destroy', $invoice->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-400 hover:text-red-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $invoices->links() }}
</div>
@endsection