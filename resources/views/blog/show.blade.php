@extends('layouts.blog')

@section('title', $post->title)
@section('description', $post->description)

@section('content')
<div class="w-full px-4 py-8">
    <!-- Main Content Full Width -->
    <div class="max-w-screen-2xl mx-auto">
            <article class="bg-white rounded-lg shadow-md overflow-hidden">
                <!-- Title -->
                <div class="p-6 border-b">
                    @if($post->title_thumbnail)
                        <!-- Display title as image -->
                        <div class="mb-4">
                            <img src="{{ Storage::url($post->title_thumbnail) }}" alt="{{ $post->title }}" class="w-full max-w-4xl mx-auto rounded-lg shadow-sm">
                        </div>
                    @else
                        <!-- Display title as text -->
                        <h1 class="text-3xl font-bold mb-4">{{ $post->title }}</h1>
                    @endif
                    <div class="flex items-center text-gray-600 text-sm space-x-4">
                        @if($post->category)
                            <span class="bg-blue-100 text-blue-600 px-3 py-1 rounded">{{ $post->category->name }}</span>
                        @endif
                        <span><i class="fas fa-eye mr-1"></i> {{ number_format($post->views) }} views</span>
                        <span><i class="fas fa-calendar mr-1"></i> {{ $post->published_at->format('M d, Y') }}</span>
                    </div>
                </div>

                <!-- Ad: Content Top -->
                @php
                    $contentTopAd = \App\Models\AdsenseSetting::getAdByPosition('content_top');
                @endphp
                @if($contentTopAd)
                    <div class="p-6 border-b bg-gray-50">
                        {!! $contentTopAd->ad_code !!}
                    </div>
                @endif

                <!-- Video Player -->
                @if($post->facebook_video_url)
                    <div class="">
                        @if($post->video_type === 'facebook')
                            <!-- Facebook embed - Natural aspect ratio -->
                            <div class="flex justify-center">
                                <iframe 
                                    src="https://www.facebook.com/plugins/video.php?href={{ urlencode($post->facebook_video_url) }}&show_text=false&width=500" 
                                    width="500" 
                                    height="800" 
                                    style="border:none;overflow:hidden;max-width:100%;" 
                                    scrolling="no" 
                                    frameborder="0" 
                                    allowfullscreen="true" 
                                    allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share">
                                </iframe>
                            </div>
                        @elseif($post->video_type === 'iframe')
                            <!-- Facebook Reel/Video iframe with ID -->
                            <div class="flex justify-center">
                                <iframe 
                                    src="https://www.facebook.com/plugins/video.php?href=https%3A%2F%2Fwww.facebook.com%2Freel%2F{{ $post->video_embed_code }}&show_text=false&width=560&height=315" 
                                    width="560" 
                                    height="315" 
                                    style="border:none;overflow:hidden;position:relative;max-width:100%;" 
                                    scrolling="no" 
                                    frameborder="0" 
                                    sandbox="allow-scripts allow-same-origin allow-presentation" 
                                    allowfullscreen="true" 
                                    allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share">
                                </iframe>
                            </div>
                        @else
                            <!-- Other video types with 16:9 aspect ratio -->
                            <div class="relative bg-black rounded-lg overflow-hidden mx-auto" style="max-width: 800px;">
                                <div style="padding-bottom: 56.25%; position: relative; height: 0;">
                                    @if($post->video_type === 'youtube')
                                        <!-- YouTube embed -->
                                        <iframe 
                                            src="https://www.youtube.com/embed/{{ $post->video_embed_code }}" 
                                            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"
                                            frameborder="0" 
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                            allowfullscreen>
                                        </iframe>
                                    @else
                                        <!-- Direct video file -->
                                        <video 
                                            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: contain;"
                                            controls
                                            preload="auto"
                                            poster="{{ $post->thumbnail ? Storage::url($post->thumbnail) : '' }}">
                                            <source src="{{ $post->video_file_url ?? $post->facebook_video_url }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    @endif
                                </div>
                            </div>
                        @endif
                        <div class="mt-4 text-sm text-gray-600 text-center">
                            <p>
                                <i class="fas fa-info-circle"></i> 
                                @if($post->video_type === 'youtube')
                                    <a href="https://www.youtube.com/watch?v={{ $post->video_embed_code }}" target="_blank" class="text-blue-600 hover:underline">Watch on YouTube</a>
                                @elseif($post->video_type === 'facebook')
                                    <a href="{{ $post->facebook_video_url }}" target="_blank" class="text-blue-600 hover:underline">Watch on Facebook</a>
                                @elseif($post->video_type === 'iframe')
                                    <a href="https://www.facebook.com/reel/{{ $post->video_embed_code }}" target="_blank" class="text-blue-600 hover:underline">Watch on Facebook</a>
                                @else
                                    Video Type: {{ ucfirst($post->video_type) }}
                                @endif
                            </p>
                        </div>
                    </div>
                @endif

                <!-- Ad: Content Middle -->
                @php
                    $contentMiddleAd = \App\Models\AdsenseSetting::getAdByPosition('content_middle');
                @endphp
                @if($contentMiddleAd)
                    <div class="p-6 border-t border-b bg-gray-50">
                        {!! $contentMiddleAd->ad_code !!}
                    </div>
                @endif

                <!-- Description -->
                @if($post->description)
                    <div class="p-6 border-t">
                        <h2 class="text-xl font-bold mb-3">Description</h2>
                        <p class="text-gray-700 leading-relaxed">{{ $post->description }}</p>
                    </div>
                @endif

                <!-- Content -->
                @if($post->content)
                    <div class="p-6 border-t prose max-w-none">
                        {!! nl2br(e($post->content)) !!}
                    </div>
                @endif

                <!-- Ad: Content Bottom -->
                @php
                    $contentBottomAd = \App\Models\AdsenseSetting::getAdByPosition('content_bottom');
                @endphp
                @if($contentBottomAd)
                    <div class="p-6 border-t bg-gray-50">
                        {!! $contentBottomAd->ad_code !!}
                    </div>
                @endif
            </article>

            <!-- Related Posts -->
            @if($relatedPosts->count() > 0)
                <div class="mt-8">
                    <h2 class="text-2xl font-bold mb-4">Related Videos</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach($relatedPosts as $related)
                            <a href="{{ route('blog.show', $related->slug) }}" class="block bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                                @if($related->thumbnail)
                                    <img src="{{ Storage::url($related->thumbnail) }}" alt="{{ $related->title }}" class="w-full h-32 object-cover">
                                @else
                                    <div class="w-full h-32 bg-gradient-to-r from-blue-400 to-indigo-500 flex items-center justify-center">
                                        <i class="fas fa-video text-white text-2xl"></i>
                                    </div>
                                @endif
                                <div class="p-3">
                                    <h3 class="font-bold text-sm line-clamp-2">{{ $related->title }}</h3>
                                    <div class="text-xs text-gray-500 mt-1">
                                        <i class="fas fa-eye mr-1"></i> {{ number_format($related->views) }}
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
    </div>
</div>
@endsection
