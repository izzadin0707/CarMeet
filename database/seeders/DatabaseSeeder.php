<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Admin;
use App\Models\Categories;
use App\Models\Roles;
use App\Models\Users;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User 
        Users::create([
            'name' => 'Admin',
            'username' => 'Admin#0000',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin#1234'),
            'roles' => 1
        ]);

        // Categories
        Categories::create([
            'name' => 'General',
            'slug' => 'general'
        ]);
        
        Categories::create([
            'name' => 'Mods & Tech',
            'slug' => 'modstech'
        ]);
        
        Categories::create([
            'name' => 'Car Showcase',
            'slug' => 'carshowcase'
        ]);

        Categories::create([
            'name' => 'Help & Tips',
            'slug' => 'helptips'
        ]);

        // Roles
        Roles::create([
            'role' => 'admin'
        ]);
    }
}
