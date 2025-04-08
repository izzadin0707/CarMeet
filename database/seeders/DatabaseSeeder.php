<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Admin;
use App\Models\Categories;
use App\Models\Roles;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Categories
        Categories::create([
            'name' => 'General',
            'slug' => 'general'
        ]);
        
        Categories::create([
            'name' => 'Mods & Tech',
            'slug' => 'mods_tech'
        ]);
        
        Categories::create([
            'name' => 'Car Showcase',
            'slug' => 'car_showcase'
        ]);

        Categories::create([
            'name' => 'Help & Tips',
            'slug' => 'help_tips'
        ]);

        // Roles
        
        Roles::create([
            'role' => 'admin'
        ]);
    }
}
