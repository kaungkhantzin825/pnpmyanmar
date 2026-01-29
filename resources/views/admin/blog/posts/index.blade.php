@extends('layouts.admin')

@section('page-title', 'All Posts')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Posts</h3>
        <div class="card-tools">
            <a href="{{ route('admin.blog.posts.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add New Post
            </a>
        </div>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Views</th>
                    <th>Published</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($posts as $post)
                    <tr>
                        <td>
                            <strong>{{ $post->title }}</strong>
                            @if($post->is_featured)
                                <span class="badge badge-warning">Featured</span>
                            @endif
                        </td>
                        <td>{{ $post->category->name ?? 'N/A' }}</td>
                        <td>
                            @if($post->status === 'published')
                                <span class="badge badge-success">Published</span>
                            @elseif($post->status === 'draft')
                                <span class="badge badge-secondary">Draft</span>
                            @else
                                <span class="badge badge-dark">Archived</span>
                            @endif
                        </td>
                        <td>{{ number_format($post->views) }}</td>
                        <td>{{ $post->published_at ? $post->published_at->format('M d, Y') : 'N/A' }}</td>
                        <td>
                            <a href="{{ route('blog.show', $post->slug) }}" class="btn btn-info btn-sm" target="_blank">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.blog.posts.edit', $post) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.blog.posts.destroy', $post) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No posts found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $posts->links() }}
    </div>
</div>
@endsection
