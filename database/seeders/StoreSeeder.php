<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StoreSeeder extends Seeder
{
    public function run(): void
    {
        $stores = [
            ['صيدلية النور', 'شارع الجمهورية، المنصورة'],
            ['صيدلية الشفاء', 'شارع البحر، الإسكندرية'],
            ['صيدلية الأمل', 'شارع النيل، القاهرة'],
            ['صيدلية الرحمة', 'شارع الهرم، الجيزة'],
            ['صيدلية العافية', 'شارع المعادي، القاهرة'],
            ['صيدلية السلام', 'شارع الفتح، الإسكندرية'],
            ['صيدلية البركة', 'شارع العروبة، المنيا'],
            ['صيدلية الفجر', 'شارع المحطة، أسيوط'],
            ['صيدلية النهضة', 'شارع الجامعة، طنطا'],
            ['صيدلية المستقبل', 'شارع الملك، المنصورة'],
            ['صيدلية العز', 'شارع النصر، القاهرة'],
            ['صيدلية الفاروق', 'شارع العباسية، الإسكندرية'],
            ['صيدلية الزهراء', 'شارع الزهراء، القاهرة'],
            ['صيدلية الروضة', 'شارع الروضة، الجيزة'],
            ['صيدلية العمران', 'شارع العمران، المنيا']
        ];

        $data = [];
        foreach ($stores as $i => $store) {
            $data[] = [
                'name' => $store[0],
                'phone' => '011' . str_pad((string)($i + 1), 8, '0', STR_PAD_LEFT),
                'whatsapp_number' => '011' . str_pad((string)($i + 1), 8, '0', STR_PAD_LEFT),
                'address' => $store[1],
                'created_at' => now()->subDays(rand(1, 90)),
                'updated_at' => now()
            ];
        }

        DB::table('stores')->insert($data);
    }
}