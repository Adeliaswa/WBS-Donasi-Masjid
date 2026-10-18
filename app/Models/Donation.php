<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Donation extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'donor_name',
        'donation_date',
        'amount',
        'channel',
        'payment_method',
        'category',
        'notes',
        'verification_status',
        'proof_path',
    ];

    protected function casts(): array
    {
        return [
            'donation_date' => 'date',
            'amount' => 'decimal:2',
        ];
    }

    public function getDisplayDonorNameAttribute(): string
    {
        return $this->donor_name ?: 'Hamba Allah';
    }
}