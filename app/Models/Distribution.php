<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Distribution extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'distribution_date',
        'beneficiary_id',
        'assistance_type',
        'amount',
        'donation_id',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'distribution_date' => 'date',
            'amount' => 'decimal:2',
        ];
    }

    public function beneficiary(): BelongsTo
    {
        return $this->belongsTo(Beneficiary::class);
    }

    public function donation(): BelongsTo
    {
        return $this->belongsTo(Donation::class);
    }
}