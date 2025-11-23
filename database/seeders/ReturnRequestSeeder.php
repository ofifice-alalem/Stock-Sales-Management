<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReturnRequestSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = ['pending', 'approved', 'rejected'];
        $data = [];
        
        for ($i = 1; $i <= 80; $i++) {
            $status = $statuses[rand(0, 2)];
            $data[] = [
                'marketer_id' => rand(4, 23),
                'product_id' => rand(1, 20),
                'quantity' => rand(1, 10),
                'status' => $status,
                'approved_by' => $status != 'pending' ? rand(2, 3) : null,
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now()
            ];
        }

        DB::table('return_requests')->insert($data);
    }
}