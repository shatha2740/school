
<x-app-layout>
    @php
        $isArabic = app()->getLocale() === 'ar';
    @endphp

    <x-slot name="header">
     <div class="flex items-center justify-between"
             dir="{{ $isArabic ? 'rtl' : 'ltr' }}">
            <div>
                <h2 class="text-xl font-bold text-gray-800 leading-tight">
                    {{ $isArabic ? 'كورساتي' : 'My Courses' }}
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    {{ $isArabic
                        ? 'تابعي رحلتك التعليمية من مكان واحد'
                        : 'Continue your learning journey in one place' }}
                </p>
            </div>

            <a href="{{ route('courses') }}"
               class="inline-flex items-center gap-2 rounded-xl bg-emerald-600
                      px-4 py-2.5 text-sm font-semibold text-white
                      shadow-sm transition hover:bg-emerald-700">
                <span>{{ $isArabic ? 'تصفّح الكورسات' : 'Explore Courses' }}</span>
                <span aria-hidden="true">{{ $isArabic ? '←' : '→' }}</span>
            </a>
        </div>
    </x-slot>

         <div class="min-h-screen bg-slate-50 py-4 sm:py-6"
         dir="{{ $isArabic ? 'rtl' : 'ltr' }}">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Session messages --}}
            @if (session('success'))
                <div class="mb-6 flex items-center gap-3 rounded-2xl border border-emerald-200
                            bg-emerald-50 p-4 text-sm font-medium text-emerald-800"
                     role="status">
                    <span class="text-xl">✓</span>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 flex items-center gap-3 rounded-2xl border border-red-200
                            bg-red-50 p-4 text-sm font-medium text-red-800"
                     role="alert">
                    <span class="text-xl">!</span>
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            {{-- Courses count --}}
            <div class="mb-8 flex items-center justify-between rounded-2xl border
                        border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 items-center justify-center
                                rounded-xl bg-indigo-50 text-2xl">
                        🎓
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">
                            {{ $isArabic ? 'الكورسات المسجّل بها' : 'Enrolled Courses' }}
                        </p>
                         <p class="mt-1 text-2xl font-extrabold text-slate-900">
                            {{ $enrollments->count() }}
                        </p>
                    </div>
                </div>

                <span class="hidden rounded-full bg-emerald-50 px-3 py-1.5
                             text-xs font-semibold text-emerald-700 sm:inline-flex">
                    {{ $isArabic ? 'رحلتك مستمرة ✨' : 'Keep Going ✨' }}
                </span>
            </div>

            {{-- Courses grid --}}
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">

                @forelse ($enrollments as $enrollment)

                    @php($course = $enrollment->course)

                    @if ($course)
                        <article class="group flex h-full flex-col overflow-hidden
                                        rounded-2xl border border-slate-200 bg-white
                                        shadow-sm transition duration-300
                                        hover:-translate-y-1 hover:border-indigo-200
                                        hover:shadow-xl">

                            {{-- Course image --}}
                            <div class="relative overflow-hidden bg-slate-100">
                                <img
                                    src="{{ $course->imageUrl() ?: asset('font/images/course_1.jpg') }}"
                                    alt="{{ $course->localized('title') }}"
                                    loading="lazy"
                                    class="h-52 w-full object-cover transition duration-500
                                           group-hover:scale-105"
                                >

                                <div class="absolute inset-0 bg-gradient-to-t
                                            from-slate-900/40 to-transparent">
                                </div>

                                <div class="absolute bottom-3 start-3">
                                    <span class="inline-flex items-center gap-2 rounded-full
                                                 bg-white/95 px-3 py-1.5 text-xs font-bold
                                                 text-indigo-700 shadow-sm">
                                        <span>✓</span>
                                        {{ $isArabic ? 'تم التسجيل' : 'Enrolled' }}
                                    </span>
                                </div>
                            </div>

                            {{-- Course details --}}
                            <div class="flex flex-1 flex-col p-5 sm:p-6">

                                <h3 class="mb-3 text-xl font-bold leading-8 text-slate-900
                                           transition group-hover:text-indigo-700">
                                    {{ $course->localized('title') }}
                                </h3>

                                <div class="mb-5 flex items-center gap-3">
                                    <div class="flex h-10 w-10 shrink-0 items-center
                                                justify-center rounded-full bg-indigo-50 text-lg">
                                        👨‍🏫
                                    </div>

                                    <div class="min-w-0">
                                        <p class="text-xs text-slate-400">
                                            {{ $isArabic ? 'المدرّب' : 'Instructor' }}
                                        </p>

                                        <p class="mt-1 truncate text-sm font-semibold text-slate-700">
                                            {{ $course->instructor?->name ?? '—' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="mt-auto border-t border-slate-100 pt-4">
                                    <a href="{{ route('student.course', $course) }}"
                                       class="flex w-full items-center justify-center gap-2
                                              rounded-xl bg-emerald-600 px-4 py-3
                                              text-sm font-bold text-white shadow-sm
                                              transition hover:bg-emerald-700
                                              focus:outline-none focus:ring-2
                                              focus:ring-indigo-500 focus:ring-offset-2">

                                        <span>📖</span>

                                        <span>
                                            {{ $isArabic ? 'ابدأ التعلّم' : 'Start Learning' }}
                                        </span>

                                        <span class="transition group-hover:translate-x-1"
                                              aria-hidden="true">
                                            {{ $isArabic ? '←' : '→' }}
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endif

                @empty

                    {{-- Empty state --}}
                    <div class="col-span-full">
                        <div class="rounded-3xl border-2 border-dashed border-slate-200
                                    bg-white px-6 py-14 text-center sm:px-12 sm:py-20">

                            <div class="mx-auto mb-6 flex h-20 w-20 items-center
                                        justify-center rounded-3xl bg-indigo-50 text-4xl">
                                📚
                            </div>

                            <h3 class="text-2xl font-extrabold text-slate-900">
                                {{ $isArabic
                                    ? 'لم تنضمّي إلى أي كورس بعد'
                                    : 'No Courses Yet' }}
                            </h3>

                            <p class="mx-auto mt-3 max-w-md text-sm leading-7 text-slate-500">
                                {{ $isArabic
                                    ? 'اكتشفي الكورسات المتاحة واختاري ما يناسب أهدافك، ثم ابدئي رحلتك التعليمية.'
                                    : 'Explore available courses, find what matches your goals, and start your learning journey.' }}
                            </p>

                            <a href="{{ route('courses') }}"
                               class="mt-7 inline-flex items-center justify-center gap-2
                                      rounded-xl bg-indigo-600 px-6 py-3.5
                                      text-sm font-bold text-white shadow-sm
                                      transition hover:bg-indigo-700">
                                <span>🔎</span>
                                <span>
                                    {{ $isArabic ? 'اكتشف الكورسات' : 'Discover Courses' }}
                                </span>
                                <span aria-hidden="true">
                                    {{ $isArabic ? '←' : '→' }}
                                </span>
                            </a>
                        </div>
                    </div>

                @endforelse
            </div>

            {{-- Pagination --}}
            @if (method_exists($enrollments, 'links'))
                <div class="mt-8">
                    {{ $enrollments->links() }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
