<?php
namespace Modules\Admin\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Illuminate\Http\Request;
use Modules\Admin\Models\Settings;
// use Modules\Admin\Http\Requests\RoleRequest;
use Modules\Admin\Models\PharmacyList;
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
class PharmacyListController extends Controller {
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
        View::share('viewPage', 'pharmacyList');
        View::share('helper',new Helper);
        View::share('route_url',route('pharmacyList'));
        View::share('heading','Pharmacy List');

        $this->record_per_page = Config::get('app.record_per_page');
    }

    protected $categories;

    /*
     * Dashboard
     * */

    public function index(PharmacyList $pharmacylist, Request $request) 
    { 
        
        $page_title = 'Pharmacy List';
        $page_action = 'View PharmacyList                                                                                                                                                                                                                               '; 
        
        // Search by name ,email and group
        $search = Input::get('search'); 
        if ((isset($search) && !empty($search)) ) {

            $search = isset($search) ? Input::get('search') : '';
               
            $pharmacylist = PharmacyList::where(function($query) use($search) {
                        if (!empty($search)) {
                            $query->Where('name', 'LIKE', "%$search%");
                            $query->orWhere('contact', 'LIKE', "%$search%");
                        }
                        
                    })->orderBy('name','asc')->Paginate($this->record_per_page);
        } else {
            $pharmacylist  = PharmacyList::orderBy('name','asc')->Paginate(10);  
        } 

         return view('packages::pharmacylist.index', compact('pharmacylist', 'page_title', 'page_action'));
   
    }

    /*
     * create  method
     * */

    public function create(PharmacyList $pharmacylist)  
    {
        $page_title = 'Pharmacy List';
        $page_action = 'Create Pharmacy List';

        return view('packages::pharmacylist.create', compact('pharmacylist','page_title', 'page_action'));
     }

    /*
     * Save Group method
     * */

    public function store(Request $request, PharmacyList $pharmacylist) 
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
        


        $pharmacylist->name         =   $request->get('name');
        $pharmacylist->phone =   $request->get('phone');
        $pharmacylist->contact =   $request->get('contact');
       
        $pharmacylist->save();
       return Redirect::to('admin/pharmacyList')
                            ->with('flash_alert_notice', 'Pharmacy List was successfully created !');
    }
    /*
     * Edit Group method
     * @param 
     * object : $category
     * */

    public function edit($pharmacylist) {
        $pharmacylist = PharmacyList::find($pharmacylist);
        $page_title = 'Pharmacy List';
        $page_action = 'Edit List'; 
         
        return view('packages::pharmacylist.edit', compact( 'pharmacylist','page_title', 'page_action'));
    }

    public function update(Request $request, $id) 
    {
        $pharmacylist = PharmacyList::find($id);
        $pharmacylist->name         =   $request->get('name');
        $pharmacylist->contact      =   $request->get('contact');
        $pharmacylist->phone        =   $request->get('phone');

        $pharmacylist->save();
       
        return Redirect::to('admin/pharmacyList')
                        ->with('flash_alert_notice', 'Pharmacy List was successfully updated!');
    }
    /*
     *Delete User
     * @param ID
     * 
     */
    public function destroy($id) 
    {
        PharmacyList::where('id',$id)->delete();
        return Redirect::to('admin/pharmacyList')
                        ->with('flash_alert_notice', 'Pharmacy List was successfully deleted!');
    }

    public function show(PharmacyList $pharmacylist) {
        
    }
	

}
