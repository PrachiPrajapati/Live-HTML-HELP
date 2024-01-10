<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\Admin\ProductRequest;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\BoxTitle;
use App\Models\Shape;
use App\Models\Category;
use App\Models\Color;
use App\Models\SubCategory;
use App\Models\TempProduct;
use App\Models\ProductColor;
use App\Models\ProductRelated;
use App\Models\ProductAddon;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $count = product::count();
        return view('admin.pages.products.list',compact('count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::select('id','custom_id','title','ar_title')->where('is_active','y')->get();
        $colors     = Color::where('is_active','y')->get();
        $products   = Product::select('id','custom_id','title','ar_title')->where('is_active','y')->get();
        return view('admin.pages.products.create',compact('categories','colors','products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  
        //When Product Main Image Store
        if( $request->has('filepond_request') ){
            $image_path = null;
            $Response   = "Something Went Wrong";

            if($request->en_title_filepond != null && $request->ar_title_filepond != null){

                if( $request->has('filepond') ) {
                    $image      = $request->file('filepond');
                    $image_path = $image->store('temp/product/images');
                }

                if( $request->has('image') ) {
                    $image      = $request->file('image');
                    $image_path = $image->store('temp/product/images');
                }
 
                if($image_path != null){
                    $data = [
                        'en_title' =>   $request->en_title_filepond,
                        'ar_title' =>   $request->ar_title_filepond,
                        'image'    =>   $image_path,
                    ];

                    $temp_product = TempProduct::create($data);
                    
                    if($temp_product->save()){
                        $Response = "image added into temp products table";
                    }
                } else{
                    dd($error);
                }
            }else{
                dd($error);
            }
        } 

        //When Product Color Images Store
        if( $request->has('filepond_color_images') ){
            $count      =   0;
            $image_path =   null;
            $Response   =   "Something Went Wrong";

            if($request->color_id != null && $request->en_title_filepond != null && $request->ar_title_filepond != null){ 
                if($request->count != 0){    
                    $count = rtrim($request->count,0);
                }
                if($request->has('count_perfect')){
                    $count = $request->count_perfect;
                }

                if( $request->has('color_image') ) {
                    $image      = $request->file('color_image')[$count];
                    $image_path = $image->store('temp/product/image_colors');
                } 

                if( $request->has('filepond') ) {
                    $image      = $request->file('filepond');
                    $image_path = $image->store('temp/product/image_colors');
                }
                // if( $request->has('image') ) {
                //     $image      = $request->file('image');
                //     $image_path = $image->store('temp/product/image_colors');
                // }
 
                if($image_path != null){
                    $data = [
                        'en_title' =>   $request->en_title_filepond,
                        'ar_title' =>   $request->ar_title_filepond,
                        'color_id' =>   $request->color_id,
                        'image'    =>   $image_path,
                    ];

                    $temp_product = TempProduct::create($data);
                    
                    if($temp_product->save()){
                        $Response = "multiple images added into temp products table";
                    }else{
                        $Response = "multiple images upload fail";
                    }
                } else{
                    dd($error);
                }
            }else{
                dd($error);
            }
        }
        
        //When Form Submit
        else {              
            $request->validate([
                'en_title'          =>  'required|max:255',
                'ar_title'          =>  'required|max:255',
                'en_description'    =>  'required',
                'ar_description'    =>  'required',
                'category'          =>  'required|numeric',
                'box'               =>  'required',
                'shape'             =>  'required',
                'sku'               =>  'required',
                'list_price'        =>  'required|numeric',
                'your_price'        =>  'required|numeric',
                'weight'            =>  'required|max:255',
                'total_stock'       =>  'required|numeric',
                'minimum_qty'       =>  'required|numeric',
                'order_amount'      =>  'required|numeric',
            ]);
         
            $flag               =   0;
            $en_title           =   $request->en_title;
            $ar_title           =   $request->ar_title;
            $color_ids          =   $request->color_title;
            $related_products   =   $request->related_products;
            $addons_products    =   $request->addons_products;

            $main_image = TempProduct::where([ 'en_title' => $en_title, 'ar_title' => $ar_title, 'color_id' => null])->first();

            if($main_image){
                
                $slug  = str_slug($request->en_title);
                $count = Product::withTrashed()->where('slug', "like", "%{$slug}%")->count();

                $request['slug'] = $slug;
                if( $count != 0 ) {
                    $request['slug'] = $slug . '-' . $count;
                }

                $image          =    $main_image['image'];
                $explode        =    explode('/', $image);
                $new_image      =    $explode[3];

                $request['custom_id']       = getUniqueString('products');
                $request['title']           = $request->en_title;
                $request['category_id']     = $request->category;  
                $request['box_id']          = $request->box;
                $request['shape_id']        = $request->shape;

                if(Storage::exists($image)){
                    Storage::move($image,'/product/images/'.$new_image);
                    $image_path         = "/product/images/".$new_image; 
                    $request['image']   = $image_path;
                } else{
                    $request['image']   = null; 
                } 

                $product = Product::create($request->all());
                $product->save();
                $flag = 1;

                $product = Product::where('custom_id',$request['custom_id'])->first();

                if($product){
                    if( $color_ids != null ){
                        foreach ($color_ids as $key => $color_id) {
                            
                            $temp_products =  TempProduct::where(['en_title' => $request->en_title, 'ar_title' => $request->ar_title, 'color_id' => $color_id])->get();

                            if(!$temp_products->isEmpty()){
                                foreach ($temp_products as $key => $temp_product) {

                                    if($temp_product != null && $product != null){
                                        $custom_id      =   getUniqueString('product_colors');
                                        $product_id     =   $product['id'];
                                        $color_id       =   $color_id;
                                        $image          =   $temp_product['image'];
                                        $explode        =   explode('/', $image);
                                        $new_image      =   $explode[3];

                                        if(Storage::exists($image)){
                                            Storage::move($image,'/product/image_colors/'.$new_image);
                                            $image_path = "/product/image_colors/".$new_image;

                                            $data = [
                                                'custom_id'     =>  $custom_id,
                                                'product_id'    =>  $product_id,
                                                'color_id'      =>  $color_id,
                                                'image'         =>  $image_path,
                                            ];   

                                            $product_colors = ProductColor::create($data);
                                            $product_colors->save();
                                            $flag = 1;
                                        } 
                                    }
                                }
                            }
                        }
                    }

                    if($related_products != null){
                        $data = [];
                        foreach ($related_products as $key => $related_product) {
                            $data[] = [
                                'custom_id'             =>   getUniqueString('product_related'),
                                'product_id'            =>   $product['id'],
                                'related_product_id'    =>   $related_product,
                                'created_at'            =>  \Carbon\Carbon::now(),
                                'updated_at'            =>  \Carbon\Carbon::now(),
                            ];
                        }
                        $related_data = ProductRelated::insert($data);
                        $flag = 1;
                    }

                    if($addons_products != null){
                        $data = [];
                        foreach ($addons_products as $key => $addons_product) {
                            $data[] = [
                                'custom_id'             =>   getUniqueString('product_addons'),
                                'product_id'            =>   $product['id'],
                                'addons_product_id'     =>   $addons_product,
                                'created_at'            =>  \Carbon\Carbon::now(),
                                'updated_at'            =>  \Carbon\Carbon::now(),
                            ];
                        }
                        $addon_data = ProductAddon::insert($data);
                        $flag = 1;
                    }
                }
            }

            //Delete Temparally Files From DB & Storage
            TempProduct::query()->delete();
            Storage::delete(Storage::allFiles('temp/product/images'));
            Storage::delete(Storage::allFiles('temp/product/image_colors'));

            if($flag == 1){
                flash('Product details added successfully')->success();
            }else{
                flash('Unable to add product details. Try again later')->error();
            }
            return redirect(route('admin.product.index'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($custom_id)
    {
        $product  = Product::with(['category','box','shape','relatedProducts','color'])->where('custom_id',$custom_id)->first();

        if($product){
            $products           = Product::where('is_active','y')->orderby('id','desc')->get();
            $colors             = Color::all();
            $related_products   = $product->relatedProducts;
            $product_related    = $product_colors   = null;

            //RELATED PRODUCTS
            if($related_products != "[]"){
                foreach ($related_products as $key => $related) {
                    $related_product_ids[] = $related->related_product_id;
                }

                foreach ($products as $key => $related_data) {
                    if(in_array($related_data->id, $related_product_ids)){
                        $product_related[] = $related_data;
                    }
                }
            }

            //COLOR DETAILS
            if($product->color != "[]"){
                foreach ($product->color as $key => $color_data) {
                    $color_ids[] = $color_data->color_id;
                }

                if($color_ids != null){
                    foreach ($colors as $key => $color) {
                        if(in_array($color->id, $color_ids)){
                            $product_colors[] = $color;
                        }
                    }
                }
            }

            return view('admin.pages.products.view',compact('product','products','product_related','product_colors'));
        } else{
            return redirect(route('admin.product.index'));
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
        $no_of_colors       = 0;
        $product_related    = null;
        $product_addons     = null;
        $product            = Product::with(['color','relatedProducts','addonProducts'])->where('custom_id',$custom_id)->first();

        if($product){
            $box                = BoxTitle::where('id',$product['box_id'])->first();      
            $shape              = Shape::where('id',$product['shape_id'])->first();
            $product_colors     = ProductColor::distinct()->select('color_id')->where('product_id',$product['id'])->get();
            $product_images     = ProductColor::distinct()->select('color_id','image')->where('product_id',$product['id'])->get();
            $related_products   = $product->relatedProducts;
            $addons_products    = $product->addonProducts;
            $no_of_colors       = count($product_colors);

            $categories = Category::where('is_active','y')->get();
            $colors     = Color::where('is_active','y')->get();
            $products   = Product::where('is_active','y')->whereNotIn('custom_id',[$custom_id])->get();

            //RELATED PRODUCTS
            if($related_products != "[]"){
                foreach ($related_products as $key => $related) {
                    $related_product_ids[] = $related->related_product_id;
                }

                foreach ($products as $key => $related_data) {
                    if(in_array($related_data->id, $related_product_ids)) {
                        $product_related[]                  = $related_data;
                        $product_related[$key]['select_related']  = true;
                    } else{
                        $product_related[] = $related_data;
                    }
                }
            }

            //ADD-ONS PRODUCTS
            if($addons_products != "[]"){
                foreach ($addons_products as $key => $addons) {
                    $addons_product_ids[] = $addons->addons_product_id;
                }

                foreach ($products as $key => $addons_data) {
                    if(in_array($addons_data->id, $addons_product_ids)) {
                        $product_addons[]                   = $addons_data;
                        $product_addons[$key]['select_addons']     = true;
                    } else{
                        $product_addons[] = $addons_data;
                    }
                }
            }

            return view('admin.pages.products.edit',compact('product','box','shape','product_colors','product_images','product_related','product_addons','no_of_colors','categories','colors','products'));
        } else{  
           return redirect()->route('admin.product.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $custom_id)
    {
        $product = Product::where('custom_id',$custom_id)->first();
        $product_main = $product;

        if(!empty($request->action) && $request->action == 'change_status') {
            $content = ['status'=>204, 'message'=>"something went wrong"];
            if($product->title || $product->image) {
                $product->is_active = $request->value;
                if($product->save()) {
                    $content['status']=200;
                    $content['message'] = "Status updated successfully.";
                }
            }
            return response()->json($content);
        } 
        else{
            $color_ids              = $request->color_title;
            $related_products       = $request->related_products;
            $addons_products        = $request->addons_products;            
            $request['title']       = $request->en_title;
            $request['category_id'] = $request->category;
            $request['box_id']      = $request->box;
            $request['shape_id']    = $request->shape;

            $main_image = TempProduct::where([ 'en_title' => $request->en_title, 'ar_title' => $request->ar_title, 'color_id' => null])->first();

            //Product Image Edit
            if($main_image){                
                $image          =   $main_image['image'];
                $explode        =   explode('/', $image);
                $new_image      =   $explode[3];

                if(Storage::exists($image)){
                    Storage::move($image,'/product/images/'.$new_image);
                    $image_path         = "/product/images/".$new_image; 
                    $request['image']   = $image_path;
                }
            }else{
                $request['image'] = $product->image;
            }
           
            //Product Color Image Edit
            if( $color_ids != null ){
                
                foreach ($color_ids as $key => $color_id) {    
                
                    $temp_products = TempProduct::where(['en_title' => $request->en_title, 'ar_title' => $request->ar_title, 'color_id' => $color_id])->get();
                
                    if(!$temp_products->isEmpty()){
                    
                        foreach ($temp_products as $key => $temp_product) {

                            if($temp_product != null && $product != null){
                                $custom_id      =   getUniqueString('product_colors');
                                $image          =   $temp_product['image'];
                                $explode        =   explode('/', $image);
                                $new_image      =   $explode[3];
                                
                                if(Storage::exists($image)){
                                    Storage::move($image,'/product/image_colors/'.$new_image);
                                    $image_path = "/product/image_colors/".$new_image;

                                    $product_colors = ProductColor::updateOrCreate([
                                            'product_id'    =>  $product['id'],
                                            'custom_id'     =>  $custom_id,   
                                        ],[             
                                            'color_id'      =>  $color_id,
                                            'image'         =>  $image_path,
                                        ]);

                                    $not_to_delete_item[] = $custom_id;
                                }
                            }
                        }
                    } 
                }

                foreach ($color_ids as $key => $color_id) {
                    $not_delete_colors = ProductColor::where(['product_id' => $product->id, 'color_id' => $color_id])->get();

                    if(!$not_delete_colors->isEmpty()){
                        foreach ($not_delete_colors as $key => $not_delete_color) {
                            $not_to_delete_item[] = $not_delete_color->custom_id;
                        }
                    }            
                }
            }
            else{
                ProductColor::where('product_id',$product->id)->delete();
                $not_to_delete_item[] = null;
            }

            //Allocate $product as Edited Product
            $product = $product_main;

            // Delete Product Colors(Which Not In Update List)
            ProductColor::where('product_id',$product->id)->whereNotIn('custom_id', $not_to_delete_item)->delete();    

            //Relate Products Edit
            if($related_products != null){
                foreach ($related_products as $key => $related_product) {
                    $custom_id = getUniqueString('product_related');

                    ProductRelated::updateOrCreate([
                        'product_id'            =>  $product['id'],
                        'custom_id'             =>  $custom_id,   
                    ],[             
                        'related_product_id'    =>  $related_product,
                    ]);

                    $not_to_delete_related_product[] = $custom_id;
                }

            } else{
                ProductRelated::where('product_id',$product->id)->delete();
                $not_to_delete_related_product[] = null;
            }

            //Delete Related Products
            ProductRelated::where('product_id',$product->id)->whereNotIn('custom_id',$not_to_delete_related_product)->delete();
            

            //Addons Products Edit
            if($addons_products != null){

                foreach ($addons_products as $key => $addons_product) {
                    $custom_id = getUniqueString('product_addons');

                    ProductAddon::updateOrCreate([
                        'product_id'            =>  $product['id'],
                        'custom_id'             =>  $custom_id,   
                    ],[             
                        'addons_product_id'     =>  $addons_product,
                    ]);

                    $not_to_delete_addon_product[] = $custom_id;
                }
            } else{
                ProductAddon::where('product_id',$product->id)->delete();
                $not_to_delete_addon_product[] = null;
            }

            //Delete Addons Products
            ProductAddon::where('product_id',$product->id)->whereNotIn('custom_id',$not_to_delete_addon_product)->delete();

            $product->fill($request->all());
            
            if (array_key_exists('title', $product->getDirty())) 
            {
                $slug  = str_slug($request->en_title);
                $count = Product::withTrashed()->where('id', '<>', $product->id)->where('slug', "like", "%{$slug}%")->count();
                $slug  = $slug;
                if( $count != 0 ) {
                    $request['slug'] = $product->slug . '-' . $count;
                }
                $product->slug = $slug;
            }

            if( $product->save() ) {   
                TempProduct::query()->delete();
                Storage::delete(Storage::allFiles('temp/product/images'));
                Storage::delete(Storage::allFiles('temp/product/image_colors')); 
                flash('product details updated successfully!')->success();
            } else {
                flash('Unable to update products. Try again later')->error();
            }
            return redirect(route('admin.product.index'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $custom_id)
    {
        if(!empty($request->action) && $request->action == 'delete_all'){
            $content = ['status'=>204, 'message'=>"something went wrong"];
            $product_images = Product::whereIn('custom_id', explode(',', $request->ids))->pluck('image')->toArray();
            foreach ($product_images as $image) {
                if(!empty($image) && Storage::exists($image)){
                    Storage::delete($image);
                }
            }
            $products = Product::whereIn('custom_id', explode(',', $request->ids))->get();
            foreach ($products as $key => $product) {
                $product_color_images = ProductColor::where('product_id', $product->id)->pluck('image')->toArray();
                foreach ($product_color_images as $image) {
                    if(!empty($image) && Storage::exists($image)){
                      Storage::delete($image);
                    }
                }
                ProductColor::where('product_id', $product->id)->delete();
            }
            Product::whereIn('custom_id',explode(',',$request->ids))->delete();
            $content['status']=200;
            $content['message'] = "Products deleted successfully.";
            $content['count'] = Product::all()->count();
            return response()->json($content);
        }else{
            $product = Product::where('custom_id',$custom_id)->firstOrFail();
            if(!empty($product->image) && Storage::exists($product->image)){
                Storage::delete($product->image);
            }
            $product_color_images = ProductColor::where('product_id', $product->id)->pluck('image')->toArray();
            foreach ($product_color_images as $image) {
                if(!empty($image) && Storage::exists($image)){
                    Storage::delete($image);
                }
            }
            ProductColor::where('product_id', $product->id)->delete();
            $product->delete();
            if(request()->ajax()){
                $content = array('status'=>200, 'message'=>"Product deleted successfully.", 'count' => Product::all()->count());
                return response()->json($content);
            }else{
                flash('Product deleted successfully.')->success();
                return redirect()->route('admin.product.index');
            }
        }
    }

    public function listing(Request $request)
    {
        extract($this->DTFilters($request->all()));
        $products = Product::orderBy($sort_column,$sort_order);

        if( !empty($search) ) {
            $products->where("title", "like", "%{$search}%");
        }
        
        $count = $products->count();
        $records["recordsTotal"] = $count;
        $records["recordsFiltered"] = $count;
        $records['data'] = array();

        $products->offset($offset)->limit($limit);

        foreach ($products->get() as $product) {
            $params = array(
               'checked'    =>  ($product->is_active == 'y' ? "checked" : ""),
               'getaction'  =>  '',
               'class'      =>  '',
               'id'         =>  $product->custom_id
            );
            $records['data'][] = [
                'id'        =>  $product->id,
                'title'     =>  $product->title,
                'is_active' =>  view('admin.layout.includes.switch', compact('params'))->render(),
                'action'    =>  view('admin.layout.includes.actions')->with(['id'=> $product->custom_id], $product)->render(),
                'checkbox'  =>  view('admin.layout.includes.checkbox')->with('id',$product->custom_id)->render(),
            ];
        }
        return $records;
    }

    //When Select Category Then Set Box For Products
    public function getCategoryWiseBox(Request $request)
    {
        $sub_categories = SubCategory::select('category_id','box_id')->with('box')->where('category_id',$request->category_id)->distinct('box_id')->get();

        if($sub_categories != null){
            $sub_categories = $sub_categories->toArray();
            $Response['sub_categories'] = json_encode($sub_categories);
            $Response['success'] = "Getting Category Data Successfully"; 
        } else{
            $Response['fail'] = "Something Went Wrong"; 
        }
        return response()->json($Response,200);          
    }  


    //When Select Box Then Set Shape For Products
    public function getCategoryWiseShape(Request $request)
    {
        $sub_categories = SubCategory::select('category_id','box_id','shape_id')->with('shape')->where(['category_id' => $request->category_id, 'box_id' => $request->box_id])->distinct('shape_id')->get();
        
        if(!$sub_categories->isEmpty()){
            $sub_categories = $sub_categories->toArray();
            $Response['sub_categories'] = json_encode($sub_categories);
            $Response['success'] = "Getting Category Data Successfully"; 
        } else{
            $Response['fail'] = "Something Went Wrong"; 
        }
        return response()->json($Response,200);          
    }  


    public function csvUpload(Request $request)
    {
        $file = NULL;
        $status = false;
        $counter = 0;
        $message = "No new products found";
        if( $request->has('csvFile') ) {
            $path = $request->file('csvFile');
            // Open File
                $handle = fopen($path,'r');
                if( $handle !== false ) {
                    $readLine = fgetcsv($handle,1000,',');
                    while ( ($readLine = fgetcsv($handle,1000,',')) !== false ) {
                            
                        if( !empty($readLine[0]) && !empty($readLine[1]) && !empty($readLine[2]) && !empty($readLine[3])   
                            && !empty($readLine[4]) && !empty($readLine[5]) && !empty($readLine[6]) && !empty($readLine[7])
                            && !empty($readLine[8]) && !empty($readLine[9]) && !empty($readLine[10]) && !empty($readLine[11])
                            && !empty($readLine[12]) && !empty($readLine[13]) && !empty($readLine[14]) && !empty($readLine[15]) 
                            && !empty($readLine[16])
                          ) {
                        
                            $product = Product::updateOrCreate([
                                'custom_id'         =>  $readLine[0],
                            ],[
                                'slug'              =>  $readLine[1],
                                'title'             =>  $readLine[2],
                                'ar_title'          =>  $readLine[3],
                                'en_description'    =>  $readLine[4],
                                'ar_description'    =>  $readLine[5],
                                'category_id'       =>  $readLine[6],
                                'box_id'            =>  $readLine[7],
                                'shape_id'          =>  $readLine[8],
                                'sku'               =>  $readLine[9],
                                'list_price'        =>  $readLine[10],
                                'your_price'        =>  $readLine[11],
                                'weight'            =>  $readLine[12],
                                'total_stock'       =>  $readLine[13],
                                'minimum_qty'       =>  $readLine[14],
                                'order_amount'      =>  $readLine[15],
                                'image'             =>  $readLine[16],
                            ]);

                            if( $product->wasRecentlyCreated )
                                $counter++;
                        }
                    }
                    $status = true;
                } else {
                    $message = "Unable to read file, please upload proper file.";
                }
        }
        if( $status = true && $counter >= 1) {
            $title = 'products';
            if( $counter >= 2 )
                $title = 'products';
            flash($counter.' '.$title.' added successfully!')->success();
        } else {
            flash($message)->important();
        }
        return redirect(route('admin.product.index')); 
    }

    //SAMPLE CSV DOWNLOAD
    public function csvDownload(Request $request)
    {
        $data = [
            [
                'custom_id'         =>  'ukcdubcajdbakbkbaaf',
                'slug'              =>  'red-rose',
                'title'             =>  'Red Rose',
                'ar_title'          =>  'Red Rose',
                'en_description'    =>  'Description In English',
                'ar_description'    =>  'Arabic In English',
                'category_id'       =>  1,
                'box_id'            =>  1,
                'shape_id'          =>  1,
                'sku'               =>  'RED123',
                'list_price'        =>  400,
                'your_price'        =>  500,
                'weight'            =>  '2kg',
                'total_stock'       =>  25,
                'minimum_qty'       =>  1,
                'order_amount'      =>  500,
                'image'             =>  '/product/images/xVvPh9aeXDc24yDONsiNThbb6M7fnMA7uiXp6XNX.png',
            ],
        ];
           
        $filename = "sampleproduct.csv";
        $handle   = fopen($filename, 'w+');
        fputcsv($handle, array('custom_id', 'slug', 'title', 'ar_title', 'en_description', 'ar_description', 'category_id', 'box_id', 'shape_id', 'sku', 'list_price', 'your_price', 'weight', 'total_stock', 'minimum_qty', 'order_amount', 'image'));

        foreach($data as $row) {
            fputcsv($handle, array(
                $row['custom_id'], $row['slug'], $row['title'], $row['ar_title'], $row['en_description'], $row['ar_description'], $row['category_id'], $row['box_id'], $row['shape_id'], $row['sku'], $row['list_price'], $row['your_price'], $row['weight'], $row['total_stock'], $row['minimum_qty'], $row['order_amount'], $row['image']));
        }
        fclose($handle);

        $headers = array(
            'Content-Type' => 'text/csv',
        );

        return Response::download($filename, 'sampleproduct.csv', $headers);
    }
}

