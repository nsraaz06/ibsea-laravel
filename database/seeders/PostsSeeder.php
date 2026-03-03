<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use Illuminate\Support\Str;

class PostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = [
            [
                'title' => 'UNION BUDGET 2026-27 Announced: Key focus on Startup Ecosystem growth.',
                'slug' => Str::slug('UNION BUDGET 2026-27 Announced'),
                'category' => 'News',
                'status' => 'Published',
                'show_on_slider' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'New Partnership with Global Trade Alliance signed in Zurich.',
                'slug' => Str::slug('New Partnership with Global Trade Alliance'),
                'category' => 'Press Release',
                'status' => 'Published',
                'show_on_slider' => true,
                'published_at' => now()->subDays(1),
            ],
            [
                'title' => 'Annual Startup Summit Registration Open Now!',
                'slug' => Str::slug('Annual Startup Summit Registration Open'),
                'category' => 'News',
                'status' => 'Published',
                'show_on_slider' => true,
                'published_at' => now()->subDays(2),
            ]
        ];

        foreach ($posts as $post) {
            Post::create($post);
        }
    }
}
