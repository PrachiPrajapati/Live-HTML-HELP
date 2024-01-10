<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BlogRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\NewsBlog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $count = NewsBlog::count();
        return view('admin.pages.blogs.list', compact('count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.blogs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogRequest $request)
    {
        $slug = str_slug($request->en_title);
        $count = NewsBlog::withTrashed()->where('slug', "like", "%{$slug}%")->count();

        $request['added_by'] = Auth::id();
        $request['slug'] = $slug;
        if( $count != 0 ) {
            $request['slug'] = $slug . '-' . $count;
        }
        $en_path = $ar_path = null;
        if( $request->has('en_banner') ) {
            $en_path = $request->file('en_banner')->store('blog/banners');
        }

        if( $request->has('ar_banner') ) {
            $ar_path = $request->file('ar_banner')->store('blog/banners');
        }

        $news = NewsBlog::create($request->all());
        $news->en_banner = $en_path;
        $news->ar_banner = $ar_path;
        $news->save();

        flash('Blog added successfully!')->success();
        return redirect(route('admin.blogs.index'));
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
    public function edit(NewsBlog $blog)
    {
        return view('admin.pages.blogs.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BlogRequest $request, NewsBlog $blog)
    {
        if(!empty($request->action) && $request->action == 'change_status') {
            $content = ['status'=>204, 'message'=>"something went wrong"];
            if($blog->en_title || $blog->ar_title) {
                $blog->is_active = $request->value;
                if($blog->save()) {
                    $content['status']=200;
                    $content['message'] = "Status updated successfully.";
                }
            }
            return response()->json($content);
        } else {

            $blog->fill($request->all());
            if (array_key_exists('en_title', $blog->getDirty())) {
                $slug = str_slug($request->en_title);
                $count = NewsBlog::withTrashed()->where('id', '<>', $blog->id)->where('slug', "like", "%{$slug}%")->count();
                $slug = $slug;
                if( $count != 0 ) {
                    $request['slug'] = $blog->slug . '-' . $count;
                }
                $blog->slug = $slug;
            }

            if( $request->has('en_banner') ) {
                if( $blog->en_banner )
                    Storage::delete($blog->en_banner);
                $path = $request->file('en_banner')->store('blog/banners');
                $blog->en_banner = $path;
            }
            if( $request->has('ar_banner') ) {
                if( $blog->ar_banner )
                    Storage::delete($blog->ar_banner);
                $path = $request->file('ar_banner')->store('blog/banners');
                $blog->ar_banner = $path;
            }
            if( $blog->save() ) {
                flash('Blog details updated successfully!')->success();
            } else {
                flash('Unable to update blog. Try again later')->error();
            }

            return redirect(route('admin.blogs.index'));
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
            $en_images = NewsBlog::whereIn('id', explode(',', $request->ids))->pluck('en_banner')->toArray();
            $ar_images = NewsBlog::whereIn('id', explode(',', $request->ids))->pluck('ar_banner')->toArray();
            foreach ($en_images as $en_image) {
                if(!empty($en_image) && Storage::exists($en_image)){
                  Storage::delete($en_image);
                }
            }
            foreach ($ar_images as $ar_image) {
                if(!empty($ar_image) && Storage::exists($ar_image)){
                  Storage::delete($ar_image);
                }
            }
            NewsBlog::whereIn('id',explode(',',$request->ids))->delete();
            $content['status']=200;
            $content['message'] = "Blogs deleted successfully.";
            $content['count'] = NewsBlog::all()->count();
            return response()->json($content);
        }else{
            $blog = NewsBlog::where('id',$id)->first();
            if( $blog->en_banner ) {
                if( Storage::exists($blog->en_banner) ){
                    Storage::delete($blog->en_banner);;
                }
            }
            if( $blog->ar_banner ) {
                if( Storage::exists($blog->ar_banner) ){
                    Storage::delete($blog->ar_banner);;
                }
            }
            $blog->delete();
            if(request()->ajax()){
                $content = array('status'=>200, 'message'=>"Blog deleted successfully.", 'count' => NewsBlog::all()->count());
                return response()->json($content);
            }else{
                flash('Blog deleted successfully.')->success();
                return redirect()->route('admin.blogs.index');
            }
        }
    }

    public function listing(Request $request)
    {
        extract($this->DTFilters($request->all()));
        $users = NewsBlog::orderBy($sort_column,$sort_order);

        if( !empty($search) ) {
            $users->where('en_title', "like", "%{$search}%")
                    ->orWhere("ar_title", "like", "%{$search}%")
                    ->orWhere("en_short_description", "like", "%{$search}%")
                    ->orWhere("ar_description", "like", "%{$search}%")
            ;
        }
        
        $count = $users->count();
        $records["recordsTotal"] = $count;
        $records["recordsFiltered"] = $count;
        $records['data'] = array();

        $users->offset($offset)->limit($limit);
        foreach ($users->get() as $user) {
            $params = array(
               'checked'=> ($user->is_active == 'y' ? "checked" : ""),
               'getaction'=>'',
               'class'=>'',
               'id'=> $user->id
            );
            $records['data'][] = [
                'id'=>$user->id,
                'en_title'=>$user->en_title,
                'en_short_description'=>$user->en_short_description,
                
                'created_at'=>\Carbon\Carbon::parse($user->created_at)->format('d-m-Y'),
                
                'is_active'=>view('admin.layout.includes.switch', compact('params'))->render(),
                'action'=>view('admin.layout.includes.actions')->with(['id'=> $user->id], $user)->render(),
                'checkbox'=>view('admin.layout.includes.checkbox')->with('id',$user->id)->render(),
            ];
        }
        return $records;
    }
}
