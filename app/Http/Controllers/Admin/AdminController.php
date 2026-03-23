<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // ── Login Form ────────────────────────────────────────────
    public function loginForm()
    {
        if (Auth::check() && Auth::user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    // ── Login POST ────────────────────────────────────────────
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            if (!Auth::user()->is_admin) {
                Auth::logout();
                return back()->withErrors(['email' => 'Akun ini tidak memiliki akses admin.']);
            }
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // ── Logout ────────────────────────────────────────────────
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }

    // ── Dashboard ─────────────────────────────────────────────
    public function dashboard()
    {
        $totalProducts  = Product::count();
        $activeProducts = Product::where('is_active', true)->count();
        $categories     = Product::distinct('category')->count('category');
        $latestProduct  = Product::latest()->value('name') ?? '—';
        $recentProducts = Product::latest()->take(8)->get();

        return view('admin.dashboard', compact(
            'totalProducts', 'activeProducts', 'categories', 'latestProduct', 'recentProducts'
        ));
    }
}