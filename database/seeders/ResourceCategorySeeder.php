<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ResourceCategory;

class ResourceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sectors = [
            [
                'name' => 'Technology & Digital Innovation',
                'icon' => 'memory',
                'description' => 'Strategic intelligence on software, AI, and digital transformation in global markets.'
            ],
            [
                'name' => 'Sustainable Energy & Cleantech',
                'icon' => 'eco',
                'description' => 'Insights into renewable energy frameworks and environmental sustainability policies.'
            ],
            [
                'name' => 'Healthcare & Life Sciences',
                'icon' => 'health_and_safety',
                'description' => 'Critical data on medical advancements, biotech, and global health operations.'
            ],
            [
                'name' => 'Fintech & Economy Strategy',
                'icon' => 'account_balance',
                'description' => 'Market analysis, venture capital trends, and strategic financial intelligence.'
            ],
            [
                'name' => 'Agri-Tech & Food Security',
                'icon' => 'agriculture',
                'description' => 'Intelligence on sustainable agriculture and global food supply chain stability.'
            ],
            [
                'name' => 'Education & Human Capital',
                'icon' => 'school',
                'description' => 'Strategic developments in global learning and professional skill-mapping.'
            ],
        ];

        foreach ($sectors as $sector) {
            ResourceCategory::updateOrCreate(
                ['name' => $sector['name']],
                [
                    'icon' => $sector['icon'],
                    'description' => $sector['description']
                ]
            );
        }
    }
}
