<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdsenseSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'position',
        'ad_code',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public static function getAdByPosition($position)
    {
        return self::where('position', $position)
                   ->where('is_active', true)
                   ->orderBy('order')
                   ->first();
    }

    public static function getActiveAds()
    {
        return self::where('is_active', true)
                   ->orderBy('position')
                   ->orderBy('order')
                   ->get()
                   ->groupBy('position');
    }
}
