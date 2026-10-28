<?php
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(['prefix' => LaravelLocalization::setLocale()], function()
{


Route::prefix('task')->controller(TaskController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/about', 'about')->name('about');
    Route::get('/admissions', 'admissions')->name('admissions');
    Route::get('/contact', 'contact')->name('contact');
    Route::get('/course_single', 'course_single')->name('course_single');
    Route::get('/courses', 'courses')->name('courses');
    Route::get('/course/{course}', 'courseDetails')->name('course.show');

    Route::get('/news_single', 'news_single')->name('news_single');
    Route::post('/contact', 'contact_data')->middleware('throttle:5,1');
     Route::post('/email', 'email')->middleware('throttle:5,1')->name('email');

});

});
