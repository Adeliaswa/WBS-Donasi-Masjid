<?php

namespace App\Http\Controllers;

use App\Models\Donation;

use App\Models\Distribution;

use Carbon\Carbon;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller

{

    public function index(Request $request)

    {

        $now = now();

        // ==========================================

        // FILTER PERIODE

        // ==========================================

        $validated = $request->validate([

            'month' => ['nullable', 'integer', 'between:1,12'],

            'year' => ['nullable', 'integer', 'between:2000,2100'],

            'chart_year' => ['nullable', 'integer', 'between:2000,2100'],

        ]);

        $selectedMonth = (int) ($validated['month'] ?? $now->month);

        $selectedYear = (int) ($validated['year'] ?? $now->year);

        $chartYear = (int) ($validated['chart_year'] ?? $now->year);

        $periodStart = Carbon::create(

            $selectedYear,

            $selectedMonth,

            1

        )->startOfMonth();

        $periodEnd = $periodStart->copy()->endOfMonth();

        $previousStart = $periodStart->copy()->subMonth()->startOfMonth();

        $previousEnd = $periodStart->copy()->subMonth()->endOfMonth();

        // ==========================================

        // QUERY DASAR DONASI

        // Hanya donasi terverifikasi

        // ==========================================

        $verifiedDonations = Donation::query()

            ->where('verification_status', 'verified');

        // ==========================================

        // QUERY DASAR PENYALURAN

        // Hanya penyaluran yang sudah disalurkan

        // ==========================================

        $completedDistributions = Distribution::query()

            ->where('status', 'Disalurkan')

            ->whereHas('beneficiary');

        // ==========================================

        // 1. TOTAL DONASI

        // ==========================================

        $totalDonation = (clone $verifiedDonations)

            ->whereBetween('donation_date', [

                $periodStart->toDateString(),

                $periodEnd->toDateString(),

            ])

            ->sum('amount');

        $previousDonation = (clone $verifiedDonations)

            ->whereBetween('donation_date', [

                $previousStart->toDateString(),

                $previousEnd->toDateString(),

            ])

            ->sum('amount');

        // ==========================================

        // 2. JUMLAH DONATUR UNIK

        // Nama kosong tidak dihitung

        // ==========================================

        $donorQuery = function ($start, $end) {

            return Donation::query()

                ->where('verification_status', 'verified')

                ->whereBetween('donation_date', [

                    $start->toDateString(),

                    $end->toDateString(),

                ])

                ->whereNotNull('donor_name')

                ->whereRaw("TRIM(donor_name) <> ''");

        };

        $totalDonors = (clone $donorQuery(

            $periodStart,

            $periodEnd

        ))->distinct()->count(DB::raw('LOWER(TRIM(donor_name))'));

        $previousDonors = (clone $donorQuery(

            $previousStart,

            $previousEnd

        ))->distinct()->count(DB::raw('LOWER(TRIM(donor_name))'));

        // ==========================================

        // 3. BANTUAN DISALURKAN

        // ==========================================

        $totalDistribution = (clone $completedDistributions)

            ->whereBetween('distribution_date', [

                $periodStart->toDateString(),

                $periodEnd->toDateString(),

            ])

            ->sum('amount');

        $previousDistribution = (clone $completedDistributions)

            ->whereBetween('distribution_date', [

                $previousStart->toDateString(),

                $previousEnd->toDateString(),

            ])

            ->sum('amount');

        // ==========================================

        // 4. JUMLAH PENERIMA UNIK

        // ==========================================

        $recipientQuery = function ($start, $end) {

            return Distribution::query()

                ->where('status', 'Disalurkan')

                ->whereHas('beneficiary')

                ->whereBetween('distribution_date', [

                    $start->toDateString(),

                    $end->toDateString(),

                ]);

        };

        $totalRecipients = (clone $recipientQuery(

            $periodStart,

            $periodEnd

        ))->distinct()->count('beneficiary_id');

        $previousRecipients = (clone $recipientQuery(

            $previousStart,

            $previousEnd

        ))->distinct()->count('beneficiary_id');

        // ==========================================

        // PERSENTASE PERUBAHAN

        // ==========================================

        $calculateChange = function ($current, $previous) {

            if ($previous == 0) {

                return null;

            }

            return round(

                (($current - $previous) / $previous) * 100

            );

        };

        $summary = [

            [

                'title' => 'Total Donasi',

                'value' => $totalDonation,

                'type' => 'currency',

                'icon' => 'hand-heart',

                'change' => $calculateChange(

                    $totalDonation,

                    $previousDonation

                ),

                'description' => 'Dibanding bulan lalu',

            ],

            [

                'title' => 'Jumlah Donatur',

                'value' => $totalDonors,

                'type' => 'number',

                'icon' => 'users',

                'change' => $calculateChange(

                    $totalDonors,

                    $previousDonors

                ),

                'description' => 'Dibanding bulan lalu',

            ],

            [

                'title' => 'Bantuan Disalurkan',

                'value' => $totalDistribution,

                'type' => 'currency',

                'icon' => 'package-check',

                'change' => $calculateChange(

                    $totalDistribution,

                    $previousDistribution

                ),

                'description' => 'Dibanding bulan lalu',

            ],

            [

                'title' => 'Jumlah Penerima',

                'value' => $totalRecipients,

                'type' => 'number',

                'icon' => 'users-round',

                'change' => $calculateChange(

                    $totalRecipients,

                    $previousRecipients

                ),

                'description' => 'Dibanding bulan lalu',

            ],

        ];

        // ==========================================

        // DAFTAR TAHUN YANG MEMILIKI DATA DONASI

        // ==========================================

        $availableYears = Donation::query()

            ->where('verification_status', 'verified')

            ->selectRaw(

                'EXTRACT(YEAR FROM donation_date)::integer AS year'

            )

            ->distinct()

            ->orderByDesc('year')

            ->pluck('year')

            ->map(fn ($year) => (int) $year)

            ->values()

            ->all();

        if (!in_array($now->year, $availableYears)) {

            $availableYears[] = $now->year;

        }

        if (!in_array($selectedYear, $availableYears)) {

            $availableYears[] = $selectedYear;

        }

        if (!in_array($chartYear, $availableYears)) {

            $availableYears[] = $chartYear;

        }

        rsort($availableYears);

        // ==========================================

        // GRAFIK DONASI MASUK PER BULAN

        // ==========================================

        $monthlyDonations = Donation::query()

            ->where('verification_status', 'verified')

            ->whereYear('donation_date', $chartYear)

            ->selectRaw(

                'EXTRACT(MONTH FROM donation_date)::integer AS month_number,

                 SUM(amount) AS total'

            )

            ->groupByRaw(

                'EXTRACT(MONTH FROM donation_date)'

            )

            ->pluck('total', 'month_number');

        $monthNames = [

            'Jan', 'Feb', 'Mar', 'Apr',

            'Mei', 'Jun', 'Jul', 'Agu',

            'Sep', 'Okt', 'Nov', 'Des',

        ];

        $lastChartMonth = $chartYear === $now->year

            ? $now->month

            : 12;

        $chartDonations = [];

        for ($month = 1; $month <= $lastChartMonth; $month++) {

            $chartDonations[] = [

                'month' => $monthNames[$month - 1],

                'month_number' => $month,

                'total' => (float) ($monthlyDonations[$month] ?? 0),

            ];

        }

        // ==========================================

        // GRAFIK KATEGORI DONASI

        // Mengikuti filter bulan dan tahun

        // ==========================================

        $categoryDonations = Donation::query()

            ->where('verification_status', 'verified')

            ->whereBetween('donation_date', [

                $periodStart->toDateString(),

                $periodEnd->toDateString(),

            ])

            ->select('category')

            ->selectRaw('SUM(amount) AS total')

            ->groupBy('category')

            ->orderByDesc('total')

            ->get();

        $categoryTotal = (float) $categoryDonations->sum('total');

        $categoryColors = [

            '#294236',

            '#83B84D',

            '#A9CE78',

            '#D8E8B9',

            '#E8EEE5',

        ];

        $categoryChart = $categoryDonations

            ->values()

            ->map(function ($item, $index) use (

                $categoryTotal,

                $categoryColors

            ) {

                $total = (float) $item->total;

                return [

                    'name' => $item->category ?: 'Lainnya',

                    'total' => $total,

                    'percentage' => $categoryTotal > 0

                        ? round(($total / $categoryTotal) * 100, 1)

                        : 0,

                    'color' => $categoryColors[

                        $index % count($categoryColors)

                    ],

                ];

            });

        // ==========================================

        // DONASI TERBARU

        // Tidak mengikuti filter periode

        // ==========================================

        $latestDonations = Donation::query()

            ->where('verification_status', 'pending')
            ->orderByDesc('donation_date')

            ->orderByDesc('id')

            ->limit(5)

            ->get();

        // ==========================================

        // PENYALURAN TERBARU

        // Tidak mengikuti filter periode

        // ==========================================

        $latestDistributions = Distribution::query()

            ->with('beneficiary')

            ->orderByDesc('distribution_date')

            ->orderByDesc('id')

            ->limit(5)

            ->get();

        // ==========================================

        // NAMA BULAN UNTUK TAMPILAN

        // ==========================================

        $selectedMonthName = Carbon::create()

            ->month($selectedMonth)

            ->translatedFormat('F');

        $chartYearTotal = (float) array_sum(

            array_column($chartDonations, 'total')

        );

        return view('dashboard', compact(

            'summary',

            'selectedMonth',

            'selectedYear',

            'selectedMonthName',

            'chartYear',

            'availableYears',

            'chartDonations',

            'chartYearTotal',

            'categoryChart',

            'categoryTotal',

            'latestDonations',

            'latestDistributions'

        ));

    }

}
