<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmed;
use App\Mail\OrderReceived;
use App\Order;
use App\OrderHasProduct;
use Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Mail;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:view-order,order')->only('show');
        $this->middleware('can:manage')->except('store', 'show');
    }

    /**
     * Admin view for all orders
     */
    public function index(): View
    {
        $non_fulfilled = Order::with('user')->where('fulfilled', '=', false)->get();
        $fulfilled = Order::with('user')->where('fulfilled', '=', true)->get();
        return view('orders.index', compact('non_fulfilled', 'fulfilled'));
    }

    /**
     * Details about own order or admin view of order with option to fulfill
     */
    public function show(Request $request, Order $order): View
    {
        return view('orders.show', compact('order'));
    }

    /**
     * Ability to set fulfilled
     */
    public function update(Request $request, Order $order): RedirectResponse
    {
        $validatedData = $request->validate([
            'fulfilled' => 'nullable|in:1,0,toggle',
        ]);

        if ($validatedData['fulfilled'] !== null) {
            if ($validatedData['fulfilled'] === 'toggle') {
                $order->fulfilled = !$order->fulfilled;
            } else {
                $order->fulfilled = $validatedData['fulfilled'];
            }
        }

        $order->save();

        return back()->with('success', 'Bestelling bewerkt');
    }

    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            // Don't allow anything other than: 1,1,2,33,4544,324,12
            'product-ids' => array('required', 'string', 'not_regex:/([^0-9,]|,,)/'),
        ]);

        // Create a new order
        $order = new Order;
        $order->user_id = Auth::user()->id;

        $order->save();

        // Add all products to the order
        $ids = explode(',', $validatedData['product-ids']);
        foreach ($ids as $productId) {
            $orderHasProduct = new OrderHasProduct;
            $orderHasProduct->product_id = $productId;
            $orderHasProduct->order_id = $order->id;

            $orderHasProduct->save();
        }

        // Email admins about order
        $receivers = parseConfigReceivers(config('app.order_receivers'));
        foreach ($receivers as $receiver) {
            Mail::to($receiver['email'], $receiver['name'])
                ->queue(new OrderReceived($order));
        }

        Mail::to(Auth::user()->email, Auth::user()->name)
            ->queue(new OrderConfirmed($order));

        return redirect()
            ->route('orders.show', ['order' => $order->id])
            ->with('success', 'Wij gaan zo snel mogelijk aan de slag!');
    }
}
