<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FranchiseRequests;
use App\Http\Requests\Frontend\FranchiseDetailsRequest;

class FranchiseRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('frontend.pages.franchisesrequests');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FranchiseDetailsRequest $request)
    {
        $request['custom_id'] = getUniqueString('franchise_requests');;
        $FranchiseRequests = FranchiseRequests::create($request->all());
        
        if($FranchiseRequests->save()){
            return redirect()->back();
        }else{
            return redirect()->route('home');
        }
    }
}
