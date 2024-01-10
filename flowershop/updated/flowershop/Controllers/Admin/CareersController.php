<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\CareerRequest;
use App\Models\Career;
use Illuminate\Support\Facades\DB;

class CareersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $count = Career::count();
        return view('admin.pages.careers.list', compact('count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.careers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CareerRequest $request)
    {
        $slug = str_slug($request->en_title);
        $count = Career::withTrashed()->where('slug', "like", "%{$slug}%")->count();

        $request['slug'] = $slug;
        if( $count != 0 ) {
            $request['slug'] = $slug . '-' . $count;
        }       

        $career = Career::create($request->all());
        $career->save();

        flash('Career details added successfully')->success();
        return redirect(route('admin.careers.index'));
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
    public function edit($id)
    {
        $career = Career::where('id',$id)->first();
        return view('admin.pages.careers.edit', compact('career'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CareerRequest $request, $id)
    {
        $career = Career::where('id',$id)->first();
        if(!empty($request->action) && $request->action == 'change_status') {
            $content = ['status'=>204, 'message'=>"something went wrong"];
            if($career->en_title || $career->ar_title || $career->en_description || $career->ar_description) {
                $career->is_active = $request->value;
                if($career->save()) {
                    $content['status']=200;
                    $content['message'] = "Status updated successfully.";
                }
            }
            return response()->json($content);
        } else {
            $career->fill($request->all());
             if (array_key_exists('en_title', $career->getDirty())) {
                $slug = str_slug($request->en_title);
                $count = Career::withTrashed()->where('id', '<>', $career->id)->where('slug', "like", "%{$slug}%")->count();
                $slug = $slug;
                if( $count != 0 ) {
                    $request['slug'] = $career->slug . '-' . $count;
                }
                $career->slug = $slug;
            }

            if( $career->save() ) {
                flash('Career details updated successfully!')->success();
            } else {
                flash('Unable to update career. Try again later')->error();
            }

            return redirect(route('admin.careers.index'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        if(!empty($request->action) && $request->action == 'delete_all'){
            $content = ['status'=>204, 'message'=>"something went wrong"];
            Career::whereIn('id',explode(',',$request->ids))->delete();
            $content['status']=200;
            $content['message'] = "Carrer deleted successfully.";
            $content['count'] = Career::all()->count();
            return response()->json($content);
        }else{
            Career::where('id',$id)->delete();
            if(request()->ajax()){
                $content = array('status'=>200, 'message'=>"Career deleted successfully.", 'count' => Career::all()->count());
                return response()->json($content);
            }else{
                flash('Carrer deleted successfully.')->success();
                return redirect()->route('admin.careers.index');
            }
        }
    }

    public function listing(Request $request)
    {
        extract($this->DTFilters($request->all()));
        $careers = Career::orderBy($sort_column,$sort_order);

        if( !empty($search) ) {
            $careers->where("en_title", "like", "%{$search}%")
                    ->orWhere("ar_title", "like", "%{$search}%")
                    ->orWhere("en_description", "like", "%{$search}%")
                    ->orWhere("ar_description", "like", "%{$search}%");
        }
        
        $count = $careers->count();
        $records["recordsTotal"] = $count;
        $records["recordsFiltered"] = $count;
        $records['data'] = array();

        $careers->offset($offset)->limit($limit);
        foreach ($careers->get() as $career) {
            $params = array(
               'checked'=> ($career->is_active == 'y' ? "checked" : ""),
               'getaction'=>'',
               'class'=>'',
               'id'=> $career->id
            );
            $records['data'][] = [
                'id'=>$career->id,

                'en_title'          =>$career->en_title,
                'en_description'    =>$career->en_description,
                
                'ar_title'          =>$career->ar_title,
                'ar_description'    =>$career->ar_description,
            
                'is_active'=>view('admin.layout.includes.switch', compact('params'))->render(),
                'action'=>view('admin.layout.includes.actions')->with(['id'=> $career->id], $career)->render(),
                'checkbox'=>view('admin.layout.includes.checkbox')->with('id',$career->id)->render(),
            ];
        }
        return $records;
    }
}
