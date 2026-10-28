<div>
    <!-- I have not failed. I've just found 10,000 ways that won't work. - Thomas Edison -->
</div>
<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold" dir="rtl">تسليمات الواجبات</h2></x-slot>
    <div class="py-10" dir="rtl">
        <div class="mx-auto max-w-7xl space-y-4 sm:px-6 lg:px-8">
            @if (session('success')) <div class="rounded-lg bg-green-50 p-4 text-green-800">{{ session('success') }}</div> @endif
            @if ($errors->any()) <div class="rounded-lg bg-red-50 p-4 text-red-800">{{ $errors->first() }}</div> @endif
            @forelse ($submissions as $submission)
                <article class="rounded-lg bg-white p-5 shadow-sm">
                    <div class="flex flex-wrap justify-between gap-3">
                        <div>
                            <h3 class="font-bold">{{ $submission->assignment->title }}</h3>
                            <p class="text-sm text-gray-600">{{ $submission->assignment->course->localized('title') }}</p>
                        </div>
                        <div class="text-sm text-gray-600">
                            {{ $submission->user->name }} · {{ $submission->submitted_at->format('Y-m-d H:i') }}
                        </div>
                    </div>
                    @if ($submission->answer)
                        <p class="mt-4 whitespace-pre-line">{{ $submission->answer }}</p>
                    @endif
                    @if ($submission->file_path)
                        <a href="{{ route('submissions.download', $submission) }}" class="mt-3 inline-block text-indigo-700">تنزيل الملف المرفق</a>
                    @endif
                    <p class="mt-3 text-sm">الحالة: {{ $submission->status }}</p>
                    @if ($submission->status === 'graded')
                        <p>الدرجة: {{ $submission->score }} / {{ $submission->assignment->max_score }}</p>
                        @if ($submission->instructor_feedback)
                            <p class="mt-2">ملاحظات المدرب: {{ $submission->instructor_feedback }}</p>
                        @endif
                    @endif

                    @can('update', $submission->assignment)
                        <form method="POST" action="{{ route('submissions.grade', $submission) }}" class="mt-4 grid gap-3 border-t pt-4 md:grid-cols-3">
                            @csrf @method('PUT')
                            <label class="text-sm">الدرجة
                                <input type="number" name="score" min="0" max="{{ $submission->assignment->max_score }}" step="0.01"
                                       value="{{ old('score', $submission->score) }}" required class="mt-1 block w-full rounded-md border-gray-300">
                            </label>
                            <label class="text-sm md:col-span-2">ملاحظات المدرب
                                <textarea name="instructor_feedback" rows="2" class="mt-1 block w-full rounded-md border-gray-300">{{ old('instructor_feedback', $submission->instructor_feedback) }}</textarea>
                            </label>
                            <button class="rounded-md bg-gray-800 px-4 py-2 text-white md:col-span-3">حفظ التصحيح</button>
                        </form>
                    @endcan
                </article>
            @empty
                <div class="rounded-lg bg-white p-10 text-center text-gray-500">لا توجد تسليمات لعرضها.</div>
            @endforelse
            {{ $submissions->links() }}
        </div>
    </div>
</x-app-layout>
