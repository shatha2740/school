<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}"
      dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
 <title>🎓 Academics University | جامعة أكاديمكس</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


  <link href="https://fonts.googleapis.com/css?family=Muli:300,400,700,900" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('font/fonts/icomoon/style.css') }}">

  <link rel="stylesheet" href="{{ asset('font/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('font/css/jquery-ui.css') }}">
  <link rel="stylesheet" href="{{ asset('font/css/owl.carousel.min.css') }}">
  <link rel="stylesheet" href="{{ asset('font/css/owl.theme.default.min.css') }}">
  <link rel="stylesheet" href="{{ asset('font/css/jquery.fancybox.min.css') }}">
  <link rel="stylesheet" href="{{ asset('font/css/bootstrap-datepicker.css') }}">
  <link rel="stylesheet" href="{{ asset('font/fonts/flaticon/font/flaticon.css') }}">
  <link rel="stylesheet" href="{{ asset('font/css/aos.css') }}">
  <link href="{{ asset('font/css/jquery.mb.YTPlayer.min.css') }}" media="all" rel="stylesheet" type="text/css">

  <link rel="stylesheet" href="{{ asset('font/css/style.css') }}">



</head>

<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">

  <div class="site-wrap">

    <div class="site-mobile-menu site-navbar-target">
      <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
          <span class="icon-close2 js-menu-toggle"></span>
        </div>
      </div>
      <div class="site-mobile-menu-body"></div>
    </div>


    <div class="py-2 bg-light">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-9 d-none d-lg-block">
            <a href="#" class="small mr-3"><span class="icon-question-circle-o mr-2"></span>{{ __('site.questions') }} </a>
            <a href="#" class="small mr-3"><span class="icon-phone2 mr-2"></span> 10 20 123 456</a>
            <a href="#" class="small mr-3"><span class="icon-envelope-o mr-2"></span> info@mydomain.com</a>
<div class="dropdown d-inline-block">
    <button class="btn btn-sm btn-outline-secondary dropdown-toggle py-0 px-2"
            type="button"
            data-toggle="dropdown"
            style="font-size: 12px; border-radius: 4px;">
        {{ app()->getLocale() == 'ar' ? 'العربية' : 'English' }}
    </button>

    <div class="dropdown-menu">
        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
            <a class="dropdown-item"
               rel="alternate"
               hreflang="{{ $localeCode }}"
               href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                {{ $properties['native'] }}
            </a>
        @endforeach
    </div>
</div>
          </div>
          <div class="col-lg-3 text-right">
            @guest
              <a href="{{ route('login') }}" class="small mr-3"><span class="icon-unlock-alt"></span>  {{ __('site.login') }}</a>
              <a href="{{ route('register') }}" class="small btn btn-primary px-4 py-2 rounded-0"><span class="icon-users"></span>  {{ __('site.register') }} </a>
            @else
              <a href="{{ route('dashboard') }}" class="small mr-3">{{ __('site.dashboard') }}</a>
              <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="small btn btn-primary px-4 py-2 rounded-0">{{ __('site.logout') }}</button>
              </form>
            @endguest
          </div>
        </div>
      </div>
    </div>
    <header class="site-navbar py-4 js-sticky-header site-navbar-target" role="banner">

      <div class="container">
        <div class="d-flex align-items-center">
          <div class="site-logo">
            <a href="{{ route('index') }}" class="d-block">
              <img src="{{ asset('font/images/logo.jpg') }}" alt="Image" class="img-fluid">
            </a>
          </div>
          <div class="mr-auto">
            <nav class="site-navigation position-relative text-right" role="navigation">
              <ul class="site-menu main-menu js-clone-nav mr-auto d-none d-lg-block">
                <li class="active">
                  <a href="{{ route('index') }}" class="nav-link text-left">  {{ __('site.home') }}</a>
                </li>
                <li >
                  <a href="{{ route('about') }}" class="nav-link text-left"> {{ __('site.about') }}</a>

                </li>
                <li>
                  <a href="{{ route('admissions') }}" class="nav-link text-left"> {{ __('site.admissions') }}</a>
                </li>
                <li>
                  <a href="{{ route('courses') }}" class="nav-link text-left">{{ __('site.courses') }}</a>
                </li>
                <li>
                    <a href="{{ route('contact') }}" class="nav-link text-left">  {{ __('site.contact') }}</a>
                  </li>


                                                                                   </ul>
            </nav>

          </div>
          <div class="ml-auto">
            <div class="social-wrap">
              <a href="#"><span class="icon-facebook"></span></a>
              <a href="#"><span class="icon-twitter"></span></a>
              <a href="#"><span class="icon-linkedin"></span></a>

              <a href="#" class="d-inline-block d-lg-none site-menu-toggle js-menu-toggle text-black"><span
                class="icon-menu h3"></span></a>
            </div>
          </div>

        </div>
      </div>

    </header>

