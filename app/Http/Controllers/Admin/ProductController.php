<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\DTOs\Product\CreateProductDTO;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\Product\ProductService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductService $productService
    ) {}

    public function index(Request $request)
    {
        if ($request->has('ajax')) {
            $products = Product::where('name', 'like', '%' . $request->input('search') . '%')
                ->orderBy('name')
                ->limit(50)
                ->get();
            return response()->json($products);
        }
        
        $products = $this->productService->getAllProducts($request->input('search'));
        return view('admin.products.index', compact('products'));
    }

    public function create(): View
    {
        return view('admin.products.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'unit' => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
        ]);

        $productDTO = new CreateProductDTO(
            name: $request->input('name'),
            unit: $request->input('unit'),
            price: (float)$request->input('price'),
            description: $request->input('description')
        );

        $this->productService->createProduct($productDTO);

        return redirect()->route('admin.products.index')
            ->with('success', 'تم إضافة المنتج بنجاح');
    }

    public function edit(int $productId): View
    {
        $product = $this->productService->getAllProducts()->getCollection()->find($productId);
        if (!$product) {
            $product = Product::findOrFail($productId);
        }
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, int $productId): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'unit' => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
        ]);

        $productDTO = new CreateProductDTO(
            name: $request->input('name'),
            unit: $request->input('unit'),
            price: (float)$request->input('price'),
            description: $request->input('description')
        );

        $this->productService->updateProduct($productId, $productDTO);

        return redirect()->route('admin.products.index')
            ->with('success', 'تم تحديث المنتج بنجاح');
    }

    public function destroy(int $productId): RedirectResponse
    {
        $this->productService->deleteProduct($productId);

        return redirect()->route('admin.products.index')
            ->with('success', 'تم حذف المنتج بنجاح');
    }
    
    public function managePrices(): View
    {
        $products = Product::orderBy('name')->get();
        return view('admin.products.prices', compact('products'));
    }
}