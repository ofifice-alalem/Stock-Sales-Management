<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Store;
use App\Repositories\Interfaces\StoreRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class StoreRepository implements StoreRepositoryInterface
{
    public function getAllStoresWithRemainingDebts(): Collection
    {
        return Store::with(['invoices', 'debts'])
            ->get()
            ->map(function ($store) {
                $totalDebt = $store->invoices->sum('total_amount');
                $totalPaid = $store->debts->sum('amount');
                $remaining = $totalDebt - $totalPaid;
                
                $store->remaining = $remaining;
                return $store;
            })
            ->filter(fn($store) => $store->remaining > 0);
    }
}
