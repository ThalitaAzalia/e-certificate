<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        return view('admin.profil', [
            'user' => auth()->user()
        ]);
    }

    public function updateUsername(Request $request)
    {
        $request->validate([
            'username' => 'required|min:4|unique:users,username,' . auth()->id(),
        ]);

        auth()->user()->update([
            'username' => $request->username
        ]);

        return back()->with('success', 'Username berhasil diperbarui');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->old_password, auth()->user()->password)) {
            return back()->withErrors(['old_password' => 'Password lama salah']);
        }

        auth()->user()->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Password berhasil diperbarui');
    }

    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $user = auth()->user();

        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        $path = $request->file('photo')->store('admins', 'public');

        $user->update(['photo' => $path]);

        return response()->json([
            'url' => asset('storage/' . $path)
        ]);
    }

    public function removePhoto()
    {
        $user = auth()->user();

        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        $user->update(['photo' => null]);

        return response()->json(['status' => 'ok']);
    }
}
