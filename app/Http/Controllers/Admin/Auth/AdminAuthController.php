<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\NxUser;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.auth.login');
    }
    
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        // Find user in nx_users table
        $user = NxUser::where('email', $request->email)->first();
        
        if (!$user) {
            return back()->with('error', 'No account found with this email.');
        }
        
        // Check if user is admin
        if ($user->role !== 'admin') {
            return back()->with('error', 'You do not have admin access.');
        }
        
        // Check if user is active
        if ($user->status !== 'active') {
            return back()->with('error', 'Your account is inactive. Please contact administrator.');
        }
        
        // Verify password
        if (!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Invalid password.');
        }
        
        // Login the user
        Auth::login($user, $request->remember);
        $request->session()->regenerate();
        
        // Update last login
        $user->last_login_at = now();
        $user->last_login_ip = $request->ip();
        $user->save();
        
        return redirect()->route('admin.dashboard');
    }
    
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}