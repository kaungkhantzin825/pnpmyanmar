<!DOCTYPE html>
<html lang="en" class="m-0 p-0">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Video Blog')</title>
    <meta name="description" content="@yield('description', 'Share and watch amazing videos')">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        html, body {
            width: 100%;
            overflow-x: hidden;
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-50 m-0 p-0">
    <!-- Facebook SDK -->
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v24.0&appId=799616644805773"></script>
    <!-- Header Ad -->
    @php
        $headerAd = \App\Models\AdsenseSetting::getAdByPosition('header');
    @endphp
    @if($headerAd)
        <div class="bg-white border-b">
            <div class="w-full px-4 py-2">
                <div class="max-w-screen-2xl mx-auto">
                    {!! $headerAd->ad_code !!}
                </div>
            </div>
        </div>
    @endif

    <!-- Navigation -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="w-full px-4">
            <div class="max-w-screen-2xl mx-auto flex justify-between items-center py-4">
                <a href="{{ route('blog.index') }}" class="text-2xl font-bold text-blue-600">
                    <i class="fas fa-video"></i> VideoShare
                </a>
                
                <div class="flex items-center space-x-6">
                    <a href="{{ route('blog.index') }}" class="text-gray-700 hover:text-blue-600">Home</a>
                    
                    <!-- Categories Dropdown -->
                    <div class="relative group">
                        <button class="text-gray-700 hover:text-blue-600 flex items-center">
                            Categories <i class="fas fa-chevron-down ml-1 text-xs"></i>
                        </button>
                        <div class="absolute left-0 mt-2 w-48 bg-white rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                            @php
                                $navCategories = \App\Models\PostCategory::active()->withCount('posts')->get();
                            @endphp
                            @foreach($navCategories as $category)
                                <a href="{{ route('blog.category', $category->slug) }}" class="block px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 first:rounded-t-lg last:rounded-b-lg">
                                    @if($category->icon)
                                        <i class="{{ $category->icon }} mr-2"></i>
                                    @endif
                                    {{ $category->name }}
                                    <span class="text-xs text-gray-500">({{ $category->posts_count }})</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Search Form -->
                    <form action="{{ route('blog.search') }}" method="GET" class="hidden md:block">
                        <div class="relative">
                            <input type="text" name="q" placeholder="Search videos..." class="pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500" value="{{ request('q') }}">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                    </form>
                    
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-blue-600">Admin</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-700 hover:text-blue-600">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-12">
        @php
            $footerAd = \App\Models\AdsenseSetting::getAdByPosition('footer');
        @endphp
        @if($footerAd)
            <div class="border-b border-gray-700">
                <div class="w-full px-4 py-4">
                    <div class="max-w-screen-2xl mx-auto">
                        {!! $footerAd->ad_code !!}
                    </div>
                </div>
            </div>
        @endif
        
        <div class="w-full px-4 py-8">
            <div class="max-w-screen-2xl mx-auto text-center">
                <p>&copy; {{ date('Y') }} VideoShare. All rights reserved.</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
