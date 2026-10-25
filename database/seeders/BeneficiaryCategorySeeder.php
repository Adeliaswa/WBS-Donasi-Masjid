<?php

namespace Database\Seeders;

use App\Models\BeneficiaryCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BeneficiaryCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Fakir Miskin',
            'Anak Yatim',
            'Lansia',
            'Duafa',
            'Korban Bencana Alam',
            'Lainnya',
        ];

        foreach ($categories as $name) {
            BeneficiaryCategory::firstOrCreate(
                ['name' => $name],
                [
                    'slug' => Str::slug($name),
                    'description' => null,
                    'is_active' => true,
                ]
            );
        }
    }
}