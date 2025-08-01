<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $tableNumber = $request->query('meja');
        if ($tableNumber) {
            Session::put('table_number', $tableNumber);
        }

        $items = Item::where('is_active', 1)
            ->orderBy('category_id', 'asc')
            ->orderBy('item_name', 'asc')
            ->get();

        return view('customer.menu', compact('items'));
    }

    /**
     * Display the cart contents.
     *
     * @return \Illuminate\View\View
     */
    public function cart()
    {
        $cart = Session::get('cart');

        return view('customer.cart', compact('cart'));
    }

    public function addToCart(Request $request)
    {
        $menuId = $request->input('id');
        $menu = Item::find($menuId);

        if (!$menu) {
            return response()->json([
                'status' => 'error',
                'message' => 'Menu tidak ditemukan',
            ], 404);
        }

        $cart = Session::get('cart', []);

        if (isset($cart[$menuId])) {
            $cart[$menuId]['quantity'] += 1;
        } else {
            $cart[$menuId] = [
                'id' => $menu->id,
                'name' => $menu->item_name,
                'price' => $menu->price,
                'image' => $menu->image,
                'quantity' => 1,
            ];
        }

        Session::put('cart', $cart);

        return response()->json([
            'status' => 'success',
            'message' => 'Menu berhasil ditambahkan ke keranjang',
            'cart' => $cart,
        ], 200);
    }

    public function updateCart(Request $request)
    {
        $itemId = $request->input('id');
        $newQty = $request->input('quantity'); // Sesuai dengan JavaScript

        if ($newQty <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Jumlah tidak boleh kurang dari 1'
            ], 400);
        }

        $cart = Session::get('cart', []);

        if (isset($cart[$itemId])) {
            $cart[$itemId]['quantity'] = $newQty; // Konsisten key-nya
            Session::put('cart', $cart);
            Session::flash('success', 'Keranjang berhasil diperbarui');

            return response()->json([
                'success' => true,
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Item tidak ditemukan di keranjang'
        ], 404);
    }

    public function removeFromCart(Request $request)
    {
        $itemId = $request->input('id');

        $cart = Session::get('cart', []);

        if (isset($cart[$itemId])) {
            unset($cart[$itemId]);
            Session::put('cart', $cart);
            Session::flash('success', 'Item berhasil dihapus dari keranjang');

            return response()->json([
                'success' => true,
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Item tidak ditemukan di keranjang'
        ], 404);
    }

    public function clearAllCart()
    {
        Session::forget('cart');
        Session::flash('success', 'Keranjang berhasil dikosongkan');

        return redirect()->route('cart');
    }

    /**
     * Display the checkout page.
     *
     * @return \Illuminate\View\View
     */
    public function checkout()
    {
        $cart = Session::get('cart');
        if (empty($cart)) {
            Session::flash('error', 'Keranjang Anda kosong. Silakan tambahkan item ke keranjang sebelum checkout.');
            return redirect()->route('cart');
        }
        
        // Retrieve the table number from the session
        $tableNumber = Session::get('table_number');

        return view('customer.checkout', compact('cart', 'tableNumber'));
    }

    public function storeCheckout(Request $request)
    {
        $cart = Session::get('cart');
        if (empty($cart)) {
            Session::flash('error', 'Keranjang Anda kosong. Silakan tambahkan item ke keranjang sebelum checkout.');
            return redirect()->route('cart');
        }

        // Retrieve the table number from the session
        $tableNumber = Session::get('table_number');

        // Validasi input
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $totalAmount = 0;
        foreach ($cart as $item) {
            $totalAmount += $item['price'] * $item['quantity'];

            $itemDetails[]= [
                'id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => (int) ($item['price'] * 0.1 ) + $item['price'],
                'name' => substr($item['name'], 0, 50),
            ];
        }

        $user = User::firstOrCreate([
            'fullname' => $request->input('fullname'),
            'phone' => $request->input('phone'),
            'role_id' => 20,
        ]);
        
        $order = Order::create([
            'order_code' => 'ORD-' .  $tableNumber . '-' . time(),
            'user_id' => $user->id,
            'subtotal' => $totalAmount,
            'tax'       => 0.1 * $totalAmount,
            'grand_total' => $totalAmount + (0.1 * $totalAmount),
            'table_number' => $tableNumber,
            'payment_method' => $request->payment_method,
            'note' => $request->notes,
            'status' => 'pending',
        ]);

        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'item_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'] * $item['quantity'],
                'tax' => 0.1 * $item['price'] * $item['quantity'],
                'total_price' => ($item['price'] * $item['quantity']) + (0.1 * $item['price'] * $item['quantity']),
            ]); 
        }
        // Kosongkan keranjang setelah checkout
        Session::forget('cart');
        Session::flash('success', 'Checkout berhasil. Terima kasih telah berbelanja!');

        return redirect()->route('checkout.success', ['orderId' => $order->order_code]) ;
    }

    public function checkoutSuccess($orderId)
    {
        $order = Order::where('order_code', $orderId)->first();
        if (!$order) {
            Session::flash('error', 'Pesanan tidak ditemukan.');
            return redirect()->route('menu');
        }

        $orderItems = OrderItem::where('order_id', $order->id)->get();

        if($order->patment_method == 'non_tunai') {
            $order->status = 'settlement';
            $order->save();
        }
        return view('customer.success', compact('order', 'orderItems'));
    }
}
