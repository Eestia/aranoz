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
            'Blanc',        //1
            'Noyer',        // 2
            'Chêne',        // 3
            'Noir',         // 4
            'Marron',       //5
            'Rouge',        // 6
            'Jaune',        //7
            'Vert',         //8
            'Bleu',         // 9
            'Rose',         // 10
            'Orange',       // 11
            'Violet',       // 12
            'Autre',        // 13
        ];

        foreach ($couleurs as $nom) {
            Couleur::create(['nom' => $nom]);
        }
    }
}
