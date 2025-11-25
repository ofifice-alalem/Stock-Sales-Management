<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InvoiceItemSeeder extends Seeder
{
    public function run(): void
    {
        $products = DB::table('products')->get();
        
        for ($invoiceId = 1; $invoiceId <= 150; $invoiceId++) {
            $invoice = DB::table('invoices')->where('id', $invoiceId)->first();
            $itemsCount = rand(2, 6);
            $selectedProducts = $products->random($itemsCount);
            $totalAmount = 0;
            
            foreach ($selectedProducts as $product) {
                $quantity = rand(5, 30);
                $itemTotal = $quantity * $product->price;
                $totalAmount += $itemTotal;
                
                DB::table('invoice_items')->insert([
                    'invoice_id' => $invoiceId,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->price,
                    'created_at' => $invoice->created_at,
                    'updated_at' => $invoice->created_at
                ]);
            }
            
            DB::table('invoices')
                ->where('id', $invoiceId)
                ->update(['total_amount' => $totalAmount]);
        }
    }
}