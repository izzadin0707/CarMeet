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
            'name' => 'Art',
            'slug' => 'art'
        ]);
        
        Categories::create([
            'name' => 'Animation',
            'slug' => 'animation'
        ]);
        
        Categories::create([
            'name' => 'Design',
            'slug' => 'design'
        ]);

        Categories::create([
            'name' => 'Music',
            'slug' => 'music'
        ]);

        // Roles
        
        Roles::create([
            'role' => 'admin'
        ]);
    }
}
