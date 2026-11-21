<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            [
                'key' => 'site_name',
                'value' => 'Sonar Advertising',
                'type' => 'text'
            ],
            [
                'key' => 'site_description',
                'value' => 'Jasa Pembuatan Huruf Timbul, Neon Box & Reklame di Jember, Kediri & Jawa Timur',
                'type' => 'text'
            ],
            [
                'key' => 'site_logo',
                'value' => null,
                'type' => 'image'
            ],
            [
                'key' => 'site_favicon',
                'value' => null,
                'type' => 'image'
            ],
            [
                'key' => 'site_phone',
                'value' => '+62 855-4000-0007',
                'type' => 'text'
            ],
            [
                'key' => 'site_email',
                'value' => 'sonaradvertising@gmail.com',
                'type' => 'email'
            ],
            [
                'key' => 'site_address',
                'value' => 'Kalimalang, Mayangan, Gumukmas, Jember, Jawa Timur',
                'type' => 'text'
            ],
            [
                'key' => 'facebook_url',
                'value' => 'https://www.facebook.com/share/195r6jnMJE/?mibextid=wwXIfr',
                'type' => 'url'
            ],
            [
                'key' => 'instagram_url',
                'value' => 'https://instagram.com/sonaradv',
                'type' => 'url'
            ],
            [
                'key' => 'tiktok_url',
                'value' => 'https://www.tiktok.com/@sonar.adv',
                'type' => 'url'
            ]
        ];

        foreach ($settings as $setting) {
            Setting::firstOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value'], 'type' => $setting['type']]
            );
        }

        $this->command->info('Default settings created!');
    }
}
