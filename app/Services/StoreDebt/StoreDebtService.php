<?php

declare(strict_types=1);

namespace App\Services\StoreDebt;

use App\DTOs\StoreDebt\CreateStoreDebtPaymentDTO;
use App\Repositories\Interfaces\StoreDebtRepositoryInterface;

class StoreDebtService
{
    public function __construct(
        private readonly StoreDebtRepositoryInterface $storeDebtRepository
    ) {}

    public function getAllStoresWithDebts(?string $search, ?string $sortBy, ?string $direction): mixed
    {
        return $this->storeDebtRepository->getAllStoresWithDebts($search, $sortBy, $direction);
    }

    public function getStoreDebtDetails(int $storeId): array
    {
        $debts = $this->storeDebtRepository->getStoreDebtsByStoreId($storeId);
        $payments = $this->storeDebtRepository->getPaymentsByStoreId($storeId);
        $totalDebt = $this->storeDebtRepository->getTotalDebtByStoreId($storeId);
        $totalPaid = $this->storeDebtRepository->getTotalPaidByStoreId($storeId);
        $remaining = $totalDebt - $totalPaid;

        return [
            'debts' => $debts,
            'payments' => $payments,
            'totalDebt' => $totalDebt,
            'totalPaid' => $totalPaid,
            'remaining' => $remaining,
        ];
    }

    public function createPayment(CreateStoreDebtPaymentDTO $dto): mixed
    {
        return $this->storeDebtRepository->createPayment([
            'store_id' => $dto->storeId,
            'marketer_id' => $dto->marketerId,
            'amount' => $dto->amount,
            'remaining' => $dto->remaining,
            'note' => $dto->note,
        ]);
    }

    public function updatePayment(int $paymentId, CreateStoreDebtPaymentDTO $dto): bool
    {
        return $this->storeDebtRepository->updatePayment($paymentId, [
            'store_id' => $dto->storeId,
            'marketer_id' => $dto->marketerId,
            'amount' => $dto->amount,
            'remaining' => $dto->remaining,
            'note' => $dto->note,
        ]);
    }
}
