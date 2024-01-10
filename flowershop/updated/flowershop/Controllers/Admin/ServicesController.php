<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\ServicesShowcase;
use App\Http\Requests\Admin\ServiceRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $count = Service::count();
        return view('admin.pages.services.list', compact('count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.services.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceRequest $request)
    {
        $custom_id = getUniqueString('services');
        $request['custom_id'] = $custom_id;

        $Insertdata = [];
        $slug  = str_slug($request->en_title);
        $count = Service::withTrashed()->where('slug', "like", "%{$slug}%")->count();
        $request['slug'] = $slug;
        if( $count != 0 ) {
            $request['slug'] = $slug . '-' . $count;
        }

        $en_path = $en_section_1_path = $en_section_2_path = $ar_path = $ar_section_1_path = $ar_section_2_path  = $image_showcase_path = null;

        $data = $request->all();  
        
        if( $request->has('en_banner') ) {
            $en_path = $request->file('en_banner')->store('service/banners');
        }
        if( $request->has('en_section_1_image') ) {
            $en_section_1_path = $request->file('en_section_1_image')->store('service/banners');
        }
        if( $request->has('en_section_2_image') ) {
            $en_section_2_path = $request->file('en_section_2_image')->store('service/banners');
        }
        if( $request->has('ar_banner') ) {
            $ar_path = $request->file('ar_banner')->store('service/banners');
        }
        if( $request->has('ar_section_1_image') ) {
            $ar_section_1_path = $request->file('ar_section_1_image')->store('service/banners');
        }
        if( $request->has('ar_section_2_image') ) {
            $ar_section_2_path = $request->file('ar_section_2_image')->store('service/banners');
        }

        $service = Service::create($request->all());
        $service->en_banner = $en_path;
        $service->ar_banner = $ar_path;
        $service->en_section_1_image = $en_section_1_path;
        $service->en_section_2_image = $en_section_2_path;
        $service->ar_section_1_image = $ar_section_1_path;
        $service->ar_section_2_image = $ar_section_2_path;
        $service->save();

        $showcase   = new ServicesShowcase;
        $service_id = Service::select('id')->where('custom_id',$request->custom_id)->first();

        if( $request->has('image_showcase'))
        {
            for($i = 0; $i < count($data['en_title_showcase']); $i++)
            {
                $image_showcase_path = $request['image_showcase'][$i]->store('service/showcase');

                $Insertdata[] = array(
                    'custom_id'    => getUniqueString('services_showcases'),
                    'service_id'   => $service_id['id'],
                    'en_title'     => $data['en_title_showcase'][$i],
                    'ar_title'     => $data['ar_title_showcase'][$i],
                    'image'        => $image_showcase_path,
                    'created_at'   => \Carbon\Carbon::now(),
                    'updated_at'   => \Carbon\Carbon::now(),
                );
            }
            ServicesShowcase::insert($Insertdata);
        }

        if($service->save()){
            flash('Event added successfully!')->success();
        } else{
            flash('Unable to add event. Try again later')->error();
        }
        return redirect(route('admin.services.index'));
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
        $service = Service::find($id);
        if($service){
            $showcases = ServicesShowcase::with('service')->where('service_id',$service->id)->get();
            $count = 0;
            return view('admin.pages.services.edit',compact('service','showcases','count'));
        }
        return redirect()->route('admin.services.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ServiceRequest $request, $id)
    {
        $service = Service::find($id);
        if(!empty($request->action) && $request->action == 'change_status') {
            $content = ['status'=>204, 'message'=>"something went wrong"];
            if($service->en_title || $service->ar_title) {
                $service->is_active = $request->value;
                if($service->save()) {
                    $content['status']=200;
                    $content['message'] = "Status updated successfully.";
                }
            }
            return response()->json($content);
        }
        else 
        {  
            $data = $request->all();   
            $service->fill($request->all());
            if (array_key_exists('en_title', $service->getDirty())) 
            {
                $slug  = str_slug($request->en_title);
                $count = Service::withTrashed()->where('id', '<>', $service->id)->where('slug', "like", "%{$slug}%")->count();
                $slug  = $slug;
                if( $count != 0 ) {
                    $request['slug'] = $service->slug . '-' . $count;
                }
                $service->slug = $slug;
            }

            if(Storage::exists('/service/banners'))
            {   
                if( $request->has('en_banner') ) {
                    if( $service->en_banner ){
                       \Storage::delete($service->en_banner);
                    }
                    $path = $request->file('en_banner')->store('service/banners');
                    $service->en_banner = $path;
                }

                if( $request->has('ar_banner') ) {
                    if( $service->ar_banner )
                        \Storage::delete($service->ar_banner);
                    $path = $request->file('ar_banner')->store('service/banners');
                    $service->ar_banner = $path;
                }

                if( $request->has('en_section_1_image') ) {
                    if( $service->en_section_1_image )
                        \Storage::delete($service->en_section_1_image);
                    $path = $request->file('en_section_1_image')->store('service/banners');
                    $service->en_section_1_image = $path;
                }

                if( $request->has('ar_section_1_image') ) {
                    if( $service->ar_section_1_image )
                        \Storage::delete($service->ar_section_1_image);
                    $path = $request->file('ar_section_1_image')->store('service/banners');
                    $service->ar_section_1_image = $path;
                }

                if( $request->has('en_section_2_image') ) {
                    if( $service->en_section_2_image )
                        \Storage::delete($service->en_section_2_image);
                    $path = $request->file('en_section_2_image')->store('service/banners');
                    $service->en_section_2_image = $path;
                }

                if( $request->has('ar_section_2_image') ) {
                    if( $service->ar_section_2_image )
                        \Storage::delete($service->ar_section_2_image);
                    $path = $request->file('ar_section_2_image')->store('service/banners');
                    $service->ar_section_2_image = $path;
                }
            }
            
            $existing_items = ServicesShowcase::pluck('custom_id')->toArray();    

            if($data['image_showcase'] || $request->has('custom_id'))
            {   
                if($request->has('custom_id')){
                    $custom_id = $data['custom_id'];
                }

                foreach ($data['en_title_showcase'] as $key => $value) {
                    $en_title[] = $data['en_title_showcase'][$key]; 
                } 

                foreach ($data['ar_title_showcase'] as $key => $value) {
                    $ar_title[] = $data['ar_title_showcase'][$key];
                }

                foreach ($data['image_showcase'] as $key => $value) {
                    $showcase_image[] = $data['image_showcase'][$key];
                }

                for($i=0; $i<count($data['image_showcase']); $i++)
                {   
                    if( $request->has('custom_id') && in_array($custom_id[$i], $existing_items) && gettype($custom_id[$i]) == 'string') {  
                        $custom_id = $custom_id[$i];
                    } else {
                        $custom_id = getUniqueString('services_showcases', 'custom_id');
                    }

                    $showcase_item = ServicesShowcase::updateOrCreate([
                            'service_id'   => $id,
                            'custom_id'    => $custom_id,
                        ],[
                            'en_title'     => $en_title[$i],
                            'ar_title'     => $ar_title[$i], 
                            'image'        => $showcase_image[$i]->store('service/showcase'),
                        ]);

                   $not_to_delete_item[] = $showcase_item->custom_id; 
                }
            } else{
                 $not_to_delete_item[] = null;
            }
            
            // Delete
            ServicesShowcase::where('service_id',$id)->whereNotIn('custom_id', $not_to_delete_item)->delete();  
                
            if( $service->save() ) {
                flash('Event details updated successfully!')->success();
            } else {
                flash('Unable to update event. Try again later')->error();
            }
            return redirect()->route('admin.services.index');
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
            $serviecs = Service::whereIn('id',explode(',',$request->ids))->get();
            foreach ($serviecs as $key => $service) {
                if(!empty($service->en_banner) && Storage::exists($service->en_banner)){
                    Storage::delete($service->en_banner);
                }
                if(!empty($service->ar_banner) && Storage::exists($service->ar_banner)){
                    Storage::delete($service->ar_banner);
                }
                if(!empty($service->en_section_1_image) && Storage::exists($service->en_section_1_image)){
                    Storage::delete($service->en_section_1_image);
                }
                if(!empty($service->ar_section_1_image) && Storage::exists($service->ar_section_1_image)){
                    Storage::delete($service->ar_section_1_image);
                }
                if(!empty($service->en_section_2_image) && Storage::exists($service->en_section_2_image)){
                    Storage::delete($service->en_section_2_image);
                }
                if(!empty($service->ar_section_2_image) && Storage::exists($service->ar_section_2_image)){
                    Storage::delete($service->ar_section_2_image);
                }
                $services_showcase_images = ServicesShowcase::where('service_id', $service->id)->pluck('image')->toArray();
                foreach ($services_showcase_images as $image) {
                    if(!empty($image) && Storage::exists($image)){
                        Storage::delete($image);
                    }
                }
                ServicesShowcase::where('service_id', $service->id)->delete();
                $service->delete();
            }
            $content['status']=200;
            $content['message'] = "Events deleted successfully.";
            $content['count'] = Service::all()->count();
            return response()->json($content);
        }else{
            $service = Service::where('id',$id)->firstOrFail();
            if(!empty($service->en_banner) && Storage::exists($service->en_banner)){
                Storage::delete($service->en_banner);
            }
            if(!empty($service->ar_banner) && Storage::exists($service->ar_banner)){
                Storage::delete($service->ar_banner);
            }
            if(!empty($service->en_section_1_image) && Storage::exists($service->en_section_1_image)){
                Storage::delete($service->en_section_1_image);
            }
            if(!empty($service->ar_section_1_image) && Storage::exists($service->ar_section_1_image)){
                Storage::delete($service->ar_section_1_image);
            }
            if(!empty($service->en_section_2_image) && Storage::exists($service->en_section_2_image)){
                Storage::delete($service->en_section_2_image);
            }
            if(!empty($service->ar_section_2_image) && Storage::exists($service->ar_section_2_image)){
                Storage::delete($service->ar_section_2_image);
            }
            $services_showcase_images = ServicesShowcase::where('service_id', $service->id)->pluck('image')->toArray();
            foreach ($services_showcase_images as $image) {
                if(!empty($image) && Storage::exists($image)){
                    Storage::delete($image);
                }
            }
            ServicesShowcase::where('service_id', $service->id)->delete();
            $service->delete();
            if(request()->ajax()){
                $content = array('status'=>200, 'message'=>"Event deleted successfully.", 'count' => Service::all()->count());
                return response()->json($content);
            }else{
                flash('Event deleted successfully.')->success();
                return redirect()->route('admin.services.index');
            }
        }
    }

    public function listing(Request $request)
    {
        extract($this->DTFilters($request->all()));
        $services = Service::orderBy($sort_column,$sort_order);

        if( !empty($search) ) {
            $services->where('en_title', "like", "%{$search}%")
                    ->orWhere("ar_title", "like", "%{$search}%");
        }
        
        $count = $services->count();
        $records["recordsTotal"] = $count;
        $records["recordsFiltered"] = $count;
        $records['data'] = array();

        $services->offset($offset)->limit($limit);
        foreach ($services->get() as $service) {
            $params = array(
               'checked'    => ($service->is_active == 'y' ? "checked" : ""),
               'getaction'  =>'',
               'class'      =>'',
               'id'         => $service->id,
            );

            $records['data'][] = [
                'id'            =>  $service->id,
                'en_title'      =>  $service->en_title,
                'en_description'=>  $service->en_description,
                'created_at'    =>  \Carbon\Carbon::parse($service->created_at)->format('d-m-Y'),
                
                'is_active'     =>  view('admin.layout.includes.switch', compact('params'))->render(),
                'action'        =>  view('admin.layout.includes.actions')->with(['id'=> $service->id], $service)->render(),
                'checkbox'      =>  view('admin.layout.includes.checkbox')->with('id',$service->id)->render(),
            ];
        }
        return $records;
    }
}
