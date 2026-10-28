
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>تعديل الكورس | Academics</title>

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
            box-shadow: 0 0 0 2px rgba(30, 64, 175, 0.12);
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
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold">تعديل الكورس</h1>

            <p class="mt-2 text-sm text-gray-500">
                تعديل بيانات الكورس بالعربية والإنجليزية.
            </p>

            <p class="mt-1 text-sm font-semibold text-blue-900">
                {{ $course->localized('title') }}
            </p>
        </div>

        <a href="{{ route('courses.index') }}"
           class="rounded-lg border bg-white px-4 py-2 text-sm transition hover:bg-gray-50">
            العودة للكورسات
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

    <form action="{{ route('courses.update', $course) }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="space-y-6 rounded-xl border bg-white p-5 shadow-sm sm:p-6">

            {{-- البيانات المترجمة --}}
            <section>
                <h2 class="mb-4 text-lg font-bold">
                    عنوان الكورس وأوصافه
                </h2>

                <div class="overflow-x-auto rounded-lg border">
                    <table class="w-full min-w-[650px] border-collapse text-sm">

                        <thead class="bg-gray-100">
                            <tr>
                                <th class="w-1/5 border p-3 text-right">الحقل</th>
                                <th class="w-2/5 border p-3">العربية</th>
                                <th class="w-2/5 border p-3">English</th>
                            </tr>
                        </thead>

                        <tbody>
                            {{-- العنوان --}}
                            <tr>
                                <td class="border bg-gray-50 p-3 font-semibold">
                                    العنوان <span class="text-red-600">*</span>
                                </td>

                                <td class="border p-3">
                                    <input type="text"
                                           name="title_ar"
                                           value="{{ old('title_ar', $course->title_ar) }}"
                                           placeholder="عنوان الكورس بالعربية"
                                           dir="rtl"
                                           required
                                           class="form-control">

                                    @error('title_ar')
                                        <p class="error">{{ $message }}</p>
                                    @enderror
                                </td>

                                <td class="border p-3">
                                    <input type="text"
                                           name="title_en"
                                           value="{{ old('title_en', $course->title_en) }}"
                                           placeholder="Course title in English"
                                           dir="ltr"
                                           required
                                           class="form-control">

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
                                    <textarea name="short_description_ar"
                                              placeholder="وصف مختصر بالعربية"
                                              dir="rtl"
                                              rows="3"
                                              class="form-control">{{ old('short_description_ar', $course->short_description_ar) }}</textarea>

                                    @error('short_description_ar')
                                        <p class="error">{{ $message }}</p>
                                    @enderror
                                </td>

                                <td class="border p-3">
                                    <textarea name="short_description_en"
                                              placeholder="Short description in English"
                                              dir="ltr"
                                              rows="3"
                                              class="form-control">{{ old('short_description_en', $course->short_description_en) }}</textarea>

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
                                    <textarea name="description_ar"
                                              placeholder="تفاصيل الكورس بالعربية..."
                                              dir="rtl"
                                              rows="6"
                                              class="form-control">{{ old('description_ar', $course->description_ar) }}</textarea>

                                    @error('description_ar')
                                        <p class="error">{{ $message }}</p>
                                    @enderror
                                </td>

                                <td class="border p-3">
                                    <textarea name="description_en"
                                              placeholder="Full course description..."
                                              dir="ltr"
                                              rows="6"
                                              class="form-control">{{ old('description_en', $course->description_en) }}</textarea>

                                    @error('description_en')
                                        <p class="error">{{ $message }}</p>
                                    @enderror
                                </td>
                            </tr>



                        </tbody>
                    </table>
                </div>
            </section>

            {{-- البيانات الأساسية --}}
            <section>
                <h2 class="mb-4 text-lg font-bold">
                    البيانات الأساسية للكورس
                </h2>

                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                    {{-- الرابط المختصر --}}
                    <div class="md:col-span-2">
                        <label for="slug" class="mb-2 block font-semibold">
                            الرابط المختصر (Slug)
                            <span class="text-red-600">*</span>
                        </label>

                        <input id="slug"
                               type="text"
                               name="slug"
                               value="{{ old('slug', $course->slug) }}"
                               placeholder="backend-development-php-laravel"
                               pattern="[A-Za-z0-9-]+"
                               required
                               dir="ltr"
                               class="form-control">

                        <p class="mt-1 text-xs text-gray-500">
                            حروف إنجليزية وأرقام وشرطة (-) فقط، بدون مسافات.
                        </p>

                        @error('slug')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- المدرب --}}
                    <div>
                        <label for="instructor_id" class="mb-2 block font-semibold">
                            المدرب <span class="text-red-600">*</span>
                        </label>

                        <select id="instructor_id"
                                name="instructor_id"
                                required
                                @disabled($instructors->isEmpty())
                                class="form-control">

                            <option value="">اختاري المدرب</option>

                            @foreach ($instructors as $instructor)
                                <option value="{{ $instructor->id }}"
                                    @selected((string) old('instructor_id', $course->instructor_id) === (string) $instructor->id)>
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

                    {{-- التصنيف الأساسي --}}
                    <div>
                        <label for="category" class="mb-2 block font-semibold">
             التصنيف الأساسي
                        </label>

                        <input id="category"
                               type="text"
                               name="category"
                               value="{{ old('category', $course->category) }}"
                               placeholder="مثال: Programming"
                               class="form-control">

                        @error('category')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- المستوى --}}
                    <div>
                        <label for="level" class="mb-2 block font-semibold">
                            المستوى <span class="text-red-600">*</span>
                        </label>

                        <select id="level"
                                name="level"
                                required
                                class="form-control">

                            <option value="">اختاري المستوى</option>

                            <option value="beginner"
                                @selected(old('level', $course->level) === 'beginner')>
                                مبتدئ
                            </option>

                            <option value="intermediate"
                                @selected(old('level', $course->level) === 'intermediate')>
                                متوسط
                            </option>

                            <option value="advanced"
                                @selected(old('level', $course->level) === 'advanced')>
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

                        <input id="price"
                               type="number"
                               name="price"
                               value="{{ old('price', $course->price) }}"
                               min="0"
                               step="0.01"
                               required
                               class="form-control">

                        @error('price')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- المدة --}}
                    <div>
                        <label for="duration_weeks" class="mb-2 block font-semibold">
                            المدة بالأسابيع
                        </label>

                        <input id="duration_weeks"
                               type="number"
                               name="duration_weeks"
                               value="{{ old('duration_weeks', $course->duration_weeks) }}"
                               min="1"
                               step="1"
                               class="form-control">

                        @error('duration_weeks')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- صورة الكورس --}}
                    <div class="md:col-span-2">
                        <label for="image" class="mb-2 block font-semibold">
                            صورة الكورس
                        </label>

                        <div class="rounded-lg border border-dashed bg-gray-50 p-4">
                            @if ($course->image)
                                <p class="mb-2 text-sm text-gray-600">
                                    الصورة الحالية:
                                </p>

                                <img id="currentImage"
                                     src="{{ asset($course->image) }}"
                                     alt="الصورة الحالية للكورس"
                                     class="mb-4 max-h-48 rounded-lg border bg-white object-cover">
                            @endif

                            <input id="image"
                                   type="file"
                                   name="image"
                                   accept="image/jpeg,image/png,image/webp"
                                   class="form-control">

                            <p class="mt-2 text-xs text-gray-500">
                                اختاري صورة جديدة فقط إذا أردتِ استبدال الحالية.
                                الصيغ المدعومة JPG وPNG وWEBP.
                            </p>

                            <img id="imagePreview"
                                 alt="معاينة الصورة الجديدة"
                                 class="mt-4 hidden max-h-48 rounded-lg border object-cover">

                            @error('image')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- النشر --}}
                    <div class="flex items-center gap-3 rounded-lg border bg-gray-50 p-4">
                        <input type="hidden" name="is_published" value="0">

                        <input id="is_published"
                               type="checkbox"
                               name="is_published"
                               value="1"
                               @checked(old('is_published', $course->is_published))
                               class="h-4 w-4 rounded">

                        <label for="is_published" class="font-semibold">
                            نشر الكورس ليظهر للطلاب
                        </label>
                    </div>

                </div>
            </section>

            {{-- الأزرار --}}
            <div class="flex flex-wrap gap-3 border-t pt-5">
                <button type="submit"
                        @disabled($instructors->isEmpty())
                        class="rounded-lg bg-blue-900 px-6 py-3 font-semibold text-white transition hover:bg-blue-800 disabled:cursor-not-allowed disabled:opacity-50">
                    حفظ التعديلات
                </button>

                <a href="{{ route('courses.index') }}"
                   class="rounded-lg border bg-white px-6 py-3 transition hover:bg-gray-50">
                    إلغاء
                </a>
            </div>

        </div>
    </form>
</div>

{{-- معاينة الصورة الجديدة --}}
<script>
    const imageInput = document.getElementById('image');
    const preview = document.getElementById('imagePreview');
    const currentImage = document.getElementById('currentImage');

    let previewUrl = null;

    imageInput.addEventListener('change', function (event) {
        const file = event.target.files[0];

        if (previewUrl) {
            URL.revokeObjectURL(previewUrl);
            previewUrl = null;
        }

        if (!file) {
            preview.classList.add('hidden');
            preview.removeAttribute('src');

            if (currentImage) {
                currentImage.classList.remove('hidden');
            }

            return;
        }

        previewUrl = URL.createObjectURL(file);
        preview.src = previewUrl;
        preview.classList.remove('hidden');

        if (currentImage) {
            currentImage.classList.add('hidden');
        }
    });
</script>

</body>
</html>
