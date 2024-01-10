<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\CategoryRequest;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Models\BoxTitle;
use App\Models\BoxShape;
use App\Models\Shape;
use App\Models\SubCategory;
use App\Models\Temp;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $count = Category::count();
        return view('admin.pages.category.list',compact('count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $boxes  = BoxTitle::where('is_active','y')->get();
        $shapes = Shape::where('is_active','y')->get();    
        return view('admin.pages.category.create',compact('boxes','shapes'));   
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $flag   = 0; 
        $sub_category_data = [];
        $boxes  = $request->box;
        $shapes = $request->shape;
        $slug   = str_slug($request->en_title);
        $count  = Category::withTrashed()->where('slug', "like", "%{$slug}%")->count();
        $request['slug'] = $slug;
        if( $count != 0 ) {
            $request['slug'] = $slug . '-' . $count;
        }

        $temp_data = Temp::where([ 'en_color' => $request->en_title, 'ar_color' => $request->ar_title])->first();
        if($temp_data){
            $image          =    $temp_data['image'];
            $explode        =    explode('/', $image);
            $new_image      =    $explode[2];

            if(Storage::exists($image)){
                Storage::move($image,'/color/'.$new_image);
                $image_path = "/color/".$new_image;

                $category_data = Category::create( [
                    'custom_id'     =>  getUniqueString('categories'),
                    'slug'          =>  $request->slug,
                    'title'         =>  $request->en_title,
                    'ar_title'      =>  $request->ar_title,
                    'image'         =>  $image_path,
                ]);
                $category_data->save();
               
                foreach ($boxes as $key => $box) 
                {
                    $sub_category_data[] = [
                        'custom_id'     =>  getUniqueString('sub_categories'),
                        'category_id'   =>  $category_data['id'],
                        'box_id'        =>  $box,
                        'shape_id'      =>  $shapes[$key],
                        'created_at'    =>  \Carbon\Carbon::now(),
                        'updated_at'    =>  \Carbon\Carbon::now(),
                    ];
                }
                SubCategory::insert($sub_category_data);
                $flag = 1;
            }
        }
        //Delete Temparally Files From DB & Storage
        Temp::query()->delete();
        Storage::delete(Storage::allFiles('temp/color'));

        if($flag == 1){
            flash('Category details added successfully')->success();
            return redirect(route('admin.category.index'));
        }else{
            flash('Unable to add Category details')->error();
            return redirect(route('admin.category.index'));
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
        $category = Category::where('custom_id',$custom_id)->first();
        if($category)
        {
            $sub_category_count = SubCategory::where('category_id',$category->id)->count();
            $sub_categories     = SubCategory::with('box')->where('category_id',$category->id)->get();
            return view('admin.pages.category.view',compact('category','sub_category_count','sub_categories'));
        } else{
            return redirect(route('admin.category.index'));
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
        $category = Category::where('custom_id',$custom_id)->first();
        if($category)
        {
            $sub_categories =   SubCategory::where('category_id',$category['id'])->get();
            $boxes          =   BoxTitle::where('is_active','y')->get(); 
            $shapes         =   Shape::where('is_active','y')->get();    
            return view('admin.pages.category.edit',compact('category','sub_categories','boxes','shapes'));
        }else{
            return redirect(route('admin.category.index'));
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
        $category = Category::where('custom_id',$custom_id)->first();

        if(!empty($request->action) && $request->action == 'change_status') {
            $content = ['status'=>204, 'message'=>"something went wrong"];
            if($category->title) {
                $category->is_active = $request->value;
                if($category->save()) {
                    $content['status']=200;
                    $content['message'] = "Status updated successfully.";
                }
            }
            return response()->json($content);
        } 
        else {
            $request->validate([
                'en_title'      =>  'required|max:255',
                'ar_title'      =>  'required|max:255',
                'box.*'         =>  'required',
                'shape.*'       =>  'required',
            ],[
                'en_title.required' => 'The category title filed is required',
                'ar_title.required' => 'The category title filed is required',
                'box.*.required'    => 'The product type field is required',
                'shape.*.required'  => 'The product shape field is required',
            ]);

            $not_to_delete_item     = [];
            $boxes                  = $request->box;
            $shapes                 = $request->shape;
            $request['title']       = $request->en_title;
            
            $temp_data  = Temp::where(['en_color' => $request->en_title, 'ar_color' => $request->ar_title])->first();
            if($temp_data){
                $image          =   $temp_data['image'];
                $explode        =   explode('/', $image);
                $new_image      =   $explode[2];

                if(Storage::exists($image)){
                    Storage::move($image,'/color/'.$new_image);
                    $image_path = "/color/".$new_image;

                    $category = $category->fill([
                        'image'     =>  $image_path,
                    ]);
                    $category->save();
                }
            }
            $category->fill($request->all());

            //Update Category Title
            if (array_key_exists('title', $category->getDirty())) 
            {
                $slug  = str_slug($request->en_title);
                $count = Category::withTrashed()->where('id', '<>', $category->id)->where('slug', "like", "%{$slug}%")->count();
                $slug  = $slug;
                if( $count != 0 ) {
                    $request['slug'] = $category->slug . '-' . $count;
                }
                $category->slug = $slug;
            }

            if($category){
                //Update Sub-Category
                foreach ($boxes as $key => $box) 
                {
                    $custom_id  = getUniqueString('sub_categories');
                    SubCategory::updateOrCreate([
                        'category_id'   =>  $category['id'],
                        'custom_id'     =>  $custom_id,   
                    ],[             
                        'box_id'        =>  $box,
                        'shape_id'      =>  $shapes[$key],
                    ]);
                    $not_to_delete_item[] = $custom_id; 
                }
            }else{
                $not_to_delete_item[] = null;
            }
            
            // Delete Subboxes(Which Not In Update List)
            SubCategory::where('category_id',$category['id'])->whereNotIn('custom_id', $not_to_delete_item)->delete();  
           
            //Delete Temparally Files From DB & Storage
            Temp::query()->delete();
            Storage::delete(Storage::allFiles('temp/color'));

            if($category->save()){
                flash('Category details updated successfully')->success();
            }else{
                flash('Unable to update category details. Try again later')->error();
            }
            return redirect(route('admin.category.index'));
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
            $category_images = Category::whereIn('custom_id', explode(',', $request->ids))->pluck('image')->toArray();
            foreach ($category_images as $image) {
                if(!empty($image) && Storage::exists($image)){
                    Storage::delete($image);
                }
            }
            Category::whereIn('custom_id',explode(',',$request->ids))->delete();
            $content['status']=200;
            $content['message'] = "Category deleted successfully.";
            $content['count'] = Category::all()->count();
            return response()->json($content);
        }else{
            $category = Category::where('custom_id',$custom_id)->firstOrFail();
            if(!empty($category->image) && Storage::exists($category->image)){
                Storage::delete($category->image);
            }
            $category->delete();
            if(request()->ajax()){
                $content = array('status'=>200, 'message'=>"Category deleted successfully.", 'count' => Category::all()->count());
                return response()->json($content);
            }else{
                flash('Category deleted successfully.')->success();
                return redirect()->route('admin.category.index');
            }
        }
    }


    public function listing(Request $request)
    {
        extract($this->DTFilters($request->all()));
        $categories = Category::orderBy($sort_column,$sort_order);

        if( !empty($search) ) {
            $categories->where("title", "like", "%{$search}%");
        }
        
        $count = $categories->count();
        $records["recordsTotal"] = $count;
        $records["recordsFiltered"] = $count;
        $records['data'] = array();

        $categories->offset($offset)->limit($limit);
        foreach ($categories->get() as $category) {
            $count = SubCategory::where('category_id',$category->id)->count();

            $params = array(
               'checked'    =>  ($category->is_active == 'y' ? "checked" : ""),
               'getaction'  =>  '',
               'class'      =>  '',
               'id'         =>  $category->custom_id
            );
            $records['data'][] = [
                'id'        =>  $category->custom_id,
                'title'     =>  $category->title,
                'count'     =>  $count,
                'is_active' =>  view('admin.layout.includes.switch', compact('params'))->render(),
                'action'    =>  view('admin.layout.includes.actions')->with(['id'=> $category->custom_id], $category)->render(),
                'checkbox'  =>  view('admin.layout.includes.checkbox')->with('id',$category->custom_id)->render(),
            ];
        }
        return $records;
    }
}
