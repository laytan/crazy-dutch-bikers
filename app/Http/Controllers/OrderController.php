<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\OrderHasProduct;
use App\Product;
use Auth;

class OrderController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('sameOrAdmin')->only('show');
        $this->middleware('role:admin|super-admin')->except('store', 'show');
    }

    /**
     * Admin view for all orders
     */
    public function index() {
        $non_fulfilled = Order::where('fulfilled', '=', false)->get();
        $fulfilled = Order::where('fulfilled', '=', true)->get();
        $deleted = Order::onlyTrashed()->get();
        return view('orders.index', compact('non_fulfilled', 'fulfilled', 'deleted'));
    }

    /**
     * Details about own order or admin view of order with option to fulfill
     */
    public function show(Request $request, Order $order) {
        return view('orders.show', compact('order'));
    }

    /**
     * Ability to set fulfilled
     */
    public function update(Request $request, Order $order) {
        $validatedData = $request->validate([
            'fulfilled' => 'nullable|in:1,0,toggle',
        ]);

        if($validatedData['fulfilled'] !== null) {
            if($validatedData['fulfilled'] === 'toggle') {
                $order->fulfilled = !$order->fulfilled;
            } else {
                $order->fulfilled = $validatedData['fulfilled'];
            }
        }

        $order->save();

        return back()->with('success', 'Bestelling bewerkt');
    }

    /**
     * Delete an order (soft delete)
     */
    public function destroy(Request $request, Order $order) {
        $order->delete();
        return back()->with('success', 'Bestelling verwijderd');
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            // Don't allow anything other than: 1,1,2,33,4544,324,12
            'product-ids' => array('required', 'string', 'not_regex:/([^0-9,]|,,)/'),
        ]);
        
        // Create a new order
        $order          = new Order;
        $order->user_id = Auth::user()->id;

        $order->save();

        // Add all products to the order
        $ids = explode(',', $validatedData['product-ids']);
        foreach($ids as $productId) {
            $orderHasProduct             = new OrderHasProduct;
            $orderHasProduct->product_id = $productId;
            $orderHasProduct->order_id   = $order->id;

            $orderHasProduct->save();
        }

        // TODO: Email admin about order

        // TODO: Email user about order

        return back()->with('success', 'Bestelling geplaatst');
    }
}
