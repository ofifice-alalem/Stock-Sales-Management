<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class UpdateProductPrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:update-prices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'تحديث أسعار المنتجات التي لها سعر 0';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('بدء تحديث أسعار المنتجات...');
        
        $products = Product::where('price', 0)->get();
        
        if ($products->isEmpty()) {
            $this->info('لا توجد منتجات بسعر 0');
            return;
        }
        
        $this->info("تم العثور على {$products->count()} منتج بسعر 0");
        
        $updatedCount = 0;
        
        foreach ($products as $product) {
            // أسعار عشوائية منطقية حسب نوع المنتج
            $price = $this->generateRandomPrice($product->name, $product->unit);
            
            $product->update(['price' => $price]);
            
            $this->line("تم تحديث سعر {$product->name} إلى {$price} ريال");
            $updatedCount++;
        }
        
        $this->info("تم تحديث {$updatedCount} منتج بنجاح!");
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
