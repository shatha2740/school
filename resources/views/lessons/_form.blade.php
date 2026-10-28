
<div class="space-y-5">
    <div>
        <label for="title" class="block text-sm font-medium text-gray-700">
            عنوان الدرس
        </label>
        <input
            id="title" name="title" value="{{ old('title', $lesson->title) }}" required  maxlength="191"
            class="mt-1 block w-full rounded-md border-gray-300" >
        @error('title')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label for="week_number" class="block text-sm font-medium text-gray-700">
            رقم الأسبوع </label>
        <select id="week_number" name="week_number" required
            class="mt-1 block w-full rounded-md border-gray-300">
            @for ($week = 1; $week <= 12; $week++)
                <option
                    value="{{ $week }}"
                    @selected(old('week_number', $lesson->week_number ?? 1) == $week)>
                    الأسبوع {{ $week }}
                </option>
            @endfor
        </select>

        @error('week_number')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label for="content" class="block text-sm font-medium text-gray-700">
            المحتوى</label>
        <textarea  id="content" name="content" rows="7" class="mt-1 block w-full rounded-md border-gray-300" >{{ old('content', $lesson->content) }}</textarea>
        @error('content')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label for="video_url" class="block text-sm font-medium text-gray-700">
            رابط الفيديو</label>
        <input id="video_url" name="video_url"type="url"
            value="{{ old('video_url', $lesson->video_url) }}"
            class="mt-1 block w-full rounded-md border-gray-300" >
        @error('video_url')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label for="sort_order" class="block text-sm font-medium text-gray-700">
            ترتيب الدرس</label>
        <input id="sort_order"name="sort_order" type="number" min="0"
            value="{{ old('sort_order', $lesson->sort_order ?? 0) }}" required
            class="mt-1 block w-full rounded-md border-gray-300" >
        @error('sort_order')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>

