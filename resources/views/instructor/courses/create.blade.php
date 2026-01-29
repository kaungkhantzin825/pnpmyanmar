@extends('layouts.lecturer')

@section('title', 'Create Course')
@section('page-title', 'Create New Course')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('instructor.dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item"><a href="{{ route('instructor.courses') }}">Courses</a></li>
<li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
<form action="{{ route('instructor.courses.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Course Information</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="title">Course Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" 
                               value="{{ old('title') }}" required placeholder="Enter course title">
                        @error('title')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="short_description">Short Description</label>
                        <textarea name="short_description" id="short_description" rows="2" class="form-control @error('short_description') is-invalid @enderror" 
                                  placeholder="Brief description for course cards">{{ old('short_description') }}</textarea>
                        @error('short_description')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Full Description <span class="text-danger">*</span></label>
                        <textarea name="description" id="description" rows="6" class="form-control @error('description') is-invalid @enderror" 
                                  required placeholder="Detailed course description">{{ old('description') }}</textarea>
                        @error('description')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>What You'll Learn</label>
                        <div id="what-you-learn-container">
                            <div class="input-group mb-2">
                                <input type="text" name="what_you_learn[]" class="form-control" placeholder="Learning outcome">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-success add-field" data-target="what-you-learn-container">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Requirements</label>
                        <div id="requirements-container">
                            <div class="input-group mb-2">
                                <input type="text" name="requirements[]" class="form-control" placeholder="Course requirement">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-success add-field" data-target="requirements-container">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Course Settings</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="category_id">Category <span class="text-danger">*</span></label>
                        <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="level">Level <span class="text-danger">*</span></label>
                        <select name="level" id="level" class="form-control @error('level') is-invalid @enderror" required>
                            <option value="beginner" {{ old('level') == 'beginner' ? 'selected' : '' }}>Beginner</option>
                            <option value="intermediate" {{ old('level') == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                            <option value="advanced" {{ old('level') == 'advanced' ? 'selected' : '' }}>Advanced</option>
                        </select>
                        @error('level')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="language">Language <span class="text-danger">*</span></label>
                        <input type="text" name="language" id="language" class="form-control @error('language') is-invalid @enderror" 
                               value="{{ old('language', 'English') }}" required>
                        @error('language')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="price">Price ($) <span class="text-danger">*</span></label>
                                <input type="number" name="price" id="price" class="form-control @error('price') is-invalid @enderror" 
                                       value="{{ old('price', 0) }}" min="0" step="0.01" required>
                                @error('price')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="discount_price">Discount Price</label>
                                <input type="number" name="discount_price" id="discount_price" class="form-control @error('discount_price') is-invalid @enderror" 
                                       value="{{ old('discount_price') }}" min="0" step="0.01">
                                @error('discount_price')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="thumbnail">Thumbnail <span class="text-danger">*</span></label>
                        <input type="file" name="thumbnail" id="thumbnail" class="form-control-file @error('thumbnail') is-invalid @enderror" required>
                        @error('thumbnail')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <small class="text-muted">Recommended: 1280x720px</small>
                    </div>

                    <div class="form-group">
                        <label for="preview_video">Preview Video URL</label>
                        <input type="url" name="preview_video" id="preview_video" class="form-control @error('preview_video') is-invalid @enderror" 
                               value="{{ old('preview_video') }}" placeholder="YouTube or Vimeo URL">
                        @error('preview_video')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-block">Create Course</button>
                    <a href="{{ route('instructor.courses') }}" class="btn btn-secondary btn-block">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.add-field').forEach(button => {
    button.addEventListener('click', function() {
        const container = document.getElementById(this.dataset.target);
        const inputGroup = container.querySelector('.input-group').cloneNode(true);
        inputGroup.querySelector('input').value = '';
        inputGroup.querySelector('button').classList.remove('btn-success', 'add-field');
        inputGroup.querySelector('button').classList.add('btn-danger', 'remove-field');
        inputGroup.querySelector('button').innerHTML = '<i class="fas fa-minus"></i>';
        inputGroup.querySelector('button').addEventListener('click', function() {
            this.closest('.input-group').remove();
        });
        container.appendChild(inputGroup);
    });
});
</script>
@endpush
