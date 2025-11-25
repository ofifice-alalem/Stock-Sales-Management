<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StoreDebtPaymentSeeder extends Seeder
{
    public function run(): void
    {
        $stores = DB::table('stores')->get();

        foreach ($stores as $store) {
            $totalDebt = DB::table('invoices')
                ->where('store_id', $store->id)
                ->sum('total_amount');

            if ($totalDebt <= 0) {
                continue;
            }

            $remainingAmount = $totalDebt;
            $paymentsCount = rand(2, 5);
            $shouldPayFull = rand(1, 3) === 1;

            for ($i = 0; $i < $paymentsCount; $i++) {
                if ($remainingAmount <= 0) {
                    break;
                }

                if ($shouldPayFull && $i === $paymentsCount - 1) {
                    $paymentAmount = $remainingAmount;
                } else {
                    $maxPayment = min($remainingAmount, $totalDebt * 0.4);
                    $paymentAmount = rand((int)($maxPayment * 0.3), (int)$maxPayment);
                }

                $remainingAmount -= $paymentAmount;

                DB::table('store_debt_payments')->insert([
                    'store_id' => $store->id,
                    'marketer_id' => rand(4, 23),
                    'amount' => $paymentAmount,
                    'remaining' => max(0, $remainingAmount),
                    'note' => $i === 0 ? 'دفعة أولى' : ($remainingAmount <= 0 ? 'دفعة نهائية' : 'دفعة جزئية'),
                    'created_at' => now()->subDays(rand(1, 60)),
                    'updated_at' => now()
                ]);
            }
        }
    }
}
