<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Instructor;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{

    public function index(Request $request)
    {
        $courses = Course::orderBy('id', 'desc')->paginate(5);

        $coursesCount   = Course::count();
        $publishedCount = Course::where('is_published', true)->count();
        $draftsCount    = Course::where('is_published', false)->count();
        return view('courses.index', compact(
            'courses',
            'coursesCount',
            'publishedCount',
            'draftsCount'
        ));
    }

    public function create()
    {
          $instructors = Instructor::orderBy('id')->get();

        return view('courses.create', compact('instructors'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate($this->rules());

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads/images');
        }
        $data = $this->data($request);

$data['description'] = $data['description_ar'];
$data['title'] = $data['title_ar'];
$data['short_description'] = $data['short_description_ar'] ?? '';


        Course::create($data + ['image' => $path]);

        return redirect()->route('courses.index')
            ->with('success', 'تم إضافة الكورس بنجاح');
    }

    public function show(Course $course)
    {
         $instructors = Instructor::orderBy('id')->get();

$students = $course->students()->paginate(10);
      $course->load('lessons');
        $payments = Payment::with('user')
        ->whereHas('enrollment', function ($query) use ($course) {
            $query->where('course_id', $course->id);
        })
        ->latest()
        ->paginate(10);
        return view('courses.show', compact('instructors','course','students',"payments"));
    }

    public function edit(Course $course)
    {
          $instructors = Instructor::orderBy('id')->get();
        return view('courses.edit', compact('course',"instructors"));
    }

    public function update(Request $request, Course $course): RedirectResponse
    {
       $request->validate($this->rules($course));

        $path = $course->image;
        if ($request->hasFile('image')) {
            if ($course->image) {
                Storage::delete($course->image);
            }
            $path = $request->file('image')->store('uploads/images');
        }

        $course->update($this->data($request) + ['image' => $path]);

        return redirect()->route('courses.index')
            ->with('success', 'تم تحديث الكورس بنجاح');
    }

    public function destroy(Course $course): RedirectResponse
    {
         $hasRelatedData =
            $course->lessons()->exists()
            || $course->assignments()->exists()
            || $course->enrollments()->exists();

        if ($hasRelatedData) {
            return redirect()
                ->route('courses.index')
                ->with(
                    'error',
                    'لا يمكن حذف الكورس لأنه مرتبط بدروس أو واجبات أو تسجيلات.'
                );
        }
        if ($course->image) {
            Storage::delete($course->image);
        }

        $course->delete();

        return redirect()->back()->with('success', 'تم حذف الكورس بنجاح');
    }



    private function rules(?Course $course = null): array
    {
        return [
            'title_en'             => 'required',
            'title_ar'             => 'required',
            'short_description_en' => 'nullable',
            'short_description_ar' => 'nullable',
            'description_en'       => 'nullable',
            'description_ar'       => 'nullable',
            'category'             => 'required|string|max:255',
            'level'                => 'required|in:beginner,intermediate,advanced',
            'price'                => 'required|numeric|min:0',
            'duration_weeks'       => 'required|integer|min:1',
            'is_published'         => 'nullable|boolean',
            'image'                => 'nullable|image',
            'instructor_id' => 'required|exists:instructors,id',
            'slug' => [
    'required',
    'string',
    'max:255',
    'alpha_dash',
    Rule::unique('courses', 'slug')->ignore($course?->id),
],
        ];
    }

    private function data(Request $request): array
    {
        return [
            'title_ar' => $request->title_ar,
             'title_en' => $request->title_en,
            'short_description_ar' => $request->short_description_ar,
          'short_description_en' => $request->short_description_en,
            'description_ar' => $request->description_ar,
             'description_en' => $request->description_en,
            'category'       => $request->category,
            'level'          => $request->level,
            'price'          => $request->price,
            'duration_weeks' => $request->duration_weeks,
            'is_published'   => $request->boolean('is_published'),
             'instructor_id' => $request->instructor_id,
             'slug' => $request->slug,
        ];

    }
}
