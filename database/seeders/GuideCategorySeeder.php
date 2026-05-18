<?php

namespace Database\Seeders;

use App\Models\GuideCategory;
use Illuminate\Database\Seeder;

class GuideCategorySeeder extends Seeder
{
    public function run(): void
    {
        GuideCategory::create([
            'name' => 'Rental Advice',
            'name_id' => 'Saran Sewa',
            'name_zh' => '租赁建议',
            'name_fr' => 'Conseils en matière de location',
        ]);

        GuideCategory::create([
            'name' => 'Area Guides',
            'name_id' => 'Panduan Wilayah',
            'name_zh' => '地区指南',
            'name_fr' => 'Guides régionaux',
        ]);

        GuideCategory::create([
            'name' => 'Living In Bali',
            'name_id' => 'Tinggal di Bali',
            'name_zh' => '在巴厘岛生活',
            'name_fr' => 'Vivre à Bali',
        ]);
    }
}
