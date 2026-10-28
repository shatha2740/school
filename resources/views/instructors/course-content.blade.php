
@php
    $isArabic = app()->getLocale() === 'ar';

    $studentsCount = $course->students()->count();
    $lessonsCount = $lessons->count();

    $submissionsCount = $assignments->sum(function ($assignment) {
        return $assignment->submissions_count
            ?? $assignment->submissions->count();
    });

    // ترتيب الدروس حسب الأسبوع ثم ترتيب الدرس
    $orderedLessons = $lessons->sortBy([
        ['week_number', 'asc'],
        ['sort_order', 'asc'],
    ]);

    $lessonsByWeek = $orderedLessons->groupBy(
        fn ($lesson) => $lesson->week_number ?? 1
    );
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">
                {{ $isArabic ? 'محتوى الكورس' : 'Course Content' }}
            </h2>
        </div>
    </x-slot>

    <div class="min-h-screen bg-gray-50 py-8"
         dir="{{ $isArabic ? 'rtl' : 'ltr' }}">

        <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6 lg:px-8">

            {{-- رسائل النظام --}}
            @if (session('success'))
                <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            {{-- عنوان الكورس --}}
            <section class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-gray-500">
                    {{ $isArabic ? 'إدارة المحتوى التعليمي' : 'Learning Content Management' }}
                </p>

                <h1 class="mt-2 text-2xl font-bold text-gray-900">
                    {{ $course->localized('title') }}
                </h1>

                <p class="mt-2 text-sm text-gray-500">
                    {{ $isArabic
                        ? 'إدارة الدروس والواجبات ومتابعة تسليمات الطلاب.'
                        : 'Manage lessons and assignments and review student submissions.' }}
                </p>
            </section>

            {{-- الإحصائيات --}}
            <section class="grid grid-cols-1 gap-6 sm:grid-cols-3">

                <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">
                        {{ $isArabic ? 'إجمالي الطلاب' : 'Total Students' }}
                    </p>

                    <p class="mt-3 text-3xl font-bold text-gray-900">
                        {{ $studentsCount }}
                    </p>

                    <div class="mt-4 h-1 rounded-full bg-gray-100">
                        <div class="h-1 w-full rounded-full bg-blue-600"></div>
                    </div>
                </div>

                <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">
                        {{ $isArabic ? 'إجمالي الدروس' : 'Total Lessons' }}
                    </p>

                    <p class="mt-3 text-3xl font-bold text-gray-900">
                        {{ $lessonsCount }}
                    </p>

                    <div class="mt-4 h-1 rounded-full bg-gray-100">
                        <div class="h-1 w-full rounded-full bg-emerald-600"></div>
                    </div>
                </div>

                <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">
                        {{ $isArabic ? 'إجمالي التسليمات' : 'Total Submissions' }}
                    </p>

                    <p class="mt-3 text-3xl font-bold text-gray-900">
                        {{ $submissionsCount }}
                    </p>

                    <div class="mt-4 h-1 rounded-full bg-gray-100">
                        <div class="h-1 w-full rounded-full bg-amber-500"></div>
                    </div>
                </div>

            </section>

            {{-- أزرار الإضافة --}}
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('courses.lessons.create', $course) }}"
                   class="inline-flex items-center rounded-lg bg-emerald-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-emerald-700">
                    {{ $isArabic ? 'إضافة درس جديد' : 'Add New Lesson' }}
                </a>

                <a href="{{ route('courses.assignments.create', $course) }}"
                   class="inline-flex items-center rounded-lg bg-blue-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-700">
                    {{ $isArabic ? 'إضافة واجب جديد' : 'Add New Assignment' }}
                </a>
            </div>

            {{-- الدروس حسب الأسبوع --}}
            <section class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">

                <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">
                            {{ $isArabic ? 'الخطة التعليمية' : 'Course Curriculum' }}
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            {{ $isArabic
                                ? 'الدروس مرتبة حسب الأسبوع ورقم الدرس.'
                                : 'Lessons are organized by week and lesson order.' }}
                        </p>
                    </div>

                    <span class="rounded-full bg-emerald-50 px-3 py-1 text-sm font-semibold text-emerald-700">
                        {{ $lessonsCount }}
                        {{ $isArabic ? 'دروس' : 'Lessons' }}
                    </span>
                </div>

                @forelse ($lessonsByWeek as $weekNumber => $weekLessons)

                    <div class="mb-6 overflow-hidden rounded-xl border border-gray-200 last:mb-0">

                        {{-- عنوان الأسبوع --}}
                        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-gray-200 bg-gray-50 px-5 py-4">

                            <div>
                                <h3 class="font-bold text-gray-900">
                                    {{ $isArabic ? 'الأسبوع' : 'Week' }}
                                    {{ $weekNumber ?? 1 }}
                                </h3>

                                <p class="mt-1 text-sm text-gray-500">
                                    {{ $isArabic
                                        ? 'المحتوى التعليمي لهذا الأسبوع'
                                        : 'Learning materials for this week' }}
                                </p>
                            </div>

                            <span class="rounded-full border border-gray-200 bg-white px-3 py-1 text-xs font-semibold text-gray-600">
                                {{ $weekLessons->count() }}
                                {{ $isArabic ? 'دروس' : 'Lessons' }}
                            </span>
                        </div>

                        {{-- قائمة الدروس --}}
                        <div class="divide-y divide-gray-100">

                            @foreach ($weekLessons as $lesson)

                                <details class="group">

                                    <summary class="flex cursor-pointer list-none items-center gap-4 px-5 py-4 transition hover:bg-gray-50">

                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg border border-gray-200 bg-white text-sm font-semibold text-gray-700">
                                            {{ $loop->iteration }}
                                        </div>

                                        <div class="min-w-0 flex-1">
                                            <h4 class="font-semibold text-gray-800">
                                                {{ $lesson->title }}
                                            </h4>

                                            <p class="mt-1 text-sm text-gray-500">
                                                {{ $isArabic ? 'رقم الدرس:' : 'Lesson Number:' }}
                                                {{ $lesson->sort_order }}
                                            </p>
                                        </div>

                                        <span class="text-sm font-medium text-blue-700 group-open:hidden">
                                            {{ $isArabic ? 'عرض التفاصيل' : 'View Details' }}
                                        </span>

                                        <span class="hidden text-sm font-medium text-blue-700 group-open:inline">
                                            {{ $isArabic ? 'إخفاء التفاصيل' : 'Hide Details' }}
                                        </span>

                                        <svg class="h-4 w-4 shrink-0 text-gray-400 transition group-open:rotate-180"
                                             viewBox="0 0 20 20"
                                             fill="currentColor"
                                             aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                  d="M5.22 7.22a.75.75 0 011.06 0L10 10.94l3.72-3.72a.75.75 0 111.06 1.06l-4.25 4.25a.75.75 0 01-1.06 0L5.22 8.28a.75.75 0 010-1.06z"
                                                  clip-rule="evenodd"/>
                                        </svg>

                                    </summary>

                                    <div class="space-y-5 border-t border-gray-100 bg-white px-5 py-5">

                                        @if ($lesson->content)
                                            <div>
                                                <h5 class="mb-2 text-sm font-bold text-gray-800">
                                                    {{ $isArabic ? 'محتوى الدرس' : 'Lesson Content' }}
                                                </h5>

                                                <div class="whitespace-pre-line text-sm leading-8 text-gray-600">
                                                    {{ $lesson->content }}
                                                </div>
                                            </div>
                                        @endif

                                        @if ($lesson->video_url)
                                            <div>
                                                <h5 class="mb-3 text-sm font-bold text-gray-800">
                                                    {{ $isArabic ? 'المحاضرة المسجلة' : 'Recorded Lecture' }}
                                                </h5>

                                                <a href="{{ $lesson->video_url }}"
                                                   target="_blank"
                                                   rel="noopener noreferrer"
                                                   class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700">
                                                    {{ $isArabic ? 'فتح المحاضرة' : 'Open Lecture' }}
                                                </a>
                                            </div>
                                        @endif

                                        @if (! $lesson->content && ! $lesson->video_url)
                                            <p class="text-sm text-gray-500">
                                                {{ $isArabic
                                                    ? 'لم تتم إضافة محتوى لهذا الدرس بعد.'
                                                    : 'No content has been added to this lesson yet.' }}
                                            </p>
                                        @endif

                                        <div class="border-t border-gray-100 pt-4">
                                            <a href="{{ route('courses.lessons.edit', [$course, $lesson]) }}"
                                               class="inline-flex items-center rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50">
                                                {{ $isArabic ? 'تعديل الدرس' : 'Edit Lesson' }}
                                            </a>
                                        </div>

                                    </div>
                                </details>

                            @endforeach

                        </div>
                    </div>

                @empty

                    <div class="rounded-lg border border-dashed border-gray-300 px-6 py-12 text-center">
                        <h3 class="font-semibold text-gray-800">
                            {{ $isArabic ? 'لا توجد دروس حاليًا' : 'No Lessons Available' }}
                        </h3>

                        <p class="mt-2 text-sm text-gray-500">
                            {{ $isArabic
                                ? 'ستظهر الدروس هنا بعد إضافتها إلى الكورس.'
                                : 'Lessons will appear here once they are added to the course.' }}
                        </p>
                    </div>

                @endforelse
            </section>

            {{-- الواجبات وتسليمات الطلاب --}}
            <section class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">

                <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">
                            {{ $isArabic ? 'الواجبات وتسليمات الطلاب' : 'Assignments & Student Submissions' }}
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            {{ $isArabic
                                ? 'افتح الواجب لمراجعة تسليمات الطلاب ودرجاتهم.'
                                : 'Open an assignment to review student submissions and grades.' }}
                        </p>
                    </div>

                    <span class="rounded-full bg-blue-50 px-3 py-1 text-sm font-semibold text-blue-700">
                        {{ $assignments->count() }}
                        {{ $isArabic ? 'واجبات' : 'Assignments' }}
                    </span>
                </div>

                @forelse ($assignments as $assignment)

                    <div class="mb-4 overflow-hidden rounded-xl border border-gray-200 last:mb-0">

                        {{-- عنوان الواجب القابل للفتح --}}
                        <details class="group">

                            <summary class="flex cursor-pointer list-none items-center gap-4 bg-white px-5 py-4 transition hover:bg-gray-50">

                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg border border-gray-200 bg-gray-50 text-sm font-semibold text-gray-700">
                                    {{ $loop->iteration }}
                                </div>

                                <div class="min-w-0 flex-1">
                                    <h3 class="font-semibold text-gray-900">
                                        {{ $assignment->title }}
                                    </h3>

                                    <p class="mt-1 text-sm text-gray-500">
                                        {{ $assignment->submissions->count() }}
                                        {{ $isArabic ? 'تسليمات' : 'Submissions' }}
                                    </p>
                                </div>

                                <span class="text-sm font-medium text-blue-700 group-open:hidden">
                                    {{ $isArabic ? 'عرض التسليمات' : 'View Submissions' }}
                                </span>

                                <span class="hidden text-sm font-medium text-blue-700 group-open:inline">
                                    {{ $isArabic ? 'إخفاء التسليمات' : 'Hide Submissions' }}
                                </span>

                                <svg class="h-4 w-4 shrink-0 text-gray-400 transition group-open:rotate-180"
                                     viewBox="0 0 20 20"
                                     fill="currentColor"
                                     aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M5.22 7.22a.75.75 0 011.06 0L10 10.94l3.72-3.72a.75.75 0 111.06 1.06l-4.25 4.25a.75.75 0 01-1.06 0L5.22 8.28a.75.75 0 010-1.06z"
                                          clip-rule="evenodd"/>
                                </svg>

                            </summary>

                            <div class="space-y-5 border-t border-gray-200 bg-gray-50 p-5">

                                {{-- تعليمات الواجب --}}
                                @if ($assignment->instructions)
                                    <div class="rounded-lg border border-gray-200 bg-white p-4">
                                        <h4 class="mb-2 text-sm font-bold text-gray-800">
                                            {{ $isArabic ? 'تعليمات الواجب' : 'Assignment Instructions' }}
                                        </h4>

                                        <p class="whitespace-pre-line text-sm leading-7 text-gray-600">{{ $assignment->instructions }}</p>
                                    </div>
                                @endif

                                <div class="flex flex-wrap gap-3 text-sm text-gray-600">
                                    <span class="rounded-lg border border-gray-200 bg-white px-3 py-2">
                                        {{ $isArabic ? 'الدرجة الكاملة:' : 'Maximum Score:' }}
                                        <strong>{{ $assignment->max_score }}</strong>
                                    </span>

                                    @if ($assignment->due_at)
                                        <span class="rounded-lg border border-gray-200 bg-white px-3 py-2">
                                            {{ $isArabic ? 'موعد التسليم:' : 'Due Date:' }}
                                            {{ \Illuminate\Support\Carbon::parse($assignment->due_at)->format('Y-m-d H:i') }}
                                        </span>
                                    @endif
                                </div>

                                {{-- قائمة التسليمات --}}
                                <div class="space-y-3">

                                    <h4 class="text-sm font-bold text-gray-800">
                                        {{ $isArabic ? 'تسليمات الطلاب' : 'Student Submissions' }}
                                    </h4>

                                    @forelse ($assignment->submissions as $submission)

                                        <details class="group overflow-hidden rounded-lg border border-gray-200 bg-white">

                                            {{-- بيانات الطالب --}}
                                            <summary class="flex cursor-pointer list-none items-center gap-4 px-4 py-4 transition hover:bg-gray-50">

                                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-gray-100 text-sm font-semibold text-gray-700">
                                                    {{ mb_substr($submission->user->name ?? 'S', 0, 1) }}
                                                </div>

                                                <div class="min-w-0 flex-1">
                                                    <p class="font-semibold text-gray-800">
                                                        {{ $submission->user->name ?? ($isArabic ? 'طالب' : 'Student') }}
                                                    </p>

                                                    <p class="mt-1 text-sm text-gray-500">
                                                        @if ($submission->status === 'graded')
                                                            {{ $isArabic ? 'تم التصحيح' : 'Graded' }}
                                                        @else
                                                            {{ $isArabic ? 'بانتظار التصحيح' : 'Awaiting Grading' }}
                                                        @endif
                                                    </p>
                                                </div>

                                                <div class="text-end">
                                                    <p class="text-xs text-gray-500">
                                                        {{ $isArabic ? 'الدرجة' : 'Score' }}
                                                    </p>

                                                    <p class="mt-1 font-bold text-gray-900">
                                                        {{ $submission->score ?? '—' }}
                                                        <span class="text-xs font-normal text-gray-500">
                                                            / {{ $assignment->max_score }}
                                                        </span>
                                                    </p>
                                                </div>

                                                <svg class="h-4 w-4 shrink-0 text-gray-400 transition group-open:rotate-180"
                                                     viewBox="0 0 20 20"
                                                     fill="currentColor"
                                                     aria-hidden="true">
                                                    <path fill-rule="evenodd"
                                                          d="M5.22 7.22a.75.75 0 011.06 0L10 10.94l3.72-3.72a.75.75 0 111.06 1.06l-4.25 4.25a.75.75 0 01-1.06 0L5.22 8.28a.75.75 0 010-1.06z"
                                                          clip-rule="evenodd"/>
                                                </svg>

                                            </summary>

                                            {{-- محتوى تسليم الطالب --}}
                                            <div class="space-y-4 border-t border-gray-100 p-4">

                                                @if ($submission->answer)

                                                    <div>

                                                        <h5 class="mb-2 text-sm font-bold text-gray-800">
                                                            {{ $isArabic ? 'إجابة الطالب' : 'Student Answer' }}
                                                        </h5>

                                                        <div class="whitespace-pre-line rounded-lg border border-gray-200 bg-gray-50 p-4 text-sm leading-7 text-gray-700">{{ $submission->answer }}</div>

                                                    </div>
                                                @endif

                                                @if ($submission->file_path)
                                                    <div class="flex flex-wrap items-center justify-between gap-3 rounded-lg border border-gray-200 bg-white p-4">
                                                        <div>
                                                            <p class="text-sm font-semibold text-gray-800">
                                                                {{ $isArabic ? 'ملف مرفق' : 'Attached File' }}
                                                            </p>

                                                            <p class="mt-1 text-xs text-gray-500">
                                                                {{ $isArabic ? 'أرفق الطالب ملفًا مع التسليم.' : 'The student attached a file.' }}
                                                            </p>
                                                        </div>

                                                        <a href="{{ route('submissions.download' ,$submission) }}"
                                                           target="_blank"
                                                           rel="noopener noreferrer"
                                                           class="inline-flex items-center rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50">
                                                            {{ $isArabic ? 'عرض الملف' : 'View File' }}
                                                        </a>
                                                    </div>
                                                @endif

