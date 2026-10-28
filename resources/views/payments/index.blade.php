<div>
    <!-- He who is contented is rich. - Laozi -->
</div>
<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold" dir="rtl">إدارة المدفوعات اليدوية</h2></x-slot>
    <div class="py-10" dir="rtl">
        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
            <div class="grid gap-4 sm:grid-cols-3">
                <div class="rounded-lg bg-white p-5 shadow-sm"><p class="text-sm text-gray-500">مدفوعات مؤكدة</p><strong class="text-2xl">{{ $successfulPayments }}</strong></div>
                <div class="rounded-lg bg-white p-5 shadow-sm"><p class="text-sm text-gray-500">مدفوعات معلّقة</p><strong class="text-2xl">{{ $pendingPayments }}</strong></div>
                <div class="rounded-lg bg-white p-5 shadow-sm"><p class="text-sm text-gray-500">الإيرادات المؤكدة فقط</p><strong class="text-2xl">{{ number_format((float) $confirmedRevenue, 2) }}</strong></div>
            </div>
            <form method="GET" action="{{ route('payments.index') }}" class="flex gap-3 rounded-lg bg-white p-4 shadow-sm">
                <select name="status" class="rounded-md border-gray-300">
                    <option value="">كل الحالات</option>
                    @foreach (['pending' => 'معلّق', 'confirmed' => 'مؤكد', 'failed' => 'فاشل', 'refunded' => 'مسترد'] as $value => $label)
                        <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                <button class="rounded-md bg-gray-800 px-4 py-2 text-white">تصفية</button>
            </form>
            @if (session('success')) <div class="rounded-lg bg-green-50 p-4 text-green-800">{{ session('success') }}</div> @endif
            @if ($errors->any()) <div class="rounded-lg bg-red-50 p-4 text-red-800">{{ $errors->first() }}</div> @endif
            <div class="overflow-x-auto rounded-lg bg-white shadow-sm">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50"><tr class="text-right">
                        <th class="px-4 py-3">الطالب</th><th class="px-4 py-3">الكورس</th>
                        <th class="px-4 py-3">المبلغ</th><th class="px-4 py-3">الطريقة</th>
                        <th class="px-4 py-3">الحالة</th><th class="px-4 py-3">التاريخ</th><th class="px-4 py-3">الإجراء</th>
                    </tr></thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($payments as $payment)
                            <tr>
                                <td class="px-4 py-3">{{ $payment->user->name }} <span class="text-gray-500">{{ $payment->user->email }}</span></td>
                                <td class="px-4 py-3">{{ $payment->enrollment->course->localized('title') }}</td>
                                <td class="px-4 py-3">{{ number_format((float) $payment->amount, 2) }}</td>
                                <td class="px-4 py-3">{{ $payment->method }}</td>
                                <td class="px-4 py-3">{{ $payment->status }}</td>
                                <td class="px-4 py-3">{{ $payment->paid_at?->format('Y-m-d H:i') ?? $payment->created_at->format('Y-m-d H:i') }}</td>
                                <td class="px-4 py-3">
                                    @if ($payment->status === 'pending')
                                        <form method="POST" action="{{ route('payments.confirm', $payment) }}">
                                            @csrf @method('PATCH')
                                            <button class="rounded bg-green-700 px-3 py-1 text-white">تأكيد الدفع</button>
                                        </form>
                                    @else
                                        {{ $payment->confirmer?->name ?? '—' }}
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="px-4 py-8 text-center text-gray-500">لا توجد مدفوعات.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $payments->links() }}
        </div>
    </div>
</x-app-layout>
