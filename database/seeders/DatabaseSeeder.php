<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\BlogCategory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'ADMIN',
            'email' => 'manh.tv0911@gmail.com',
            'role' => 1,
            'password' => Hash::make('manh.tv0911'),
        ]);
        BlogCategory::create([
            'name' => 'First category',
        ]);

        BlogCategory::create([
            'name' => 'Second category',
        ]);
    }
}