<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function beneficiaryCategory()
    {
        return $this->belongsTo(BeneficiaryCategory::class, 'category_id');
    }
}