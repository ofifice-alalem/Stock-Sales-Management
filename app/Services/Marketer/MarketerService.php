<?php

declare(strict_types=1);

namespace App\Services\Marketer;

use App\DTOs\Marketer\MarketerStockDTO;
use App\DTOs\Marketer\StockTransactionDTO;
use App\Repositories\Interfaces\MarketerRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class MarketerService
{
    public function __construct(
        private readonly MarketerRepositoryInterface $marketerRepository
    ) {}

    public function getMarketersWithStock(?string $search, ?string $sort): Collection
    {
        $marketers = $this->marketerRepository->getMarketersWithStock($search, $sort);

        return $marketers->map(fn($marketer) => new MarketerStockDTO(
            marketerId: $marketer->id,
            marketerName: $marketer->name,
            marketerPhone: $marketer->phone,
            products: $marketer->products->toArray(),
            totalQuantity: $marketer->total_quantity,
            totalInvoices: (float)$marketer->total_invoices,
            totalStockValue: (float)$marketer->total_stock_value
        ));
    }

    public function getMarketerStock(int $marketerId): Collection
    {
        return $this->marketerRepository->getMarketerStock($marketerId);
    }

    public function addStock(StockTransactionDTO $dto): void
    {
        DB::transaction(function () use ($dto) {
            foreach ($dto->items as $item) {
                $this->marketerRepository->addStock(
                    $dto->marketerId,
                    (int)$item['product_id'],
                    (int)$item['quantity']
                );
            }
        });
    }

    public function returnStock(StockTransactionDTO $dto): void
    {
        DB::transaction(function () use ($dto) {
            foreach ($dto->items as $item) {
                $this->marketerRepository->removeStock(
                    $dto->marketerId,
                    (int)$item['product_id'],
                    (int)$item['quantity']
                );
            }
        });
    }
}
