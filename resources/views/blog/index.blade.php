@extends('layouts.blog')

@section('title', 'Home - Video Blog')

@push('styles')
<style>
    /* Hero Carousel Styles */
    .hero-carousel-container {
        position: relative;
        width: 100%;
        height: 500px;
        overflow: hidden;
        background: #000;
    }
    
    .hero-carousel-track {
        position: relative;
        width: 100%;
        height: 100%;
    }
    
    .hero-slide {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        transition: opacity 1s ease-in-out;
    }
    
    .hero-slide.active {
        opacity: 1;
        z-index: 1;
    }
    
    .hero-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .hero-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to bottom, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0.7) 100%);
    }
    
    .hero-content {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 3rem 0;
        color: white;
        z-index: 2;
    }
    
    .hero-badge {
        display: inline-block;
        background: #ef4444;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 0.25rem;
        font-size: 0.875rem;
        font-weight: bold;
        margin-bottom: 1rem;
    }
    
    .hero-title {
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 1rem;
        line-height: 1.2;
    }
    
    .hero-description {
        font-size: 1.125rem;
        margin-bottom: 1rem;
        opacity: 0.9;
        max-width: 600px;
    }
    
    .hero-meta {
        display: flex;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
        font-size: 0.875rem;
        opacity: 0.8;
    }
    
    .hero-btn {
        display: inline-block;
        background: #3b82f6;
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 0.5rem;
        font-weight: bold;
        text-decoration: none;
        transition: background 0.3s;
    }
    
    .hero-btn:hover {
        background: #2563eb;
    }
    
    .hero-nav-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(0, 0, 0, 0.5);
        color: white;
        border: none;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        cursor: pointer;
        z-index: 10;
        transition: background 0.3s;
        font-size: 1.25rem;
    }
    
    .hero-nav-btn:hover {
        background: rgba(0, 0, 0, 0.8);
    }
    
    .hero-prev {
        left: 1rem;
    }
    
    .hero-next {
        right: 1rem;
    }
    
    .hero-dots {
        position: absolute;
        bottom: 1rem;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 0.5rem;
        z-index: 10;
    }
    
    .hero-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.5);
        cursor: pointer;
        transition: background 0.3s;
    }
    
    .hero-dot.active {
        background: white;
    }
    
    @media (max-width: 768px) {
        .hero-carousel-container {
            height: 400px;
        }
        .hero-title {
            font-size: 1.5rem;
        }
        .hero-description {
            font-size: 0.875rem;
        }
        .hero-content {
            padding: 2rem 0;
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Image Carousel Slider -->
<div class="hero-carousel-container">
    <div class="hero-carousel-track" id="heroCarouselTrack">
        @foreach($featuredPosts as $index => $featured)
            <div class="hero-slide {{ $index === 0 ? 'active' : '' }}">
                @if($featured->thumbnail)
                    <img src="{{ Storage::url($featured->thumbnail) }}" alt="{{ $featured->title }}" class="hero-image">
                @else
                    <div class="hero-image hero-gradient"></div>
                @endif
                <div class="hero-overlay"></div>
                <div class="hero-content">
                    <div class="max-w-screen-2xl mx-auto px-4">
                        <span class="hero-badge">
                            <i class="fas fa-star"></i> FEATURED
                        </span>
                        <h1 class="hero-title">{{ $featured->title }}</h1>
                        <p class="hero-description">{{ $featured->description }}</p>
                        <div class="hero-meta">
                            <span><i class="fas fa-eye"></i> {{ number_format($featured->views) }} views</span>
                            @if($featured->category)
                                <span><i class="fas fa-folder"></i> {{ $featured->category->name }}</span>
                            @endif
                        </div>
                        <a href="{{ route('blog.show', $featured->slug) }}" class="hero-btn">
                            <i class="fas fa-play"></i> Watch Now
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    <!-- Navigation Arrows -->
    <button class="hero-nav-btn hero-prev" onclick="moveHeroSlide(-1)">
        <i class="fas fa-chevron-left"></i>
    </button>
    <button class="hero-nav-btn hero-next" onclick="moveHeroSlide(1)">
        <i class="fas fa-chevron-right"></i>
    </button>
    
    <!-- Dots Indicator -->
    <div class="hero-dots" id="heroDots">
        @foreach($featuredPosts as $index => $featured)
            <div class="hero-dot {{ $index === 0 ? 'active' : '' }}" onclick="goToHeroSlide({{ $index }})"></div>
        @endforeach
    </div>
</div>

<div class="w-full px-4 py-8">
    <!-- Main Content Full Width -->
    <div class="max-w-screen-2xl mx-auto">
            <!-- Featured Posts -->
            <!-- Featured Posts Carousel -->
            @if($featuredPosts->count() > 0)
                <div class="mb-8">
                    <h2 class="text-2xl font-bold mb-4">Featured Videos</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($featuredPosts as $featured)
                            <a href="{{ route('blog.show', $featured->slug) }}" class="block bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                                @if($featured->thumbnail)
                                    <img src="{{ Storage::url($featured->thumbnail) }}" alt="{{ $featured->title }}" class="w-full h-48 object-cover">
                                @else
                                    <div class="w-full h-48 bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center">
                                        <i class="fas fa-video text-white text-5xl"></i>
                                    </div>
                                @endif
                                <div class="p-4">
                                    <h3 class="font-bold text-lg mb-2 line-clamp-2">{{ $featured->title }}</h3>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-eye mr-1"></i> {{ number_format($featured->views) }}
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Ad: Content Top -->
            @php
                $contentTopAd = \App\Models\AdsenseSetting::getAdByPosition('content_top');
            @endphp
            @if($contentTopAd)
                <div class="mb-6 bg-white p-4 rounded-lg">
                    {!! $contentTopAd->ad_code !!}
                </div>
            @endif

            <!-- All Posts -->
            <h2 class="text-2xl font-bold mb-4">Latest Videos</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($posts as $post)
                    <a href="{{ route('blog.show', $post->slug) }}" class="block bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                        @if($post->thumbnail)
                            <img src="{{ Storage::url($post->thumbnail) }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gradient-to-r from-blue-400 to-indigo-500 flex items-center justify-center">
                                <i class="fas fa-video text-white text-4xl"></i>
                            </div>
                        @endif
                        <div class="p-4">
                            @if($post->category)
                                <span class="text-xs bg-blue-100 text-blue-600 px-2 py-1 rounded">{{ $post->category->name }}</span>
                            @endif
                            <h3 class="font-bold text-lg mt-2 mb-2 line-clamp-2">{{ $post->title }}</h3>
                            <p class="text-gray-600 text-sm line-clamp-2 mb-2">{{ $post->description }}</p>
                            <div class="flex items-center justify-between text-sm text-gray-500">
                                <span><i class="fas fa-eye mr-1"></i> {{ number_format($post->views) }}</span>
                                <span>{{ $post->published_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $posts->links() }}
            </div>
    </div>
</div>

@push('scripts')
<script>
    let currentHeroSlide = 0;
    const heroSlides = document.querySelectorAll('.hero-slide');
    const heroDots = document.querySelectorAll('.hero-dot');
    const totalHeroSlides = heroSlides.length;
    
    function showHeroSlide(index) {
        // Remove active class from all slides and dots
        heroSlides.forEach(slide => slide.classList.remove('active'));
        heroDots.forEach(dot => dot.classList.remove('active'));
        
        // Add active class to current slide and dot
        heroSlides[index].classList.add('active');
        heroDots[index].classList.add('active');
    }
    
    function moveHeroSlide(direction) {
        currentHeroSlide += direction;
        
        if (currentHeroSlide < 0) {
            currentHeroSlide = totalHeroSlides - 1;
        } else if (currentHeroSlide >= totalHeroSlides) {
            currentHeroSlide = 0;
        }
        
        showHeroSlide(currentHeroSlide);
    }
    
    function goToHeroSlide(index) {
        currentHeroSlide = index;
        showHeroSlide(currentHeroSlide);
    }
    
    // Auto-play hero carousel
    let heroAutoplay = setInterval(() => {
        moveHeroSlide(1);
    }, 5000);
    
    // Pause on hover
    document.querySelector('.hero-carousel-container').addEventListener('mouseenter', () => {
        clearInterval(heroAutoplay);
    });
    
    document.querySelector('.hero-carousel-container').addEventListener('mouseleave', () => {
        heroAutoplay = setInterval(() => {
            moveHeroSlide(1);
        }, 5000);
    });
</script>
@endpush
@endsection
