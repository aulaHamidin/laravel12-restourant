<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Logic to retrieve and display orders
        $orders = Order::with('user')->get();
        return view('admin.order.index', compact('orders'));
    }
    
}
