<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Webinar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WebinarController extends Controller
{
    /**
     * LIST + FILTER WEBINAR
     */
    public function index(Request $request)
    {
        $query = Webinar::query();

        // =====================
        // FILTER: SEARCH
        // =====================
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $request->search . '%');
            });
        }

        // =====================
        // FILTER: STATUS
        // =====================
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // =====================
        // SORTING
        // =====================
        switch ($request->sort) {
            case 'tanggal_terjauh':
                $query->orderBy('tanggal', 'asc');
                break;

            case 'terbaru':
                $query->orderBy('created_at', 'desc');
                break;

            case 'terlama':
                $query->orderBy('created_at', 'asc');
                break;

            default:
                // tanggal terdekat
                $query->orderBy('tanggal', 'desc');
                break;
        }

        $webinars = $query->paginate(5)->withQueryString();

        return view('admin.manajemen', compact('webinars'));
    }

    /**
     * STORE WEBINAR
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'         => 'required|string|max:255',
            'deskripsi'     => 'required|string',
            'tanggal'       => 'required|date',
            'waktu'         => 'nullable',
            'narasumber'    => 'nullable|string|max:255',
            'media'         => 'nullable|string|max:255',
            'status'        => 'required|in:draft,published',
            'poster'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'link_absensi'  => 'nullable|string|max:255',
            'link_detail'   => 'nullable|string|max:255',
        ]);

        // =====================
        // UPLOAD POSTER
        // =====================
        if ($request->hasFile('poster')) {
            $validated['poster'] = $request->file('poster')
                ->store('webinars', 'public');
        }

        Webinar::create($validated);

        return redirect()->back()->with('success', 'Webinar berhasil ditambahkan');
    }

    /**
     * UPDATE WEBINAR
     */
    public function update(Request $request, Webinar $webinar)
    {
        $validated = $request->validate([
            'judul'         => 'required|string|max:255',
            'deskripsi'     => 'required|string',
            'tanggal'       => 'required|date',
            'waktu'         => 'nullable',
            'narasumber'    => 'nullable|string|max:255',
            'media'         => 'nullable|string|max:255',
            'status'        => 'required|in:draft,published',
            'poster'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'link_absensi'  => 'nullable|string|max:255',
            'link_detail'   => 'nullable|string|max:255',
        ]);

        // =====================
        // UPDATE POSTER
        // =====================
        if ($request->hasFile('poster')) {

            // hapus poster lama
            if ($webinar->poster && Storage::disk('public')->exists($webinar->poster)) {
                Storage::disk('public')->delete($webinar->poster);
            }

            $validated['poster'] = $request->file('poster')
                ->store('webinars', 'public');
        }

        $webinar->update($validated);

        return redirect()->back()->with('success', 'Webinar berhasil diperbarui');
    }

    /**
     * DELETE WEBINAR
     */
    public function destroy(Webinar $webinar)
    {
        if ($webinar->poster && Storage::disk('public')->exists($webinar->poster)) {
            Storage::disk('public')->delete($webinar->poster);
        }

        $webinar->delete();

        return redirect()->back()->with('success', 'Webinar berhasil dihapus');
    }
}