@yield('content')

    <div class="footer">
      <div class="container">
        <div class="row">
          <div class="col-lg-3">
            <p class="mb-4"><img src="{{ asset('font/images/logo.png') }}" alt="Image" class="img-fluid"></p>
            <p>{{__("site.description")}}</p>
            <p><a href="#">{{ __('site.learn_more') }}</a></p>
          </div>
          <div class="col-lg-3">
            <h3 class="footer-heading"><span>{{ __('site.our_campus') }}</span></h3>
            <ul class="list-unstyled">
                <li><a href="#">{{ __('site.admissions') }}</a></li>
                <li><a href="#">{{ __('site.news') }}</a></li>
                <li><a href="#">{{ __('site.Our Interns') }}</a></li>
                <li><a href="#">{{ __('site.Our Leadership') }}</a></li>
                <li><a href="#">{{ __('site.careers') }}</a></li>
                <li><a href="#">{{ __('site.human_resources') }}</a></li>
            </ul>
          </div>
          <div class="col-lg-3">
              <h3 class="footer-heading"><span>{{ __('site.our_courses') }}</span></h3>
              <ul class="list-unstyled">
                  <li><a href="#">{{ __('site.math') }}</a></li>
                  <li><a href="#">{{ __('site.science_engineering') }}</a></li>
                  <li><a href="#">{{ __('site.arts_humanities') }}</a></li>
                  <li><a href="#">{{ __('site.economics_finance') }}</a></li>
                  <li><a href="#">{{ __('site.business_administration') }}</a></li>
                  <li><a href="#">{{ __('site.computer_science') }}</a></li>
              </ul>
          </div>
          <div class="col-lg-3">
              <h3 class="footer-heading"><span>{{ __('site.contact') }}</span></h3>
              <ul class="list-unstyled">
                  <li><a href="#">{{ __('site.help_center') }}</a></li>
                  <li><a href="#">{{ __('site.support_community') }}</a></li>
                  <li><a href="#">{{ __('site.press') }}</a></li>
                  <li><a href="#">{{ __('site.share_your_story') }}</a></li>
                  <li><a href="#">{{ __('site.our_supporters') }}</a></li>
              </ul>
          </div>
        </div>

        <div class="row">
          <div class="col-12">
            <div class="copyright">
                <p>
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
              </ul>
                {{ __('site.copyright') }} |  {{ __('site.template_made_with') }}<i class="icon-heart" aria-hidden="true"></i> <a href="https://colorlib.com" target="_blank" >Colorlib</a>
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    </p>
            </div>
          </div>
        </div>
      </div>
    </div>


  </div>
  <!-- .site-wrap -->


  <!-- loader -->
  <div id="loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#51be78"/></svg></div>

  <script src="{{ asset('font/js/jquery-3.3.1.min.js') }}"></script>
  <script src="{{ asset('font/js/jquery-migrate-3.0.1.min.js') }}"></script>
  <script src="{{ asset('font/js/jquery-ui.js') }}"></script>
  <script src="{{ asset('font/js/popper.min.js') }}"></script>
  <script src="{{ asset('font/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('font/js/owl.carousel.min.js') }}"></script>
  <script src="{{ asset('font/js/jquery.stellar.min.js') }}"></script>
  <script src="{{ asset('font/js/jquery.countdown.min.js') }}"></script>
  <script src="{{ asset('font/js/bootstrap-datepicker.min.js') }}"></script>
  <script src="{{ asset('font/js/jquery.easing.1.3.js') }}"></script>
  <script src="{{ asset('font/js/aos.js') }}"></script>
  <script src="{{ asset('font/js/jquery.fancybox.min.js') }}"></script>
  <script src="{{ asset('font/js/jquery.sticky.js') }}"></script>
  <script src="{{ asset('font/js/jquery.mb.YTPlayer.min.js') }}"></script>




  <script src="{{ asset('font/js/main.js') }}"></script>

</body>

</html>

