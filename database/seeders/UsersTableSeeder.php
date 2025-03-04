<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'niltondeveloper96@gmail.com',
            'email_verified_at' => now(),
            'role' => 'Administrador',
            'password' => Hash::make('12345678'),
            'remember_token' => Str::random(10),
            'status' => 'Activo',
        ]);
    }
}
