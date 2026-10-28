<div>
    <!-- Order your soul. Reduce your wants. - Augustine -->
</div>
<div class="space-y-5">
    <div>
        <label for="title" class="block text-sm font-medium text-gray-700">عنوان الواجب</label>
        <input id="title" name="title" value="{{ old('title', $assignment->title) }}" required maxlength="191"
               class="mt-1 block w-full rounded-md border-gray-300">
        @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label for="instructions" class="block text-sm font-medium text-gray-700">التعليمات</label>
        <textarea id="instructions" name="instructions" rows="7" required class="mt-1 block w-full rounded-md border-gray-300">{{ old('instructions', $assignment->instructions) }}</textarea>
        @error('instructions') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label for="max_score" class="block text-sm font-medium text-gray-700">الدرجة النهائية</label>
        <input id="max_score" name="max_score" type="number" min="0.01" step="0.01"
               value="{{ old('max_score', $assignment->max_score) }}" required
               class="mt-1 block w-full rounded-md border-gray-300">
        @error('max_score') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label for="due_at" class="block text-sm font-medium text-gray-700">موعد التسليم</label>
        <input id="due_at" name="due_at" type="datetime-local"
               value="{{ old('due_at', $assignment->due_at?->format('Y-m-d\TH:i')) }}"
               class="mt-1 block w-full rounded-md border-gray-300">
        @error('due_at') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
</div>
