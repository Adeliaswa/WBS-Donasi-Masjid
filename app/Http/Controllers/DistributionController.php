<?php

namespace App\Http\Controllers;

use App\Models\Beneficiary;
use App\Models\Donation;
use App\Models\Distribution;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DistributionController extends Controller
{
    /**
     * Menampilkan daftar penyaluran bantuan.
     */
    public function index(Request $request)
    {
        $query = Distribution::with(['beneficiary', 'donation']);

        // ==============================================
        // PENCARIAN NAMA PENERIMA ATAU JENIS BANTUAN
        // ==============================================

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('assistance_type', 'ILIKE', "%{$search}%")
                    ->orWhereHas('beneficiary', function ($b) use ($search) {
                        $b->where('name', 'ILIKE', "%{$search}%");
                    });
            });
        }

        // ==============================================
        // FILTER JENIS BANTUAN
        // ==============================================

        if ($request->filled('assistance_type')) {
            $assistanceType = trim($request->assistance_type);

            $query->where(
                'assistance_type',
                'ILIKE',
                "%{$assistanceType}%"
            );
        }

        // ==============================================
        // FILTER STATUS
        // ==============================================

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // ==============================================
        // FILTER PERIODE
        // ==============================================

        $startDate = null;
        $endDate = null;

        switch ($request->input('period')) {
            case 'this_month':
                $startDate = now()->startOfMonth()->toDateString();
                $endDate = now()->endOfMonth()->toDateString();
                break;

            case 'last_month':
                $lastMonth = now()->subMonthNoOverflow();

                $startDate = $lastMonth->copy()
                    ->startOfMonth()
                    ->toDateString();

                $endDate = $lastMonth->copy()
                    ->endOfMonth()
                    ->toDateString();
                break;

            case 'this_year':
                $startDate = now()->startOfYear()->toDateString();
                $endDate = now()->endOfYear()->toDateString();
                break;
        }

        // Terapkan filter periode
        if ($startDate && $endDate) {
            $query->whereDate('distribution_date', '>=', $startDate)
                ->whereDate('distribution_date', '<=', $endDate);
        }

        // ==============================================
        // FILTER RENTANG TANGGAL MANUAL
        // ==============================================

        if ($request->filled('start_date')) {
            $query->whereDate(
                'distribution_date',
                '>=',
                $request->start_date
            );
        }

        if ($request->filled('end_date')) {
            $query->whereDate(
                'distribution_date',
                '<=',
                $request->end_date
            );
        }

        // ==============================================
        // HASIL DATA DAN PAGINATION
        // ==============================================

        $distributions = $query
            ->orderByDesc('distribution_date')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        // ==============================================
        // RINGKASAN SELURUH DATA
        // TIDAK MENGIKUTI FILTER PENCARIAN
        // ==============================================

        $summary = [
            'total' => Distribution::count(),

            'this_month' => Distribution::whereYear(
                'distribution_date',
                now()->year
            )->whereMonth(
                'distribution_date',
                now()->month
            )->count(),

            'total_amount' => Distribution::sum('amount'),
        ];

        // ==============================================
        // DATA PENERIMA DAN DONASI UNTUK FORM
        // ==============================================

        $beneficiaries = Beneficiary::where('status', 'Aktif')
            ->orderBy('name')
            ->get();

        $donations = Donation::orderByDesc('donation_date')->get();

        return view('distributions.index', compact(
            'distributions',
            'summary',
            'beneficiaries',
            'donations'
        ));
    }

    /**
     * Menampilkan form tambah penyaluran.
     */
    public function create()
    {
        $beneficiaries = Beneficiary::where('status', 'Aktif')
            ->orderBy('name')
            ->get();

        $donations = Donation::orderByDesc('donation_date')->get();

        return view('distributions.create', compact(
            'beneficiaries',
            'donations'
        ));
    }

    /**
     * Memeriksa potensi duplikasi penyaluran.
     */
    private function findPotentialDuplicates(
        array $data,
        ?int $excludeId = null
    ) {
        $date = \Illuminate\Support\Carbon::parse(
            $data['distribution_date']
        );

        $query = Distribution::with('beneficiary')
            ->where('beneficiary_id', $data['beneficiary_id'])
            ->whereYear('distribution_date', $date->year)
            ->whereMonth('distribution_date', $date->month)
            ->where('status', '!=', 'Dibatalkan');

        if ($excludeId !== null) {
            $query->where('id', '!=', $excludeId);
        }

        return $query
            ->orderByDesc('distribution_date')
            ->orderByDesc('id')
            ->get();
    }

    /**
     * Endpoint pemeriksaan duplikasi melalui AJAX.
     */
    public function checkDuplicates(Request $request)
    {
        $validated = $request->validate([
            'distribution_date' => ['required', 'date'],

            'beneficiary_id' => [
                'required',
                'integer',
                Rule::exists('beneficiaries', 'id')
                    ->whereNull('deleted_at'),
            ],

            'distribution_id' => ['nullable', 'integer'],
        ]);

        $distributionId = $validated['distribution_id'] ?? null;

        if ($distributionId !== null) {
            $exists = Distribution::whereKey($distributionId)->exists();

            if (!$exists) {
                return response()->json([
                    'message' => 'Data penyaluran yang sedang diedit tidak ditemukan.',
                ], 404);
            }
        }

        $duplicates = $this->findPotentialDuplicates(
            $validated,
            $distributionId
        );

        return response()->json([
            'has_duplicates' => $duplicates->isNotEmpty(),
            'count' => $duplicates->count(),

            'data' => $duplicates->map(function ($item) {
                return [
                    'beneficiary_name' => $item->beneficiary?->name,
                    'distribution_date' => $item->distribution_date->format('Y-m-d'),
                    'assistance_type' => $item->assistance_type,
                    'amount' => $item->amount,
                    'status' => $item->status,
                ];
            })->values(),
        ]);
    }

    /**
     * Menyimpan data penyaluran baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'distribution_date' => ['required', 'date'],

            'beneficiary_id' => [
                'required',
                'integer',
                Rule::exists('beneficiaries', 'id')
                    ->whereNull('deleted_at'),
            ],

            'assistance_type' => ['required', 'string', 'max:100'],

            'amount' => ['required', 'numeric', 'min:10000'],

            'donation_id' => [
                'nullable',
                'integer',
                Rule::exists('donations', 'id')
                    ->whereNull('deleted_at'),
            ],

            'status' => [
                'required',
                Rule::in(['Disalurkan', 'Diproses', 'Dibatalkan']),
            ],

            'notes' => ['nullable', 'string', 'max:500'],

        ], [
            'distribution_date.required' => 'Tanggal penyaluran wajib diisi.',
            'distribution_date.date' => 'Tanggal penyaluran harus berupa tanggal yang valid.',
            'beneficiary_id.required' => 'Penerima manfaat wajib dipilih.',
            'beneficiary_id.exists' => 'Penerima manfaat tidak ditemukan atau sudah dihapus.',
            'assistance_type.required' => 'Jenis bantuan wajib diisi.',
            'amount.required' => 'Nominal atau nilai bantuan wajib diisi.',
            'amount.numeric' => 'Nominal atau nilai bantuan harus berupa angka.',
            'amount.min' => 'Nominal atau nilai bantuan minimal Rp10.000.',
            'donation_id.exists' => 'Sumber donasi tidak ditemukan atau sudah dihapus.',
            'status.required' => 'Status penyaluran wajib dipilih.',
            'status.in' => 'Status penyaluran tidak valid.',
            'notes.max' => 'Catatan penyaluran maksimal 500 karakter.',
        ]);

        $duplicates = $this->findPotentialDuplicates($validated);

        if ($duplicates->isNotEmpty() && !$request->boolean('confirm_duplicate')) {
            return back()
                ->withInput()
                ->with('duplicate_warning', [
                    'count' => $duplicates->count(),

                    'data' => $duplicates->map(function ($item) {
                        return [
                            'beneficiary_name' => $item->beneficiary?->name,
                            'distribution_date' => $item->distribution_date->format('Y-m-d'),
                            'assistance_type' => $item->assistance_type,
                            'amount' => $item->amount,
                            'status' => $item->status,
                        ];
                    })->values()->all(),
                ]);
        }

        Distribution::create($validated);

        return redirect()->route('distributions.index')
            ->with('success', 'Penyaluran bantuan berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail penyaluran.
     */
    public function show(Distribution $distribution)
    {
        $distribution->load(['beneficiary', 'donation']);

        return view('distributions.show', compact('distribution'));
    }

    /**
     * Menampilkan form edit penyaluran.
     */
    public function edit(Distribution $distribution)
    {
        $beneficiaries = Beneficiary::where('status', 'Aktif')
            ->orWhere('id', $distribution->beneficiary_id)
            ->orderBy('name')
            ->get();

        $donations = Donation::whereNull('deleted_at')
            ->orWhere('id', $distribution->donation_id)
            ->orderByDesc('donation_date')
            ->get();

        return view('distributions.edit', compact(
            'distribution',
            'beneficiaries',
            'donations'
        ));
    }

    /**
     * Memperbarui data penyaluran.
     */
    public function update(Request $request, Distribution $distribution)
    {
        $validated = $request->validate([
            'distribution_date' => ['required', 'date'],

            'beneficiary_id' => [
                'required',
                'integer',
                Rule::exists('beneficiaries', 'id')
                    ->whereNull('deleted_at'),
            ],

            'assistance_type' => ['required', 'string', 'max:100'],

            'amount' => ['required', 'numeric', 'min:10000'],

            'donation_id' => [
                'nullable',
                'integer',
                Rule::exists('donations', 'id')
                    ->whereNull('deleted_at'),
            ],

            'status' => [
                'required',
                Rule::in(['Disalurkan', 'Diproses', 'Dibatalkan']),
            ],

            'notes' => ['nullable', 'string', 'max:500'],

        ], [
            'distribution_date.required' => 'Tanggal penyaluran wajib diisi.',
            'distribution_date.date' => 'Tanggal penyaluran harus berupa tanggal yang valid.',
            'beneficiary_id.required' => 'Penerima manfaat wajib dipilih.',
            'beneficiary_id.exists' => 'Penerima manfaat tidak ditemukan atau sudah dihapus.',
            'assistance_type.required' => 'Jenis bantuan wajib diisi.',
            'amount.required' => 'Nominal atau nilai bantuan wajib diisi.',
            'amount.numeric' => 'Nominal atau nilai bantuan harus berupa angka.',
            'amount.min' => 'Nominal atau nilai bantuan minimal Rp10.000.',
            'donation_id.exists' => 'Sumber donasi tidak ditemukan atau sudah dihapus.',
            'status.required' => 'Status penyaluran wajib dipilih.',
            'status.in' => 'Status penyaluran tidak valid.',
            'notes.max' => 'Catatan penyaluran maksimal 500 karakter.',
        ]);

        $duplicates = $this->findPotentialDuplicates(
            $validated,
            $distribution->id
        );

        if ($duplicates->isNotEmpty() && !$request->boolean('confirm_duplicate')) {
            return back()
                ->withInput()
                ->with('duplicate_warning', [
                    'count' => $duplicates->count(),

                    'data' => $duplicates->map(function ($item) {
                        return [
                            'beneficiary_name' => $item->beneficiary?->name,
                            'distribution_date' => $item->distribution_date->format('Y-m-d'),
                            'assistance_type' => $item->assistance_type,
                            'amount' => $item->amount,
                            'status' => $item->status,
                        ];
                    })->values()->all(),
                ]);
        }

        $distribution->update($validated);

        return redirect()->route('distributions.index')
            ->with('success', 'Data penyaluran berhasil diperbarui.');
    }

    /**
     * Menghapus data penyaluran.
     */
    public function destroy(Distribution $distribution)
    {
        $distribution->delete();

        return redirect()
            ->route('distributions.index')
            ->with('success', 'Data penyaluran berhasil dihapus.');
    }
}
