<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DonationCategory;
use Illuminate\Support\Str;

class DonationCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Operasional Masjid',
                'description' => 'Donasi untuk kebutuhan operasional masjid.',
            ],
            [
                'name' => 'Pembangunan Masjid',
                'description' => 'Donasi untuk pembangunan dan renovasi masjid.',
            ],
            [
                'name' => 'Santunan Anak Yatim',
                'description' => 'Donasi untuk santunan anak yatim.',
            ],
            [
                'name' => 'Bantuan Sosial',
                'description' => 'Donasi untuk kegiatan bantuan sosial.',
            ],
            [
                'name' => 'Kegiatan Keagamaan',
                'description' => 'Donasi untuk kegiatan keagamaan masjid.',
            ],
        ];

        foreach ($categories as $category) {
            DonationCategory::firstOrCreate(
                ['name' => $category['name']],
                [
                    'slug' => Str::slug($category['name']),
                    'description' => $category['description'],
                    'is_active' => true,
                ]
            );
        }
    }
}   