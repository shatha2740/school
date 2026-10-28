<div>
    <!-- He who is contented is rich. - Laozi -->
</div>
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between" dir="rtl">
            <h2 class="text-xl font-semibold">دروس {{ $course->localized('title') }}</h2>
            <a href="{{ route('courses.lessons.create', $course) }}" class="rounded-md bg-gray-800 px-4 py-2 text-white">إضافة درس</a>
        </div>
    </x-slot>
    <div class="py-10" dir="rtl">
        <div class="mx-auto max-w-7xl space-y-4 sm:px-6 lg:px-8">
            <a href="{{ route('courses.show', $course) }}" class="text-indigo-700">العودة للكورس</a>
            @foreach ($lessons as $lesson)
                <article class="flex items-center justify-between rounded-lg bg-white p-5 shadow-sm">
                    <div><strong>{{ $lesson->sort_order }}. {{ $lesson->title }}</strong><p class="text-sm text-gray-500">{{ Str::limit($lesson->content, 140) }}</p></div>
                    <div class="flex gap-3">
                        <a href="{{ route('courses.lessons.edit', [$course, $lesson]) }}" class="text-indigo-700">تعديل</a>
                        <form method="POST" action="{{ route('courses.lessons.destroy', [$course, $lesson]) }}">
                            @csrf @method('DELETE')
                            <button class="text-red-700" onclick="return confirm('حذف هذا الدرس؟')">حذف</button>
                        </form>
                    </div>
                </article>
            @endforeach
            {{ $lessons->links() }}
        </div>
    </div>
</x-app-layout>
