@extends('layouts.admin')

@section('page-title', 'AdSense Ads')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Manage AdSense Ads</h3>
        <div class="card-tools">
            <a href="{{ route('admin.adsense.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add New Ad
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> <strong>Important:</strong> Place ads strategically to avoid invalid traffic. Recommended positions: sidebar, content_middle, and footer. Avoid too many ads on a single page.
        </div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Status</th>
                    <th>Order</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ads as $ad)
                    <tr>
                        <td><strong>{{ $ad->name }}</strong></td>
                        <td>
                            <span class="badge badge-secondary">{{ ucwords(str_replace('_', ' ', $ad->position)) }}</span>
                        </td>
                        <td>
                            @if($ad->is_active)
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-danger">Inactive</span>
                            @endif
                        </td>
                        <td>{{ $ad->order }}</td>
                        <td>
                            <a href="{{ route('admin.adsense.edit', $ad) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.adsense.destroy', $ad) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
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
                        <td colspan="5" class="text-center">No ads found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $ads->links() }}
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Ad Position Guide</h3>
    </div>
    <div class="card-body">
        <ul>
            <li><strong>Header:</strong> Top of every page (use sparingly)</li>
            <li><strong>Sidebar:</strong> Right sidebar on all pages (recommended)</li>
            <li><strong>Content Top:</strong> Before video on post pages</li>
            <li><strong>Content Middle:</strong> After video, before description (recommended)</li>
            <li><strong>Content Bottom:</strong> After all content</li>
            <li><strong>Footer:</strong> Bottom of every page</li>
        </ul>
        <div class="alert alert-warning mt-3">
            <strong>Best Practices:</strong>
            <ul class="mb-0">
                <li>Use 2-3 ads per page maximum</li>
                <li>Avoid placing ads too close to navigation or buttons</li>
                <li>Ensure ads don't interfere with user experience</li>
                <li>Test ad placements and monitor performance</li>
            </ul>
        </div>
    </div>
</div>
@endsection
