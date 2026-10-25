<?php

namespace App\Http\Controllers;

use App\Models\Beneficiary;
use App\Models\BeneficiaryCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BeneficiaryCategoryController extends Controller
{
    public function index()
    {
        $categories = BeneficiaryCategory::withCount('beneficiaries')
            ->orderBy('name')
            ->paginate(10);

        return view('beneficiary-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('beneficiary-categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:beneficiary_categories,name'],
            'description' => ['nullable', 'string'],
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = true;

        // Pastikan slug tetap unik jika nama berbeda menghasilkan slug sama.
        $baseSlug = $validated['slug'];
        $counter = 1;

        while (
            BeneficiaryCategory::where('slug', $validated['slug'])->exists()
        ) {
            $validated['slug'] = $baseSlug . '-' . $counter++;
        }

        BeneficiaryCategory::create($validated);

        return redirect()
            ->route('beneficiary-categories.index')
            ->with('success', 'Kategori penerima manfaat berhasil ditambahkan.');
    }

    public function show(BeneficiaryCategory $beneficiaryCategory)
    {
        $beneficiaryCategory->loadCount('beneficiaries');

        return view(
            'beneficiary-categories.show',
            compact('beneficiaryCategory')
        );
    }

    public function edit(BeneficiaryCategory $beneficiaryCategory)
    {
        return view(
            'beneficiary-categories.edit',
            compact('beneficiaryCategory')
        );
    }

    public function update(
        Request $request,
        BeneficiaryCategory $beneficiaryCategory
    ) {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('beneficiary_categories', 'name')
                    ->ignore($beneficiaryCategory->id),
            ],
            'description' => ['nullable', 'string'],
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $baseSlug = $validated['slug'];
        $counter = 1;

        while (
            BeneficiaryCategory::where('slug', $validated['slug'])
                ->where('id', '!=', $beneficiaryCategory->id)
                ->exists()
        ) {
            $validated['slug'] = $baseSlug . '-' . $counter++;
        }

        $beneficiaryCategory->update($validated);

        return redirect()
            ->route('beneficiary-categories.index')
            ->with('success', 'Kategori penerima manfaat berhasil diperbarui.');
    }

    public function destroy(BeneficiaryCategory $beneficiaryCategory)
    {
        $hasBeneficiaries = Beneficiary::withTrashed()
            ->where('category_id', $beneficiaryCategory->id)
            ->exists();

        if ($hasBeneficiaries) {
            return redirect()
                ->route('beneficiary-categories.index')
                ->with(
                    'error',
                    'Kategori sudah digunakan dan tidak dapat dihapus. Nonaktifkan kategori jika tidak ingin digunakan lagi.'
                );
        }

        $beneficiaryCategory->delete();

        return redirect()
            ->route('beneficiary-categories.index')
            ->with('success', 'Kategori penerima manfaat berhasil dihapus.');
    }

    public function toggleStatus(BeneficiaryCategory $beneficiaryCategory)
    {
        $beneficiaryCategory->update([
            'is_active' => ! $beneficiaryCategory->is_active,
        ]);

        return redirect()
            ->route('beneficiary-categories.index')
            ->with(
                'success',
                $beneficiaryCategory->is_active
                    ? 'Kategori berhasil diaktifkan.'
                    : 'Kategori berhasil dinonaktifkan.'
            );
    }
}