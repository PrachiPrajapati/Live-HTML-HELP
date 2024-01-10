<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FranchiseRequests;
use App\Http\Requests\Admin\FranchiseDetailsRequest;

class FranchiseRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $count = FranchiseRequests::count();
        return view('admin.pages.Franchise-Requests.list', compact('count'));
    }

    public function show($id)
    {
        $FranchiseRequest = FranchiseRequests::find($id);
        if($FranchiseRequest){
            return view('admin.pages.Franchise-Requests.view', compact('FranchiseRequest'));
        }
        return redirect()->route('admin.franchiserequests.index');
    }

    public function destroy(Request $request, $id)
    {
        if(!empty($request->action) && $request->action == 'delete_all'){
            $content = ['status'=>204, 'message'=>"something went wrong"];
            FranchiseRequests::whereIn('id',explode(',',$request->ids))->delete();
            $content['status']=200;
            $content['message'] = "Franchise Request deleted successfully.";
            $content['count'] = FranchiseRequests::all()->count();
            return response()->json($content);
        }else{
            FranchiseRequests::where('id',$id)->delete();
            if(request()->ajax()){
                $content = array('status'=>200, 'message'=>"Franchise Request deleted successfully.", 'count' => FranchiseRequests::all()->count());
                return response()->json($content);
            }else{
                flash('Franchise Request deleted successfully.')->success();
                return redirect()->route('admin.franchiserequests.index');
            }
        }
    }

    public function listing(Request $request)
    {
        extract($this->DTFilters($request->all()));
        $FranchiseRequests = FranchiseRequests::orderBy($sort_column,$sort_order);

        if( !empty($search) ) {
            $FranchiseRequests->where("name", "like", "%{$search}%")
                    ->orWhere("email", "like", "%{$search}%")
                    ->orWhere("phone", "like", "%{$search}%"); 
        }
        
        $count = $FranchiseRequests->count();
        $records["recordsTotal"] = $count;
        $records["recordsFiltered"] = $count;
        $records['data'] = array();

        $FranchiseRequests->offset($offset)->limit($limit);
        foreach ($FranchiseRequests->get() as $FranchiseRequest) {
            $params = array(
               'checked'    =>  ($FranchiseRequest->is_active == 'y' ? "checked" : ""),
               'getaction'  =>  '',
               'class'      =>  '',
               'id'         =>  $FranchiseRequest->id
            );
            $records['data'][] = [
                'id'        =>  $FranchiseRequest->id,
                'name'      =>  $FranchiseRequest->name,
                'email'     =>  $FranchiseRequest->email,
                'phone'     =>  $FranchiseRequest->phone,
                'action'    =>  view('admin.layout.includes.actions')->with(['id'=> $FranchiseRequest->id], $FranchiseRequest)->render(),
                'checkbox'  =>  view('admin.layout.includes.checkbox')->with('id',$FranchiseRequest->id)->render(),
            ];
        }
        return $records;
    }
}
