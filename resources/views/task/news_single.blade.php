@extends('layouts.sh')
@section('content')

<div class="site-section ftco-subscribe-1 site-blocks-cover pb-4" style="background-image: url({{ asset('font/images/bg_1.jpg') }})">
    <div class="container">
      <div class="row align-items-end">
        <div class="col-lg-7">
          <h2 class="mb-0">{{ __('site.training_camp') }}</h2>
          <p>{{ __('site.news_date_by_admin') }}</p>
        </div>
      </div>
    </div>
</div>


<div class="custom-breadcrumns border-bottom">
  <div class="container">
    <a href="{{ url('/') }}">{{ __('site.home') }}</a>
    <span class="mx-3 icon-keyboard_arrow_right"></span>
    <span class="current">{{ __('site.news') }}</span>
  </div>
</div>

<div class="site-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9 mb-4">
                <p class="mb-5">
                    <img src="{{ asset('font/images/course_5.jpg') }}" alt="Image" class="img-fluid">
                </p>

                <p>{{ __('site.news_article_paragraph_1') }}</p>

                <p>{{ __('site.news_article_paragraph_2') }}</p>

                <p>{{ __('site.news_article_paragraph_3') }}</p>

                <p>{{ __('site.news_article_paragraph_4') }}</p>

                <p>{{ __('site.news_article_paragraph_5') }}</p>
            </div>

        </div>
    </div>
</div>

<div class="section-bg style-1" style="background-image: url('{{ asset('font/images/hero_1.jpg') }}');">
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
