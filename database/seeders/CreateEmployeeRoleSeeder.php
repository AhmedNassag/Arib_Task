<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateEmployeeRoleSeeder extends Seeder
{
    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
    
        $role = Role::create(['name' => 'Employee']);

        $permissions = Permission::where('name', 'عرض المهمات')->pluck('id','name')->all();

        $role->syncPermissions($permissions);

    }
}