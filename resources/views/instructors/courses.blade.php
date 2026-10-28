
<x-app-layout>
    @php
        $isArabic = app()->getLocale() === 'ar';
    @endphp

    <x-slot name="header">
        <div class="flex items-center justify-between"
             dir="{{ $isArabic ? 'rtl' : 'ltr' }}">

            <div>
                <h2 class="text-xl font-bold text-gray-800">
                    {{ $isArabic ? 'كورساتي كمدرّب' : 'My Teaching Courses' }}
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    {{ $isArabic
                        ? 'إدارة ومتابعة الكورسات الخاصة بك'
                        : 'View and manage your assigned courses' }}
                </p>
            </div>


        </div>
    </x-slot>

    <div class="min-h-screen bg-slate-50 py-6"
         dir="{{ $isArabic ? 'rtl' : 'ltr' }}">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- عدد الكورسات --}}
            <div class="mb-8 flex items-center gap-4 rounded-2xl
                        border border-slate-200 bg-white p-6 shadow-sm">

                <div class="flex h-14 w-14 items-center justify-center
                            rounded-xl bg-indigo-50 text-3xl">
                    👨‍🏫
                </div>

                <div>
                    <p class="text-sm text-slate-500">
                        {{ $isArabic ? 'عدد الكورسات الخاصة بك' : 'Your Courses' }}
                    </p>

                    <p class="mt-1 text-2xl font-extrabold text-slate-900">
                        {{ $courses->count() }}
                    </p>
                </div>
            </div>


            {{-- بطاقات الكورسات --}}
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">

                @forelse ($courses as $course)

                    <article class="group flex h-full flex-col overflow-hidden
                                    rounded-2xl border border-slate-200 bg-white
                                    shadow-sm transition duration-300
                                    hover:-translate-y-1 hover:border-indigo-200
                                    hover:shadow-xl">
                          <a href="{{ route('student.course', $course) }}"
       class="flex flex-1 flex-col">
                        {{-- صورة الكورس --}}
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
                                <span class="rounded-full bg-white/95 px-3 py-1.5
                                             text-xs font-bold text-indigo-700 shadow-sm">
                                    👨‍🏫
                                    {{ $isArabic ? 'كورسي' : 'My Course' }}
                                </span>
                            </div>
                        </div>

                        {{-- معلومات الكورس --}}
                        <div class="flex flex-1 flex-col p-5 sm:p-6">

                            <h3 class="mb-3 text-xl font-bold leading-8
                                       text-slate-900 transition
                                       group-hover:text-indigo-700">
                                {{ $course->localized('title') }}
                            </h3>

                            <p class="mb-4 text-sm leading-7 text-slate-500">
                                {{ $course->localized('short_description')
                                    ?: ($isArabic
                                        ? 'لا يوجد وصف للكورس حتى الآن.'
                                        : 'No course description available.') }}
                            </p>

                            <div class="mt-auto border-t border-slate-100 pt-4">

                                <div class="flex items-center justify-between gap-3">
                                    <span class="text-sm text-slate-500">
                                        {{ $isArabic ? 'المدرّب' : 'Instructor' }}
                                    </span>

                                    <span class="truncate text-sm font-semibold text-slate-700">
                                        {{ $course->instructor?->name ?? '—' }}
                                    </span>
                                </div>

                                <div class="mt-3 flex items-center justify-between gap-3">
                                    <span class="text-sm text-slate-500">
                                        {{ $isArabic ? 'الحالة' : 'Status' }}
                                    </span>

                                    @if ($course->is_published)
                                        <span class="rounded-full bg-emerald-50
                                                     px-3 py-1 text-xs font-semibold
                                                     text-emerald-700">
                                            {{ $isArabic ? 'منشور' : 'Published' }}
                                        </span>
                                    @else
                                        <span class="rounded-full bg-amber-50
                                                     px-3 py-1 text-xs font-semibold
                                                     text-amber-700">
                                            {{ $isArabic ? 'مسودة' : 'Draft' }}
                                        </span>
                                    @endif
                                </div>


                            </div>
                        </div >
                    </a>

                    </article>

                @empty

                    {{-- لا توجد كورسات --}}
                    <div class="col-span-full rounded-3xl border-2
                                border-dashed border-slate-200 bg-white
                                px-6 py-14 text-center">

                        <div class="mx-auto mb-5 flex h-20 w-20
                                    items-center justify-center rounded-3xl
                                    bg-indigo-50 text-4xl">
                            📚
                        </div>

                        <h3 class="text-2xl font-extrabold text-slate-900">
                            {{ $isArabic
                                ? 'لا توجد كورسات مرتبطة بحسابك'
                                : 'No Courses Assigned Yet' }}
                        </h3>

                        <p class="mx-auto mt-3 max-w-md text-sm leading-7 text-slate-500">
                            {{ $isArabic
                                ? 'ستظهر هنا الكورسات التي يتم إسنادها إليك من الإدارة.'
                                : 'Courses assigned to you by the administration will appear here.' }}
                        </p>
                    </div>

                @endforelse

            </div>
        </div>
    </div>
</x-app-layout>
