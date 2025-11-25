<?php

declare(strict_types=1);

namespace App\Services\Marketer;

use App\DTOs\Marketer\EarningsItemDTO;
use App\DTOs\Marketer\MarketerEarningsDTO;
use App\Repositories\Interfaces\MarketerRepositoryInterface;

final class MarketerEarningsService
{
    public function __construct(
        private readonly MarketerRepositoryInterface $marketerRepository
    ) {
    }

    public function getEarnings(int $marketerId): MarketerEarningsDTO
    {
        $earnings = $this->marketerRepository->getMarketerEarnings($marketerId);

        $items = $earnings->map(fn($item) => new EarningsItemDTO(
            productName: $item->product_name,
            price: (float) $item->price,
            quantity: (int) $item->quantity,
            total: (float) $item->total
        ))->toArray();

        $totalEarnings = $earnings->sum('total');

        return new MarketerEarningsDTO(
            marketerId: $marketerId,
            items: $items,
            totalEarnings: (float) $totalEarnings
        );
    }
}
