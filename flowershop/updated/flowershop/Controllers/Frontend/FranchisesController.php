<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Franchises;
use App\Http\Requests\Frontend\FranchisRequest;

class FranchisesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $franchises = Franchises::where('is_active','y')->get();
        return view('frontend.pages.franchises',compact('franchises'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FranchisRequest $request)
    {
        $request['custom_id']   =   getUniqueString('franchises');
        
        $franchises = Franchises::create($request->all());
        if($franchises->save()){
            return redirect()->back();
        } else{
            return redirect(route('home'));
        }

    }

}
