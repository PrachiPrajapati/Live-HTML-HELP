<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Franchises;
use App\Http\Requests\Admin\FranchisRequest;

class FranchisesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $count = Franchises::count();
        return view('admin.pages.franchises.list', compact('count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.franchises.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FranchisRequest $request)
    {
        $request['custom_id'] = getUniqueString('franchises');
        $franchises = Franchises::create($request->all());

        if( $franchises->save() ) {
            flash('Franchises details added successfully')->success();
        } else {
            flash('Unable to add franchises. Try again later')->error();
        }
        return redirect(route('admin.franchises.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(FranchisRequest $request ,$id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {        
        $franchise = Franchises::where('id',$id)->first();
        if($franchise){
            return view('admin.pages.franchises.edit', compact('franchise'));
        }
        return redirect(route('admin.franchises.index'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FranchisRequest $request, $id)
    {
        $franchise = Franchises::where('id',$id)->first();
        if(!empty($request->action) && $request->action == 'change_status') {
            $content = ['status'=>204, 'message'=>"something went wrong"];
            if($franchise->name || $franchise->email || $franchise->phone || $franchise->mobile) {
                $franchise->is_active = $request->value;
                if($franchise->save()) {
                    $content['status']=200;
                    $content['message'] = "Status updated successfully.";
                }
            }
            return response()->json($content);
        } else {
            $franchise->fill($request->all());
            if( $franchise->save() ) {
                flash('Franchise details updated successfully!')->success();
            } else {
                flash('Unable to update franchise. Try again later')->error();
            }
            return redirect(route('admin.franchises.index'));
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
            Franchises::whereIn('id',explode(',',$request->ids))->delete();
            $content['status']=200;
            $content['message'] = "Franchise deleted successfully.";
            $content['count'] = Franchises::all()->count();
            return response()->json($content);
        }else{
            Franchises::where('id',$id)->delete();
            if(request()->ajax()){
                $content = array('status'=>200, 'message'=>"Franchise deleted successfully.", 'count' => Franchises::all()->count());
                return response()->json($content);
            }else{
                flash('Franchise deleted successfully.')->success();
                return redirect()->route('admin.franchises.index');
            }
        }
    }

    public function listing(Request $request)
    {
        extract($this->DTFilters($request->all()));
        $franchises = Franchises::orderBy($sort_column,$sort_order);

        if( !empty($search) ) {
            $franchises->where("en_name", "like", "%{$search}%")
                    ->orWhere("ar_name", "like", "%{$search}%")
                    ->orWhere("email", "like", "%{$search}%")
                    ->orWhere("contact_number", "like", "%{$search}%");;
            }
        
        $count = $franchises->count();
        $records["recordsTotal"] = $count;
        $records["recordsFiltered"] = $count;
        $records['data'] = array();

        $franchises->offset($offset)->limit($limit);
        foreach ($franchises->get() as $franchis) {
            $params = array(
               'checked'    => ($franchis->is_active == 'y' ? "checked" : ""),
               'getaction'  =>'',
               'class'      =>'',
               'id'         => $franchis->id
            );
            $records['data'][] = [
                'id'             =>  $franchis->id,
                'en_name'        =>  $franchis->en_name,
                'email'          =>  $franchis->email,
                'contact_number'          =>  $franchis->contact_number,
            
                'is_active'=>view('admin.layout.includes.switch', compact('params'))->render(),
                'action'=>view('admin.layout.includes.actions')->with(['id'=> $franchis->id], $franchis)->render(),
                'checkbox'=>view('admin.layout.includes.checkbox')->with('id',$franchis->id)->render(),
            ];
        }
        return $records;
    }
}
