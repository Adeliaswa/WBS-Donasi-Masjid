<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Donation;
use App\Models\Distribution;
use Illuminate\Support\Facades\DB;

class PublicHomeController extends Controller
{
    public function index()
    {
        $startDate = now()->startOfYear()->toDateString();
        $endDate = now()->endOfYear()->toDateString();

        // Donasi yang sudah terverifikasi.
        $donationQuery = Donation::query()
            ->where('verification_status', 'verified');

        // Penyaluran yang sudah selesai dan penerimanya masih aktif.
        $distributionQuery = Distribution::query()
            ->where('status', 'Disalurkan')
            ->whereHas('beneficiary');

        // Ringkasan publik.
        $totalDonation = (clone $donationQuery)
            ->sum('amount');

        $totalDistribution = (clone $distributionQuery)
            ->sum('amount');

        $totalRecipients = (clone $distributionQuery)
            ->distinct()
            ->count('beneficiary_id');

        $balance = $totalDonation - $totalDistribution;

        // Data grafik donasi dan penyaluran per bulan.
        $monthlyDonation = (clone $donationQuery)
            ->whereBetween('donation_date', [$startDate, $endDate])
            ->selectRaw('EXTRACT(MONTH FROM donation_date) AS month, SUM(amount) AS total')
            ->groupByRaw('EXTRACT(MONTH FROM donation_date)')
            ->pluck('total', 'month');

        $monthlyDistribution = (clone $distributionQuery)
            ->whereBetween('distribution_date', [$startDate, $endDate])
            ->selectRaw('EXTRACT(MONTH FROM distribution_date) AS month, SUM(amount) AS total')
            ->groupByRaw('EXTRACT(MONTH FROM distribution_date)')
            ->pluck('total', 'month');

        $monthlyChart = [];

        for ($month = 1; $month <= now()->month; $month++) {
            $monthlyChart[] = [
                'month' => $month,
                'donation' => (float) ($monthlyDonation[$month] ?? 0),
                'distribution' => (float) ($monthlyDistribution[$month] ?? 0),
            ];
        }

        // Kategori penyaluran untuk grafik donat.
        $categoryMapping = [
            'Sembako' => 'Bantuan Sembako',
            'Biaya Pendidikan' => 'Bantuan Pendidikan',
            'Kesehatan' => 'Bantuan Kesehatan',
            'Uang Tunai' => 'Bantuan Uang Tunai',
        ];

        $categoryTotals = (clone $distributionQuery)
            ->whereBetween('distribution_date', [$startDate, $endDate])
            ->select('assistance_type')
            ->selectRaw('SUM(amount) AS total')
            ->groupBy('assistance_type')
            ->get();

        $distributionCategoryChart = $categoryTotals
            ->groupBy(function ($item) use ($categoryMapping) {
                return $categoryMapping[$item->assistance_type] ?? 'Lainnya';
            })
            ->map(function ($items, $category) {
                return [
                    'category' => $category,
                    'total' => (float) $items->sum('total'),
                ];
            })
            ->values();

        // Kegiatan terbaru yang sudah dipublikasikan.
        $latestActivities = Activity::query()
            ->where('is_published', true)
            ->select([
                'title',
                'description',
                'activity_date',
                'image_path',
            ])
            ->orderByDesc('activity_date')
            ->limit(4)
            ->get();

        return view('public.home', compact(
            'totalDonation',
            'totalDistribution',
            'totalRecipients',
            'balance',
            'monthlyChart',
            'distributionCategoryChart',
            'latestActivities'
        ));
    }
}