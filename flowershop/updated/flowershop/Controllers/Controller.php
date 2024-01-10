<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Models\Setting;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public $vat = 0;

    public function __construct()
    {    
        $setting = Setting::select('en_vat','ar_vat')->latest()->first();
        if($setting != null && $setting != '[]'){
            $this->vat = $setting->getVat();
        }
    }

    public function DTFilters($request){
        $filters = array(
            'draw' => $request['draw'],
            'offset' => $request['start'],
            'limit' => $request['length'],
            'sort_column' => $request['columns'][$request['order'][0]['column']]['data'],
            'sort_order' => $request['order'][0]['dir'],
            'search' => $request['search']['value']

        );
        return $filters;
    }

    // APIs status and response variables
	    // public $response = array('data'=> null,'meta'=> [ 'message' => "" ]);
        // dump(url()->current());
        public $response = [
            'data'  =>  null,
            'meta'  =>  [
                'message'                   =>  "",
                'api'                       =>  "",
                'url'                       =>  "",
                'notification'              =>  false,
                'subscription'              =>  false,
                'trial'                     =>  false,
                'subscription_end_date'     =>  "",
            ],
        ];
	    
        public $status = 412;
	    public $statusArr = [
	        'success'=> 200,
	        'bad_request' => 400,
	        'authorization_required' => 401,
	        'payment_required' => 402,
	        'forbidden' => 403,
	        'not_found' => 404,
	        'method_not_allowed' => 405,
	        'not_acceptable' => 406,
	        'proxy_authentication_required' => 407,
	        'request_timeout' => 408,
	        'conflict' => 409,
	        'gone' => 410,
	        'length_required' => 411,
	        'precondition_failed' => 412,
	        'request_entity_too_large' => 413,
	        'request_URI_too_large' => 414,
	        'unsupported_media_type' => 415,
	        'request_range_not_satisfiable' => 416,
	        'expectation_failed' => 417,
	        'unprocessable_entity' => 422,
	        'locked' => 423,
	        'failed_dependency' => 424,
	        'internal_server_error' => 500,
	        'not_implemented' => 501,
	        'bad_gateway' => 502,
	        'service_unavailable' => 503,
	        'gateway_timeout' => 504,
	        'insufficient_storage' => 507,
	    ];

    // APIs Validations
	    public function apiValidator($fields, $rules, $version = "v.0.0", $message = array())
	    {
	        $validator = Validator::make($fields, $rules, $message);
	        if($validator->fails()){
	            $errors = $validator->errors();
	            $r_message  = '';
	            $i=1;
	            foreach($errors->messages() as $key => $message){
	                if($i==1){
	                    $r_message = $message[0];
	                } else {
	                    break;
	                }
	                $i++;
	            }
	            $this->response['meta']['message'] = $r_message;
                $this->response['meta']['url'] = url()->current();
                $this->response['meta']['api'] = $version;
	            return false;
	        }
	        return true;
	    }

    // Send JSON object as response
	    public function return_response()
	    {

            $status = false;
            $trial = false;
            $notification = false;
            $end_date = \Carbon\Carbon::yesterday()->format('Y-m-d');
            if( ! Auth::guest() ) {
                $status = Auth::user()->subscription_status == 'active'
                            || Auth::user()->trial_end_date >= \Carbon\Carbon::now()->format('Y-m-d')
                            || Auth::user()->subscription_end_date >= \Carbon\Carbon::now()->format('Y-m-d')
                            || Auth::user()->is_free_account == 'y';
                
                $end_date = Auth::user()->subscription_end_date ?? \Carbon\Carbon::yesterday()->format('Y-m-d');
                if( Auth::user()->is_free_account == 'y' )
                    $end_date = \Carbon\Carbon::tomorrow()->format('Y-m-d');
                $trial = Auth::user()->trial_end_date >= \Carbon\Carbon::now()->format('Y-m-d');
                $notification = Auth::user()->notifications()->where('is_read', 'n')->exists();
            }

            
            $this->response['meta']['notification']             = $notification;
            $this->response['meta']['subscription']             = $status;
            $this->response['meta']['trial']                    = $trial;
            $this->response['meta']['subscription_end_date']    = $end_date;


	        return response()->json($this->response, $this->status);
	    }


    public function getLocaleField() {
        $locale = app()->getLocale();
        if ($locale == 'en') {
            $this->field = "show_en";
        } else {
            $this->field = "show_ar";
        }
        return $this->field;
    }

    public function getLanguageField() {
        $this->local = 'en';
        if (Session::has('local')) {
            $this->local = in_array(Session::get('local', Config::get('app.local')), ['ar', 'en']) ? Session::get('local', Config::get('app.local')) : 'en';
        } else {
            $this->local = 'en';
        }
        return $this->local;
    }
}
