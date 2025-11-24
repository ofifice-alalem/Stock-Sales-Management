@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-white">تفاصيل ديون المحل - {{ $storeName }}</h1>
    <a href="{{ route('admin.store-debts.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg transition-all">
        رجوع
    </a>
</div>

@if(session('success'))
<div class="bg-green-500/20 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg mb-6">
    {{ session('success') }}
</div>
@endif

<div class="grid grid-cols-3 gap-6 mb-6">
    <div class="stat-card rounded-2xl p-6 border border-white/5 shadow-xl">
        <h3 class="text-gray-400 text-sm mb-2">إجمالي المبلغ</h3>
        <p class="text-3xl font-bold text-white">{{ number_format($totalDebt, 2) }} جنيه</p>
    </div>
    <div class="stat-card rounded-2xl p-6 border border-white/5 shadow-xl">
        <h3 class="text-gray-400 text-sm mb-2">إجمالي المدفوع</h3>
        <p class="text-3xl font-bold text-green-400">{{ number_format($totalPaid, 2) }} جنيه</p>
    </div>
    <div class="stat-card rounded-2xl p-6 border border-white/5 shadow-xl">
        <h3 class="text-gray-400 text-sm mb-2">المتبقي (الدين)</h3>
        <p class="text-3xl font-bold text-red-400">{{ number_format($remaining, 2) }} جنيه</p>
    </div>
</div>

