<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Favourite;
use App\Models\Setting;
use App\Models\Cart;


class WishlistController extends Controller
{   
    // Display Wishlist Products
    public function showFavouriteList(Request $request)
    {
    	$products = Favourite::with(['product:id,slug,title,ar_title,order_amount,total_stock,minimum_qty,image','color:id,image'])->where('user_id', Auth::id())->paginate(9,['*'],'products');
    	
    	return view('frontend.pages.favourites',compact('products'));
    }


    // Check Product Color Is Added In Wishlist Or Not
    public function checkFavourite(Request $request)
    {
    	$favourite = Favourite::where(['user_id' => Auth::id(), 'product_id' => $request->product_id, 'color_id' => $request->color_id])->first();

    	if($favourite != null){
            $Response['success'] = trans('messages.success',['entity' => 'product fetch']);
    	} else{
            $Response['fail'] = trans('messages.fail',['entity' => 'product']);
    	}
    	return response()->json($Response,200);
    }


    //Product Add to Wishlist(Ajax)
    public function addToWishlist(Request $request)
    {
		$custom_id = getUniqueString('favourites');

  		if($request->color_id == "undefined"){
  			$request['color_id'] = null;
  		}

    	$data = [
    		'custom_id'		=>  $custom_id,	
    		'user_id'		=>	Auth::id(),
    		'product_id'	=>  $request->product_id,
    		'color_id'		=>  $request->color_id,
    	];

    	if($data != null){
    		$favourite = Favourite::create($data);
        	$Response['success'] 		= trans('messages.success',['entity' => 'product add to wishlist']);
    		$Response['favourite_icon'] = '<a href="javascript:;" class="add-to-wishlist active" id="removeFromWishlist" data-product_id="{{ $product->id }}" data-custom_id="{{ $product->custom_id }}" ><img src="{{ asset("frontend/images/heart-sprite.svg") }}" alt="wishlist"></a>';
    	}
    	else{
        	$Response['fail'] = trans('messages.fail',['entity' => 'product']);
    	}
	    
    	return response()->json($Response,200);
    }

    //Remove From Wishlist
    public function removeFromWishlist(Request $request)
    {
		$product = Favourite::where(['user_id' => Auth::id(),'product_id' => $request->product_id,'color_id' => $request->color_id])->get();
    	
    	if($product != null){
    		$count   = Favourite::where('user_id',Auth::id())->count();

    		if($count <= 1){
    			$Response['noProduct'] = '<p id="empty">No Favourite Product Selected</p>';
    		}
    		$product->each->delete();
        	$Response['success'] 		= trans('messages.success',['entity' => 'product remove from wishlist']);
    		$Response['favourite_icon'] = '<a href="javascript:;" class="add-to-wishlist" id="addToWishlist" data-product_id="{{ $product["id"] }}"><img src="{{ asset("frontend/images/heart-sprite.svg") }}" alt="wishlist"></a>';
			$Response['header']         = view('frontend.layouts.includes.header')->render();  
    	}
    	else{
        	$Response['fail'] = trans('messages.fail',['entity' => 'product']);
    	}
	
	    return response()->json($Response,200);
    }


    //Add All Products TO Cart(From Favourite Page)
    public function addAllToCart()
    {
    	$products = Favourite::with('product')->where('user_id',Auth::id())->get();

    	if(!$products->isEmpty()){
 	
    		foreach ($products as $key => $data) {
    			if($data->product != null)
    			{
			    	Cart::create([
			    		'custom_id'		=>	getUniqueString('carts'),
			    		'user_id'		=>	Auth::id(),
			    		'product_id'	=>	$data->product->id,
			    		'color_id'		=>  $data->color_id,
			    		'quantity'		=>	$data->product->minimum_qty,
			    	]);	
				}
			}
			$products->each->delete();
			return redirect()->route('cart');
    	}
    	else{
    		return redirect()->route('favourites');
    	}
    }
}
