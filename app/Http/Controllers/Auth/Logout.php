<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Logout extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        
        // Invalidate session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

           return redirect('/')->with('success', 'you are logged out!');
    }
}
