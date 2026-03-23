<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@mitraabadimetalindo.com'],
            [
                'name'     => 'Administrator',
                'email'    => 'admin@mitraabadimetalindo.com',
                'password' => Hash::make('Admin@MAM2024!'),
                'is_admin' => true,
            ]
        );

        $this->command->info('Admin user created:');
        $this->command->info('  Email    : admin@mitraabadimetalindo.com');
        $this->command->info('  Password : Admin@MAM2024!');
        $this->command->warn('  ⚠ Segera ganti password setelah login pertama!');
    }
}