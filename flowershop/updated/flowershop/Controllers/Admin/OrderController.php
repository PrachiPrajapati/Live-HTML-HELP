<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Color;
use App\Mail\OrderProcessing;
use App\Mail\OrderUnderProcessing;
use App\Mail\OrderOnTheWay;
use App\Mail\OrderDelivered;
use App\Mail\OrderCancelled;
use App\Mail\OrderRefunded;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $count = Order::count();
        return view('admin.pages.orders.list', compact('count'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($custom_id)
    {
        $order = Order::with(['product:id,custom_id,title,ar_title,image','color','user:id,first_name,last_name','transaction'])->where('custom_id',$custom_id)->first();
        if($order){
            if($order->color != null){
                $color =  color::where('id',$order->color->color_id)->first();
                if($color){
                    $order->color_name = $color->getTitle();
                }else{
                    $order->color_name = "Default Color";
                }
            } else{
                $order->color_name = "Default Color";
            }
            return view('admin.pages.orders.view', compact('order'));
        } else{
            return redirect(route('admin.order.index'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($custom_id)
    {
        $order = Order::where('custom_id',$custom_id)->first();
        if($order){
            if($order->color != null){
                $color =  color::where('id',$order->color->color_id)->first();
                if($color){
                    $order->color_name  = $color->getTitle();
                }else{
                    $order->color_name = "Default Color";
                }
            } else{
                    $order->color_name = "Default Color";
            }
            return view('admin.pages.orders.edit',compact('order'));
        } else{
            return redirect(route('admin.order.index'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $custom_id)
    {
        $order = Order::with('transaction')->where('custom_id',$custom_id)->first();
        if($order != null && $order->transaction != null){
            $data['username']   =   $order->transaction->billing_fname . ' ' . $order->transaction->billing_sname;
            $data['cart_id']    =   $order->cart_id;
            $data['order_date'] =   $order->order_date;

            if($request->status == "Processing"){
                $data['status']     =   'Processing';
                Mail::to($order->transaction->billing_email)->queue(new OrderProcessing($data));       
            }
            elseif ($request->status == "Under Processing") {
                $data['status']     =   'flowers being arranged';
                Mail::to($order->transaction->billing_email)->queue(new OrderUnderProcessing($data));    
            }
            elseif ($request->status == "On The Way") {
                $data['status']         =   'On the way';
                $data['delivery_date']  =   $order->delivery_date;
                $data['delivery_time']  =   $order->delivery_time;
                Mail::to($order->transaction->billing_email)->queue(new OrderOnTheWay($data));  
            }
            elseif ($request->status == "Delivered") {
                $data['status']         =   'Flowers delivered';
                Mail::to($order->transaction->billing_email)->queue(new OrderDelivered($data));  
            }
            elseif ($request->status == "Cancelled") {
                $data['status']         =   'Order cancelled';
                Mail::to($order->transaction->billing_email)->queue(new OrderCancelled($data));  
            }
            elseif ($request->status == "Refunded") {
                $data['status']         =   'Refunded';
                $data['billing_amount'] =   $order->billing_amount;
                Mail::to($order->transaction->billing_email)->queue(new OrderRefunded($data));  
            }

            $order->fill($request->all());
            
            if($order->save()){
                flash('order details updated successfully!')->success();
            }else{
                flash('Unable to update order. Try again later')->error();
            }
        }
            return redirect(route('admin.order.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function listing(Request $request)
    {
        extract($this->DTFilters($request->all()));
        $orders = Order::orderBy($sort_column,$sort_order);

        if( !empty($search) ) {
            $orders->where("price", "like", "%{$search}%")
                    ->orWhere("quantity", "like", "%{$search}%")
                    ->orWhere("status", "like", "%{$search}%")
                    ->orWhere("billing_amount", "like", "%{$search}%"); 
            
            $data = $orders->get();

            if( $data->isEmpty() ){
                $products =  Product::where("sku", "like", "%{$search}%")
                                    ->orWhere("title", "like", "%{$search}%")
                                    ->orWhere("ar_title", "like", "%{$search}%")
                                    ->pluck('id')->toArray();

                if($products != []){
                    $orders = Order::orderBy($sort_column,$sort_order);
                    $orders->whereIn('product_id',[$products]);
                }
            }
        }
        
        $count = $orders->count();
        $records["recordsTotal"] = $count;
        $records["recordsFiltered"] = $count;
        $records['data'] = array();

        $orders->offset($offset)->limit($limit);
        foreach ($orders->get() as $order) {
            $params = array(
               'checked'=> ($order->is_active == 'y' ? "checked" : ""),
               'getaction'=>'',
               'class'=>'',
               'id'=> $order->custom_id,
            );

            $product =  Product::where('id',$order->product_id)->first();
            if($product != null){
                $product_id = $product->getEnglishTitle();
            }else{
                $product_id = "Product Name";
            }

            $records['data'][] = [
                'id'                =>  $order->id,
                'product_id'        =>  $product_id,
                'quantity'          =>  $order->quantity,
                'billing_amount'    =>  $order->billing_amount,
                'order_date'        =>  $order->order_date,
                'delivery_date'     =>  $order->delivery_date,
                'status'            =>  $order->status,
                'action'            =>  view('admin.layout.includes.actions')->with(['id'=> $order->custom_id], $order)->render(),
                'checkbox'          =>  view('admin.layout.includes.checkbox')->with('id',$order->custom_id)->render(),
            ];
        }
        return $records;
    }
}
