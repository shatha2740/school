@extends("layouts.sh")
@section('content')

{{-- ===================== Hero ===================== --}}
<div style="position: relative; width: 100%; line-height: 0;">
    <img src="{{ asset('font/images/hero_1.jpg') }}"
         alt="{{ __('site.Academics Academy') }}"
         style="width: 100%; height: auto; display: block;">

    <div style="position: absolute; top: 50%; left: 0; right: 0;
                transform: translateY(-50%); text-align: center; line-height: 1.2;">
        <h1 style="color: #fff; margin: 0; font-size: clamp(28px, 5vw, 64px);
                   text-shadow: 0 2px 10px rgba(0,0,0,.6);">
            {{ __('site.Academics Academy') }}
        </h1>
    </div>
</div>

{{-- ===================== Why Academics ===================== --}}
<div class="site-section">
  <div class="container">
    <div class="row mb-5 justify-content-center text-center">
      <div class="col-lg-4 mb-5">
        <h2 class="section-title-underline mb-5">
          <span>{{ __('site.why_choose_academics') }}</span>
        </h2>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
        <div class="feature-1 border">
          <div class="icon-wrapper bg-primary">
            <span class="flaticon-mortarboard text-white"></span>
          </div>
          <div class="feature-1-content">
            <h2>{{ __('site.personalized_learning') }}</h2>
            <p>{{ __('site.personalized_learning_desc') }}</p>
            <p><a href="#" class="btn btn-primary px-4 rounded-0">{{ __('site.learn_more') }}</a></p>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
        <div class="feature-1 border">
          <div class="icon-wrapper bg-primary">
            <span class="flaticon-school-material text-white"></span>
          </div>
          <div class="feature-1-content">
            <h2>{{ __('site.trusted_courses') }}</h2>
            <p>{{ __('site.trusted_courses_desc') }}</p>
            <p><a href="#" class="btn btn-primary px-4 rounded-0">{{ __('site.learn_more') }}</a></p>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
        <div class="feature-1 border">
          <div class="icon-wrapper bg-primary">
            <span class="flaticon-library text-white"></span>
          </div>
          <div class="feature-1-content">
            <h2>{{ __('site.tools_for_students') }}</h2>
            <p>{{ __('site.tools_for_students_desc') }}</p>
            <p><a href="#" class="btn btn-primary px-4 rounded-0">{{ __('site.learn_more') }}</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


{{-- ===================== Academy Statistics (new) ===================== --}}
<div class="site-section">
  <div class="container">
    <div class="row mb-5 justify-content-center text-center">
      <div class="col-lg-6">
        <h2 class="section-title-underline mb-3">
          <span>{{ __('site.academics_in_numbers') }}</span>
        </h2>
        <p>{{ __('site.growing_community') }}</p>
      </div>
    </div>

    <div class="row text-center">
      <div class="col-lg-4 col-md-4 mb-4 mb-md-0">
        <span class="flaticon-mortarboard text-primary display-4"></span>
        <h3 class="display-4 font-weight-bold mt-3 mb-1">{{ number_format($statistics['students']) }}</h3>
        <p class="text-uppercase mb-0">{{ __('site.students') }}</p>
      </div>

      <div class="col-lg-4 col-md-4 mb-4 mb-md-0">
        <span class="flaticon-school-material text-primary display-4"></span>
        <h3 class="display-4 font-weight-bold mt-3 mb-1">{{ number_format($statistics['courses']) }}</h3>
        <p class="text-uppercase mb-0">{{ __('site.courses') }}</p>
      </div>

      <div class="col-lg-4 col-md-4">
        <span class="flaticon-library text-primary display-4"></span>
        <h3 class="display-4 font-weight-bold mt-3 mb-1">{{ number_format($statistics['instructors']) }}</h3>
        <p class="text-uppercase mb-0">{{ __('site.instructors') }}</p>
      </div>
    </div>
  </div>
</div>

