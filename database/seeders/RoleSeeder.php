<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->insert([
            ['name' => 'admin', 'display_name' => 'مدير النظام', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'storekeeper', 'display_name' => 'أمين المخزن', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'marketer', 'display_name' => 'مسوق', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}