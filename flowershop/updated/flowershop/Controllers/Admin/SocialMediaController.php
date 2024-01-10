<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\SettingRequest;
use App\Models\Setting;


class SocialMediaController extends Controller
{ 
    public function index()
    {
        $setting = Setting::latest()->first();
        return view('admin.pages.social-media.create',compact('setting'));
    }

    public function update(SettingRequest $request, $id)
    {
        $setting = Setting::where('id',$id)->first();
        if($setting){
            $setting->fill($request->all());
            if( $setting->save() ) {
                flash('Social Media details updated successfully!')->success();
            }else{
                flash('Unable to update social media detais. Try again later')->error();
            }
        }
        else{
            flash('Unable to update social media detais. Try again later')->error();
        }
        return redirect(route('admin.social.index'));
    }
}
