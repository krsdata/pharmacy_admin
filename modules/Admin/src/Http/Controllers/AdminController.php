<?php
namespace Modules\Admin\Http\Controllers; 

use Modules\Admin\Http\Requests\LoginRequest;
use Modules\Admin\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Dispatcher; 
use Illuminate\Contracts\Encryption\DecryptException;
use App\Http\Requests\UserRequest;
use Auth,Input,Redirect,Response,Crypt,View,Session;
use Cookie,Closure,Hash,URL,Lang,Validator;
use App\Http\Requests;
use App\Helpers\Helper as Helper;
//use Modules\Admin\Models\User; 
use Modules\Admin\Models\Category;
use App\Models\Matches;
use App\Models\Player;
use App\Models\TeamASquad;
use App\Models\TeamBSquad;
use App\Models\CreateContest;
use App\Models\CreateTeam;
use App\Models\Wallet;
use App\Models\JoinContest;
use App\Models\WalletTransaction;
use App\Models\MatchPoint;
use App\Models\PrizeDistribution;
use App\Admin;
use Illuminate\Http\Request;
use App\User;

/**
 * Class : AdminController
 */
class AdminController extends Controller { 
    /**
     * @var  Repository
     */ 
    /**
     * Displays all admin.
     *
     * @return \Illuminate\View\View
     */ 
    protected $guard = 'admin';
    public function __construct()
    {  
        $this->middleware('admin');  
        View::share('heading','dashboard');
        View::share('route_url','admin');
        View::share('WebsiteTitle',env('company_url'));
    }
    /*
    * Dashboard
    **/
    public function index(Request $request) 
    { 
        $page_title = "";
        $page_action = "";
       
        $professor = User::where('role_type',1)->count();
         
        $user = User::count();
        $viewPage = "Admin";

        $users_count        =  User::count();
        $category_grp_count =  Category::where('parent_id',0)->count();
        $category_count     =  Category::where('parent_id','!=',0)->count();
        
        $musers_count =  User::where('customer_type',0)
                                ->whereMonth('created_at', '=', date('m'))
                                ->whereYear('created_at', date('Y'))
                                ->count();

            
        $match_1 = Matches::where('status',1)
                    ->whereDate('date_start',\Carbon\Carbon::today())
                    ->count();
        
        $hero = User::where('customer_type',3)->pluck('id')->toArray();
        $hero[] = 285;
        $hero[] = 262;
        $hero[] = 361;
        $hero[] = 11556;
        $hero[] = 9112;
        
        $cj = 0;
        $tinc = 0;
        $mid = Matches::whereMonth('date_start',date('m'))
                        ->whereYear('date_start',date('Y'))
                        ->whereIn('status',[2])
                        ->get();

        $today_profits = Matches::
                        whereDate('date_start',\Carbon\Carbon::today())
                        ->select('profit','loss') 
                        ->whereIn('status',[2,3])
                        ->get(); 
                        
        $today_profit = $today_profits->sum('profit') - $today_profits->sum('loss'); 

        $extra_income = $mid->sum('profit')-$mid->sum('loss'); 

        $match_2 = Matches::where('status',2)->count();
        $match_3 = Matches::where('status',3)->count();

        $deposit = WalletTransaction::where('payment_type',3)->sum('amount');

        $monthly_deposit = WalletTransaction::where('payment_type',3)
                ->whereMonth('created_at',date('m'))
                ->whereYear('created_at', date('Y'))
                ->sum('amount');

        $prize = WalletTransaction::where('payment_type','4')->sum('amount');

        $refunded = round(WalletTransaction::where('payment_type_string','Refunded')->sum('amount'),2);

        $referral = WalletTransaction::where('payment_type_string','referral')->sum('amount');

        $today_deposit = round(WalletTransaction::where('payment_type_string','Deposit')
            ->whereDate('created_at',\Carbon\Carbon::today())
            ->sum('amount'),2);




        $join_contest_amt = WalletTransaction::where('payment_type',6)->sum('amount');

        $today_withdrawal = WalletTransaction::where('payment_type',5)->sum('amount');

        $today_withdrawal2 = WalletTransaction::where('payment_type',5)->whereDate('created_at',\Carbon\Carbon::today())->sum('amount');

         $monthly_withdrawal = WalletTransaction::where('payment_type',5)
                    ->whereMonth('created_at',date('m'))
                    ->whereYear('created_at', date('Y'))
                    ->sum('amount');

        $revenue = (int)($deposit - $today_withdrawal);

        $create_count = CreateTeam::count();

        $joinContest_count = JoinContest::count(); 
       // dd($create_count);
        $match = Matches::count();

        $contest_types = \DB::table('contest_types')->count();
        $banner = \DB::table('banners')->count();

        $total_user = \DB::table('eventLogs')
                ->whereDate('created_at',\Carbon\Carbon::today())
                ->groupBy('user_id')
                ->pluck('user_id')
                ->count();

        $total_reg = \DB::table('users')
                ->whereDate('created_at',\Carbon\Carbon::today())
                ->count();


        $total_bonus = WalletTransaction::whereIn('payment_type',[1,8,2])->sum('amount');
        $bonus = Wallet::where('payment_type',1)->sum('amount');
        $total_bonus_used = $bonus;


        $today_deposit_paytm = round(WalletTransaction::where('payment_type_string','Deposit')
            ->where('payment_mode','paytm')
            ->whereDate('created_at',\Carbon\Carbon::today())
            ->sum('amount'),2);

        $today_deposit_razorpay = round(WalletTransaction::where('payment_type_string','Deposit')
            ->where('payment_mode','razorpay')
            ->whereDate('created_at',\Carbon\Carbon::today())
            ->sum('amount'),2);

         $affiliate = \DB::table('affiliate_programs')->sum('amount'); 

         $pending_doc = \DB::table('verify_documents')
                            ->where('status',1)
                            ->count(); 

        $monthly_revenue = ($monthly_deposit-$monthly_withdrawal);


        return view('packages::dashboard.index',compact('joinContest_count','create_count','today_deposit','category_count','users_count','category_grp_count','page_title','page_action','viewPage','match_1','match_2','match_3','match','contest_types','banner','deposit','prize','refunded','referral','join_contest_amt','total_user','today_withdrawal','total_bonus','total_bonus_used','total_reg','today_deposit_paytm','today_deposit_razorpay','revenue','affiliate','today_withdrawal2','pending_doc','extra_income','monthly_withdrawal','monthly_deposit','monthly_revenue','musers_count','tinc','cj','today_profit')); 
    }

