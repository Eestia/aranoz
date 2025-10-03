<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdresseSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::find(1); // Admin

        if ($user) {
            $user->adresse()->create([
                'rue'         => 'Place de la minoterie',
                'numero'      => '10',
                'ville'       => 'Molenbeek',
                'code_postal' => '1080',
                'pays'        => 'Belgique',
                'code_pays'   => 'BE',
            ]);
        }
    }
}
