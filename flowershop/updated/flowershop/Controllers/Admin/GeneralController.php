<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ChangeProfileRequest;
use App\Http\Requests\General\ChangePassword;
use App\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class GeneralController extends Controller
{
    public function dashboard()
    {
        $users_count = User::count();
        $product_count = Product::count();
        $data = [
            'users'     =>  $users_count,
            'products'  =>  $product_count,
        ];

    	return view('admin.pages.general.dashboard', compact('data'));
    }

    public function changePassword()
    {
    	return view('admin.pages.general.change-password')->withTitle('Change Password');
    }
        public function updatePassword(ChangePassword $request)
        {
            $user = Auth::user();
            if( Hash::check($request->old_password, $user->password) ) {
                Auth::user()->password = Hash::make($request->password);
                Auth::user()->save();
                flash('Password details updated successfully')->success();
            } else {
                flash(trans('validation.not_match', ['attribute' => 'old password']))->error();
            }
            return redirect()->back();
            
        }

    public function getProfile()
    {
    	$user = Auth::user();
    	return view('admin.pages.general.profile', compact('user'))->withTitle('Profile');
    }

        public function editProfile(ChangeProfileRequest $request)
        {
            unset($request->type); unset($request->is_active);

            $path = Auth::user()->profile;
            if( $request->profile ) {
                if( Auth::user()->profile && Storage::exists(Auth::user()->profile) )
                    Storage::delete(Auth::user()->profile);;
                $path = $request->file('profile')->store('admin/profiles');
            }
            Auth::user()->fill($request->all());
            Auth::user()->profile = $path;
            Auth::user()->save();
            flash('Profile updated successfully!')->success();
            return redirect(route('admin.profile-show'));
        }
}
