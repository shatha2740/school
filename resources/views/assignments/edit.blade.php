<div>
    <!-- We must ship. - Taylor Otwell -->
</div>
<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold">تعديل الواجب: {{ $assignment->title }}</h2></x-slot>
    <div class="py-10" dir="rtl">
        <div class="mx-auto max-w-3xl rounded-lg bg-white p-6 shadow-sm sm:px-8">
            <form method="POST" action="{{ route('courses.assignments.update', [$course, $assignment]) }}">
                @csrf
                @method('PUT')
                @include('assignments._form')
                <div class="mt-6 flex gap-3">
                    <button class="rounded-md bg-gray-800 px-4 py-2 text-white">حفظ التعديلات</button>
                    <a href="{{ route('courses.show', $course) }}" class="rounded-md border px-4 py-2">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
