<?php

namespace Database\Seeders;

use App\Models\Commentaire;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Commentaire::insert([
            //blog 1
            [
            'commentaire' => 'Super article, merci !',
            'user_id'     => 1,
            'blog_id'     => 1,
            ],
            [
            'commentaire' => 'Genial cette article, merci beaucoup!',
            'user_id'     => 2,
            'blog_id'     => 1,
            ],
            //blog 2
            [
            'commentaire' => 'Super article, merci !',
            'user_id'     => 1,
            'blog_id'     => 2,
            ],
            [
            'commentaire' => 'Genial cette article, merci beaucoup!',
            'user_id'     => 2,
            'blog_id'     => 2,
            ],
            //3
            [
            'commentaire' => 'Super article, merci !',
            'user_id'     => 1,
            'blog_id'     => 3,
            ],
            [
            'commentaire' => 'Genial cette article, merci beaucoup!',
            'user_id'     => 2,
            'blog_id'     => 3,
            ],
            // blog 4
            [
            'commentaire' => 'Super article, merci !',
            'user_id'     => 1,
            'blog_id'     => 4,
            ],
            [
            'commentaire' => 'Genial cette article, merci beaucoup!',
            'user_id'     => 2,
            'blog_id'     => 4,
            ],
            //blog 5
            [
            'commentaire' => 'Super article, merci !',
            'user_id'     => 1,
            'blog_id'     => 5,
            ],
            [
            'commentaire' => 'Genial cette article, merci beaucoup!',
            'user_id'     => 2,
            'blog_id'     => 5,
            ],
    ]);

    }
}
