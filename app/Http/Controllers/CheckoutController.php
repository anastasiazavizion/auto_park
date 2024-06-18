<?php

namespace App\Http\Controllers;

use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Enums\OrderStatus;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function success(Request $request)
    {
        $stripe = new \Stripe\StripeClient(getenv('STRIPE_SECRET_KEY'));
        try{
            $sessionId = $request->get('session_id');
            $session = $stripe->checkout->sessions->retrieve($sessionId);
            $paymentIntent = $session->payment_intent;

            $customer = $stripe->customers->retrieve($session->customer);
            $payment = Payment::where('session_id',$sessionId)->first();

            if(!$payment || $payment->status !== PaymentStatus::Pending->value){
                return redirect(route('checkout.fail'));
            }else{

                $payment->status = PaymentStatus::Paid->value;
                $payment->payment_intent = $paymentIntent;
                $payment->save();

                $order = $payment->order;
                $order->status = OrderStatus::Paid;
                $order->save();

            }


            return inertia('Checkout/Success', ['name'=>$customer->name]);
        }catch (\Exception $exception){
            dd($exception->getMessage());
            abort(404);
        }

    }

    public function fail(Request $request)
    {
        return inertia('Checkout/Fail');
    }

    public function checkout(Request $request)
    {

        $stripe = new \Stripe\StripeClient(getenv('STRIPE_SECRET_KEY'));
        $price = $request->get('price');
        $lineItems = [];
        $lineItems[] =[
            'price_data' => [
                'currency' => 'usd',
                'product_data' => [
                    'name' => $request->get('model'),
                ],
                'unit_amount' => floatval($price) * 100,
            ],
            'quantity' => 1,
        ];

        $checkout_session = $stripe->checkout->sessions->create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'customer_creation' => 'always',
            'success_url' => route('checkout.success', [], true). '?session_id={CHECKOUT_SESSION_ID}', //pass session id
            'cancel_url' => route('checkout.fail', [], true),
        ]);

        $order = Order::create([
            'total'=>$price,
            'car_id'=>$request->get('car_id'),
            'user_id'=>Auth::id(),
            'driver_id'=>$request->get('driver')['id'],
            'status'=>OrderStatus::Unpaid
        ]);

        $payment = Payment::create([
            'total'=>$price,
            'order_id'=>$order->id,
            'session_id'=>$checkout_session->id,
            'status'=>PaymentStatus::Pending
        ]);

        return inertia_location($checkout_session->url);
    }
}
