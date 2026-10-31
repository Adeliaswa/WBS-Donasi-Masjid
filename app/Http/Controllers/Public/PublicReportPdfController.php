<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\Distribution;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PublicReportPdfController extends Controller
{
    public function donations(Request $request)
    {
        $startDate = $request->input(
            'start_date',
            now()->startOfYear()->toDateString()
        );

        $endDate = $request->input(
            'end_date',
            now()->endOfYear()->toDateString()
        );

        $request->merge([
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);

        $request->validate([
            'start_date' => ['required', 'date', 'before_or_equal:end_date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
        ]);

        $donations = Donation::query()
            ->where('verification_status', 'verified')
            ->whereBetween('donation_date', [$startDate, $endDate])
            ->select([
                'donation_date',
                'category',
                'payment_method',
                'amount',
            ])
            ->orderBy('donation_date')
            ->get();

        $total = $donations->sum('amount');

        $pdf = Pdf::loadView('public.reports.pdf.donations', compact(
            'donations',
            'startDate',
            'endDate',
            'total'
        ));

        return $pdf->download('rekap-donasi.pdf');
    }

    public function distributions(Request $request)
    {
        $startDate = $request->input(
            'start_date',
            now()->startOfYear()->toDateString()
        );

        $endDate = $request->input(
            'end_date',
            now()->endOfYear()->toDateString()
        );

        $request->merge([
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);

        $request->validate([
            'start_date' => ['required', 'date', 'before_or_equal:end_date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
        ]);

        $distributions = Distribution::query()
            ->where('status', 'Disalurkan')
            ->whereHas('beneficiary')
            ->whereBetween('distribution_date', [$startDate, $endDate])
            ->select([
                'distribution_date',
                'assistance_type',
                'amount',
            ])
            ->orderBy('distribution_date')
            ->get();

        $categoryMapping = [
            'Sembako' => 'Bantuan Sembako',
            'Biaya Pendidikan' => 'Bantuan Pendidikan',
            'Kesehatan' => 'Bantuan Kesehatan',
            'Uang Tunai' => 'Bantuan Uang Tunai',
        ];

        $distributions->transform(function ($item) use ($categoryMapping) {
            $item->public_category = $categoryMapping[$item->assistance_type]
                ?? 'Lainnya';

            return $item;
        });

        $total = $distributions->sum('amount');

        $pdf = Pdf::loadView('public.reports.pdf.distributions', compact(
            'distributions',
            'startDate',
            'endDate',
            'total'
        ));

        return $pdf->download('rekap-penyaluran.pdf');
    }
}