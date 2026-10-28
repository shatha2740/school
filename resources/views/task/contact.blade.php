
@extends('layouts.sh')

@section('content')

{{-- Page Header --}}
<div class="site-section ftco-subscribe-1 site-blocks-cover pb-4"
     style="background-image: url({{ asset('font/images/bg_1.jpg') }}); background-size: cover; background-position: center;">
    <div class="container">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <span class="badge badge-primary px-3 py-2 mb-3 font-weight-normal" style="background-color: rgba(0, 123, 255, 0.2); color: #fff; border: 1px solid rgba(255,255,255,0.2);">
                    🎓 {{ __('site.academics_university') }}
                </span>
                <h1 class="mb-3 text-white font-weight-bold display-4">{{ __('site.contact') }}</h1>
                <p class="text-white-50 lead">
                    {{ __('site.contact_intro') }}
                </p>
            </div>
        </div>
    </div>
</div>

{{-- Breadcrumbs --}}
<div class="custom-breadcrumns border-bottom bg-white py-3 shadow-sm">
    <div class="container">
        <a href="{{ route('index') }}" class="text-primary">{{ __('site.home') }}</a>
        <span class="mx-3 text-muted">/</span>
        <span class="text-secondary font-weight-bold">{{ __('site.contact') }}</span>
    </div>
</div>

