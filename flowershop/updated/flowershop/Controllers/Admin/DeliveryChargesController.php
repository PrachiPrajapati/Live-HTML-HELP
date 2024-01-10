<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DeliveryChargeRequest;
use App\Models\Country;
use App\Models\DeliveryCharge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeliveryChargesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $count = DeliveryCharge::count();
        return view('admin.pages.delivery-charges.list', compact('count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::where('is_active', 'y')->get();
        return view('admin.pages.delivery-charges.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DeliveryChargeRequest $request)
    {
        DeliveryCharge::updateOrCreate([
            'country_id'    =>  $request->country_id,
            'en_city'       =>  $request->en_city,
        ],[
            'added_by'          =>  Auth::id(),
            'minimum_amount'    =>  $request->minimum_amount,
            'charges'           =>  $request->charges,
            'ar_city'           =>  $request->ar_city,
        ]);
        flash('Charges details added successfully!')->success();
        return redirect(route('admin.delivery-charges.index'));
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
    public function edit(DeliveryCharge $deliveryCharge)
    {
        $countries = Country::where('is_active', 'y')->get();
        return view('admin.pages.delivery-charges.edit', compact('countries', 'deliveryCharge'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DeliveryChargeRequest $request, DeliveryCharge $deliveryCharge)
    {
        if(!empty($request->action) && $request->action == 'change_status') {
            $content = ['status'=>204, 'message'=>"something went wrong"];
            if($deliveryCharge->en_city || $deliveryCharge->ar_city) {
                $deliveryCharge->is_active = $request->value;
                if($deliveryCharge->save()) {
                    $content['status']=200;
                    $content['message'] = "Status updated successfully.";
                }
            }
            return response()->json($content);
        } else {
            $deliveryCharge->fill($request->all());

            if( $deliveryCharge->save() ) {
                flash('Delivery charges updated successfully!')->success();
            } else {
                flash('Unable to update delivey charges. Try again later')->error();
            }

            return redirect(route('admin.delivery-charges.index'));
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
            DeliveryCharge::whereIn('id',explode(',',$request->ids))->delete();
            $content['status']=200;
            $content['message'] = "Delivery charges deleted successfully.";
            $content['count'] = DeliveryCharge::all()->count();
            return response()->json($content);
        }else{
            DeliveryCharge::where('id',$id)->delete();
            if(request()->ajax()){
                $content = array('status'=>200, 'message'=>"Delivery charges deleted successfully.", 'count' => DeliveryCharge::all()->count());
                return response()->json($content);
            }else{
                flash('Delivery charges deleted successfully.')->success();
                return redirect()->route('admin.delivery-charges.index');
            }
        }
    }

        public function csvUpload(Request $request)
        {
            $file = NULL;
            $status = false;
            $counter = 0;
            $message = "No new details found";
            if( $request->has('csvFile') ) {
                $path = $request->file('csvFile');
                // Open File
                    $handle = fopen($path,'r');
                    if( $handle !== false ) {
                        $readLine = fgetcsv($handle,1000,',');
                        while ( ($readLine = fgetcsv($handle,1000,',')) !== false ) {
                            $country = Country::where('en_name', $readLine[0])->first();
                            if( !empty($country) && count($readLine) == 5 ) {
                                $charge = DeliveryCharge::updateOrCreate([
                                    'country_id'    =>  $country->id,
                                    'en_city'       =>  $readLine[1],
                                ],[
                                    'added_by'          =>  Auth::id(),
                                    'ar_city'           =>  $readLine[2],
                                    'minimum_amount'    =>  $readLine[3],
                                    'charges'           =>  $readLine[4],
                                ]);

                                if( $charge->wasRecentlyCreated )
                                    $counter++;
                                $status = true;
                            } else {
                                $message = "Unable to read file, please upload proper file.";
                            }
                        }
                    } else {
                        $message = "Unable to read file, please upload proper file.";
                    }
            }
            if( $status = true && $counter >= 1) {
                $title = 'delivery charge';
                if( $counter >= 2 )
                    $title = 'delivery charges';
                flash($counter.' '.$title.' added successfully!')->success();
            } else {
                flash($message)->important();
            }
            return redirect(route('admin.delivery-charges.index'));
        }

    public function listing(Request $request)
    {
        extract($this->DTFilters($request->all()));
        $roles = DeliveryCharge::orderBy($sort_column,$sort_order);

        if( !empty($search) ) {
            $roles->where("en_city", "like", "%{$search}%")
                    ->orWhere("minimum_amount", "like", "%{$search}%")
                    ->orWhere("charges", "like", "%{$search}%")
            ;
        }
        
        $count = $roles->count();
        $records["recordsTotal"] = $count;
        $records["recordsFiltered"] = $count;
        $records['data'] = array();

        $roles->offset($offset)->limit($limit);
        foreach ($roles->get() as $role) {
            $params = array(
               'checked'=> ($role->is_active == 'y' ? "checked" : ""),
               'getaction'=>'',
               'class'=>'',
               'id'=> $role->id
            );
            $records['data'][] = [
                'id'=>$role->id,

                'en_city'=>$role->en_city,
                'minimum_amount'=>$role->minimum_amount,
                'charges'=>$role->charges,
                
                'is_active'=>view('admin.layout.includes.switch', compact('params'))->render(),
                'action'=>view('admin.layout.includes.actions')->with(['id'=> $role->id], $role)->render(),
                'checkbox'=>view('admin.layout.includes.checkbox')->with('id',$role->id)->render(),
            ];
        }
        return $records;
    }
}
