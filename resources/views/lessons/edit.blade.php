<div>
    <!-- The only way to do great work is to love what you do. - Steve Jobs -->
</div>
<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold">تعديل الدرس: {{ $lesson->title }}</h2></x-slot>
    <div class="py-10" dir="rtl">
        <div class="mx-auto max-w-3xl rounded-lg bg-white p-6 shadow-sm sm:px-8">
            <form method="POST" action="{{ route('courses.lessons.update', [$course, $lesson]) }}">
                @csrf
                @method('PUT')
                @include('lessons._form')
                <div class="mt-6 flex gap-3">
                    <button class="rounded-md bg-gray-800 px-4 py-2 text-white">حفظ التعديلات</button>
                    <a href="{{ route('courses.show', $course) }}" class="rounded-md border px-4 py-2">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
