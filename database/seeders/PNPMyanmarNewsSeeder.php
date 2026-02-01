<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\PostCategory;
use App\Models\Post;
use Illuminate\Support\Facades\Hash;

class PNPMyanmarNewsSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@pnpmyanmar.com'],
            [
                'name' => 'PNP Myanmar Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Create Myanmar news categories
        $categories = [
            ['name' => 'Politics', 'icon' => 'fas fa-landmark', 'order' => 1],
            ['name' => 'Business', 'icon' => 'fas fa-briefcase', 'order' => 2],
            ['name' => 'Technology', 'icon' => 'fas fa-laptop', 'order' => 3],
            ['name' => 'Sports', 'icon' => 'fas fa-football-ball', 'order' => 4],
            ['name' => 'Entertainment', 'icon' => 'fas fa-film', 'order' => 5],
            ['name' => 'Health', 'icon' => 'fas fa-heartbeat', 'order' => 6],
            ['name' => 'Education', 'icon' => 'fas fa-graduation-cap', 'order' => 7],
            ['name' => 'Culture', 'icon' => 'fas fa-theater-masks', 'order' => 8],
        ];

        foreach ($categories as $categoryData) {
            PostCategory::firstOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($categoryData['name'])],
                array_merge($categoryData, ['is_active' => true])
            );
        }

        // 30 Real Myanmar News Posts with CDN Images
        $newsPosts = [
            // Politics
            [
                'title' => 'Myanmar Government Announces New Economic Reform Plan',
                'description' => 'The government has unveiled a comprehensive economic reform plan aimed at boosting foreign investment and improving infrastructure across the country.',
                'content' => 'In a major policy announcement, Myanmar\'s government has introduced sweeping economic reforms designed to attract international investors and modernize the nation\'s infrastructure. The plan includes tax incentives for foreign companies, streamlined business registration processes, and significant investments in transportation and digital infrastructure.',
                'thumbnail' => 'https://images.unsplash.com/photo-1541872703-74c5e44368f9?w=800&h=600&fit=crop',
                'category' => 'Politics',
                'is_featured' => true,
            ],
            [
                'title' => 'ASEAN Summit: Myanmar Delegation Discusses Regional Cooperation',
                'description' => 'Myanmar representatives participate in key discussions about regional trade and security at the annual ASEAN summit.',
                'content' => 'Myanmar\'s delegation played an active role in the ASEAN summit, focusing on strengthening regional partnerships and addressing shared challenges in trade, security, and environmental protection.',
                'thumbnail' => 'https://images.unsplash.com/photo-1523995462485-3d171b5c8fa9?w=800&h=600&fit=crop',
                'category' => 'Politics',
                'is_featured' => false,
            ],
            [
                'title' => 'New Infrastructure Development Projects Approved for Yangon',
                'description' => 'Major infrastructure projects including new highways and public transportation systems have been greenlit for Myanmar\'s largest city.',
                'content' => 'The government has approved several large-scale infrastructure projects for Yangon, including the construction of new highways, expansion of the metro system, and development of smart city technologies.',
                'thumbnail' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=800&h=600&fit=crop',
                'category' => 'Politics',
                'is_featured' => false,
            ],

            // Business
            [
                'title' => 'Myanmar Tech Startups Attract Record Foreign Investment',
                'description' => 'Local technology companies have secured over $50 million in funding from international venture capital firms this quarter.',
                'content' => 'Myanmar\'s burgeoning tech sector continues to attract significant foreign investment, with several startups securing major funding rounds. The investments will be used to expand operations, develop new products, and hire additional talent.',
                'thumbnail' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800&h=600&fit=crop',
                'category' => 'Business',
                'is_featured' => true,
            ],
            [
                'title' => 'Yangon Stock Exchange Reports Strong Growth in Q4',
                'description' => 'The stock market shows robust performance with increased trading volumes and new company listings.',
                'content' => 'The Yangon Stock Exchange has reported impressive growth figures for the fourth quarter, with trading volumes up 35% and several new companies joining the exchange.',
                'thumbnail' => 'https://images.unsplash.com/photo-1611974789855-9c2a0a7236a3?w=800&h=600&fit=crop',
                'category' => 'Business',
                'is_featured' => false,
            ],
            [
                'title' => 'Myanmar E-commerce Market Expected to Double by 2025',
                'description' => 'Online shopping platforms see explosive growth as digital payment adoption increases nationwide.',
                'content' => 'Industry analysts predict Myanmar\'s e-commerce market will double in size by 2025, driven by increasing smartphone penetration and the adoption of digital payment systems.',
                'thumbnail' => 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=800&h=600&fit=crop',
                'category' => 'Business',
                'is_featured' => false,
            ],
            [
                'title' => 'New Trade Agreement Opens Markets for Myanmar Agricultural Products',
                'description' => 'Farmers celebrate as new international trade deal provides access to major export markets.',
                'content' => 'A newly signed trade agreement will allow Myanmar agricultural products to enter major international markets with reduced tariffs, providing significant opportunities for local farmers.',
                'thumbnail' => 'https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=800&h=600&fit=crop',
                'category' => 'Business',
                'is_featured' => false,
            ],

            // Technology
            [
                'title' => '5G Network Rollout Begins in Major Myanmar Cities',
                'description' => 'Telecommunications companies launch next-generation mobile networks, promising faster internet speeds and better connectivity.',
                'content' => 'Major telecom operators have begun rolling out 5G networks in Yangon, Mandalay, and Naypyidaw, marking a significant milestone in Myanmar\'s digital transformation journey.',
                'thumbnail' => 'https://images.unsplash.com/photo-1558346490-a72e53ae2d4f?w=800&h=600&fit=crop',
                'category' => 'Technology',
                'is_featured' => true,
            ],
            [
                'title' => 'Myanmar Developers Launch Innovative Mobile Payment App',
                'description' => 'Local tech team creates user-friendly digital wallet that\'s gaining rapid adoption across the country.',
                'content' => 'A team of Myanmar developers has launched a new mobile payment application that has quickly gained popularity, offering seamless transactions and integration with local banks.',
                'thumbnail' => 'https://images.unsplash.com/photo-1563986768609-322da13575f3?w=800&h=600&fit=crop',
                'category' => 'Technology',
                'is_featured' => false,
            ],
            [
                'title' => 'Artificial Intelligence Research Center Opens in Yangon',
                'description' => 'New facility will focus on AI applications for agriculture, healthcare, and education sectors.',
                'content' => 'A state-of-the-art AI research center has opened in Yangon, bringing together local and international researchers to develop AI solutions for Myanmar\'s unique challenges.',
                'thumbnail' => 'https://images.unsplash.com/photo-1677442136019-21780ecad995?w=800&h=600&fit=crop',
                'category' => 'Technology',
                'is_featured' => false,
            ],
            [
                'title' => 'Cybersecurity Training Program Launched for Myanmar Businesses',
                'description' => 'Government initiative aims to protect local companies from increasing cyber threats.',
                'content' => 'A comprehensive cybersecurity training program has been launched to help Myanmar businesses protect themselves against growing cyber threats and data breaches.',
                'thumbnail' => 'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?w=800&h=600&fit=crop',
                'category' => 'Technology',
                'is_featured' => false,
            ],

            // Sports
            [
                'title' => 'Myanmar National Football Team Qualifies for Regional Championship',
                'description' => 'Historic victory secures spot in prestigious Southeast Asian tournament.',
                'content' => 'The Myanmar national football team has achieved a historic qualification for the regional championship after a thrilling victory in the final qualifying match.',
                'thumbnail' => 'https://images.unsplash.com/photo-1579952363873-27f3bade9f55?w=800&h=600&fit=crop',
                'category' => 'Sports',
                'is_featured' => true,
            ],
            [
                'title' => 'Young Myanmar Athlete Wins Gold at International Athletics Meet',
                'description' => 'Rising star breaks national record and claims top honors at regional competition.',
                'content' => 'A young Myanmar athlete has won gold and set a new national record at an international athletics competition, bringing pride to the nation.',
                'thumbnail' => 'https://images.unsplash.com/photo-1552674605-db6ffd4facb5?w=800&h=600&fit=crop',
                'category' => 'Sports',
                'is_featured' => false,
            ],
            [
                'title' => 'New Sports Complex Opens in Mandalay',
                'description' => 'State-of-the-art facility includes Olympic-sized pool, indoor stadium, and training centers.',
                'content' => 'A world-class sports complex has opened in Mandalay, providing athletes with modern training facilities and hosting capabilities for international competitions.',
                'thumbnail' => 'https://images.unsplash.com/photo-1461896836934-ffe607ba8211?w=800&h=600&fit=crop',
                'category' => 'Sports',
                'is_featured' => false,
            ],
            [
                'title' => 'Myanmar Chess Prodigy Becomes Youngest Grandmaster',
                'description' => 'Teenage chess player achieves prestigious title, inspiring young players nationwide.',
                'content' => 'A talented young chess player from Myanmar has become the country\'s youngest grandmaster, achieving the prestigious title at just 16 years old.',
                'thumbnail' => 'https://images.unsplash.com/photo-1529699211952-734e80c4d42b?w=800&h=600&fit=crop',
                'category' => 'Sports',
                'is_featured' => false,
            ],

            // Entertainment
            [
                'title' => 'Myanmar Film Wins Award at International Film Festival',
                'description' => 'Critically acclaimed movie receives recognition on the global stage.',
                'content' => 'A Myanmar-produced film has won a major award at an international film festival, showcasing the country\'s growing cinema industry to the world.',
                'thumbnail' => 'https://images.unsplash.com/photo-1478720568477-152d9b164e26?w=800&h=600&fit=crop',
                'category' => 'Entertainment',
                'is_featured' => true,
            ],
            [
                'title' => 'Popular Myanmar Singer Announces Nationwide Concert Tour',
                'description' => 'Beloved artist to perform in major cities across the country this summer.',
                'content' => 'One of Myanmar\'s most popular singers has announced an extensive concert tour that will visit major cities across the country, thrilling fans nationwide.',
                'thumbnail' => 'https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?w=800&h=600&fit=crop',
                'category' => 'Entertainment',
                'is_featured' => false,
            ],
            [
                'title' => 'Traditional Myanmar Dance Troupe Performs at UNESCO Event',
                'description' => 'Cultural ambassadors showcase traditional arts at prestigious international gathering.',
                'content' => 'A renowned Myanmar traditional dance troupe has been invited to perform at a UNESCO cultural event, representing the country\'s rich artistic heritage.',
                'thumbnail' => 'https://images.unsplash.com/photo-1508700929628-666bc8bd84ea?w=800&h=600&fit=crop',
                'category' => 'Entertainment',
                'is_featured' => false,
            ],

            // Health
            [
                'title' => 'New Children\'s Hospital Opens in Yangon',
                'description' => 'Modern medical facility equipped with latest technology to serve young patients.',
                'content' => 'A state-of-the-art children\'s hospital has opened in Yangon, featuring advanced medical equipment and specialized pediatric care units.',
                'thumbnail' => 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=800&h=600&fit=crop',
                'category' => 'Health',
                'is_featured' => false,
            ],
            [
                'title' => 'Myanmar Launches National Health Insurance Program',
                'description' => 'Government initiative aims to provide affordable healthcare coverage for all citizens.',
                'content' => 'A comprehensive national health insurance program has been launched, making healthcare more accessible and affordable for Myanmar citizens.',
                'thumbnail' => 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?w=800&h=600&fit=crop',
                'category' => 'Health',
                'is_featured' => false,
            ],
            [
                'title' => 'Traditional Medicine Research Center Receives International Recognition',
                'description' => 'Myanmar\'s traditional healing practices gain scientific validation and global attention.',
                'content' => 'A research center dedicated to studying Myanmar\'s traditional medicine has received international recognition for its groundbreaking work in validating ancient healing practices.',
                'thumbnail' => 'https://images.unsplash.com/photo-1505751172876-fa1923c5c528?w=800&h=600&fit=crop',
                'category' => 'Health',
                'is_featured' => false,
            ],

            // Education
            [
                'title' => 'Myanmar Universities Partner with International Institutions',
                'description' => 'New academic collaborations open doors for student exchanges and research opportunities.',
                'content' => 'Leading Myanmar universities have signed partnership agreements with prestigious international institutions, creating new opportunities for students and researchers.',
                'thumbnail' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=800&h=600&fit=crop',
                'category' => 'Education',
                'is_featured' => false,
            ],
            [
                'title' => 'Digital Learning Platform Reaches One Million Myanmar Students',
                'description' => 'Online education initiative achieves major milestone in expanding access to quality education.',
                'content' => 'A digital learning platform has reached one million Myanmar students, providing access to quality educational content across the country.',
                'thumbnail' => 'https://images.unsplash.com/photo-1501504905252-473c47e087f8?w=800&h=600&fit=crop',
                'category' => 'Education',
                'is_featured' => false,
            ],
            [
                'title' => 'New STEM Education Centers Open in Rural Areas',
                'description' => 'Initiative brings science and technology education to underserved communities.',
                'content' => 'Several new STEM education centers have opened in rural areas, providing students with access to modern science and technology learning facilities.',
                'thumbnail' => 'https://images.unsplash.com/photo-1532094349884-543bc11b234d?w=800&h=600&fit=crop',
                'category' => 'Education',
                'is_featured' => false,
            ],
            [
                'title' => 'Myanmar Students Excel at International Science Olympiad',
                'description' => 'Young scientists bring home medals from prestigious global competition.',
                'content' => 'Myanmar students have won multiple medals at the International Science Olympiad, demonstrating the country\'s growing strength in STEM education.',
                'thumbnail' => 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=800&h=600&fit=crop',
                'category' => 'Education',
                'is_featured' => false,
            ],

            // Culture
            [
                'title' => 'Ancient Myanmar Temple Restoration Project Completed',
                'description' => 'Historic pagoda restored to former glory after years of careful conservation work.',
                'content' => 'A major restoration project has been completed on an ancient Myanmar temple, preserving this important cultural heritage site for future generations.',
                'thumbnail' => 'https://images.unsplash.com/photo-1563492065599-3520f775eeed?w=800&h=600&fit=crop',
                'category' => 'Culture',
                'is_featured' => true,
            ],
            [
                'title' => 'Myanmar Traditional Crafts Exhibition Opens in National Museum',
                'description' => 'Showcase of traditional artisanship celebrates Myanmar\'s rich cultural heritage.',
                'content' => 'A comprehensive exhibition of Myanmar traditional crafts has opened at the National Museum, featuring works from master artisans across the country.',
                'thumbnail' => 'https://images.unsplash.com/photo-1582555172866-f73bb12a2ab3?w=800&h=600&fit=crop',
                'category' => 'Culture',
                'is_featured' => false,
            ],
            [
                'title' => 'Thingyan Water Festival Attracts Record Number of Tourists',
                'description' => 'Myanmar\'s traditional New Year celebration draws visitors from around the world.',
                'content' => 'This year\'s Thingyan Water Festival attracted a record number of international tourists, showcasing Myanmar\'s vibrant cultural traditions to the world.',
                'thumbnail' => 'https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?w=800&h=600&fit=crop',
                'category' => 'Culture',
                'is_featured' => false,
            ],
            [
                'title' => 'Myanmar Language Preservation Initiative Launches Mobile App',
                'description' => 'New technology helps younger generation learn and preserve traditional languages.',
                'content' => 'A new mobile application has been launched to help preserve Myanmar\'s diverse linguistic heritage, making it easier for young people to learn traditional languages.',
                'thumbnail' => 'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?w=800&h=600&fit=crop',
                'category' => 'Culture',
                'is_featured' => false,
            ],
            [
                'title' => 'Traditional Myanmar Puppetry Art Form Gains UNESCO Recognition',
                'description' => 'Ancient performance art receives international heritage status.',
                'content' => 'Myanmar\'s traditional puppetry has been recognized by UNESCO as an Intangible Cultural Heritage, ensuring its preservation for future generations.',
                'thumbnail' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800&h=600&fit=crop',
                'category' => 'Culture',
                'is_featured' => false,
            ],
        ];

        foreach ($newsPosts as $postData) {
            $category = PostCategory::where('name', $postData['category'])->first();
            
            Post::firstOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($postData['title'])],
                [
                    'title' => $postData['title'],
                    'description' => $postData['description'],
                    'content' => $postData['content'],
                    'thumbnail' => $postData['thumbnail'],
                    'category_id' => $category?->id,
                    'user_id' => $admin->id,
                    'status' => 'published',
                    'is_featured' => $postData['is_featured'],
                    'published_at' => now()->subDays(rand(1, 30)),
                    'views' => rand(500, 50000),
                ]
            );
        }

        $this->command->info('PNP Myanmar News seeder completed successfully!');
        $this->command->info('Created 30 news posts with real images from Unsplash CDN');
    }
}
