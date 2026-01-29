@extends('layouts.admin')

@section('page-title', 'Create Post')

@section('content')
<form action="{{ route('admin.blog.posts.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label>Title *</label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                        @error('title')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label>Video Type *</label>
                        <select name="video_type" id="videoType" class="form-control @error('video_type') is-invalid @enderror" onchange="toggleVideoFields()">
                            <option value="facebook" {{ old('video_type') === 'facebook' ? 'selected' : '' }}>Facebook Video URL</option>
                            <option value="youtube" {{ old('video_type') === 'youtube' ? 'selected' : '' }}>YouTube Video URL</option>
                            <option value="iframe" {{ old('video_type') === 'iframe' ? 'selected' : '' }}>Facebook Reel ID (iframe)</option>
                            <option value="direct" {{ old('video_type') === 'direct' ? 'selected' : '' }}>Direct Video URL</option>
                        </select>
                        @error('video_type')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group" id="videoUrlField">
                        <label id="videoUrlLabel">Facebook Video URL *</label>
                        <input type="text" name="facebook_video_url" id="videoUrl" class="form-control @error('facebook_video_url') is-invalid @enderror" value="{{ old('facebook_video_url') }}" placeholder="https://www.facebook.com/watch?v=...">
                        <small class="form-text text-muted" id="videoUrlHelp">
                            Paste the Facebook video URL (e.g., https://www.facebook.com/watch?v=123456789)
                        </small>
                        @error('facebook_video_url')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group" id="iframeField" style="display: none;">
                        <label>Facebook Reel/Video ID *</label>
                        <input type="text" name="video_embed_code" id="iframeCode" class="form-control" placeholder="1944066969543322" value="{{ old('video_embed_code') }}">
                        <small class="form-text text-muted">Enter only the Facebook Reel/Video ID number (e.g., 1944066969543322)</small>
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description') }}</textarea>
                        @error('description')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label>Content</label>
                        <textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="6">{{ old('content') }}</textarea>
                        @error('content')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Publish</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="draft">Draft</option>
                            <option value="published" selected>Published</option>
                            <option value="archived">Archived</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Published Date</label>
                        <input type="datetime-local" name="published_at" class="form-control" value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}">
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="is_featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                            <label class="custom-control-label" for="is_featured">Featured Post</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Category</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <select name="category_id" class="form-control">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Title Image Generator</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <div class="custom-control custom-checkbox mb-3">
                            <input type="checkbox" class="custom-control-input" id="auto_generate_thumbnail" name="auto_generate_thumbnail" value="1" {{ old('auto_generate_thumbnail') ? 'checked' : '' }} onchange="toggleThumbnailUpload()">
                            <label class="custom-control-label" for="auto_generate_thumbnail">
                                <strong>Generate Title Image</strong>
                            </label>
                            <small class="form-text text-muted">Convert title and description text into an image that will be displayed instead of plain text</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Video Thumbnail</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <input type="file" name="thumbnail" class="form-control-file" accept="image/*">
                        <small class="form-text text-muted">Optional thumbnail for video preview. Max 2MB</small>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-block">
                <i class="fas fa-save"></i> Create Post
            </button>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
function toggleVideoFields() {
    const videoType = document.getElementById('videoType').value;
    const videoUrlField = document.getElementById('videoUrlField');
    const iframeField = document.getElementById('iframeField');
    const videoUrlLabel = document.getElementById('videoUrlLabel');
    const videoUrlHelp = document.getElementById('videoUrlHelp');
    const videoUrl = document.getElementById('videoUrl');
    
    // Hide all fields first
    videoUrlField.style.display = 'none';
    iframeField.style.display = 'none';
    
    // Show appropriate field based on type
    if (videoType === 'iframe') {
        iframeField.style.display = 'block';
    } else {
        videoUrlField.style.display = 'block';
        
        // Update labels and placeholders
        if (videoType === 'facebook') {
            videoUrlLabel.textContent = 'Facebook Video URL *';
            videoUrl.placeholder = 'https://www.facebook.com/watch?v=...';
            videoUrlHelp.textContent = 'Paste the Facebook video URL';
        } else if (videoType === 'youtube') {
            videoUrlLabel.textContent = 'YouTube Video URL *';
            videoUrl.placeholder = 'https://www.youtube.com/watch?v=...';
            videoUrlHelp.textContent = 'Paste the YouTube video URL';
        } else if (videoType === 'direct') {
            videoUrlLabel.textContent = 'Direct Video URL *';
            videoUrl.placeholder = 'https://example.com/video.mp4';
            videoUrlHelp.textContent = 'Paste the direct video file URL';
        }
    }
}

function toggleThumbnailUpload() {
    const autoGenerate = document.getElementById('auto_generate_thumbnail').checked;
    // No need to disable anything - they are separate features now
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleVideoFields();
});
</script>
@endpush
