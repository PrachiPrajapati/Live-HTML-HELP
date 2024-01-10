<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CountryRequest;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class CountriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $count = Country::count();
        return view('admin.pages.countries.list', compact('count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.countries.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CountryRequest $request)
    {
        Country::updateorCreate([
            'en_name'   =>  $request->en_name,
        ],[
            'ar_name'   =>  $request->ar_name,
            'url'       =>  $request->url,
            'added_by'  =>  Auth::id(),
        ]);

        flash('Country details added / updated successfully')->success();
        return redirect(route('admin.countries.index'));
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
    public function edit(Country $country)
    {
        return view('admin.pages.countries.edit', compact('country'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CountryRequest $request, Country $country)
    {
        if(!empty($request->action) && $request->action == 'change_status') {
            $content = ['status'=>204, 'message'=>"something went wrong"];
            if($country->en_name || $country->ar_name) {
                $country->is_active = $request->value;
                if($country->save()) {
                    $content['status']=200;
                    $content['message'] = "Status updated successfully.";
                }
            }
            return response()->json($content);
        } else {
            $country->fill($request->all());

            if( $country->save() ) {
                flash('Country details updated successfully!')->success();
            } else {
                flash('Unable to update country. Try again later')->error();
            }

            return redirect(route('admin.countries.index'));
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
            Country::whereIn('id',explode(',',$request->ids))->delete();
            $content['status']=200;
            $content['message'] = "Countries deleted successfully.";
            $content['count'] = Country::all()->count();
            return response()->json($content);
        }else{
            Country::where('id',$id)->delete();
            if(request()->ajax()){
                $content = array('status'=>200, 'message'=>"Country deleted successfully.", 'count' => Country::all()->count());
                return response()->json($content);
            }else{
                flash('Country deleted successfully.')->success();
                return redirect()->route('admin.countries.index');
            }
        }
    }

    public function csvUpload(Request $request)
    {
        $file = NULL;
        $status = false;
        $counter = 0;
        $message = "No new cities found";
        if( $request->has('csvFile') ) {
            $path = $request->file('csvFile');
            // Open File
                $handle = fopen($path,'r');
                if( $handle !== false ) {
                    $readLine = fgetcsv($handle,1000,',');
                    while ( ($readLine = fgetcsv($handle,1000,',')) !== false ) {
                        if( !empty($readLine[0]) && !empty($readLine[1]) && !empty($readLine[2]) ) {
                            $country = Country::updateOrCreate([
                                'en_name'   =>  $readLine[0],
                            ],['added_by'   =>  Auth::id(),'ar_name'   =>  $readLine[1],'url'   =>  $readLine[2]]);

                            if( $country->wasRecentlyCreated )
                                $counter++;
                        }
                    }
                    $status = true;
                } else {
                    $message = "Unable to read file, please upload proper file.";
                }
        }
        if( $status = true && $counter >= 1) {
            $title = 'country';
            if( $counter >= 2 )
                $title = 'countries';
            flash($counter.' '.$title.' added successfully!')->success();
        } else {
            flash($message)->important();
        }
        return redirect(route('admin.countries.index'));
    }

    //SAMPLE CSV DOWNLOAD
    public function csvDownload(Request $request)
    {
        $data = [
            [
                'en_name'   =>  'india',
                'ar_name'   =>  'alhind',
                'url'       =>  'www.flowershop.com/countries/india',
            ],
            [
                'en_name'   =>  'US',
                'ar_name'   =>  'nahn',
                'url'       =>  'www.flowershop.com/countries/us',
            ]
        ];
           
        $filename = "sample.csv";
        $handle = fopen($filename, 'w+');
        fputcsv($handle, array('en_name', 'ar_name', 'url'));

        foreach($data as $row) {
            fputcsv($handle, array($row['en_name'], $row['ar_name'], $row['url']));
        }
        fclose($handle);

        $headers = array(
            'Content-Type' => 'text/csv',
        );

        return Response::download($filename, 'sample.csv', $headers);
    }

    public function listing(Request $request)
    {
        extract($this->DTFilters($request->all()));
        $roles = Country::orderBy($sort_column,$sort_order);

        if( !empty($search) ) {
            $roles->where("en_name", "like", "%{$search}%")
                    ->orWhere("ar_name", "like", "%{$search}%")
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

                'en_name'=>$role->en_name,
                'ar_name'=>$role->ar_name,
                
                'is_active'=>view('admin.layout.includes.switch', compact('params'))->render(),
                'action'=>view('admin.layout.includes.actions')->with(['id'=> $role->id], $role)->render(),
                'checkbox'=>view('admin.layout.includes.checkbox')->with('id',$role->id)->render(),
            ];
        }
        return $records;
    }
}
