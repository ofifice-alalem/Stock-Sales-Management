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
            for ($product = 1; $product <= 20; $product++) {
                if (rand(1, 3) == 1) {
                    $data[] = [
                        'marketer_id' => $marketer,
                        'product_id' => $product,
                        'quantity' => rand(0, 50),
                        'updated_at' => now()
                    ];
                }
            }
        }

        DB::table('marketer_stock')->insert($data);
    }
}