<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class EnrollmentController extends Controller
{
    public function index(): View
    {
        $enrollments = Enrollment::query()
            ->with(['user', 'course'])
            ->withCount('payments')
            ->latest('enrolled_at')
            ->paginate(20);

        return view('enrollments.index', compact('enrollments'));
    }

    public function store(Request $request, Course $course): RedirectResponse
    {
        abort_unless($request->user()->isStudent()
            || $request->user()->can('enrollments.create'), 403);
        abort_unless($course->is_published, 404);

        $enrollment = DB::transaction(function () use ($course, $request): ?Enrollment {
            $lockedCourse = Course::query()
                ->whereKey($course->id)
                ->lockForUpdate()
                ->firstOrFail();

            $existingEnrollment = Enrollment::query()
                ->where('user_id', $request->user()->id)
                ->where('course_id', $lockedCourse->id)
                ->first();

            if ($existingEnrollment !== null) {
                return null;
            }

            $enrollment = $request->user()->enrollments()->create([
                'course_id' => $lockedCourse->id,
                'status' => (float) $lockedCourse->price > 0 ? 'pending' : 'active',
            ]);

            if ((float) $lockedCourse->price > 0) {
                $enrollment->payments()->create([
                    'user_id' => $request->user()->id,
                    'amount' => $lockedCourse->price,
                    'method' => 'manual',
                    'status' => 'pending',
                    'notes' => 'بانتظار تأكيد المدير للدفع اليدوي.',
                ]);
            }

            return $enrollment;
        });

        if ($enrollment === null) {
            return redirect()
                ->route('course.show', $course)
                ->with('success', 'لديك تسجيل سابق في هذا الكورس.');
        }

        $message = (float) $course->price > 0
            ? 'تم إنشاء التسجيل، والدفع اليدوي معلّق حتى يؤكده المدير.'
            : 'تم تسجيلك في الكورس المجاني بنجاح.';

        return redirect()
            ->route('course.show', $course)
            ->with('success', $message);
    }
}
