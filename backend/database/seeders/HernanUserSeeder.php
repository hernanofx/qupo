<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class HernanUserSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate([
            'email' => 'hernan@hernan.com',
        ], [
            'name' => 'Hernan',
            'email' => 'hernan@hernan.com',
            'password' => Hash::make('12345678'),
            'email_verified_at' => now(),
            'role' => 'merchant'
        ]);
    }
}
