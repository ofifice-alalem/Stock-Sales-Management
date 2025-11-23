<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StoreReturnSeeder extends Seeder
{
    public function run(): void
    {
        $data = [];
        for ($i = 1; $i <= 50; $i++) {
            $data[] = [
                'invoice_id' => rand(1, 150),
                'product_id' => rand(1, 20),
                'marketer_id' => rand(4, 23),
                'quantity' => rand(1, 5),
                'created_at' => now()->subDays(rand(1, 60)),
                'updated_at' => now()
            ];
        }

        DB::table('store_returns')->insert($data);
    }
}