@extends('layouts.admin')

@section('content')
<div class="max-w-5xl">
    <h1 class="text-2xl font-bold text-white mb-6">إضافة بضاعة للمسوق</h1>

    <form action="{{ route('admin.marketers.add-stock.store', $marketerId) }}" method="POST">
        @csrf

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

            <div class="overflow-visible">
                <table class="w-full">
                    <thead class="bg-white/5">
                        <tr>
                            <th class="px-4 py-3 text-right text-sm font-medium text-gray-400">المنتج</th>
                            <th class="px-4 py-3 text-right text-sm font-medium text-gray-400">الكمية</th>
                            <th class="px-4 py-3 text-center text-sm font-medium text-gray-400">حذف</th>
                        </tr>
                    </thead>
                    <tbody id="productsTable" class="divide-y divide-white/5">
                        <tr class="product-row">
                            <td class="px-4 py-3">
                                <div class="relative">
                                    <input type="text" class="product-search w-full px-3 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:ring-2 focus:ring-blue-500" placeholder="ابحث عن منتج..." autocomplete="off">
                                    <div class="product-dropdown absolute z-[9999] w-full mt-1 bg-gray-800 border border-white/20 rounded-lg shadow-2xl max-h-60 overflow-y-auto hidden">
                                        @foreach($products as $product)
                                            <div class="product-option px-4 py-3 hover:bg-blue-600 cursor-pointer border-b border-white/5 transition-colors" data-id="{{ $product->id }}" data-name="{{ $product->name }}">
                                                <span class="text-white font-medium">{{ $product->name }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <input type="hidden" name="items[0][product_id]" class="product-id" required>
                            </td>
                            <td class="px-4 py-3">
                                <input type="number" name="items[0][quantity]" value="1" min="1" class="w-full px-3 py-2 bg-white/5 border border-white/10 rounded-lg text-white" required>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <button type="button" onclick="removeRow(this)" class="text-red-400 hover:text-red-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white px-6 py-3 rounded-lg transition-all shadow-lg">
                حفظ
            </button>
            <a href="{{ route('admin.marketers.index') }}" class="bg-white/5 hover:bg-white/10 text-white px-6 py-3 rounded-lg transition-all">
                إلغاء
            </a>
        </div>
    </form>
</div>

<script>
let productIndex = 1;
const products = @json($products);

function addProductRow() {
    const tbody = document.getElementById('productsTable');
    const row = document.createElement('tr');
    row.className = 'product-row';
    
    let productOptions = '';
    products.forEach(product => {
        productOptions += `<div class="product-option px-4 py-3 hover:bg-blue-600 cursor-pointer border-b border-white/5 transition-colors" data-id="${product.id}" data-name="${product.name}"><span class="text-white font-medium">${product.name}</span></div>`;
    });
    
    row.innerHTML = `
        <td class="px-4 py-3">
            <div class="relative">
                <input type="text" class="product-search w-full px-3 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:ring-2 focus:ring-blue-500" placeholder="ابحث عن منتج..." autocomplete="off">
                <div class="product-dropdown absolute z-[9999] w-full mt-1 bg-gray-800 border border-white/20 rounded-lg shadow-2xl max-h-60 overflow-y-auto hidden">
                    ${productOptions}
                </div>
            </div>
            <input type="hidden" name="items[${productIndex}][product_id]" class="product-id" required>
        </td>
        <td class="px-4 py-3">
            <input type="number" name="items[${productIndex}][quantity]" value="1" min="1" class="w-full px-3 py-2 bg-white/5 border border-white/10 rounded-lg text-white" required>
        </td>
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
}

function removeRow(button) {
    const rows = document.querySelectorAll('.product-row');
    if (rows.length <= 1) {
        alert('يجب أن يحتوي على منتج واحد على الأقل.');
        return;
    }
    button.closest('tr').remove();
}

function attachEventListeners(row) {
    const productSearch = row.querySelector('.product-search');
    const productDropdown = row.querySelector('.product-dropdown');
    const productIdInput = row.querySelector('.product-id');
    
    productSearch.addEventListener('focus', function() {
        productDropdown.classList.remove('hidden');
        filterProducts(productDropdown, '');
    });
    
    productSearch.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        filterProducts(productDropdown, searchTerm);
        productDropdown.classList.remove('hidden');
    });
    
    productDropdown.querySelectorAll('.product-option').forEach(option => {
        option.addEventListener('click', function() {
            const productId = this.getAttribute('data-id');
            const productName = this.getAttribute('data-name');
            
            productSearch.value = productName;
            productIdInput.value = productId;
            productDropdown.classList.add('hidden');
        });
    });
    
    document.addEventListener('click', function(e) {
        if (!row.contains(e.target)) {
            productDropdown.classList.add('hidden');
        }
    });
}

function filterProducts(dropdown, searchTerm) {
    const options = dropdown.querySelectorAll('.product-option');
    options.forEach(option => {
        const name = option.getAttribute('data-name').toLowerCase();
        option.style.display = name.includes(searchTerm) ? 'block' : 'none';
    });
}

document.querySelectorAll('.product-row').forEach(attachEventListeners);
</script>
@endsection
