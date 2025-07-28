<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'role_name' => 'Admin',
                'description' => 'Administrator with full access',
            ],
            [
                'role_name' => 'Cashier',
                'description' => 'Cashier with limited access',
            ],
            [
                'role_name' => 'Staff',
                'description' => 'Chef with basic access',
            ],
            [
                'role_name' => 'Customer',
                'description' => 'Customer with no access',
            ],
        ];

        DB::table('roles')->insert($roles);
    }
}
