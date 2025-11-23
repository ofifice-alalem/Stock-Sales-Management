<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StockAssignmentSeeder extends Seeder
{
    public function run(): void
    {
        $data = [];
        for ($i = 1; $i <= 100; $i++) {
            $data[] = [
                'marketer_id' => rand(4, 23),
                'product_id' => rand(1, 20),
                'quantity' => rand(10, 100),
                'approved_by' => rand(2, 3),
                'created_at' => now()->subDays(rand(1, 60)),
                'updated_at' => now()
            ];
        }

        DB::table('stock_assignments')->insert($data);
    }
}