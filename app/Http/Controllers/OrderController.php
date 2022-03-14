<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use \Carbon\Carbon;
use App\Models\Order;
use App\Models\OrderItem;

class OrderController extends Controller
{
    function store(Request $request){
//        $date = Carbon::now();
//        Order::create([
//            'user_id' => $request->user_id,
//            'order_date' => $date->toDateString(),
//            'order_amount'=> $request->order_amount
//        ]);
//        Order_item::create([
//            'order_id' => $request->order_id,
//            'order_date' => $date->toDateString(),
//            'order_amount'=> $request->order_amount
//        ])->where('order_item.order_id','=','order.id');
//
//        return response()->json(
//            [
//                'message' => "Placed order",
//            ],
//            201
//        );
        DB::beginTransaction();
        try{

            $order = new Order();
            $order->order_number = uniqid('ORD.');
            $order->user_id = Auth::id();
            $order->item_count = 2;
            $order->grand_total = 20;
            $order->save();

            $items = json_decode($request->getContent(), true);

            foreach( $items as $item ){
                $orderItem = new OrderItem;
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $item['product_id'];
                $orderItem->price = $item['price'];
                $orderItem->quantity = $item['quantity'];
                $orderItem->save();
            }
            DB::commit();
        }catch (\Exception $e ){
            DB::rollBack();
        }
        return response()->json(
            [
                'message' => "Placed order",
            ],
            201
        );
    }
}
