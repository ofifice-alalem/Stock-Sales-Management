<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActivityLogSeeder extends Seeder
{
    public function run(): void
    {
        $actions = [
            'stock_assignment' => 'تسليم بضاعة',
            'invoice_created' => 'إنشاء فاتورة',
            'invoice_updated' => 'تعديل فاتورة',
            'return_request' => 'طلب إرجاع',
            'return_approved' => 'موافقة على الإرجاع',
            'stock_updated' => 'تحديث المخزون'
        ];
        
        $data = [];
        for ($i = 1; $i <= 200; $i++) {
            $actionType = array_rand($actions);
            $data[] = [
                'user_id' => rand(1, 23),
                'action_type' => $actionType,
                'reference_table' => $this->getTableForAction($actionType),
                'reference_id' => rand(1, 100),
                'product_id' => rand(0, 5) > 0 ? rand(1, 20) : null,
                'marketer_id' => rand(0, 3) > 0 ? rand(4, 23) : null,
                'store_id' => rand(0, 4) > 0 ? rand(1, 15) : null,
                'quantity' => rand(0, 3) > 0 ? rand(1, 50) : null,
                'old_quantity' => rand(0, 3) > 0 ? rand(0, 30) : null,
                'new_quantity' => rand(0, 3) > 0 ? rand(1, 50) : null,
                'description' => $actions[$actionType] . ' - عملية رقم ' . $i,
                'created_at' => now()->subDays(rand(1, 90))
            ];
        }

        DB::table('activity_log')->insert($data);
    }

    private function getTableForAction(string $action): string
    {
        $tables = [
            'stock_assignment' => 'stock_assignments',
            'invoice_created' => 'invoices',
            'invoice_updated' => 'invoices',
            'return_request' => 'return_requests',
            'return_approved' => 'return_requests',
            'stock_updated' => 'marketer_stock'
        ];
        
        return $tables[$action] ?? 'general';
    }
}