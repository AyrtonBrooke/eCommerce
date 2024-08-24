<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\Checkout;
use Illuminate\Http\Request;

class UserOrderController extends Controller
{
    public function index()
    {
        $orders = Order::orderBy('id', 'DESC')->get();
        return view('order.index', compact('orders'));
    }

    public function destroy($id)
    {
        Order::find($id)->delete();
        return redirect()->route('user.order')->with('message', 'Order deleted');

    }

    public function customers()
    {
        $customers = User::where('is_admin', 0)->get();
        return view('customers', compact('customers'));
    }
    function checkout(Request $request)
    {
        $deliveryChoice = $request->input('delivery_choice');

        $orders = Order::all();
        foreach ($orders as $order) {
            // Create a new checkout record
            $checkout = new Checkout();
            $checkout->user_id = $order->user_id;
            $checkout->pizza_id = $order->pizza_id;
            $checkout->pizza_price = $order->pizza_price;
            $checkout->pizza_size = $order->pizza_size;
            $checkout->body = $order->body;
            $checkout->phone = $request->phone;
            $checkout->total = $request->total;
            $checkout->delivery_choice = $deliveryChoice;
            $checkout->save();
        }

        Order::truncate();
        return redirect()->back()->with('success', 'Checkout successful!');
    }
}
