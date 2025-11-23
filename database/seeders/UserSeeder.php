<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['role_id' => 1, 'name' => 'أحمد محمد', 'email' => 'admin@example.com', 'username' => 'admin'],
            ['role_id' => 2, 'name' => 'محمد علي', 'email' => 'storekeeper1@example.com', 'username' => 'storekeeper1'],
            ['role_id' => 2, 'name' => 'فاطمة حسن', 'email' => 'storekeeper2@example.com', 'username' => 'storekeeper2'],
        ];

        $marketers = [
            'سارة أحمد', 'خالد حسن', 'نور محمد', 'عمر علي', 'ليلى حسام', 'يوسف أحمد', 'مريم سالم',
            'حسام محمود', 'دينا عبدالله', 'طارق إبراهيم', 'رنا خالد', 'محمود فتحي', 'هدى عمر',
            'كريم سعد', 'نادية حسن', 'أسامة علي', 'منى محمد', 'وليد أحمد', 'سمر حسين', 'عادل محمد'
        ];

        foreach ($marketers as $i => $name) {
            $users[] = [
                'role_id' => 3,
                'name' => $name,
                'email' => 'marketer' . ($i + 1) . '@example.com',
                'username' => 'marketer' . ($i + 1)
            ];
        }

        $data = [];
        foreach ($users as $i => $user) {
            $data[] = [
                'role_id' => $user['role_id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'phone' => '0123456789' . str_pad((string)$i, 2, '0', STR_PAD_LEFT),
                'whatsapp_number' => '0123456789' . str_pad((string)$i, 2, '0', STR_PAD_LEFT),
                'username' => $user['username'],
                'password' => Hash::make('password'),
                'is_active' => rand(0, 10) > 1,
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now()
            ];
        }

        DB::table('users')->insert($data);
    }
}