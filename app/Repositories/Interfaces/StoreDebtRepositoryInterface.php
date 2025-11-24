<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface StoreDebtRepositoryInterface
{
    public function getAllStoresWithDebts(?string $search, ?string $sortBy, ?string $direction): Collection;
    public function getStoreDebtsByStoreId(int $storeId): Collection;
    public function getPaymentsByStoreId(int $storeId): Collection;
    public function createDebt(array $debtData): mixed;
    public function createPayment(array $paymentData): mixed;
    public function updatePayment(int $paymentId, array $paymentData): bool;
    public function getTotalDebtByStoreId(int $storeId): float;
    public function getTotalPaidByStoreId(int $storeId): float;
}
