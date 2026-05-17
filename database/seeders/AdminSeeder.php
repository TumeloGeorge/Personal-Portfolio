<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::updateOrCreate(
            ['email' => 'admin@portfolio.local'],
            [
                'name'     => 'Tim Tom',
                'email'    => 'admin@portfolio.local',
                'password' => Hash::make('ChangeMe123!'),
            ]
        );
    }
}