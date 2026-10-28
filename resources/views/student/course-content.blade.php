
<x-app-layout>
    <x-slot name="header">

    </x-slot>

    @php
        $isArabic = app()->getLocale() === 'ar';
        $orderedLessons = $lessons->sortBy([
            ['week_number', 'asc'],
            ['sort_order', 'asc'],
        ]);
        $lessonsByWeek = $orderedLessons->groupBy('week_number');
    @endphp

    <div class="min-h-screen bg-slate-50 py-8"
         dir="{{ $isArabic ? 'rtl' : 'ltr' }}">

        <div class="mx-auto max-w-6xl space-y-8 px-4 sm:px-6 lg:px-8">
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
            <section class="grid grid-cols-1 gap-4 sm:grid-cols-3">

                <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">
                        {{ $isArabic ? 'إجمالي الدروس' : 'Total Lessons' }}
                    </p>
                    <p class="mt-3 text-3xl font-bold text-slate-900">
                        {{ $lessons->count() }}
                    </p>
                    <div class="mt-4 h-1 rounded-full bg-slate-100">
                        <div class="h-1 w-full rounded-full bg-indigo-600"></div>
                    </div>
                </div>

                <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">
                        {{ $isArabic ? 'إجمالي الواجبات' : 'Total Assignments' }}
                    </p>
                    <p class="mt-3 text-3xl font-bold text-slate-900">
                        {{ $assignments->count() }}
                    </p>
                    <div class="mt-4 h-1 rounded-full bg-slate-100">
                        <div class="h-1 w-full rounded-full bg-sky-600"></div>
                    </div>
                </div>

                <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">
                        {{ $isArabic ? 'الواجبات المسلّمة' : 'Submitted Assignments' }}
                    </p>
                    <p class="mt-3 text-3xl font-bold text-slate-900">
                        {{ $assignments->filter(fn ($assignment) => $assignment->submissions->isNotEmpty())->count() }}
                    </p>
                    <div class="mt-4 h-1 rounded-full bg-slate-100">
                        <div class="h-1 w-full rounded-full bg-emerald-600"></div>
                    </div>
                </div>

            </section>

            {{-- الدروس --}}
            <section class="space-y-5">

                <div class="flex flex-wrap items-end justify-between gap-3">
                    <div>
                        <h3 class="text-xl font-bold text-slate-900">
                            {{ $isArabic ? 'الخطة التعليمية' : 'Course Curriculum' }}
                        </h3>
                        <p class="mt-1 text-sm text-slate-500">
                            {{ $isArabic ? 'الدروس مرتبة حسب الأسبوع والترتيب المحدد لها.' : 'Lessons are organized by week and lesson order.' }}
                        </p>
                    </div>

                    <span class="text-sm text-slate-500">
                        {{ $isArabic ? 'عدد الأسابيع التي تحتوي على دروس:' : 'Weeks with lessons:' }}
                        <strong class="text-slate-800">{{ $lessonsByWeek->count() }}</strong>
                    </span>
                </div>

                @forelse ($lessonsByWeek as $weekNumber => $weekLessons)

                    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

                        {{-- عنوان الأسبوع --}}
                        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-200 bg-slate-50 px-5 py-4 sm:px-6">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-100 font-bold text-indigo-800">
                                    {{ $weekNumber }}
                                </div>

                                <div>
                                    <h4 class="font-bold text-slate-900">
                                        {{ $isArabic ? 'الأسبوع ' : 'Week ' }}{{ $weekNumber }}
                                    </h4>
                                    <p class="mt-1 text-xs text-slate-500">
                                        {{ $isArabic ? 'المواد التعليمية للأسبوع' : 'Weekly learning materials' }}
                                    </p>
                                </div>
                            </div>

                            <span class="rounded-full border border-slate-200 bg-white px-3 py-1 text-xs font-semibold text-slate-600">
                                {{ $weekLessons->count() }}
                                {{ $isArabic ? 'دروس' : 'Lessons' }}
                            </span>
                        </div>

                        {{-- قائمة الدروس --}}
                        <div class="divide-y divide-slate-100">

                            @foreach ($weekLessons as $lesson)

                                <details class="group">
                                    <summary class="flex cursor-pointer list-none items-center gap-4 px-5 py-5 transition hover:bg-slate-50 sm:px-6">

                                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg border border-slate-200 bg-white text-sm font-bold text-slate-600">
                                            {{ $loop->iteration }}
                                        </div>

                                        <div class="min-w-0 flex-1">
                                            <h5 class="font-semibold text-slate-800">
                                                {{ $lesson->title }}
                                            </h5>
                                            <p class="mt-1 text-sm text-slate-500">
                                                {{ $isArabic ? 'الدرس ' : 'Lesson ' }}{{ $lesson->sort_order }}
                                            </p>
                                        </div>

                                        <span class="text-xs font-semibold text-indigo-700 group-open:hidden">
                                            {{ $isArabic ? 'عرض التفاصيل' : 'View details' }}
                                        </span>

                                        <span class="hidden text-xs font-semibold text-indigo-700 group-open:inline">
                                            {{ $isArabic ? 'إخفاء التفاصيل' : 'Hide details' }}
                                        </span>

                                        <svg class="h-4 w-4 shrink-0 text-slate-400 transition group-open:rotate-180"
                                             viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                  d="M5.22 7.22a.75.75 0 011.06 0L10 10.94l3.72-3.72a.75.75 0 111.06 1.06l-4.25 4.25a.75.75 0 01-1.06 0L5.22 8.28a.75.75 0 010-1.06z"
                                                  clip-rule="evenodd"/>
                                        </svg>

                                    </summary>

                                    <div class="space-y-5 border-t border-slate-100 bg-white px-5 py-5 sm:px-6">

                                        @if ($lesson->content)
                                            <div>
                                                <h6 class="mb-2 text-sm font-bold text-slate-800">
                                                    {{ $isArabic ? 'محتوى الدرس' : 'Lesson Description' }}
                                                </h6>
                                                <div class="whitespace-pre-line text-sm leading-8 text-slate-600">
                                                    {{ $lesson->content }}
                                                </div>
                                            </div>
                                        @endif

                                        @if ($lesson->video_url)
                                            <div class="border-t border-slate-100 pt-4">
                                                <h6 class="mb-3 text-sm font-bold text-slate-800">
                                                    {{ $isArabic ? 'المحاضرة المسجلة' : 'Recorded Lecture' }}
                                                </h6>

                                                <a href="{{ $lesson->video_url }}"
                                                   target="_blank"
                                                   rel="noopener noreferrer"
                                                   class="inline-flex items-center justify-center rounded-lg bg-indigo-700 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                                    {{ $isArabic ? 'فتح المحاضرة' : 'Open Lecture' }}
                                                </a>
                                            </div>
                                        @endif

                                        @if (! $lesson->content && ! $lesson->video_url)
                                            <p class="text-sm text-slate-500">
                                                {{ $isArabic ? 'لم تتم إضافة محتوى لهذا الدرس بعد.' : 'No content has been added to this lesson yet.' }}
                                            </p>
                                        @endif

                                    </div>
                                </details>

                            @endforeach

                        </div>
                    </div>

                @empty
                    <div class="rounded-xl border border-dashed border-slate-300 bg-white px-6 py-14 text-center">
                        <h4 class="font-bold text-slate-800">
                            {{ $isArabic ? 'لا توجد دروس حاليًا' : 'No Lessons Available' }}
                        </h4>
                        <p class="mt-2 text-sm text-slate-500">
                            {{ $isArabic ? 'ستظهر الدروس هنا عند إضافتها إلى الكورس.' : 'Lessons will appear here when they are added to the course.' }}
                        </p>
                    </div>
                @endforelse

            </section>

            {{-- الواجبات والتقييمات --}}
            <section class="space-y-5">

                <div>
                    <h3 class="text-xl font-bold text-slate-900">
                        {{ $isArabic ? 'الواجبات والتقييمات' : 'Assignments & Assessments' }}
                    </h3>
                    <p class="mt-1 text-sm text-slate-500">
                        {{ $isArabic ? 'تابع متطلبات الواجبات وحالة التسليم والدرجات.' : 'Review assignment requirements, submission status, and grades.' }}
                    </p>
                </div>

                <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

                    <div class="flex items-center justify-between border-b border-slate-200 bg-slate-50 px-5 py-4 sm:px-6">
                        <h4 class="font-bold text-slate-800">
                            {{ $isArabic ? 'قائمة الواجبات' : 'Assignment List' }}
                        </h4>
                        <span class="text-sm font-semibold text-slate-600">
                            {{ $assignments->count() }}
                        </span>
                    </div>

                    @forelse ($assignments as $assignment)

                        @php
                            $submission = $assignment->submissions->first();
                            $closed = $assignment->due_at && $assignment->due_at->isPast();
                        @endphp

                        <details class="group border-b border-slate-100 last:border-b-0">

                            <summary class="flex cursor-pointer list-none items-center gap-4 px-5 py-5 transition hover:bg-slate-50 sm:px-6">

                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg border border-slate-200 bg-white text-sm font-bold text-slate-600">
                                    {{ $loop->iteration }}
                                </div>

                                <div class="min-w-0 flex-1">
                                    <h5 class="font-semibold text-slate-800">
                                        {{ $assignment->title }}
                                    </h5>

                                    <p class="mt-1 text-xs text-slate-500">
                                        @if ($submission?->status === 'graded')
                                            {{ $isArabic ? 'تم التصحيح' : 'Graded' }}
                                        @elseif ($submission)
                                            {{ $isArabic ? 'تم التسليم' : 'Submitted' }}
                                        @elseif ($closed)
                                            {{ $isArabic ? 'انتهى موعد التسليم' : 'Deadline passed' }}
                                        @else
                                            {{ $isArabic ? 'بانتظار التسليم' : 'Awaiting submission' }}
                                        @endif
                                    </p>
                                </div>

                                @if ($submission?->status === 'graded')
                                    <span class="rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-700">
                                        {{ $isArabic ? 'تم التصحيح' : 'Graded' }}
                                    </span>
                                @elseif ($submission)
                                    <span class="rounded-full bg-green-50 px-3 py-1 text-xs font-semibold text-green-700">
                                        {{ $isArabic ? 'تم التسليم' : 'Submitted' }}
                                    </span>
                                @elseif ($closed)
                                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                                        {{ $isArabic ? 'مغلق' : 'Closed' }}
                                    </span>
                                @else
                                    <span class="rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-700">
                                        {{ $isArabic ? 'مطلوب' : 'Pending' }}
                                    </span>
                                @endif

                                <svg class="h-4 w-4 shrink-0 text-slate-400 transition group-open:rotate-180"
                                     viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M5.22 7.22a.75.75 0 011.06 0L10 10.94l3.72-3.72a.75.75 0 111.06 1.06l-4.25 4.25a.75.75 0 01-1.06 0L5.22 8.28a.75.75 0 010-1.06z"
                                          clip-rule="evenodd"/>
                                </svg>

                            </summary>

                            <div class="space-y-5 border-t border-slate-100 px-5 py-5 sm:px-6">

                                @if ($assignment->instructions)
                                    <div>
                                        <h6 class="mb-2 text-sm font-bold text-slate-800">
                                            {{ $isArabic ? 'تعليمات الواجب' : 'Instructions' }}
                                        </h6>
                                        <div class="whitespace-pre-line text-sm leading-7 text-slate-600">
                                            {{ $assignment->instructions }}
                                        </div>
                                    </div>
                                @endif

                                <div class="flex flex-wrap gap-3 text-sm text-slate-600">
                                    <span class="rounded-lg bg-slate-50 px-3 py-2">
                                        {{ $isArabic ? 'الدرجة الكاملة:' : 'Maximum score:' }}
                                        <strong>{{ $assignment->max_score }}</strong>
                                    </span>

                                    @if ($assignment->due_at)
                                        <span class="rounded-lg bg-slate-50 px-3 py-2">
                                            {{ $isArabic ? 'موعد التسليم:' : 'Due date:' }}
                                            {{ $assignment->due_at->format('Y-m-d H:i') }}
                                        </span>
                                    @endif
                                </div>

                                {{-- بعد التصحيح --}}
                                @if ($submission?->status === 'graded')

                                    <div class="rounded-xl border border-indigo-100 bg-indigo-50 p-5">
                                        <p class="text-sm font-semibold text-indigo-900">
                                            {{ $isArabic ? 'الدرجة المحصّلة' : 'Your Score' }}
                                        </p>

                                        <p class="mt-2 text-2xl font-bold text-indigo-800">
                                            {{ $submission->score ?? '—' }}
                                            <span class="text-base font-medium text-indigo-600">
                                                / {{ $assignment->max_score }}
                                            </span>
                                        </p>

                                        @if ($submission->instructor_feedback)
                                            <div class="mt-4 border-t border-indigo-100 pt-4">
                                                <h6 class="text-sm font-bold text-indigo-900">
                                                    {{ $isArabic ? 'ملاحظات المدرب' : 'Instructor Feedback' }}
                                                </h6>
                                                <p class="mt-2 whitespace-pre-line text-sm leading-7 text-indigo-900">
                                                    {{ $submission->instructor_feedback }}
                                                </p>
                                            </div>
                                        @endif
                                    </div>

                                {{-- تم التسليم --}}
                                @elseif ($submission)

                                    <div class="rounded-lg border border-green-200 bg-green-50 p-4 text-sm text-green-800">
                                        <p class="font-semibold">
                                            {{ $isArabic ? 'تم تسليم الواجب بنجاح.' : 'Assignment submitted successfully.' }}
                                        </p>

                                        @if ($submission->answer)
                                            <p class="mt-3 whitespace-pre-line leading-7">
                                                {{ $submission->answer }}
                                            </p>
                                        @endif

                                        @if ($submission->file_path)
                                            <p class="mt-3 text-xs">
                                                {{ $isArabic ? 'تم إرفاق ملف مع التسليم.' : 'A file was attached to the submission.' }}
                                            </p>
                                        @endif

                                        <p class="mt-3 text-xs">
                                            {{ $isArabic ? 'بانتظار مراجعة المدرب وتصحيح الواجب.' : 'Waiting for instructor review and grading.' }}
                                        </p>
                                    </div>

                                {{-- انتهى الموعد --}}
                                @elseif ($closed)

                                    <div class="rounded-lg border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600">
                                        {{ $isArabic ? 'انتهى موعد تسليم هذا الواجب.' : 'The deadline for this assignment has passed.' }}
                                    </div>

                                {{-- نموذج التسليم --}}
                                @else

                                    <form method="POST"
                                          action="{{ route('submissions.store', $assignment) }}"
                                          enctype="multipart/form-data"
                                          class="space-y-5 border-t border-slate-100 pt-5">

                                        @csrf

                                        <div>
                                            <label for="answer-{{ $assignment->id }}"
                                                   class="mb-2 block text-sm font-semibold text-slate-700">
                                                {{ $isArabic ? 'الإجابة النصية' : 'Written Answer' }}
                                            </label>

                                            <textarea
                                                id="answer-{{ $assignment->id }}"
                                                name="answer"
                                                rows="5"
                                                class="w-full rounded-lg border-slate-300 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                placeholder="{{ $isArabic ? 'اكتب إجابتك هنا...' : 'Write your answer here...' }}"
                                            >{{ old('answer') }}</textarea>

                                            @error('answer')
                                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="file-{{ $assignment->id }}"
                                                   class="mb-2 block text-sm font-semibold text-slate-700">
                                                {{ $isArabic ? 'إرفاق ملف (اختياري)' : 'Attach File (Optional)' }}
                                            </label>

                                            <input
                                                id="file-{{ $assignment->id }}"
                                                type="file"
                                                name="file"
                                                accept=".pdf,.doc,.docx,.zip"
                                                class="block w-full text-sm text-slate-600 file:me-3 file:rounded-lg file:border-0 file:bg-slate-100 file:px-4 file:py-2 file:font-semibold hover:file:bg-slate-200"
                                            >

                                            <p class="mt-2 text-xs text-slate-500">
                                                {{ $isArabic ? 'الصيغ المدعومة: PDF وDOC وDOCX وZIP، بحد أقصى 10 ميغابايت.' : 'Supported formats: PDF, DOC, DOCX, ZIP. Maximum size: 10 MB.' }}
                                            </p>

                                            @error('file')
                                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <button type="submit"
                                                class="inline-flex items-center justify-center rounded-lg bg-indigo-700 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                            {{ $isArabic ? 'تسليم الواجب' : 'Submit Assignment' }}
                                        </button>

                                    </form>

                                @endif

                            </div>
                        </details>

                    @empty
                        <div class="px-6 py-12 text-center">
                            <h4 class="font-bold text-slate-800">
                                {{ $isArabic ? 'لا توجد واجبات حاليًا' : 'No Assignments Available' }}
                            </h4>
                            <p class="mt-2 text-sm text-slate-500">
                                {{ $isArabic ? 'ستظهر الواجبات هنا عند إضافتها إلى الكورس.' : 'Assignments will appear here when they are added to the course.' }}
                            </p>
                        </div>
                    @endforelse

                </div>
            </section>

            {{-- تذييل الصفحة --}}
            <footer class="border-t border-slate-200 pt-5 text-center text-xs text-slate-500">
                {{ $isArabic ? 'منصة Academics للتعليم الإلكتروني' : 'Academics E-Learning Platform' }}
            </footer>

        </div>
    </div>
</x-app-layout>
