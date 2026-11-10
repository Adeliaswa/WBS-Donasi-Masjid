<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PengurusSeeder extends Seeder
{
    public function run(): void
    {
        $password = env('PENGURUS_PASSWORD');

        if (empty($password)) {
            throw new \RuntimeException(
                'PENGURUS_PASSWORD belum diatur.'
            );
        }

        User::firstOrCreate(
            ['email' => 'pengurus@sabilillah.id'],
            [
                'name' => 'Pengurus Masjid Sabilillah',
                'password' => Hash::make($password),
            ]
        );
    }
}