<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InvoiceSeeder extends Seeder
{
    public function run(): void
    {
        $data = [];
        for ($i = 1; $i <= 150; $i++) {
            $createdAt = now()->subDays(rand(1, 90));
            $data[] = [
                'invoice_number' => 'INV-' . str_pad((string)$i, 4, '0', STR_PAD_LEFT),
                'marketer_id' => rand(4, 23),
                'store_id' => rand(1, 15),
                'total_amount' => 0,
                'sent_to_whatsapp' => rand(0, 1),
                'created_at' => $createdAt,
                'updated_at' => $createdAt
            ];
        }

        DB::table('invoices')->insert($data);
    }
}