   public function profile(Request $request,Admin $users)
   {
        $users = Admin::find(Auth::guard('admin')->user()->id);
        $page_title = "Profile";
        $page_action = "My Profile";
        $viewPage = "Admin";
        $method = $request->method();
        $msg = "";
        $error_msg = [];
        if($request->method()==='POST'){
            $messages = ['password.regex' => "Your password must contain 1 lower case character 1 upper case character one number"];

            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'min:6',
                'name' => 'required', 
        ]);
        /** Return Error Message **/
        if ($validator->fails()) {

            $error_msg  =   $validator->messages()->all(); 
           return view('packages::users.admin.index',compact('error_msg','method','users','page_title','page_action','viewPage'))->with('flash_alert_notice', $msg)->withInput($request->all());
        }
            $users->name= $request->get('name');
            $users->email= $request->get('email');
            if($request->get('password')!=null){
                $users->password=    Hash::make($request->get('password'));
            }
            $users->save();
            $method = $request->method();
            $msg = "Profile details successfully updated.";
        } 
       return view('packages::users.admin.index',compact('error_msg','method','users','page_title','page_action','viewPage'))->with('flash_alert_notice', $msg)->withInput($request->all());
       
     
   }
   public function errorPage()
   {
        $page_title = "Error";
        $page_action = "Error Page";
        $viewPage = "404 Error";
        $msg = "page not found";
        return view('packages::auth.page_not_found',compact('page_title','page_action','viewPage'))->with('flash_alert_notice', $msg);

   }  
}