<div class="stat-card rounded-2xl p-6 border border-white/5 shadow-xl mb-6">
    <h2 class="text-xl font-bold text-white mb-4">إضافة دفعة جديدة</h2>
    <form method="POST" action="{{ route('admin.store-debts.payments.store', $storeId) }}" class="grid grid-cols-4 gap-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-white mb-2">المسوق المستلم</label>
            <select name="marketer_id" required class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:ring-2 focus:ring-blue-500">
                <option value="">اختر المسوق</option>
                @foreach($marketers as $marketer)
                    <option value="{{ $marketer->id }}">{{ $marketer->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-white mb-2">المبلغ المدفوع</label>
            <input type="number" step="0.01" name="amount" id="payment_amount" required class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-white mb-2">المتبقي بعد الدفع</label>
            <input type="number" step="0.01" name="remaining" id="payment_remaining" value="{{ $remaining }}" readonly class="w-full px-4 py-2 bg-gray-700 border border-white/10 rounded-lg text-gray-400 cursor-not-allowed">
        </div>
        <div>
            <label class="block text-sm font-medium text-white mb-2">ملاحظة</label>
            <input type="text" name="note" class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-lg text-white focus:ring-2 focus:ring-blue-500">
        </div>
        <div class="col-span-4">
            <button type="submit" class="bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white px-6 py-3 rounded-lg transition-all">
                إضافة الدفعة
            </button>
        </div>
    </form>
</div>

<div class="grid grid-cols-2 gap-6">
    <div class="stat-card rounded-2xl border border-white/5 shadow-xl">
        <div class="p-6 border-b border-white/5">
            <h2 class="text-xl font-bold text-white">الديون</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-white/5">
                    <tr>
                        <th class="px-6 py-4 text-right text-sm font-medium text-gray-400">رقم الفاتورة</th>
                        <th class="px-6 py-4 text-right text-sm font-medium text-gray-400">المبلغ</th>
                        <th class="px-6 py-4 text-right text-sm font-medium text-gray-400">المسوق</th>
                        <th class="px-6 py-4 text-right text-sm font-medium text-gray-400">التاريخ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @foreach($debts as $invoice)
                    <tr class="hover:bg-white/5 transition-colors">
                        <td class="px-6 py-4 text-white">{{ $invoice->invoice_number }}</td>
                        <td class="px-6 py-4 text-red-400">{{ number_format($invoice->total_amount, 2) }} جنيه</td>
                        <td class="px-6 py-4 text-gray-400">{{ $invoice->marketer->name }}</td>
                        <td class="px-6 py-4 text-gray-400">{{ $invoice->created_at->format('Y-m-d') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="stat-card rounded-2xl border border-white/5 shadow-xl">
        <div class="p-6 border-b border-white/5">
            <h2 class="text-xl font-bold text-white">الدفعات</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-white/5">
                    <tr>
                        <th class="px-6 py-4 text-right text-sm font-medium text-gray-400">المبلغ</th>
                        <th class="px-6 py-4 text-right text-sm font-medium text-gray-400">المسوق</th>
                        <th class="px-6 py-4 text-right text-sm font-medium text-gray-400">التاريخ</th>
                        <th class="px-6 py-4 text-right text-sm font-medium text-gray-400">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @foreach($payments as $payment)
                    <tr class="hover:bg-white/5 transition-colors">
                        <td class="px-6 py-4 text-green-400">{{ number_format($payment->amount, 2) }} جنيه</td>
                        <td class="px-6 py-4 text-gray-400">{{ $payment->marketer->name }}</td>
                        <td class="px-6 py-4 text-gray-400">{{ $payment->created_at->format('Y-m-d') }}</td>
                        <td class="px-6 py-4">
                            <button onclick="editPayment({{ $payment->id }}, {{ $payment->marketer_id }}, {{ $payment->amount }}, {{ $payment->remaining }}, '{{ $payment->note }}')" class="bg-yellow-600 hover:bg-yellow-700 text-white p-2 rounded-lg transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="editModal" class="hidden fixed inset-0 bg-black/80 flex items-center justify-center z-50">
    <div class="modal-bg rounded-2xl p-8 border-2 border-blue-500/50 shadow-2xl w-full max-w-md">
        <h2 class="text-2xl font-bold text-white mb-6">تعديل الدفعة</h2>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-white mb-2">المسوق المستلم</label>
                    <select id="edit_marketer_id" name="marketer_id" required class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg text-white focus:ring-2 focus:ring-blue-500">
                        @foreach($marketers as $marketer)
                            <option value="{{ $marketer->id }}">{{ $marketer->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-white mb-2">المبلغ المدفوع</label>
                    <input type="number" step="0.01" id="edit_amount" name="amount" required class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg text-white focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-white mb-2">المتبقي بعد الدفع</label>
                    <input type="number" step="0.01" id="edit_remaining" name="remaining" value="{{ $remaining }}" readonly class="w-full px-4 py-3 bg-gray-700 border border-white/10 rounded-lg text-gray-400 cursor-not-allowed">
                </div>
                <div>
                    <label class="block text-sm font-medium text-white mb-2">ملاحظة</label>
                    <input type="text" id="edit_note" name="note" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg text-white focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="flex gap-3 mt-6">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-3 rounded-lg transition-all font-medium">
                        حفظ
                    </button>
                    <button type="button" onclick="closeModal()" class="flex-1 bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg transition-all font-medium">
                        إلغاء
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
.modal-bg {
    background: linear-gradient(135deg, rgba(30, 30, 35, 0.98) 0%, rgba(20, 20, 25, 0.98) 100%) !important;
}
body.light-mode .modal-bg {
    background: white !important;
}
</style>

<script>
const totalDebt = {{ $totalDebt }};
const totalPaid = {{ $totalPaid }};
const currentRemaining = {{ $remaining }};

document.getElementById('payment_amount').addEventListener('input', function() {
    const paymentAmount = parseFloat(this.value) || 0;
    const newRemaining = currentRemaining - paymentAmount;
    document.getElementById('payment_remaining').value = newRemaining.toFixed(2);
});

let originalPaymentAmount = 0;

document.getElementById('edit_amount').addEventListener('input', function() {
    const newPaymentAmount = parseFloat(this.value) || 0;
    const difference = originalPaymentAmount - newPaymentAmount;
    const newRemaining = currentRemaining + difference;
    document.getElementById('edit_remaining').value = newRemaining.toFixed(2);
});

function editPayment(id, marketerId, amount, remaining, note) {
    document.getElementById('editForm').action = `/admin/store-debts/{{ $storeId }}/payments/${id}`;
    document.getElementById('edit_marketer_id').value = marketerId;
    document.getElementById('edit_amount').value = amount;
    document.getElementById('edit_remaining').value = currentRemaining.toFixed(2);
    document.getElementById('edit_note').value = note || '';
    originalPaymentAmount = parseFloat(amount);
    document.getElementById('editModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('editModal').classList.add('hidden');
}
</script>
@endsection
