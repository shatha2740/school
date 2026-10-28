
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>إضافة كورس جديد | Academics</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #d1d5db;
            border-radius: 7px;
            background: white;
            font-size: 14px;
        }

        .form-control:focus {
            outline: none;
            border-color: #1e40af;
        }

        textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }

        .error {
            color: #dc2626;
            font-size: 12px;
            margin-top: 5px;
        }
    </style>
</head>

<body class="min-h-screen bg-gray-100 text-gray-800">

<div class="mx-auto max-w-6xl p-4 sm:p-6">

    {{-- عنوان الصفحة --}}
    <div class="mb-6 flex items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold">إضافة كورس جديد</h1>
            <p class="mt-2 text-sm text-gray-500">
                أدخلي بيانات الكورس بالعربية والإنجليزية.
            </p>
        </div>

        <a href="{{ route('courses.index') }}"
           class="rounded-lg border bg-white px-4 py-2 text-sm hover:bg-gray-50">
            العودة
        </a>
    </div>

    {{-- رسائل الخطأ --}}
    @if ($errors->any())
        <div class="mb-5 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
            <p class="font-bold">يرجى مراجعة الأخطاء التالية:</p>

            @foreach ($errors->all() as $error)
                <p class="mt-1">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('courses.store') }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf

        <div class="space-y-6 rounded-xl border bg-white p-5 shadow-sm sm:p-6">

            {{-- البيانات المترجمة في جدول --}}
            <section>
                <h2 class="mb-4 text-lg font-bold">
                    عنوان الكورس وأوصافه
                </h2>

                <div class="overflow-x-auto rounded-lg border">
                    <table class="w-full min-w-[650px] border-collapse text-sm">

                        <thead class="bg-gray-100">
                            <tr>
                                <th class="w-1/5 border p-3 text-right">
                                    الحقل
                                </th>

                                <th class="w-2/5 border p-3">
                                    العربية
                                </th>

                                <th class="w-2/5 border p-3">
                                    English
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            {{-- العنوان --}}
                            <tr>
                                <td class="border bg-gray-50 p-3 font-semibold">
                                    العنوان
                                    <span class="text-red-600">*</span>
                                </td>

                                <td class="border p-3">
                                    <input
                                        type="text"
                                        name="title_ar"
                                        value="{{ old('title_ar') }}"
                                        placeholder="عنوان الكورس بالعربية"
                                        dir="rtl"
                                        required
                                        class="form-control"
                                    >

                                    @error('title_ar')
                                        <p class="error">{{ $message }}</p>
                                    @enderror
                                </td>

                                <td class="border p-3">
                                    <input
                                        type="text"
                                        name="title_en"
                                        value="{{ old('title_en') }}"
                                        placeholder="Course title in English"
                                        dir="ltr"
                                        required
                                        class="form-control"
                                    >

                                    @error('title_en')
                                        <p class="error">{{ $message }}</p>
                                    @enderror
                                </td>
                            </tr>

                            {{-- الوصف المختصر --}}
                            <tr>
                                <td class="border bg-gray-50 p-3 font-semibold">
                                    الوصف المختصر
                                </td>

                                <td class="border p-3">
                                    <textarea
                                        name="short_description_ar"
                                        placeholder="وصف مختصر بالعربية"
                                        dir="rtl"
                                        rows="3"
                                        class="form-control"
                                    >{{ old('short_description_ar') }}</textarea>

                                    @error('short_description_ar')
                                        <p class="error">{{ $message }}</p>
                                    @enderror
                                </td>

                                <td class="border p-3">
                                    <textarea
                                        name="short_description_en"
                                        placeholder="Short description in English"
                                        dir="ltr"
                                        rows="3"
                                        class="form-control"
                                    >{{ old('short_description_en') }}</textarea>

                                    @error('short_description_en')
                                        <p class="error">{{ $message }}</p>
                                    @enderror
                                </td>
                            </tr>

                            {{-- الوصف الكامل --}}
                            <tr>
                                <td class="border bg-gray-50 p-3 font-semibold">
                                    الوصف الكامل
                                </td>

                                <td class="border p-3">
                                    <textarea
                                        name="description_ar"
                                        placeholder="اكتبي تفاصيل الكورس بالعربية..."
                                        dir="rtl"
                                        rows="6"
                                        class="form-control"
                                    >{{ old('description_ar') }}</textarea>

                                    @error('description_ar')
                                        <p class="error">{{ $message }}</p>
                                    @enderror
                                </td>

                                <td class="border p-3">
                                    <textarea
                                        name="description_en"
                                        placeholder="Write the full course description..."
                                        dir="ltr"
                                        rows="6"
                                        class="form-control"
                                    >{{ old('description_en') }}</textarea>

                                    @error('description_en')
                                        <p class="error">{{ $message }}</p>
                                    @enderror
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            {{-- البيانات العادية --}}
            <section>
                <h2 class="mb-4 text-lg font-bold">
                    البيانات الأساسية للكورس
                </h2>
{{-- الرابط المختصر --}}
<div>
    <label for="slug" class="mb-2 block font-semibold">
        الرابط المختصر (Slug)
        <span class="text-red-600">*</span>
    </label>

    <input
        id="slug"
        type="text"
        name="slug"
        value="{{ old('slug') }}"
        placeholder="backend-development-php-laravel"
        pattern="[A-Za-z0-9-]+"
        required
        dir="ltr"
        class="form-control"
    >

    <p class="mt-1 text-xs text-gray-500">
        حروف إنجليزية وأرقام وشرطة (-) فقط، بدون مسافات.
    </p>

    @error('slug')
        <p class="error">{{ $message }}</p>
    @enderror
