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
                'value' => 'Digital Marketing Agency',
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
                'value' => '+62 812 3456 7890',
                'type' => 'text'
            ],
            [
                'key' => 'site_email',
                'value' => 'info@sonar-advertising.com',
                'type' => 'email'
            ],
            [
                'key' => 'site_address',
                'value' => 'Jl. Merdeka No. 123, Jakarta',
                'type' => 'text'
            ],
            [
                'key' => 'facebook_url',
                'value' => 'https://facebook.com/sonaradvertising',
                'type' => 'url'
            ],
            [
                'key' => 'instagram_url',
                'value' => 'https://instagram.com/sonaradvertising',
                'type' => 'url'
            ],
            [
                'key' => 'linkedin_url',
                'value' => 'https://linkedin.com/company/sonaradvertising',
                'type' => 'url'
            ],
            [
                'key' => 'twitter_url',
                'value' => 'https://twitter.com/sonaradvertising',
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
