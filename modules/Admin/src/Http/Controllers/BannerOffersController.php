<?php
namespace Modules\Admin\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Illuminate\Http\Request;
use Modules\Admin\Http\Requests\BannerOfferRequest;
use Modules\Admin\Models\User; 
use Input, Validator, Auth, Paginate, Grids, HTML;
use Form, Hash, View, URL, Lang, Session, DB;
use Route, Crypt, Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Dispatcher; 
use App\Helpers\Helper;
use Modules\Admin\Models\Roles; 
use Modules\Admin\Models\BannerOffer; 
 

/**
 * Class AdminController
 */
class BannerOffersController extends Controller {
    /**
     * @var  Repository
     */

    /**
     * Displays all admin.
     *
     * @return \Illuminate\View\View
     */
    public function __construct() { 
        $this->middleware('admin');
        View::share('viewPage', 'BannerOffer');
        View::share('sub_page_title', 'BannerOffer');
        View::share('helper',new Helper);
        View::share('heading','Banner');
        View::share('route_url',route('bannerOffer'));

        $this->record_per_page = Config::get('app.record_per_page');
    }

   
    /*
     * Dashboard
     * */

    public function index(BannerOffer $banner, Request $request) 
    { 
        $page_title = 'Offers';
        $sub_page_title = 'Offers';
        $page_action = 'View Offers'; 


        if ($request->ajax()) {
            $id = $request->get('id'); 
            $banner = BannerOffer::find($id); 
            $banner->status = $s;
            $banner->save(); 
            exit();
        }

        // Search by name ,email and group
        $search = Input::get('search');
        if ((isset($search) && !empty($search))) {

            $search = isset($search) ? Input::get('search') : '';
               
            $banners = BannerOffer::where(function($query) use($search) {
                        if (!empty($search)) {
                            $query->Where('title', 'LIKE', "%$search%");
                        }
                        
                    })->Paginate($this->record_per_page);
        } else {
            $banners = BannerOffer::Paginate($this->record_per_page);
        }
         
        
        return view('packages::bannerOffer.index', compact('banners', 'page_title', 'page_action','sub_page_title'));
    }

    /*
     * create Group method
     * */

    public function create(BannerOffer $banner) 
    {
         
        $page_title = 'Offers';
        $page_action = 'Create Offer';
 
        $url = '';

        return view('packages::bannerOffer.create', compact('url','banner', 'page_title', 'page_action'));
    }

    /*
     * Save Group method
     * */

    public function store(Request $request, BannerOffer $banner) 
    {  

         

        $photo = $request->file('photo');
        if($photo){
        $destinationPath = storage_path('uploads/banner');
        $photo->move($destinationPath, time().$photo->getClientOriginalName());
        $photo_name = time().$photo->getClientOriginalName();
        $request->merge(['photo'=>$photo_name]);
        }else{
            return Redirect::to(route('bannerOffer.create'))
                            ->with('flash_alert_notice', 'Banner is missing. Upload Offer Banner');
        }
        
        $banner = new BannerOffer;
        $banner->title        =  $request->get('title');
        $banner->photo        =  $photo_name; 
	    $banner->url          =  url('storage/uploads/banner/'.$photo_name);
        $banner->description  =  $request->get('description');
        
        $banner->save();   
         
        return Redirect::to(route('bannerOffer'))
                            ->with('flash_alert_notice', 'New offer  successfully created !');
        }

    /*
     * Edit Group method
     * @param 
     * object : $banner
     * */

    public function edit($id) {
        $banner = BannerOffer::find($id);
        $page_title = 'Offer';
        $page_action = 'Edit Offer'; 
        $url = $banner->url;
        return view('packages::bannerOffer.edit', compact( 'url','banner', 'page_title', 'page_action'));
    }

    public function update(Request $request,  $id) {
        
        $banner = BannerOffer::find($id); 
        $validate_cat = BannerOffer::where('title',$request->get('title'))
                            ->where('id','!=',$banner->id)
                            ->first();
         
        if($validate_cat){
              return  Redirect::back()->withInput()->with(
                'field_errors','The offer title already been taken!'
            );
        } 


        if ($request->file('photo')) {
            $photo = $request->file('photo');
            $destinationPath = storage_path('uploads/banner');
            $photo->move($destinationPath, time().$photo->getClientOriginalName());
            $photo_name = time().$photo->getClientOriginalName();
            $request->merge(['photo'=>$photo_name]);
            $banner->photo        =  $photo_name; 
            $banner->url          =  url('storage/uploads/banner/'.$photo_name);	
        } 

        $banner->title         =  $request->get('title'); 
        $banner->description           =  $request->get('description'); 
         
        $banner->save();    


        return Redirect::to(route('bannerOffer'))
                        ->with('flash_alert_notice', ' Offer  successfully updated.');
    }
    /*
     *Delete User
     * @param ID
     * 
     */
    public function destroy($id) {

        BannerOffer::where('id',$id)->delete(); 
        return Redirect::to(route('bannerOffer'))
                        ->with('flash_alert_notice', ' Offer  successfully deleted.');
        
    }

    public function show(BannerOffer $banner) {
        
    }

}
