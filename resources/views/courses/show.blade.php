@php($ar = app()->getLocale() === 'ar')
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ $ar ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $course->localized('title') }} | Academics</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-stone-50 text-slate-800 antialiased">

    <x-app-layout>
        <nav class="mx-auto max-w-6xl px-6 py-5 text-sm text-slate-500" aria-label="Breadcrumb">
            <a href="/" class="hover:text-blue-900">{{ $ar ? 'الرئيسية' : 'Home' }}</a>
            <span class="mx-2 text-slate-300">/</span>
            <a href="{{ route('courses.index') }}" class="hover:text-blue-900">{{ $ar ? 'الكورسات' : 'Courses' }}</a>
            <span class="mx-2 text-slate-300">/</span>
            <span class="text-slate-800">{{ $course->localized('title') }}</span>
        </nav>

        <main class="mx-auto max-w-6xl px-6 pb-16">
            <div class="grid grid-cols-1 gap-10 lg:grid-cols-3">
                <section class="space-y-10 lg:col-span-2">
                    <div>
                        <div class="mb-4 flex flex-wrap items-center gap-2 text-sm">
                            <span class="rounded bg-blue-950/5 px-3 py-1 font-medium text-blue-950">
                                {{ $course->localized('category') }}
                            </span>
                            <span class="rounded bg-slate-100 px-3 py-1 font-medium text-slate-700">
                                {{ $course->localized('level') }}
                            </span>
                            @if($course->is_published)
                                <span class="rounded bg-emerald-50 px-3 py-1 font-medium text-emerald-800">
                                    {{ $ar ? 'منشور' : 'Published' }}
                                </span>
                            @else
                                <span class="rounded bg-amber-50 px-3 py-1 font-medium text-amber-800">
                                    {{ $ar ? 'مسودة' : 'Draft' }}
                                </span>
                            @endif
                        </div>

                        <h1 class="font-serif text-3xl font-bold leading-tight text-blue-950 md:text-4xl">
                            {{ $course->localized('title') }}
                        </h1>

                        <p class="mt-3 text-sm text-slate-500">
                            {{ __('site.teacher') }}:
                            <span class="font-medium text-slate-700">{{ $course->instructor?->name ?? '—' }}</span>
                        </p>

                        @if($course->localized('short_description'))
                            <p class="mt-5 max-w-2xl text-lg leading-8 text-slate-600">
                                {{ $course->localized('short_description') }}
                            </p>
                        @endif
                    </div>


                    <div class="overflow-hidden rounded-lg border border-slate-200 bg-slate-100">
                        @if($course->image)
                            <img src="{{ $course->imageUrl() }}"
                                 alt="{{ $course->localized('title') }}"
                                 class="h-72 w-full object-cover md:h-96">
                        @else
                            <div class="flex h-72 items-center justify-center bg-blue-950 md:h-96">
                                <span class="font-serif text-7xl text-white/80">
                                    {{ mb_substr($course->localized('title'), 0, 1) }}
                                </span>
                            </div>
                        @endif
                    </div>
                    <div>
                        <h2 class="border-b border-slate-200 pb-3 font-serif text-2xl font-bold text-blue-950">
                            {{ $ar ? 'عن الكورس' : 'About This Course' }}
                        </h2>
                        <div class="mt-5 max-w-3xl whitespace-pre-line leading-8 text-slate-600">
                            {{ $course->localized('description') }}
                        </div>
                    </div>
                    <div>
                        <h2 class="border-b border-slate-200 pb-3 font-serif text-2xl font-bold text-blue-950">
                            {{ $ar ? 'ماذا ستتعلم؟' : 'What You Will Learn' }}
                        </h2>

                        <ul class="mt-5 grid grid-cols-1 gap-x-8 gap-y-3 sm:grid-cols-2">
                            @forelse ($course->lessons as $lesson)
                                <li class="flex gap-3 text-slate-700">
                                    <span class="mt-0.5 text-emerald-700">✓</span>
                                    <span>{{ $lesson->title }}</span>
                                </li>
                            @empty
                                <li class="text-slate-500 sm:col-span-2">
                                    {{ $ar ? 'لا توجد دروس مضافة لهذا الكورس بعد.' : 'No lessons have been added to this course yet.' }}
                                </li>
                            @endforelse
                        </ul>
                    </div>

                    {{-- Enrolled students --}}
                    <div>
                        <h2 class="border-b border-slate-200 pb-3 font-serif text-2xl font-bold text-blue-950">
                            {{ $ar ? 'الطلاب المسجلون' : 'Enrolled Students' }}
                        </h2>

                        <div class="mt-5 overflow-x-auto rounded-lg border border-slate-200 bg-white">
                            <table class="min-w-full text-sm">
                                <thead class="bg-slate-50 text-slate-500">
                                    <tr>
                                        <th class="px-4 py-3 text-start font-semibold">{{ $ar ? 'الاسم' : 'Name' }}</th>
                                        <th class="px-4 py-3 text-start font-semibold">{{ $ar ? 'البريد' : 'Email' }}</th>
                                        <th class="px-4 py-3 text-start font-semibold">{{ $ar ? 'حالة التسجيل' : 'Status' }}</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @forelse ($students as $student)
                                        <tr>
                                            <td class="px-4 py-3 font-medium text-slate-800">{{ $student->name }}</td>
                                            <td class="px-4 py-3 text-slate-600">{{ $student->email }}</td>
                                            <td class="px-4 py-3 text-slate-600">{{ $student->pivot->status }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-4 py-6 text-center text-slate-500">
                                                {{ $ar ? 'لا يوجد طلاب مسجلون.' : 'No students enrolled yet.' }}
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">{{ $students->links() }}</div>
                    </div>

                    @can('update', $course)
                        <div>
                            <h2 class="border-b border-slate-200 pb-3 font-serif text-2xl font-bold text-blue-950">
                                {{ $ar ? 'مدفوعات هذا الكورس' : 'Course Payments' }}
                            </h2>

                            <div class="mt-5 overflow-x-auto rounded-lg border border-slate-200 bg-white">
                                <table class="min-w-full text-sm">
                                    <thead class="bg-slate-50 text-slate-500">
                                        <tr>
                                            <th class="px-4 py-3 text-start font-semibold">{{ $ar ? 'الطالب' : 'Student' }}</th>
                                            <th class="px-4 py-3 text-start font-semibold">{{ $ar ? 'المبلغ' : 'Amount' }}</th>
                                            <th class="px-4 py-3 text-start font-semibold">{{ $ar ? 'الحالة' : 'Status' }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100">
                                        @forelse ($payments as $payment)
                                            <tr>
                                                <td class="px-4 py-3 font-medium text-slate-800">{{ $payment->user->name }}</td>
                                                <td class="px-4 py-3 text-slate-600">{{ number_format((float) $payment->amount, 2) }}</td>
                                                <td class="px-4 py-3 text-slate-600">{{ $payment->status }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="px-4 py-6 text-center text-slate-500">
                                                    {{ $ar ? 'لا توجد مدفوعات.' : 'No payments yet.' }}
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-4">{{ $payments->links() }}</div>
                        </div>
                    @endcan

                </section>

                {{-- Side panel --}}
                <aside>
                    <div class="sticky top-6 overflow-hidden rounded-lg border border-slate-200 bg-white">

                        <div class="bg-blue-950 px-6 py-6 text-white">
                            <p class="text-sm text-blue-200">{{ $ar ? 'سعر الكورس' : 'Course Price' }}</p>
                            <p class="mt-1 font-serif text-4xl font-bold">
                                {{ number_format((float) $course->price, 2) }}
                            </p>
                        </div>

                        <div class="p-6">
                            <h2 class="font-serif text-lg font-bold text-blue-950">
                                {{ $ar ? 'معلومات الكورس' : 'Course Information' }}
                            </h2>

                            <dl class="mt-4 divide-y divide-slate-100 text-sm">
                                <div class="flex items-center justify-between gap-3 py-3">
                                    <dt class="text-slate-500">{{ $ar ? 'التصنيف' : 'Category' }}</dt>
                                    <dd class="font-semibold text-slate-800">{{ $course->localized('category') }}</dd>
                                </div>
                                <div class="flex items-center justify-between gap-3 py-3">
                                    <dt class="text-slate-500">{{ $ar ? 'المدة' : 'Duration' }}</dt>
                                    <dd class="font-semibold text-slate-800">
                                        {{ $course->duration_weeks }} {{ $ar ? 'أسبوع' : 'weeks' }}
                                    </dd>
                                </div>
                                <div class="flex items-center justify-between gap-3 py-3">
                                    <dt class="text-slate-500">{{ $ar ? 'المستوى' : 'Level' }}</dt>
                                    <dd class="font-semibold text-slate-800">{{ $course->localized('level') }}</dd>
                                </div>
                                <div class="flex items-center justify-between gap-3 py-3">
                                    <dt class="text-slate-500">{{ $ar ? 'الحالة' : 'Status' }}</dt>
                                    <dd class="font-semibold text-slate-800">
                                        {{ $course->is_published ? ($ar ? 'متاح' : 'Available') : ($ar ? 'غير منشور' : 'Unpublished') }}
                                    </dd>
                                </div>
                            </dl>

                            <div class="mt-6 grid gap-3">
                                @can('update', $course)
                                    <a href="{{ route('courses.edit', $course) }}"
                                       class="rounded-md bg-blue-950 px-5 py-2.5 text-center text-sm font-semibold text-white transition hover:bg-blue-900">
                                        {{ $ar ? 'تعديل بيانات الكورس' : 'Edit Course' }}
                                    </a>
                                @endcan

                                @can('submissions.view.any')
                                    <a href="{{ route('submissions.index') }}"
                                       class="rounded-md border border-slate-300 px-5 py-2.5 text-center text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                                        {{ $ar ? 'عرض التسليمات وتصحيحها' : 'Review Submissions' }}
                                    </a>
                                @endcan

                                <a href="{{ route('courses.index') }}"
                                   class="rounded-md border border-slate-300 px-5 py-2.5 text-center text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                                    {{ $ar ? 'العودة إلى الكورسات' : 'Back to Courses' }}
                                </a>
                            </div>
                        </div>
                    </div>
                </aside>

            </div>
        </main>

        {{-- Footer --}}
        <footer class="border-t border-slate-200 bg-white">
            <div class="mx-auto max-w-6xl px-6 py-6 text-center text-sm text-slate-500">
                © {{ date('Y') }} Academics. {{ $ar ? 'جميع الحقوق محفوظة.' : 'All rights reserved.' }}
            </div>
        </footer>

    </x-app-layout>

</body>
</html>
