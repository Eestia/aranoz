<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function redirectAfterLogin()
    {
        $user = Auth::user();

        if ($user->hasRole('admin') || $user->hasRole('agent')) {
            return redirect()->route('admin.dashboard');
        }

        // sinon, utilisateur normal
        return redirect()->route('shop');
    }
}
