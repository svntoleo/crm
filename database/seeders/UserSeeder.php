<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@dmix.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Sales user
        User::create([
            'name' => 'Sales User',
            'email' => 'sales@dmix.com',
            'password' => Hash::make('password'),
            'role' => 'sales',
            'email_verified_at' => now(),
        ]);

        // Customer users
        $customer1 = User::create([
            'name' => 'João Silva',
            'email' => 'joao@construtora-silva.com.br',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        $customer2 = User::create([
            'name' => 'Maria Santos',
            'email' => 'maria@logistica-express.com.br',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        // Create customer profiles
        $customer1->customerProfile()->create([
            'cnpj' => '12.345.678/0001-90',
            'company_name' => 'Construtora Silva & Irmãos Ltda',
            'phone' => '+55 11 98765-4321',
            'address' => 'Rua Industrial, 1500',
            'city' => 'São Paulo',
            'postcode' => '01310-100',
            'country' => 'Brazil',
        ]);

        $customer2->customerProfile()->create([
            'cnpj' => '98.765.432/0001-10',
            'company_name' => 'Logística Express Transportes S.A.',
            'phone' => '+55 21 91234-5678',
            'address' => 'Av. Portuária, 2500',
            'city' => 'Rio de Janeiro',
            'postcode' => '20040-020',
            'country' => 'Brazil',
        ]);
    }
}
