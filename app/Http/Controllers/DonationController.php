<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\DonationCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class DonationController extends Controller
{
    /**
     * Menampilkan daftar donasi dengan fitur pencarian dan filter.
     */
    public function index(Request $request)
    {
        $query = Donation::query();

        // Filter pencarian berdasarkan nama donatur.
        if ($request->filled('search')) {
            $search = trim($request->input('search'));

            $query->where(function ($q) use ($search) {
                $q->where('donor_name', 'ilike', '%' . $search . '%');
            });
        }

        // Filter berdasarkan kategori donasi.
        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        // Filter berdasarkan status verifikasi.
        if ($request->filled('verification_status')) {
            $query->where(
                'verification_status',
                $request->input('verification_status')
            );
        }

        // Urutkan dan tampilkan 10 data per halaman.
        $donations = $query
            ->latest('donation_date')
            ->paginate(10)
            ->withQueryString();

        // Ambil kategori aktif untuk pilihan filter.
        $categories = DonationCategory::where('is_active', true)
            ->orderBy('name')
            ->pluck('name');

        return view('donations.index', compact(
            'donations',
            'categories'
        ));
    }

    /**
     * Menampilkan form tambah donasi beserta kategori aktif.
     */
    public function create()
    {
        $categories = DonationCategory::where('is_active', true)
            ->orderBy('name')
            ->pluck('name');

        return view('donations.create', compact('categories'));
    }

    /**
     * Menyimpan donasi dan kategori baru jika diperlukan.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'donor_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'donation_date' => [
                'required',
                'date',
            ],

            'amount' => [
                'required',
                'numeric',
                'gt:0',
            ],

            'channel' => [
                'required',
                'string',
                'max:255',
            ],

            'payment_method' => [
                'required',
                'string',
                'max:255',
            ],

            'category' => [
                'required',
                'string',
                'max:255',
            ],

            'new_category' => [
                'nullable',
                'required_if:category,Lainnya',
                'string',
                'max:255',
            ],

            'notes' => [
                'nullable',
                'string',
            ],

            'verification_status' => [
                'sometimes',
                'required',
                Rule::in(['pending', 'verified', 'rejected']),
            ],

            'proof_path' => [
                'nullable',
                'string',
                'max:255',
            ],
        ]);

        // Status default jika tidak dikirim dari form.
        $validated['verification_status'] =
            $validated['verification_status'] ?? 'pending';

        // Nama donatur boleh kosong.
        if (
            !isset($validated['donor_name']) ||
            trim($validated['donor_name']) === ''
        ) {
            $validated['donor_name'] = null;
        }

        // Simpan kategori baru jika admin memilih Lainnya.
        if ($validated['category'] === 'Lainnya') {
            $newCategoryName = trim(
                $validated['new_category'] ?? ''
            );

            if ($newCategoryName === '') {
                return back()
                    ->withErrors([
                        'new_category' => 'Nama kategori baru wajib diisi.',
                    ])
                    ->withInput();
            }

            $category = DonationCategory::whereRaw(
                'LOWER(name) = ?',
                [mb_strtolower($newCategoryName)]
            )->first();

            if (!$category) {
                $category = DonationCategory::create([
                    'name' => $newCategoryName,
                    'slug' => $this->generateUniqueCategorySlug(
                        $newCategoryName
                    ),
                    'is_active' => true,
                ]);
            } elseif (!$category->is_active) {
                $category->update(['is_active' => true]);
            }

            $validated['category'] = $category->name;
        }

        // Jangan masukkan field khusus form ke tabel donations.
        unset($validated['new_category']);

        // Simpan data donasi.
        Donation::create($validated);

        return redirect()
            ->route('donations.index')
            ->with('success', 'Data donasi berhasil disimpan.');
    }

    /**
     * Menampilkan detail donasi.
     */
    public function show(Donation $donation)
    {
        return view('donations.show', compact('donation'));
    }

    /**
     * Menampilkan form edit donasi.
     */
    public function edit(Donation $donation)
    {
        $categories = DonationCategory::where('is_active', true)
            ->orderBy('name')
            ->pluck('name');

        return view('donations.edit', compact(
            'donation',
            'categories'
        ));
    }

    /**
     * Memperbarui data donasi.
     */
    public function update(Request $request, Donation $donation)
    {
        $validated = $request->validate([
            'donor_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'donation_date' => [
                'required',
                'date',
            ],

            'amount' => [
                'required',
                'numeric',
                'gt:0',
            ],

            'channel' => [
                'required',
                'string',
                'max:255',
            ],

            'payment_method' => [
                'required',
                'string',
                'max:255',
            ],

            'category' => [
                'required',
                'string',
                'max:255',
            ],

            'notes' => [
                'nullable',
                'string',
            ],

            'verification_status' => [
                'required',
                Rule::in(['pending', 'verified', 'rejected']),
            ],

            'proof_path' => [
                'nullable',
                'string',
                'max:255',
            ],
        ]);

        // Nama donatur boleh dikosongkan.
        if (
            !isset($validated['donor_name']) ||
            trim($validated['donor_name']) === ''
        ) {
            $validated['donor_name'] = null;
        }

        // Perbarui data tanpa menghapus catatan donasi lain.
        $donation->update($validated);

        return redirect()
            ->route('donations.index')
            ->with('success', 'Data donasi berhasil diperbarui.');
    }

    /**
     * Menghapus data donasi.
     */
    public function destroy(Donation $donation)
    {
        $donation->delete();

        return redirect()
            ->route('donations.index')
            ->with('success', 'Data donasi berhasil dihapus.');
    }

    /**
     * Membuat slug kategori yang unik.
     */
    private function generateUniqueCategorySlug(string $name): string
    {
        $baseSlug = Str::slug($name);

        if ($baseSlug === '') {
            $baseSlug = 'kategori';
        }

        $slug = $baseSlug;
        $counter = 1;

        while (DonationCategory::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}