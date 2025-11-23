@extends('layouts.admin')

@section('content')
<div class="max-w-5xl">
    <h1 class="text-2xl font-bold text-white mb-6">تعديل الفاتورة #{{ $invoice->invoice_number }}</h1>

    <form action="{{ route('admin.invoices.update', $invoice->id) }}" method="POST" id="invoiceForm">
        @csrf
        @method('PUT')

    <div class="stat-card rounded-2xl p-6 border border-white/5 shadow-xl mb-6">
        <h2 class="text-xl font-bold text-white mb-4">بيانات الفاتورة</h2>
            
            <div class="mb-4">
                <label for="invoice_number" class="block text-sm font-medium text-white mb-2">رقم الفاتورة</label>
                <input type="text" id="invoice_number" name="invoice_number" value="{{ old('invoice_number', $invoice->invoice_number) }}" 
                    class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-white @error('invoice_number') border-red-500 @enderror" required>
                @error('invoice_number')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="marketer_id" class="block text-sm font-medium text-white mb-2">المسوق</label>
                <select id="marketer_id" name="marketer_id" 
                    class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-white @error('marketer_id') border-red-500 @enderror" required>
                    <option value="">اختر المسوق</option>
                    @foreach($marketers as $marketer)
                        <option value="{{ $marketer->id }}" {{ old('marketer_id', $invoice->marketer_id) == $marketer->id ? 'selected' : '' }}>{{ $marketer->name }}</option>
                    @endforeach
                </select>
                @error('marketer_id')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="store_id" class="block text-sm font-medium text-white mb-2">المحل</label>
                <select id="store_id" name="store_id" 
                    class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-white @error('store_id') border-red-500 @enderror" required>
                    <option value="">اختر المحل</option>
                    @foreach($stores as $store)
                        <option value="{{ $store->id }}" {{ old('store_id', $invoice->store_id) == $store->id ? 'selected' : '' }}>{{ $store->name }}</option>
                    @endforeach
                </select>
                @error('store_id')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

    </div>

    <div class="stat-card rounded-2xl p-6 border border-white/5 shadow-xl mb-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-white">المنتجات</h2>
            <button type="button" onclick="addProductRow()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-all">
                <svg class="w-5 h-5 inline-block ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                إضافة منتج
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-white/5">
                    <tr>
                        <th class="px-4 py-3 text-right text-sm font-medium text-gray-400">المنتج</th>
                        <th class="px-4 py-3 text-right text-sm font-medium text-gray-400">الكمية</th>
                        <th class="px-4 py-3 text-right text-sm font-medium text-gray-400">السعر</th>
                        <th class="px-4 py-3 text-right text-sm font-medium text-gray-400">الإجمالي</th>
                        <th class="px-4 py-3 text-center text-sm font-medium text-gray-400">حذف</th>
                    </tr>
                </thead>
                <tbody id="productsTable" class="divide-y divide-white/5">
                    @foreach($invoice->items as $index => $item)
                    <tr class="product-row">
                        <td class="px-4 py-3">
                            <input type="hidden" name="items[{{ $index }}][id]" value="{{ $item->id }}">
                            <select name="items[{{ $index }}][product_id]" class="w-full px-3 py-2 bg-white/5 border border-white/10 rounded-lg text-white" required>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ $item->product_id == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td class="px-4 py-3">
                            <input type="number" name="items[{{ $index }}][quantity]" value="{{ $item->quantity }}" min="1" class="w-full px-3 py-2 bg-white/5 border border-white/10 rounded-lg text-white quantity-input" required>
                        </td>
                        <td class="px-4 py-3">
                            <input type="number" step="0.01" name="items[{{ $index }}][price]" value="{{ $item->price }}" min="0" class="w-full px-3 py-2 bg-white/5 border border-white/10 rounded-lg text-white price-input" required>
                        </td>
                        <td class="px-4 py-3 text-white font-medium item-total">{{ number_format($item->price * $item->quantity, 2) }}</td>
                        <td class="px-4 py-3 text-center">
                            <button type="button" onclick="removeRow(this)" class="text-red-400 hover:text-red-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-white/5">
                    <tr>
                        <td colspan="3" class="px-4 py-3 text-right text-white font-bold">الإجمالي الكلي:</td>
                        <td class="px-4 py-3 text-white font-bold" id="grandTotal">0.00</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="flex gap-4">
        <button type="submit" class="bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white px-6 py-3 rounded-lg transition-all shadow-lg">
            تحديت
        </button>
        <a href="{{ route('admin.invoices.show', $invoice->id) }}" class="bg-white/5 hover:bg-white/10 text-white px-6 py-3 rounded-lg transition-all">
            إلغاء
        </a>
    </div>
    </form>
</div>

<script>
let productIndex = {{ $invoice->items->count() }};
const products = @json($products);

function addProductRow() {
    const tbody = document.getElementById('productsTable');
    const row = document.createElement('tr');
    row.className = 'product-row';
    
    let productOptions = '<option value="">اختر منتج</option>';
    products.forEach(product => {
        productOptions += `<option value="${product.id}">${product.name}</option>`;
    });
    
    row.innerHTML = `
        <td class="px-4 py-3">
            <select name="items[${productIndex}][product_id]" class="w-full px-3 py-2 bg-white/5 border border-white/10 rounded-lg text-white" required>
                ${productOptions}
            </select>
        </td>
        <td class="px-4 py-3">
            <input type="number" name="items[${productIndex}][quantity]" value="1" min="1" class="w-full px-3 py-2 bg-white/5 border border-white/10 rounded-lg text-white quantity-input" required>
        </td>
        <td class="px-4 py-3">
            <input type="number" step="0.01" name="items[${productIndex}][price]" value="0" min="0" class="w-full px-3 py-2 bg-white/5 border border-white/10 rounded-lg text-white price-input" required>
        </td>
        <td class="px-4 py-3 text-white font-medium item-total">0.00</td>
        <td class="px-4 py-3 text-center">
            <button type="button" onclick="removeRow(this)" class="text-red-400 hover:text-red-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </button>
        </td>
    `;
    
    tbody.appendChild(row);
    productIndex++;
    attachEventListeners(row);
    calculateTotal();
}

function removeRow(button) {
    const rows = document.querySelectorAll('.product-row');
    if (rows.length <= 1) {
        alert('لا يمكن حذف جميع المنتجات. يجب أن تحتوي الفاتورة على منتج واحد على الأقل.');
        return;
    }
    if (confirm('هل أنت متأكد من حذف هذا المنتج؟')) {
        button.closest('tr').remove();
        calculateTotal();
    }
}

function calculateTotal() {
    let grandTotal = 0;
    document.querySelectorAll('.product-row').forEach(row => {
        const quantity = parseFloat(row.querySelector('.quantity-input').value) || 0;
        const price = parseFloat(row.querySelector('.price-input').value) || 0;
        const total = quantity * price;
        row.querySelector('.item-total').textContent = total.toFixed(2);
        grandTotal += total;
    });
    document.getElementById('grandTotal').textContent = grandTotal.toFixed(2);
}

function attachEventListeners(row) {
    row.querySelector('.quantity-input').addEventListener('input', calculateTotal);
    row.querySelector('.price-input').addEventListener('input', calculateTotal);
}

document.querySelectorAll('.product-row').forEach(attachEventListeners);
calculateTotal();
</script>
@endsection
