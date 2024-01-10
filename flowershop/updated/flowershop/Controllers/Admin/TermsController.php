<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TermRequest;
use Illuminate\Http\Request;
use App\Models\Term;

class TermsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $count = Term::count();
        return view('admin.pages.terms.list',compact('count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.terms.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TermRequest $request)
    {
        $terms = Term::create($request->all());
        if( $terms->save() ) {
            flash('Term & Condition details added successfully!')->success();
        } else {
            flash('Unable to add terms & condition. Please try again later.')->error();
        }
        return redirect(route('admin.terms.index'));
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
        $terms = Term::where('id',$id)->first();
        if($terms){
            return view('admin.pages.terms.edit', compact('terms'));
        } else{
            return redirect(route('admin.terms.index'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TermRequest $request, $id)
    {
        $terms = Term::find($id);
        if(!empty($request->action) && $request->action == 'change_status') {
            $content = ['status'=>204, 'message'=>"something went wrong"];
            if($terms->en_title || $terms->en_details || $terms->ar_title || $terms->ar_details) {
                $terms->is_active = $request->value;
                if($terms->save()) {
                    $content['status']=200;
                    $content['message'] = "Status updated successfully.";
                }
            }
            return response()->json($content);
        } else {
            $terms->fill($request->all());
            if( $terms->save() ) {
                flash('Terms & Condition details updated successfully!')->success();
            } else {
                flash('Unable to update terms & condition. Try again later')->error();
            }

            return redirect(route('admin.terms.index'));
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
            Term::whereIn('id',explode(',',$request->ids))->delete();
            $content['status']=200;
            $content['message'] = "Terms & Condition deleted successfully.";
            $content['count'] = Term::all()->count();
            return response()->json($content);
        }else{
            Term::where('id',$id)->delete();
            if(request()->ajax()){
                $content = array('status'=>200, 'message'=>"Terms & Condition deleted successfully.", 'count' => Term::all()->count());
                return response()->json($content);
            }else{
                flash('Terms & Condition deleted successfully.')->success();
                return redirect()->route('admin.terms.index');
            }
        }
    }

    public function listing(Request $request)
    {
        extract($this->DTFilters($request->all()));
        $terms = Term::orderBy($sort_column,$sort_order);

        if( !empty($search) ) {
            $terms->where("en_title", "like", "%{$search}%")
                    ->orWhere("ar_title", "like", "%{$search}%"); 
        }
        
        $count = $terms->count();
        $records["recordsTotal"] = $count;
        $records["recordsFiltered"] = $count;
        $records['data'] = array();

        $terms->offset($offset)->limit($limit);
        foreach ($terms->get() as $term) {
            $params = array(
               'checked'    => ($term->is_active == 'y' ? "checked" : ""),
               'getaction'  =>  '',
               'class'      =>  '',
               'id'         =>  $term->id
            );
            $records['data'][] = [
                'id'        =>  $term->id,
                'en_title'  =>  $term->en_title,
                'ar_title'  =>  $term->ar_title,
                
                'is_active' =>  view('admin.layout.includes.switch', compact('params'))->render(),
                'action'    =>  view('admin.layout.includes.actions')->with(['id'=> $term->id], $term)->render(),
                'checkbox'  =>  view('admin.layout.includes.checkbox')->with('id',$term->id)->render(),
            ];
        }
        return $records;
    }
}
