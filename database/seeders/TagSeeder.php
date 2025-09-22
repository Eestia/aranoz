<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $tags = [
            'Art de vivre', //1
            'Technologie', //2
            'Recettes', //3
            'Éducation', //4
            'Politique', //5
            'Loisirs', //6
            'Habitat', //7
            'Gastronomie', //8
            'Religion', //9
            'Cinéma', //10
            'Science', //11
            'Actualités', //12
            'Monde', //13
        ];

        foreach ($tags as $nom) {
            Tag::create(['nom' => $nom]);
        }
    }
}
