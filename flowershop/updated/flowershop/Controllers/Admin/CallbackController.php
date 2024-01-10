<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Callback;

class CallbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $count = Callback::count();
        return view('admin.pages.callbacks.list', compact('count'));
    }

    public function show($id)
    {
        $callback = Callback::find($id);
        return view('admin.pages.callbacks.view', compact('callback'));
    }

    public function destroy(Request $request, $id)
    {
        if(!empty($request->action) && $request->action == 'delete_all'){
            $content = ['status'=>204, 'message'=>"something went wrong"];
            Callback::whereIn('id',explode(',',$request->ids))->delete();
            $content['status']=200;
            $content['message'] = "Callback details deleted successfully.";
            $content['count'] = Callback::all()->count();
            return response()->json($content);
        }else{
            Callback::where('id',$id)->delete();
            if(request()->ajax()){
                $content = array('status'=>200, 'message'=>"Callback details deleted successfully.", 'count' => Callback::all()->count());
                return response()->json($content);
            }else{
                flash('Callback details deleted successfully.')->success();
                return redirect()->route('admin.callback.index');
            }
        }
    }

    public function listing(Request $request)
    {
        extract($this->DTFilters($request->all()));
        $callbacks = Callback::orderBy($sort_column,$sort_order);

        if( !empty($search) ) {
            $callbacks->where("name", "like", "%{$search}%")
                    ->orWhere("contact", "like", "%{$search}%"); 
        }
        
        $count = $callbacks->count();
        $records["recordsTotal"] = $count;
        $records["recordsFiltered"] = $count;
        $records['data'] = array();

        $callbacks->offset($offset)->limit($limit);
        foreach ($callbacks->get() as $callback) {
            $params = array(
               'checked'        =>  ($callback->is_active == 'y' ? "checked" : ""),
               'getaction'      =>  '',
               'class'          =>  '',
               'id'             =>  $callback->id
            );
            $records['data'][] = [
                'id'        =>  $callback->id,
                'name'      =>  $callback->name,
                'contact'   =>  $callback->contact,
                
                'action'=>view('admin.layout.includes.actions')->with(['id'=> $callback->id], $callback)->render(),
                'checkbox'=>view('admin.layout.includes.checkbox')->with('id',$callback->id)->render(),
            ];
        }
        return $records;
    }
}
