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

<div class="stat-card rounded-2xl p-6 border border-white/5 shadow-xl mb-6 overflow-visible">
    <form method="GET" action="{{ route('admin.invoices.index') }}" class="grid grid-cols-4 gap-4">
        <div>
            <label class="block text-sm font-medium text-white mb-2">رقم الفاتورة</label>
            <input type="text" name="invoice_number" value="{{ request('invoice_number') }}" placeholder="ابحث برقم الفاتورة" class="w-full h-[42px] px-4 bg-white/5 border border-white/10 rounded-lg text-white focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-white mb-2">المسوق</label>
            <div class="relative">
                <input type="text" class="marketer-search w-full h-[42px] px-4 bg-white/5 border border-white/10 rounded-lg text-white focus:ring-2 focus:ring-blue-500" placeholder="اختر مسوق..." value="{{ $marketers->firstWhere('id', request('marketer_id'))?->name ?? '' }}" autocomplete="off">
                <div class="marketer-dropdown absolute z-[99999] w-full mt-1 bg-gray-800 border border-white/20 rounded-lg shadow-2xl max-h-60 overflow-y-auto hidden" style="pointer-events: auto;">
                    <div class="marketer-option px-4 py-3 hover:bg-blue-600 cursor-pointer border-b border-white/5 transition-colors" data-id="" data-name="الكل">الكل</div>
                    @foreach($marketers as $marketer)
                        <div class="marketer-option px-4 py-3 hover:bg-blue-600 cursor-pointer border-b border-white/5 transition-colors" data-id="{{ $marketer->id }}" data-name="{{ $marketer->name }}">{{ $marketer->name }}</div>
                    @endforeach
                </div>
            </div>
            <input type="hidden" name="marketer_id" id="marketer_id" value="{{ request('marketer_id') }}">
        </div>
        <div>
            <label class="block text-sm font-medium text-white mb-2">المحل</label>
            <div class="relative">
                <input type="text" class="store-search w-full h-[42px] px-4 bg-white/5 border border-white/10 rounded-lg text-white focus:ring-2 focus:ring-blue-500" placeholder="اختر محل..." value="{{ $stores->firstWhere('id', request('store_id'))?->name ?? '' }}" autocomplete="off">
                <div class="store-dropdown absolute z-[99999] w-full mt-1 bg-gray-800 border border-white/20 rounded-lg shadow-2xl max-h-60 overflow-y-auto hidden" style="pointer-events: auto;">
                    <div class="store-option px-4 py-3 hover:bg-blue-600 cursor-pointer border-b border-white/5 transition-colors" data-id="" data-name="الكل">الكل</div>
                    @foreach($stores as $store)
                        <div class="store-option px-4 py-3 hover:bg-blue-600 cursor-pointer border-b border-white/5 transition-colors" data-id="{{ $store->id }}" data-name="{{ $store->name }}">{{ $store->name }}</div>
                    @endforeach
                </div>
            </div>
            <input type="hidden" name="store_id" id="store_id" value="{{ request('store_id') }}">
        </div>
        <div>
            <label class="block text-sm font-medium text-white mb-2">&nbsp;</label>
            <div class="flex gap-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-all h-[42px]">
                    <svg class="w-5 h-5 inline-block ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    بحث
                </button>
                <a href="{{ route('admin.invoices.index') }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition-all h-[42px] flex items-center">
                    إعادة تعيين
                </a>
            </div>
        </div>
    </form>
</div>

<div class="stat-card rounded-2xl border border-white/5 shadow-xl">
    <div class="overflow-x-auto">
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
                        <a href="{{ route('admin.invoices.show', $invoice->id) }}" class="text-blue-600 hover:text-blue-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </a>
                        <a href="{{ route('admin.invoices.edit', $invoice->id) }}" class="text-yellow-600 hover:text-yellow-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </a>
                        <form action="{{ route('admin.invoices.destroy', $invoice->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-700">
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
</div>

<div class="mt-6">
    {{ $invoices->links() }}
</div>

<script>
// Marketer Search
const marketerSearch = document.querySelector('.marketer-search');
const marketerDropdown = document.querySelector('.marketer-dropdown');
const marketerIdInput = document.getElementById('marketer_id');

marketerSearch.addEventListener('focus', function() {
    marketerDropdown.classList.remove('hidden');
});

marketerSearch.addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    document.querySelectorAll('.marketer-option').forEach(option => {
        const name = option.getAttribute('data-name').toLowerCase();
        option.style.display = name.includes(searchTerm) ? 'block' : 'none';
    });
});

document.querySelectorAll('.marketer-option').forEach(option => {
    option.addEventListener('click', function() {
        marketerSearch.value = this.getAttribute('data-name');
        marketerIdInput.value = this.getAttribute('data-id');
        marketerDropdown.classList.add('hidden');
    });
});

// Store Search
const storeSearch = document.querySelector('.store-search');
const storeDropdown = document.querySelector('.store-dropdown');
const storeIdInput = document.getElementById('store_id');

storeSearch.addEventListener('focus', function() {
    storeDropdown.classList.remove('hidden');
});

storeSearch.addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    document.querySelectorAll('.store-option').forEach(option => {
        const name = option.getAttribute('data-name').toLowerCase();
        option.style.display = name.includes(searchTerm) ? 'block' : 'none';
    });
});

document.querySelectorAll('.store-option').forEach(option => {
    option.addEventListener('click', function() {
        storeSearch.value = this.getAttribute('data-name');
        storeIdInput.value = this.getAttribute('data-id');
        storeDropdown.classList.add('hidden');
    });
});

// Close dropdowns on outside click
document.addEventListener('click', function(e) {
    if (!e.target.closest('.marketer-search') && !e.target.closest('.marketer-dropdown')) {
        marketerDropdown.classList.add('hidden');
    }
    if (!e.target.closest('.store-search') && !e.target.closest('.store-dropdown')) {
        storeDropdown.classList.add('hidden');
    }
});
</script>
@endsection