<div>
    <!-- Because you are alive, everything is possible. - Thich Nhat Hanh -->
</div>
<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold">إضافة درس: {{ $course->localized('title') }}</h2></x-slot>
    <div class="py-10" dir="rtl">
        <div class="mx-auto max-w-3xl rounded-lg bg-white p-6 shadow-sm sm:px-8">
            <form method="POST" action="{{ route('courses.lessons.store', $course) }}">
                @csrf
                @include('lessons._form')
                <div class="mt-6 flex gap-3">
                    <button class="rounded-md bg-gray-800 px-4 py-2 text-white">حفظ الدرس</button>
                    <a href="{{ route('student.course', $course) }}" class="rounded-md border px-4 py-2">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
