<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Franchises;
use App\Models\FranchiseRequests;
use App\Models\ServiceInquiry;
use App\Models\SubscriptionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HelperController extends Controller
{
    public function checkEmail(Request $request)
    {
    	$id = $request->id ?? 0;
    	if( $request->type == 'user' ) {
    		$user = User::withTrashed();
    	} elseif($request->type == 'admin') {
    		$user = Admin::withTrashed();
    	} elseif($request->type == "franchise"){
            $user = Franchises::withTrashed();
        } elseif($request->type == "franchise_request"){
            $user = FranchiseRequests::withTrashed();
        } elseif($request->type == "service_inquiry_email"){
            $user = ServiceInquiry::withTrashed();
        } elseif($request->type == "subscribe_user"){
            $user = SubscriptionDetail::withTrashed();
        }

    	$user =	$user->where([
    			['id', '<>', $id],
    			'email' => $request->email,
    		])->count();

    	if( $user == 0 ){
    	    return "true";
    	}else{
    	    return "false";
    	}
    }

    public function checkContact(Request $request)
    {
    	$id = $request->id ?? 0;
    	if( $request->type == 'user' ) {
    		$user = User::withTrashed();
    	} elseif($request->type == 'admin') {
    		$user = Admin::withTrashed();
    	} elseif($request->type == 'franchise'){
            $franchise = Franchises::withTrashed();
        } elseif($request->type == 'franchise_request'){
            $franchise_request = FranchiseRequests::withTrashed();
        } elseif($request->type == 'service_contact'){
            $user = ServiceInquiry::withTrashed();
        } elseif($request->type == 'service_contact_home'){
            $service_contact_home = ServiceInquiry::withTrashed();
        } 

        if($request->type == 'user' || $request->type == 'admin' || $request->type == "service_contact"){
    	$user =	$user->where([
    			['id', '<>', $id],
    			'contact' => $request->contact,
    		])->count();

            if($user == 0){
                return "true";
            }
            else{
                return "false";
            }
        }

        if($request->type == 'franchise'){
        $franchise = $franchise->where([
                ['id','<>', $id],
                'contact_number' => $request->contact_number,
            ])->count();
        
            if($franchise == 0){
                return "true";
            }
            else{
                return "false";
            }    
        }

        if($request->type == 'franchise_request'){
        $franchise_request = $franchise_request->where([
                ['id','<>', $id],
                'phone' => $request->phone,
            ])->count();
        
            if($franchise_request == 0){
                return "true";
            }
            else{
                return "false";
            }    
        }

        if($request->type == 'service_contact_home'){
        $service_contact_home = $service_contact_home->where([
                ['id','<>', $id],
                'contact_home' => $request->contact_home,
            ])->count();
        
            if($service_contact_home == 0){
                return "true";
            }
            else{
                return "false";
            }    
        }
    }

    public function checkUserForgotEmail(Request $request)
    {
        if( $request->type == 'user' ) {
            $user = User::withTrashed();
            $user = $user->where('email',$request->email)->count();
        
            if($user == 1){
                return "true";
            }else{
                return "false";
            }
        }else{
            return "false";
        }
    }

    public static function generateUrl($path)
    {
        $url = "";
        if( !empty($path) )
            $path = ltrim($path, '/');

        if( !empty($path) && Storage::exists($path) )
            $url = Storage::url($path);

        // $url = Storage::temporaryUrl( $path, now()->addMinutes(5) );
        return $url;
    }

    public function uploadImage(Request $request)
    {
        dd($request->all());
    }
}
