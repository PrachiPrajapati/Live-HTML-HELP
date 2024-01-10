<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ShapeRequest;
use Illuminate\Http\Request;
use App\Models\Shape;

class ShapeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $count = Shape::count();
        return view('admin.pages.shapes.list',compact('count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.shapes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShapeRequest $request)
    {
        $request['custom_id'] = getUniqueString('shapes');
        $shape = Shape::create($request->all());
        
        if( $shape->save() ) {
            flash('Shape added successfully!')->success();
        } else {
            flash('Unable to add shape. Please try again later.')->error();
        }
        return redirect(route('admin.shape.index'));
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
        $shape = Shape::where('custom_id',$custom_id)->first();
        if($shape){
            return view('admin.pages.shapes.edit', compact('shape'));
        } else{
            return redirect(route('admin.shape.index'));
        } 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ShapeRequest $request, $custom_id)
    {
        $shape = Shape::where('custom_id',$custom_id)->first();
        if(!empty($request->action) && $request->action == 'change_status') {
            $content = ['status'=>204, 'message'=>"something went wrong"];
            if($shape->title || $shape->size) {
                $shape->is_active = $request->value;
                if($shape->save()) {
                    $content['status']=200;
                    $content['message'] = "Status updated successfully.";
                }
            }
            return response()->json($content);
        } else {
            $shape->fill($request->all());
            if( $shape->save() ) {
                flash('Shape details updated successfully!')->success();
            } else {
                flash('Unable to update shape. Try again later')->error();
            }
            return redirect(route('admin.shape.index'));
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
            Shape::whereIn('custom_id',explode(',',$request->ids))->delete();
            $content['status']=200;
            $content['message'] = "Shape deleted successfully.";
            $content['count'] = Shape::all()->count();
            return response()->json($content);
        }else{
            Shape::where('custom_id',$custom_id)->delete();
            if(request()->ajax()){
                $content = array('status'=>200, 'message'=>"Shape deleted successfully.", 'count' => Shape::all()->count());
                return response()->json($content);
            }else{
                flash('Shape deleted successfully.')->success();
                return redirect()->route('admin.shape.index');
            }
        }
    }

    public function listing(Request $request)
    {
        extract($this->DTFilters($request->all()));
        $shapes = Shape::orderBy($sort_column,$sort_order);

        if( !empty($search) ) {
            $shapes->where("title", "like", "%{$search}%");
        }
        
        $count = $shapes->count();
        $records["recordsTotal"] = $count;
        $records["recordsFiltered"] = $count;
        $records['data'] = array();

        $shapes->offset($offset)->limit($limit);
        foreach ($shapes->get() as $shape) {
            $params = array(
               'checked'    =>  ($shape->is_active == 'y' ? "checked" : ""),
               'getaction'  =>  '',
               'class'      =>  '',
               'id'         =>  $shape->custom_id
            );
            $records['data'][] = [
                'id'        =>  $shape->custom_id,
                'title'     =>  $shape->title,
                'height'    =>  $shape->height,
                'width'     =>  $shape->width,
                'is_active' =>  view('admin.layout.includes.switch', compact('params'))->render(),
                'action'    =>  view('admin.layout.includes.actions')->with(['id'=> $shape->custom_id], $shape)->render(),
                'checkbox'  =>  view('admin.layout.includes.checkbox')->with('id',$shape->custom_id)->render(),
            ];
        }
        return $records;
    }
}
