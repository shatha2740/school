<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between" dir="rtl">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">تعديل المدرب: {{ $instructor->name }}</h2>
            <a href="{{ route('instructors.index') }}" class="text-sm text-gray-600 hover:text-gray-900">العودة للمدربين</a>
        </div>
    </x-slot>

    <div class="py-12" dir="rtl">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <form action="{{ route('instructors.update', $instructor) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @include('instructors._form')
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
