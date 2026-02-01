@extends('layouts.blog')

@section('title', $category->name . ' - Video Blog')

@section('content')
<div class="w-full px-4 py-8">
    <div class="max-w-screen-2xl mx-auto">
        <div class="mb-6">
            <h1 class="text-3xl font-bold">
                @if($category->icon)
                    <i class="{{ $category->icon }}"></i>
                @endif
                {{ $category->name }}
            </h1>
            @if($category->description)
                <p class="text-gray-600 mt-2">{{ $category->description }}</p>
            @endif
        </div>

        <!-- Full Width Content -->
        <div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($posts as $post)
                    <a href="{{ route('blog.show', $post->slug) }}" class="block bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                        @if($post->thumbnail)
                            <img src="{{ str_starts_with($post->thumbnail, 'http') ? $post->thumbnail : Storage::url($post->thumbnail) }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gradient-to-r from-blue-400 to-indigo-500 flex items-center justify-center">
                                <i class="fas fa-newspaper text-white text-4xl"></i>
                            </div>
                        @endif
                        <div class="p-4">
                            <h3 class="font-bold text-lg mb-2 line-clamp-2">{{ $post->title }}</h3>
                            <p class="text-gray-600 text-sm line-clamp-2">{{ $post->description }}</p>
                        </div>
                    </a>
                @empty
                    <div class="col-span-3 text-center py-12">
                        <i class="fas fa-newspaper text-gray-300 text-6xl mb-4"></i>
                        <p class="text-gray-500">No news found in this category</p>
                    </div>
                @endforelse
        </div>

        <div class="mt-8">
            {{ $posts->links() }}
        </div>
    </div>
    </div>
</div>
@endsection
