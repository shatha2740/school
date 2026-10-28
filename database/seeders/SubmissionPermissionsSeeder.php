<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
class SubmissionPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إنشاء الصلاحيات
        $permissions = [
            'submissions.view.own',
            'submissions.view.any',
            'submissions.create',
            'submissions.grade',
            'submissions.download.own-course',
            'submissions.download.any',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        $instructor = Role::where('name', 'instructor')
            ->where('guard_name', 'web')
            ->first();

        if ($instructor) {
            $instructor->givePermissionTo([
                'submissions.view.own',
                'submissions.grade',
                'submissions.download.own-course',
            ]);
        }

        $student = Role::where('name', 'student')
            ->where('guard_name', 'web')
            ->first();

        if ($student) {
            $student->givePermissionTo([
                'submissions.create',
                'submissions.view.own',
            ]);
        }

        $admin = Role::where('name', 'admin')
            ->where('guard_name', 'web')
            ->first();

        if ($admin) {
            $admin->givePermissionTo([
                'submissions.view.any',
                'submissions.grade',
                'submissions.download.any',
            ]);
        }
    }
}


