<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddPermissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Db::table('permissions')->insert([
            [
                'alias' => 'SUPER_ADMINISTRATOR',
                'title' => 'Super Administrator',
            ],
            [
                'alias' => 'ROLE_ACCESS',
                'title' => 'Role Access',
            ],
            [
                'alias' => 'USER_ACCESS',
                'title' => 'User Access',
            ],
            [
                'alias' => 'CAR_ACCESS',
                'title' => 'Car Access',
            ],
        ]);
    }

}
