<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\BoxRequest;
use App\Models\BoxTitle;
use App\Models\SubBox;
use App\Models\Shape;
use App\Models\BoxShape;
use App\Models\Temp;

class BoxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $count = BoxTitle::count();
        return view('admin.pages.boxs.list', compact('count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $shapes = Shape::where('is_active','y')->get();    
        return view('admin.pages.boxs.create',compact('shapes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Store Data When Form Submit
        if($request->has('en_title') && $request->has('ar_title')){ 

            $this->validate($request, [
                'en_title'      => 'required|max:255',
                'ar_title'      => 'required|max:255',
                'shape_title.*' => 'required|distinct',
            ],[
                'en_title.required'      => 'The box title filed is required',
                'ar_title.required'      => 'The box title filed is required',
                'shape_title.*.required' => 'The shape title field is required',
                'shape_title.*.distinct' => 'The shape title field has duplicate value',
            ]);

            $flag       =   0;
            $shape_ids  =   $request->shape_title;

            BoxTitle::create([
                'custom_id'     =>  getUniqueString('box_titles'),
                'title'         =>  $request->en_title,
                'ar_title'      =>  $request->ar_title,
            ]);

            $box_data = BoxTitle::select('id')->where(['title' => $request->en_title, 'ar_title' => $request->ar_title])->first();

            foreach ($shape_ids as $key => $shape_id) 
            {
                $temp_data     = Temp::select('shape_id','image')->where('shape_id',$shape_id)->first();

                if($temp_data != null){
                    $custom_id      = getUniqueString('sub_boxes');
                    $box_title_id   = $box_data['id'];
                    $shape_id       = $temp_data['shape_id'];
                    $image          = $temp_data['image'];

                    $explode        = explode('/', $image);
                    $new_image      = $explode[2];

                    if(Storage::exists($image)){
                        Storage::move($image,'/box/'.$new_image);
                        $image_path = "/box/".$new_image;

                        $data = [
                            'custom_id'     =>  $custom_id,
                            'box_title_id'  =>  $box_title_id,
                            'shape_id'      =>  $shape_id,
                            'image'         =>  $image_path,
                        ];   

                        $subbox = SubBox::create($data);
                        $subbox->save();
                        $flag = 1;
                        // $temp_data = Temp::where('box_shape_id',$box_shape_id)->first();
                        // $temp_data->delete();
                    }
                }
            }

            if($flag == 1){
                //Delete Temparally Files From DB & Storage
                Temp::query()->delete();
                Storage::delete(Storage::allFiles('temp/box'));

                flash('Box details added successfully')->success();
                return redirect(route('admin.box.index'));
            }else{
                flash('Unable to update Box details')->error();
                return redirect(route('admin.box.index'));
            }
        }
        else{
            //To Store Image Using Ajax(Before Form Submit)
            $image_path = null;
            $Response   = "Something Went Wrong";

            if($request->shape_id != "undefined" && $request->shape_id != null ){
                if( $request->has('filepond') ) {
                    $image      = $request->file('filepond');
                    $image_path = $image->store('temp/box');
                }
                if( $request->has('image') ){
                    if($request->has('count')){
                        //When Edit Box Details
                        $image      = $request->file('image')[$request->count];
                        $image_path = $image->store('temp/box');
                    }else{
                        //When Add New Box
                        $image      = $request->file('image')[0];
                        $image_path = $image->store('temp/box');
                    }
                }

                $temp = Temp::create([
                    'shape_id' =>   $request->shape_id,
                    'image'    =>   $image_path,
                ]);

                $temp->save();

                if($temp->save()){
                    $Response = "image added into temp table";
                }else{
                    $Response = "image upload fail";
                }
            }else{
                dd($error);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $box = BoxTitle::where('id',$id)->first();
        if($box != null){
            $subbox_count = SubBox::where('box_title_id',$id)->count();
            $sub_boxes    = SubBox::with('shape')->where('box_title_id',$id)->get();

            return view('admin.pages.boxs.view',compact('box','subbox_count','sub_boxes'));
        } else{
            return redirect(route('admin.box.index'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $box = BoxTitle::where('id',$id)->first();
        if($box != null){
            $shapes     =   Shape::where('is_active','y')->get();
            $sub_boxes  =   SubBox::where('box_title_id',$id)->get();
            return view('admin.pages.boxs.edit',compact('box','shapes','sub_boxes'));
        } else{
            return redirect(route('admin.box.index'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BoxRequest $request, $id)
    {
        $boxTitle = boxTitle::where('id',$id)->first();
        if(!empty($request->action) && $request->action == 'change_status') {
            $content = ['status'=>204, 'message'=>"something went wrong"];
            if($boxTitle->title) {
                $boxTitle->is_active = $request->value;
                if($boxTitle->save()) {
                    $content['status']  = 200;
                    $content['message'] = "Status updated successfully.";
                }
            }
            return response()->json($content);
        } 
        else {
            $not_to_delete_item = [];
            $only_title_edit    = false;
            $shape_ids          = $request->shape_title;

            //Update Box Title
            $box_title  = BoxTitle::find($id);
            $edit_title = $box_title->fill([
                'title'         =>  $request->en_title,
                'ar_title'      =>  $request->ar_title
            ]);
            $edit_title->save();

            if($shape_ids != null){
                //Update Sub-Boxes
                foreach ($shape_ids as $key => $shape_id) 
                {
                    $temp_data     = Temp::select('shape_id','image')->where('shape_id',$shape_id)->first();

                    if($temp_data != null){
                        $custom_id      = getUniqueString('sub_boxes');
                        $box_title_id   = $id;
                        $shape_id       = $temp_data['shape_id'];
                        $image          = $temp_data['image'];

                        $explode        = explode('/', $image);
                        $new_image      = $explode[2];

                        if(Storage::exists($image)){
                            Storage::move($image,'/box/'.$new_image);
                            $image_path = "/box/".$new_image;   

                            $subbox = SubBox::updateOrCreate([
                                'box_title_id'  =>  $box_title_id,
                                'shape_id'      =>  $shape_id,
                            ],[
                                'custom_id'     =>  $custom_id,
                                'image'         =>  $image_path,
                            ]);

                            $not_to_delete_item[] = $custom_id; 
                        }
                    }
                }

                foreach ($shape_ids as $key => $shape_id) {
                    $not_delete = SubBox::where(['box_title_id' => $id, 'shape_id' => $shape_id])->first();

                    if($not_delete != null){
                        $custom_id = $not_delete->custom_id; 
                        $not_to_delete_item[] = $custom_id;
                    }                
                }

                // Delete Subboxes(Which Not In Update List)
                SubBox::where('box_title_id',$id)->whereNotIn('custom_id', $not_to_delete_item)->delete();  
                
            }else{
                $only_title_edit = true;                
            }

            if($edit_title->save() || $subbox->save() || $only_title_edit == true){
                //Delete Temparally Files From DB & Storage
                Temp::query()->delete();
                Storage::delete(Storage::allFiles('temp/box'));
                flash('Box details updated successfully')->success();
            }else{
                flash('Unable to update box details. Try again later')->error();
            }
            return redirect(route('admin.box.index'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if(!empty($request->action) && $request->action == 'delete_all'){
            $content = ['status'=>204, 'message'=>"something went wrong"];
            BoxTitle::whereIn('id',explode(',',$request->ids))->delete();
            $sub_boxes_images = SubBox::whereIn('box_title_id', explode(',', $request->ids))->pluck('image')->toArray();
            foreach ($sub_boxes_images as $image) {
                if(!empty($image) && Storage::exists($image)){
                    Storage::delete($image);
                }
            }
            $content['status']=200;
            $content['message'] = "Box deleted successfully.";
            $content['count'] = BoxTitle::all()->count();
            return response()->json($content);
        }else{
            BoxTitle::where('id',$id)->delete();
            $sub_boxes_images = SubBox::where('box_title_id', $id)->pluck('image')->toArray();
            foreach ($sub_boxes_images as $image) {
                if(!empty($image) && Storage::exists($image)){
                    Storage::delete($image);
                }
            }
            if(request()->ajax()){
                $content = array('status'=>200, 'message'=>"Box deleted successfully.", 'count' => BoxTitle::all()->count());
                return response()->json($content);
            }else{
                flash('Box deleted successfully.')->success();
                return redirect()->route('admin.box.index');
            }
        }
    }

    public function listing(Request $request)
    {
        extract($this->DTFilters($request->all()));
        $boxes = BoxTitle::orderBy($sort_column,$sort_order);

        if( !empty($search) ) {
            $boxes->where("title", "like", "%{$search}%");
        }
        
        $count = $boxes->count();
        $records["recordsTotal"] = $count;
        $records["recordsFiltered"] = $count;
        $records['data'] = array();

        $boxes->offset($offset)->limit($limit);
        foreach ($boxes->get() as $box) {
            $subbox_count = SubBox::where('box_title_id',$box->id)->count();
            $params = array(
               'checked'    =>  ($box->is_active == 'y' ? "checked" : ""),
               'getaction'  =>  '',
               'class'      =>  '',
               'id'         =>  $box->id
            );
            $records['data'][] = [
                'id'            =>  $box->id,
                'title'         =>  $box->title,
                'subbox_count'  =>  $subbox_count,
                'is_active'     =>  view('admin.layout.includes.switch', compact('params'))->render(),
                'action'        =>  view('admin.layout.includes.actions')->with(['id'=> $box->id], $box)->render(),
                'checkbox'      =>  view('admin.layout.includes.checkbox')->with('id',$box->id)->render(),
            ];
        }
        return $records;
    }

    public function subBoxDelete(Request $request, $custom_id)
    {
        $box   = SubBox::select('box_title_id')->where('custom_id',$custom_id)->first();
        if($box != null)
        {
            SubBox::where('custom_id',$custom_id)->delete();
            if(request()->ajax()){
                $content = array('status'=>200, 'message'=>"Sub Box deleted successfully.", 'count' => SubBox::where('box_title_id',$box->box_title_id)->count());
                return redirect()->route('admin.box.index');            
            }else{
                flash('Sub Box deleted successfully.')->success();
                return redirect()->route('admin.box.index');            
            }
        }
        else{
            flash('Unable to delete  sub box details. Try again later')->error();
            return redirect(route('admin.box.index'));
        }
    }
}