</div>
                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                    {{-- المدرب --}}
                    <div>
                        <label for="instructor_id" class="mb-2 block font-semibold">
                            المدرب <span class="text-red-600">*</span>
                        </label>

                        <select
                            id="instructor_id"
                            name="instructor_id"
                            required
                            @disabled($instructors->isEmpty())
                            class="form-control"
                        >
                            <option value="">اختاري المدرب</option>

                            @foreach ($instructors as $instructor)
                                <option
                                    value="{{ $instructor->id }}"
                                    @selected(old('instructor_id') == $instructor->id)
                                >
                                    {{ $instructor->name }}
                                </option>
                            @endforeach
                        </select>

                        @if ($instructors->isEmpty())
                            <p class="error">
                                لا يوجد مدربون. أضيفي مدربًا أولًا.
                            </p>
                        @endif

                        @error('instructor_id')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- التصنيف --}}
                    <div>
                        <label for="category" class="mb-2 block font-semibold">
                            التصنيف <span class="text-red-600">*</span>
                        </label>

                        <input
                            id="category"
                            type="text"
                            name="category"
                            value="{{ old('category') }}"
                            placeholder="مثال: البرمجة"
                            required
                            class="form-control"
                        >

                        @error('category')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- المستوى --}}
                    <div>
                        <label for="level" class="mb-2 block font-semibold">
                            المستوى <span class="text-red-600">*</span>
                        </label>

                        <select id="level" name="level" required class="form-control">
                            <option value="">اختاري المستوى</option>

                            <option value="beginner"
                                @selected(old('level') === 'beginner')>
                                مبتدئ
                            </option>

                            <option value="intermediate"
                                @selected(old('level') === 'intermediate')>
                                متوسط
                            </option>

                            <option value="advanced"
                                @selected(old('level') === 'advanced')>
                                متقدم
                            </option>
                        </select>

                        @error('level')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- السعر --}}
                    <div>
                        <label for="price" class="mb-2 block font-semibold">
                            السعر بالدولار ($) <span class="text-red-600">*</span>
                        </label>

                        <input
                            id="price"
                            type="number"
                            name="price"
                            value="{{ old('price', 0) }}"
                            min="0"
                            step="0.01"
                            required
                            class="form-control"
                        >

                        @error('price')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- المدة --}}
                    <div>
                        <label for="duration_weeks" class="mb-2 block font-semibold">
                            المدة بالأسابيع <span class="text-red-600">*</span>
                        </label>

                        <input
                            id="duration_weeks"
                            type="number"
                            name="duration_weeks"
                            value="{{ old('duration_weeks') }}"
                            min="1"
                            step="1"
                            required
                            class="form-control"
                        >

                        @error('duration_weeks')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- صورة الكورس --}}
                    <div>
                        <label for="image" class="mb-2 block font-semibold">
                            صورة الكورس
                        </label>

                        <input
                            id="image"
                            type="file"
                            name="image"
                            accept="image/jpeg,image/png,image/webp"
                            class="form-control"
                        >

                        <p class="mt-2 text-xs text-gray-500">
                            JPG أو PNG أو WEBP.
                        </p>

                        @error('image')
                            <p class="error">{{ $message }}</p>
                        @enderror

                        <img
                            id="imagePreview"
                            alt="معاينة صورة الكورس"
                            class="mt-3 hidden max-h-40 rounded-lg"
                        >
                    </div>

                    {{-- النشر --}}
                    <div class="flex items-center gap-3 self-center rounded-lg border p-4">
                        <input type="hidden" name="is_published" value="0">

                        <input
                            id="is_published"
                            type="checkbox"
                            name="is_published"
                            value="1"
                            @checked(old('is_published'))
                            class="h-4 w-4"
                        >

                        <label for="is_published">
                            نشر الكورس ليظهر للطلاب
                        </label>
                    </div>

                </div>
            </section>

            {{-- الأزرار --}}
            <div class="flex flex-wrap gap-3 border-t pt-5">
                <button
                    type="submit"
                    @disabled($instructors->isEmpty())
                    class="rounded-lg bg-blue-900 px-6 py-3 font-semibold text-white hover:bg-blue-800 disabled:opacity-50"
                >
                    حفظ الكورس
                </button>

                <a
                    href="{{ route('courses.index') }}"
                    class="rounded-lg border px-6 py-3 hover:bg-gray-50"
                >
                    إلغاء
                </a>
            </div>

        </div>
    </form>
</div>

{{-- معاينة الصورة --}}
<script>
    document.getElementById('image').addEventListener('change', function (event) {
        const file = event.target.files[0];
        const preview = document.getElementById('imagePreview');

        if (!file) {
            preview.classList.add('hidden');
            preview.removeAttribute('src');
            return;
        }

        preview.src = URL.createObjectURL(file);
        preview.classList.remove('hidden');
    });
</script>

</body>
</html>
