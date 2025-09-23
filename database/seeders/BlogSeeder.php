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
            //1
            [
            'titre'        => 'Aranoz grand opening party',
            'description'  => 'MCSE boot camps have its supporters and its detractors. Some people do not understand why you should have to spend money on boot camp when you can get the MCSE study materials yourself at a fraction of the camp price. However, who has the willpower to actually sit through a self-imposed MCSE training. Who has the willpower to actually.',
            'image_path'   => 'm-blog-1.jpg',
            'categorie_id' => 5, // l’ID de "Affaires"
            'created_at'   => now(),
            'updated_at'   => now(),
            ],
            //2
            [
            'titre'        => 'Smartphones Working on the moon?',
            'description'  => 'MCSE boot camps have its supporters and its detractors. Some people do not understand why you should have to spend money on boot camp when you can get the MCSE study materials yourself at a fraction of the camp price. However, who has the willpower to actually sit through a self-imposed MCSE training. Who has the willpower to actually.',
            'image_path'   => 'm-blog-2.jpg',
            'categorie_id' => 3,
            'created_at'   => now(),
            'updated_at'   => now(),
            ],
            //3
            [
            'titre'        => "Today's Fashion first tour",
            'description'  => 'MCSE boot camps have its supporters and its detractors. Some people do not understand why you should have to spend money on boot camp when you can get the MCSE study materials yourself at a fraction of the camp price. However, who has the willpower to actually sit through a self-imposed MCSE training. Who has the willpower to actually.',
            'image_path'   => 'm-blog-3.jpg',
            'categorie_id' => 4,
            'created_at'   => now(),
            'updated_at'   => now(),
            ],
            //4
            [
            'titre'        => 'This daily cup of coffee could save your life!',
            'description'  => 'MCSE boot camps have its supporters and its detractors. Some people do not understand why you should have to spend money on boot camp when you can get the MCSE study materials yourself at a fraction of the camp price. However, who has the willpower to actually sit through a self-imposed MCSE training. Who has the willpower to actually.',
            'image_path'   => 'm-blog-4.jpg',
            'categorie_id' => 2,
            'created_at'   => now(),
            'updated_at'   => now(),
            ],
            //5
            [
            'titre'        => 'Cup cakes & donuts worldwide consumption is growing.',
            'description'  => 'MCSE boot camps have its supporters and its detractors. Some people do not understand why you should have to spend money on boot camp when you can get the MCSE study materials yourself at a fraction of the camp price. However, who has the willpower to actually sit through a self-imposed MCSE training. Who has the willpower to actually.',
            'image_path'   => 'm-blog-5.jpg',
            'categorie_id' => 2,
            'created_at'   => now(),
            'updated_at'   => now(),
            ],
        ]);
        DB::table('blog_tag')->insert([
            //1
            ['blog_id' => 1, 'tag_id' => 1],   // Art de vivre
            ['blog_id' => 1, 'tag_id' => 13],  // Monde
            //2
            ['blog_id' => 2, 'tag_id' => 2],  
            //3
            ['blog_id' => 3, 'tag_id' => 1],  
            //4
            ['blog_id' => 4, 'tag_id' => 5], 
            //5
            ['blog_id' => 5, 'tag_id' => 8],  
        ]);
    }
}
