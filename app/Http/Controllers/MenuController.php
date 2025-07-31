<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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

    public function checkout()
    {
        $cart = Session::get('cart', []);
        $tableNumber = Session::get('table_number');

        return view('customer.checkout', compact('cart', 'tableNumber'));
    }
}
