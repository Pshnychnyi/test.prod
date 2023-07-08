<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        if (!DB::table('permissions')->exists()) {
            $this->call(AddPermissions::class);
        }

        if (!DB::table('roles')->exists()) {
            $this->call(AddRoles::class);
        }

        if (!DB::table('permission_role')->exists()) {
            $this->call(AddPermissionRole::class);
        }

        if (!DB::table('users')->exists()) {
            $this->call(AddUser::class);
        }

        if (!DB::table('role_user')->exists()) {
            $this->call(AddRoleUser::class);
        }
    }
}
