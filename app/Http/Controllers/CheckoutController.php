<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class CheckoutController extends Controller
{
    public function checkout(Request $request, Course $course): RedirectResponse
    {
        $user = $request->user();

        abort_unless($user->isStudent(), 403);
        $existing = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if ($existing?->status === 'active') {
            return back()->with('success', 'أنت مسجّلة في هذا الكورس.');
        }
        if ((float) $course->price <= 0) {
            Enrollment::updateOrCreate(
                ['user_id' => $user->id, 'course_id' => $course->id],
                ['status' => 'active']
            );

            return back()->with('success', 'تم تسجيلك في الكورس.');
        }

        $enrollment = Enrollment::updateOrCreate(
            ['user_id' => $user->id, 'course_id' => $course->id],
            ['status' => 'pending']
        );

        $payment = Payment::firstOrCreate(
            ['enrollment_id' => $enrollment->id, 'status' => 'pending'],
            [
                'user_id' => $user->id,
                'amount'  => $course->price,
                'method'  => 'stripe',
            ]
        );

        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            $session = Session::create([
                'mode'           => 'payment',
                'customer_email' => $user->email,
                'line_items'     => [[
                    'quantity'   => 1,
                    'price_data' => [
                        'currency'     => 'usd',
                        'unit_amount'  => (int) round($course->price * 100),
                        'product_data' => ['name' => $course->localized('title')],
                    ],
                ]],
                'metadata'    => ['payment_id' => $payment->id],
                'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url'  => url()->previous(),
            ]);
        } catch (\Throwable $e) {
            report($e);

            return back()->with('error', 'تعذّر بدء عملية الدفع.');
        }

        $payment->update(['reference' => $session->id]);

        return redirect()->away($session->url);
    }

    public function success(Request $request): RedirectResponse
    {
        $sessionId = $request->query('session_id');

        if (! $sessionId) {
            return redirect()->route('student.courses');
        }

        try {
            Stripe::setApiKey(config('services.stripe.secret'));
            $session = Session::retrieve($sessionId);
      } catch (\Throwable $e) {
    report($e);


    return back()->with('error', 'تعذّر بدء عملية الدفع.');

}

        if ($session->payment_status === 'paid') {
            DB::transaction(function () use ($session, $request) {
                $payment = Payment::lockForUpdate()
                    ->where('reference', $session->id)
                    ->where('user_id', $request->user()->id)
                    ->first();

                if ($payment && $payment->status !== 'paid') {
                    $payment->update(['status' => 'paid', 'paid_at' => now()]);
                    $payment->enrollment->update(['status' => 'active']);
                }
            });

            return redirect()->route('student.courses')
                ->with('success', 'تم الدفع والتسجيل بنجاح.');
        }

        return redirect()->route('student.courses')
            ->with('error', 'لم يكتمل الدفع.');
    }
}
