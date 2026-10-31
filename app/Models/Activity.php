<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'activity_date',
        'image_path',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'activity_date' => 'date',
            'is_published' => 'boolean',
        ];
    }
}