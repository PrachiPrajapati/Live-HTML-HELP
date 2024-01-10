<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\NewsBlog;
use App\Models\CmsPages;
use App\Models\Service;
use App\Models\ServicesShowcase;
use App\Models\Career;
use App\Models\Faqs;
use App\Models\Term;
use App\Models\Privacy;
use App\Models\DeliveryCharge;
use App\Models\ServiceInquiry;
use App\Models\Product;
use App\Models\Category;
use App\Models\ManageOccasion;
use App\Models\ManageColor;
use App\Models\ManageService;
use App\Models\Callback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Frontend\ServiceInquiryRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PagesController extends Controller
{
    public function index()
    {
        $products   =   Product::select('id','slug','title','ar_title','order_amount','image')->where('is_active','y')->latest()->limit(4)->get();
        $services   =   ManageService::select('id','service_id')->with('service:id,slug,en_title,ar_title,en_banner,ar_banner')->get();
        $occasions  =   ManageOccasion::select('id','category_id')->with('category')->get();
        $colors     =   ManageColor::with(['color:id,title,ar_title','category'])->get();
        $categories =   Category::select('id','slug','title','ar_title','image')->where('is_active','y')->get();

        return view('frontend.pages.index',compact('products','services','occasions','colors','categories'));
    }

    public function blogs()
    {
    	$blogs = NewsBlog::select(['*', \DB::raw('DATE_FORMAT(created_at, "%M %Y")  as formated')])->where('is_active', 'y')->get();
    	$blogs = $blogs->groupBy('formated');
    	return view('frontend.pages.blogs', compact('blogs'));
    }

    public function blogDetails($slug)
    {
        $blog = NewsBlog::where('slug', $slug)->firstOrFail();
        return view('frontend.pages.blog-details', compact('blog'));
    }

    //Carrer
    public function showCareers()
    {
        if(Career::all()->count() != 0){
            $careers = Career::where('is_active','y')->get();
            return view('frontend.pages.careers',compact('careers'));
        }
        else{
            return view('frontend.pages.careers-empty');
        }
    }

    //Carrer Inner
    public function showCareerDetails($slug)
    {
        $career = Career::where('slug', $slug)->firstOrFail();
        return view('frontend.pages.career-inner',compact('career'));
    }


    //Faqs
    public function showFaqs()
    {
        $faqs   = Faqs::where('is_active','y')->get();
        return view('frontend.pages.faqs',compact('faqs'));
    }

    //Delivery Charge
    public function deliveryCharge()
    {
        $delivery_charges = DeliveryCharge::where('is_active','y')->get();
        return view('frontend.pages.delivery',compact('delivery_charges'));
    }

    //Privacy Policy
    public function privacyPolicy()
    {
        $privacies = Privacy::where('is_active','y')->get();
        return view('frontend.pages.privacy-policy',compact('privacies'));
    }

    //Terms & Condition
    public function termConditions()
    {
        $terms = Term::where('is_active','y')->get();
        return view('frontend.pages.terms-conditions',compact('terms'));
    }

    //About-Us
    public function aboutUs()
    {
        return view('frontend.pages.about-us');
    }

    //Service
    public function services()
    {
        $banner     = Service::latest()->firstOrFail();
        $sliders    = Service::where('is_active','y')->get();
        return view('frontend.pages.services-overview',compact('banner','sliders'));
    }

    //Service Inner
    public function servicesInner($slug)
    {
        $service    = Service::where('slug',$slug)->firstOrFail();
        $showcases  = ServicesShowcase::where('service_id',$service->id)->get();
        return view('frontend.pages.services-inner',compact('service','showcases'));   
    }

    //Service Inquiry Form Display
    public function showInquiryForm($slug)
    {
        $countries      = Country::where('is_active', 'y')->get(); 
        $service        = Service::select('id','en_title','ar_title')->where('slug',$slug)->firstOrFail();
        return view('frontend.pages.inquiry-form',compact('countries','service','slug'));
    }
    
    //SERVICE INQUIRY SAVE
    public function serviceInquirySave(ServiceInquiryRequest $request)
    {
        $country = Country::where('id',$request->country)->firstOrFail();
        $city = DeliveryCharge::where(['id' => $request->city, 'is_active' => 'y'])->firstOrFail();

        $request['country'] = $country->getName();
        $request['city'] = $city->getCity();

        $data = ServiceInquiry::create($request->all());
        
        if($data->save()){
            Session::flash('message',' Inquiry details save successfully.'); 
            return redirect()->route('home'); 
        } else{
            Session::flash('message', 'unable to store details.');  
            return redirect()->route('home'); 
        }
    }
    
    //News
    public function getNews(Request $request)
    {
        $latest_blog  = NewsBlog::where('is_active','y')->latest()->first();
        if($latest_blog != null){
            $blogs = NewsBlog::select(['*', \DB::raw('DATE_FORMAT(created_at, "%M %Y")  as formated')])->where('is_active', 'y')->get();
            $blogs = $blogs->groupBy('formated');

            return view('frontend.pages.news', compact('latest_blog','blogs'));
        } else{
            return view('frontend.pages.news-empty');
        }
    }

    //News Details
    public function newsDetails($slug)
    {
        $blog = NewsBlog::where('slug', $slug)->firstOrFail();
        $related_blogs = NewsBlog::select(['*', \DB::raw('DATE_FORMAT(created_at, "%M %Y")  as formated')])->whereNotIN('id',[ $blog->id ])->where('is_active', 'y')->get();
        return view('frontend.pages.news-inner', compact('blog','related_blogs'));
    }

    // View All News
    public function newsViewAll(Request $request)
    {
        $latest_blog  = NewsBlog::where('is_active','y')->latest()->first();
        if( $latest_blog != null && $latest_blog != '[]')
        {
            $blogs = NewsBlog::where('is_active','y')->get();
            return view('frontend.pages.view-all', compact('latest_blog','blogs'));
        } else{
            return view('frontend.pages.news-empty');
        }
    }

    //Request a callback
    public function callbackSave(Request $request)
    {
        $callback = Callback::updateOrCreate([
            'name'      =>  $request->name,
            'contact'   =>  $request->contact,
        ]);
        
        if($callback->save()){
           Session::flash('message', $request->name. ' details save successfully.'); 
           return redirect()->back();
        } else{
           Session::flash('message', 'unable to store details.');  
           return redirect()->back(); 
        }
    }

}

