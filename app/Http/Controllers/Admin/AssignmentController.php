<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AssignmentController extends Controller
{
    public function index(Course $course): View
    {
        $this->authorizeCourse($course);

        $assignments = $course->assignments()
            ->withCount('submissions')
            ->latest()
            ->paginate(20);

        return view('assignments.index', compact('course', 'assignments'));
    }

    public function create(Course $course): View
    {
        $this->authorizeCourse($course);

        $assignment = new Assignment();

        return view('assignments.create', compact('course', 'assignment'));
    }

    public function store(Request $request, Course $course): RedirectResponse
    {
        $this->authorizeCourse($course);

        $course->assignments()->create($request->validate($this->rules()));

        return redirect()
            ->route('courses.show', $course)
            ->with('success', 'تم إنشاء الواجب.');
    }

    public function edit(Course $course, Assignment $assignment): View
    {
        $this->authorizeCourse($course);
        abort_unless($assignment->course_id === $course->id, 404);

        return view('assignments.edit', compact('course', 'assignment'));
    }

    public function update(
        Request $request,
        Course $course,
        Assignment $assignment,
    ): RedirectResponse {
        $this->authorizeCourse($course);
        abort_unless($assignment->course_id === $course->id, 404);

        $assignment->update($request->validate($this->rules()));

        return redirect()
            ->route('courses.show', $course)
            ->with('success', 'تم تحديث الواجب.');
    }

    public function destroy(Course $course, Assignment $assignment): RedirectResponse
    {
        $this->authorizeCourse($course);
        abort_unless($assignment->course_id === $course->id, 404);

        if ($assignment->submissions()->exists()) {
            return back()->withErrors([
                'assignment' => 'لا يمكن حذف واجب له تسليمات محفوظة.',
            ]);
        }

        $assignment->delete();

        return redirect()
            ->route('courses.show', $course)
            ->with('success', 'تم حذف الواجب.');
    }

    /**
     * الصلاحيات معطلة حاليًا.
     * لاحقًا ضع الفحص هنا فقط، مثال:
     * Gate::authorize('update', $course);
     */
    private function authorizeCourse(Course $course): void
    {
        //
    }

    /**
     * @return array<string, array<int, string>>
     */
    private function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:191'],
            'instructions' => ['required', 'string', 'max:20000'],
            'max_score' => ['required', 'numeric', 'gt:0', 'max:999999.99'],
            'due_at' => ['nullable', 'date'],
        ];
    }
}
