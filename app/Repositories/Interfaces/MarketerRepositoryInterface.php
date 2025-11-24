<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use Illuminate\Support\Collection;

interface MarketerRepositoryInterface
{
    public function getMarketersWithStock(?string $search, ?string $sort): Collection;
    public function getMarketerStock(int $marketerId): Collection;
    public function addStock(int $marketerId, int $productId, int $quantity): void;
    public function removeStock(int $marketerId, int $productId, int $quantity): void;
}
