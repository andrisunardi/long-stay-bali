<?php

namespace Database\Seeders;

use App\Models\Guide;
use Illuminate\Database\Seeder;

class GuideSeeder extends Seeder
{
    public function run(): void
    {
        Guide::create([
            'guide_category_id' => 1,
            'title' => 'What to know before renting long-term in Bali',
            'title_id' => 'Apa yang perlu diketahui sebelum menyewa jangka panjang di Bali',
            'title_zh' => '在巴厘岛长期租房前需要了解的事项',
            'title_fr' => "Ce qu'il faut savoir avant de louer un logement à long terme à Bali",
            'body' => 'Lorem ipsum dolor sit amet consectetu pelleue faucibus volutpat Lorem ipsum dolor sit amet consectetur. Massa vutate ullamcorper pelleue faucibus volutpat metus. metus.',
            'body_id' => 'Lorem ipsum dolor sit amet consectetu pelleue faucibus volutpat Lorem ipsum dolor sit amet consectetur. Massa vutate ullamcorper pelleue faucibus volutpat metus. metus.',
            'body_zh' => 'Lorem ipsum dolor sit amet consectetu pelleue faucibus volutpat Lorem ipsum dolor sit amet consectetur. Massa vutate ullamcorper pelleue faucibus volutpat metus. metus.',
            'body_fr' => 'Lorem ipsum dolor sit amet consectetu pelleue faucibus volutpat Lorem ipsum dolor sit amet consectetur. Massa vutate ullamcorper pelleue faucibus volutpat metus. metus.',
            'google_file_id' => '',
            'image_url' => 'https://solivingbali.com/assets/images/guides/what-to-know-before-renting-long-term-in-bali.png',
            'slug' => 'what-to-know-before-renting-long-term-in-bali',
        ]);

        Guide::create([
            'guide_category_id' => 2,
            'title' => 'Monthly vs yearly rentals',
            'title_id' => 'Sewa bulanan vs tahunan',
            'title_zh' => '月租与年租对比',
            'title_fr' => 'Locations mensuelles ou annuelles',
            'body' => 'Lorem ipsum dolor sit amet consectetu pelleue faucibus volutpat Lorem ipsum dolor sit amet consectetur. Massa vutate ullamcorper pelleue faucibus volutpat metus. metus.',
            'body_id' => 'Lorem ipsum dolor sit amet consectetu pelleue faucibus volutpat Lorem ipsum dolor sit amet consectetur. Massa vutate ullamcorper pelleue faucibus volutpat metus. metus.',
            'body_zh' => 'Lorem ipsum dolor sit amet consectetu pelleue faucibus volutpat Lorem ipsum dolor sit amet consectetur. Massa vutate ullamcorper pelleue faucibus volutpat metus. metus.',
            'body_fr' => 'Lorem ipsum dolor sit amet consectetu pelleue faucibus volutpat Lorem ipsum dolor sit amet consectetur. Massa vutate ullamcorper pelleue faucibus volutpat metus. metus.',
            'google_file_id' => '',
            'image_url' => 'https://solivingbali.com/assets/images/guides/monthly-vs-yearly-rentals.png',
            'slug' => 'monthly-vs-yearly-rentals',
        ]);

        Guide::create([
            'guide_category_id' => 3,
            'title' => 'Choosing the right area to live in Bali',
            'title_id' => 'Memilih area yang tepat untuk tinggal di Bali',
            'title_zh' => '在巴厘岛选择合适的居住区域',
            'title_fr' => 'Choisir le bon quartier où vivre à Bali',
            'body' => 'Lorem ipsum dolor sit amet consectetu pelleue faucibus volutpat Lorem ipsum dolor sit amet consectetur. Massa vutate ullamcorper pelleue faucibus volutpat metus. metus.',
            'body_id' => 'Lorem ipsum dolor sit amet consectetu pelleue faucibus volutpat Lorem ipsum dolor sit amet consectetur. Massa vutate ullamcorper pelleue faucibus volutpat metus. metus.',
            'body_zh' => 'Lorem ipsum dolor sit amet consectetu pelleue faucibus volutpat Lorem ipsum dolor sit amet consectetur. Massa vutate ullamcorper pelleue faucibus volutpat metus. metus.',
            'body_fr' => 'Lorem ipsum dolor sit amet consectetu pelleue faucibus volutpat Lorem ipsum dolor sit amet consectetur. Massa vutate ullamcorper pelleue faucibus volutpat metus. metus.',
            'google_file_id' => '',
            'image_url' => 'https://solivingbali.com/assets/images/guides/choosing-the-right-area-to-live-in-bali.png',
            'slug' => 'choosing-the-right-area-to-live-in-bali',
        ]);

        Guide::create([
            'guide_category_id' => 3,
            'title' => 'Choosing the right area to live in Bali 2',
            'title_id' => 'Memilih area yang tepat untuk tinggal di Bali 2',
            'title_zh' => '在巴厘岛选择合适的居住区域 2',
            'title_fr' => 'Choisir le bon quartier où vivre à Bali 2',
            'body' => 'Lorem ipsum dolor sit amet consectetu pelleue faucibus volutpat Lorem ipsum dolor sit amet consectetur. Massa vutate ullamcorper pelleue faucibus volutpat metus. metus.',
            'body_id' => 'Lorem ipsum dolor sit amet consectetu pelleue faucibus volutpat Lorem ipsum dolor sit amet consectetur. Massa vutate ullamcorper pelleue faucibus volutpat metus. metus.',
            'body_zh' => 'Lorem ipsum dolor sit amet consectetu pelleue faucibus volutpat Lorem ipsum dolor sit amet consectetur. Massa vutate ullamcorper pelleue faucibus volutpat metus. metus.',
            'body_fr' => 'Lorem ipsum dolor sit amet consectetu pelleue faucibus volutpat Lorem ipsum dolor sit amet consectetur. Massa vutate ullamcorper pelleue faucibus volutpat metus. metus.',
            'google_file_id' => '',
            'image_url' => 'https://solivingbali.com/assets/images/guides/choosing-the-right-area-to-live-in-bali-2.png',
            'slug' => 'choosing-the-right-area-to-live-in-bali-2',
        ]);
    }
}
