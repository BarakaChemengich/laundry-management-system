<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectUserController extends Controller
{
    /**
     * Handle the incoming request and route users based on role_id.
     */
    public function __invoke(Request $request)
    {
        $user = Auth::user();

        // Match roles explicitly based on the lookup table IDs
        switch ($user->role_id) {
            Case 1: // Admin
                Return redirect()->route('admin.dashboard');
            Case 2: // Customer
                Return redirect()->route('customer.dashboard');
            Case 3: // Vendor (Mama Fua)
                Return redirect()->route('vendor.dashboard');
            Case 4: // Rider
                Return redirect()->route('rider.dashboard');
            Default:
                Auth::logout();
                Return redirect()->route('login')->withErrors(['email' => 'Unauthorized system role assignment.']);
        }
    }
}