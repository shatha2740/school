<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use App\Models\Course;
use App\Models\Instructor;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function index(): View
    {
        $courses = Course::query()
            ->where('is_published', true)
            ->with('instructor')
            ->latest()
            ->take(6)
            ->get();

        $statistics = [
          'students' => User::role('student')->count(),
    'instructors' => Instructor::query()->count(),
    'courses' => Course::query()->where('is_published', true)->count(),
        ];

        return view('task.index', compact('courses', 'statistics'));
    }

    public function about()

    {
         $instructors = Instructor::latest()
        ->withCount('courses')
        ->get();


        return view('task.about',compact('instructors'));
    }
    public function admissions()
    {
        return view('task.admissions');
    }
    public function contact(){

        return view('task.contact');
    }

    public function course_single(){
        return view('task.course_single');
    }
    public function courses(): View
    {
        $courses = Course::query()
            ->where('is_published', true)
            ->with('instructor')
            ->latest()
            ->paginate(9);

        return view('task.courses', compact('courses'));
    }

    public function courseDetails(Course $course,Request $request): View|\Illuminate\Http\RedirectResponse
    {
        abort_unless($course->is_published, 404);

        if (! Auth::check()) {
            session()->put('url.intended', route('course.show', $course));

            return redirect()->route('login')
                ->with(
                    'notice',
                    app()->getLocale() === 'ar'
                        ? 'يجب تسجيل الدخول أولًا لعرض تفاصيل الكورس.'
                        : 'Please log in before viewing course details.',
                );
        }
 $user = $request->user();
         Gate::authorize('view', $course);
        $course->load('instructor');
        $enrollment = $user->enrollments()
            ->whereBelongsTo($course)
            ->with('payments')
            ->first();
        return view('task.course_detail', compact(
            'course',
            'enrollment',
        ));
    }

    public function beginEnrollment(Course $course): \Illuminate\Http\RedirectResponse
    {
        abort_unless($course->is_published, 404);

        if (! Auth::check()) {
            session()->put('url.intended', route('course.show', $course));

            return redirect()->route('login')
                ->with(
                    'notice',
                    app()->getLocale() === 'ar'
                        ? 'يجب تسجيل الدخول أولًا للتسجيل في الكورس.'
                        : 'Please log in before enrolling in this course.',
                );
        }

        return redirect()
            ->route('course.show', $course)
            ->with('enroll_prompt', true);
    }

    public function news_single(){
        return view('task.news_single');
    }

     public function contact_data(Request $request){
         $data = $request->validate([
            'fname'    => 'required|string|min:3|max:100',
            'email'   => 'required|email|max:150|ends_with:.com',
            'lname' => 'required|string|max:150',
            'message' => 'required|string|min:10|max:2000',
            'tel'=>'required|digits:10',
            "file"=>"nullable",
        ]);
      $files = null;

if ($request->hasFile('file')) {
    $files = $request->file('file')->store('uploads/files');
}

$data['file'] = $files;
Message::create([
        'fname'     => $data['fname'],
        'lname'     => $data['lname'],
        'email'     => $data['email'],
        'tel'       => $data['tel'],
        'message'   => $data['message'],
        'file_path' => $files,
    ]);

        Mail::to('shoshogehad29@gmail.com')->send( new ContactMail($data));

         return back()->with('success', 'تم إرسال رسالتك بنجاح!');

    }
public function email(Request $request){
$emails=$request->validate([
    'email'=>'email|required',
]);


         return back()->with('success', 'تم الارسال');
    }
    public function messages()
    {

       $messages = Message::orderBy('is_read', 'asc')->latest()->paginate(15);

    return view('messages.index', compact('messages'));
    }
    public function showMessage(Message $message)
{


    if (! $message->is_read) {
        $message->update(['is_read' => true]);
    }

    return view('messages.show', compact('message'));
}
}
