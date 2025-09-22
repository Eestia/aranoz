<?php

namespace Database\Seeders;

use App\Models\Categorie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Chaises',
            'Buffets',
            'Vaisseliers',
            'Étagères',
            'Bibliothèques',
            'Canapés',
            'Fauteuils',
            'Méridiennes',
            'Bureaux',
            'Lits',
            'Armoires',
        ];

        foreach ($categories as $nom) {
            Categorie::create([
                'nom'  => $nom,
                'slug' => \Str::slug($nom),
            ]);
        }
    }
}
