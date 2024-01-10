<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Color;
use App\Models\ManageOccasion;
use App\Models\ManageColor;
use App\Models\ManageService;
use App\Models\Service;
use App\Models\Category;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $services   = null;
        $categories = Category::where('is_active','y')->get();
        $products   = Product::select('id','custom_id','title','ar_title')->where('is_active','y')->get();
        $colors     = Color::where('is_active','y')->get();
        $occassions_category    = ManageOccasion::with('category')->get();
        $colors_category        = ManageColor::with(['color','category'])->get();  
        $manage_services        = ManageService::with('service:id,custom_id,en_title,ar_title')->get();
        
        if(!$manage_services->isEmpty()){
            $services = Service::where('is_active','y')->get();
        }else{
            $service_data = Service::where('is_active','y')->get();
            if($manage_services->count() != $service_data->count()){
                $services = $service_data;
            }
        } 
        return view('admin.pages.home.create',compact('categories','products','colors','occassions_category','colors_category','services','manage_services'));
    }

    // TO Store & Change Every Occasion Products
    public function storeEveryOccasion(Request $request)
    {
        $occassions_category = $request->occassion_category;
        if($occassions_category != null){
            ManageOccasion::getQuery()->delete();
            $data = [];
            foreach ($occassions_category as $key => $category) {
                $data[] = [
                    'custom_id'     =>  getUniqueString('manage_occasions'),
                    'category_id'    => $category,
                    'created_at'    =>  \Carbon\Carbon::now(),
                    'updated_at'    =>  \Carbon\Carbon::now(),
                ];
            }
            ManageOccasion::insert($data);
            flash('Occasion Category added/updated successfully')->success();
            return redirect(route('admin.home.index'));
        } else{
            flash('category not avalible')->error();
            return redirect(route('admin.home.index'));
        }
    }

    // TO Store & Change Shop By Colors Products
    public function storeShopByColor(Request $request)
    {
        $color_ids      = $request->color;
        $colors_category   = $request->colors_category;

        if($color_ids != null && $colors_category != null && count($color_ids) == count($colors_category)){
            ManageColor::getQuery()->delete();
            $data = [];
            foreach ($color_ids as $key => $color_id) {
                $data[] = [
                    'custom_id'     =>  getUniqueString('manage_colors'),
                    'color_id'      =>  $color_id,
                    'category_id'   =>  $colors_category[$key],
                    'created_at'    =>  \Carbon\Carbon::now(),
                    'updated_at'    =>  \Carbon\Carbon::now(),
                ];
            }
            ManageColor::insert($data);
            flash('Color details added/updated successfully')->success();
            return redirect(route('admin.home.index'));
        } else{
            flash('colors not avalible')->error();
            return redirect(route('admin.home.index'));
        }
    }

    // TO Store & Change Sequence Of Services
    public function manageServices(Request $request)
    {
        $services = $request->service;
        if($services != null){
            ManageService::getQuery()->delete();
            $data = [];
            foreach ($services as $key => $service) { 
                $data[] = [
                    'custom_id'     =>  getUniqueString('manage_services'),
                    'service_id'    =>  $service,
                    'created_at'    =>  \Carbon\Carbon::now(),
                    'updated_at'    =>  \Carbon\Carbon::now(),
                ];
            }
            ManageService::insert($data);
            flash('Service details updated successfully')->success();
            return redirect(route('admin.home.index'));
        } else{
            flash('services not avalible')->error();
            return redirect(route('admin.home.index'));
        }
    }
}
