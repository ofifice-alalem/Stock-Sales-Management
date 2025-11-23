<?php

declare(strict_types=1);

namespace App\Services\Product;

use App\DTOs\Product\CreateProductDTO;
use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductService
{
    public function __construct(
        private readonly ProductRepositoryInterface $productRepository
    ) {}

    public function getAllProducts(): LengthAwarePaginator
    {
        return $this->productRepository->getAll();
    }

    public function createProduct(CreateProductDTO $productData): Product
    {
        return $this->productRepository->create([
            'name' => $productData->name,
            'unit' => $productData->unit,
            'description' => $productData->description,
        ]);
    }

    public function updateProduct(int $productId, CreateProductDTO $productData): bool
    {
        return $this->productRepository->update($productId, [
            'name' => $productData->name,
            'unit' => $productData->unit,
            'description' => $productData->description,
        ]);
    }

    public function deleteProduct(int $productId): bool
    {
        return $this->productRepository->delete($productId);
    }
}