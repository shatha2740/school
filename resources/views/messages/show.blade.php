<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between" dir="rtl">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                📄 تفاصيل الرسالة الواردة
            </h2>
            <a href="{{ route('messages.index') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300">
                &larr; العودة لصندوق الرسائل
            </a>
        </div>
    </x-slot>

    <div class="py-12" dir="rtl">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">

                {{-- معلومات المرسل --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-6 border-b border-gray-200">
                    <div>
                        <span class="text-xs text-gray-500 block">اسم المرسل:</span>
                        <h3 class="text-lg font-bold text-gray-800 mt-1">{{ $message->fname }} {{ $message->lname }}</h3>
                    </div>
                    <div>
                        <span class="text-xs text-gray-500 block">تاريخ الإرسال:</span>
                        <span class="text-sm font-semibold text-gray-700 mt-1 block">{{ $message->created_at->format('Y-m-d | h:i A') }}</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 py-6 border-b border-gray-200">
                    <div>
                        <span class="text-xs text-gray-500 block">البريد الإلكتروني:</span>
                        <a href="mailto:{{ $message->email }}" class="text-indigo-600 font-semibold hover:underline mt-1 block">
                            {{ $message->email }}
                        </a>
                    </div>
                    <div>
                        <span class="text-xs text-gray-500 block">رقم الهاتف:</span>
                        <span class="text-gray-800 font-semibold mt-1 block">{{ $message->tel }}</span>
                    </div>
                </div>

                {{-- نص الرسالة --}}
                <div class="py-6 border-b border-gray-200">
                    <span class="text-xs text-gray-500 block mb-2">محتوى الرسالة:</span>
                    <div class="bg-gray-50 p-4 rounded-lg text-gray-700 leading-relaxed whitespace-pre-line">
                        {{ $message->message }}
                    </div>
                </div>

                {{-- الملف المرفق --}}
                <div class="pt-6">
                    <span class="text-xs text-gray-500 block mb-2">الملف المرفق:</span>
                    @if($message->file_path)
                        <a href="{{ asset( $message->file_path) }}" target="_blank"
                           class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                            تحميل الملف المرفق 📎
                        </a>
                    @else
                        <span class="text-sm text-gray-400 italic">لا يوجد ملف مرفق مع هذه الرسالة.</span>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
