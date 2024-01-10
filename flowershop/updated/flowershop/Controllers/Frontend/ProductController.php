<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Favourite;
use App\Models\Setting;
use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductRelated;
use App\Models\ProductAddon;
use App\Models\ProductColor;
use App\Models\Shape;
use App\Models\Color;
use App\Models\Category;
use App\Models\UserAddress;
use App\Models\DeliveryCharge;

class ProductController extends Controller
{
	  // Display Product in Single Product Page
    public function showProduct(Request $request, $slug)
    {
        $product = Product::with('category:id,slug,title,ar_title','relatedProducts.product:id,slug,title,ar_title,image,order_amount','addonProducts.product:id,custom_id,slug,title,ar_title,image,order_amount,minimum_qty','color.color:id,image')->where(['slug' => $slug, 'is_active' => 'y'])->firstOrFail();

        $product_colors = ProductColor::select('product_id','color_id')->with('color:id,image')->where('product_id',$product->id)->distinct()->get();
        $setting = Setting::select('en_fb_value','ar_fb_value','en_pintrest_value','ar_pintrest_value')->firstOrFail();
        $favourite_product = [];

        if($request->user()){
            $favourite_product = Favourite::where([ 'user_id' => Auth::id(), 'color_id' => null])->pluck('product_id')->toArray();
        }

        return view('frontend.pages.product-single',compact('product','product_colors','setting','favourite_product'));
    }
    
    // When Changing Product Qauntity
    public function changeProductQuantity(Request $request)
    {
      if( $request->user() ){
        $product = Cart::where(['user_id' => Auth::id(), 'product_id' => $request->product_id, 'custom_id' => $request->custom_id])->first(); 

        if ($product != null) {              
              $product->fill($request->all());
              $product->save();
              
              if($product->save()){
                  $products = Cart::with('product:id,order_amount')->where('user_id',Auth::id())->get();

                  if(!$products->isEmpty()){
                      $delivery_charge =  $sub_total_array[] = $total = 0;
                      $vat = $this->vat;
                    
                      $userAddress =  UserAddress::with('city:id,charges')->where(['user_id' => Auth::id(), 'is_default' => 'y'])->firstOrFail();

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
                      
                      $Response['header']           =   view('frontend.layouts.includes.header')->render();
                      $Response['subTotal']         =   "<td id='subTotal'>$$subTotal</td>";
                      $Response['vat']              =   "<td id='vat'>$vat %</td>";
                      $Response['total']            =   "<td id='total'>$$total</td>";   
                      $Response['delivery_charge']  =   "<td id='delivery_charge'>$$delivery_charge</td>";
                      $Response['success']          =   trans('messages.success',['entity' => 'product quantity changed']);
                  }
                  else{
                      $Response['fail'] = trans('messages.fail',['entity' => 'products']);

                  }
              }else{
                  $Response['fail'] = trans('messages.fail',['entity' => 'products']);
              }
          }else{
              $Response['fail'] = trans('messages.fail',['entity' => 'product']);
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

          if($user = $request->cookie($cookie_name)){
              if($user != null){
                  $data       = json_decode($user);
                  $minutes    = 1440;
                  $user       = [ 'custom_id' => $request->custom_id,'color_id' => $data->color_id, 'quantity' => $request->quantity, 'message' => $data->message ];
                  $array_json = json_encode($user);
                  
                  $Response   = new Response([
                      $Response['success'] = trans('messages.success',['entity' => 'product quantity changed']),
                  ]);

                  $Response->withCookie(cookie($cookie_name,$array_json,$minutes));
                  return $Response;
              }else{
                  return redirect()->route('home');
              }           
          }else{
                 return redirect()->route('home');
          }
      }
  }

  // Getting Product Colors (Product Single Page)
  public function getProductColors(Request $request)
  {
      if($request->has('product_id') && $request->has('color_id') )
      {
          $colors = ProductColor::where(['product_id' => $request->product_id, 'color_id' => $request->color_id])->get();
          $path   = "";

          if(!$colors->isEmpty()){  
              foreach ($colors as $key => $color) {
                  $path =  generateURL($color->image);

                  $color['showColors'] = "<li> <span class='product_color getColors' data-product_id='$color->product_id' data-color_id='$color->id'></span><img src='$path' alt='thumb'> </li>";

                  $color['productMainUl'] = "<li class='img-zoom'><a href='$path' data-image='$path' data-fancybox><img src='$path' alt='product'></a></li>";
              }
          }
          $colors = $colors->toArray();

          $Response['colors']  = json_encode($colors);
          $Response['success'] = trans('messages.success',['entity' => 'product colors fetch']);
      } else{
          $Response['fail'] = trans('messages.fail',['entity' => 'product colors']);
      }

      return response()->json($Response,200);
  }


  // Search, Filter And Sorting
  public function search(Request $request)
  { 
      $products = $shape = $color = $price = $category = $extra = null; $favourite_product = []; $ascDesc = "ASC"; $minimum = 0;
      if($request->sort == "high"){ $ascDesc = "DESC"; }

      if($request->search != null){
          $products = Product::select('id','custom_id','slug','title','ar_title','order_amount','image')->Where('title' , 'LIKE' , '%' . $request->search . '%')->where('is_active','y')->orWhere('ar_title', 'LIKE', '%' . $request->search . '%')->where('is_active','y');
      }else{
          $products = Product::select('id','custom_id','slug','title','ar_title','order_amount','image')->where('is_active','y');
      }

      // WHEN SORTING APPLY
      if($request->sort != null){
          $extra = $request->sort;
          if($request->sort == "new"){
              $products = $products->latest();
          }else{
              $products = $products->orderby('order_amount',$ascDesc);
          }
      }
      $products = $products->paginate(9);

      //WHEN PAGE REFRESH NOT FOR AJAX CALL
      if(!$request->ajax()){
          $search_keyword   =   $request->search;
          $shapes           =   Shape::select('id','title','ar_title')->where('is_active','y')->get();
          $colors           =   Color::select('id','title','ar_title','image')->where('is_active','y')->get();
          $categories       =   Category::select('id','title','ar_title')->where('is_active','y')->get();
          $product_prices   =   Product::where('is_active','y')->pluck('order_amount')->toArray();   
      }

      if($request->user()){
          $favourite_product = Favourite::where([ 'user_id' => Auth::id(), 'color_id' => null])->pluck('product_id')->toArray();
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

          if(!empty($product_prices)){
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
              $request['search']              =   $request['sort_search'];
              $request['category_id'] = $request['shape_id'] = $request['color_id'] = $request['price'] = null;
          }

          $request['extra'] = $request['sort_shape_id'] = $request['sort_color_id'] = $request['sort_price'] = $request['sort_category_id'] = $request['sort_search'] = null;

          return $this->search($request);
      }

      if($request->ajax()){
          $Response['products']   =   view('frontend.pages.product-pagination', compact('products','favourite_product'))->render();
          $Response['success']    =   trans('messages.success',['entity' => 'products fetch']);
       
          return response()->json($Response,200); 
      }

      return view('frontend.pages.search',compact('search_keyword','shape','color','price','category','extra','products','shapes','colors','categories','product_prices','favourite_product'));  
  }

}
