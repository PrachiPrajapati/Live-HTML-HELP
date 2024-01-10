<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class GeneralTasksController extends Controller
{
    public function getDeliveryDetails(Request $request)
    {
    	$country = Country::with('deliveryCharges')->where('en_name', $request->country)->first();
    	$check = $country->deliveryCharges;
    	return json_encode([
    		'status'	=>	'success',
    		'data'		=>	view('frontend.layouts.includes.delivery-charges', compact('country'))->render(),
    	]);
    }
    public function demo()
    {
    	return serialize(getPermissions('admin'));
    }
}