{{-- Contact Section --}}
<section class="py-5" style="background-color: #f8f9fa;">
    <div class="container">

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="row">

            {{-- Contact Form (Left Side - 7 Cols) --}}
            <div class="col-lg-7 mb-4">
                <div class="card border-0 shadow-sm rounded-lg p-4 p-md-5 h-100">

                    <div class="border-bottom pb-3 mb-4">
                        <h4 class="font-weight-bold text-dark mb-1">
                            ✉️ {{ __('site.send_us_message') }}
                        </h4>
                        <p class="text-muted small mb-0">
                            {{ __('site.contact_assistance_desc') }}
                        </p>
                    </div>

                    <form method="POST" action="{{ route('contact') }}" enctype="multipart/form-data">
                        @csrf

                        {{-- Name Fields --}}
                        <div class="form-row">
                            <div class="col-md-6 form-group">
                                <label for="fname" class="font-weight-bold text-muted small text-uppercase">
                                    {{ __('site.first_name') }} <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       id="fname"
                                       name="fname"
                                       value="{{ old('fname') }}"
                                       class="form-control @error('fname') is-invalid @enderror"
                                       placeholder="{{ __('site.enter_first_name') }}"
                                       required>
                                @error('fname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="lname" class="font-weight-bold text-muted small text-uppercase">
                                    {{ __('site.last_name') }} <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       id="lname"
                                       name="lname"
                                       value="{{ old('lname') }}"
                                       class="form-control @error('lname') is-invalid @enderror"
                                       placeholder="{{ __('site.enter_last_name') }}"
                                       required>
                                @error('lname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Email & Mobile Fields --}}
                        <div class="form-row">
                            <div class="col-md-6 form-group">
                                <label for="email" class="font-weight-bold text-muted small text-uppercase">
                                    {{ __('site.email_address') }} <span class="text-danger">*</span>
                                </label>
                                <input type="email"
                                       id="email"
                                       name="email"
                                       value="{{ old('email') }}"
                                       class="form-control @error('email') is-invalid @enderror"
                                       placeholder="name@example.com"
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="tel" class="font-weight-bold text-muted small text-uppercase">
                                    {{ __('site.mobile_number') }} <span class="text-danger">*</span>
                                </label>
                                <input type="tel"
                                       id="tel"
                                       name="tel"
                                       value="{{ old('tel') }}"
                                       class="form-control @error('tel') is-invalid @enderror"
                                       placeholder="0591234567"
                                       required>
                                @error('tel')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Optional File Attachment --}}
                        <div class="form-group">
                            <label for="file" class="font-weight-bold text-muted small text-uppercase">
                                {{ __('site.file_optional') }}
                            </label>
                            <div class="custom-file">
                                <input type="file"
                                       id="file"
                                       name="file"
                                       class="custom-file-input @error('file') is-invalid @enderror">
                                <label class="custom-file-label text-muted" for="file">اختر ملفاً (اختياري)...</label>
                            </div>
                            @error('file')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Message Textarea --}}
                        <div class="form-group mb-4">
                            <label for="message" class="font-weight-bold text-muted small text-uppercase">
                                {{ __('site.your_message') }} <span class="text-danger">*</span>
                            </label>
                            <textarea id="message"
                                      name="message"
                                      rows="5"
                                      class="form-control @error('message') is-invalid @enderror"
                                      placeholder="{{ __('site.how_can_we_help') }}"
                                      required>{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Submit Button --}}
                        <button type="submit"
                                class="btn btn-primary btn-lg px-4 py-2 font-weight-bold shadow-sm"
                                style="background-color: #183b56; border-color: #183b56;">
                            {{ __('site.send_message') }} &rarr;
                        </button>
                    </form>
                </div>
            </div>

            {{-- Contact Information Sidebar (Right Side - 5 Cols) --}}
            <div class="col-lg-5 mb-4">
                <div class="card border-0 shadow-sm rounded-lg p-4 p-md-5 h-100">

                    <h4 class="font-weight-bold text-dark border-bottom pb-3 mb-4">
                        📍 {{ __('site.contact_information') }}
                    </h4>

                    <div class="media mb-4 align-items-start">
                        <div class="mr-3 bg-light rounded-circle d-flex align-items-center justify-content-center text-primary" style="width: 45px; height: 45px; font-size: 20px;">
                            📍
                        </div>
                        <div class="media-body">
                            <h6 class="font-weight-bold text-dark mb-1">{{ __('site.our_location') }}</h6>
                            <p class="text-muted small mb-0">{{ __('site.gaza_strip_palestine') }}</p>
                        </div>
                    </div>

                    <div class="media mb-4 align-items-start">
                        <div class="mr-3 bg-light rounded-circle d-flex align-items-center justify-content-center text-primary" style="width: 45px; height: 45px; font-size: 20px;">
                            🎓
                        </div>
                        <div class="media-body">
                            <h6 class="font-weight-bold text-dark mb-1">{{ __('site.academics_university') }}</h6>
                            <p class="text-muted small mb-0">{{ __('site.education_knowledge_success') }}</p>
                        </div>
                    </div>

                    <div class="media mb-4 align-items-start">
                        <div class="mr-3 bg-light rounded-circle d-flex align-items-center justify-content-center text-primary" style="width: 45px; height: 45px; font-size: 20px;">
                            ✉️
                        </div>
                        <div class="media-body">
                            <h6 class="font-weight-bold text-dark mb-1">{{ __('site.email_support') }}</h6>
                            <p class="text-muted small mb-0">{{ __('site.contact_using_form') }}</p>
                        </div>
                    </div>

                    <hr class="my-4">

                    <h5 class="h6 font-weight-bold text-dark mb-3">
                        {{ __('site.find_us_on_map') }}
                    </h5>

                    <div class="embed-responsive embed-responsive-16by9 rounded shadow-sm mb-3" style="border-radius: 8px; overflow: hidden;">
                        <iframe
                            src="https://www.openstreetmap.org/export/embed.html?bbox=34.38%2C31.40%2C34.48%2C31.53&layer=mapnik&marker=31.5017%2C34.4668"
                            class="embed-responsive-item"
                            style="border:0;"
                            loading="lazy"
                            title="{{ __('site.map_gaza_palestine') }}">
                        </iframe>
                    </div>

                    <a href="https://www.openstreetmap.org/?mlat=31.5017&mlon=34.4668#map=13/31.5017/34.4668"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="btn btn-outline-primary btn-block btn-sm font-weight-bold py-2">
                        {{ __('site.open_interactive_map') }} &nearr;
                    </a>

                    <small class="text-muted d-block text-center mt-2">
                        {{ __('site.map_data_attribution') }}
                    </small>

                </div>
            </div>

        </div>
    </div>
</section>

@endsection
