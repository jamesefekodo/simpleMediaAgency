<?php

use App\Models\BasicSystemSetting;
use Illuminate\Support\Facades\Auth;

if (!function_exists('getUserType')) {
    function getUserType(): string
    {
        // 0 - admin, 1 - staff, 2 - customer

        if (!Auth::check()) {
            return 'guest';
        }

        $user = Auth::user();

        if ($user) {
            switch ((int) $user->account_type) {
                case 0:
                    return 'admin';
                case 1:
                    return 'staff';
                case 2:
                    return 'customer';
                default:
                    return 'guest';
            }
        }

        return 'guest'; // Fallback to satisfy the : string return type
    }
}



if (!function_exists('basicSystemInfo')) {
    function basicSystemInfo()
    {
        return BasicSystemSetting::first();
    }
}

if (!function_exists('logo')) {
    function logo()
    {
        $defaultSettings = basicSystemInfo();

        if (
            $defaultSettings &&
            !empty($defaultSettings->association_logo) &&
            file_exists(public_path('system/images/' . $defaultSettings->logo))
        ) {
            return asset('system/images/' . $defaultSettings->logo);
        }

        return asset('system/images/transcend_logo.webp');
    }
}
