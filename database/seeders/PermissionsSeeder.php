<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'dashboard.view',
            'courses.view.any',
            'courses.view.own',
            'courses.create',
            'courses.edit.any',
            'courses.edit.own',
            'courses.delete.any',
            'courses.delete.own',
            'lessons.view.any',
            'lessons.view.own',
            'lessons.create',
            'lessons.edit',
            'lessons.delete',
            'assignments.view.any',
            'assignments.view.own',
            'assignments.create',
            'assignments.edit.any',
            'assignments.edit.own',
            'assignments.delete.any',
            'assignments.delete.own',
            'instructors.view',
            'instructors.create',
            'instructors.edit',
            'instructors.delete',
            'enrollments.view',
            'payments.view',
            'payments.confirm',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $instructor = Role::firstOrCreate(['name' => 'instructor', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'student', 'guard_name' => 'web']);

        $admin->syncPermissions($permissions);

        $instructor->syncPermissions([
            'dashboard.view',
            'courses.view.own',
            'courses.create',
            'courses.edit.own',
            'courses.delete.own',
            'lessons.view.own',
            'lessons.create',
            'lessons.edit',
            'lessons.delete',
            'assignments.view.own',
            'assignments.create',
            'assignments.edit.own',
            'assignments.delete.own',
        ]);
    }
}
