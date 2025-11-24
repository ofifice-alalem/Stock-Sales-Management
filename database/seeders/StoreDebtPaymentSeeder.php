<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StoreDebtPaymentSeeder extends Seeder
{
    public function run(): void
    {
        $debts = DB::table('store_debts')->get();
        $data = [];

        foreach ($debts as $debt) {
            $remainingAmount = $debt->amount;
            $paymentsCount = rand(1, 3);

            for ($i = 0; $i < $paymentsCount; $i++) {
                if ($remainingAmount <= 0) {
                    break;
                }

                $paymentAmount = $i === $paymentsCount - 1 
                    ? $remainingAmount 
                    : rand(50, (int)($remainingAmount * 0.6));

                $remainingAmount -= $paymentAmount;

                $data[] = [
                    'store_id' => $debt->store_id,
                    'marketer_id' => $debt->marketer_id,
                    'amount' => $paymentAmount,
                    'remaining' => max(0, $remainingAmount),
                    'note' => rand(0, 1) ? 'دفعة جزئية' : null,
                    'created_at' => now()->subDays(rand(0, 30)),
                    'updated_at' => now()
                ];
            }
        }

        DB::table('store_debt_payments')->insert($data);
    }
}
