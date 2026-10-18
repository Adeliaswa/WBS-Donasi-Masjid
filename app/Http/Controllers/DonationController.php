<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DonationController extends Controller
{
    public function index()
    {
        $donations = Donation::latest('donation_date')
            ->paginate(10);

        return view('donations.index', compact('donations'));
    }

    public function create()
    {
        return view('donations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'donor_name' => ['nullable', 'string', 'max:255'],
            'donation_date' => ['required', 'date'],
            'amount' => ['required', 'numeric', 'gt:0'],
            'channel' => ['required', 'string', 'max:255'],
            'payment_method' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
            'verification_status' => [
                'required',
                Rule::in(['pending', 'verified', 'rejected']),
            ],
            'proof_path' => ['nullable', 'string', 'max:255'],
        ]);

        Donation::create($validated);

        return redirect()
            ->route('donations.index')
            ->with('success', 'Data donasi berhasil disimpan.');
    }

    public function show(Donation $donation)
    {
        return view('donations.show', compact('donation'));
    }

    public function edit(Donation $donation)
    {
        return view('donations.edit', compact('donation'));
    }

    public function update(Request $request, Donation $donation)
    {
        $validated = $request->validate([
            'donor_name' => ['nullable', 'string', 'max:255'],
            'donation_date' => ['required', 'date'],
            'amount' => ['required', 'numeric', 'gt:0'],
            'channel' => ['required', 'string', 'max:255'],
            'payment_method' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
            'verification_status' => [
                'required',
                Rule::in(['pending', 'verified', 'rejected']),
            ],
            'proof_path' => ['nullable', 'string', 'max:255'],
        ]);

        $donation->update($validated);

        return redirect()
            ->route('donations.index')
            ->with('success', 'Data donasi berhasil diperbarui.');
    }

    public function destroy(Donation $donation)
    {
        $donation->delete();

        return redirect()
            ->route('donations.index')
            ->with('success', 'Data donasi berhasil dihapus.');
    }
}