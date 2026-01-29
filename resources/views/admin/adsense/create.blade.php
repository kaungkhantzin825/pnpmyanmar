@extends('layouts.admin')

@section('page-title', 'Add New Ad')

@section('content')
<form action="{{ route('admin.adsense.store') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label>Ad Name *</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                        @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label>Position *</label>
                        <select name="position" class="form-control @error('position') is-invalid @enderror" required>
                            <option value="">Select Position</option>
                            @foreach($positions as $key => $label)
                                <option value="{{ $key }}" {{ old('position') == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('position')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label>AdSense Code *</label>
                        <textarea name="ad_code" class="form-control @error('ad_code') is-invalid @enderror" rows="8" required>{{ old('ad_code') }}</textarea>
                        <small class="form-text text-muted">Paste your AdSense ad code here (including script tags)</small>
                        @error('ad_code')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label>Order</label>
                        <input type="number" name="order" class="form-control" value="{{ old('order', 0) }}">
                        <small class="form-text text-muted">Lower numbers appear first</small>
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
                        <i class="fas fa-save"></i> Save Ad
                    </button>
                    <a href="{{ route('admin.adsense.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tips</h3>
                </div>
                <div class="card-body">
                    <p><strong>How to get AdSense code:</strong></p>
                    <ol>
                        <li>Log in to Google AdSense</li>
                        <li>Go to Ads → By ad unit</li>
                        <li>Create or select an ad unit</li>
                        <li>Copy the ad code</li>
                        <li>Paste it here</li>
                    </ol>
                    <hr>
                    <p><strong>Avoid Invalid Traffic:</strong></p>
                    <ul>
                        <li>Don't place ads near clickable elements</li>
                        <li>Use natural ad placements</li>
                        <li>Don't encourage clicks</li>
                        <li>Monitor your traffic quality</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
