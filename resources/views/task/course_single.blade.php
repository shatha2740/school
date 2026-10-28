@extends("layouts.sh")
@section('content')
<div class="site-section ftco-subscribe-1 site-blocks-cover pb-4" style="background-image: url({{ asset('font/images/bg_1.jpg') }})">
    <div class="container">
      <div class="row align-items-end">
        <div class="col-lg-7">
          <h2 class="mb-0">{{ __('site.create_mobile_apps') }}</h2>
          <p>{{ __('site.course_detail_intro') }}</p>
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
    <span class="current">{{ __('site.courses') }}</span>
  </div>
</div>

<div class="site-section">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mb-4">
                <p>
                    <img src="{{ asset('font/images/course_5.jpg') }}" alt="Image" class="img-fluid">
                </p>
            </div>
            <div class="col-lg-5 ml-auto align-self-center">
                <h2 class="section-title-underline mb-5">
                    <span>{{ __('site.course_details') }}</span>
                </h2>

                <p><strong class="text-black d-block">{{ __('site.teacher') }}:</strong> Craig Daniel</p>
                <p class="mb-5"><strong class="text-black d-block">{{ __('site.hours') }}:</strong> 8:00 am &mdash; 9:30am</p>

                <p>{{ __('site.course_detail_paragraph_1') }}</p>
                <p>{{ __('site.course_detail_paragraph_2') }}</p>

                <ul class="ul-check primary list-unstyled mb-5">
                    <li>{{ __('site.course_detail_topic_1') }}</li>
                    <li>{{ __('site.course_detail_topic_2') }}</li>
                    <li>{{ __('site.course_detail_topic_3') }}</li>
                    <li>{{ __('site.course_detail_topic_4') }}</li>
                    <li>{{ __('site.course_detail_topic_5') }}</li>
                </ul>

                <p>
                    <a href="#" class="btn btn-primary rounded-0 btn-lg px-5">{{ __('site.enroll_in_course') }}</a>
                </p>

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
