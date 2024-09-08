<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class CartController extends Controller
{
    public function add(Request $request, $id)
    {
        $product = Products::findOrFail($id);
        $quantity = $request->input('quantity', 1);

        $cart = session()->get('cart', []);
        $images = $product->image ? json_decode($product->image, true) : [];
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;
        } else {
            $cart[$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
                'image' => is_array($images) && !empty($images) ? $images[0] : null,
            ];
        }
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Product removed from cart!');
    }

    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }


    public function checkout()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('status', 'You must be logged in to checkout.');
        }
        $user = Auth::user();
        $cart = session()->get('cart', []);
        //store data in cart table
        foreach ($cart as $id => $item) {
            Cart::create([
                'user_id' => $user->id,
                'product_id' => $id,
                'product_qty' => $item['quantity'],
            ]);
        }
        return view('cart.checkout', ['cart' => $cart]);
    }

    public function directCheckout(Request $request, $id)
    {
        $product = Products::findOrFail($id);
        $quantity = $request->input('quantity', 1);

        $cart = session()->get('cart', []);
        $images = $product->image ? json_decode($product->image, true) : [];
        $cart[$id] = [
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => $quantity,
            'image' => is_array($images) && !empty($images) ? $images[0] : null,
        ];
        session()->put('cart', $cart);

        // Redirect to checkout page
        return redirect()->route('checkout');
    }

    public function placeOrder(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('status', 'You must be logged in to place an order.');
        }

        $user = Auth::user();
        $cart = session()->get('cart', []);
        $cartItems = Cart::where('user_id', $user->id)->get();

        // Validate cart is not empty
        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('status', 'Your cart is empty. Please add products to your cart before proceeding to place an order.');
        }

        // foreach ($cart as $id => $item) {
        //     // Save to orders table
        //     Order::create([
        //         'user_id' => $user->id,
        //         'product_id' => $id,
        //         'product_qty' => $item['quantity'],
        //         'product_price' => $item['price'],
        //     ]);
        // }

        $orderNumber = uniqid('ORDER_');    
        foreach ($cartItems as $item) {
            Order::create([
                'user_id' => $user->id,
                'product_id' => $item->product_id,
                'product_qty' => $item->product_qty,
                'product_price' => $item->product->price,
                'order_number' => $orderNumber,
            ]);
        }

        // Clear the cart
        session()->forget('cart');
        Cart::where('user_id', $user->id)->delete();
        return redirect()->route('invoice', ['order_number' => $orderNumber])->with('status', 'Order placed successfully!');
    }

    public function invoice($orderNumber)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('status', 'You need to log in to view the invoice.');
        }

        $user = Auth::user();

        $orders = Order::where('user_id', $user->id)
        ->where('order_number', $orderNumber)
        ->get();

        // Fetch the latest order for the user

        if ($orders->isEmpty()) {
            return redirect()->route('cart.index')->with('status', 'No order found for the invoice.');
        }

        // Calculate totals
        $subtotal = $orders->sum(function ($item) {
            return $item->product_price * $item->product_qty;
        });

        $shippingFee = 23; // Example shipping fee
        $taxFee = 7; // Example tax fee
        $discount = 0; // Example discount
        $total = $subtotal + $shippingFee + $taxFee - $discount;

        return view('cart.invoice', compact('orders', 'subtotal', 'shippingFee', 'taxFee', 'discount', 'total'));
    }

    public function generateInvoice($orderNumber)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('status', 'You need to log in to view the invoice.');
        }

        $user = Auth::user();

        $orders = Order::where('user_id', $user->id)
                   ->where('order_number', $orderNumber)
                   ->get();
        // Fetch the latest order for the user

        if ($orders->isEmpty()) {
            return redirect()->route('cart.index')->with('status', 'No order found for the invoice.');
        }

        // Calculate totals
        $subtotal = $orders->sum(function ($item) {
            return $item->product_price * $item->product_qty;
        });

        $shippingFee = 23; // Example shipping fee
        $taxFee = 7; // Example tax fee
        $discount = 0; // Example discount
        $total = $subtotal + $shippingFee + $taxFee - $discount;
        $pdf = Pdf::loadView('cart.invoicepdf', compact('orders', 'subtotal', 'shippingFee', 'taxFee', 'discount', 'total'));
        return $pdf->download('invoice.pdf');
    }

}
