@extends('layouts.admin')

@section('content')
<div class="max-w-5xl">
    <h1 class="text-2xl font-bold text-white mb-6">ترجيع بضاعة من المسوق</h1>

    @if($marketerStock->isEmpty())
        <div class="stat-card rounded-2xl p-12 border border-white/5 shadow-xl text-center">
            <p class="text-gray-400 text-lg">لا توجد بضاعة لدى المسوق</p>
            <a href="{{ route('admin.marketers.index') }}" class="inline-block mt-4 bg-white/5 hover:bg-white/10 text-white px-6 py-3 rounded-lg transition-all">
                رجوع
            </a>
        </div>
    @else
    <form action="{{ route('admin.marketers.return-stock.store', $marketerId) }}" method="POST">
        @csrf

        <div class="stat-card rounded-2xl p-6 border border-white/5 shadow-xl mb-6">
            <h2 class="text-xl font-bold text-white mb-4">المنتجات</h2>

            <div class="overflow-visible">
                <table class="w-full">
                    <thead class="bg-white/5">
                        <tr>
                            <th class="px-4 py-3 text-right text-sm font-medium text-gray-400">المنتج</th>
                            <th class="px-4 py-3 text-right text-sm font-medium text-gray-400">الكمية المرتجعة</th>
                            <th class="px-4 py-3 text-right text-sm font-medium text-gray-400">الباقي</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach($marketerStock as $index => $stock)
                        <tr>
                            <td class="px-4 py-3 text-white">{{ $stock->name }}</td>
                            <td class="px-4 py-3">
                                <input type="hidden" name="items[{{ $index }}][product_id]" value="{{ $stock->id }}">
                                <input type="number" name="items[{{ $index }}][quantity]" value="0" min="0" max="{{ $stock->quantity }}" class="w-32 px-3 py-2 bg-white/5 border border-white/10 rounded-lg text-white quantity-input" data-max="{{ $stock->quantity }}">
                            </td>
                            <td class="px-4 py-3 text-green-400 font-medium remaining" data-original="{{ $stock->quantity }}">{{ $stock->quantity }}</td>
                        </tr>
                        @endforeach
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
    @endif
</div>

<script>
document.querySelectorAll('.quantity-input').forEach(input => {
    input.addEventListener('input', function() {
        const row = this.closest('tr');
        const remaining = row.querySelector('.remaining');
        const original = parseInt(remaining.getAttribute('data-original'));
        const returned = parseInt(this.value) || 0;
        const newRemaining = original - returned;
        
        remaining.textContent = newRemaining;
        
        if (returned > original) {
            this.value = original;
            remaining.textContent = 0;
        }
    });
});
</script>
@endsection
