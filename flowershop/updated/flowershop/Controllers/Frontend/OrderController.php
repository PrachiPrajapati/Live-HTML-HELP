<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Product;
use App\Models\UserAddress;
use App\Models\DeliveryCharge;
use App\Models\Setting;
use App\Models\Color;

class OrderController extends Controller
{
	//Display Products On Order History Page
    public function getOrders(Request $request)
    {
        $products = Order::select('id','custom_id','product_id','color_id','quantity','status')->with(['product:id,title,ar_title,sku,order_amount,image','color:id,color_id,image','color.color:id,title,ar_title'])->where('user_id',Auth::id())->get();

    	if(!$products->isEmpty()){
            return view('frontend.pages.order-history',compact('products'));
    	} else{
            return redirect(route('home'));
        }
    }

    //Display Order Details
    public function getOrderDetails(Request $request, $custom_id)
    {
	    $product = Order::with(['product:id,title,ar_title,sku,image','color:id,color_id,image','color.color:id,title,ar_title','transaction:cart_id,order_id,billing_address_1,billing_email'])->where('custom_id',$custom_id)->firstOrFail();
   	
        return view('frontend.pages.order-detail',compact('product'));
    }
}
