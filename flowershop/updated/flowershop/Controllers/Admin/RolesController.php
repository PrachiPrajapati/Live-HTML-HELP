<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleRequest;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $count = Admin::where('type', 'role')->count();
        return view('admin.pages.roles.list', compact('count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::where('is_display','y')->orderBy('sequence','asc')->get();
        return view('admin.pages.roles.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        $permissions = [];
        if(!empty($request->roles)) {
            foreach ($request->roles as $id => $role) {
                if($id == 1) {
                    $permissions[$id] = ['permissions' => 'access'];
                } else {
                    $permissions[$id] = ['permissions' => implode(',', $role['permissions'])];
                }
            }
        }
        $permissions[1] = ['permissions' => 'access'];
        $request['permissions'] = serialize($permissions);
        $password = '12345678';
        // $password = str_random(config('utility.default_password'));
        $request['password'] = \Hash::make($password);
        $request['type'] = "role";

        $admin = Admin::create($request->all());
        $path = "";
        if( $request->has('profile') ) {
            $path = $request->file('profile')->store('profiles/admin');
        }
        if( $admin->save() ) {
            flash('Account created successfully!')->success();
        } else {
            flash('Unable to save avatar. Please try again later.')->error();
        }
        return redirect(route('admin.roles.index'));

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
    public function edit(Admin $role)
    {
        $roles = Role::where('is_display','y')->orderBy('sequence','asc')->get();
        return view('admin.pages.roles.edit', compact('role', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, Admin $role)
    {
        if(!empty($request->action) && $request->action == 'change_status') {
            $content = ['status'=>204, 'message'=>"something went wrong"];
            if($role->full_name || $role->email) {
                $role->is_active = $request->value;
                if($role->save()) {
                    $content['status']=200;
                    $content['message'] = "Status updated successfully.";
                }
            }
            return response()->json($content);
        } else {
            $permissions = [];
            if(!empty($request->roles)) {
                foreach ($request->roles as $id => $user_role) {
                    if($id == 1) {
                        $permissions[$id] = ['permissions' => 'access'];
                    } else {
                        $permissions[$id] = ['permissions' => implode(',', $user_role['permissions'])];
                    }
                }
            }
            $permissions[1] = ['permissions' => 'access'];
            $request['permissions'] = serialize($permissions);
            unset($request['email']);
            $role->fill($request->all());
            if($role->save()) {
                flash('Role details updated successfully!')->success();
            } else {
                flash('Enable to update! Try again later')->error();
            }
            return redirect(route('admin.roles.index'));
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
            Admin::where('type', 'role')->whereIn('id',explode(',',$request->ids))->delete();
            $content['status']=200;
            $content['message'] = "User deleted successfully.";
            $content['count'] = Admin::where('type', 'role')->all()->count();
            return response()->json($content);
        }else{
            Admin::where('type', 'role')->where('id',$id)->delete();
            if(request()->ajax()){
                $content = array('status'=>200, 'message'=>"User deleted successfully.", 'count' => Admin::where('type', 'role')->count());
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
        $roles = Admin::where('type', 'role')->where('id', '<>', Auth::id())->orderBy($sort_column,$sort_order);

        if( !empty($search) ) {
            $roles->where("full_name", "like", "%{$search}%")
                    ->orWhere("contact", "like", "%{$search}%")
                    ->orWhere("email", "like", "%{$search}%")
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
                'full_name'=>$role->full_name,
                'email'=>'<a href="mailto:'. $role->email .'" >' . $role->email . '</a>',
                'contact'=>'<a href="tel:'. $role->contact .'" >' . $role->contact . '</a>',
                
                'is_active'=>view('admin.layout.includes.switch', compact('params'))->render(),
                'action'=>view('admin.layout.includes.actions')->with(['id'=> $role->id], $role)->render(),
                'checkbox'=>view('admin.layout.includes.checkbox')->with('id',$role->id)->render(),
            ];
        }
        return $records;
    }
}
