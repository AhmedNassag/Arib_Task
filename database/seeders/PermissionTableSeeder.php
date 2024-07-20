<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'صلاحيات المستخدمين',
            //المستخدمين
            'عرض المستخدمين',
            'إضافة المستخدمين',
            'تعديل المستخدمين',
            'حذف المستخدمين',
            'تغيير حالة المستخدمين',

            //الصلاحيات
            'عرض الصلاحيات',
            'إضافة الصلاحيات',
            'تعديل الصلاحيات',
            'حذف الصلاحيات',

            //الأقسام
            'عرض الأقسام',
            'إضافة الأقسام',
            'تعديل الأقسام',
            'حذف الأقسام',

            //المهمات
            'عرض المهمات',
            'إضافة المهمات',
            'تعديل المهمات',
            'حذف المهمات',
            'تغيير حالة المهمات',

        ];



        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
