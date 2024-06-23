<?php

namespace App\Http\Controllers;

use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\OrderStatus;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CheckoutController extends Controller
{
    private function updateOrderInfo($sessionId, $paymentIntent)
    {
        $payment = Payment::where('session_id',$sessionId)->first();
        if(!$payment || ($payment->status !== PaymentStatus::Pending->value && $payment->status !== PaymentStatus::Paid->value)){
            throw new NotFoundHttpException();
        }else{
            $payment->status = PaymentStatus::Paid->value;
            $payment->payment_intent = $paymentIntent;
            $payment->save();
            $order = $payment->order;
            $order->status()->associate(OrderStatus::byName('Paid')->first());
            $order->save();
        }
    }
    public function success(Request $request)
    {
        $stripe = new \Stripe\StripeClient(getenv('STRIPE_SECRET_KEY'));
        try{
            $sessionId = $request->get('session_id');
            $session = $stripe->checkout->sessions->retrieve($sessionId);
            $paymentIntent = $session->payment_intent;
            $customer = $stripe->customers->retrieve($session->customer);
            try{
                $this->updateOrderInfo($sessionId, $paymentIntent);
            }catch (NotFoundHttpException $e){
                return redirect(route('checkout.fail'));
            }
            return inertia('Checkout/Success', ['name'=>$customer->name]);
        }catch (\Exception $exception){
            abort(404);
        }

    }

    public function fail(Request $request)
    {
        return inertia('Checkout/Fail');
    }

    private function generateItemsArray(float $price, string $name): array
    {
        $lineItems = [];
        $lineItems[] =[
            'price_data' => [
                'currency' => 'usd',
                'product_data' => [
                    'name' => $name,
                ],
                'unit_amount' => $price * 100,
            ],
            'quantity' => 1,
        ];
        return $lineItems;
    }

    private function getHoursAmount(string $date1, string $date2)
    {
        $date1 = new \DateTime($date1);
        $date2 = new \DateTime($date2);
        $diff = $date2->diff($date1);
        $hours = $diff->h;
        $minutes = $diff->i;
        if($minutes > 15){
            $hours++;
        }
        return $hours;
    }

    private function getEndPrice(float $price, int $hours)
    {
        return $price * $hours;
    }

    private function createSession($lineItems)
    {
        $stripe = new \Stripe\StripeClient(getenv('STRIPE_SECRET_KEY'));
        return $stripe->checkout->sessions->create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'customer_creation' => 'always',
            'success_url' => route('checkout.success', [], true). '?session_id={CHECKOUT_SESSION_ID}', //pass session id
            'cancel_url' => route('checkout.fail', [], true),
        ]);
    }

    public function checkout(Request $request)
    {
        $hours = $this->getHoursAmount($request->start,$request->finish);

        $price = $this->getEndPrice($request->get('price'), $hours);

        $lineItems = $this->generateItemsArray($price,$request->get('model'));
        $checkout_session = $this->createSession($lineItems);

        $order = Order::make([
            'total'=>$price,
            'car_id'=>$request->get('car_id'),
            'user_id'=>Auth::id(),
            'driver_id'=>$request->get('driver'),
        ]);

        $order->status()->associate(OrderStatus::byName('Unpaid')->first());
        $order->save();

        $payment = Payment::create([
            'total'=>$price,
            'order_id'=>$order->id,
            'session_id'=>$checkout_session->id,
            'status'=>PaymentStatus::Pending
        ]);

        return inertia_location($checkout_session->url);
    }

    public function checkoutOrder(Order $order)
    {
        $car = $order->car;
        $lineItems = $this->generateItemsArray($car->price,$car->model);
        $checkout_session = $this->createSession($lineItems);
        $order->payment->session_id=$checkout_session->id;
        $order->payment->save();
        return inertia_location($checkout_session->url);
    }

    public function webhook()
    {
        $stripe = new \Stripe\StripeClient(getenv('STRIPE_SECRET_KEY'));
        //whsec_69eb21bda20b8a0ec1177383c410568e43a16b27c7c06f5c7dc03a0e71caf3a0
        $endpoint_secret = 'whsec_69eb21bda20b8a0ec1177383c410568e43a16b27c7c06f5c7dc03a0e71caf3a0';

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch(\UnexpectedValueException $e) {
            // Invalid payload
            http_response_code(400);
            exit();
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            http_response_code(400);
            exit();
        }

// Handle the event
        switch ($event->type) {
            case 'checkout.session.completed':
                $dataPayment = $event->data->object;
                $sessionId = $dataPayment['id'];
                $paymentIntent = $dataPayment['payment_intent'];
                try{
                    $this->updateOrderInfo($sessionId, $paymentIntent);
                }catch (NotFoundHttpException $e){
                    return redirect(route('checkout.fail'));
                }
            default:
                echo 'Received unknown event type ' . $event->type;
        }

        return response('', 200);

    }
}
