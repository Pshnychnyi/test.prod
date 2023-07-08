<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddRoleUser extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Db::table('role_user')->insert([
            [
                'role_id' => '1',
                'user_id' => '1'
            ]
        ]);
    }
}
