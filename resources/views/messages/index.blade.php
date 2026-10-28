<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between" dir="rtl">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                📥 صندوق الرسائل الواردة
            </h2>
            <span class="inline-flex items-center px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-xs font-semibold">
                إجمالي الرسائل: {{ $messages->total() }}
            </span>
        </div>
    </x-slot>

    <div class="py-12" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- رسالة نجاح إن وجدت --}}
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-right">
                            <thead class="bg-gray-50 text-gray-700 text-xs uppercase font-bold">
                                <tr>
                                    <th scope="col" class="px-6 py-3">#</th>
                                    <th scope="col" class="px-6 py-3">المرسل</th>
                                    <th scope="col" class="px-6 py-3">البريد الإلكتروني</th>
                                    <th scope="col" class="px-6 py-3">الهاتف</th>
                                    <th scope="col" class="px-6 py-3">نص الرسالة</th>
                                    <th scope="col" class="px-6 py-3">الحالة</th>
                                    <th scope="col" class="px-6 py-3">الإجراء</th>
                                    <th scope="col" class="px-6 py-3">التاريخ</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 text-sm">
                                @forelse($messages as $msg)
                                    {{-- إذا كانت الرسالة غير مقروءة، نغير لون الخلفية قليلاً لتكون مميزة --}}
                                    <tr class="{{ $msg->is_read ? 'bg-white hover:bg-gray-50' : 'bg-indigo-50/50 hover:bg-indigo-50 font-semibold' }}">
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $msg->id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-900">{{ $msg->fname }} {{ $msg->lname }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="mailto:{{ $msg->email }}" class="text-indigo-600 hover:underline">{{ $msg->email }}</a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $msg->tel }}</td>
                                        <td class="px-6 py-4 text-gray-700 max-w-xs truncate">
                                            {{ Str::limit($msg->message, 30) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($msg->is_read)
                                                <span class="px-2.5 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">مقروء</span>
                                            @else
                                                <span class="px-2.5 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full animate-pulse">جديد / غير مقروء</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <a href="{{ route('messages.show', $msg->id) }}"
                                               class="inline-flex items-center px-3 py-1.5 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                عرض 👁️
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500">
                                            {{ $msg->created_at->diffForHumans() }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-6 py-10 text-center text-gray-500">
                                            لا توجد أي رسائل واردة حتى الآن.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- أزرار التنقل بين الصفحات (Pagination) --}}
                    <div class="mt-4">
                        {{ $messages->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
