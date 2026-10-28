<div>
    <!-- Because you are alive, everything is possible. - Thich Nhat Hanh -->
</div>
<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold" dir="rtl">إدارة تسجيلات الطلاب</h2></x-slot>
    <div class="py-10" dir="rtl">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-x-auto rounded-lg bg-white shadow-sm">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50"><tr class="text-right">
                        <th class="px-4 py-3">الطالب</th><th class="px-4 py-3">الكورس</th>
                        <th class="px-4 py-3">حالة التسجيل</th><th class="px-4 py-3">تاريخ التسجيل</th>
                        <th class="px-4 py-3">عدد الدفعات</th>
                    </tr></thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($enrollments as $enrollment)
                            <tr>
                                <td class="px-4 py-3">{{ $enrollment->user->name }} <span class="text-gray-500">{{ $enrollment->user->email }}</span></td>
                                <td class="px-4 py-3"><a class="text-indigo-700" href="{{ route('courses.show', $enrollment->course) }}">{{ $enrollment->course->localized('title') }}</a></td>
                                <td class="px-4 py-3">{{ $enrollment->status }}</td>
                                <td class="px-4 py-3">{{ $enrollment->enrolled_at->format('Y-m-d H:i') }}</td>
                                <td class="px-4 py-3">{{ $enrollment->payments_count ?? $enrollment->payments()->count() }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-4 py-8 text-center text-gray-500">لا توجد تسجيلات.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $enrollments->links() }}</div>
        </div>
    </div>
</x-app-layout>
