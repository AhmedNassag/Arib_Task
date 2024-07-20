<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionTableSeeder::class);
        $this->call(CreateSuperAdminUserSeeder::class);
        $this->call(CreateManagerRoleSeeder::class);
        $this->call(CreateEmployeeRoleSeeder::class);
    }
}
