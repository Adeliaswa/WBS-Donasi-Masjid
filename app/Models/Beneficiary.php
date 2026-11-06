<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Beneficiary extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'nik',
        'address',
        'contact',
        'category_id',
        'other_category',
        'condition',
        'status',
        'registered_at',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'registered_at' => 'date',
            'deleted_at' => 'datetime',
        ];
    }

    public function beneficiaryCategory(): BelongsTo
    {
        return $this->belongsTo(
            BeneficiaryCategory::class,
            'category_id'
        );
    }

    /**
     * Riwayat seluruh penyaluran bantuan penerima.
     */
    public function distributions(): HasMany
    {
        return $this->hasMany(
            Distribution::class,
            'beneficiary_id'
        );
    }
}
