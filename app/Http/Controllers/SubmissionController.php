<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreSubmissionRequest;
use App\Http\Requests\GradeSubmissionRequest;
use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SubmissionController extends Controller
{

    public function index(Request $request): View
    {
        $user = $request->user();

        abort_unless($user->isStudent() || $user->can('submissions.view.any') || $user->can('submissions.view.own'), 403);

        $query = Submission::query()
            ->with(['user', 'assignment.course'])
            ->latest('submitted_at');

        if ($user->isStudent()) {
            $query->where('user_id', $user->id);
        } elseif ($user->can('submissions.view.own') && ! $user->can('submissions.view.any')) {
            $query->whereHas('assignment.course.instructor', fn ($q) => $q->where('user_id', $user->id));
        }

        $submissions = $query->paginate(20);

        return view('submissions.index', compact('submissions'));
    }


    public function store(StoreSubmissionRequest $request, Assignment $assignment): RedirectResponse
    {
        $user = $request->user();


        abort_unless($user->enrollments()->where('course_id', $assignment->course_id)->where('status', 'active')->exists(), 403);


        if ($assignment->due_at !== null && $assignment->due_at->isPast()) {
            return back()->withErrors(['assignment' => 'انتهى موعد تسليم هذا الواجب.']);
        }


        $submission = Submission::where('assignment_id', $assignment->id)
            ->where('user_id', $user->id)
            ->first();

        if ($submission?->status === 'graded') {
            return back()->withErrors(['assignment' => 'تم تصحيح هذا الواجب ولا يمكن تعديل التسليم.']);
        }


        $oldFilePath = $submission?->file_path;
        $newFilePath = $request->hasFile('file')
            ? $request->file('file')->store('assignment-submissions')
            : $oldFilePath;


        Submission::updateOrCreate(
            [
                'assignment_id' => $assignment->id,
                'user_id' => $user->id,
            ],
            [
                'answer' => $request->validated('answer'),
                'file_path' => $newFilePath,
                'status' => 'submitted',
                'submitted_at' => now(),
            ]
        );


        if ($request->hasFile('file') && $oldFilePath !== null) {
            Storage::disk('custom')->delete($oldFilePath);
        }

        return back()->with('success', 'تم تسليم الواجب بنجاح.');
    }


    public function grade(GradeSubmissionRequest $request, Submission $submission): RedirectResponse
    {
        $submission->update([
            'score' => $request->validated('score'),
            'instructor_feedback' => $request->validated('instructor_feedback'),
            'status' => 'graded',
            'graded_at' => now(),
        ]);

        return back()->with('success', 'تم حفظ تصحيح الواجب.');
    }


    public function download(Request $request, Submission $submission)
    {
        $submission->load('assignment.course.instructor');
        $user = $request->user();

        $isOwner = $submission->user_id === $user->id;
        $canDownloadAny = $user->can('submissions.download.any');
        $isCourseInstructor = $user->can('submissions.download.own-course')
            && $submission->assignment->course->instructor?->user_id === $user->id;

        abort_unless($isOwner || $canDownloadAny || $isCourseInstructor, 403);
        abort_unless($submission->file_path !== null, 404);

           return response()->download(Storage::disk('custom')->path($submission->file_path));
    }
}
