<div class="space-y-6">
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700">اسم المدرب *</label>
        <input id="name" name="name" value="{{ old('name', $instructor->name) }}" required maxlength="191"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="user_id" class="block text-sm font-medium text-gray-700">حساب المدرب</label>
        <select id="user_id" name="user_id"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @if (! $instructor->exists)
                <option value="">إنشاء حساب مدرب جديد</option>
            @endif
            @foreach ($users as $user)
                <option value="{{ $user->id }}" @selected((string) old('user_id', $instructor->user_id) === (string) $user->id)>
                    {{ $user->name }} ({{ $user->email }})
                </option>
            @endforeach
        </select>
        @if (! $instructor->exists)
            <p class="mt-1 text-xs text-gray-500">اختر حسابًا موجودًا أو أدخل بيانات الحساب الجديد أدناه.</p>
        @endif
        @error('user_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    @if (! $instructor->exists)
        <div class="grid gap-4 rounded-md border border-gray-200 p-4 md:grid-cols-2">
            <div>
                <label for="account_name" class="block text-sm font-medium text-gray-700">اسم الحساب الجديد</label>
                <input id="account_name" name="account_name" value="{{ old('account_name') }}"
                       maxlength="191" class="mt-1 block w-full rounded-md border-gray-300">
                @error('account_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="account_email" class="block text-sm font-medium text-gray-700">البريد الإلكتروني</label>
                <input id="account_email" name="account_email" type="email" value="{{ old('account_email') }}"
                       maxlength="191" class="mt-1 block w-full rounded-md border-gray-300">
                @error('account_email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="account_password" class="block text-sm font-medium text-gray-700">كلمة المرور</label>
                <input id="account_password" name="account_password" type="password" autocomplete="new-password"
                       class="mt-1 block w-full rounded-md border-gray-300">
                @error('account_password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="account_password_confirmation" class="block text-sm font-medium text-gray-700">تأكيد كلمة المرور</label>
                <input id="account_password_confirmation" name="account_password_confirmation" type="password"
                       autocomplete="new-password" class="mt-1 block w-full rounded-md border-gray-300">
            </div>
        </div>
    @endif

    <div>
        <label for="specialization" class="block text-sm font-medium text-gray-700">التخصص</label>
        <input id="specialization" name="specialization" value="{{ old('specialization', $instructor->specialization) }}"
               maxlength="191"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        @error('specialization') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="bio" class="block text-sm font-medium text-gray-700">نبذة تعريفية</label>
        <textarea id="bio" name="bio" rows="5"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('bio', $instructor->bio) }}</textarea>
        @error('bio') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="image" class="block text-sm font-medium text-gray-700">الصورة الشخصية</label>
        @if ($instructor->image)
            <img src="{{ asset($instructor->image) }}" alt="{{ $instructor->name }}" class="my-2 h-24 w-24 rounded-full object-cover">
        @endif
        <input id="image" name="image" type="file" accept="image/jpeg,image/png,image/webp"
               class="mt-1 block w-full text-sm text-gray-700">
        <p class="mt-1 text-xs text-gray-500">JPG أو PNG أو WEBP، بحد أقصى 2 ميغابايت.</p>
        @error('image') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="flex items-center gap-3 border-t border-gray-200 pt-5">
        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 rounded-md text-xs font-semibold text-white uppercase tracking-widest hover:bg-gray-700">
            {{ $instructor->exists ? 'حفظ التعديلات' : 'إضافة المدرب' }}
        </button>
        <a href="{{ route('instructors.index') }}" class="text-sm text-gray-600 hover:text-gray-900">إلغاء</a>
    </div>
</div>
