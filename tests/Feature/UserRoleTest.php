<?php

use App\Models\Course;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;

test('users no longer have a legacy role column and roleless accounts are students', function () {
    $user = User::factory()->create();

    expect(Schema::hasColumn('users', 'role'))->toBeFalse()
        ->and($user->isStudent())->toBeTrue();

    Role::query()->firstOrCreate(['name' => 'instructor', 'guard_name' => 'web']);
    $user->assignRole('instructor');

    expect($user->fresh()->isStudent())->toBeFalse();

    Role::query()->firstOrCreate(['name' => 'student', 'guard_name' => 'web']);
    $student = User::factory()->create();
    $student->assignRole('student');

    expect($student->isStudent())->toBeTrue();
});

test('an account with a custom role is not treated as a student by default', function () {
    $user = User::factory()->create();
    Role::query()->firstOrCreate(['name' => 'custom-role', 'guard_name' => 'web']);
    $user->assignRole('custom-role');

    expect($user->isStudent())->toBeFalse();
});

test('registered accounts are left without an assigned Spatie role', function () {
    $response = $this->post(route('register'), [
        'name' => 'New Student',
        'email' => 'new-student@example.test',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertRedirect(route('dashboard', absolute: false));

    $user = User::query()->where('email', 'new-student@example.test')->firstOrFail();

    expect($user->getRoleNames())->toBeEmpty()
        ->and($user->isStudent())->toBeTrue();
});

test('roleless student accounts can enroll but cannot access admin course management', function () {
    $user = User::factory()->create();
    $course = Course::factory()->create(['price' => 0, 'is_published' => true]);

    $this->actingAs($user)
        ->post(route('course.enroll', $course))
        ->assertRedirect(route('course.show', $course));

    $this->assertDatabaseHas('enrollments', [
        'user_id' => $user->id,
        'course_id' => $course->id,
        'status' => 'active',
    ]);

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertSee('لوحة الطالب');

    $this->actingAs($user)
        ->get(route('courses.create'))
        ->assertForbidden();
});

test('removing the legacy column preserves old admin and teacher roles in Spatie', function () {
    Schema::table('users', function (Blueprint $table): void {
        $table->string('role')->default('student');
    });

    $admin = User::factory()->create();
    $teacher = User::factory()->create();
    DB::table('users')->where('id', $admin->id)->update(['role' => 'admin']);
    DB::table('users')->where('id', $teacher->id)->update(['role' => 'teacher']);

    $migration = require database_path('migrations/2026_10_23_195547_remove_role_column_from_users_table.php');
    $migration->up();

    expect(Schema::hasColumn('users', 'role'))->toBeFalse()
        ->and($admin->fresh()->hasRole('admin'))->toBeTrue()
        ->and($teacher->fresh()->hasRole('instructor'))->toBeTrue();
});
