<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            ProductSeeder::class,
            StoreSeeder::class,
            StockAssignmentSeeder::class,
            MarketerStockSeeder::class,
            InvoiceSeeder::class,
            InvoiceItemSeeder::class,
            StoreReturnSeeder::class,
            ReturnRequestSeeder::class,
            ActivityLogSeeder::class,
        ]);
    }
}