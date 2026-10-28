<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function index(Request $request): View
    {
        abort_unless($request->user()->can('payments.view'), 403);

        $validated = $request->validate([
            'status' => ['nullable', 'in:pending,confirmed,failed,refunded'],
        ]);

        $query = Payment::query()->with(['user', 'enrollment.course', 'confirmer']);

        if (! empty($validated['status'])) {
            $query->where('status', $validated['status']);
        }

        $payments = $query->latest()->paginate(20)->withQueryString();
        $successfulPayments = Payment::query()->where('status', 'confirmed')->count();
        $pendingPayments = Payment::query()->where('status', 'pending')->count();
        $confirmedRevenue = Payment::query()->where('status', 'confirmed')->sum('amount');

        return view('payments.index', compact(
            'payments',
            'successfulPayments',
            'pendingPayments',
            'confirmedRevenue',
        ));
    }

    public function confirm(Request $request, Payment $payment): RedirectResponse
    {
        abort_unless($request->user()->can('payments.confirm'), 403);

        $confirmed = DB::transaction(function () use ($payment, $request): bool {
            $lockedPayment = Payment::query()
                ->whereKey($payment->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($lockedPayment->status !== 'pending') {
                return false;
            }

            $lockedPayment->update([
                'status' => 'confirmed',
                'confirmed_by' => $request->user()->id,
                'paid_at' => now(),
            ]);
            $lockedPayment->enrollment()->update(['status' => 'active']);

            return true;
        });

        if (! $confirmed) {
            return back()->withErrors([
                'payment' => 'لا يمكن تأكيد هذه الدفعة لأنها لم تعد معلّقة.',
            ]);
        }

        return back()->with('success', 'تم تأكيد الدفع وتفعيل التسجيل.');
    }
}