{{-- ===================== Popular Courses ===================== --}}
<div class="site-section">
  <div class="container">
    <div class="row mb-5 justify-content-center text-center">
      <div class="col-lg-6 mb-5">
        <h2 class="section-title-underline mb-3">
          <span>{{ __('site.popular_courses') }}</span>
        </h2>
        <p>{{ __('site.popular_courses_desc') }}</p>
      </div>
    </div>

    <div class="row">
      @forelse ($courses as $course)
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="course-1-item h-100 d-flex flex-column border bg-white">
            <figure class="thumnail mb-0">
              <a href="{{ route('course.show', $course) }}">
                <img src="{{ $course->imageUrl() ?? asset('font/images/course_1.jpg') }}"
                     alt="{{ $course->localized('title') }}"
                     class="img-fluid w-100"
                     style="height: 220px; object-fit: cover;">
              </a>
              <div class="price" dir="ltr" style="display: inline-flex; align-items: center; gap: 4px;">
    <span>{{ number_format((float) $course->price, 2) }}</span>
    <span>$</span>
</div>

              <div class="category"><h3>{{ $course->localized('category') }}</h3></div>
            </figure>

            <div class="course-1-content pb-4 d-flex flex-column flex-grow-1">
              <h2>{{ $course->localized('title') }}</h2>
              <div class="rating text-center mb-3">
                <span class="icon-user"></span>
                {{ $course->instructor?->name ?? '—' }}
              </div>
              <p class="desc mb-4">{{ $course->localized('short_description') }}</p>
             <div class="d-flex mt-auto px-3">
  <a href="{{ route('course.show', $course) }}"
     class="btn btn-primary rounded-0 flex-fill mx-1 py-2">
    {{ __('site.view_course') }}
  </a>

</div>
            </div>
          </div>
        </div>
      @empty
        <p class="mx-auto py-4 text-center">{{ __('site.no_courses_available') }}</p>
      @endforelse
    </div>
  </div>
</div>

{{-- ===================== About ===================== --}}
<div class="section-bg style-1"
     style="background-image: url('{{ asset('font/images/hero_1.jpg') }}');">
  <div class="container">
    <div class="row">
      <div class="col-lg-4">
        <h2 class="section-title-underline style-2">
          <span>{{ __('site.about_our_academy') }}</span>
        </h2>
      </div>

      <div class="col-lg-8">
        <p>{{ __('site.about_paragraph_1') }}</p>

        <p>{{ __('site.about_paragraph_2') }}</p>

        <p>
          <a href="{{route('about')}}">Read More</a>
        </p>
      </div>
    </div>
  </div>
</div>


{{-- ===================== Testimonials ===================== --}}


  {{-- ===================== Testimonials ===================== --}}
<div class="site-section">
  <div class="container">
    <div class="row mb-5">
      <div class="col-lg-4">
        <h2 class="section-title-underline">
          <span>{{ __('site.testimonials') }}</span>
        </h2>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-6 mb-4">
        <div class="ftco-testimonial-1 h-100">
          <div class="ftco-testimonial-vcard d-flex align-items-center mb-4">
            <img src="{{ asset('font/images/person_1.jpg') }}" alt="Image" class="img-fluid mr-3">
            <div>
              <h3>Allison Holmes</h3>
              <span>{{ __('site.student_web_design') }}</span>
            </div>
          </div>
          <div>
            <p>&ldquo;{{ __('site.testimonial_1') }}&rdquo;</p>
          </div>
        </div>
      </div>

      <div class="col-lg-6 mb-4">
        <div class="ftco-testimonial-1 h-100">
          <div class="ftco-testimonial-vcard d-flex align-items-center mb-4">
            <img src="{{ asset('font/images/person_2.jpg') }}" alt="Image" class="img-fluid mr-3">
            <div>
              <h3>Allison Holmes</h3>
              <span>{{ __('site.student_mobile_application') }}</span>
            </div>
          </div>
          <div>
            <p>&ldquo;{{ __('site.testimonial_2') }}&rdquo;</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- ===================== Philosophy / Principles ===================== --}}
<div class="section-bg style-1" style="background-image: url('{{ asset("font/images/hero_1.jpg") }}');">
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


