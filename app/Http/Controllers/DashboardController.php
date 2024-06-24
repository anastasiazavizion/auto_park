<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
class DashboardController extends Controller
{
    public function index()
    {

        $ordersNumber = Order::all()->count();
        $ordersTotalIncome = Order::sum('total');
        $ordersTotalIncome = number_format($ordersTotalIncome,'2', '.');

        $paidOrders = Order::paid()->count();

        $countCars = DB::table('orders')
            ->join('cars', 'orders.car_id', '=', 'cars.id')
            ->select('cars.model as name', DB::raw('COUNT(orders.car_id) AS count'))
            ->groupBy('orders.car_id')
            ->get();

        $latestPaidOrders =  Order::paid()
            ->with(['user', 'car'])
            ->orderBy('created_at', 'DESC')
            ->get()
            ->map(function ($order) {
                $order->created_at_human = Carbon::parse($order->created_at)->diffForHumans();
                return $order;
            });

        $driversCount = Driver::select('name')->withCount('orders as count')->get();

        return inertia('Dashboard/Index', compact('countCars', 'driversCount','ordersNumber', 'ordersTotalIncome', 'paidOrders', 'latestPaidOrders'));

    }
}
