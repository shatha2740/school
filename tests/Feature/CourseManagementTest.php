<?php

use App\Models\Course;
use App\Models\Instructor;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Spatie\Permission\Models\Role;

beforeEach(function (): void {
    $this->seed(RolesAndPermissionsSeeder::class);
});

function validCourseInput(int $instructorId): array
{
    return [
        'title_en' => 'Laravel Fundamentals',
        'title_ar' => 'أساسيات لارافيل',
        'category_en' => 'Development',
        'category_ar' => 'التطوير',
        'description_en' => 'A complete Laravel course.',
        'description_ar' => 'دورة كاملة في لارافيل.',
        'short_description_en' => 'Learn Laravel.',
        'short_description_ar' => 'تعلم لارافيل.',
        'level_en' => 'Beginner',
        'level_ar' => 'مبتدئ',
        'slug_en' => 'laravel-fundamentals',
        'slug_ar' => 'أساسيات-لارافيل',
        'instructor_id' => $instructorId,
        'price' => 25,
        'duration_weeks' => 8,
        'is_published' => 1,
    ];
}

test('course forms list registered instructors and select the current instructor for editing', function () {
    $user = User::factory()->create();
    $user->assignRole('admin');
    $instructor = Instructor::factory()->create(['name' => 'Registered Instructor']);
    $course = Course::factory()->create(['instructor_id' => $instructor->id]);
    $unregisteredName = 'Not in the instructor directory';

    $this->actingAs($user)
        ->get(route('courses.create'))
        ->assertOk()
        ->assertSee('<select id="instructor_id"', false)
        ->assertSee($instructor->name)
        ->assertDontSee($unregisteredName);

    $this->actingAs($user)
        ->get(route('courses.edit', $course))
        ->assertOk()
        ->assertSee('<option value="'.$instructor->id.'"', false)
        ->assertSee('selected', false);

    $this->actingAs($user)
        ->get(route('courses.index'))
        ->assertOk()
        ->assertSee($course->localized('title'));

    $this->actingAs($user)
        ->get(route('courses.show', $course))
        ->assertOk()
        ->assertSee($course->localized('description'));
});

test('instructors with own-course permissions cannot see or edit another instructors course', function () {
    $user = User::factory()->create();
    $user->assignRole('instructor');
    $ownInstructor = Instructor::factory()->create(['user_id' => $user->id]);
    $otherInstructor = Instructor::factory()->create();
    $ownCourse = Course::factory()->create(['instructor_id' => $ownInstructor->id]);
    $otherCourse = Course::factory()->create(['instructor_id' => $otherInstructor->id]);

    $this->actingAs($user)
        ->get(route('courses.index'))
        ->assertOk()
        ->assertSee($ownCourse->localized('title'))
        ->assertDontSee($otherCourse->localized('title'));

    $this->actingAs($user)->get(route('courses.edit', $ownCourse))->assertOk();
    $this->actingAs($user)->get(route('courses.edit', $otherCourse))->assertForbidden();
    $this->actingAs($user)->get(route('courses.create'))->assertForbidden();
});

test('a role without an assigned permission cannot access course management', function () {
    $user = User::factory()->create();
    $user->assignRole(Role::query()->create(['name' => 'course-observer', 'guard_name' => 'web']));

    expect($user->isStudent())->toBeFalse();

    $this->actingAs($user)->get(route('courses.index'))->assertForbidden();
});

test('courses save both translations and the selected instructor id', function () {
    $user = User::factory()->create();
    $user->assignRole('admin');
    $instructor = Instructor::factory()->create();

    $response = $this->actingAs($user)
        ->post(route('courses.store'), validCourseInput($instructor->id));

    $course = Course::query()->latest()->first();

    $response->assertRedirect(route('courses.show', $course));
    $response->assertSessionHas('success');
    $this->assertDatabaseHas('courses', [
        'title' => 'Laravel Fundamentals',
        'title_en' => 'Laravel Fundamentals',
        'title_ar' => 'أساسيات لارافيل',
        'slug' => 'laravel-fundamentals',
        'slug_en' => 'laravel-fundamentals',
        'slug_ar' => 'أساسيات-لارافيل',
        'instructor_id' => $instructor->id,
    ]);
});

