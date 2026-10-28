<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between" dir="rtl">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $instructor->name }}</h2>
            <div class="flex items-center gap-3">
                <a href="{{ route('instructors.edit', $instructor) }}" class="text-sm text-indigo-600 hover:text-indigo-900">تعديل</a>
                <a href="{{ route('instructors.index') }}" class="text-sm text-gray-600 hover:text-gray-900">العودة للمدربين</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12" dir="rtl">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg" role="status">
                    {{ session('success') }}
                </div>
            @endif
            <section class="bg-white p-6 shadow-sm sm:rounded-lg">
                @if ($instructor->image)
                    <img src="{{ asset($instructor->image) }}" alt="{{ $instructor->name }}" class="mb-4 h-24 w-24 rounded-full object-cover">
                @endif
                <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div><dt class="text-sm text-gray-500">التخصص</dt><dd class="font-semibold">{{ $instructor->specialization ?: '—' }}</dd></div>
                    <div><dt class="text-sm text-gray-500">حساب المستخدم</dt><dd class="font-semibold">{{ $instructor->user?->name ?? 'غير مرتبط بحساب' }}</dd></div>
                    <div class="sm:col-span-2"><dt class="text-sm text-gray-500">نبذة تعريفية</dt><dd class="whitespace-pre-line">{{ $instructor->bio ?: '—' }}</dd></div>
                </dl>
            </section>

            <section class="bg-white p-6 shadow-sm sm:rounded-lg">
                <h3 class="mb-4 text-lg font-semibold">الكورسات المرتبطة</h3>
                @forelse ($instructor->courses as $course)
                    <p class="border-b border-gray-100 py-3">
                        <a href="{{ route('courses.show', $course) }}" class="text-indigo-600 hover:underline">
                            {{ $course->localized('title') }}
                        </a>
                    </p>
                @empty
                    <p class="text-sm text-gray-500">لا توجد كورسات مرتبطة بهذا المدرب حاليًا.</p>
                @endforelse
            </section>
        </div>
    </div>
</x-app-layout>
