<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MarketerStockSeeder extends Seeder
{
    public function run(): void
    {
        $data = [];
        for ($marketer = 4; $marketer <= 23; $marketer++) {
            $productsCount = rand(5, 12);
            $selectedProducts = array_rand(range(1, 20), $productsCount);
            
            foreach ($selectedProducts as $product) {
                $data[] = [
                    'marketer_id' => $marketer,
                    'product_id' => $product + 1,
                    'quantity' => rand(10, 100),
                    'updated_at' => now()->subDays(rand(1, 30))
                ];
            }
        }

        DB::table('marketer_stock')->insert($data);
    }
}