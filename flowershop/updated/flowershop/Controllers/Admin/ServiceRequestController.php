<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServiceInquiry;

class ServiceRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $count = ServiceInquiry::count();
        return view('admin.pages.service-requests.list', compact('count'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $serviceRequest = ServiceInquiry::with('service')->find($id);
        if($serviceRequest){
            return view('admin.pages.service-requests.view', compact('serviceRequest'));
        }else{
            return redirect(route('admin.service-request.index'));
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
            ServiceInquiry::whereIn('id',explode(',',$request->ids))->delete();
            $content['status']=200;
            $content['message'] = "Service Request deleted successfully.";
            $content['count'] = ServiceInquiry::all()->count();
            return response()->json($content);
        }else{
            ServiceInquiry::where('id',$id)->delete();
            if(request()->ajax()){
                $content = array('status'=>200, 'message'=>"Service Request deleted successfully.", 'count' => ServiceInquiry::all()->count());
                return response()->json($content);
            }else{
                flash('Service Request deleted successfully.')->success();
                return redirect()->route('admin.service-request.index');
            }
        }
    }

    public function listing(Request $request)
    {
        extract($this->DTFilters($request->all()));
        $serviceRequests = ServiceInquiry::orderBy($sort_column,$sort_order);

        if( !empty($search) ) {
            $serviceRequests->where("first_name", "like", "%{$search}%")
                    ->orWhere("contact", "like", "%{$search}%")
                    ->orWhere("city", "like", "%{$search}%"); 
        }
        
        $count = $serviceRequests->count();
        $records["recordsTotal"] = $count;
        $records["recordsFiltered"] = $count;
        $records['data'] = array();

        $serviceRequests->offset($offset)->limit($limit);

        foreach ($serviceRequests->get() as $serviceRequest) {
            $params = array(
               'checked'=> ($serviceRequest->is_active == 'y' ? "checked" : ""),
               'getaction'=>'',
               'class'=>'',
               'id'=> $serviceRequest->id
            );
            $records['data'][] = [
                'id'            =>  $serviceRequest->id,
                'first_name'    =>  $serviceRequest->first_name,
                'contact'       =>  $serviceRequest->contact,
                'city'          =>  $serviceRequest->city,
                
                'action'=>view('admin.layout.includes.actions')->with(['id'=> $serviceRequest->id], $serviceRequest)->render(),
                'checkbox'=>view('admin.layout.includes.checkbox')->with('id',$serviceRequest->id)->render(),
            ];
        }

        return $records;
    }
}
