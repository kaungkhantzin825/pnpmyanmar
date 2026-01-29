@extends('layouts.admin')

@section('page-title', 'Edit Ad')

@section('content')
<form action="{{ route('admin.adsense.update', $adsense) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label>Ad Name *</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $adsense->name) }}" required>
                        @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label>Position *</label>
                        <select name="position" class="form-control @error('position') is-invalid @enderror" required>
                            <option value="">Select Position</option>
                            @foreach($positions as $key => $label)
                                <option value="{{ $key }}" {{ $adsense->position == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('position')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label>AdSense Code *</label>
                        <textarea name="ad_code" class="form-control @error('ad_code') is-invalid @enderror" rows="8" required>{{ old('ad_code', $adsense->ad_code) }}</textarea>
                        @error('ad_code')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label>Order</label>
                        <input type="number" name="order" class="form-control" value="{{ old('order', $adsense->order) }}">
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ $adsense->is_active ? 'checked' : '' }}>
                            <label class="custom-control-label" for="is_active">Active</label>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Ad
                    </button>
                    <a href="{{ route('admin.adsense.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
