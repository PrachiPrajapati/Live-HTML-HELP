<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PrivacyRequest;
use Illuminate\Http\Request;
use App\Models\Privacy;

class PrivacyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $count = Privacy::count();
        return view('admin.pages.privacy.list',compact('count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.privacy.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PrivacyRequest $request)
    {
        $privacy = Privacy::create($request->all());

        if( $privacy->save() ) {
            flash('Privacy Policy details added successfully')->success();
        } else {
            flash('Unable to add privacy policy. Try again later')->error();
        }
        return redirect(route('admin.privacy.index'));
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
        $privacy = Privacy::where('id',$id)->first();
        if($privacy){
            return view('admin.pages.privacy.edit', compact('privacy'));
        } else{
            return redirect(route('admin.privacy.index'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PrivacyRequest $request, $id)
    {
        $privacy = Privacy::find($id);
        if(!empty($request->action) && $request->action == 'change_status') {
            $content = ['status'=>204, 'message'=>"something went wrong"];
            if($privacy->en_title || $privacy->en_details || $privacy->ar_title || $privacy->ar_details) {
                $privacy->is_active = $request->value;
                if($privacy->save()) {
                    $content['status']=200;
                    $content['message'] = "Status updated successfully.";
                }
            }
            return response()->json($content);
        } else {
            $privacy->fill($request->all());

            if( $privacy->save() ) {
                flash('Privacy Policy details updated successfully!')->success();
            } else {
                flash('Unable to update privacy policy. Try again later')->error();
            }

            return redirect(route('admin.privacy.index'));
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
            Privacy::whereIn('id',explode(',',$request->ids))->delete();
            $content['status']=200;
            $content['message'] = "Privacy Policy deleted successfully.";
            $content['count'] = Privacy::all()->count();
            return response()->json($content);
        }else{
            Privacy::where('id',$id)->delete();
            if(request()->ajax()){
                $content = array('status'=>200, 'message'=>"Privacy Policy deleted successfully.", 'count' => Privacy::all()->count());
                return response()->json($content);
            }else{
                flash('Privacy Policy deleted successfully.')->success();
                return redirect()->route('admin.privacy.index');
            }
        }
    }

    public function listing(Request $request)
    {
        extract($this->DTFilters($request->all()));
        $privacies = Privacy::orderBy($sort_column,$sort_order);

        if( !empty($search) ) {
            $privacies->where("en_title", "like", "%{$search}%")
                    ->orWhere("ar_title", "like", "%{$search}%"); 
        }
        
        $count = $privacies->count();
        $records["recordsTotal"] = $count;
        $records["recordsFiltered"] = $count;
        $records['data'] = array();

        $privacies->offset($offset)->limit($limit);
        foreach ($privacies->get() as $privacy) {
            $params = array(
               'checked'=> ($privacy->is_active == 'y' ? "checked" : ""),
               'getaction'=>'',
               'class'=>'',
               'id'=> $privacy->id
            );
            $records['data'][] = [
                'id'=>$privacy->id,
                'en_title'   =>  $privacy->en_title,
                'ar_title'   =>  $privacy->ar_title,
                
                'is_active'=>view('admin.layout.includes.switch', compact('params'))->render(),
                'action'=>view('admin.layout.includes.actions')->with(['id'=> $privacy->id], $privacy)->render(),
                'checkbox'=>view('admin.layout.includes.checkbox')->with('id',$privacy->id)->render(),
            ];
        }
        return $records;
    }
}
