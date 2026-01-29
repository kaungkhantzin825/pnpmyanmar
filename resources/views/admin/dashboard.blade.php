@extends('layouts.admin')

@section('page-title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ \App\Models\Post::count() }}</h3>
                <p>Total Posts</p>
            </div>
            <div class="icon">
                <i class="fas fa-newspaper"></i>
            </div>
            <a href="{{ route('admin.blog.posts.index') }}" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ \App\Models\Post::where('status', 'published')->count() }}</h3>
                <p>Published Posts</p>
            </div>
            <div class="icon">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ \App\Models\PostCategory::count() }}</h3>
                <p>Categories</p>
            </div>
            <div class="icon">
                <i class="fas fa-folder"></i>
            </div>
            <a href="{{ route('admin.blog.categories.index') }}" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ \App\Models\AdsenseSetting::where('is_active', true)->count() }}</h3>
                <p>Active Ads</p>
            </div>
            <div class="icon">
                <i class="fas fa-ad"></i>
            </div>
            <a href="{{ route('admin.adsense.index') }}" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Recent Posts</h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Views</th>
                            <th>Published</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(\App\Models\Post::latest()->take(10)->get() as $post)
                            <tr>
                                <td>{{ $post->title }}</td>
                                <td>
                                    @if($post->status === 'published')
                                        <span class="badge badge-success">Published</span>
                                    @else
                                        <span class="badge badge-secondary">{{ ucfirst($post->status) }}</span>
                                    @endif
                                </td>
                                <td>{{ number_format($post->views) }}</td>
                                <td>{{ $post->published_at?->format('M d, Y') ?? 'N/A' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
