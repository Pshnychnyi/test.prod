<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AddUser extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Db::table('users')->insert([
            [
                'login' => 'Admin',
                'name' => 'Admin',
                'phone' => '+380000000000',
                'email' => 'admin@admin.com',
                'password' => Hash::make('1111'),
            ]
        ]);
    }
}
