<?php

namespace Database\Seeders;

use App\Models\Blog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Blog::insert([
            [
            'titre'        => 'Aranoz grand opening party',
            'description'  => 'MCSE boot camps have its supporters and its detractors. ...',
            'image'        => 'm-blog-1.jpg',
            'categorie_id' => 5, // l’ID de "Affaires"
            'created_at'   => now(),
            'updated_at'   => now(),
            ],
        ]);
        DB::table('blog_tag')->insert([
            ['blog_id' => 1, 'tag_id' => 1],   // Art de vivre
            ['blog_id' => 1, 'tag_id' => 13],  // Monde
        ]);
    }
}
