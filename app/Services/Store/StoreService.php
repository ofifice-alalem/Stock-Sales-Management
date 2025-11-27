<?php

declare(strict_types=1);

namespace App\Services\Store;

use App\DTOs\Store\StoreCardDTO;
use App\Repositories\Interfaces\StoreRepositoryInterface;

class StoreService
{
    public function __construct(
        private readonly StoreRepositoryInterface $storeRepository
    ) {}

    public function getStoresCards(): array
    {
        $stores = $this->storeRepository->getAllStoresWithRemainingDebts();
        
        return $stores->map(fn($store) => new StoreCardDTO(
            id: $store->id,
            name: $store->name,
            phone: $store->phone,
            address: $store->address,
            remaining: $store->remaining
        ))->toArray();
    }
}
