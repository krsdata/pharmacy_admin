<?php
namespace Modules\Admin\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Illuminate\Http\Request;
use Modules\Admin\Models\Settings;
// use Modules\Admin\Http\Requests\RoleRequest;
use Modules\Admin\Models\Inventory;
use Modules\Admin\Models\InventoryIntake;
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
class InventoryController extends Controller {
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
        View::share('viewPage', 'inventory-return');
        View::share('helper',new Helper);
        View::share('route_url',route('inventory-return'));
        View::share('heading','Inventory');

        $this->record_per_page = Config::get('app.record_per_page');
    }

    protected $categories;

    public function unknownItem(Request $request, Inventory $inventory)
    {
        $page_title = 'Inventory';
        $page_action = 'View Inventory';

        if($request->method()=="POST")
        { 
            $pid  = $request->pharmacy_id; 
            if($request->get('return_item')=='return_item')
            {

               $return_item = \DB::table('inventory')
                        ->where(function($query) use($request){
                            if($request->ndc)
                            {
                                $query->where('ndc',$request->ndc);
                            } 
                             if($request->qty)
                            {
                                 $query->where('qty',$request->qty);
                            }
                             if($request->lot)
                            {
                                $query->where('lot',$request->lot); 
                            } if($request->lot)
                            {
                                $query->where('exp_date',$request->exp_date); 
                            } 
                            
                        })->where('pharmacy_id',$request->pharmacy_id)
                        ->first(); 

                $data = [];
                if($return_item)
                {
                    foreach($return_item as $key => $value)
                    {   
                        if( $key=="id")
                        {
                            continue;
                        }
                        $data[$key] = $value;
                    }

                    if(count($data))
                    {
                        \DB::table('inventory')->insert($data);      
                    }
                }else{
                   return Redirect::to('admin/unknown-item?pharmacy='.$pid);
                }

            }else{
                 \DB::table('inventory')->insert($request->all()); 
            } 

            return Redirect::to('admin/inventory-intake?pharmacy_name='.$pid);
        }

        return view('packages::inventory.unknownItem', compact('inventory', 'page_title', 'page_action','request'));                                         
    }

    /*
     * Dashboard
     * */

    public function index(Inventory $inventory, Request $request) 
    { 
        
        $page_title = 'Inventory';
        $page_action = 'View Inventory';
        // Search by name ,email and group
        $search = Input::get('search'); 
        if ((isset($search) && !empty($search)) ) {

            $search = isset($search) ? Input::get('search') : '';
               
            $pharmacylist = Inventory::where(function($query) use($search) {
                        if (!empty($search)) {
                            $query->Where('name', 'LIKE', "%$search%");
                            $query->orWhere('contact', 'LIKE', "%$search%");
                        }
                        
                    })->orderBy('name','asc')->Paginate($this->record_per_page);
        } else {
            $inventory  = Inventory::orderBy('name','asc')->Paginate(10);  
        } 

         return view('packages::inventory.index', compact('inventory', 'page_title', 'page_action'));
   
    }

    /*
     * create  method
     * */

    public function create(Inventory $inventory)  
    {
        $page_title = 'Inventory';
        $page_action = 'Create Inventory';

        return view('packages::inventory.create', compact('inventory','page_title', 'page_action'));
     }

    /*
     * Save Group method
     * */

    public function store(Request $request, Inventory $inventory) 
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
       return Redirect::to('admin/inventory')
                            ->with('flash_alert_notice', 'Inventory was successfully created !');
    }
    /*
     * Edit Group method
     * @param 
     * object : $category
     * */

    public function edit($inventory) {
        $pharmacylist = Inventory::find($inventory);
        $page_title = 'Inventory';
        $page_action = 'Edit Inventory'; 
         
        return view('packages::pharmacylist.edit', compact( 'inventory','page_title', 'page_action'));
    }

    public function update(Request $request, $id) 
    {
        $pharmacylist = Inventory::find($id);
        $pharmacylist->name         =   $request->get('name');
        $pharmacylist->contact      =   $request->get('contact');
        $pharmacylist->phone        =   $request->get('phone');

        $pharmacylist->save();
       
        return Redirect::to('admin/inventory')
                        ->with('flash_alert_notice', 'Inventory was successfully updated!');
    }
    /*
     *Delete User
     * @param ID
     * 
     */
    public function destroy($id) 
    {
        Inventory::where('id',$id)->delete();
        return Redirect::to('admin/inventory')
                        ->with('flash_alert_notice', 'Inventory was successfully deleted!');
    }

    public function show(Inventory $inventory) {
        
    }

     public function intake(InventoryIntake $inventoryIntake, Request $request)  
    {
        $page_title = 'Inventory Return';
        $page_action = 'Intake Inventory';

        $pid = $request->get('pharmacy_name');

        $inventory = \DB::table('inventory')->where('pharmacy_id',$pid)
                        ->get()->groupBy('class');

        
        if($request->method()=="POST"){
            $remove_item = $request->get('remove_it');

            \DB::table('inventory')->where('id',$remove_item)
                        ->delete();
            return Redirect::to('admin/inventory-intake?pharmacy_name='.$pid);
        }


        return view('packages::inventory.intake', compact('inventoryIntake','page_title', 'page_action','request','inventory'));
     }

      public function return_store(Request $request, InventoryIntake $inventoryIntake) 
    {   


          $validator = Validator::make($request->all(), [
           'ndc' => 'required',
           'qty' => 'required|min:11|numeric',
           'lot' => 'required'
           
        ]);
        /** Return Error Message **/
        if ($validator->fails()) {
             return redirect()
                        ->back()
                        ->withInput()  
                        ->withErrors($validator);
        }
        


        $inventoryIntake->inventory_ndc         =   $request->get('ndc');
        $inventoryIntake->inventory_qty_type =   $request->get('qty_type');
        $inventoryIntake->inventory_qty =   $request->get('qty');
        $inventoryIntake->inventory_lot =   $request->get('lot');
        $inventoryIntake->inventory_exp_date =   $request->get('exp_date');
        $inventoryIntake->save();
       return Redirect::to('admin/inventory-intake')
                            ->with('flash_alert_notice', 'Return Inventory was successfully created !');
    }

	 public function inventoryReturn(PharmacyList $pharmacylist)  
    {
        $page_title = 'Inventory Return';
        $page_action = 'Inventory Return';

        $pharmacylist = PharmacyList::all();
        
        return view('packages::inventory.return', compact('pharmacylist','page_title', 'page_action'));
     }

     public function return_save(Request $request) 
    {

        $pharmacyid = $request->id; 
        dd($pharmacyid); exit;
        return  Redirect::to(route('admin/inventory','pharmacyId='.$pharmacyid));
    }

}
