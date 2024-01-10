<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\UserAddressRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\UserAddress;
use App\Models\Setting;
use App\Models\Cart;
use App\Models\DeliveryCharge;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\Country;
use Cookie;

class CheckoutController extends Controller
{
    //CHECKOUT(When User Login)
    public function showCheckoutWhenLogin(Request $request)
    {
        $products = Cart::with(['product:id,slug,title,ar_title,order_amount,minimum_qty,total_stock,image','color'])->where('user_id',Auth::id())->orderby('product_id')->get();

        if(!$products->isEmpty()){
            $delivery_charge     =  $sub_total_array[] =   $subTotal    =   $total   =   0;
            $userDefaultAddress  =  $userAddress       =   null;
            $redirect            =  false;
            $vat                 =  $this->vat;

            // SUB TOTAL
            foreach ($products as $key => $data) {
                if($data->product != null){
                    $sub_total_array[] = $data->product->order_amount * $data->quantity;
                } else{
                    $data->delete();
                    $redirect = true;
                }
            }
            
            if($redirect == false){
             
                $subTotal   =   array_sum($sub_total_array);
               
                $userDefaultAddress = UserAddress::select('id','first_name','last_name','country_id','city_id','address','pincode')->with(['city:id,en_city,ar_city,charges','country:id,en_name,ar_name'])->where([ 'user_id' => Auth::id(),'is_default' => 'y'])->firstOrFail();

                if($userDefaultAddress->city != null){
                    $delivery_charge = $userDefaultAddress->city->charges;
                }
                
                if($subTotal != 0){
                    $total = $subTotal + $delivery_charge + ( ( $subTotal + $delivery_charge ) * $vat ) / 100;
                }
            
                $userAddress    =   UserAddress::select('id','first_name','last_name','country_id','city_id','address','pincode')->with(['city:id,en_city,ar_city,charges','country:id,en_name,ar_name'])->where('user_id',Auth::id())->orderBy('id','DESC')->get();
               
                $country        =   Country::select('id','en_name','ar_name')->where('is_active','y')->get();

                return view('frontend.pages.logged-in-checkout',compact('userDefaultAddress','userAddress','country','products','delivery_charge','total','subTotal','vat'));
            } else{
                return redirect()->back();
            }
        }
        else{
            return redirect()->route('home');
        }
    }

    //Checkout(Guest User)
    public function showCheckoutForGuest(Request $request)
    {
        if( $request->user() ){
            return redirect()->route('home');
        }else{
            $total = 0; $vat  = $this->vat; $products = $subTotal = null;

            $cookies = Cookie::get();

            foreach ($cookies as $key => $cookie) {             
                $length = config('utility.custom_length', 20);

                if(strlen($key) >= $length){
                    if(strlen($key) == $length){
                        $custom_id = $key;
                    }else{
                        $custom_id = substr($key,0,$length);
                    }

                    $product = Product::select('id','custom_id','category_id','slug','title','ar_title','sku','minimum_qty','total_stock','order_amount','image')->where('custom_id',$custom_id)->where('is_active','y')->first();
                    if($product){
                        $cookie                         =   json_decode($cookie);
                        if($cookie != null){
                            $products[$key]                 =   $product;
                            $products[$key]['color_id']     =   $cookie->color_id;
                            $products[$key]['quantity']     =   $cookie->quantity;
                        }
                    }
                }
            }

            if(!empty($products)){
                // SUB TOTAL
                foreach ($products as $key => $data) {
                    if($data->color_id != null){
                        $product_color =  ProductColor::where('id',$data->color_id)->first();
                        if($product_color){
                            $data->image = $product_color->image;
                        }   
                    }
                    $sub_total_array[] = $data->order_amount * $data->quantity;
                }
                $subTotal = array_sum($sub_total_array);

                if($subTotal != 0){
                    $total = $subTotal + ( $subTotal * $vat ) / 100;
                }
                $countries = Country::select('id','en_name','ar_name')->where('is_active','y')->get();

                return view('frontend.pages.checkout',compact('products','countries','subTotal','vat','total'));
            }else{
                return redirect()->route('home');
            }
            
        }
    }

    // Remove Product From Checkout(Login User)
    public function removeFromCheckout(Request $request)
    {
    	$product = Cart::where(['user_id' => Auth::id(), 'product_id' => $request->product_id, 'quantity' => $request->quantity])->first();

    	if($product){
    		$product->delete();

    		$products   =   Cart::where('user_id',Auth::id())->get();
			$count 		=   $products->count();
  			$subTotal[] =   $delivery_charge = 0; 
            $vat        =   $this->vat;

			if($count >= 1){
                $userAddress =  UserAddress::with('city')->where(['user_id' => Auth::id(), 'is_default' => 'y'])->firstOrFail();

				foreach ($products as $key => $data) {	
					$sub_total_array[] = $data->product->order_amount * $data->quantity;
				}
				$subTotal = array_sum($sub_total_array);

                if($userAddress->city != null){
                    $delivery_charge = $userAddress->city->charges;
                }
                  
			  	if($subTotal != 0){
                    $total = $subTotal + $delivery_charge + ( ( $subTotal + $delivery_charge ) * $vat ) / 100;
                }
							
				$Response['header'] 	      =   view('frontend.layouts.includes.header')->render();
        		$Response['subTotal']         =   "<td id='subTotal'>$$subTotal</td>";
        		$Response['vat']              =   "<td id='vat'>$vat %</td>";
    			$Response['total']            =   "<td id='total'>$$total</td>";		
                $Response['delivery_charge']  =   "<td id='delivery_charge'>$$delivery_charge</td>";
	   			$Response['success']          =   trans('messages.success',['entity' => 'product removed']);
			}
			elseif($count < 1){
                $Response['fail'] = trans('messages.fail',['entity' => 'product']);
			}
    	}
    	else{
            $Response['fail'] = trans('messages.fail',['entity' => 'product']);
    	}
    	return response()->json($Response,200);
    }


