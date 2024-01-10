<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FaqRequest;
use Illuminate\Http\Request;
use App\Models\Faqs;

class FaqsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $count = Faqs::count();
        return view('admin.pages.faqs.list', compact('count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.faqs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FaqRequest $request)
    {
        $faqs = Faqs::create($request->all());
        if( $faqs->save() ) {
            flash('Faqs details added successfully')->success();
        } else {
            flash('Unable to add faqs. Try again later')->error();
        }
        return redirect(route('admin.faqs.index'));
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
        $faqs = Faqs::where('id',$id)->first();
        if($faqs){
            return view('admin.pages.faqs.edit', compact('faqs'));
        } else{
            return redirect(route('admin.faqs.index'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FaqRequest $request, $id)
    {
        $faq = Faqs::find($id);
        if(!empty($request->action) && $request->action == 'change_status') {
            $content = ['status'=>204, 'message'=>"something went wrong"];
            if($faq->en_question || $faq->en_answer || $faq->ar_question || $faq->ar_answer) {
                $faq->is_active = $request->value;
                if($faq->save()) {
                    $content['status']=200;
                    $content['message'] = "Status updated successfully.";
                }
            }
            return response()->json($content);
        } else {
            $faq->fill($request->all());
            if( $faq->save() ) {
                flash('Faqs details updated successfully!')->success();
            } else {
                flash('Unable to update faqs. Try again later')->error();
            }
            return redirect(route('admin.faqs.index'));
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
            Faqs::whereIn('id',explode(',',$request->ids))->delete();
            $content['status']=200;
            $content['message'] = "Faqs deleted successfully.";
            $content['count'] = Faqs::all()->count();
            return response()->json($content);
        }else{
            Faqs::where('id',$id)->delete();
            if(request()->ajax()){
                $content = array('status'=>200, 'message'=>"Faqs deleted successfully.", 'count' => Faqs::all()->count());
                return response()->json($content);
            }else{
                flash('Faqs deleted successfully.')->success();
                return redirect()->route('admin.faqs.index');
            }
        }
    }

    public function listing(Request $request)
    {
        extract($this->DTFilters($request->all()));
        $faqs = Faqs::orderBy($sort_column,$sort_order);

        if( !empty($search) ) {
            $faqs->where("en_question", "like", "%{$search}%")
                    ->orWhere("ar_question", "like", "%{$search}%"); 
        }
        
        $count = $faqs->count();
        $records["recordsTotal"] = $count;
        $records["recordsFiltered"] = $count;
        $records['data'] = array();

        $faqs->offset($offset)->limit($limit);
        foreach ($faqs->get() as $faq) {
            $params = array(
               'checked'=> ($faq->is_active == 'y' ? "checked" : ""),
               'getaction'=>'',
               'class'=>'',
               'id'=> $faq->id
            );
            $records['data'][] = [
                'id'=>$faq->id,
                'en_question'   =>  $faq->en_question,
                'ar_question'   =>  $faq->ar_question,
                'en_answer'     =>  $faq->en_answer,
                'ar_answer'     =>  $faq->ar_answer,
                
                'is_active'=>view('admin.layout.includes.switch', compact('params'))->render(),
                'action'=>view('admin.layout.includes.actions')->with(['id'=> $faq->id], $faq)->render(),
                'checkbox'=>view('admin.layout.includes.checkbox')->with('id',$faq->id)->render(),
            ];
        }
        return $records;
    }
}
