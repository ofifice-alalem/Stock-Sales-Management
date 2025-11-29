<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductPriceController extends Controller
{
    public function updateZeroPrices(): JsonResponse
    {
        $products = Product::where('price', 0)->get();
        
        if ($products->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'لا توجد منتجات بسعر 0'
            ]);
        }
        
        $updatedCount = 0;
        $updatedProducts = [];
        
        foreach ($products as $product) {
            $price = $this->generateRandomPrice($product->name, $product->unit);
            
            $product->update(['price' => $price]);
            
            $updatedProducts[] = [
                'id' => $product->id,
                'name' => $product->name,
                'old_price' => 0,
                'new_price' => $price
            ];
            
            $updatedCount++;
        }
        
        return response()->json([
            'success' => true,
            'message' => "تم تحديث {$updatedCount} منتج بنجاح",
            'updated_products' => $updatedProducts
        ]);
    }
    
    public function updateSinglePrice(Request $request, Product $product): JsonResponse
    {
        $request->validate([
            'price' => 'required|numeric|min:0'
        ]);
        
        $oldPrice = $product->price;
        $product->update(['price' => $request->price]);
        
        return response()->json([
            'success' => true,
            'message' => 'تم تحديث السعر بنجاح',
            'product' => [
                'id' => $product->id,
                'name' => $product->name,
                'old_price' => $oldPrice,
                'new_price' => $product->price
            ]
        ]);
    }
    
    private function generateRandomPrice(string $productName, string $unit): float
    {
        $name = strtolower($productName);
        
        // أسعار حسب نوع المنتج
        if (str_contains($name, 'رز') || str_contains($name, 'أرز')) {
            return rand(15, 35); // كيس أرز
        }
        
        if (str_contains($name, 'سكر')) {
            return rand(8, 18); // كيس سكر
        }
        
        if (str_contains($name, 'زيت')) {
            return rand(20, 45); // زيت طبخ
        }
        
        if (str_contains($name, 'دقيق') || str_contains($name, 'طحين')) {
            return rand(12, 25); // كيس دقيق
        }
        
        if (str_contains($name, 'شاي')) {
            return rand(5, 15); // علبة شاي
        }
        
        if (str_contains($name, 'قهوة')) {
            return rand(25, 60); // قهوة
        }
        
        if (str_contains($name, 'حليب')) {
            return rand(3, 8); // حليب
        }
        
        if (str_contains($name, 'عصير')) {
            return rand(2, 6); // عصير
        }
        
        if (str_contains($name, 'بسكويت') || str_contains($name, 'كوكيز')) {
            return rand(4, 12); // بسكويت
        }
        
        if (str_contains($name, 'شوكولاتة') || str_contains($name, 'شوكولا')) {
            return rand(3, 15); // شوكولاتة
        }
        
        if (str_contains($name, 'شامبو')) {
            return rand(10, 25); // شامبو
        }
        
        if (str_contains($name, 'صابون')) {
            return rand(5, 15); // صابون
        }
        
        if (str_contains($name, 'كريم')) {
            return rand(8, 20); // كريم
        }
        
        if (str_contains($name, 'عطر')) {
            return rand(30, 80); // عطر
        }
        
        // أسعار حسب الوحدة
        if (str_contains($unit, 'كيلو') || str_contains($unit, 'كغم')) {
            return rand(10, 30);
        }
        
        if (str_contains($unit, 'لتر')) {
            return rand(5, 20);
        }
        
        if (str_contains($unit, 'علبة') || str_contains($unit, 'حبة')) {
            return rand(2, 15);
        }
        
        if (str_contains($unit, 'كيس') || str_contains($unit, 'عبوة')) {
            return rand(8, 25);
        }
        
        // سعر افتراضي
        return rand(5, 20);
    }
}