{{-- نموذج تصحيح تسليم الطالب --}}
<form method="POST"
      action="{{ route('submissions.grade', $submission) }}"
      class="space-y-5 rounded-xl border border-slate-200 bg-slate-50 p-5">

    @csrf
    @method('PUT')

    <div>
        <h5 class="text-lg font-bold text-slate-900">
            {{ $isArabic ? 'تصحيح تسليم الطالب' : 'Grade Student Submission' }}
        </h5>

        <p class="mt-1 text-sm text-slate-500">
            {{ $isArabic
                ? 'أدخلي الدرجة والملاحظات، ويمكنك تعديلهما لاحقًا.'
                : 'Enter the score and feedback. You can update them later.' }}
        </p>
    </div>

    {{-- الدرجة --}}
    <div>
        <label for="score-{{ $submission->id }}"
               class="mb-2 block text-sm font-semibold text-slate-700">
            {{ $isArabic ? 'الدرجة' : 'Score' }}
            ({{ $isArabic ? 'من' : 'out of' }} {{ $assignment->max_score }})
        </label>

        <input
            id="score-{{ $submission->id }}"
            type="number"
            name="score"
            min="0"
            max="{{ $assignment->max_score }}"
            step="0.01"
            value="{{ old('score', $submission->score) }}"
            required
            class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500"
        >

        @error('score')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- ملاحظات المدرّب --}}
    <div>
        <label for="feedback-{{ $submission->id }}"
               class="mb-2 block text-sm font-semibold text-slate-700">
            {{ $isArabic ? 'ملاحظات التصحيح' : 'Grading Feedback' }}
        </label>

        <textarea
            id="feedback-{{ $submission->id }}"
            name="instructor_feedback"
            rows="4"
            class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500"
            placeholder="{{ $isArabic
                ? 'اكتبي ملاحظاتك على إجابة الطالب...'
                : 'Write feedback about the student answer...' }}"
        >{{ old('instructor_feedback', $submission->instructor_feedback) }}</textarea>

        @error('instructor_feedback')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- حفظ التصحيح ونشر النتيجة --}}
    <button
        type="submit"
        class="inline-flex items-center gap-2 rounded-lg bg-indigo-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
    >
        <span>
            {{ $submission->status === 'graded'
                ? ($isArabic ? 'تحديث التصحيح' : 'Update Grade')
                : ($isArabic ? 'حفظ وإرسال النتيجة' : 'Save and Publish Grade') }}
        </span>
    </button>

