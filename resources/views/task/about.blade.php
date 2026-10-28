@extends('layouts.sh')
@section("content")
<div class="site-section ftco-subscribe-1 site-blocks-cover pb-4" style="background-image: url({{ asset('font/images/bg_1.jpg') }})">
    <div class="container">
      <div class="row align-items-end">
        <div class="col-lg-7">
          <h2 class="mb-0">{{ __('site.about') }}</h2>
          <p>{{ __('site.about_intro_text') }}</p>
        </div>
      </div>
    </div>
  </div>


<div class="custom-breadcrumns border-bottom">
  <div class="container">
    <a href="#">{{ __('site.home') }}</a>
    <span class="mx-3 icon-keyboard_arrow_right"></span>
    <span class="current">{{ __('site.about') }}</span>
  </div>
</div>

<div class="container pt-5 mb-5">
    <div class="row">
      <div class="col-lg-4">
        <h2 class="section-title-underline">
          <span>{{ __('site.academics_history') }}</span>
        </h2>
      </div>
      <div class="col-lg-4">
        <p>{{ __('site.academics_history_paragraph_1') }}</p>
      </div>
      <div class="col-lg-4">
        <p>{{ __('site.academics_history_paragraph_2') }}</p>
      </div>
    </div>
  </div> -->

<div class="site-section">
    <div class="container">
        <div class="row mb-5">
            <div class="col-lg-6 mb-lg-0 mb-4">
                <img src="{{ asset('font/images/course_4.jpg') }}" alt="Image" class="img-fluid">
            </div>
            <div class="col-lg-5 ml-auto align-self-center">
                <h2 class="section-title-underline mb-5">
                    <span>{{ __('site.why_academics_works') }}</span>
                </h2>
                <p>{{ __('site.about_feature_paragraph_1') }}</p>
                <p>{{ __('site.about_feature_paragraph_2') }}</p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 order-1 order-lg-2 mb-4 mb-lg-0">
                <img src="{{ asset('font/images/course_5.jpg') }}" alt="Image" class="img-fluid">
            </div>
            <div class="col-lg-5 mr-auto align-self-center order-2 order-lg-1">
                <h2 class="section-title-underline mb-5">
                    <span>{{ __('site.personalized_learning') }}</span>
                </h2>
                <p>{{ __('site.personalized_learning_desc') }}</p>
                <p>{{ __('site.about_feature_paragraph_2') }}</p>
            </div>
        </div>
    </div>
</div>

<div class="section-bg style-1" style="background-image: url({{ asset('font/images/hero_1.jpg') }});">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-md-6 mb-5 mb-lg-0">
          <span class="icon flaticon-mortarboard"></span>
          <h3>{{ __('site.our_philosophy') }}</h3>
          <p>{{ __('site.our_philosophy_desc') }}</p>
        </div>
        <div class="col-lg-4 col-md-6 mb-5 mb-lg-0">
          <span class="icon flaticon-school-material"></span>
          <h3>{{ __('site.academic_principles') }}</h3>
          <p>{{ __('site.academic_principles_desc') }}</p>
        </div>
        <div class="col-lg-4 col-md-6 mb-5 mb-lg-0">
          <span class="icon flaticon-library"></span>
          <h3>{{ __('site.key_to_success') }}</h3>
          <p>{{ __('site.key_to_success_desc') }}</p>
        </div>
      </div>
    </div>
  </div>
<section class="site-section">
  <div class="container">

    {{-- عنوان القسم --}}
    <div class="row mb-5 justify-content-center text-center">
      <div class="col-lg-4 mb-5">
        <h2 class="section-title-underline mb-5">
          <span>{{ __('site.our_teachers') }}</span>
        </h2>
      </div>
    </div>

    {{-- بطاقات المدربين --}}
    <div class="row">
      @forelse ($instructors as $instructor)
        @php
          $photo = $instructor->image
              ? asset($instructor->image)
              : asset('font/images/person_1.jpg');
        @endphp

        <div class="col-lg-4 col-md-6 mb-5">
          <div class="feature-1 border person text-center h-100 d-flex flex-column">

            <img src="{{ $photo }}"
                 alt="{{ $instructor->name }}"
                 class="img-fluid">

            <div class="feature-1-content flex-grow-1">
              <h2>{{ $instructor->name }}</h2>

              <span class="position mb-3 d-block">

                {{ $instructor->specialization?? __('site.math_teacher') }}
              </span>

              <p>{{ \Illuminate\Support\Str::limit($instructor->bio ?? __('site.teacher_bio'), 110) }}</p>
            </div>

            <div class="border-top py-3 bg-light">
              <span class="icon-book mx-1"></span>
              <strong>{{ $instructor->courses_count }}</strong>
              {{ __('site.courses') }}
            </div>

          </div>
        </div>

      @empty
        <div class="col-12 text-center">
          <p class="text-muted">{{ __('site.no_teachers') }}</p>
        </div>
      @endforelse
    </div>

  </div>
</section>

<div class="site-section ftco-subscribe-1" style="background-image: url({{ asset('font/images/bg_1.jpg') }})">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-7">
        <h2>{{ __('site.subscribe_to_us') }}</h2>
        <p>{{ __('site.subscribe_desc') }}</p>
      </div>
      <div class="col-lg-5">
        <form action="" class="d-flex">
          <input type="text" class="rounded form-control mr-2 py-3" placeholder="{{ __('site.enter_your_email') }}">
          <button class="btn btn-primary rounded py-3 px-4" type="submit">{{ __('site.send') }}</button>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection
