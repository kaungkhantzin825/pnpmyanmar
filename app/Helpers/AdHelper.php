<?php

namespace App\Helpers;

use App\Models\AdsenseSetting;

class AdHelper
{
    /**
     * Get ad by position
     */
    public static function getAd($position)
    {
        return AdsenseSetting::getAdByPosition($position);
    }
    
    /**
     * Render ad by position
     */
    public static function renderAd($position, $wrapperClass = '')
    {
        $ad = self::getAd($position);
        
        if (!$ad) {
            return '';
        }
        
        $html = '<div class="adsense-wrapper ' . $wrapperClass . '" data-position="' . $position . '">';
        $html .= $ad->ad_code;
        $html .= '</div>';
        
        return $html;
    }
    
    /**
     * Check if ads should be displayed (avoid invalid traffic)
     */
    public static function shouldDisplayAds()
    {
        // Don't show ads to admin users
        if (auth()->check() && auth()->user()->role === 'admin') {
            return false;
        }
        
        // Add more checks as needed (e.g., bot detection, suspicious traffic)
        
        return true;
    }
}