test('course submission requires a registered instructor and reports an empty instructor list', function () {
    $user = User::factory()->create();
    $user->assignRole('admin');

    $this->actingAs($user)
        ->get(route('courses.create'))
        ->assertOk()
        ->assertSee('لا يوجد مدربون مسجلون حاليًا');

    $input = validCourseInput(0);
    unset($input['instructor_id']);

    $response = $this->actingAs($user)
        ->from(route('courses.create'))
        ->post(route('courses.store'), $input);

    $response->assertRedirect(route('courses.create'));
    $response->assertSessionHasErrors('instructor_id');
    $this->assertDatabaseCount('courses', 0);
});

test('course submission rejects instructor ids that do not exist', function () {
    $user = User::factory()->create();
    $user->assignRole('admin');

    $response = $this->actingAs($user)
        ->from(route('courses.create'))
        ->post(route('courses.store'), validCourseInput(999999));

    $response->assertRedirect(route('courses.create'));
    $response->assertSessionHasErrors('instructor_id');
    $this->assertDatabaseCount('courses', 0);
});

test('course update keeps its own slugs and changes the instructor', function () {
    $user = User::factory()->create();
    $user->assignRole('admin');
    $oldInstructor = Instructor::factory()->create();
    $newInstructor = Instructor::factory()->create();
    $course = Course::factory()->create(['instructor_id' => $oldInstructor->id]);
    $input = validCourseInput($newInstructor->id);
    $input['slug_en'] = $course->slug_en;
    $input['slug_ar'] = $course->slug_ar;

    $response = $this->actingAs($user)
        ->put(route('courses.update', $course), $input);

    $response->assertRedirect(route('courses.show', $course));
    $this->assertDatabaseHas('courses', [
        'id' => $course->id,
        'title_ar' => 'أساسيات لارافيل',
        'slug_en' => $course->slug_en,
        'slug_ar' => $course->slug_ar,
        'instructor_id' => $newInstructor->id,
    ]);
});

test('course submission rejects duplicate English slugs', function () {
    $user = User::factory()->create();
    $user->assignRole('admin');
    $instructor = Instructor::factory()->create();
    $existingCourse = Course::factory()->create(['slug_en' => 'laravel-fundamentals']);
    $input = validCourseInput($instructor->id);
    $input['slug_en'] = $existingCourse->slug_en;

    $response = $this->actingAs($user)
        ->from(route('courses.create'))
        ->post(route('courses.store'), $input);

    $response->assertRedirect(route('courses.create'));
    $response->assertSessionHasErrors('slug_en');
    $this->assertDatabaseCount('courses', 1);
});

test('course submission rejects duplicate Arabic slugs', function () {
    $user = User::factory()->create();
    $user->assignRole('admin');
    $instructor = Instructor::factory()->create();
    $existingCourse = Course::factory()->create(['slug_ar' => 'تعلم-لارافيل']);
    $input = validCourseInput($instructor->id);
    $input['slug_ar'] = $existingCourse->slug_ar;

    $response = $this->actingAs($user)
        ->from(route('courses.create'))
        ->post(route('courses.store'), $input);

    $response->assertRedirect(route('courses.create'));
    $response->assertSessionHasErrors('slug_ar');
    $this->assertDatabaseCount('courses', 1);
});

test('public course pages redirect guests to login before viewing details', function () {
    $course = Course::factory()->create([
        'title_en' => 'English Course Title',
        'title_ar' => 'عنوان الكورس العربي',
        'short_description_en' => 'English course summary.',
        'short_description_ar' => 'ملخص الكورس العربي.',
        'is_published' => true,
    ]);

    app()->setLocale('ar');

    $this->get(route('courses'))
        ->assertOk()
        ->assertSee('عنوان الكورس العربي');

    $this->get(route('course.show', $course))
        ->assertRedirect(route('login'))
        ->assertSessionHas('notice');
});

test('public course details do not expose unpublished courses', function () {
    $course = Course::factory()->create(['is_published' => false]);

    $this->get(route('course.show', $course))->assertNotFound();
});

test('course content falls back to legacy fields when translations are missing', function () {
    $course = Course::factory()->create([
        'title' => 'Legacy course title',
        'title_en' => null,
        'title_ar' => null,
    ]);

    app()->setLocale('ar');

    expect($course->localized('title'))->toBe('Legacy course title');
});
