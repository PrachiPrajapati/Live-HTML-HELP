<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\UserAddressRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\UserAddress;
use App\Models\Setting;
use App\Models\Cart;
use App\Models\DeliveryCharge;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\Country;
use App\Models\SubscriptionDetail;
use NZTim\Mailchimp\Mailchimp;

class UserDetailsController extends Controller
{
    //SAVE DELIVERY ADDRESS
    public function userAddress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name'    =>  'required|max:255',
            'last_name'     =>  'required|max:255',
            'city'          =>  'required|max:255',
            'emirate'       =>  'required|max:255',
            'pincode'       =>  'required|numeric|digits_between:6,10',
            'address'       =>  'required|max:500',
            'contact'       =>  'required|numeric|digits_between:8,16',
        ]);

        if ($validator->fails()) {
            $Response['serverError'] = $validator->messages();
        }else{
            $count = 0; $is_default = 'n';
            $count = UserAddress::where('user_id',Auth::id())->count();
            if($count == 0){
                $is_default = 'y';
            }

            $address = UserAddress::updateOrCreate([
                    'user_id'       => Auth::user()->id,
                    'first_name'    => $request->first_name,
                    'last_name'     => $request->last_name,
                    'country_id'    => $request->emirate,
                    'city_id'       => $request->city,
                    'pincode'       => $request->pincode,
                    'address'       => $request->address,
                    'contact'       => $request->contact,
                    'is_default'    => $is_default,
                ]);

            $Response['address'] = $address;
            $Response['success'] = trans('messages.success',['entity' => 'address save']);
        }
        return response()->json($Response,200);
    }

    // GETTING CITY DATA AS COUNTRY WISE
    public function getCountryWiseCity(Request $request)
    {
        $cities = DeliveryCharge::where(['country_id' => $request->country_id, 'is_active' => 'y'])->get();

        if(!$cities->isEmpty()){
            foreach ($cities as $key => $city) {
                $city->city_name = $city->getCity();
            }
            $cities = $cities->toArray();

            $Response['success'] = trans('messages.success',['entity' => 'city data fetch']);
            $Response['cities'] = json_encode($cities);
        } else{
            $Response['fail'] = trans('messages.fail',['entity' => 'city data']);
        }

        return response($Response,200);
    }

    //CHECKOUT PAGE(LOGIN USER)
    public function changeDefaultAddress(Request $request)
    { 
        UserAddress::where(['user_id' => Auth::id(), 'is_default' => 'y'])->update(['is_default' => 'n']);

        $userAddress =  UserAddress::with('city:id,charges')->where(['user_id' => Auth::id(), 'id' => $request->id])->firstOrFail();
        $userAddress->fill(['is_default' => 'y']);

        if($userAddress->save()){
            $products = Cart::with('product:id,order_amount')->where('user_id',Auth::id())->get();

            if(!$products->isEmpty()){
                $delivery_charge = $sub_total_array[] = $total = 0;
                $vat = $this->vat;
            
                foreach ($products as $key => $data) {
                    if($data->product != null){
                        $sub_total_array[] = $data->product->order_amount * $data->quantity;
                    } else{
                        $data->delete();
                    }
                }
                $subTotal   =   array_sum($sub_total_array);
                
                if($userAddress->city != null){
                    $delivery_charge = $userAddress->city->charges;
                }

                if($subTotal != 0){
                    $total = $subTotal + $delivery_charge + ( ( $subTotal + $delivery_charge ) * $vat ) / 100;
                }
                
                $Response['success']        = trans('messages.success',['entity' => 'address changed']);
                $Response['subTotal']       = "<td id='subTotal'>$$subTotal</td>";
                $Response['vat']            = "<td id='vat'>$vat %</td>";
                $Response['total']          = "<td id='total'>$$total</td>";
                $Response['delivery_charge']= "<td id='delivery_charge'>$$delivery_charge</td>";
            }
            else{ 
                $Response['fail'] = trans('messages.fail',['entity' => 'products']);
            }
        } else{
            $Response['fail'] = trans('messages.fail',['entity' => 'address']);
        }
        return response($Response,200);
    }


    // Subscribe User
    public function subscribeUser(Request $request)
    {
        $request['campaign_id'] = rand(111111,999999);
        $subscribeDetails = SubscriptionDetail::create($request->all());

        if($subscribeDetails->save()){
           Session::flash('message', $request->email. ' subscribed successfully.'); 
           return redirect()->back();
        } else{
           Session::flash('message', 'unable to subscribe.');  
           return redirect()->back(); 
        }

        // $details['id'] = env('MAIL_CHIMP_LIST_ID', '');
      
        // try {
        //     $campaing = new Mailchimp(env('MC_KEY'));

        //     $details = $campaing->subscribe(env('MAIL_CHIMP_LIST_ID', ''), $request->email, $merge = ['FNAME' => ''], $confirm = false);
            
        //     SubscriptionDetail::updateOrCreate([
        //         'email' => $request->email,
        //     ], [
        //         'campaign_id' => $details['id'],
        //     ]);

        //     //flash($request->email . ' subscribed successfully')->success();
        //     Session::flash('message', $request->email. ' subscribed successfully.'); 
        // } catch (Exception $exception) {
        //     //dd($exception);
        //     flash('Unable to subscribe to the newsletter. Please try again later.')->error();
        //     $error['message'] = $exception->getMessage();
        //     $error['exception'] = $exception;
        //     $orderLog = new Logger('NewsLatterSubscribe');
        //     $orderLog->pushHandler(new StreamHandler(storage_path('logs/NewsLatterSubscribe.log')), Logger::INFO);
        //     $orderLog->info('NewsLatterSubscribe', $error);
        // } finally {
        //     //Session::flash('message', $request->email. ' subscribed successfully.'); 
        //     return redirect()->back();
        // }
    }
}
