<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->paginate(config('app.paginate_order'));

        return view('orders.index', compact('orders', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $order = new Order();

        $order->user_id = $user->id;
        $order->total = $request->total;
        $order->status = 0;

        $order->save();

        $cartItems = Cart::where('user_id', $user->id)->get();

        foreach ($cartItems as $cartItem) {
            $orderDetail = new OrderDetail();
            $orderDetail->book_id = $cartItem->book_id;
            $orderDetail->quantity = $cartItem->quantity;
            $orderDetail->order_id = $order->id;
            $orderDetail->save();

            $book = Book::where('id', $cartItem->book_id)->first();
            if ($book) {
                $newStock = $book->stock - $cartItem->quantity;
                Book::where('id', $cartItem->book_id)->update(['stock' => $newStock]);
            }
        }

        $carts = Cart::where('user_id', $user->id)->get();

        DB::table('carts')->whereIn('id', $carts->pluck('id'))->delete();

        return redirect()->route('orders.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return view('orderDetails.index', ['order' => $order]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
    public function all()
    {
        $orders = Order::orderBy('created_at', 'desc')->paginate(config('app.paginate_order'));

        return view('admin.orders.list', ['orders' => $orders]);
    }
    public function showDetail(Order $order)
    {
        return view('admin.orders.show', ['order' => $order]);
    }

    public function updateStatus(Request $request)
    {
        $orderId = $request->input('orderId');
        $newStatus = $request->input('newStatus');

        $order = Order::find($orderId);

        if ($order->status != $newStatus) {
            $order->status = $newStatus;
            $order->save();
            return response()->json(['message' => __('success.status_update_success')]);
        } else {
            return response()->json(['error' => __('error.status_already')]);
        }
    }

    public function updateStatusShipped(Request $request)
    {
        $orderId = $request->input('orderId');
        $order = Order::find($orderId);

        if ($order) {
            $order->status = config('app.order_status')['shipped'];
            $order->save();
            return response()->json(['message' => __('success.status_update_success')]);
        } else {
            return response()->json(['error' => __('error.order_not_found')], 404);
        }
    }
}
