<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InvoiceItemSeeder extends Seeder
{
    public function run(): void
    {
        $data = [];
        for ($invoice = 1; $invoice <= 150; $invoice++) {
            $itemsCount = rand(1, 5);
            for ($item = 1; $item <= $itemsCount; $item++) {
                $data[] = [
                    'invoice_id' => $invoice,
                    'product_id' => rand(1, 20),
                    'quantity' => rand(1, 20),
                    'price' => rand(5, 100) + (rand(0, 99) / 100),
                    'created_at' => now()->subDays(rand(1, 90)),
                    'updated_at' => now()
                ];
            }
        }

        DB::table('invoice_items')->insert($data);
    }
}