    //Change City In Checkout(Guest User)
    public function getCity(Request $request)
    {
        $charges = null;
        $delivery_data = DeliveryCharge::select('charges')->where('id',$request->city)->where('is_active','y')->first();
        $charges = $delivery_data->charges;                       

        if($charges != null){
            $data  = $products = null;
            $total = $subTotal = 0;
            $vat   = $this->vat;

            $cookies = Cookie::get();

            foreach ($cookies as $key => $cookie) {             
                $length = config('utility.custom_length', 20);

                if(strlen($key) >= $length){
                    if(strlen($key) == $length){
                        $custom_id = $key;
                    }else{
                        $custom_id = substr($key,0,$length);
                    }

                    $product = Product::select('id','custom_id','category_id','slug','title','ar_title','sku','minimum_qty','total_stock','order_amount','image')->where('custom_id',$custom_id)->where('is_active','y')->first();
                    if($product){
                        $cookie                         =   json_decode($cookie);
                        if($cookie != null){
                            $products[$key]                 =   $product;
                            $products[$key]['color_id']     =   $cookie->color_id;
                            $products[$key]['quantity']     =   $cookie->quantity;
                        }
                    }
                }
            }

            if(!empty($products)){
                
                foreach ($products as $key => $data) {
                    $sub_total_array[] = $data->order_amount * $data->quantity;
                }
                $subTotal = array_sum($sub_total_array);
            
                if($subTotal != 0){
                    $total = $subTotal + $charges + ( ( $subTotal + $charges ) * $vat ) / 100;
                }

                $Response['success']    =   trans('messages.success',['entity' => 'city changed']);
                $Response['subTotal']   =   "<td id='subTotal'>$$subTotal</td>";
                $Response['vat']        =   "<td id='vat'>$vat %</td>";
                $Response['total']      =   "<td id='total'>$$total</td>";
                $Response['charges']    =   "<td id='charges'>$$charges.00</td>";
            }
        }else{
            $Response['fail']    = trans('messages.fail',['entity' => 'city']);
        }
        return response($Response,200);
    }

    // add gift message on checkout page
    public function addGiftMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cart_id'       =>  'nullable',
            'product_id'    =>  'required',
            'color_id'      =>  'nullable',
            'message'       =>  'required|max:500',
        ]);

        if ($validator->fails()) {
            $Response['serverError'] = $validator->messages();
        }else{         
            if($request->color_id == 'null'){
                $request['color_id'] = null;
            }  

            if($request->user()){
                $cart = Cart::updateOrCreate([
                    'id'            =>  $request->cart_id,
                    'product_id'    =>  $request->product_id,
                    'color_id'      =>  $request->color_id,
                ],[
                    'message'       =>  $request->message,
                ]);

                if($cart->save()){
                    $Response['success']    =   trans('messages.success',['entity' => 'message added']);
                }else{
                    $Response['fail']    = trans('messages.fail',['entity' => 'product']);
                }
            }
            else{
                $product = Product::select('custom_id')->where('id',$request->product_id)->where('is_active','y')->first();
                if($product){
                    $cookie_name = $request->custom_id;

                    if($request->color_id != null){
                        $color = ProductColor::select('custom_id')->where('id',$request->color_id)->first();
                        if($color){
                            $cookie_name = $request->custom_id.$color->custom_id;
                        }
                    }

                    if($user = $request->cookie($cookie_name)){
                        if($user != null){
                            $data       = json_decode($user);
                            $minutes    = 1440;
                            $user       = [ 
                                'custom_id' => $product->custom_id,
                                'color_id'  => $data->color_id,
                                'quantity'  => $request->quantity,
                                'message'   => $request->message
                            ];
                            $array_json = json_encode($user);

                            $Response   = new Response([
                                $Response['success'] = trans('messages.success',['entity' => 'message added']),
                            ]);
                            $Response->withCookie(cookie($cookie_name,$array_json,$minutes));
                            return $Response;
                        }          
                    }
                }else{
                     $Response['fail']    = trans('messages.fail',['entity' => 'product']);
                }
            } 
        }
        return response($Response,200);
    }

    //get gift message data on checkout page
    public function getGiftMessage(Request $request)
    {
        if($request->user()){
            $cart = Cart::where('id',$request->cart_id)->first();
            if($cart){
                $cart =  $cart->toArray();
                $Response['cart'] = json_encode($cart);
                $Response['success'] = trans('messages.success',['entity' => 'message fetch']);
            }else{
                $Response['fail']    = trans('messages.fail',['entity' => 'message']);
            }
        }else{
            $product = Product::select('custom_id')->where(['id' => $request->product_id, 'is_active' => 'y'])->first();
            if($product){
                $cookie_name = $request->custom_id;

                if($request->color_id){
                    $color = ProductColor::select('custom_id')->where('id',$request->color_id)->first();
                    if($color){
                        $cookie_name = $request->custom_id.$color->custom_id;
                    }
                }

                if($user = $request->cookie($cookie_name)){
                    if($user != null){
                        $data       = json_decode($user);
                        $Response['message'] = json_encode($data);
                        $Response['success'] = trans('messages.success',['entity' => 'message fetch']);
                            
                    }else{
                        $Response['fail']    = trans('messages.fail',['entity' => 'message']);
                    }          
                }
            }else{
                $Response['fail']    = trans('messages.fail',['entity' => 'message']);
            }
        }
        return response($Response,200);
    }
}
