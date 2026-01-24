<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // ======================
    // HALAMAN PROFIL
    // ======================
    public function index()
    {
        return view('admin.profil', [
            'user' => Auth::guard('admin')->user()
        ]);
    }

    // ======================
    // UPDATE USERNAME
    // ======================
    public function updateUsername(Request $request)
    {
        $request->validate([
            'username' => 'required|min:4|unique:admins,username,' . Auth::guard('admin')->id(),
        ]);

        Auth::guard('admin')->user()->update([
            'username' => $request->username
        ]);

        return redirect()
            ->route('admin.profil')
            ->with('success', 'Username berhasil diperbarui');
    }

    // ======================
    // UPDATE PASSWORD
    // ======================
    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $admin = Auth::guard('admin')->user();

        if (!Hash::check($request->old_password, $admin->password)) {
            return back()->withErrors(['old_password' => 'Password lama salah']);
        }

        $admin->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()
            ->route('admin.profil')
            ->with('success', 'Password berhasil diperbarui');
    }

    // ======================
    // UPLOAD FOTO PROFIL
    // ======================
    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $admin = Auth::guard('admin')->user();

        // Hapus foto lama jika ada
        if ($admin->photo && Storage::disk('public')->exists($admin->photo)) {
            Storage::disk('public')->delete($admin->photo);
        }

        // Simpan foto baru
        $path = $request->file('photo')->store('admins', 'public');

        // Update DB
        $admin->update(['photo' => $path]);

        return redirect()
            ->route('admin.profil')
            ->with('success', 'Foto profil berhasil diperbarui');
    }

    // ======================
    // HAPUS FOTO PROFIL
    // ======================
    public function removePhoto()
    {
        $admin = Auth::guard('admin')->user();

        if ($admin->photo && Storage::disk('public')->exists($admin->photo)) {
            Storage::disk('public')->delete($admin->photo);
        }

        $admin->update(['photo' => null]);

        return redirect()
            ->route('admin.profil')
            ->with('success', 'Foto profil berhasil dihapus');
    }
}
