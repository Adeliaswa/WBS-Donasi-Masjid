<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ActivityController extends Controller
{
    /**
     * Menampilkan seluruh kegiatan untuk admin.
     */
    public function index()
    {
        $activities = Activity::latest('activity_date')
            ->paginate(10);

        return view('activities.index', compact('activities'));
    }

    /**
     * Menampilkan form tambah kegiatan.
     */
    public function create()
    {
        return view('activities.create');
    }

    /**
     * Menyimpan kegiatan baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'activity_date' => ['required', 'date'],
            'is_published' => ['required', 'boolean'],
        ]);

        Activity::create($validated);

        return redirect()
            ->route('activities.index')
            ->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail kegiatan.
     */
    public function show(Activity $activity)
    {
        return view('activities.show', compact('activity'));
    }

    /**
     * Menampilkan form edit kegiatan.
     */
    public function edit(Activity $activity)
    {
        return view('activities.edit', compact('activity'));
    }

    /**
     * Memperbarui kegiatan.
     */
    public function update(Request $request, Activity $activity)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'activity_date' => ['required', 'date'],
            'is_published' => ['required', 'boolean'],
        ]);

        $activity->update($validated);

        return redirect()
            ->route('activities.index')
            ->with('success', 'Kegiatan berhasil diperbarui.');
    }

    /**
     * Menghapus kegiatan.
     */
    public function destroy(Activity $activity)
    {
        $activity->delete();

        return redirect()
            ->route('activities.index')
            ->with('success', 'Kegiatan berhasil dihapus.');
    }
}