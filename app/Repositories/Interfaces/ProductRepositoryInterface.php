<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface
{
    public function getAll(): LengthAwarePaginator;
    public function findById(int $productId): ?Product;
    public function create(array $productData): Product;
    public function update(int $productId, array $productData): bool;
    public function delete(int $productId): bool;
}