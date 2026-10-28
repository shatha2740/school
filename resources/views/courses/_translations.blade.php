@php
    $languages = [
        'en' => ['label' => 'English', 'direction' => 'ltr'],
        'ar' => ['label' => 'العربية', 'direction' => 'rtl'],
    ];
    $fields = [
        'title' => ['label' => 'اسم الكورس', 'type' => 'input'],
        'category' => ['label' => 'التصنيف', 'type' => 'input'],
        'slug' => ['label' => 'الرابط المختصر', 'type' => 'input'],
        'level' => ['label' => 'المستوى', 'type' => 'input'],
        'short_description' => ['label' => 'الوصف المختصر', 'type' => 'textarea'],
        'description' => ['label' => 'المحتوى أو الوصف الكامل', 'type' => 'textarea'],
    ];
@endphp

@foreach ($languages as $locale => $language)
    <section dir="{{ $language['direction'] }}" class="rounded-xl border border-slate-200 p-5">
        <h3 class="mb-5 border-b border-slate-100 pb-3 text-base font-bold text-slate-800">
            بيانات الكورس باللغة {{ $language['label'] }}
        </h3>

        <div class="grid grid-cols-1 gap-x-6 gap-y-5 md:grid-cols-2">
            @foreach ($fields as $field => $details)
                @php
                    $fieldName = "{$field}_{$locale}";
                    $value = old($fieldName, $course->getAttribute($fieldName) ?: $course->getAttribute($field));
                @endphp
                <div class="{{ in_array($field, ['short_description', 'description'], true) ? 'md:col-span-2' : '' }}">
                    <label for="{{ $fieldName }}" class="mb-2 block text-sm font-bold text-slate-700">
                        {{ $details['label'] }} <span class="required">*</span>
                    </label>

                    @if ($details['type'] === 'textarea')
                        <textarea id="{{ $fieldName }}" name="{{ $fieldName }}"
                                  rows="{{ $field === 'description' ? 5 : 3 }}"
                                  class="form-control @error($fieldName) border-red-500 @enderror"
                                  required>{{ $value }}</textarea>
                    @else
                        <input id="{{ $fieldName }}" type="text" name="{{ $fieldName }}"
                               maxlength="191" value="{{ $value }}"
                               class="form-control @error($fieldName) border-red-500 @enderror" required>
                        @if ($field === 'slug')
                            <small class="mt-1 block text-xs text-slate-500">
                                اكتب الرابط يدويًا؛ الروابط العربية مدعومة.
                            </small>
                        @endif
                    @endif

                    @error($fieldName)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            @endforeach
        </div>
    </section>
@endforeach
