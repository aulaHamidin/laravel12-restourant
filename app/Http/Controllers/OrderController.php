<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Logic to retrieve and display orders
        $orders = Order::all()->sortBy('created_at');
        return view('admin.order.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::findOrFail($id);
        $orderItems = OrderItem::where('order_id', $id)->get();

        return view('admin.order.show', compact('order', 'orderItems'));
    }

    public function updateStatus($id)
    {
        $order = Order::findOrFail($id);
        
        if(Auth::user()->role->role_name == 'admin' || Auth::user()->role->role_name == 'cashier') {
            $order->status = 'settlement';
        } else {
            $order->status = 'coocked';
        }

        $order->save();

        return redirect()->route('orders.index')->with('success', 'Order status has been updated.');
    }
}
