<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectUserController extends Controller
{
    /**
     * Handle the incoming request and route users based on role.
     */
    public function __invoke(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Match roles by role name
        $roleName = $user->role?->name ?? '';

        switch ($roleName) {
            case 'Admin':
                return redirect()->route('admin.dashboard');
            case 'Customer':
                return redirect()->route('customer.dashboard');
            case 'Vendor':
            case 'Mama Fua':
                return redirect()->route('vendor.dashboard');
            case 'Rider':
                return redirect()->route('rider.dashboard');
            default:
                Auth::logout();
                return redirect()->route('login')->withErrors(['email' => 'Unauthorized system role assignment.']);
        }
    }
}