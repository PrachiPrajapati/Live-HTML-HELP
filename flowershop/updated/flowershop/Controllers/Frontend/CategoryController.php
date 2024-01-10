<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\BoxTitle;
use App\Models\Shape;
use App\Models\Color;
use App\Models\Category;
use App\Models\ProductColor;
use App\Models\Favourite;

class CategoryController extends Controller
{
	// Show Products In Category Page, Apply Filters, Sort And Search
    public function getProducts(Request $request, $slug, $box_data = null, $shape_data = null)
    {
        $box = $shape = $shapes = $color = $price = $colors = $extra = $search = $categories = $breadcumb_category = null;
        $favourite_product = []; $minimum = 0; $ascDesc = "ASC";
        if($request->sort == "high"){ $ascDesc = "DESC"; }

        //Breadcumb Titles
        $category                   =   Category::select('id','slug','custom_id')->where('slug',$slug)->firstOrFail();
        $breadcumb_category_slug    =   $category->slug;
        $breadcumb_category         =   $category->getTitle();

        if(!$request->ajax()){
            //Shape Wise Products 
        	if($shape_data != null){
                $box 		=	BoxTitle::where('custom_id',$box_data)->firstOrFail();
        		$shape      =   Shape::select('id','custom_id')->where('custom_id',$shape_data)->firstOrFail();
        		$products 	= 	Product::select('id','custom_id','category_id','slug','title','ar_title','order_amount','image')->where(['category_id' => $category->id, 'box_id' => $box->id, 'shape_id' => $shape->id, 'is_active' => 'y'])->paginate(9);
        	}
        	//Box Wise Products
    		elseif($box_data != null){
                $box 		=	BoxTitle::where('custom_id',$box_data)->firstOrFail();
            	$products 	= 	Product::select('id','custom_id','category_id','slug','title','ar_title','order_amount','image')->where(['category_id' => $category->id, 'box_id' => $box->id, 'is_active' => 'y'])->paginate(9);
        	}
        	//Category Wise Products
        	else{
        		$products 	= 	Product::select('id','custom_id','category_id','slug','title','ar_title','order_amount','image')->where(['category_id' => $category->id, 'is_active' => 'y'])->paginate(9);
            }

            //DATA FOR FILTERS
            $shapes  			= 	Shape::select('id','custom_id','title','ar_title')->where('is_active','y')->get();
            $colors  			=	Color::select('id','title','ar_title','image')->where('is_active','y')->get();
            $categories  		=	Category::select('id','custom_id','title','ar_title')->where('is_active','y')->get();
            $product_prices		=	Product::where('is_active','y')->pluck('order_amount')->toArray();       
        }

        if( $request->user() ){
            $favourite_product = Favourite::where(['user_id' => Auth::id(), 'color_id' => null])->pluck('product_id')->toArray();
        }

        // SHAPE FILTERS
        if($request->has('shape_id') && $request->shape_id != null){
            $products = Product::select('id','custom_id','slug','title','ar_title','order_amount','image')->where(['shape_id' =>$request->shape_id, 'is_active'=> 'y']);
            $shape = Shape::select('id','custom_id')->where('id',$request->shape_id)->first();   
            
            if($request->shape_price != null){
                $price          =   $request->shape_price;
                $product_prices =   Product::where('is_active','y')->pluck('order_amount')->toArray();

                if(!empty($product_prices)){
                    $minimum    =   intval( array_sum($product_prices) / count($product_prices) );
                }
                if($minimum == $price){ $minimum    =   0; }

                $products = $products->whereBetween('order_amount',[$minimum,$price]);
            }

            if($request->sort != null){
                $extra = $request->sort;
                if($request->sort == "new"){
                    $products = $products->latest();
                }else{
                    $products = $products->orderby('order_amount',$ascDesc);    
                }
            }
            $products = $products->paginate(9);
        }

        // COLOR FILTER
        if($request->has('color_id') && $request->color_id != null){
            $product_ids = ProductColor::where('color_id',$request->color_id)->distinct('product_id')->pluck('product_id')->toArray();
            $products = Product::select('id','custom_id','slug','title','ar_title','order_amount','image')->whereIn('id',$product_ids)->where('is_active','y');

            $color = Color::select('id','title','ar_title','image')->where(['id' => $request->color_id,'is_active' => 'y'])->first();     
            if($request->color_shape_id != null && $request->color_shape_id != "null"){
                $shape = Shape::select('id','custom_id')->where('id',$request->color_shape_id)->first();   
            }

            if($request->sort != null){
                $extra = $request->sort;
                if($request->sort == "new"){
                    if($request->color_shape_id != null && $request->color_shape_id != "null"){
                        $products = $products->where('shape_id',$request->color_shape_id)->latest();
                    }else{
                        $products = $products->latest();
                    }
                }else{
                    if($request->color_shape_id != null && $request->color_shape_id != "null"){
                        $products = $products->where('shape_id',$request->color_shape_id)->orderby('order_amount',$ascDesc);
                    }else{
                        $products = $products->orderby('order_amount',$ascDesc);
                    }
                }
            }else{
                if($request->color_shape_id != null && $request->color_shape_id != "null"){
                    $products = $products->where('shape_id',$request->color_shape_id);
                }
            }
            $products = $products->paginate(9);
        }

        // CATEGORY FILTER
        if($request->has('category_id') && $request->category_id != null){
            $products = Product::select('id','custom_id','slug','title','ar_title','order_amount','image')->where(['category_id' => $request->category_id, 'is_active' => 'y']);
            $category = Category::select('id','slug','custom_id')->where('id',$request->category_id)->first();

            if($request->sort != null){
                $extra = $request->sort;
                if($request->sort == "new"){
                    $products = $products->latest();
                }else{ 
                    $products = $products->orderby('order_amount',$ascDesc);
                }
            }
            $products = $products->paginate(9);
        }

        // PRICE FILTER
        if($request->has('price') && $request->price != null){
            $price          =   $request->price;
            $product_prices =   Product::where('is_active','y')->pluck('order_amount')->toArray();
   
            if($product_prices != null && $product_prices != '[]'){
                $minimum    =   intval( array_sum($product_prices) / count($product_prices) );
            }
            if($minimum == $request->price){ $minimum    =   0; }

            //WHen Shape And Color Is Selected
            if($request->price_shape_id != null && $request->price_color_id != null && $request->price_shape_id != "null" && $request->price_color_id != "null"){
                $product_ids = ProductColor::where('color_id',$request->price_color_id)->distinct('product_id')->pluck('product_id')->toArray();
                $products = Product::select('id','custom_id','slug','title','ar_title','order_amount','image')->whereIn('id',$product_ids)->whereBetween('order_amount',[$minimum,$request->price])->where(['shape_id' => $request->price_shape_id,'is_active' => 'y']);

                $shape = Shape::select('id','custom_id')->where('id',$request->price_shape_id)->first();  
                $color = Color::select('id','title','ar_title','image')->where(['id' => $request->price_color_id,'is_active' => 'y'])->first();
            }
            //When Shape Is Selected
            elseif($request->price_shape_id != null && $request->price_shape_id != "null"){
                $products = Product::select('id','custom_id','slug','title','ar_title','order_amount','image')->whereBetween('order_amount',[$minimum,$request->price])->where(['shape_id' => $request->price_shape_id,'is_active' => 'y']);    
                $shape = Shape::select('id','custom_id')->where('id',$request->price_shape_id)->first();   
            }
            
            //When Color Selected
            elseif($request->price_color_id != null && $request->price_color_id != "null"){
                $product_ids = ProductColor::where('color_id',$request->price_color_id)->distinct('product_id')->pluck('product_id')->toArray();
                $products = Product::select('id','custom_id','slug','title','ar_title','order_amount','image')->whereIn('id',$product_ids)->whereBetween('order_amount',[$minimum,$request->price])->where('is_active','y');
                $color = Color::select('id','title','ar_title','image')->where(['id' => $request->price_color_id,'is_active' => 'y'])->first();
            }

            //WHEN ONLY PRICE IS SELECTED
            else{
                $products = Product::select('id','custom_id','slug','title','ar_title','order_amount','image')->whereBetween('order_amount',[$minimum,$request->price])->where('is_active','y');
                if($request->price_category_id != null && $request->price_category_id != 'null'){
                    $products = $products->where('category_id' ,$request->price_category_id);
                }
            }

            //IF SORTING APPLY THEN CHECK NEW, LOW, HIGH VALUES
            if($request->sort != null){
                $extra = $request->sort;
                if($request->sort == "new"){
                    $products = $products->latest();
                }
                else{
                    $products = $products->orderby('order_amount',$ascDesc);
                }
            }
            $products = $products->paginate(9);
        }

        // NEW, LOW, HIGH SORTING
        if($request->has('extra') && $request->extra != null){    

            if($request->extra == "new"){ $request['sort'] = "new"; }
            elseif($request->extra == "low"){ $request['sort'] = "low"; }
            elseif($request->extra == "high"){ $request['sort'] = "high"; }
            $extra = $request->sort;

            //CATEGORY WISE SORTING
            if($request->sort_category_id != null && $request->sort_category_id != "null"){
                $request['category_id']         =   $request['sort_category_id'];
            }
            //SHAPE WISE SORTING
            if($request->sort_shape_id != null && $request->sort_shape_id != "null"){
                $request['shape_id']            =   $request['sort_shape_id'];
                $request['category_id']         =   null;
            }
            //PRICE WISE SORTING
            if($request->sort_price != null && $request->sort_price != "null"){
                $request['price']               =   $request['sort_price'];
                $request['price_shape_id']      =   $request['sort_shape_id'];
                $request['price_color_id']      =   $request['sort_color_id'];
                $request['price_category_id']   =   $request['sort_category_id'];
                $request['shape_id'] = $request['category_id'] = $request['sort_color_id'] = null;
            }
            //COLOR WISE SORTING
            if($request->sort_color_id != null && $request->sort_color_id != "null"){
                $request['color_id']            =   $request->sort_color_id;
                $request['color_shape_id']      =   $request->sort_shape_id;
                $request['category_id'] = $request['shape_id'] = null;
            }
            //SEARCH WISE SORTING
            if($request->sort_search != null && $request->sort_search != "null"){
                $request['search'] = $request['sort_search'];
                $request['category_id'] = $request['shape_id'] = $request['color_id'] = $request['price'] = null;
            }

            $request['extra'] = $request['sort_shape_id'] = $request['sort_color_id'] = $request['sort_price'] = $request['sort_category_id'] = $request['sort_search'] = null;

            return $this->getProducts($request,$category->slug);
        }

        // SEARCH
        if($request->search != null && $request->search != ''){
            $search = $request->search;

            $products = Product::select('id','slug','title','ar_title','order_amount','image')->where('title', 'LIKE', '%' . $request->search . '%')->where('is_active','y')->orWhere('ar_title', '%' . $request->search . '%')->where('is_active','y');
            
            if($request->sort != null){
                $extra = $request->sort;
                if($request->sort == "new"){
                    $products = $products->latest();
                }else{
                    $products = $products->orderby('order_amount',$ascDesc);
                }
            }
            $products = $products->paginate(9);
        }

        if($request->ajax()){
            $Response['products']   =   view('frontend.pages.product-pagination', compact('products','favourite_product'))->render();
            $Response['success']    =   trans('messages.success',['entity' => 'products fetch']);
         
            return response()->json($Response,200); 
        }

        return view('frontend.pages.category',compact('products','box','shape','color','price','shapes','colors','extra','search','breadcumb_category_slug','breadcumb_category','categories','category','product_prices','favourite_product'));
    }

}
