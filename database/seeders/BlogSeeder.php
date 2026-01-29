<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\PostCategory;
use App\Models\Post;
use Illuminate\Support\Facades\Hash;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Create categories
        $categories = [
            ['name' => 'Entertainment', 'icon' => 'fas fa-film', 'order' => 1],
            ['name' => 'Music', 'icon' => 'fas fa-music', 'order' => 2],
            ['name' => 'Gaming', 'icon' => 'fas fa-gamepad', 'order' => 3],
            ['name' => 'Sports', 'icon' => 'fas fa-football-ball', 'order' => 4],
            ['name' => 'News', 'icon' => 'fas fa-newspaper', 'order' => 5],
            ['name' => 'Comedy', 'icon' => 'fas fa-laugh', 'order' => 6],
        ];

        foreach ($categories as $categoryData) {
            PostCategory::firstOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($categoryData['name'])],
                array_merge($categoryData, ['is_active' => true])
            );
        }

        // Create sample posts
        $samplePosts = [
            [
                'title' => 'Amazing Football Highlights 2024',
                'description' => 'Watch the best football moments from this week. Incredible goals, saves, and skills!',
                'facebook_video_url' => 'https://www.facebook.com/watch?v=123456789',
                'category' => 'Sports',
                'is_featured' => true,
            ],
            [
                'title' => 'Funny Cat Compilation',
                'description' => 'The funniest cat videos you will see today. These cats are hilarious!',
                'facebook_video_url' => 'https://www.facebook.com/watch?v=987654321',
                'category' => 'Entertainment',
                'is_featured' => true,
            ],
            [
                'title' => 'Latest Music Video Release',
                'description' => 'Check out this amazing new music video from top artists',
                'facebook_video_url' => 'https://www.facebook.com/watch?v=456789123',
                'category' => 'Music',
                'is_featured' => true,
            ],
            [
                'title' => 'Epic Gaming Moments',
                'description' => 'Best gaming highlights and epic wins from popular streamers',
                'facebook_video_url' => 'https://www.facebook.com/watch?v=111222333',
                'category' => 'Gaming',
                'is_featured' => false,
            ],
            [
                'title' => 'Breaking News Update',
                'description' => 'Latest news coverage and important updates from around the world',
                'facebook_video_url' => 'https://www.facebook.com/watch?v=444555666',
                'category' => 'News',
                'is_featured' => false,
            ],
            [
                'title' => 'Stand Up Comedy Special',
                'description' => 'Hilarious stand-up comedy performance that will make you laugh',
                'facebook_video_url' => 'https://www.facebook.com/watch?v=777888999',
                'category' => 'Comedy',
                'is_featured' => false,
            ],
            [
                'title' => 'Basketball Championship Finals',
                'description' => 'Intense basketball game with amazing plays and clutch moments',
                'facebook_video_url' => 'https://www.facebook.com/watch?v=101112131',
                'category' => 'Sports',
                'is_featured' => false,
            ],
            [
                'title' => 'Movie Trailer Reaction',
                'description' => 'Exciting reaction to the latest blockbuster movie trailer',
                'facebook_video_url' => 'https://www.facebook.com/watch?v=141516171',
                'category' => 'Entertainment',
                'is_featured' => false,
            ],
            [
                'title' => 'Top 10 Songs This Week',
                'description' => 'Countdown of the hottest music tracks trending right now',
                'facebook_video_url' => 'https://www.facebook.com/watch?v=181920212',
                'category' => 'Music',
                'is_featured' => false,
            ],
            [
                'title' => 'Pro Gamer Tournament Highlights',
                'description' => 'Professional esports tournament with incredible gameplay',
                'facebook_video_url' => 'https://www.facebook.com/watch?v=222324252',
                'category' => 'Gaming',
                'is_featured' => false,
            ],
            [
                'title' => 'World News Roundup',
                'description' => 'Comprehensive coverage of today\'s most important news stories',
                'facebook_video_url' => 'https://www.facebook.com/watch?v=262728293',
                'category' => 'News',
                'is_featured' => false,
            ],
            [
                'title' => 'Comedy Sketch Show',
                'description' => 'Funny sketches and parodies that will brighten your day',
                'facebook_video_url' => 'https://www.facebook.com/watch?v=303132333',
                'category' => 'Comedy',
                'is_featured' => false,
            ],
            [
                'title' => 'Tennis Match Highlights',
                'description' => 'Thrilling tennis match with incredible rallies and shots',
                'facebook_video_url' => 'https://www.facebook.com/watch?v=343536373',
                'category' => 'Sports',
                'is_featured' => false,
            ],
            [
                'title' => 'Behind The Scenes Movie Making',
                'description' => 'Exclusive behind-the-scenes footage from a major film production',
                'facebook_video_url' => 'https://www.facebook.com/watch?v=383940414',
                'category' => 'Entertainment',
                'is_featured' => false,
            ],
            [
                'title' => 'Live Concert Performance',
                'description' => 'Amazing live performance from a sold-out concert venue',
                'facebook_video_url' => 'https://www.facebook.com/watch?v=424344454',
                'category' => 'Music',
                'is_featured' => false,
            ],
            [
                'title' => 'Speedrun World Record',
                'description' => 'Incredible speedrun breaking the world record in popular game',
                'facebook_video_url' => 'https://www.facebook.com/watch?v=464748495',
                'category' => 'Gaming',
                'is_featured' => false,
            ],
            [
                'title' => 'Tech News and Reviews',
                'description' => 'Latest technology news and product reviews you need to know',
                'facebook_video_url' => 'https://www.facebook.com/watch?v=505152535',
                'category' => 'News',
                'is_featured' => false,
            ],
            [
                'title' => 'Improv Comedy Show',
                'description' => 'Spontaneous and hilarious improv comedy performance',
                'facebook_video_url' => 'https://www.facebook.com/watch?v=545556575',
                'category' => 'Comedy',
                'is_featured' => false,
            ],
            [
                'title' => 'Soccer Goals Compilation',
                'description' => 'Best soccer goals from leagues around the world this season',
                'facebook_video_url' => 'https://www.facebook.com/watch?v=585960616',
                'category' => 'Sports',
                'is_featured' => false,
            ],
            [
                'title' => 'Celebrity Interview Special',
                'description' => 'Exclusive interview with A-list celebrities about their latest projects',
                'facebook_video_url' => 'https://www.facebook.com/watch?v=626364656',
                'category' => 'Entertainment',
                'is_featured' => false,
            ],
        ];

        foreach ($samplePosts as $postData) {
            $category = PostCategory::where('name', $postData['category'])->first();
            
            Post::firstOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($postData['title'])],
                [
                    'title' => $postData['title'],
                    'description' => $postData['description'],
                    'facebook_video_url' => $postData['facebook_video_url'],
                    'category_id' => $category?->id,
                    'user_id' => $admin->id,
                    'status' => 'published',
                    'is_featured' => $postData['is_featured'],
                    'published_at' => now(),
                    'views' => rand(100, 10000),
                ]
            );
        }

        $this->command->info('Blog seeder completed successfully!');
    }
}
