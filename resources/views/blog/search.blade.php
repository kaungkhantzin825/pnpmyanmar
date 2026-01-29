@extends('layouts.blog')

@section('title', 'Search Results - ' . $query)

@section('content')
<div class="w-full px-4 py-8">
    <div class="max-w-screen-2xl mx-auto">
        <div class="mb-6">
            <h1 class="text-3xl font-bold">Search Results for "{{ $query }}"</h1>
            <p class="text-gray-600 mt-2">Found {{ $posts->total() }} results</p>
        </div>

        <!-- Full Width Content -->
        <div>
        @if($posts->count() > 0)
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

            <div class="mt-8">
                {{ $posts->appends(['q' => $query])->links() }}
            </div>
        @else
            <div class="text-center py-12 bg-white rounded-lg shadow-md">
                <i class="fas fa-search text-gray-300 text-6xl mb-4"></i>
                <p class="text-gray-500 text-lg">No results found for "{{ $query }}"</p>
                <a href="{{ route('blog.index') }}" class="mt-4 inline-block text-blue-600 hover:underline">
                    Browse all videos
                </a>
            </div>
        @endif
    </div>
</div>
</div>
@endsection
