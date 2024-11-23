<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        if (Auth::attempt($credentials)) {
            // Authentication successful, regenerate session to prevent fixation
            $request->session()->regenerate();
    
            $user = Auth::user();
    
            // Redirect based on role
            if ($user->role_id == 1) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role_id == 2) {
                return redirect()->route('vendor.dashboard');
            } elseif ($user->role_id == 3) {
                return redirect()->route('user.dashboard');
            }
    
            return redirect('/');
        }
    
        // If authentication fails
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
    

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
