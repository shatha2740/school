@extends("layouts.sh")
@section("content")

<div class="site-section ftco-subscribe-1 site-blocks-cover pb-4" style="background-image: url({{ asset('font/images/bg_1.jpg') }})">
    <div class="container">
      <div class="row align-items-end">
        <div class="col-lg-7">
          <h2 class="mb-0">{{ __('site.admissions') }}</h2>
          <p>{{ __('site.admissions_intro_text') }}</p>
        </div>
      </div>
    </div>
  </div>


<div class="custom-breadcrumns border-bottom">
  <div class="container">
    <a href="{{ route('index') }}">{{ __('site.home') }}</a>
    <span class="mx-3 icon-keyboard_arrow_right"></span>
    <span class="current">{{ __('site.admission') }}</span>
  </div>
</div>

<div class="site-section">
    <div class="container">
        <div class="row mb-5">
            <div class="col-lg-6 mb-lg-0 mb-4">
                <img src="{{ asset('font/images/course_6.jpg') }}" alt="Image" class="img-fluid">
            </div>
            <div class="col-lg-5 ml-auto align-self-center">
                <h2 class="section-title-underline mb-5">
                    <span>{{ __('site.college_requirements') }}</span>
                </h2>
                <p>{{ __('site.college_requirements_paragraph_1') }}</p>
                <p>{{ __('site.college_requirements_paragraph_2') }}</p>

                <ol class="ul-check primary list-unstyled">
                    <li>{{ __('site.application_form') }}</li>
                    <li>{{ __('site.high_school_report_card') }}</li>
                    <li>{{ __('site.high_school_transcript') }}</li>
                    <li>{{ __('site.good_moral_character_certificate') }}</li>
                    <li>{{ __('site.two_by_two_picture') }}</li>
                    <li>{{ __('site.one_by_one_picture') }}</li>
                </ol>

            </div>
        </div>

        <div class="row">
                <div class="col-lg-6 order-1 order-lg-2 mb-4 mb-lg-0">
                    <img src="{{ asset('font/images/course_3.jpg') }}" alt="Image" class="img-fluid">
                </div>
                <div class="col-lg-5 mr-auto align-self-center order-2 order-lg-1">
                    <h2 class="section-title-underline mb-5">
                        <span>{{ __('site.transferees') }}</span>
                    </h2>
                    <p>{{ __('site.transferees_paragraph_1') }}</p>
                    <p>{{ __('site.transferees_paragraph_2') }}</p>

                    <ol class="ul-check primary list-unstyled">
                            <li>{{ __('site.application_form') }}</li>
                            <li>{{ __('site.high_school_report_card') }}</li>
                            <li>{{ __('site.high_school_transcript') }}</li>
                            <li>{{ __('site.good_moral_character_certificate') }}</li>
                            <li>{{ __('site.two_by_two_picture') }}</li>
                            <li>{{ __('site.one_by_one_picture') }}</li>
                        </ol>
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



    @endsection
