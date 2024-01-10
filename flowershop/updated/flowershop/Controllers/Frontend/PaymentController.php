<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use App\Models\DeliveryCharge;
use App\Models\Transaction;
use App\Models\UserAddress;
use App\Models\Setting;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\Country;
use App\Mail\ThankYou;
use App\Mail\PaymentSuccess;
use App\Mail\PaymentFailure;
use App\Mail\OrderReceived;
use Carbon\Carbon;
use Cookie;

class PaymentController extends Controller
{
    // When Order Now Button is Clickde on checkout(For Payment) 
    public function orderPayment(Request $request)
    {
        $vat = $this->vat;

        //Login User
        if( $request->user() ){
            $userAddress =  UserAddress::with(['country','city'])->where(['user_id' => Auth::id(), 'is_default' => 'y'])->firstOrFail();

            //When Biiling Address Is Deferent
            if($request->first_name != null && $request->last_name != null && $request->address != null){
                
                $city = DeliveryCharge::select('en_city','ar_city')->where('id',$request->city)->firstOrFail();
                $request['city'] = $city->getCity();

                $country = Country::findOrFail($request->country);
                if($userAddress->city != null){
                    $request['delivery_city']   =   $userAddress->city->getCity();
                }
                if($userAddress->country != null){
                    $request['delivery_country']    =   $userAddress->country->getName();
                }

                //SET BILLING PARAMETERS
                $request['billing_first_name']  =    $request->first_name;
                $request['billing_last_name']   =    $request->last_name;
                $request['billing_address']     =    $request->address;
                $request['billing_pincode']     =    $request->pincode;
                $request['billing_phone']       =    $request->phone;
                $request['billing_email']       =    $request->email;
                $request['billing_city']        =    $request->city;
                $request['billing_country']     =    $country->getName();

                //SET DELIVERY PARAMETES
                $request['delivery_first_name']     =   $userAddress->first_name;
                $request['delivery_last_name']      =   $userAddress->last_name;
                $request['delivery_address']        =   $userAddress->address;
                $request['delivery_pincode']        =   $userAddress->pincode;
                $request['delivery_phone']          =   $userAddress->contact;
                $request['delivery_email']          =   Auth::user()->email;

            }else{
                // When Biiling Address & Delivery Address Are Same
                if($userAddress->city != null){
                    $request['billing_city']    =   $userAddress->city->getCity();
                    $request['delivery_city']   =   $userAddress->city->getCity();
                }
                if($userAddress->country != null){
                    $request['billing_country']     =   $userAddress->country->getName();
                    $request['delivery_country']    =   $userAddress->country->getName();
                }

                //SET BILLING AND DELIVERY DATA
                $request['billing_first_name']  =   $request['delivery_first_name']     =   $userAddress->first_name;
                $request['billing_last_name']   =   $request['delivery_last_name']      =   $userAddress->last_name;
                $request['billing_address']     =   $request['delivery_address']        =   $userAddress->address;
                $request['billing_pincode']     =   $request['delivery_pincode']        =   $userAddress->pincode;
                $request['billing_phone']       =   $request['delivery_phone']          =   $userAddress->contact;
                $request['billing_email']       =   $request['delivery_email']          =   Auth::user()->email;
            }   

            $products   =  Cart::with(['product','color'])->where('user_id',Auth::id())->orderby('product_id')->get();
            $subTotal[] =  $delivery_charge = $sub_total_array[] = 0;
            $redirect   =  false;

            if($products != null && !$products->isEmpty()){

                // SUB TOTAL
                foreach ($products as $key => $data) {
                    if($data->product != null){
                        $sub_total_array[] = $data->product->order_amount * $data->quantity;
                    } else{
                        $redirect = true;
                    }
                }

                //WHEN ALL PRODUCTS ARE ACTIVE AND AVALIBLE TO BUY
                if($redirect == false){
                    $total = 0;
                    $subTotal = array_sum($sub_total_array);

                    $delivery_charge = DeliveryCharge::select('charges')->where('en_city',$request->delivery_city)->orWhere('ar_city',$request->delivery_city)->where('is_active','y')->first();

                    $delivery_charge = $delivery_charge['charges'];

                    if($subTotal >= 0){
                        $total = $subTotal + $delivery_charge + ( ( $subTotal + $delivery_charge ) * $vat ) / 100;
                    }

                    if($total >= 0){

                        $telrManager = new \TelrGateway\TelrManager();

                        $billingData = $request->billing_first_name.' '.$request->billing_last_name.' '.$request->billing_address
                                      .' '.$request->billing_city.' '.$request->billing_pincode.' '.$request->billing_country.' '.$request->billing_phone;
                       
                        $billingParams = [
                                'first_name'    => $request->delivery_first_name,
                                'sur_name'      => $request->delivery_last_name,
                                'address_1'     => $request->delivery_address,
                                'address_2'     => $billingData,
                                'city'          => $request->delivery_city,
                                'zip'           => $request->delivery_pincode,
                                'country'       => $request->delivery_country,
                                'email'         => Auth::user()->email,
                        ];

                        $url_link      =   $telrManager->pay(1, $total, 'Flower Shop Payment Details', $billingParams)->redirect();
                        $url           =   $url_link->getTargetUrl();

                        $transaction   =   Transaction::where(['billing_fname'      => $request->delivery_first_name,
                                                               'billing_sname'      => $request->delivery_last_name,
                                                               'billing_address_1'  => $request->delivery_address,
                                                               'billing_zip'        => $request->delivery_pincode,
                                                               'amount'             => $total])->latest()->firstOrFail();
                       

                        $total_vat          =   ($subTotal + $delivery_charge) * $vat / 100;
                        $count              =   $products->count();
                        $vat_amount         =   $total_vat / $count;
                        $delivery_charge    =   $delivery_charge / $count;
                        $orderData          =   [];

                        foreach ($products as $key => $data){
                            if($data->product != null){
                                $total_amount       =   $data->product->order_amount * $data->quantity + $delivery_charge;
                                $billing_amount     =   $total_amount + $vat_amount;

                                $orderData[] = [
                                    'custom_id'         =>  getUniqueString('orders'),
                                    'user_id'           =>  Auth::id(),
                                    'cart_id'           =>  $transaction->cart_id,
                                    'product_id'        =>  $data->product->id,
                                    'color_id'          =>  $data->color_id,
                                    'quantity'          =>  $data->quantity,
                                    'price'             =>  $data->product->order_amount,
                                    'vat'               =>  $vat,
                                    'vat_amount'        =>  $vat_amount,
                                    'delivery_charge'   =>  $delivery_charge,
                                    'total_amount'      =>  $total_amount,
                                    'billing_amount'    =>  $billing_amount,
                                    'order_date'        =>  \Carbon\Carbon::now(),
                                    'delivery_date'     =>   Carbon::createFromFormat('m/d/Y', $request->delivery_date),
                                    'delivery_time'     =>  $request->delivery_time,
                                    'comment'           =>  $request->delivery_comment,
                                    'message'           =>  $data->message,
                                    'created_at'    =>  \Carbon\Carbon::now(),
                                    'updated_at'    =>  \Carbon\Carbon::now(),
                                ];
                            }
                        }

                        Order::insert($orderData);
                        return redirect($url);
                    }else{
                        return redirect()->back();
                    }
                } else{
                    return redirect()->back();
                }
            } else{
                return redirect()->back();
            }
        } 
        else{
            // GUEST USER
            $cookies = Cookie::get();
            $products = null;

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
                            $products[$key]['message']      =   $cookie->message;
                        }
                    }
                }
            }

            if(!empty($products)){
                // SUB TOTAL
                foreach ($products as $key => $data) {
                    $sub_total_array[] = $data->order_amount * $data->quantity;
                }
                $subTotal = array_sum($sub_total_array);

                $delivery_data = DeliveryCharge::where('id',$request->city)->where('is_active','y')->first();
                $delivery_charge = $delivery_data['charges']; 

                if($subTotal != 0){
                   $total = $subTotal + $delivery_charge + ( ( $subTotal + $delivery_charge ) * $vat ) / 100;
                }

                if($total > 0){
                    $telrManager = new \TelrGateway\TelrManager();
                    $country = Country::findOrFail($request->emirate);

                    $billingParams = [
                            'first_name'    => $request->first_name,
                            'sur_name'      => $request->last_name,
                            'address_1'     => $request->address,
                            'address_2'     => $request->address,
                            'region'        => '',       
                            'city'          => $delivery_data->getCity(),
                            'zip'           => $request->pincode,
                            'country'       => $country->getName(),
                            'email'         => $request->email,
                        ];

                    $url_link         =   $telrManager->pay(1, $total, 'Flower Shop Payment Details', $billingParams)->redirect();
                    $url              =   $url_link->getTargetUrl();
                    $transaction      =   Transaction::where('amount',$total)->latest()->first();

                    $total_vat          =   ($subTotal + $delivery_charge) * $vat / 100;
                    $count              =   count($products);
                    $vat_amount         =   $total_vat / $count;
                    $delivery_charge    =   $delivery_charge / $count;
                    $orderData          =   [];

                    foreach ($products as $key => $product){
                        $total_amount       =   $product->order_amount * $product->quantity + $delivery_charge;
                        $billing_amount     =   $total_amount + $vat_amount;

                        $orderData[] = [
                            'custom_id'         =>  getUniqueString('orders'),
                            'cart_id'           =>  $transaction->cart_id,
                            'user_id'           =>  null,
                            'product_id'        =>  $product->id,
                            'color_id'          =>  $product->color_id,
                            'quantity'          =>  $product->quantity,
                            'price'             =>  $product->order_amount,
                            'vat'               =>  $vat,
                            'vat_amount'        =>  $vat_amount,
                            'delivery_charge'   =>  $delivery_charge,
                            'total_amount'      =>  $total_amount,
                            'billing_amount'    =>  $billing_amount,
                            'order_date'        =>  \Carbon\Carbon::now(),
                            'delivery_date'     =>  Carbon::createFromFormat('m/d/Y', $request->delivery_date),
                            'delivery_time'     =>  $request->delivery_time,
                            'comment'           =>  $request->delivery_comment,
                            'message'           =>  $product->message,
                            'created_at'        =>  \Carbon\Carbon::now(),
                            'updated_at'        =>  \Carbon\Carbon::now(),
                        ];
                    }
                    Order::insert($orderData);
                    return redirect($url);
                } else{
                    return redirect()->back();
                }
            } else{
                return redirect()->back();
            }
        }
    }

    // When Payment Success Then This Mwthod IS Called
    public function paymentSuccess(Request $request)
    {       
        // Store Transaction Details 
        $telrManager    =   new \TelrGateway\TelrManager();
        $transaction    =   $telrManager->handleTransactionResponse($request);

        //Initialization
        $total = $tax  = $vat = $delivery_charge = $subTotal[] = 0;

        //Queries
        $transaction    =   Transaction::where('cart_id',$request->cart_id)->firstOrFail();
        $orders         =   Order::select('id','product_id','color_id','quantity','vat','delivery_date','delivery_time','comment')->with(['product:id,slug,title,ar_title,sku,order_amount,image','color'])->where('cart_id',$request->cart_id)->get();
        $delivery_data  =   DeliveryCharge::select('charges')->where('en_city',$transaction->billing_city)->orWhere('ar_city',$transaction->billing_city)->where('is_active','y')->first();

        //Login User(Delete Cart Data)
        if( $request->user() ){    
            $products = Cart::where('user_id',Auth::id())->get();
            $products->each->delete();
        }
        else{
            //Guest User(Delete Cookies)
            $cookies = Cookie::get();
            $minutes  = -1;
            $products = $value = $cookie = null;

            foreach ($cookies as $key => $cookie) {    
                $length = config('utility.custom_length', 20);
                if(strlen($key) >= $length){
                    if($key != 'flowers_shop_session'){
                        Cookie::queue( Cookie::make($key, json_encode($value)), $minutes );             
                    }
                }
            }
        }

        //SubTotal && Delivery Charge
        foreach ($orders as $key => $order) {
            if($order->product != null){
                $subTotal[] =  $order->quantity * $order->product->order_amount;
            }
        }
        $subTotal           =   array_sum($subTotal);
        $delivery_charge    =   $delivery_data->charges;
        $vat                =   $order->vat;

        if($subTotal >= 0){
            $total =    $subTotal + $delivery_charge + ( ( $subTotal + $delivery_charge ) * $vat ) / 100;
            $tax   =    ( $subTotal + $delivery_charge ) * $vat / 100;
        }
           
        if($orders != null && !$orders->isEmpty()){

            $data['username']           = $transaction->billing_fname. ' ' .$transaction->billing_sname;
            $data['cart_id']            = $transaction->cart_id;
            $data['amount']             = $transaction->amount;
            $data['order_date']         = \Carbon\Carbon::now();
            $data['delivery_charge']    = $delivery_charge;
            $data['delivery_date']      = $order->delivery_date;
            $data['delivery_time']      = $order->delivery_time;
            $data['comment']            = $order->comment;
            $data['email']              = $transaction->billing_email;

            if($request->user()){
                $address    =   UserAddress::with(['country','city'])->where(['user_id' => Auth::id(),'is_default' => 'y'])->first();
          
                $data['billing_details']    = $transaction->billing_address_2;
                $data['delivery_details']   = $transaction->billing_address_1;
                $data['delivery_pincode']   = $address->pincode;
                $data['delivery_contact']   = $address->contact;
                $data['delivery_city']      = $address->city->getCity();
                $data['delivery_country']   = $address->country->getName();
            }else{
                $data['billing_details']    = $transaction->billing_address_1;
                $data['pincode']            = $transaction->billing_zip;
                $data['city']               = $transaction->billing_city;
                $data['country']            = $transaction->billing_country;
            }

            //Send Mail(Payment Success && Order Received)
            Mail::to($transaction->billing_email)->queue(new PaymentSuccess($data));
            Mail::to($transaction->billing_email)->queue(new OrderReceived($data));                                

            // $data = 'Flower Shop';
            // Mail::to($transaction->billing_email)->queue(new ThankYou($data));

            return view('frontend.pages.order-confirmation',compact('transaction','orders','subTotal','delivery_charge','tax','total'))->withTitle('GuestUser');;
        } else{
            return redirect()->back();
        }
    }

    //When Payment Cancel Then This Method Id Called
    public function paymentCancel(Request $request)
    {
        $telrManager    =   new \TelrGateway\TelrManager();
        $transaction    =   $telrManager->handleTransactionResponse($request);
        $orders         =   Order::where('cart_id',$request->cart_id)->get();

        //Delete Order Data
        if(!$orders->isEmpty()){
            $orders->each->delete();
        }

        //Send Payment Failure Mail
        $data['username'] = $transaction->billing_fname. ' ' .$transaction->billing_sname;
        Mail::to($transaction->billing_email)->queue(new PaymentFailure($data));     

        return redirect()->back();    
    }

    //When Payment Declined Then This Method Is Called
    public function paymentDeclined(Request $request)
    {
        $telrManager    =   new \TelrGateway\TelrManager();
        $transaction    =   $telrManager->handleTransactionResponse($request);
        $orders         =   Order::where('cart_id',$request->cart_id)->get();

        //Delete Order Data
        if(!$orders->isEmpty()){
            $orders->each->delete();
        }
        
        //Send Payment Failure MAIL
        $data['username'] = $transaction->billing_fname. ' ' .$transaction->billing_sname;
        Mail::to($transaction->billing_email)->queue(new PaymentFailure($data));    

        return redirect()->route('home');
    }
}


