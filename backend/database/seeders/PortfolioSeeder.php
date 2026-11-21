<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        $userId = DB::table('users')->first()?->id ?? null;

        $items = [
            [
                'user_id' => $userId,
                'title' => 'Huruf Timbul Stainless Backlit',
                'description' => 'Huruf timbul stainless steel 304 dengan pencahayaan LED warm white untuk estetika elegan.',
                'category' => 'Huruf Timbul',
                'main_image' => '/hero-bg.webp',
                'gallery_images' => json_encode(['/hero-bg.webp']),
                'client' => 'Klinik Estetika Glow',
                'project_date' => '2026-03-15',
                'is_active' => true,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $userId,
                'title' => 'Neon Box Akrilik Bulat Dua Sisi',
                'description' => 'Neon box akrilik profil aluminium dengan stiker oracal tembus cahaya berdaya tahan tinggi.',
                'category' => 'Neon Box',
                'main_image' => '/warm-brick-wall.jpg',
                'gallery_images' => json_encode(['/warm-brick-wall.jpg']),
                'client' => 'Kopi Kenangan Sejahtera',
                'project_date' => '2026-04-10',
                'is_active' => true,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $userId,
                'title' => 'Fasad ACP & Signboard Ruko',
                'description' => 'Renovasi fasad gedung ruko modern menggunakan ACP seven dan logo laser akrilik timbul.',
                'category' => 'Fasad ACP',
                'main_image' => '/hero-bg.png',
                'gallery_images' => json_encode(['/hero-bg.png']),
                'client' => 'Apotek Sahabat Medika',
                'project_date' => '2026-05-02',
                'is_active' => true,
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $userId,
                'title' => 'Papan Nama Toko Plat Galvanis Cat Duco',
                'description' => 'Papan nama toko plat galvanis tahan cuaca dengan cat duco mobil dan finishing clear coat glossy.',
                'category' => 'Papan Nama',
                'main_image' => '/hero-bg.webp',
                'gallery_images' => json_encode(['/hero-bg.webp']),
                'client' => 'Minimarket Barokah Mart',
                'project_date' => '2026-05-20',
                'is_active' => true,
                'sort_order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $userId,
                'title' => 'Neon Flex Custom Interior Cafe',
                'description' => 'Instalasi neon flex silikon 12V untuk backdrop photobooth dengan cahaya warm white dan pink lembut.',
                'category' => 'Neon Flex',
                'main_image' => '/warm-brick-wall.jpg',
                'gallery_images' => json_encode(['/warm-brick-wall.jpg']),
                'client' => 'Senja Roastery & Eatery',
                'project_date' => '2026-06-05',
                'is_active' => true,
                'sort_order' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $userId,
                'title' => 'Billboard Rangka Baja 4x8 Meter',
                'description' => 'Konstruksi billboard tiang ganda rangka baja pipa besi kokoh standar keamanan dinas pekerjaan umum.',
                'category' => 'Billboard',
                'main_image' => '/hero-bg.png',
                'gallery_images' => json_encode(['/hero-bg.png']),
                'client' => 'Perumahan Grand Permata',
                'project_date' => '2026-06-18',
                'is_active' => true,
                'sort_order' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($items as $item) {
            DB::table('portfolio')->updateOrInsert(
                ['title' => $item['title']],
                $item
            );
        }
    }
}
