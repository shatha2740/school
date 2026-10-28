<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class LessonController extends Controller
{
    public function index(Course $course): View
    {
        Gate::authorize('view', $course);

        $lessons = $course->lessons()->paginate(20);

        return view('lessons.index', compact('course', 'lessons'));
    }

    public function create(Course $course,Request $request): View
    {

    Gate::authorize('update', $course);
        $user=$request->user();

        abort_unless($user->can('lessons.create'), 403);
        $lesson = new Lesson();

        return view('lessons.create', compact('course', 'lesson'));
    }

    public function store(Request $request, Course $course): RedirectResponse
    {
        Gate::authorize('update', $course);
        abort_unless($request->user()->can('lessons.create'), 403);
        $validated = $request->validate($this->rules());
        $course->lessons()->create($validated);

        return redirect()
            ->route('courses.show', $course)
            ->with('success', 'تمت إضافة الدرس.');
    }

    public function edit(Course $course, Lesson $lesson,Request $request): View
    {
        Gate::authorize('update', $course);
          $user=$request->user();
        abort_unless($user->can('lessons.edit'), 403);
        abort_unless($lesson->course_id === $course->id, 404);

        return view('lessons.edit', compact('course', 'lesson'));
    }

    public function update(Request $request, Course $course, Lesson $lesson): RedirectResponse
    {
        Gate::authorize('update', $course);
        abort_unless($request->user()->can('lessons.edit'), 403);
        abort_unless($lesson->course_id === $course->id, 404);
        $lesson->update($request->validate($this->rules()));

        return redirect()
            ->route('courses.show', $course)
            ->with('success', 'تم تحديث الدرس.');
    }

    public function destroy(Course $course, Lesson $lesson,Request $request): RedirectResponse
    {
        Gate::authorize('update', $course);
          $user=$request->user();
        abort_unless($user->can('lessons.delete'), 403);
        abort_unless($lesson->course_id === $course->id, 404);
        $lesson->delete();

        return redirect()
            ->route('courses.show', $course)
            ->with('success', 'تم حذف الدرس.');
    }

    /**
     * @return array<string, array<int, string>>
     */
    private function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:191'],
            'content' => ['nullable', 'string'],
            'video_url' => ['nullable', 'url', 'max:2048'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:4294967295'],
            'week_number' => ['required', 'integer', 'min:1', 'max:12'],
        ];
    }
}
