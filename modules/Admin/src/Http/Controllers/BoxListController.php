<?php
namespace Modules\Admin\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Illuminate\Http\Request;
use Modules\Admin\Models\Settings;
// use Modules\Admin\Http\Requests\RoleRequest;
use Modules\Admin\Models\BoxList;
use Input;
use Validator;
use Auth;
use Paginate;
use Grids;
use HTML;
use Form;
use Hash;
use View;
use URL;
use Lang;
use Session;
use Route;
use Crypt;
use Modules\Admin\Http\Controllers\Controller;
use Illuminate\Http\Dispatcher; 
use Modules\Admin\Helpers\Helper as Helper;
use Response;

/**
 * Class AdminController
 */
class BoxListController extends Controller {
    /**
     * @var  Repository
     */

    /**
     * Displays all admin.
     *
     * @return \Illuminate\View\View
     */
    public function __construct() {
        parent::__construct();

        $this->middleware('admin');
        View::share('viewPage', 'boxList');
        View::share('helper',new Helper);
        View::share('route_url',route('boxList'));
        View::share('heading','Box List');

        $this->record_per_page = Config::get('app.record_per_page');
    }

    protected $categories;

    /*
     * Dashboard
     * */

    public function index(BoxList $boxlist, Request $request) 
    { 
        
        $page_title = 'Box List';
        $page_action = 'View Box List';  
        // Search by name ,email and group
        $search = Input::get('search');  
        if ($search) { 
             
            $boxlist = \DB::table('inventory')->where(function($query) use($request) {
                        if (!empty($request->pharmacy)) { 
                            $query->where('pharmacy_id', $request->pharmacy);
                        }
                        if (!empty($request->type)) { 
                            $query->where('class', $request->type);
                        }
                    })->orderBy('created_on','desc')->Paginate(30);
        } else {
            $boxlist  = \DB::table('inventory')->orderBy('created_on','desc')->Paginate(30);  
        } 

        $pharmacylist = \DB::table('pharmacy_list')->pluck('name','id');
         

         return view('packages::boxList.index', compact('boxlist', 'page_title', 'page_action','pharmacylist'));
   
    }

    /*
     * create  method
     * */

    public function create(BoxList $boxlist)  
    {
        $page_title = 'Box List';
        $page_action = 'Create Box List';

        return view('packages::boxList.create', compact('boxlist','page_title', 'page_action'));
     }

    /*
     * Save Group method
     * */

    public function store(Request $request, BoxList $boxlist) 
    {   


          $validator = Validator::make($request->all(), [
           'name' => 'required',
           'phone' => 'required|min:11|numeric',
           'contact' => 'required'
           
        ]);
        /** Return Error Message **/
        if ($validator->fails()) {
             return redirect()
                        ->back()
                        ->withInput()  
                        ->withErrors($validator);
        }
        


        $boxlist->name         =   $request->get('name');
        $boxlist->phone =   $request->get('phone');
        $boxlist->contact =   $request->get('contact');
       
        $boxlist->save();
       return Redirect::to('admin/boxList')
                            ->with('flash_alert_notice', 'Box List was successfully created !');
    }
    /*
     * Edit Group method
     * @param 
     * object : $category
     * */

    public function edit($boxlist) {
        $boxlist = BoxList::find($boxlist);
        $page_title = 'Box List';
        $page_action = 'Edit List'; 
         
        return view('packages::boxList.edit', compact( 'boxlist','page_title', 'page_action'));
    }

    public function update(Request $request, $id) 
    {
        $boxlist = BoxList::find($id);
        $boxlist->name         =   $request->get('name');
        $boxlist->contact      =   $request->get('contact');
        $boxlist->phone        =   $request->get('phone');

        $boxlist->save();
       
        return Redirect::to('admin/boxList')
                        ->with('flash_alert_notice', 'Box List was successfully updated!');
    }
    /*
     *Delete User
     * @param ID
     * 
     */
    public function destroy($id) 
    {
        BoxList::where('id',$id)->delete();
        return Redirect::to('admin/boxList')
                        ->with('flash_alert_notice', 'Box List was successfully deleted!');
    }

    public function show(BoxList $boxlist) {
        
    }

     public function inventoryBoxDetails(BoxList $boxlist, Request $request) 
    { 
        
        $page_title = 'Box List';
        $page_action = 'View Box List';                                                                                                                                                                                                               

         return view('packages::boxList.inventoryBoxDetails', compact('page_title', 'page_action'));
   
    }
	

}
