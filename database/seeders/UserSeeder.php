<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role_id' => 1,
                'phone' =>"0477 88 99 00",
                'photo' => 'profil_pic/admin.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'User',
                'email' => 'user@example.com',
                'password' => Hash::make('password'),
                'role_id' => 2,
                'phone' =>"0434 88 12 24",
                'photo' => 'profil_pic/user.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Rédacteur',
                'email' => 'redacteur@example.com',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'phone' =>"0494 38 34 01",
                'photo' => 'profil_pic/redacteur.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Webmaster',
                'email' => 'webmaster@example.com',
                'password' => Hash::make('password'),
                'role_id' => 4,
                'phone' =>"0123 48 14 44",
                'photo' => 'profil_pic/webmasteur.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Agent',
                'email' => 'agent@example.com',
                'password' => Hash::make('password'),
                'role_id' => 5,
                'phone' =>"0444 48 44 24",
                'photo' => 'profil_pic/agent.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
