<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.pages.users.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $request['custom_id'] = getUniqueString('users');
        $path = null;
        if( $request->has('profile') ) {
            $path = $request->file('profile')->store('profiles/users');
        }
        $user = User::create($request->all());
        $user->profile = $path;
        if( $user->save() ) {
            flash('User account created successfully!')->success();
        } else {
            flash('Unable to save avatar. Please try again later.')->error();
        }
        return redirect(route('admin.users.index'));
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
    public function edit(User $user)
    {
        return view('admin.pages.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        if(!empty($request->action) && $request->action == 'change_status') {
            $content = ['status'=>204, 'message'=>"something went wrong"];
            if($user->full_name || $user->email) {
                $user->is_active = $request->value;
                if($user->save()) {
                    $content['status']=200;
                    $content['message'] = "Status updated successfully.";
                }
            }
            return response()->json($content);
        } else {
            $user->fill($request->all());
            if( $request->has('profile') ) {
                if( $user->profile )
                    \Storage::delete($user->profile);
                $path = $request->file('profile')->store('profiles/users');
                $user->profile = $path;
            }
            if( $user->save() ) {
                flash('User details updated successfully!')->success();
            } else {
                flash('Unable to update user. Try again later')->error();
            }
            return redirect(route('admin.users.index'));
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
            User::whereIn('id',explode(',',$request->ids))->delete();
            $content['status']=200;
            $content['message'] = "User deleted successfully.";
            $content['count'] = User::all()->count();
            return response()->json($content);
        }else{
            User::where('id',$id)->delete();
            if(request()->ajax()){
                $content = array('status'=>200, 'message'=>"User deleted successfully.", 'count' => User::all()->count());
                return response()->json($content);
            }else{
                flash('User deleted successfully.')->success();
                return redirect()->route('admin.users.index');
            }
        }
    }

    public function listing(Request $request)
    {
        extract($this->DTFilters($request->all()));
        $users = User::select(['*'
                ,
                \DB::raw('CONCAT(first_name, " ", last_name) AS name')
            ])->orderBy($sort_column,$sort_order);

        if( !empty($search) ) {
            $users->where(\DB::raw('CONCAT(first_name, " ", last_name)'), "like", "%{$search}%")
                    ->orWhere("email", "like", "%{$search}%")
            ;
        }
        
        $count = $users->count();
        $records["recordsTotal"] = $count;
        $records["recordsFiltered"] = $count;
        $records['data'] = array();

        $users->offset($offset)->limit($limit);
        foreach ($users->get() as $user) {
            $params = array(
               'checked'    => ($user->is_active == 'y' ? "checked" : ""),
               'getaction'  =>  '',
               'class'      =>  '',
               'id'         =>  $user->id
            );
            $records['data'][] = [
                'id'                    =>  $user->id,
                'name'                  =>  $user->name,
                'email'                 =>  '<a href="mailto:'. $user->email .'" >' . $user->email . '</a>',
                'subscription_status'   =>  title_case($user->subscription_status),
                'is_free_account'       =>  title_case($user->is_free_account == 'y' ? 'Yes' : 'No'),
                'created_at'            =>  \Carbon\Carbon::parse($user->created_at)->format('d-m-Y'),
                
                'is_active' =>  view('admin.layout.includes.switch', compact('params'))->render(),
                'action'    =>  view('admin.layout.includes.actions')->with(['id'=> $user->id], $user)->render(),
                'checkbox'  =>  view('admin.layout.includes.checkbox')->with('id',$user->id)->render(),
            ];
        }
        return $records;
    }
}
