<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdsenseSetting;
use Illuminate\Http\Request;

class AdsenseAdminController extends Controller
{
    public function index()
    {
        $ads = AdsenseSetting::orderBy('position')->orderBy('order')->paginate(20);
        return view('admin.adsense.index', compact('ads'));
    }

    public function create()
    {
        $positions = [
            'header' => 'Header (Top of page)',
            'sidebar' => 'Sidebar',
            'content_top' => 'Content Top (Before video)',
            'content_middle' => 'Content Middle (After video)',
            'content_bottom' => 'Content Bottom (After description)',
            'footer' => 'Footer',
        ];
        
        return view('admin.adsense.create', compact('positions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string',
            'ad_code' => 'required|string',
            'is_active' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        AdsenseSetting::create($validated);

        return redirect()->route('admin.adsense.index')
            ->with('success', 'Ad created successfully!');
    }

    public function edit(AdsenseSetting $adsense)
    {
        $positions = [
            'header' => 'Header (Top of page)',
            'sidebar' => 'Sidebar',
            'content_top' => 'Content Top (Before video)',
            'content_middle' => 'Content Middle (After video)',
            'content_bottom' => 'Content Bottom (After description)',
            'footer' => 'Footer',
        ];
        
        return view('admin.adsense.edit', compact('adsense', 'positions'));
    }

    public function update(Request $request, AdsenseSetting $adsense)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string',
            'ad_code' => 'required|string',
            'is_active' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        $adsense->update($validated);

        return redirect()->route('admin.adsense.index')
            ->with('success', 'Ad updated successfully!');
    }

    public function destroy(AdsenseSetting $adsense)
    {
        $adsense->delete();

        return redirect()->route('admin.adsense.index')
            ->with('success', 'Ad deleted successfully!');
    }
}
