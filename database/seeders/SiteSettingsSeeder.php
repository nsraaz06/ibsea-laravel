<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SiteSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            'contact_email' => 'info@ibsea.org',
            'contact_phone' => '+91 76518 76071',
            'hq_address' => "5, Sansad Marg,\nNew Delhi - 110001",
            'facebook_link' => 'https://facebook.com/ibsea',
            'twitter_link' => 'https://twitter.com/ibsea',
            'instagram_link' => 'https://instagram.com/ibsea',
            'linkedin_link' => 'https://linkedin.com/company/ibsea'
        ];

        foreach ($settings as $key => $value) {
            \App\Models\SiteSetting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
