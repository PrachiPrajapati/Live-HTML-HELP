<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\ColorRequest;
use Illuminate\Http\Request;
use App\Models\Color;
use App\Models\Temp;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $count = Color::count();
        return view('admin.pages.colors.list', compact('count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.colors.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //To Store Image Using Filepond Request Through Ajax(Before Form Submit)
        if( $request->has('filepond_request') ){
            $image_path = null;
            $Response   = "Something Went Wrong";

            if($request->en_title_filepond != null && $request->ar_title_filepond != null){
                if( $request->has('filepond') ) {
                    $image      = $request->file('filepond');
                    $image_path = $image->store('temp/color');
                }
                $data = [
                    'en_color' =>   $request->en_title_filepond,
                    'ar_color' =>   $request->ar_title_filepond,
                    'image'    =>   $image_path,
                ];
                $temp = Temp::create($data);
                if($temp->save()){
                    $Response = "image added into temp table";
                }else{
                    $Response = "image upload fail";
                }
            }else{
                dd($error);
            }
        }
        else{
            //When Submit Form
            $flag     = 0;
            $en_title = $request->en_title;
            $ar_title = $request->ar_title;
            
            if( $en_title != null && $ar_title != null ){
                $temp_data = Temp::where([ 'en_color' => $en_title, 'ar_color' => $ar_title])->first();

                if($temp_data){
                    $en_title       =   $temp_data['en_color'];
                    $ar_title       =   $temp_data['ar_color'];
                    $image          =   $temp_data['image'];
                    $explode        =   explode('/', $image);
                    $new_image      =   $explode[2];

                    if(Storage::exists($image)){
                        Storage::move($image,'/color/'.$new_image);
                        $image_path = "/color/".$new_image;

                        $data = [
                            'custom_id'     =>  getUniqueString('colors'),
                            'title'         =>  $en_title,
                            'ar_title'      =>  $ar_title,
                            'image'         =>  $image_path,
                        ];   
                        $color = Color::create($data);
                        $color->save();
                        $flag = 1;
                    }             
                }
            }
            //Delete Temparally Files From DB & Storage
            Temp::query()->delete();
            Storage::delete(Storage::allFiles('temp/color'));

            if($flag == 1){
                flash('Color details added successfully')->success();
            }else{
                flash('Unable to add color details. Try again later')->error();
            }
            return redirect(route('admin.color.index'));
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($custom_id)
    {
        $color = Color::where('custom_id',$custom_id)->first();
        if($color){
            return view('admin.pages.colors.edit',compact('color'));
        } else{
            return redirect(route('admin.color.index'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ColorRequest $request, $custom_id)
    {
        $color = Color::where('custom_id',$custom_id)->first();
        if(!empty($request->action) && $request->action == 'change_status') {
            $content = ['status'=>204, 'message'=>"something went wrong"];
            if($color->title || $color->image) {
                $color->is_active = $request->value;
                if($color->save()) {
                    $content['status']=200;
                    $content['message'] = "Status updated successfully.";
                }
            }
            return response()->json($content);
        } 
        else{
            $flag       = 0;
            $temp_data  = Temp::where(['en_color' => $request->en_title, 'ar_color' => $request->ar_title])->first();
            $color      = Color::where('custom_id',$custom_id)->first();

            if($color){
                $edit_color = $color->fill([
                    'title'     =>  $request->en_title,
                    'ar_title'  =>  $request->ar_title,
                ]);
                
                if($temp_data){
                    $en_title       =   $temp_data['en_color'];
                    $ar_title       =   $temp_data['ar_color'];
                    $image          =   $temp_data['image'];
                    $explode        =   explode('/', $image);
                    $new_image      =   $explode[2];

                    if(Storage::exists($image)){
                        Storage::move($image,'/color/'.$new_image);
                        $image_path = "/color/".$new_image;
                        $data = [
                            'title'     =>  $en_title,
                            'ar_title'  =>  $ar_title,
                            'image'     =>  $image_path,
                        ];   
                        $color = $color->fill($data);
                        $color->save();
                        $flag = 1;
                    }
                }   
            }
            //Delete Temparally Files From DB & Storage
            Temp::query()->delete();
            Storage::delete(Storage::allFiles('temp/color')); 

            if( $edit_color->save() || $flag == 1 ) {    
                flash('colors details updated successfully!')->success();
            } else {
                flash('Unable to update colors. Try again later')->error();
            }
            return redirect(route('admin.color.index'));
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
            $color_images = Color::whereIn('custom_id', explode(',', $request->ids))->pluck('image')->toArray();
            foreach ($color_images as $image) {
                if(!empty($image) && Storage::exists($image)){
                    Storage::delete($image);
                }
            }
            Color::whereIn('custom_id',explode(',',$request->ids))->delete();
            $content['status']=200;
            $content['message'] = "Countries deleted successfully.";
            $content['count'] = Color::all()->count();
            return response()->json($content);
        }else{
            $color = Color::where('custom_id',$custom_id)->firstOrFail();
            if(!empty($color->image) && Storage::exists($color->image)){
                Storage::delete($color->image);
            }
            $color->delete();
            if(request()->ajax()){
                $content = array('status'=>200, 'message'=>"Color deleted successfully.", 'count' => Color::all()->count());
                return response()->json($content);
            }else{
                flash('Color deleted successfully.')->success();
                return redirect()->route('admin.countries.index');
            }
        }
    }

    public function listing(Request $request)
    {
        extract($this->DTFilters($request->all()));
        $colors = Color::orderBy($sort_column,$sort_order);

        if( !empty($search) ) {
            $colors->where("title", "like", "%{$search}%");
        }
        
        $count = $colors->count();
        $records["recordsTotal"] = $count;
        $records["recordsFiltered"] = $count;
        $records['data'] = array();

        $colors->offset($offset)->limit($limit);

        foreach ($colors->get() as $color) {
            $params = array(
               'checked'    =>  ($color->is_active == 'y' ? "checked" : ""),
               'getaction'  =>  '',
               'class'      =>  '',
               'id'         =>  $color->custom_id
            );
            $records['data'][] = [
                'id'        =>  $color->id,
                'title'     =>  $color->title,
                'is_active' =>  view('admin.layout.includes.switch', compact('params'))->render(),
                'action'    =>  view('admin.layout.includes.actions')->with(['id'=> $color->custom_id], $color)->render(),
                'checkbox'  =>  view('admin.layout.includes.checkbox')->with('id',$color->custom_id)->render(),
            ];
        }
        return $records;
    }
}
