<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
        CouleurSeeder::class,
        CategorieSeeder::class,
        ProduitSeeder::class,
        CategorieBlogSeeder::class,
        TagSeeder::class,
        BlogSeeder::class,
        RoleSeeder::class,
        UserSeeder::class,
    ]);
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

    }
    
}
