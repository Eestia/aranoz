<?php

namespace Database\Seeders;

use App\Models\Couleur;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CouleurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $couleurs = [
            'Blanc',
            'Noyer',        // walnut
            'Chêne',        // oak
            'Noir',
            'Marron',
            'Rouge',
            'Jaune',
            'Vert',
            'Bleu',
            'Rose',
            'Orange',
            'Violet',
            'Autre',
        ];

        foreach ($couleurs as $nom) {
            Couleur::create(['nom' => $nom]);
        }
    }
}
