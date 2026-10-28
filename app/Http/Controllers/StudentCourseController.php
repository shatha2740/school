<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;

class StudentCourseController extends Controller
{
    public function index(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

    if ($user->isInstructor()) {

        $instructor = $user->instructor;

        abort_unless($instructor, 403);

        $courses = Course::where('instructor_id', $instructor->id)
            ->with('instructor')
            ->latest()
            ->get();

        return view('instructors.courses', compact('courses'));
    }

        $enrollments = $user->enrollments()
            ->where('status', 'active')
            ->with('course.instructor')
            ->latest()
            ->get();

        return view('student.courses', compact('enrollments'));
    }

    public function show(Request $request, Course $course)
    {
        /** @var User $user */
        $user = $request->user();

  if ($user->isInstructor()) {

    $instructor = $user->instructor;

    abort_unless($instructor, 403);

    abort_unless(
        $course->instructor_id == $instructor->id,
        403
    );

    $lessons = $course->lessons()->get();

    $assignments = $course->assignments()
        ->with([
            'submissions.user'
        ])
        ->withCount('submissions')
        ->get();

    return view('instructors.course-content', compact(
        'course',
        'lessons',
        'assignments'
    ));
}
        $isEnrolled = $user->enrollments()
            ->where('course_id', $course->id)
            ->where('status', 'active')
            ->exists();

        abort_unless($isEnrolled, 403);

        $lessons = $course->lessons()->get();

        $assignments = $course->assignments()
            ->with(['submissions' => fn ($q) => $q->where('user_id', $user->id)])
            ->get();

        return view('student.course-content', compact('course', 'lessons', 'assignments'));
    }
}
