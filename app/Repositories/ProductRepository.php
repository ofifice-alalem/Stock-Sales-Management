<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductRepository implements ProductRepositoryInterface
{
    public function getAll(): LengthAwarePaginator
    {
        return Product::orderBy('created_at', 'desc')->paginate(15);
    }

    public function findById(int $productId): ?Product
    {
        return Product::find($productId);
    }

    public function create(array $productData): Product
    {
        return Product::create($productData);
    }

    public function update(int $productId, array $productData): bool
    {
        return Product::where('id', $productId)->update($productData) > 0;
    }

    public function delete(int $productId): bool
    {
        return Product::destroy($productId) > 0;
    }
}