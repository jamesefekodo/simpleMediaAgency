<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = Auth::user();
        // 0 - admin, 1-staff , 2- customer

        if ($user) {
            // 2 members Account
            if ($user->account_type == 1 && getUserType() === 'customer') {
                $data = [
                    'user' => $user,
                ];
                return view('users.member.dashboard', compact('data'));
            }
            // 1 - Admin, 0 - root - 90 odu admin
            if (
                in_array((int) $user->account_type, [0, 1], true)
            ) {
                $data = [
                    'user' => $user,
                ];
                return view('users.admin.dashboard', compact('data'));
            }
        } else {
            return redirect()->route('accessDeniedLogout');
        }
    }
}
