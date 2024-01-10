<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Frontend\LoginRequest;
use App\Http\Requests\Frontend\SignupRequest;
use App\Http\Requests\Frontend\ForgotPasswordRequest;
use App\Http\Requests\Frontend\EditProfileRequest;
use App\Http\Requests\Frontend\ChangePasswordRequest;
use Illuminate\Support\Facades\Mail;
use App\Models\UserAddress;
use App\Mail\SignUp;
use App\Mail\ChangePassword;
use App\User;

class AuthenticationController extends Controller
{
    //LOGIN
    public function userLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'         =>  'required|email|max:150',
            'password'      =>  'required|min:8|max:16',
        ]);

        if ($validator->fails()) {
            $Response['serverError'] = $validator->messages();
        }else{
             if($request->ajax()){
                $email      = $request->input('email');
                $password   = $request->input('password');
                $registered_user = User::where('email',$email)->first();
                
                if($registered_user){

                    if($registered_user->is_active == "y"){

                        if(Auth::attempt(['email' => $email, 'password' => $password, 'is_active' => 'y'])){
                            Auth::login(Auth::user());
                            $Response['header']  = view('frontend.layouts.includes.header')->render();
                            $Response['success'] = trans('messages.success',['entity' => 'login']);
                        }else{
                            $Response['invalid'] = trans('messages.invalidlogin',['entity' => 'Email', 'entity2' => 'Password']);
                        }
                    }else{
                        $Response['notactive'] = trans('messages.notactive',['entity' => 'your account']);
                    }
                }else{
                    $Response['notregisterd'] = trans('messages.notregisterd',['entity' => 'Invalid']);
                }
            }else{
                return redirect()->back();
            }
        }
        return response()->json($Response,200);
    }

    //REGISTER
    public function userSignup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'             =>  'required|unique:users,email|email|max:150',
            'password'          =>  'required|min:8|max:16|regex:/^(?=.{8,16}$)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$/|confirmed',
        ]);

        if ($validator->fails()) {
            $Response['serverError'] = $validator->messages();
        }else{
            if($request->ajax()){
                $request['custom_id']   =   getUniqueString('users');
                $request['password']    =   bcrypt($request->password);

                $user = User::create($request->all());
                auth()->login($user);
                //$user->sendEmailVerificationNotification();

                // $name = 'Flower Shop';
                // Mail::to($request->email)->send(new SignUp($name));
               
                $Response['header']  = view('frontend.layouts.includes.header')->render();
                $Response['success'] = trans('messages.success',['entity' => 'Signup']);

            }
        }
        return response()->json($Response,200);
    }

    //LOGOUT
    public function logout(Request $request)
    {
        if(Auth::user()){
            Auth::logout();
        }
        return redirect()->route('home');
    }

    //SHOW PROFILE(MANAGE PROFILE)
    public function showProfile(Request $request)
    {
        if( $request->user() ){
            $addresses = UserAddress::with(['country','city'])->where('user_id',Auth::id())->get();
            return view('frontend.pages.account-settings',compact('addresses'));
        }else{
            return redirect(route('home'));
        }
    }

    //EDIT PROFILE(ACCOUNT SETTING -> EDIT PROFILE)
    public function editProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name'    =>  'required|max:255',
            'last_name'     =>  'required|max:255',
            'contact'       =>  'required|numeric|digits_between:8,16|unique:users,contact,'.Auth::id(),
            'profile'       =>  'nullable|mimes:jpeg,jpg,png',
        ]);

        if ($validator->fails()) {
            $Response['serverError'] = $validator->messages();
        }else{
            if($request->ajax()){
                $user = Auth::user();
                $user->fill($request->all());

                if($request->has('profile') ){
                    if( !empty($user->profile) && Storage::exists($user->profile) ){
                        \Storage::delete($user->profile);
                    }
                    $profile_path  = $request->file('profile')->store('profiles/users');
                    $user->profile = $profile_path;
                } 
               
                if($user->save()){
                    $Response['success'] = trans('messages.success',['entity' => 'Profile Edit']);
                }
            }
        }
        return response()->json($Response,200);
    }

    // CHANGE PASSWORD(ACCOUNT SETTING -> CHANGE PASSWORD)
    public function changeAccountPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' =>  'required|min:8|max:16|regex:/^(?=.{8,16}$)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$/|confirmed',
        ]);

        if ($validator->fails()) {
            $Response['serverError'] = $validator->messages();
        }else{
            if($request->ajax()){
                $user = Auth::user();
                $user['password'] = bcrypt($request->password);
                $user->save();

                if($user->first_name != null){
                    $data['username'] = $user->first_name.' '.$user->last_name;
                }else{
                    $data['username'] = $user->email;
                }
                Mail::to($user->email)->queue(new ChangePassword($data));

                $Response['success'] = trans('messages.success',['entity' => 'Passsword Changed']);
            }
        }
        return response()->json($Response,200);
    }

    //Set Default Address
    public function setDefaultAddress(Request $request)
    {
        if($request->ajax()){
            UserAddress::where(['user_id' => $request->user_id, 'is_default' => 'y'])->update(['is_default' => 'n']);
            
            $setDefault =  UserAddress::where(['user_id' => $request->user_id,'id' => $request->id])->first();
            
            if($setDefault){
                $setDefault->fill([
                    'is_default' => 'y',
                ]);
                $setDefault->save();
                $Response['success'] = trans('messages.success',['entity' => 'default address changed']);
            } else{
                $Response['fail'] = trans('messages.fail',['entity' => 'address']);
            }
            return response()->json($Response,200);
        }
    }
    
}
