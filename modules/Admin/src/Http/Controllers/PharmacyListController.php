<?php
namespace Modules\Admin\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Illuminate\Http\Request;
use Modules\Admin\Models\Settings;
use Modules\Admin\Http\Requests\PharmacyRequest;
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


    public function import(Request $request)
    {
        try{
            $file = $request->file('importContact');
            
            if($file==NULL){
                echo json_encode(['status'=>0,'message'=>'Please select  csv file!']); 
                exit(); 
            }
            $ext = $file->getClientOriginalExtension();
            if($file==NULL || $ext!='csv'){
                echo json_encode(['status'=>0,'message'=>'Please select valid csv file!']); 
                exit(); 
            }
            $mime = $file->getMimeType();   
           
            $upload = $this->uploadFile($file);
           
            $rs =    \Excel::load($upload, function($reader)use($request) {

            $data = $reader->all(); 
              
            $table_cname = \Schema::getColumnListing('contacts');
            
            $except = ['id','create_at','updated_at'];

            $input = $request->all();
           // $contact->categoryName = $cn;
            $contact =  new Contact;
            foreach ($data  as $key => $result) {
                foreach ($table_cname as $key => $value) {
                   if(in_array($value, $except )){
                        continue;
                   }
                   if(isset($result->$value)) {
                       $contact->$value = $result->$value; 
                       $status = 1;
                   } 
                }
                 if(isset($status)){
                     $contact->save(); 
                 }
            } 
           
            if(isset($status)){
                echo json_encode(['status'=>1,'message'=>'contact imported successfully!']);
            }else{
               echo json_encode(['status'=>0,'message'=>'Invalid file type or content.Please upload csv file only.']); 
            }
             
            });

        } catch (\Exception $e) {
            echo json_encode(['status'=>0,'message'=>'Please select csv file!']); 
            exit(); 
        }
        
       
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
           'phone' => 'required|min:10|numeric',
           'mobile_number' => 'required|min:10|numeric',
           'contact' => 'required',
           'email'     => "required|email|unique:users,email"
           
        ]); 
        if ($validator->fails()) {
             return redirect()
                        ->back()
                        ->withInput()  
                        ->withErrors($validator);
        }
        


        $pharmacylist->fill(Input::all()); 
        $pharmacylist->save(); 
        
        return Redirect::to('admin/pharmacyList')
                            ->with('flash_alert_notice', 'Pharmacy   was successfully created !');
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
        $pharmacylist->fill(Input::all()); 
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
