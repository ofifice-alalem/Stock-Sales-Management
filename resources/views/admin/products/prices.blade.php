@extends('layouts.app')

@section('title', 'إدارة أسعار المنتجات')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">إدارة أسعار المنتجات</h3>
                    <button type="button" class="btn btn-primary" onclick="updateZeroPrices()">
                        تحديث المنتجات بسعر 0
                    </button>
                </div>
                
                <div class="card-body">
                    <div id="alert-container"></div>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>الرقم</th>
                                    <th>اسم المنتج</th>
                                    <th>الوحدة</th>
                                    <th>السعر الحالي</th>
                                    <th>السعر الجديد</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                <tr id="product-{{ $product->id }}">
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->unit }}</td>
                                    <td>
                                        <span class="badge {{ $product->price == 0 ? 'bg-danger' : 'bg-success' }}">
                                            {{ $product->price }} ريال
                                        </span>
                                    </td>
                                    <td>
                                        <input type="number" 
                                               class="form-control form-control-sm" 
                                               id="price-{{ $product->id }}" 
                                               value="{{ $product->price }}" 
                                               step="0.01" 
                                               min="0"
                                               style="width: 100px;">
                                    </td>
                                    <td>
                                        <button type="button" 
                                                class="btn btn-sm btn-success" 
                                                onclick="updateSinglePrice({{ $product->id }})">
                                            تحديث
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function showAlert(message, type = 'success') {
    const alertContainer = document.getElementById('alert-container');
    const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
    
    alertContainer.innerHTML = `
        <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    setTimeout(() => {
        alertContainer.innerHTML = '';
    }, 5000);
}

function updateZeroPrices() {
    fetch('{{ route("admin.products.update-zero-prices") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert(data.message, 'success');
            
            // تحديث الأسعار في الجدول
            if (data.updated_products) {
                data.updated_products.forEach(product => {
                    const row = document.getElementById(`product-${product.id}`);
                    if (row) {
                        const priceCell = row.querySelector('td:nth-child(4) span');
                        const priceInput = document.getElementById(`price-${product.id}`);
                        
                        priceCell.textContent = `${product.new_price} ريال`;
                        priceCell.className = 'badge bg-success';
                        priceInput.value = product.new_price;
                    }
                });
            }
            
            setTimeout(() => {
                location.reload();
            }, 2000);
        } else {
            showAlert(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('حدث خطأ أثناء تحديث الأسعار', 'error');
    });
}

function updateSinglePrice(productId) {
    const priceInput = document.getElementById(`price-${productId}`);
    const newPrice = priceInput.value;
    
    if (!newPrice || newPrice < 0) {
        showAlert('يرجى إدخال سعر صحيح', 'error');
        return;
    }
    
    fetch(`/admin/products/${productId}/price`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            price: parseFloat(newPrice)
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert(`تم تحديث سعر ${data.product.name} بنجاح`, 'success');
            
            // تحديث السعر في الجدول
            const row = document.getElementById(`product-${productId}`);
            const priceCell = row.querySelector('td:nth-child(4) span');
            priceCell.textContent = `${data.product.new_price} ريال`;
            priceCell.className = 'badge bg-success';
        } else {
            showAlert('حدث خطأ أثناء تحديث السعر', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('حدث خطأ أثناء تحديث السعر', 'error');
    });
}
</script>
@endsection