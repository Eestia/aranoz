<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdresseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::find(1); 

        $user->adresses()->create([
            'rue'         => 'Rue Victor Hugo',
            'numero'      => '12B',
            'ville'       => 'Lyon',
            'code_postal' => '69001',
            'pays'        => 'France',
            'code_pays'   => 'FR',
        ]);
    }
}
