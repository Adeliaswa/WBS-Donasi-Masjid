<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\Distribution;
use Illuminate\Http\Request;

class PublicReportController extends Controller
{
    public function index(Request $request)
    {
        // Periode default Januari sampai Desember tahun berjalan.
        $startDate = $request->input(
            'start_date',
            now()->startOfYear()->toDateString()
        );

        $endDate = $request->input(
            'end_date',
            now()->endOfYear()->toDateString()
        );

        $reportType = $request->input('report_type', 'semua');
        $tab = $request->input('tab', 'donasi');

        // Validasi filter laporan.
        $validated = $request->validate([
            'start_date' => ['nullable', 'date', 'before_or_equal:end_date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'report_type' => ['nullable', 'in:semua,donasi,penyaluran'],
            'tab' => ['nullable', 'in:donasi,penyaluran,kategori,bulanan'],
        ]);

        // Query dasar donasi publik.
        $donationQuery = Donation::query()
            ->where('verification_status', 'verified')
            ->whereBetween('donation_date', [$startDate, $endDate]);

        // Query dasar penyaluran publik.
        $distributionQuery = Distribution::query()
            ->where('status', 'Disalurkan')
            ->whereHas('beneficiary')
            ->whereBetween('distribution_date', [$startDate, $endDate]);

        // Ringkasan mengikuti periode, tetapi tidak dipengaruhi tab.
        $totalDonation = (clone $donationQuery)->sum('amount');
        $totalDistribution = (clone $distributionQuery)->sum('amount');

        $totalRecipients = (clone $distributionQuery)
            ->distinct()
            ->count('beneficiary_id');

        $balance = $totalDonation - $totalDistribution;

        // Filter jenis laporan.
        if ($reportType === 'donasi') {
            $distributionQuery->whereRaw('1 = 0');
        } elseif ($reportType === 'penyaluran') {
            $donationQuery->whereRaw('1 = 0');
        }

        // Rekap donasi: hanya kolom yang boleh ditampilkan publik.
        $donations = (clone $donationQuery)
            ->select([
                'donation_date',
                'category',
                'amount',
                'payment_method',
            ])
            ->orderByDesc('donation_date')
            ->paginate(5, ['*'], 'donations_page')
            ->withQueryString();

        // Rekap penyaluran: tanpa identitas penerima.
        $distributions = (clone $distributionQuery)
        ->select([
            'distribution_date',
            'assistance_type',
            'amount',
        ])
        ->selectRaw('1 AS recipient_count')
        ->orderByDesc('distribution_date')
        ->paginate(5, ['*'], 'distributions_page')
        ->withQueryString();

        // Rekap kategori penyaluran.
        $categoryMapping = [
            'Sembako' => 'Bantuan Sembako',
            'Biaya Pendidikan' => 'Bantuan Pendidikan',
            'Kesehatan' => 'Bantuan Kesehatan',
            'Uang Tunai' => 'Bantuan Uang Tunai',
        ];

        $categoryRecap = (clone $distributionQuery)
            ->select('assistance_type')
            ->selectRaw('SUM(amount) AS total')
            ->groupBy('assistance_type')
            ->get()
            ->groupBy(function ($item) use ($categoryMapping) {
                return $categoryMapping[$item->assistance_type] ?? 'Lainnya';
            })
            ->map(function ($items, $category) use ($totalDistribution) {
                $total = (float) $items->sum('total');

                return [
                    'category' => $category,
                    'total' => $total,
                    'percentage' => $totalDistribution > 0
                        ? round(($total / $totalDistribution) * 100, 2)
                        : 0,
                ];
            })
            ->values();

        // Rekap bulanan.
        $monthlyDonation = (clone $donationQuery)
            ->selectRaw("TO_CHAR(donation_date, 'YYYY-MM') AS month")
            ->selectRaw('SUM(amount) AS total')
            ->groupByRaw("TO_CHAR(donation_date, 'YYYY-MM')")
            ->pluck('total', 'month');

        $monthlyDistribution = (clone $distributionQuery)
            ->selectRaw("TO_CHAR(distribution_date, 'YYYY-MM') AS month")
            ->selectRaw('SUM(amount) AS total')
            ->groupByRaw("TO_CHAR(distribution_date, 'YYYY-MM')")
            ->pluck('total', 'month');

        $monthlyRecap = collect();

        $periodStart = \Carbon\Carbon::parse($startDate)->startOfMonth();
        $periodEnd = \Carbon\Carbon::parse($endDate)->startOfMonth();

        while ($periodStart <= $periodEnd) {
            $monthKey = $periodStart->format('Y-m');

            $monthlyRecap->push([
                'month' => $monthKey,
                'donation' => (float) ($monthlyDonation[$monthKey] ?? 0),
                'distribution' => (float) ($monthlyDistribution[$monthKey] ?? 0),
            ]);

            $periodStart->addMonth();
        }

        return view('public.reports.index', compact(
            'startDate',
            'endDate',
            'reportType',
            'tab',
            'totalDonation',
            'totalDistribution',
            'totalRecipients',
            'balance',
            'donations',
            'distributions',
            'categoryRecap',
            'monthlyRecap'
        ));
    }
}