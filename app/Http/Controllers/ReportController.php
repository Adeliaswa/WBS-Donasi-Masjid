<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\DonationCategory;
use App\Models\Distribution;
use Illuminate\Http\Request;

class ReportController extends Controller
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

        // Validasi rentang tanggal laporan.
        $request->validate([
            'start_date' => ['nullable', 'date', 'before_or_equal:end_date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
        ]);

        // Filter jenis laporan dan kategori.
        $reportType = $request->input('report_type', 'semua');
        $category = $request->input('category');

        // Query donasi yang sudah terverifikasi.
        $donationQuery = Donation::query()
            ->where('verification_status', 'verified')
            ->whereBetween('donation_date', [$startDate, $endDate]);

        // Query penyaluran yang sudah disalurkan.
        $distributionQuery = Distribution::query()
            ->where('status', 'Disalurkan')
            ->whereHas('beneficiary')
            ->whereBetween('distribution_date', [$startDate, $endDate]);

        // Terapkan filter kategori sesuai jenis laporan.
        if ($category) {
            if ($reportType === 'donasi') {
                $donationQuery->where('category', $category);
            } elseif ($reportType === 'penyaluran') {
                $distributionQuery->where('assistance_type', $category);
            } else {
                $donationQuery->where('category', $category);
                $distributionQuery->where('assistance_type', $category);
            }
        }

        // Ringkasan berdasarkan filter.
        $totalDonation = $reportType === 'penyaluran'
            ? 0
            : (clone $donationQuery)->sum('amount');

        $totalDistribution = $reportType === 'donasi'
            ? 0
            : (clone $distributionQuery)->sum('amount');

        $totalRecipients = $reportType === 'donasi'
            ? 0
            : (clone $distributionQuery)
                ->distinct()
                ->count('beneficiary_id');

        // Saldo dihitung dari seluruh transaksi dalam periode,
        // tanpa dipengaruhi filter jenis laporan dan kategori.
        $balanceDonation = Donation::query()
            ->where('verification_status', 'verified')
            ->whereBetween('donation_date', [$startDate, $endDate])
            ->sum('amount');

        $balanceDistribution = Distribution::query()
            ->where('status', 'Disalurkan')
            ->whereHas('beneficiary')
            ->whereBetween('distribution_date', [$startDate, $endDate])
            ->sum('amount');

        $balance = $balanceDonation - $balanceDistribution;

        // Rekap donasi tanpa identitas donatur.
        $donations = (clone $donationQuery)
            ->select([
                'id',
                'donation_date',
                'category',
                'amount',
                'payment_method',
                'verification_status',
            ])
            ->when($reportType === 'penyaluran', function ($query) {
                $query->whereRaw('1 = 0');
            })
            ->orderByDesc('donation_date')
            ->paginate(10, ['*'], 'donations_page')
            ->withQueryString();

        // Rekap penyaluran tanpa identitas penerima.
        $distributions = (clone $distributionQuery)
            ->select([
                'id',
                'distribution_date',
                'assistance_type',
                'beneficiary_id',
                'amount',
                'status',
            ])
            ->when($reportType === 'donasi', function ($query) {
                $query->whereRaw('1 = 0');
            })
            ->orderByDesc('distribution_date')
            ->paginate(10, ['*'], 'distributions_page')
            ->withQueryString();

        
        // Data grafik batang donasi dan penyaluran per bulan.
        $monthlyDonation = (clone $donationQuery)
            ->selectRaw('EXTRACT(MONTH FROM donation_date) AS month, SUM(amount) AS total')
            ->groupByRaw('EXTRACT(MONTH FROM donation_date)')
            ->pluck('total', 'month');

        $monthlyDistribution = (clone $distributionQuery)
            ->selectRaw('EXTRACT(MONTH FROM distribution_date) AS month, SUM(amount) AS total')
            ->groupByRaw('EXTRACT(MONTH FROM distribution_date)')
            ->pluck('total', 'month');

        $monthlyChart = [];

        for ($month = 1; $month <= 12; $month++) {
            $monthlyChart[] = [
                'month' => $month,
                'donation' => $reportType === 'penyaluran'
                    ? 0
                    : (float) ($monthlyDonation[$month] ?? 0),
                'distribution' => $reportType === 'donasi'
                    ? 0
                    : (float) ($monthlyDistribution[$month] ?? 0),
            ];
        }

        // Data grafik donat nominal penyaluran berdasarkan jenis bantuan.
        $distributionCategoryChart = (clone $distributionQuery)
        ->when($reportType === 'donasi', function ($query) {
            $query->whereRaw('1 = 0');
        })
        ->selectRaw('assistance_type, SUM(amount) AS total')
        ->groupBy('assistance_type')
        ->orderBy('assistance_type')
        ->get()
        ->map(function ($item) {
            return [
                'category' => $item->assistance_type,
                'total' => (float) $item->total,
            ];
        });

        // Pilihan kategori filter.
        $donationCategories = DonationCategory::where('is_active', true)
            ->orderBy('name')
            ->pluck('name');

        $distributionCategories = Distribution::query()
            ->select('assistance_type')
            ->distinct()
            ->orderBy('assistance_type')
            ->pluck('assistance_type');

        return view('reports.index', compact(
            'totalDonation',
            'totalDistribution',
            'totalRecipients',
            'balance',
            'donations',
            'distributions',
            'startDate',
            'endDate',
            'reportType',
            'category',
            'donationCategories',
            'distributionCategories',
            'monthlyChart',
            'distributionCategoryChart'
        ));
    }
}