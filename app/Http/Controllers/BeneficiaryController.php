<?php

namespace App\Http\Controllers;

use App\Models\Beneficiary;
use App\Models\BeneficiaryCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BeneficiaryController extends Controller
{
    public function index(Request $request)
    {
        $query = Beneficiary::with('beneficiaryCategory');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'ilike', "%{$search}%")
                    ->orWhere('nik', 'ilike', "%{$search}%")
                    ->orWhere('address', 'ilike', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Daftar penerima manfaat dengan pagination
        $beneficiaries = $query
            ->orderByDesc('registered_at')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        // Kategori aktif untuk filter
        // Kategori "Lainnya" selalu berada paling bawah
        $categories = BeneficiaryCategory::where('is_active', true)
            ->orderByRaw(
                "CASE WHEN LOWER(name) = 'lainnya' THEN 1 ELSE 0 END"
            )
            ->orderBy('name')
            ->get();

        // Ringkasan seluruh data penerima manfaat
        // Tidak mengikuti filter pencarian dan pagination
        $summary = [
            'total' => Beneficiary::count(),

            'active' => Beneficiary::where('status', 'Aktif')
                ->count(),

            'new_this_month' => Beneficiary::whereBetween(
                'registered_at',
                [
                    now()->startOfMonth()->toDateString(),
                    now()->endOfMonth()->toDateString(),
                ]
            )->count(),

            'inactive' => Beneficiary::where('status', 'Tidak Aktif')
                ->count(),
        ];

        return view('beneficiaries.index', compact(
            'beneficiaries',
            'categories',
            'summary'
        ));
    }

    public function create()
    {
        // Kategori aktif dengan "Lainnya" di urutan terakhir
        $categories = BeneficiaryCategory::where('is_active', true)
            ->orderByRaw(
                "CASE WHEN LOWER(name) = 'lainnya' THEN 1 ELSE 0 END"
            )
            ->orderBy('name')
            ->get();

        return view('beneficiaries.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],

            'nik' => [
                'required',
                'string',
                'max:32',
                'unique:beneficiaries,nik',
            ],

            'address' => ['required', 'string'],
            'contact' => ['nullable', 'string', 'max:255'],

            'category_id' => [
                'required',
                'integer',
                Rule::exists('beneficiary_categories', 'id')
                    ->where('is_active', true),
            ],

            'other_category' => ['nullable', 'string', 'max:255'],
            'condition' => ['nullable', 'string'],
            'status' => ['required', Rule::in(['Aktif', 'Tidak Aktif'])],
            'notes' => ['nullable', 'string'],
        ]);

        $category = BeneficiaryCategory::findOrFail(
            $validated['category_id']
        );

        if (strtolower($category->name) === 'lainnya') {
            $request->validate([
                'other_category' => [
                    'required',
                    'string',
                    'max:255',
                ],
            ]);
        } else {
            $validated['other_category'] = null;
        }

        $validated['registered_at'] = now()->toDateString();

        unset($validated['category']);

        Beneficiary::create($validated);

        return redirect()
            ->route('beneficiaries.index')
            ->with(
                'success',
                'Data penerima manfaat berhasil ditambahkan.'
            );
    }

    public function show(Beneficiary $beneficiary)
    {
        $beneficiary->load('beneficiaryCategory');

        return view('beneficiaries.show', compact('beneficiary'));
    }

    public function edit(Beneficiary $beneficiary)
    {
        // Tampilkan kategori aktif dan kategori milik data saat ini.
        // "Lainnya" tetap berada di urutan terakhir.
        $categories = BeneficiaryCategory::where('is_active', true)
            ->orWhere('id', $beneficiary->category_id)
            ->orderByRaw(
                "CASE WHEN LOWER(name) = 'lainnya' THEN 1 ELSE 0 END"
            )
            ->orderBy('name')
            ->get();

        return view('beneficiaries.edit', compact(
            'beneficiary',
            'categories'
        ));
    }

    public function update(Request $request, Beneficiary $beneficiary)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],

            'nik' => [
                'required',
                'string',
                Rule::unique('beneficiaries', 'nik')
                    ->ignore($beneficiary->id),
            ],

            'address' => ['required', 'string'],
            'contact' => ['nullable', 'string', 'max:255'],

            'category_id' => [
                'required',
                'integer',
                Rule::exists('beneficiary_categories', 'id')
                    ->where(function ($query) use ($beneficiary) {
                        $query->where('is_active', true)
                            ->orWhere(
                                'id',
                                $beneficiary->category_id
                            );
                    }),
            ],

            'other_category' => ['nullable', 'string', 'max:255'],
            'condition' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in(['Aktif', 'Tidak Aktif'])],
            'notes' => ['nullable', 'string'],
        ]);

        $category = BeneficiaryCategory::findOrFail(
            $validated['category_id']
        );

        if (strtolower($category->name) === 'lainnya') {
            $request->validate([
                'other_category' => [
                    'required',
                    'string',
                    'max:255',
                ],
            ]);
        } else {
            $validated['other_category'] = null;
        }

        unset($validated['category']);

        $beneficiary->update($validated);

        return redirect()
            ->route('beneficiaries.show', $beneficiary)
            ->with(
                'success',
                'Data penerima manfaat berhasil diperbarui.'
            );
    }

    public function destroy(Beneficiary $beneficiary)
    {
        $beneficiary->delete();

        return redirect()
            ->route('beneficiaries.index')
            ->with(
                'success',
                'Data penerima manfaat berhasil dihapus.'
            );
    }
}
