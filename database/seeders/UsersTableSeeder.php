<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            ['id' => 1, 'role' => 'Admin', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'role' => 'Students', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'role' => 'Teacher', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'), // password
                'role_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Rossa',
                'email' => 'rossa@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'), // password
                'role_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
