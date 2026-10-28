<?php

use App\Models\Course;
use App\Models\Instructor;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;

beforeEach(function (): void {
    $this->seed(RolesAndPermissionsSeeder::class);
});

test('instructors can be created and linked to an existing account', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');
    $instructorAccount = User::factory()->create();

    $this->actingAs($admin)
        ->get(route('instructors.create'))
        ->assertOk();

    $response = $this->actingAs($admin)->post(route('instructors.store'), [
        'name' => 'Dr. Ada Lovelace',
        'user_id' => $instructorAccount->id,
        'specialization' => 'Computer Science',
        'bio' => 'Experienced instructor.',
    ]);

    $instructor = Instructor::query()->where('name', 'Dr. Ada Lovelace')->firstOrFail();

    $response->assertRedirect(route('instructors.show', $instructor));
    $this->actingAs($admin)
        ->get(route('instructors.index'))
        ->assertOk()
        ->assertSee($instructor->name);
    $this->actingAs($admin)
        ->get(route('instructors.show', $instructor))
        ->assertOk()
        ->assertSee($instructor->name);
    $this->assertDatabaseHas('instructors', [
        'id' => $instructor->id,
        'user_id' => $instructorAccount->id,
        'name' => 'Dr. Ada Lovelace',
    ]);
    expect($instructorAccount->fresh()->getRoleNames())->toBeEmpty()
        ->and($instructorAccount->fresh()->isStudent())->toBeTrue();
});

test('instructors with assigned courses cannot be deleted', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');
    $instructor = Instructor::factory()->create();
    $course = Course::factory()->create(['instructor_id' => $instructor->id]);

    $response = $this->actingAs($admin)
        ->from(route('instructors.show', $instructor))
        ->delete(route('instructors.destroy', $instructor));

    $response->assertRedirect(route('instructors.show', $instructor));
    $response->assertSessionHasErrors('instructor');
    $this->assertModelExists($instructor);
    $this->assertDatabaseHas('courses', [
        'id' => $course->id,
        'instructor_id' => $instructor->id,
    ]);
});

test('instructors can be updated and deleted when no courses are assigned', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');
    $instructor = Instructor::factory()->create(['name' => 'Original Name']);

    $this->actingAs($admin)
        ->get(route('instructors.edit', $instructor))
        ->assertOk()
        ->assertSee('Original Name');

    $response = $this->actingAs($admin)->put(route('instructors.update', $instructor), [
        'name' => 'Updated Name',
        'specialization' => 'Mathematics',
        'bio' => 'Updated profile.',
    ]);

    $response->assertRedirect(route('instructors.show', $instructor));
    $this->assertDatabaseHas('instructors', [
        'id' => $instructor->id,
        'name' => 'Updated Name',
        'specialization' => 'Mathematics',
    ]);

    $this->actingAs($admin)
        ->delete(route('instructors.destroy', $instructor))
        ->assertRedirect(route('instructors.index'));

    $this->assertDatabaseMissing('instructors', ['id' => $instructor->id]);
});
