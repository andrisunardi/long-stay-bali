<?php

namespace Database\Seeders;

use App\Models\Value;
use Illuminate\Database\Seeder;

class ValueSeeder extends Seeder
{
    public function run(): void
    {
        Value::create([
            'title' => 'Curated Homes',
            'title_id' => 'Rumah Terpilih',
            'title_zh' => '精选住宅',
            'title_fr' => 'Maisons sélectionnées',
            'short_description' => 'Homes selected for monthly and yearly living.',
            'short_description_id' => 'Rumah yang dipilih untuk hunian bulanan dan tahunan.',
            'short_description_zh' => '为月租和年租生活精心挑选的住宅。',
            'short_description_fr' => 'Maisons sélectionnées pour une occupation mensuelle et annuelle.',
            'description' => 'Homes selected for monthly and yearly living. Fully furnished, well-maintained, and defined by a consistent standar of comfort and functionality.',
            'description_id' => 'Rumah yang dipilih untuk hunian bulanan dan tahunan. Lengkap dengan perabotan, terawat dengan baik, dan didefinisikan oleh standar kenyamanan dan fungsionalitas yang konsisten.',
            'description_zh' => '为月租和年租生活精心挑选的住宅。设施齐全，维护良好，以一致的舒适和功能标准为特色。',
            'description_fr' => 'Maisons sélectionnées pour des locations mensuelles ou annuelles. Entièrement meublées, bien entretenues et caractérisées par un niveau de confort et de fonctionnalité constant.',
            'icon' => 'fas fa-building',
        ]);

        Value::create([
            'title' => 'Effortless Living',
            'title_id' => 'Hidup Tanpa Repot',
            'title_zh' => '轻松生活',
            'title_fr' => 'Vivre sans effort',
            'short_description' => 'Support beyond the property, from daily needs to practical setups.',
            'short_description_id' => 'Dukungan di luar properti, dari kebutuhan sehari-hari hingga pengaturan praktis.',
            'short_description_zh' => '超越房产的支持，从日常需求到实用设置。',
            'short_description_fr' => 'Un soutien qui va au-delà de la propriété, des besoins quotidiens aux aménagements pratiques.',
            'description' => 'A smooth living experience, from the moment you arrive. Supported by a trusted network, connecting you to everything you may need. Daily life flows with ease.',
            'description_id' => 'Pengalaman hidup yang lancar, sejak saat Anda tiba. Didukung oleh jaringan terpercaya, menghubungkan Anda dengan segala yang mungkin Anda butuhkan. Kehidupan sehari-hari berjalan dengan mudah.',
            'description_zh' => '从您到达的那一刻起，享受顺畅的生活体验。由可信赖的网络支持，为您连接所需的一切。日常生活轻松流畅。',
            'description_fr' => 'Un séjour tout en douceur dès votre arrivée. Un réseau de confiance vous connecte à tout ce dont vous avez besoin. Votre quotidien se déroule en toute sérénité.',
            'icon' => 'fas fa-screwdriver-wrench',
        ]);

        Value::create([
            'title' => 'Reliable Support',
            'title_id' => 'Dukungan Terpercaya',
            'title_zh' => '可靠支持',
            'title_fr' => 'Assistance fiable',
            'short_description' => 'A guided, Whatsapp based approach with real people.',
            'short_description_id' => 'Pendekatan terpandu berbasis WhatsApp dengan orang sungguhan.',
            'short_description_zh' => '基于WhatsApp的指导方式，真人服务。',
            'short_description_fr' => 'Une approche guidée, via WhatsApp, avec de vraies personnes.',
            'description' => 'A steady presence, throughout your time here. Support that stays with you, beyond just the key handover.',
            'description_id' => 'Kehadiran yang stabil, sepanjang waktu Anda di sini. Dukungan yang tetap bersama Anda, lebih dari sekadar penyerahan kunci.',
            'description_zh' => '在您居住期间持续稳定的陪伴。支持伴随您始终，不仅仅是钥匙交接。',
            'description_fr' => 'Une présence constante, tout au long de votre séjour. Un soutien qui perdure, bien au-delà de la simple remise des clés.',
            'icon' => 'fas fa-phone',
        ]);
    }
}
