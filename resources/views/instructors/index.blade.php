<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between" dir="rtl">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">إدارة المدربين</h2>
            <a href="{{ route('instructors.create') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-800 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                إضافة مدرب
            </a>
        </div>
    </x-slot>

    <div class="py-12" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg" role="status">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg" role="alert">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="overflow-x-auto bg-white shadow-sm sm:rounded-lg">
                @if ($instructors->isNotEmpty())
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr class="text-right text-xs font-medium text-gray-500">
                                <th class="px-6 py-3">المدرب</th>
                                <th class="px-6 py-3">حساب المستخدم</th>
                                <th class="px-6 py-3">التخصص</th>
                                <th class="px-6 py-3">الكورسات</th>
                                <th class="px-6 py-3">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 text-sm text-gray-900">
                            @foreach ($instructors as $instructor)
                                <tr>
                                    <td class="px-6 py-4 font-semibold">{{ $instructor->name }}</td>
                                    <td class="px-6 py-4">{{ $instructor->user?->name ?? 'غير مرتبط بحساب' }}</td>
                                    <td class="px-6 py-4">{{ $instructor->specialization ?: '—' }}</td>
                                    <td class="px-6 py-4">{{ $instructor->courses_count }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('instructors.show', $instructor) }}" class="text-indigo-600 hover:text-indigo-900">عرض</a>
                                            <a href="{{ route('instructors.edit', $instructor) }}" class="text-gray-600 hover:text-gray-900">تعديل</a>
                                            <form action="{{ route('instructors.destroy', $instructor) }}" method="POST"
                                                  onsubmit="return confirm('هل تريد حذف هذا المدرب؟')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="text-red-600 hover:text-red-900" type="submit">حذف</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="p-12 text-center">
                        <h3 class="text-lg font-semibold text-gray-900">لا يوجد مدربون مسجلون حاليًا</h3>
                        <a href="{{ route('instructors.create') }}"
                           class="mt-4 inline-flex items-center px-4 py-2 bg-gray-800 rounded-md text-xs font-semibold text-white">
                            إضافة أول مدرب
                        </a>
                    </div>
                @endif
            </div>

            @if ($instructors->hasPages())
                <div dir="ltr">{{ $instructors->links() }}</div>
            @endif
        </div>
    </div>
</x-app-layout>
