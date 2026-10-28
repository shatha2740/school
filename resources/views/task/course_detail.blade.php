
@extends('layouts.sh')

@section('content')
@php
    $isArabic  = app()->getLocale() === 'ar';
    $price     = (float) $course->price;
    $isPaid    = $price > 0;
    $isActive  = $enrollment?->status === 'active';
    $isPending = $enrollment?->status === 'pending';
@endphp
<div class="site-section ftco-subscribe-1 site-blocks-cover pb-4"
     style="background-image: url('{{ asset('font/images/bg_1.jpg') }}')">
    <div class="container">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <h1 class="mb-3 text-white">{{ $course->localized('title') }}</h1>
                @if ($course->localized('short_description'))
                    <p class="text-white mb-4">{{ $course->localized('short_description') }}</p>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="custom-breadcrumns border-bottom">
    <div class="container">
        <a href="{{ route('index') }}">{{ __('site.home') }}</a>
        <span class="mx-3 icon-keyboard_arrow_right"></span>
        <a href="{{ route('courses') }}">{{ __('site.courses') }}</a>
        <span class="mx-3 icon-keyboard_arrow_right"></span>
        <span class="current">{{ $course->localized('title') }}</span>
    </div>
</div>

<section class="site-section">
    <div class="container">

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <p class="mb-1">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="row">
            <div class="col-lg-7 mb-4">
                <img src="{{ $course->imageUrl() ?: asset('font/images/course_1.jpg') }}"
                     alt="{{ $course->localized('title') }}" class="img-fluid rounded">
                <h2 class="mt-4">{{ $course->localized('title') }}</h2>
                <p class="text-muted">{{ $course->localized('description') }}</p>
            </div>
            <aside class="col-lg-4 ml-auto">
                <div class="rounded border p-4">
                    <h3 class="mb-4">{{ __('site.course_details') }}</h3>

                    <p><strong>{{ __('site.teacher') }}:</strong> {{ $course->instructor?->name ?? '—' }}</p>
                    @unless ($isActive)
                        <p>
                            <strong>{{ __('site.course_fee') }}:</strong>
                            @if ($isPaid)
                                ${{ number_format($price, 2) }} USD
                            @else
                                {{ $isArabic ? 'مجاني' : 'Free' }}
                            @endif
                        </p>
                    @endunless

                    <p><strong>{{ __('site.weeks') }}:</strong> {{ $course->duration_weeks ?? '—' }}</p>
                    <p><strong>{{ __('site.level') }}:</strong> {{ $course->localized('level') }}</p>
                    <p><strong>{{ __('site.category') }}:</strong> {{ $course->localized('category') }}</p>

                    <hr>

                    @if ($isActive)

                        {{-- بعد الدفع: رسالة + زر ابدأ فقط --}}
                        <div class="alert alert-success">
                            {{ $isArabic ? 'أنتِ مسجّلة في هذا الكورس.' : 'You are enrolled in this course.' }}
                        </div>
                        <a href="{{ route('student.course', $course) }}" class="btn btn-primary rounded-0 px-4 w-100">
                            {{ $isArabic ? 'ابدأ التعلّم' : 'Start learning' }}
                        </a>

                    @else

                        @if ($isPending)
                            <div class="alert alert-warning">
                                {{ $isArabic ? 'لم تكتمل عملية الدفع بعد.' : 'Your payment has not been completed yet.' }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('course.checkout', $course) }}">
                            @csrf
                            <button type="submit" class="btn btn-primary rounded-0 px-4 w-100">
                                @if ($isPaid)
                                    {{ $isArabic ? 'ادفع وسجّل' : 'Pay & enroll' }} · ${{ number_format($price, 2) }}
                                @else
                                    {{ $isArabic ? 'سجّل مجانًا' : 'Enroll for free' }}
                                @endif
                            </button>
                        </form>
                        @if ($isPaid)
                            <p class="mt-3 small text-muted mb-1">
                                {{ $isArabic ? 'الدفع عبر Stripe.' : 'Payment via Stripe.' }}
                            </p>
                            @if (str_starts_with((string) config('services.stripe.key'), 'pk_test'))
                                <p class="small text-warning mb-0">
                                    {{ $isArabic
                                        ? 'وضع تجريبي: استخدمي البطاقة 4242 4242 4242 4242'
                                        : 'Test mode: use card 4242 4242 4242 4242' }}
                                </p>
                            @endif
                        @endif
                        <a href="{{ route('courses') }}" class="btn btn-outline-primary rounded-0 px-4 mt-3 w-100">
                            {{ __('site.courses') }}
                        </a>

                    @endif
                </div>
            </aside>
        </div>
    </div>
</section>
@endsection
