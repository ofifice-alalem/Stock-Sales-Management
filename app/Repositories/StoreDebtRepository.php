<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Invoice;
use App\Models\Store;
use App\Models\StoreDebt;
use App\Models\StoreDebtPayment;
use App\Repositories\Interfaces\StoreDebtRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class StoreDebtRepository implements StoreDebtRepositoryInterface
{
    public function getAllStoresWithDebts(?string $search, ?string $sortBy, ?string $direction): Collection
    {
        $query = Store::with('invoices.marketer')
            ->whereHas('invoices');

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        $stores = $query->get()
            ->map(function ($store) {
                $totalDebt = $this->getTotalDebtByStoreId($store->id);
                $totalPaid = $this->getTotalPaidByStoreId($store->id);
                $store->total_debt = $totalDebt;
                $store->total_paid = $totalPaid;
                $store->remaining = $totalDebt - $totalPaid;
                $store->invoices_count = $store->invoices->count();
                return $store;
            });

        if ($sortBy && $direction) {
            $stores = $direction === 'asc' 
                ? $stores->sortBy($sortBy) 
                : $stores->sortByDesc($sortBy);
        }

        return $stores->values();
    }

    public function getStoreDebtsByStoreId(int $storeId): Collection
    {
        return Invoice::with('marketer')
            ->where('store_id', $storeId)
            ->latest('created_at')
            ->get();
    }

    public function getPaymentsByStoreId(int $storeId): Collection
    {
        return StoreDebtPayment::with('marketer')
            ->where('store_id', $storeId)
            ->latest('created_at')
            ->get();
    }

    public function createDebt(array $debtData): mixed
    {
        return StoreDebt::create($debtData);
    }

    public function createPayment(array $paymentData): mixed
    {
        return StoreDebtPayment::create($paymentData);
    }

    public function updatePayment(int $paymentId, array $paymentData): bool
    {
        return (bool) StoreDebtPayment::where('id', $paymentId)->update($paymentData);
    }

    public function getTotalDebtByStoreId(int $storeId): float
    {
        return (float) Invoice::where('store_id', $storeId)->sum('total_amount');
    }

    public function getTotalPaidByStoreId(int $storeId): float
    {
        return (float) StoreDebtPayment::where('store_id', $storeId)->sum('amount');
    }
}
