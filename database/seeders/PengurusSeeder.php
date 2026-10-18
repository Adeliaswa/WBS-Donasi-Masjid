<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PengurusSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'pengurus@sabilillah.id'],
            [
                'name' => 'Pengurus Masjid Sabilillah',
                'password' => Hash::make(
                    env('PENGURUS_PASSWORD', 'Pengurus123')
                ),
            ]
        );
    }
}