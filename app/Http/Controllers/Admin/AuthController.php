<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AuthController extends Controller
{
    // ======================
    // LOGIN
    // ======================
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/admin/dashboard');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah',
        ]);
    }

    // ======================
    // RESET PASSWORD (FORM)
    // ======================
    public function showResetForm()
    {
        return view('admin.forgot-password');
    }

    // ======================
    // RESET PASSWORD (PROSES)
    // ======================
    public function resetPassword(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        $admin = Admin::where('username', $request->username)->first();

        if (!$admin) {
            return back()->withErrors([
                'username' => 'Username tidak ditemukan',
            ]);
        }

        $admin->password = Hash::make($request->password);
        $admin->save();

        return redirect('/admin/login')
            ->with('success', 'Password berhasil diperbarui');
    }

    // ======================
    // LOGOUT
    // ======================
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }
}
