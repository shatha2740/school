<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between" dir="rtl">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                الكورسات
            </h2>
            @can('courses.create')
            <a href="{{ route('courses.create') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                إضافة كورس
            </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 sm:rounded-lg" role="status">
                    {{ session('success') }}
                </div>
            @endif

            <form method="GET" action="{{ route('courses.index') }}" class="flex flex-wrap gap-3 rounded-lg bg-white p-4 shadow-sm">
                <input name="search" value="{{ request('search') }}" type="search" placeholder="ابحث باسم الكورس أو الرابط"
                       class="min-w-56 flex-1 rounded-md border-gray-300">
                <select name="status" class="rounded-md border-gray-300">
                    <option value="">كل الحالات</option>
                    <option value="published" @selected(request('status') === 'published')>منشور</option>
                    <option value="draft" @selected(request('status') === 'draft')>مسودة</option>
                </select>
                <button class="rounded-md bg-gray-800 px-4 py-2 text-sm font-semibold text-white">بحث وتصفية</button>
            </form>

            {{-- الإحصائيات --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">إجمالي الكورسات</div>
                    <div class="mt-1 text-3xl font-bold text-gray-900">{{  $coursesCount }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">منشورة</div>

                    <div class="mt-1 text-3xl font-bold text-green-600">{{   $publishedCount}}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">مسودات</div>
                    <div class="mt-1 text-3xl font-bold text-yellow-600">{{ $draftsCount }}</div>
                </div>
            </div>

            {{-- الجدول --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if ($courses->count())
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr class="text-right text-xs font-medium text-gray-500">
                                       <th class="px-6 py-3 text-right">الرقم</th>
                                    <th class="px-6 py-3 text-right">الصورة</th>
                                    <th class="px-6 py-3 text-right">الكورس</th>
                                    <th class="px-6 py-3 text-right">المستوى</th>
                                    <th class="px-6 py-3 text-right">السعر</th>
                                    <th class="px-6 py-3 text-right">المدة</th>
                                    <th class="px-6 py-3 text-right">الحالة</th>
                                    <th class="px-6 py-3 text-right">المدرب</th>
                                    <th class="px-6 py-3 text-right">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white text-sm text-gray-900">
                                @foreach ($courses as $course)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4" >{{$course->id}}</td>
                                        <td class="px-6 py-4">
                                            @if ($course->image)
                                                <img src="{{ $course->imageUrl() }}"
                                                     alt="{{ $course->localized('title') }}"
                                                     class="h-11 w-16 rounded-md object-cover">
                                            @else
                                                <div class="h-11 w-16 rounded-md bg-gray-100 flex items-center justify-center text-xs text-gray-400">
                                                    بدون صورة
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <a href="{{ route('courses.show', $course->id) }}"
                                               class="font-semibold text-gray-900 hover:text-indigo-600">
                                                {{ $course->localized('title') }}
                                            </a>
                                            <div class="text-xs text-gray-500">{{ $course->localized('category') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $course->localized('level') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ number_format($course->price, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $course->duration_weeks ? $course->duration_weeks . ' أسبوع' : '—' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($course->is_published)
                                                <span class="inline-flex rounded-full bg-green-100 px-3 py-0.5 text-xs font-semibold text-green-700">منشور</span>
                                            @else
                                                <span class="inline-flex rounded-full bg-yellow-100 px-3 py-0.5 text-xs font-semibold text-yellow-700">مسودة</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $course->instructor?->name ?? '—' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2">
                                                <a href="{{ route('courses.show', $course->id) }}"
                                                   class="px-3 py-1.5 text-xs font-semibold text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                                    عرض
                                                </a>
                                                @can('update', $course)
                                                <a href="{{ route('courses.edit', $course->id) }}"
                                                   class="px-3 py-1.5 text-xs font-semibold text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                                    تعديل
                                                </a>
                                                @endcan
                                                @can('delete', $course)
                                                <form action="{{ route('courses.destroy', $course) }}" method="POST"
                                                      onsubmit="return confirm('هل أنت متأكد من حذف هذا الكورس؟ لا يمكن التراجع عن الحذف.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="px-3 py-1.5 text-xs font-semibold text-red-600 bg-white border border-red-200 rounded-md hover:bg-red-50">
                                                        حذف
                                                    </button>
                                                </form>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-12 text-center">
                        <h3 class="text-lg font-semibold text-gray-900">لا توجد كورسات بعد</h3>
                        <p class="mt-1 text-sm text-gray-500">أضف أول كورس ليظهر هنا.</p>
                        @can('courses.create')
                        <a href="{{ route('courses.create') }}"
                           class="mt-4 inline-flex items-center px-4 py-2 bg-gray-800 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                            إضافة كورس
                        </a>
                        @endcan
                    </div>
                @endif
            </div>

            @if ($courses->hasPages())
                <div dir="ltr">
                    {{ $courses->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
