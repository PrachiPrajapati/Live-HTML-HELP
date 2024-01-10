<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Favourite;
use App\Models\Setting;
use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\UserAddress;
use Cookie;

class CartController extends Controller
{
    // Display Cart Products
	public function showCart(Request $request)
	{		
	    $vat = $this->vat;
		$subTotal = $total = $delivery_charge = 0;
		$products = $related_products = null;
		$no_products = $product_availble = false;
		$sub_total_array = $category_ids = $custom_ids = [];

		if( $request->user() ){
			$products   = Cart::with(['product:id,custom_id,category_id,slug,title,ar_title,sku,total_stock,minimum_qty,order_amount,image','color'])->where('user_id',Auth::id())->orderby('product_id')->get();

			if($products != null && !$products->isEmpty()){
				//RELATED PRODUCTS
				foreach ($products as $key => $data) {
					if($data->product != null){
						$category_ids[] 	= 	$data->product->category_id;
						$custom_ids[]   	= 	$data->product->custom_id;
						$sub_total_array[] 	= 	$data->product->order_amount * $data->quantity;
					}	
				}

				if($category_ids){
					$category[] = array_unique($category_ids);

					$related_products = Product::select('id','custom_id','slug','title','ar_title','minimum_qty','order_amount','image')->where(['category_id' => $category, 'is_active' => 'y'])->whereNotIn('custom_id',$custom_ids)->limit(3)->get();	
				}		

				$subTotal = array_sum($sub_total_array);
				$userAddress =  UserAddress::with('city:id,charges')->where(['user_id' => Auth::id(), 'is_default' => 'y'])->firstOrFail();
				if($userAddress->city != null){
                    $delivery_charge = $userAddress->city->charges;
                }

	            $total = $subTotal + $delivery_charge + ( ( $subTotal + $delivery_charge ) * $vat ) / 100;
			}	

			return view('frontend.pages.cart',compact('products','subTotal','related_products','vat','total','delivery_charge'));
		}
		else{
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
						$cookie    						=	json_decode($cookie);
						if($cookie != null){
							$products[$key]					=   $product;
							$products[$key]['color_id'] 	= 	$cookie->color_id;
							$products[$key]['quantity'] 	= 	$cookie->quantity;
						}
					}
				}
			}

			if(!empty($products)){

				foreach ($products as $key => $data) {
					$sub_total_array[] = $data->order_amount * $data->quantity;
					
					//Replace New Color Image With Old Image
					if($data->color_id != null){
						$product_color = ProductColor::where('id',$data->color_id)->first();
						if($product_color){
							$products[$key]['image'] = $product_color->image;
						}
					}
					$category_ids[] = $data->category_id;
					$custom_ids[]   = $data->custom_id;
				}

				$subTotal 			= 	array_sum($sub_total_array);
				$category[] 		= 	array_unique($category_ids);
				$total 				= 	$subTotal + ( $subTotal * $vat ) / 100;
				$related_products 	= 	Product::select('id','custom_id','slug','title','ar_title','minimum_qty','order_amount','image')
										->where(['category_id' => $category, 'is_active' => 'y'])
										->whereNotIn('custom_id',$custom_ids)->get();		
			} 

			return view('frontend.pages.cart',compact('products','subTotal','related_products','vat','total','delivery_charge'));
		}
	}

 	
 	// Add Product Into Cart
    public function addToCart(Request $request)
    {
    	if($request->color_id == 'undefined'){
    		$request['color_id'] = null;
		}

    	if( $request->user() ){

	    	if($request->ajax()){

	    		//WHEN ADD PRODUCT FROM WISHLIST(FAVOURITE)	  		
		  		$request['custom_id']	= 	getUniqueString('carts');
	        	$request['user_id']  	= 	Auth::id();
	        
	        	$product   	= 	Cart::create($request->all());
	        	$favourite 	= 	Favourite::where(['user_id'  => Auth::id(), 'product_id' => $request->product_id ])->first();
	 			$favourite->delete();

	        	if($product->save()){
                	$Response['success'] = trans('messages.success',['entity' => 'product added']);
					$Response['header']  = view('frontend.layouts.includes.header')->render();
	        	}
	        	else{
                	$Response['fail'] = trans('messages.fail',['entity' => 'product']);
	            }
	            return response()->json($Response,200);
	        }	        
	    	else{
	        	//WHEN SINGLE PRODUCT PAGE FORM SUBMIT	
	    		$product = Product::where(['custom_id' => $request->custom_id, 'is_active' => 'y'])->first();
	    		if($product){
	    			Cart::create([
			    		'custom_id'		=>	getUniqueString('carts'),
			    		'user_id'		=>	Auth::id(),
			    		'product_id'	=>	$product->id,
			    		'color_id'		=>	$request->color_id,
			    		'quantity'		=>	$request->quantity,
			    	]);
		    	} 
		    	else{
		    		return redirect()->back();
    			}
    		}
		    return redirect()->route('cart');
    	}else{
    		$cookie_name = $request->custom_id;

    		if($request->color_id){
    			$color = ProductColor::select('custom_id')->where('id',$request->color_id)->first();
    			if($color){
    				$cookie_name = $request->custom_id.$color->custom_id;
    			}
    		}
    		$minutes    = 1440;
    		$user 		= [ 'custom_id' => $request->custom_id,'color_id' => $request->color_id, 'quantity' => $request->quantity, 'message' => ''];
			$Response   = new Response([
                $Response['success'] = trans('messages.success',['entity' => 'product added into cart']),
				$Response['header']  = view('frontend.layouts.includes.header')->render(),
			]);

			//Add Data In Cookie
	   		Cookie::queue( Cookie::make($cookie_name, json_encode($user)), $minutes );				            

		    return redirect()->route('cart');
	    }
    }

    //Remove Product From Cart
    public function removeFromCart(Request $request)
    {
    	if( $request->user() ){
        	$product = Cart::where(['user_id' => Auth::id(), 'product_id' => $request->product_id, 'custom_id' => $request->custom_id])->first();

	    	if($product){
	    		$product->delete();
	    		$products   = 	Cart::with('product:id,order_amount')->where('user_id',Auth::id())->orderby('product_id')->get();
	    		$count 		= 	$products->count();
                $vat        = 	$this->vat;
	  			$subTotal[] = 	0; 
	  			$sub_total_array = [];

				if($count > 1){
					foreach ($products as $key => $data) {	
						if($data->product != null){
							$sub_total_array[] = $data->product->order_amount * $data->quantity;
						}
					}
					$subTotal = array_sum($sub_total_array);

                    $userAddress =  UserAddress::with('city:id,charges')->where(['user_id' => Auth::id(), 'is_default' => 'y'])->firstOrFail();
                      
                    if($userAddress->city != null){
                      	$delivery_charge = $userAddress->city->charges;
                  	}

                  	$total = $subTotal + $delivery_charge + ( ( $subTotal + $delivery_charge ) * $vat ) / 100;
                  				
					$Response['header'] 	 		=	view('frontend.layouts.includes.header')->render();
	        		$Response['subTotal']    		= 	"<td id='subTotal'>$$subTotal</td>";
	        		$Response['vat']         		= 	"<td id='vat'>$vat %</td>";
	    			$Response['total']       		= 	"<td id='total'>$$total</td>";	
                    $Response['delivery_charge']	=   "<td id='delivery_charge'>$$delivery_charge</td>";
		   			$Response['success'] 			= 	trans('messages.success',['entity' => 'product removed']);

				}
				else{
					$Response['header'] 	= 	view('frontend.layouts.includes.header')->render();
	   				$Response['cartEmpty']	= 	trans('messages.empty',['entity' => 'cart']);
                	$Response['success'] 	= 	trans('messages.success',['entity' => 'product removed']);
				}
	    	}
	    	else{
		    	$Response['fail'] = "<span id='product_error' class='error-help'>Product Not Remove</span>";
	    	}
	    	return response()->json($Response,200);
    	}
    	else{
    		$cookie_name = $request->custom_id;

    		if($request->color_id){
    			$color = ProductColor::select('custom_id')->where('id',$request->color_id)->first();
    			if($color){
    				$cookie_name = $request->custom_id.$color->custom_id;
    			}
    		}

    		$minutes  = -1;
			$Response = new Response([
                $Response['success'] 	= 	trans('messages.success',['entity' => 'product remove from cart']),
				$Response['header']  	= 	view('frontend.layouts.includes.header')->render(),
			]);
	   		$Response->withCookie(cookie($cookie_name,$request->custom_id,$minutes));
		    return $Response;
    	}
    }
    

    //Add Product To Cart (From Cart Page)
    public function addToCartSingleProduct(Request $request)
    {
    	if( $request->user() ){
	    	if($request->ajax()){
	        	$product = Product::where(['custom_id' => $request->custom_id, 'is_active' => 'y'])->first();

	        	if($product){ 		
		        	$cart = Cart::create( [
		    	    	'custom_id'	=>	getUniqueString('carts'),
		    	    	'user_id'	=>	Auth::id(),
		    	    	'product_id'=>	$product->id,
		    	    	'color_id'	=>	null,
		    	    	'quantity'	=>	$request->quantity,	
		    	    ]);
		        	
		        	if($cart->save()){
                		$Response['success'] = trans('messages.success',['entity' => 'product added']);
						$Response['header']  = view('frontend.layouts.includes.header')->render();
		        	}
	        	}
	        	else{
                	$Response['fail'] = trans('messages.fail',['entity' => 'product']);
	            }
	            return response()->json($Response,200);
	        }
	    }else{
	    	$minutes  	= 1440;
	    	$user 		= [ 'custom_id' => $request->custom_id,'color_id' => null, 'quantity' => $request->quantity, 'message' => ''];
			$array_json = json_encode($user);
			
			$Response 	= new Response([
                $Response['success'] 	= 	trans('messages.success',['entity' => 'product added into cart']),
				$Response['header']   	= 	view('frontend.layouts.includes.header')->render(),
	    	]);

		   	$Response->withCookie(cookie($request->custom_id,$array_json,$minutes));
		    return $Response;
	    }
    }


    //Add Combo Product From Single Product Page
    public function addToCartMultipleProduct(Request $request)
    {
    	$products  = $request->product_id;
    	$quantity  = $request->quantity;
    	$custom_id = $request->custom_id;

    	if($products != null){
			//Login User
			if( $request->user() ){
				foreach ($products as $key => $product) {
    				$cart = Cart::create([
	    					'custom_id'		=>	getUniqueString('carts'),
	    					'user_id'		=>	Auth::id(),
	    					'product_id'	=>  $product,
	    					'color_id'		=>	null,
	    					'quantity'		=>	$quantity[$key],
	    				]);
    			}
    			if($cart->save()){
					return redirect(route('cart'));
				}
				else{
	    			return redirect()->back();
				}
    		}
	    	
	    	//Guest User
	    	else{
	    		if($custom_id != null){
		    		$minutes = 1440;

			    	foreach ($products as $key => $product) {	
			            $value['custom_id']     =   $custom_id[$key];
			            $value['color_id']		=	null;
			        	$value['quantity']      =   $quantity[$key];
			        	$value['message']       =   '';

				        // Add details to cookie
			            Cookie::queue( Cookie::make($custom_id[$key], json_encode($value)), $minutes );				            
			       }
			       return redirect(route('cart'))->withTitle('GuestUser');
				}else{
    				return redirect()->back();
				}
	    	}
    	}else{
    		return redirect()->back();
    	}
    }

}
