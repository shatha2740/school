<?php
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\AssignmentController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EnrollmentController;
use App\Http\Controllers\Admin\InstructorController;
use App\Http\Controllers\Admin\LessonController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\StudentCourseController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
Route::group(['prefix' => LaravelLocalization::setLocale()], function (): void {



    Route::get('/', [TaskController::class, 'index']);

    Route::get('/course/{course}/enroll', [TaskController::class, 'beginEnrollment'])
        ->name('course.enroll.start');
    Route::middleware('auth')->group(function (): void {
        Route::get('/dashboard', DashboardController::class)->name('dashboard');
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::post('/course/{course}/enroll', [EnrollmentController::class, 'store'])
            ->name('course.enroll');
Route::post('/courses/{course}/checkout', [CheckoutController::class, 'checkout'])->name('course.checkout');
Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
        Route::get('/submissions', [SubmissionController::class, 'index'])
            ->name('submissions.index');
        Route::post('/assignments/{assignment}/submissions', [SubmissionController::class, 'store'])
            ->name('submissions.store');
        Route::get('/submissions/{submission}/download', [SubmissionController::class, 'download'])
            ->name('submissions.download');
        Route::put('/submissions/{submission}/grade', [SubmissionController::class, 'grade'])
            ->name('submissions.grade');
        Route::prefix('dashboard')->group(function (): void {

            Route::resource('courses', CourseController::class);
            Route::resource('courses.lessons', LessonController::class)->except('show');
            Route::resource('courses.assignments', AssignmentController::class)->except('show');
            Route::resource('instructors', InstructorController::class);

            Route::get('enrollments', [EnrollmentController::class, 'index'])
                ->name('enrollments.index');

            Route::get('payments', [AdminPaymentController::class, 'index'])
                ->name('payments.index');
            Route::patch('payments/{payment}/confirm',[AdminPaymentController ::class, 'confirm'])
                ->name('payments.confirm');
                Route::get('/my-courses', [StudentCourseController::class, 'index'])->name('student.courses');
Route::get('/my-courses/{course}', [StudentCourseController::class, 'show'])->name('student.course');
Route::get('messages', [TaskController::class, 'messages'])->name('messages.index')
        ->middleware('role:admin');
        Route::get('/messages/{message}', [TaskController::class, 'showMessage'])->name
    ('messages.show')->middleware('role:admin');
    });
    });

    require __DIR__ . '/auth.php';
});
