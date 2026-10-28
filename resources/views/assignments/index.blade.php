<div>
    <!-- He who is contented is rich. - Laozi -->
</div>
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between" dir="rtl">
            <h2 class="text-xl font-semibold">واجبات {{ $course->localized('title') }}</h2>
            <a href="{{ route('courses.assignments.create', $course) }}" class="rounded-md bg-gray-800 px-4 py-2 text-white">إضافة واجب</a>
        </div>
    </x-slot>
    <div class="py-10" dir="rtl">
        <div class="mx-auto max-w-7xl space-y-4 sm:px-6 lg:px-8">
            <a href="{{ route('courses.show', $course) }}" class="text-indigo-700">العودة للكورس</a>
            @foreach ($assignments as $assignment)
                <article class="flex items-center justify-between rounded-lg bg-white p-5 shadow-sm">
                    <div>
                        <strong>{{ $assignment->title }}</strong>
                        <p class="text-sm text-gray-500">{{ $assignment->submissions_count }} تسليم</p>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('courses.assignments.edit', [$course, $assignment]) }}" class="text-indigo-700">تعديل</a>
                        <form method="POST" action="{{ route('courses.assignments.destroy', [$course, $assignment]) }}">
                            @csrf @method('DELETE')
                            <button class="text-red-700" onclick="return confirm('حذف هذا الواجب؟')">حذف</button>
                        </form>
                    </div>
                </article>
            @endforeach
            {{ $assignments->links() }}
        </div>
    </div>
</x-app-layout>
