<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddRoles extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Db::table('roles')->insert([
            [
                'alias' => 'admin',
                'title' => 'Admin',
            ],
            [
                'alias' => 'user',
                'title' => 'User',
            ],
            [
                'alias' => 'manager',
                'title' => 'Manager',
            ],
            [
                'alias' => 'moderator',
                'title' => 'Moderator',
            ],
        ]);
    }
}
