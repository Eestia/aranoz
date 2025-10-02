<?php

namespace Database\Seeders;

use App\Models\Produit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProduitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Produit::insert([
            //1
            [
                'titre' => 'Canapé Bleu Moderne',
                'description' => 'Un canapé bleu élégant et moderne, alliant confort et style contemporain. Parfait pour créer un salon accueillant et raffiné, où se détendre ou recevoir des invités avec élégance.',
                'slug'=>'canapé',
                'image_path' => 'produits/banner_img.png',
                'image2_path' => 'produits/banner_img.png',
                'image3_path' => 'produits/banner_img.png',
                'prix' => 45,
                'en_reduction' => true,
                'is_pinned' => false,
                'reduction_pct' => 10,
                'stock' => 12,
                'couleur_id' => 9, 
                'categorie_id' => 6, 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            //2
            [
                'titre' => 'Chaise Verte Scandinave',
                'description' => 'Chaise au design scandinave vert pastel, légère et pratique. Son assise confortable et sa silhouette épurée apportent fraîcheur et modernité à votre salle à manger ou bureau.',
                'slug'=>'chaise',
                'image_path' => 'produits/product_1.png',
                'image2_path' => 'produits/product_1.png',
                'image3_path' => 'produits/product_1.png',
                'prix' => 12,
                'en_reduction' => false,
                'is_pinned' => false,
                'reduction_pct' => null,
                'stock' => 8,
                'couleur_id' => 8, 
                'categorie_id' => 1, 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            //3
            [
                'titre' => 'Chaise Orange Design',
                'description' => 'Chaise orange au style contemporain, avec un design épuré et un confort optimal. Idéale pour apporter une touche dynamique à votre intérieur.',
                'slug'=>'chaise2',
                'image_path' => 'produits/product_2.png',
                'image2_path' => 'produits/product_2.png',
                'image3_path' => 'produits/product_2.png',
                'prix' => 13,
                'en_reduction' => true,
                'is_pinned' => false,
                'reduction_pct' => 5,
                'stock' => 5,
                'couleur_id' => 11, // Orange
                'categorie_id' => 1, // Chaises
                'created_at' => now(),
                'updated_at' => now(),
            ],
            //4
            [
                'titre' => 'Fauteuil Rotin Cosy',
                'description' => 'Fauteuil en rotin naturel au style chaleureux et cosy. Parfait pour un coin lecture ou un salon détendu, combinant robustesse et confort.',
                'slug'=>'fauteuil',
                'image_path' => 'produits/feature_4.png',
                'image2_path' => 'produits/feature_4.png',
                'image3_path' => 'produits/feature_4.png',
                'prix' => 22,
                'en_reduction' => false,
                'is_pinned' => false,
                'reduction_pct' => null,
                'stock' => 4,
                'couleur_id' => 7, 
                'categorie_id' => 6, // Fauteuils
                'created_at' => now(),
                'updated_at' => now(),
            ],
            //5
            [
                'titre' => 'Canapé Jaune Lumineux',
                'description' => 'Canapé jaune vif et lumineux, conçu pour illuminer votre salon. Son assise douce et confortable en fait un espace parfait pour des moments conviviaux.',
                'slug'=>'canapé2',
                'image_path' => 'produits/product_9.png',
                'image2_path' => 'produits/product_9.png',
                'image3_path' => 'produits/product_9.png',
                'prix' => 48,
                'en_reduction' => true,
                'is_pinned' => true,
                'reduction_pct' => 12,
                'stock' => 10,
                'couleur_id' => 7, // Jaune
                'categorie_id' => 7, // Canapés
                'created_at' => now(),
                'updated_at' => now(),
            ],
            //6
            [
                'titre' => 'Chaise Bleu Scandinave',
                'description' => 'Chaise bleu pastel au style scandinave, combinant légèreté et design moderne. Idéale pour un bureau ou une salle à manger créative.',
                'slug'=>'chaise3',
                'image_path' => 'produits/feature_1.png',
                'image2_path' => 'produits/feature_1.png',
                'image3_path' => 'produits/feature_1.png',
                'prix' => 14,
                'en_reduction' => false,
                'is_pinned' => false,
                'reduction_pct' => null,
                'stock' => 3,
                'couleur_id' => 9, // Vert
                'categorie_id' => 1, // Chaises
                'created_at' => now(),
                'updated_at' => now(),
            ],
            //7
            [
                'titre' => 'Chaise Orange Moderne',
                'description' => 'Chaise orange au design moderne et lignes épurées, apportant une touche de couleur et de style à votre intérieur. Confort et esthétisme réunis.',
                'slug'=>'chaise4',
                'image_path' => 'produits/feature_2.png',
                'image2_path' => 'produits/feature_2.png',
                'image3_path' => 'produits/feature_2.png',
                'prix' => 12,
                'en_reduction' => true,
                'is_pinned' => true,
                'reduction_pct' => 10,
                'stock' => 20,
                'couleur_id' => 11, // Orange
                'categorie_id' => 1, // Chaises
                'created_at' => now(),
                'updated_at' => now(),
            ],
            //8
            [
                'titre' => 'Fauteuil rond mignon',
                'description' => 'Petit fauteuil rond avec coussin central blanc, alliant confort et charme. Parfait pour un coin lecture ou une chambre cosy.',
                'slug'=>'fauteuil2',
                'image_path' => 'produits/feature_3.png',
                'image2_path' => 'produits/feature_3.png',
                'image3_path' => 'produits/feature_3.png',
                'prix' => 223,
                'en_reduction' => false,
                'is_pinned' => false,
                'reduction_pct' => null,
                'stock' => 4,
                'couleur_id' => 1, // Marron
                'categorie_id' => 7, // Fauteuils
                'created_at' => now(),
                'updated_at' => now(),
            ],
            //9
            [
                'titre' => 'Fauteuil rond bleu claire',
                'description' => 'Fauteuil rond bleu clair aux couleurs pastel, idéal pour une chambre d’enfant ou un coin détente. Confort douillet et design apaisant.',
                'slug'=>'fauteuil3',
                'image_path' => 'produits/offer_img.png',
                'image2_path' => 'produits/offer_img.png',
                'image3_path' => 'produits/offer_img.png',
                'prix' => 295,
                'en_reduction' => false,
                'is_pinned' => false,
                'reduction_pct' => null,
                'stock' => 7,
                'couleur_id' => 9, // Marron
                'categorie_id' => 7, // Fauteuils
                'created_at' => now(),
                'updated_at' => now(),
            ],
            //10
            [
                'titre' => 'Chaise jaune design',
                'description' => 'Chaise jaune contemporaine au style original et formes harmonieuses. Apporte lumière et modernité à votre espace repas ou bureau.',
                'slug'=>'chaise6',
                'image_path' => 'produits/product_3.png',
                'image2_path' => 'produits/product_3.png',
                'image3_path' => 'produits/product_3.png',
                'prix' => 92,
                'en_reduction' => true,
                'is_pinned' => false,
                'reduction_pct' => 50,
                'stock' => 6,
                'couleur_id' => 7, // Orange
                'categorie_id' => 1, // Chaises
                'created_at' => now(),
                'updated_at' => now(),
            ],
            //11
            [
                'titre' => 'Chaise à carraux',
                'description' => 'Chaise à carreaux simple et pratique, avec un confort adapté pour la cuisine ou le bureau. Un classique revisité avec style.',
                'slug'=>'chaise7',
                'image_path' => 'produits/product_4.png',
                'image2_path' => 'produits/product_4.png',
                'image3_path' => 'produits/product_4.png',
                'prix' => 27,
                'en_reduction' => false,
                'is_pinned' => false,
                'reduction_pct' => null,
                'stock' => 30,
                'couleur_id' => 13, // Autre
                'categorie_id' => 1, // Chaises
                'created_at' => now(),
                'updated_at' => now(),
            ],
            //12
            [
                'titre' => 'Chaise blanche',
                'description' => 'Chaise blanche avec accoudoirs, très confortable et élégante. Un meuble polyvalent pour la salle à manger ou un bureau moderne.',
                'slug'=>'chaise8',
                'image_path' => 'produits/product_5.png',
                'image2_path' => 'produits/product_5.png',
                'image3_path' => 'produits/product_5.png',
                'prix' => 27,
                'en_reduction' => false,
                'is_pinned' => true,
                'reduction_pct' => null,
                'stock' => 5,
                'couleur_id' => 1, 
                'categorie_id' => 1, // Chaises
                'created_at' => now(),
                'updated_at' => now(),
            ],
            //13
            [
                'titre' => 'Chaise vert nature',
                'description' => 'Chaise vert olive au design naturel, parfaite pour une cuisine ou un espace repas lumineux. Confort et esthétisme sont réunis.',
                'slug'=>'chaise9',
                'image_path' => 'produits/product_6.png',
                'image2_path' => 'produits/product_6.png',
                'image3_path' => 'produits/product_6.png',
                'prix' => 30,
                'en_reduction' => false,
                'is_pinned' => false,
                'reduction_pct' => null,
                'stock' => 7,
                'couleur_id' => 8, 
                'categorie_id' => 1, // Chaises
                'created_at' => now(),
                'updated_at' => now(),
            ],
            //14
            [
                'titre' => 'Chaise blanche',
                'description' => 'Chaise blanche au style minimaliste, confortable et pratique. Un choix simple mais élégant pour tout type d’intérieur.',
                'slug'=>'chaise10',
                'image_path' => 'produits/product_7.png',
                'image2_path' => 'produits/product_7.png',
                'image3_path' => 'produits/product_7.png',
                'prix' => 21,
                'en_reduction' => false,
                'is_pinned' => false,
                'reduction_pct' => null,
                'stock' => 4,
                'couleur_id' => 1, 
                'categorie_id' => 1, // Chaises
                'created_at' => now(),
                'updated_at' => now(),
            ],
            //15
            [
                'titre' => 'Chaise rouge',
                'description' => 'Chaise rouge au design contemporain, parfaite pour apporter une touche de couleur vive à votre salon ou salle à manger. Confort et style garantis.',
                'slug'=>'chaise11',
                'image_path' => 'produits/product_8.png',
                'image2_path' => 'produits/product_8.png',
                'image3_path' => 'produits/product_8.png',
                'prix' => 21,
                'en_reduction' => false,
                'is_pinned' => true,
                'reduction_pct' => null,
                'stock' => 13,
                'couleur_id' => 6, 
                'categorie_id' => 1, // Chaises
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
