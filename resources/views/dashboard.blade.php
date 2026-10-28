<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">{{ $isAdmin ? 'لوحة تحكم المدير' : ($instructorCourses->isNotEmpty() || auth()->user()->can('courses.view.own') ? 'لوحة المدرب' : 'لوحة الطالب') }}</h2>
            @if ($isAdmin)
                <nav class="flex flex-wrap gap-3 text-sm">
                    <a href="{{ route('courses.index') }}" class="text-indigo-700">الكورسات</a>
                    <a href="{{ route('instructors.index') }}" class="text-indigo-700">المدربون</a>
                    <a href="{{ route('enrollments.index') }}" class="text-indigo-700">التسجيلات</a>
                    <a href="{{ route('payments.index') }}" class="text-indigo-700">المدفوعات</a>
                    <a href="{{ route('submissions.index') }}" class="text-indigo-700">التسليمات</a>
                </nav>
            @elseif (auth()->user()->can('courses.view.own'))
                <a href="{{ route('courses.index') }}" class="text-indigo-700">كورساتي</a>
            @else
                <a href="{{ route('submissions.index') }}" class="text-indigo-700">واجباتي وتسليماتي</a>
            @endif
        </div>
    </x-slot>

    <div class="py-8" dir="rtl">
        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="rounded-lg border border-green-200 bg-green-50 p-4 text-green-800" role="status">{{ session('success') }}</div>
            @endif

            <section class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @php
                    $cards = [
                        ['الطلاب', $stats['students']],
                        ['المدربون', $stats['instructors']],
                        ['الكورسات', $stats['courses']],
                        ['الكورسات المنشورة', $stats['published_courses']],
                        ['الدروس', $stats['lessons']],
                        ['الواجبات', $stats['assignments']],
                        ['تسجيلات الطلاب', $stats['enrollments']],
                        ['تسليمات تنتظر التصحيح', $stats['pending_submissions']],
                    ];
                    if ($isAdmin) {
                        $cards[] = ['المدفوعات المؤكدة', $stats['successful_payments']];
                        $cards[] = ['المدفوعات المعلقة', $stats['pending_payments']];
                        $cards[] = ['الإيرادات المؤكدة', number_format((float) $stats['revenue'], 2)];
                    }
                @endphp
                @foreach ($cards as [$label, $value])
                    <article class="rounded-lg bg-white p-5 shadow-sm">
                        <p class="text-sm text-gray-500">{{ $label }}</p>
                        <p class="mt-2 text-3xl font-bold text-gray-900">{{ $value }}</p>
                    </article>
                @endforeach
            </section>

            @if ($isAdmin)
                @php
                    // أكبر قيمة لا تقل عن 1 لتجنب القسمة على صفر
                    $registrationMax = max(1, (float) collect($monthlyRegistrations)->max());
                    $revenueMax = max(1, (float) collect($monthlyRevenue)->max());
                @endphp

                <section class="grid gap-6 lg:grid-cols-2">
                    <article class="rounded-lg bg-white p-6 shadow-sm">
                        <h3 class="mb-5 font-bold">التسجيلات الشهرية</h3>
                        <div class="flex h-48 items-end gap-3 border-b border-gray-200">
                            @foreach ($monthlyRegistrations as $month => $count)
                                <div class="flex h-full flex-1 flex-col justify-end text-center">
                                    <span class="mb-1 text-xs">{{ $count }}</span>
                                    <div class="mx-auto w-full max-w-12 rounded-t bg-blue-600"
                                         style="height: {{ $count > 0 ? max(5, ($count / $registrationMax) * 75) : 0 }}%"></div>
                                    <span class="mt-2 text-xs text-gray-500">{{ $month }}</span>
                                </div>
                            @endforeach
                        </div>
                    </article>

                    <article class="rounded-lg bg-white p-6 shadow-sm">
                        <h3 class="mb-5 font-bold">الإيرادات الشهرية المؤكدة</h3>
                        <div class="flex h-48 items-end gap-3 border-b border-gray-200">
                            @foreach ($monthlyRevenue as $month => $amount)
                                <div class="flex h-full flex-1 flex-col justify-end text-center">
                                    <span class="mb-1 text-xs">{{ number_format($amount, 0) }}</span>
                                    <div class="mx-auto w-full max-w-12 rounded-t bg-emerald-600"
                                         style="height: {{ $amount > 0 ? max(5, ($amount / $revenueMax) * 75) : 0 }}%"></div>
                                    <span class="mt-2 text-xs text-gray-500">{{ $month }}</span>
                                </div>
                            @endforeach
                        </div>
                    </article>
                </section>

                <section class="grid gap-6 lg:grid-cols-2">
                    <article class="overflow-x-auto rounded-lg bg-white p-5 shadow-sm">
                        <h3 class="mb-4 font-bold">أحدث التسجيلات</h3>
                        <table class="min-w-full text-sm">
                            <thead><tr class="text-right text-gray-500"><th class="py-2">الطالب</th><th>الكورس</th><th>الحالة</th><th>التاريخ</th></tr></thead>
                            <tbody class="divide-y">
                                @forelse ($latestEnrollments as $enrollment)
                                    <tr><td class="py-2">{{ $enrollment->user->name }}</td><td>{{ $enrollment->course->localized('title') }}</td><td>{{ $enrollment->status }}</td><td>{{ $enrollment->enrolled_at->format('Y-m-d') }}</td></tr>
                                @empty
                                    <tr><td colspan="4" class="py-4 text-center text-gray-500">لا توجد تسجيلات.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </article>
                    <article class="overflow-x-auto rounded-lg bg-white p-5 shadow-sm">
                        <h3 class="mb-4 font-bold">أحدث المدفوعات</h3>
                        <table class="min-w-full text-sm">
                            <thead><tr class="text-right text-gray-500"><th class="py-2">الطالب</th><th>الكورس</th><th>المبلغ</th><th>الحالة</th></tr></thead>
                            <tbody class="divide-y">
                                @forelse ($latestPayments as $payment)
                                    <tr><td class="py-2">{{ $payment->user->name }}</td><td>{{ $payment->enrollment->course->localized('title') }}</td><td>{{ number_format((float) $payment->amount, 2) }}</td><td>{{ $payment->status }}</td></tr>
                                @empty
                                    <tr><td colspan="4" class="py-4 text-center text-gray-500">لا توجد مدفوعات.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </article>
                </section>
            @endif

            @if (auth()->user()->can('courses.view.own'))
                <section class="rounded-lg bg-white p-5 shadow-sm">
                    <h3 class="mb-4 font-bold">الكورسات المسندة إليك</h3>
                    @forelse ($instructorCourses as $course)
                        <p class="border-b py-3">
                            <a href="{{ route('courses.show', $course) }}" class="font-semibold text-indigo-700">{{ $course->localized('title') }}</a>
                            <span class="text-sm text-gray-500">· {{ $course->enrollments_count }} تسجيل</span>
                        </p>
                    @empty
                        <p class="text-gray-500">لا توجد كورسات مسندة إلى حسابك.</p>
                    @endforelse
                </section>
            @endif

            <section class="rounded-lg bg-white p-5 shadow-sm">
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="font-bold">{{ auth()->user()->isStudent() ? 'تسليماتك الأخيرة' : 'أحدث التسليمات' }}</h3>
                    <a href="{{ route('submissions.index') }}" class="text-sm text-indigo-700">عرض الكل</a>
                </div>
                <div class="space-y-3">
                    @forelse ($latestSubmissions as $submission)
                        <div class="flex flex-wrap justify-between gap-2 border-b pb-3 text-sm">
                            <span>{{ $submission->assignment->title }} · {{ $submission->assignment->course->localized('title') }}</span>
                            @if ($isAdmin || auth()->user()->can('submissions.view.own'))
                                <span>{{ $submission->user->name }}</span>
                            @endif
                            <span>{{ $submission->status }} @if ($submission->status === 'graded') · {{ $submission->score }} / {{ $submission->assignment->max_score }} @endif</span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">لا توجد تسليمات.</p>
                    @endforelse
                </div>
            </section>

            @if (auth()->user()->isStudent())
                <section class="grid gap-6 lg:grid-cols-2">
                    <article class="rounded-lg bg-white p-5 shadow-sm">
                        <h3 class="mb-4 font-bold">تسجيلاتك</h3>
                        @forelse ($myEnrollments as $enrollment)
                            <p class="border-b py-3">
                                <a href="{{ route('course.show', $enrollment->course) }}" class="text-indigo-700">{{ $enrollment->course->localized('title') }}</a>
                                <span>· {{ $enrollment->status }}</span>
                            </p>
                        @empty
                            <p class="text-gray-500">ليس لديك تسجيلات بعد.</p>
                        @endforelse
                    </article>
                    <article class="rounded-lg bg-white p-5 shadow-sm">
                        <h3 class="mb-4 font-bold">مدفوعاتك</h3>
                        @forelse ($myPayments as $payment)
                            <p class="border-b py-3">
                                {{ $payment->enrollment->course->localized('title') }} ·
                                {{ number_format((float) $payment->amount, 2) }} · {{ $payment->status }}
                            </p>
                        @empty
                            <p class="text-gray-500">لا توجد مدفوعات.</p>
                        @endforelse
                    </article>
                </section>
            @endif
        </div>
    </div>
</x-app-layout>
