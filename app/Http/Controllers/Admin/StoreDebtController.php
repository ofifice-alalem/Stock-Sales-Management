<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\DTOs\StoreDebt\CreateStoreDebtPaymentDTO;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\StoreDebt\StoreDebtService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StoreDebtController extends Controller
{
    public function __construct(
        private readonly StoreDebtService $storeDebtService
    ) {}

    public function index(Request $request): View
    {
        $stores = $this->storeDebtService->getAllStoresWithDebts(
            $request->input('search'),
            $request->input('sort'),
            $request->input('direction')
        );
        return view('admin.store-debts.index', compact('stores'));
    }

    public function show(int $storeId): View
    {
        $debtDetails = $this->storeDebtService->getStoreDebtDetails($storeId);
        $marketers = User::whereHas('role', fn($q) => $q->where('name', 'marketer'))->get();
        $store = \App\Models\Store::findOrFail($storeId);
        
        return view('admin.store-debts.show', array_merge($debtDetails, [
            'storeId' => $storeId,
            'storeName' => $store->name,
            'marketers' => $marketers
        ]));
    }

    public function storePayment(Request $request, int $storeId): RedirectResponse
    {
        $request->validate([
            'marketer_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0.01',
            'remaining' => 'required|numeric|min:0',
            'note' => 'nullable|string|max:255',
        ]);

        $dto = new CreateStoreDebtPaymentDTO(
            storeId: $storeId,
            marketerId: (int)$request->input('marketer_id'),
            amount: (float)$request->input('amount'),
            remaining: (float)$request->input('remaining'),
            note: $request->input('note')
        );

        $this->storeDebtService->createPayment($dto);

        return redirect()->route('admin.store-debts.show', $storeId)
            ->with('success', 'تم إضافة الدفعة بنجاح');
    }

    public function updatePayment(Request $request, int $storeId, int $paymentId): RedirectResponse
    {
        $request->validate([
            'marketer_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0.01',
            'remaining' => 'required|numeric|min:0',
            'note' => 'nullable|string|max:255',
        ]);

        $dto = new CreateStoreDebtPaymentDTO(
            storeId: $storeId,
            marketerId: (int)$request->input('marketer_id'),
            amount: (float)$request->input('amount'),
            remaining: (float)$request->input('remaining'),
            note: $request->input('note')
        );

        $this->storeDebtService->updatePayment($paymentId, $dto);

        return redirect()->route('admin.store-debts.show', $storeId)
            ->with('success', 'تم تحديث الدفعة بنجاح');
    }
}
