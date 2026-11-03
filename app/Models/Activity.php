<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
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