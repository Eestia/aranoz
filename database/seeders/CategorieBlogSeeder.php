<?php

namespace Database\Seeders;

use App\Models\CategorieBlog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorieBlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories_blog = [
            'Voyage',   //1
            'Santé', //2
            'Découverte', //3
            'Mode', //4
            'Affaires', //5
        ];

        foreach ($categories_blog as $nom){
            CategorieBlog::create(['nom'=>$nom]);
        }
    }
}