</form>

                                    @empty

                                        <div class="rounded-lg border border-dashed border-gray-300 bg-white px-5 py-8 text-center">
                                            <p class="font-medium text-gray-700">
                                                {{ $isArabic ? 'لا توجد تسليمات لهذا الواجب حتى الآن.' : 'No submissions for this assignment yet.' }}
                                            </p>

                                            <p class="mt-1 text-sm text-gray-500">
                                                {{ $isArabic
                                                    ? 'ستظهر تسليمات الطلاب هنا بعد إرسالها.'
                                                    : 'Student submissions will appear here once submitted.' }}
                                            </p>
                                        </div>

                                    @endforelse

                                </div>
                            </div>

                        </details>
                    </div>

                @empty

                    <div class="rounded-lg border border-dashed border-gray-300 px-6 py-12 text-center">
                        <h3 class="font-semibold text-gray-800">
                            {{ $isArabic ? 'لا توجد واجبات حاليًا' : 'No Assignments Available' }}
                        </h3>

                        <p class="mt-2 text-sm text-gray-500">
                            {{ $isArabic
                                ? 'ستظهر الواجبات هنا بعد إضافتها إلى الكورس.'
                                : 'Assignments will appear here once they are added to the course.' }}
                        </p>
                    </div>

                @endforelse
            </section>

        </div>
    </div>
</x-app-layout>