{{-- ===================== News & Videos ===================== --}}
<div class="news-updates">
  <div class="container">
    <div class="row">

      {{-- News --}}
      <div class="col-lg-9">
        <div class="section-heading">
          <h2 class="text-black">{{ __('site.news_updates') }}</h2>
          <a href="{{route("news_single")}}">Read All News</a>
        </div>

        <div class="row">
          <div class="col-lg-6">
            <div class="post-entry-big">
              <a href="{{ route('news_single') }}" class="img-link"><img src="{{ asset('font/images/blog_large_1.jpg') }}" alt="Image" class="img-fluid"></a>
              <div class="post-content">
                <div class="post-meta">
                  <a href="#">June 6, 2019</a>
                  <span class="mx-1">/</span>
                  <a href="#">{{ __('site.admission') }}</a>, <a href="#">{{ __('site.updates') }}</a>
                </div>
                <h3 class="post-heading"><a href="{{ route('news_single') }}">{{ __('site.training_camp') }}</a></h3>
              </div>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="post-entry-big horizontal d-flex mb-4">
              <a href="{{ route('news_single') }}" class="img-link mr-4"><img src="{{ asset('font/images/blog_1.jpg') }}" alt="Image" class="img-fluid"></a>
              <div class="post-content">
                <div class="post-meta">
                  <a href="#">June 6, 2019</a>
                  <span class="mx-1">/</span>
                  <a href="#">{{ __('site.admission') }}</a>, <a href="#">{{ __('site.updates') }}</a>
                </div>
                <h3 class="post-heading"><a href="{{ route('news_single') }}">{{ __('site.registration_opens') }}</a></h3>
              </div>
            </div>

            <div class="post-entry-big horizontal d-flex mb-4">
              <a href="{{ route('news_single') }}" class="img-link mr-4"><img src="{{ asset('font/images/blog_2.jpg') }}" alt="Image" class="img-fluid"></a>
              <div class="post-content">
                <div class="post-meta">
                  <a href="#">June 6, 2019</a>
                  <span class="mx-1">/</span>
                  <a href="#">{{ __('site.admission') }}</a>, <a href="#">{{ __('site.updates') }}</a>
                </div>
                <h3 class="post-heading"><a href="{{ route('news_single') }}">{{ __('site.new_instructors') }}</a></h3>
              </div>
            </div>

            <div class="post-entry-big horizontal d-flex mb-4">
              <a href="{{ route('news_single') }}" class="img-link mr-4"><img src="{{ asset('font/images/blog_1.jpg') }}" alt="Image" class="img-fluid"></a>
              <div class="post-content">
                <div class="post-meta">
                  <a href="#">June 6, 2019</a>
                  <span class="mx-1">/</span>
                  <a href="#">{{ __('site.admission') }}</a>, <a href="#">{{ __('site.updates') }}</a>
                </div>
                <h3 class="post-heading"><a href="{{ route('news_single') }}">{{ __('site.graduation_ceremony') }}</a></h3>
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- Videos --}}
      <div class="col-lg-3">
        <div class="section-heading">
          <h2 class="text-black">{{ __('site.academy_videos') }}</h2>
          <a href="#">View All Videos</a>
        </div>

        <a href="https://vimeo.com/45830194" class="video-1 mb-4" data-fancybox="" data-ratio="2">
          <span class="play">
            <span class="icon-play"></span>
          </span>
          <img src="{{ asset('font/images/course_5.jpg') }}" alt="Image" class="img-fluid">
        </a>

        <a href="https://vimeo.com/45830194" class="video-1 mb-4" data-fancybox="" data-ratio="2">
          <span class="play">
            <span class="icon-play"></span>
          </span>
          <img src="{{ asset('font/images/course_5.jpg') }}" alt="Image" class="img-fluid">
        </a>
      </div>

    </div>
  </div>
</div>


{{-- ===================== Subscribe ===================== --}}
<div class="site-section ftco-subscribe-1" style="background-image: url({{ asset('font/images/bg_1.jpg') }})">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-7">
        <h2>{{ __('site.subscribe_to_us') }}</h2>
        <p>{{ __('site.subscribe_desc') }}</p>
      </div>

      <div class="col-lg-5">
        <form action="{{route("email")}}" method="POST" class="d-flex">
          <input type="email" class="rounded form-control mr-2 py-3" placeholder="Enter your email" name="email" class="form-control @error('email') is-invalid @enderror">
            @error('email')
             <div class="invalid-feedback">
                        {{ $message }}
             </div>
             @enderror
          <button class="btn btn-primary rounded py-3 px-4" type="submit">Send</button>
        </form>
      </div>
        @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
    </div>
  </div>
</div>

@endsection
