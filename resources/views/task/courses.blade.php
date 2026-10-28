@extends('layouts.sh')

@section('content')
<div class="site-section ftco-subscribe-1 site-blocks-cover pb-4"
     style="background-image: url({{ asset('font/images/bg_1.jpg') }})">
    <div class="container">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <span class="badge badge-light px-3 py-2 mb-3">🎓 {{ __('site.academics_university') }}</span>
                <h1 class="mb-3 text-white">{{ __('site.our_courses') }}</h1>
                <p class="text-white mb-4">{{ __('site.courses_header_desc') }}</p>
            </div>
        </div>
    </div>
</div>

<div class="custom-breadcrumns border-bottom">
    <div class="container">
        <a href="{{ route('index') }}">{{ __('site.home') }}</a>
        <span class="mx-3 icon-keyboard_arrow_right"></span>
        <span class="current">{{ __('site.courses') }}</span>
    </div>
</div>

<section class="py-5" style="background:#f5f8fc;">
    <div class="container">
        <div class="text-center mb-5">
            <span class="text-uppercase font-weight-bold" style="color:#3986b7; letter-spacing:2px;">
                {{ __('site.learn_and_grow') }}
            </span>
            <h2 class="font-weight-bold mt-2 mb-3" style="color:#183b56;">
                {{ __('site.explore_our_courses') }}
            </h2>
            <p class="text-muted mx-auto" style="max-width:600px;">{{ __('site.explore_courses_desc') }}</p>
            <div style="width:60px;height:4px;background:#3986b7;margin:20px auto;border-radius:5px;"></div>
        </div>

        <div class="row">
            @forelse ($courses as $course)
                <div class="col-lg-4 col-md-6 mb-4">
                    <article class="course-card bg-white h-100">
                        <div class="course-image">
                            <img src="{{ $course->imageUrl() ?? asset('font/images/course_1.jpg') }}"
                                 alt="{{ $course->localized('title') }}">
                            <span class="course-category">{{ $course->localized('category') }}</span>
                        </div>
                        <div class="p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="course-label">{{ $course->instructor?->name ?? __('site.instructors') }}</span>
                                <span class="course-level">{{ $course->localized('level') }}</span>
                            </div>
                            <h3 class="course-title">{{ $course->localized('title') }}</h3>
                            <p class="text-muted course-description">{{ $course->localized('short_description') }}</p>
                            <div class="course-info">
                                <span>⏱ {{ $course->duration_weeks ?? '—' }} {{ __('site.weeks') }}</span>
                                <strong class="course-price">{{ number_format((float) $course->price, 2) }}</strong>
                            </div>
                            <hr>
                            <a href="{{ route('course.show', $course) }}" class="btn course-btn">
                                {{ __('site.view_course') }} →
                            </a>
                            <a href="{{ route('course.enroll.start', $course) }}" class="btn btn-outline-primary ml-2">
                                {{ app()->getLocale() === 'ar' ? 'التسجيل' : 'Enroll' }}
                            </a>
                        </div>
                    </article>
                </div>
            @empty
                <div class="col-12 py-5 text-center text-muted">
                    {{ __('site.no_courses_available') }}
                </div>
            @endforelse
        </div>

        @if ($courses->hasPages())
            <div class="d-flex justify-content-center mt-4">{{ $courses->links() }}</div>
        @endif

        <div class="course-cta text-center mt-4 p-4 p-md-5">
            <h3 class="font-weight-bold mb-3">{{ __('site.ready_to_start') }}</h3>
            <p class="mb-4">{{ __('site.ready_to_start_desc') }}</p>
            <a href="{{ route('contact') }}" class="btn btn-light btn-lg px-4 font-weight-bold">
                {{ __('site.contact_us') }} →
            </a>
        </div>
    </div>
</section>

<style>
    .course-card { border-radius: 14px; overflow: hidden; border: 1px solid #e8eef4; box-shadow: 0 5px 22px rgba(24, 59, 86, .06); transition: transform .3s ease, box-shadow .3s ease; }
    .course-card:hover { transform: translateY(-7px); box-shadow: 0 14px 32px rgba(24, 59, 86, .13); }
    .course-image { height: 220px; position: relative; overflow: hidden; background: #eaf1f8; }
    .course-image img { width: 100%; height: 100%; object-fit: cover; transition: transform .4s ease; }
    .course-card:hover .course-image img { transform: scale(1.06); }
    .course-category { position: absolute; bottom: 14px; left: 14px; background: #183b56; color: #fff; padding: 7px 12px; border-radius: 5px; font-size: 12px; font-weight: 600; }
    .course-label { font-size: 12px; color: #3986b7; font-weight: 600; }
    .course-level { background: #edf6fb; color: #28739f; padding: 5px 9px; border-radius: 20px; font-size: 11px; }
    .course-title { color: #183b56; font-size: 21px; font-weight: 700; line-height: 1.4; min-height: 58px; }
    .course-description { font-size: 14px; line-height: 1.8; min-height: 76px; }
    .course-info { display: flex; justify-content: space-between; flex-wrap: wrap; gap: 8px; color: #687b8d; font-size: 12px; }
    .course-price { color: #183b56; font-size: 21px; }
    .course-btn { background: #183b56; color: #fff; border-radius: 6px; padding: 10px 15px; font-size: 13px; font-weight: 600; }
    .course-btn:hover { background: #3986b7; color: #fff; }
    .course-cta { background: linear-gradient(135deg, #183b56, #287ba7); border-radius: 14px; color: #fff; }
    .course-cta p { color: #e2edf5; }
    .course-cta .btn { color: #183b56; border-radius: 6px; }
    @media (max-width: 767px) { .course-image { height: 210px; } .course-title, .course-description { min-height: auto; } }
</style>
@endsection
