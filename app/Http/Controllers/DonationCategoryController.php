<?php

namespace App\Http\Controllers;

use App\Models\DonationCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DonationCategoryController extends Controller
{
    /**
     * Menyimpan kategori baru dari form donasi.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:donation_categories,name',
            ],
            'description' => [
                'nullable',
                'string',
            ],
        ]);

        $category = DonationCategory::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'is_active' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kategori donasi berhasil ditambahkan.',
            'category' => [
                'id' => $category->id,
                'name' => $category->name,
            ],
        ], 201);
    }
}