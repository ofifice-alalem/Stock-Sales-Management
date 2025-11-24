<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StoreDebtSeeder extends Seeder
{
    public function run(): void
    {
        $invoices = DB::table('invoices')->get();
        $data = [];

        foreach ($invoices as $invoice) {
            if ($invoice->total_amount && rand(0, 100) > 30) {
                $data[] = [
                    'store_id' => $invoice->store_id,
                    'marketer_id' => $invoice->marketer_id,
                    'invoice_id' => $invoice->id,
                    'amount' => $invoice->total_amount,
                    'note' => rand(0, 1) ? 'دين من فاتورة ' . $invoice->invoice_number : null,
                    'created_at' => $invoice->created_at,
                    'updated_at' => now()
                ];
            }
        }

        DB::table('store_debts')->insert($data);
    }
}
