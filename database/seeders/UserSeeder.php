<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Constants\RoleConstants;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'isacc',
            'email' => 'isacc@gmail.com',
            'password' => bcrypt('isacc123')
        ]);
        $user->assignRole(RoleConstants::ADMINISTRADOR);
    }
}
