@extends('layouts.admin')

@section('page-title', 'Create Category')

@section('content')
<form action="{{ route('admin.blog.categories.store') }}" method="POST">
    @csrf
    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <label>Name *</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label>Icon (Font Awesome class)</label>
                <input type="text" name="icon" class="form-control" value="{{ old('icon') }}" placeholder="fas fa-video">
                <small class="form-text text-muted">Example: fas fa-video, fas fa-music, fas fa-gamepad</small>
            </div>

            <div class="form-group">
                <label>Order</label>
                <input type="number" name="order" class="form-control" value="{{ old('order', 0) }}">
            </div>

            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                    <label class="custom-control-label" for="is_active">Active</label>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Create Category
            </button>
            <a href="{{ route('admin.blog.categories.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </div>
</form>
@endsection
