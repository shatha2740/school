<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Instructor;
use App\Models\Lesson;
use App\Models\Payment;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // الأدوار فقط، بدون صلاحيات
        $isAdmin      = $user->hasRole('admin');
        $isInstructor = $user->hasRole('instructor') && $user->instructor !== null;
        $isStudent    = $user->hasRole('student');
        $instructorId = $user->instructor?->id;

        $courses = Course::query();
        if (! $isAdmin && $isInstructor && $instructorId !== null) {
            $courses->where('instructor_id', $instructorId);
        } elseif (! $isAdmin && $isStudent) {
            $courses->whereHas('enrollments', fn (Builder $enrollments) => $enrollments
                ->where('user_id', $user->id));
        } elseif (! $isAdmin) {
            $courses->whereRaw('1 = 0');
        }

        $courseIds = (clone $courses)->select('id');

        $stats = [
            'students' => $isAdmin
                ? $this->studentsQuery()->count()
                : $this->studentsQuery()
                    ->whereHas('enrollments', fn (Builder $enrollments) => $enrollments
                        ->whereIn('course_id', $courseIds))
                    ->count(),
            'instructors' => $isAdmin ? Instructor::query()->count() : ($isInstructor ? 1 : 0),
            'courses' => (clone $courses)->count(),
            'published_courses' => (clone $courses)->where('is_published', true)->count(),
            'lessons' => Lesson::query()->whereIn('course_id', $courseIds)->count(),
            'assignments' => Assignment::query()->whereIn('course_id', $courseIds)->count(),
            'enrollments' => Enrollment::query()->whereIn('course_id', $courseIds)->count(),
            'pending_submissions' => Submission::query()
                ->where('status', 'submitted')
                ->when($isStudent, fn (Builder $submissions) => $submissions
                    ->where('user_id', $user->id))
                ->whereHas('assignment', fn (Builder $assignments) => $assignments
                    ->whereIn('course_id', $courseIds))
                ->count(),
            'successful_payments' => $isAdmin
                ? Payment::query()->where('status', 'confirmed')->count()
                : 0,
            'pending_payments' => $isAdmin
                ? Payment::query()->where('status', 'pending')->count()
                : 0,
            'revenue' => $isAdmin
                ? Payment::query()->where('status', 'confirmed')->sum('amount')
                : 0,
        ];

        $latestEnrollments = $isAdmin
            ? Enrollment::query()->with(['user', 'course'])->latest('enrolled_at')->take(8)->get()
            : collect();

        $latestPayments = $isAdmin
            ? Payment::query()->with(['user', 'enrollment.course'])->latest()->take(8)->get()
            : collect();

        $myEnrollments = $isStudent
            ? $user->enrollments()->with(['course', 'payments'])->latest('enrolled_at')->take(10)->get()
            : collect();

        $myPayments = $isStudent
            ? $user->payments()->with('enrollment.course')->latest()->take(10)->get()
            : collect();

        $instructorCourses = $isInstructor && $instructorId !== null
            ? Course::query()->where('instructor_id', $instructorId)->withCount('enrollments')->latest()->take(10)->get()
            : collect();

        $latestSubmissionsQuery = Submission::query()
            ->with(['user', 'assignment.course'])
            ->whereHas('assignment', fn (Builder $assignments) => $assignments
                ->whereIn('course_id', $courseIds));

        if (! $isAdmin && $isStudent) {
            $latestSubmissionsQuery->where('user_id', $user->id);
        }

        $latestSubmissions = $latestSubmissionsQuery
            ->latest('submitted_at')
            ->take(8)
            ->get();

        $monthlyRegistrations = [];
        $monthlyRevenue = [];

        if ($isAdmin) {
            for ($monthOffset = 5; $monthOffset >= 0; $monthOffset--) {
                $month = now()->startOfMonth()->subMonths($monthOffset);
                $start = $month->copy();
                $end = $month->copy()->endOfMonth();
                $key = $month->format('Y-m');

                $monthlyRegistrations[$key] = Enrollment::query()
                    ->whereBetween('enrolled_at', [$start, $end])
                    ->count();

                $monthlyRevenue[$key] = (float) Payment::query()
                    ->where('status', 'confirmed')
                    ->whereBetween('paid_at', [$start, $end])
                    ->sum('amount');
            }
        }

        return view('dashboard', compact(
            'isAdmin',
            'stats',
            'latestEnrollments',
            'latestPayments',
            'latestSubmissions',
            'myEnrollments',
            'myPayments',
            'instructorCourses',
            'monthlyRegistrations',
            'monthlyRevenue',
        ));
    }

    private function studentsQuery(): Builder
    {
        return User::role('student');
    }
}
