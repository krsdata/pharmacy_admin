<?php
namespace Modules\Admin\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Illuminate\Http\Request;
use Modules\Admin\Http\Requests\CategoryRequest;
use Modules\Admin\Models\User;
use Input, Validator, Auth, Paginate, Grids, HTML;
use Form, Hash, View, URL, Lang, Session, DB;
use Route, Crypt, Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Dispatcher;
use App\Helpers\Helper;
use Modules\Admin\Models\Roles;
use Modules\Admin\Models\Menu; 
use Modules\Admin\Models\Wallets;
use Modules\Admin\Models\MatchContest;
use Modules\Admin\Models\MatchTeams;
use App\Models\Matches;
use App\Models\JoinContest;
use App\Models\WalletTransaction;
use App\Models\CreateContest;
use App\Models\CreateTeam;
use Modules\Admin\Models\Player;
use PDF;

/**
 * Class MenuController
 */
class MatchContestController extends Controller {
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
        View::share('viewPage', 'matchContest');
        View::share('sub_page_title', 'Match Contest');
        View::share('helper',new Helper);
        View::share('heading','Match Contest');
        View::share('route_url',route('matchContest'));

        $this->record_per_page = 30; //??Config::get('app.record_per_page');
    }

    public function contestReports(MatchTeams $matchTeams, Request $request)
    {   
        $page_title = 'Contest Reports';
        $sub_page_title = 'Contest Reports';
        $page_action = 'Contest Reports'; 
        $match_id = $request->get('match_id');
        $contest_id = $request->get('contest_id');

        $contest = CreateContest::find($contest_id);

        $created_team_id = \DB::table('join_contests')
                    ->where('contest_id',$contest_id)
                    ->where('match_id',$match_id)
                    ->pluck('created_team_id')
                    ->toArray();

        $matchTeams = MatchTeams::whereIn('id',$created_team_id)
                    ->orderBy('points' ,'DESC')
                    ->get();                                  
            $matchTeams->transform(function($item,$key)use($contest_id){ 
                
                    $match = Matches::where('match_id',$item->match_id)->select('short_title','status_str')->first();
                    $item->status = $match->status_str??null;
                    $item->match_name = $match->short_title??null;

                    $teams = json_decode($item->teams);

                    $teams = Player::where('match_id',$item->match_id)->whereIn('pid',$teams)
                        ->get(['pid','team_id','match_id','title','short_name','playing_role','fantasy_player_rating']);
                    $item->teams = $teams; 

                    $user = User::find($item->user_id);
                    $item->user_name = $user->name??null; 
                    $item->referral_code = $user->reference_code??null;
            $joinContest = JoinContest::where('match_id',$item->match_id)
                ->where('team_count',$item->team_count)
                ->where('contest_id',$contest_id)
                ->where('user_id',$item->user_id)
                ->where('created_team_id',$item->id)
                ->first();

                if($joinContest){
                    $item->point = $joinContest->points;
                    $item->rank  = $joinContest->ranks;
                    $item->prize_amount = $joinContest->winning_amount;
                }else{
                    $item->point = 0;
                    $item->rank  = 0;
                    $item->prize_amount = 0;   
                }
                    
                return $item; 
            });

        //dd($matchTeams);    
        $table_cname = \Schema::getColumnListing('create_teams');
        
        $except = ['id','created_at','updated_at','contest_id','user_id','isWinning','edit_team_count','team_id','captain','vice_captain','trump','teams','team_join_status','points','rank','prize_amount','is_cloned','rail_id','editable','match_id'];
        $data = [];

        $tables[] = 'match_name';
        $tables[] = 'status';
        $tables[] = 'user_name';
        $tables[] = 'referral_code';
        $tables[] = 'rank';
        $tables[] = 'point';
        $tables[] = 'prize_amount';

      //  $tables[] = 'join_status';

        foreach ($table_cname as $key => $value) {

           if(in_array($value, $except )){
                continue;
           }
              
            $tables[] = $value;
        }

        $contest_id = $request->contest_id;

        $contest_type = \DB::table('contest_types')->where('id',$contest->contest_type)->first();
        $contest_name = $contest_type->contest_type??'';

        $pdf = PDF::loadView('packages::matchContest.reports', compact('matchTeams','tables','contest_id','contest_name','contest'));
        
        return $pdf->download($contest_name.'.pdf');
    }

    public function matchTeams(MatchTeams $matchTeams, Request $request)
    {   

        $page_title = 'Users Team';
        $sub_page_title = 'User Teams';
        $page_action = 'View user Teams'; 
         
        // Search by name ,email and group
        $search = Input::get('search');
        $status = Input::get('status');
       /* $user =  User::where('email','LIKE',"%$search%")
                            ->orWhere('first_name','LIKE',"%$search%")
                            ->orWhere('phone','LIKE',"%$search%")
                            ->get('id')->pluck('id');*/
        $user = User::where('id',285)->pluck('id');

        $contest_id = $request->contest_id; 

        $created_team_id = JoinContest::where('match_id',$search)->where('contest_id',$contest_id)->orderBy('ranks','asc')
            ->pluck('created_team_id')->toArray();
        
        if ((isset($search) && !empty($search))) { 
            $matchTeams = MatchTeams::where(function($query) use($search,$status,$user,$contest_id,$created_team_id) {
                        if (!empty($search)) {
                            $query->where('match_id', $search);
                         }
                         if ($user) {
                             $query->whereIn('user_id', $user);
                         }
                         if($created_team_id){
                            $query->whereIn('id', $created_team_id);
                         }
                    })->pluck('id');
            
            $matchTeams = JoinContest::where('match_id',$search)
            ->where(function($q)use($contest_id){
                if($contest_id){
                    $q->where('contest_id',$contest_id);    
                }
            })
            ->orderBy('ranks','asc')->Paginate(30);
            
            $matchTeams->transform(function($item,$key)use($contest_id){ 
                $joinContest = $item;

                $matchTeams = CreateTeam::find($item->created_team_id);
                
                
                $item->captain      = $matchTeams->captain;
                $item->vice_captain = $matchTeams->vice_captain;

                if($joinContest){
                    $item->point = $joinContest->points;
                    $item->rank  = $joinContest->ranks;
                    $item->prize_amount = $joinContest->winning_amount;
                }else{
                    $item->point = 0;
                    $item->rank  = 0;
                    $item->prize_amount = 0;   
                }

                $match = Matches::where('match_id',$item->match_id)->select('short_title','status_str')->first();
                $item->status = $match->status_str??null;
                $item->match_name = $match->short_title??null;

                $cc = MatchTeams::where('match_id',$item->match_id)
                    ->where('id',$item->created_team_id)->first();

                $teams = json_decode($cc->teams);
                $teams = Player::where('match_id',$item->match_id)
                        ->whereIn('pid',$teams)
                        ->get(['pid','team_id','match_id','title','short_name','playing_role','fantasy_player_rating']);

                $user = User::find($item->user_id);
                $item->user_name = $user->team_name??$user->name;
                $item->user_id = '<a href="user?search='.$user->email.'">'.$user->id.'</a>';
                $item->referral_code = $user->reference_code??null;
                $item->teams = $teams;
                

                $join_status =  ($cc->team_join_status==1)?'<span class="btn btn-success btn-xs">Joined</span>':'<span class="btn btn-danger btn-xs">Not Joined</span>';

                $item->join_status = $join_status;
                return $item; 
            });
        } else {
            $matchTeams = MatchTeams::orderBy('created_at','desc')->orderBy('id','desc')->Paginate($this->record_per_page);
                                                  
            $matchTeams->transform(function($item,$key){ 

                    

                    $match = Matches::where('match_id',$item->match_id)->select('short_title','status_str')->first();
                    $item->status = $match->status_str??null;
                    $item->match_name = $match->short_title??null;

                    $teams = json_decode($item->teams);

                    $teams = Player::where('match_id',$item->match_id)->whereIn('pid',$teams)
                        ->get(['pid','team_id','match_id','title','short_name','playing_role','fantasy_player_rating']);
                    $item->teams = $teams; 

                    $user = User::find($item->user_id);
                    $item->user_name = $user->team_name??$user->name; 
                    $item->referral_code = $user->reference_code??null;

                    $item->user_id = '<a href="user?search='.$user->email.'">'.$user->id.'</a>';

            $joinContest = JoinContest::where('match_id',$item->match_id)
                ->where('team_count',$item->team_count)
                ->where('user_id',$item->user_id)
                ->where('created_team_id',$item->id)
                ->first();

                if($joinContest){
                    $item->point = $joinContest->points;
                    $item->rank  = $joinContest->ranks;
                    $item->prize_amount = $joinContest->winning_amount;
                }else{
                    $item->point = 0;
                    $item->rank  = 0;
                    $item->prize_amount = 0;   
                }
                    $item->join_status =  ($item->team_join_status==1)?'<span class="btn btn-success btn-xs">Joined</span>':'<span class="btn btn-danger btn-xs">Not Joined</span>';
                        
                    return $item; 
            });

        } 
        $table_cname = \Schema::getColumnListing('create_teams');
        
        $except = ['id','created_at','updated_at','contest_id','user_id','isWinning','edit_team_count','team_id','captain','vice_captain','trump','teams','team_join_status','points','rank','prize_amount','rail_id','is_cloned','editable','extra_cash_usable'];
        $data = [];

        $tables[] = 'match_name';
        $tables[] = 'status';
        $tables[] = 'user_name';
        $tables[] = 'user_id';
        $tables[] = 'referral_code';
        $tables[] = 'rank';
        $tables[] = 'point';
        $tables[] = 'prize_amount';

        $tables[] = 'join_status';

        foreach ($table_cname as $key => $value) {

           if(in_array($value, $except )){
                continue;
           }     
            $tables[] = $value;
        }
        $contest_id = $request->contest_id;
        $match_id   = $request->search;

        $lastSeen = \DB::table('eventLogs')
                    ->where('match_id',$match_id)
                    ->where('contest_id',$contest_id)
                    ->limit(10)->orderBy('id','desc')
                    ->get()
                    ->transform(function($item,$key)use($contest_id) { 
                    $td = \DB::table('join_contests')
                        ->where('created_team_id',$item->team_id)
                        ->where('contest_id',$contest_id)
                        ->first();
                    
                    $item->team_name =  $td->team_name.'-'.$td->team_count;
                    //.'('.$td->team_count.')';
                    $item->seentime =  $item->date_time;
                    $item->seenby   =  $item->email;
                    return $item;
                }); 

        return view('packages::matchContest.matchTeams', compact('matchTeams', 'page_title', 'page_action','sub_page_title','tables','contest_id','lastSeen'));
    }

    /*
     * Dashboard
     * */

    public function index(MatchContest $matchContest, Request $request)
    {

        $page_title = 'Match Contest';
        $sub_page_title = 'Match Contest';
        $page_action = 'View Match Contest'; 
        

        $match_id = $request->match_id ;//= 45626;  
        // Search by name ,email and group
        $search = Input::get('search');
        $status = Input::get('status');
        $user = User::where(function($q) use($request,$search){
            if($request->email){
                $q->orWhere('email','LIKE',$request->email);
            }
            if($search){
                $q->orWhere('name','LIKE',"%$search%");
                $q->orWhere('team_name','LIKE',"%$search%");
                $q->orWhere('phone','LIKE',"%$search%");
            }
                
        })->pluck('id')->toArray();    
        $joinContest = [];  

        if($user){
                $joinContest = JoinContest::where('match_id',$match_id)
                                ->whereIn('user_id',$user)
                                ->pluck('contest_id')
                                ->toArray();
            }
                        
        if ((isset($search) && !empty($search)) || $joinContest) { 
            //dd($joinContest);
            $matchContest = MatchContest::where(function($query) use($search,$status,$user,$joinContest) {
                        if (!empty($search) && !$user) {
                             $query->where('match_id', $search);
                             $query->where('filled_spot','>',0);
                         }
                         //dd($joinContest);
                         if($joinContest){
                            $query->whereIn('id',$joinContest);
                         }
                    })->orderBy('total_spots','DESC')->Paginate(50);
                
            

            $matchContest->transform(function($item,$key){ 
               
                $contest_name = \DB::table('contest_types')->where('id',$item->contest_type)->first();
                $item->contest_name = $contest_name->contest_type??null;

                $joinContest = JoinContest::where('match_id',$item->match_id)
                    ->where('contest_id',$item->id)
                    ->orderBy('winning_amount','desc')->limit(1)->first();
                 $item->cancel_status = 'No';  
                 if(!isset($joinContest->user_id)){
                  // dd($item->id);
                 }
                 $user = User::find($joinContest->user_id);
                      
                if($joinContest && isset($user->id)){
                    

                    $link1 = '<a target="_blank" href="'.url('admin/matchContest?match_id='.$item->match_id.'&email='.$user->email??null).'">'.$user->team_name??$user->name.'</a>';
                 
                    $link2 = '<a target="_blank" href="'.url('admin/user?search='.$user->email??null).'">'.$user->id??null.'</a>';
                     //  dd( $link1);
                    $first_ranker = $joinContest->winning_amount??0;
                    $item->first_ranker = $user->name.'<br>'.$link1.'<br><b>'.$first_ranker.' INR </b><br>';
                    $status = $joinContest->cancel_contest;
                    $item->cancel_status = $status?'Yes':'No';
                    $item->user_id = $link2;
                }

                return $item; 
            });

            $is_match =true;
        } else {
            $matchContest = MatchContest::orderBy('total_winning_prize','desc')->Paginate(15);
                                                    
            $matchContest->transform(function($item,$key){ 
                    $contest_name = \DB::table('contest_types')->where('id',$item->contest_type)->first();
                    $item->contest_name = $contest_name->contest_type??null;
                    $match = Matches::where('match_id',$item->match_id)->select('short_title','status_str')->first();
                    $item->status = $match->status_str??'Cancel';  
                    return $item; 
            });
        } 
        
        $table_cname = \Schema::getColumnListing('create_contests');
        $except = ['created_at','updated_at','winner_percentage','prize_percentage','is_cancelled','contest_type','default_contest_id','cancellation','is_free','is_cloned','is_full','sort_by','deleted_at','is_cancelable','id','usable_bonus','bonus_contest','discounted_price','extra_cash_usable',
            'offer_end_at','mega_rewards','match_id','auto_create',
            'contest_category_type','gift_url'];
        $data = [];

        $tables[] = 'contest_name';
        if(isset($is_match)){
            $tables[] = 'first_ranker';
            $tables[] = 'user_id';
            $tables[] = 'cancel_status';    
        }
        
        foreach ($table_cname as $key => $value) {

           if(in_array($value, $except )){
                continue;
           }
              
            $tables[] = $value;
        }

        return view('packages::matchContest.index', compact('matchContest', 'page_title', 'page_action','sub_page_title','tables'));
    }

    /*
     * create Group method
     * */

    public function create(MatchContest $matchContest)
    {

        $page_title     = 'Match Contest';
        $page_action    = 'Create Wallets';
        $table_cname = \Schema::getColumnListing('create_contests');
        $except = ['id','created_at','updated_at'];
        $data = [];
        foreach ($table_cname as $key => $value) {

           if(in_array($value, $except )){
                continue;
           }
             $tables[] = $value;
        }

        return view('packages::matchContest.create', compact('matchContest', 'page_title', 'page_action','tables'));
    }

    /*
     * Save Group method
     * */

    public function store(Request $request, MatchContest $matchContest)
    {
        $data = [];
        $table_cname = \Schema::getColumnListing('create_contests');
        $except = ['id','created_at','updated_at','_token','_method'];
        $data = [];
        foreach ($table_cname as $key => $value) {

           if(in_array($value, $except )){
                continue;
           }
            if($request->$value!=null){
                $wallets->$value = $request->$value;
           }
        }
        $wallets->save();
        return Redirect::to(route('Match Contest'))
                            ->with('flash_alert_notice', 'Wallets successfully created !');
        }

    /*
     * Edit Group method
     * @param
     * object : $menu
     * */

    public function edit($id) {
        $wallets = MatchContest::find($id);
        $page_title = 'Match Contest';
        $page_action = 'Match Contest';

        $table_cname = \Schema::getColumnListing('create_contests');
        $except = ['id','created_at','updated_at'];
        $data = [];
        foreach ($table_cname as $key => $value) {

           if(in_array($value, $except )){
                continue;
           }
             $tables[] = $value;
        }


        return view('packages::matchContest.edit', compact( 'create_contests', 'page_title','page_action', 'tables'));
    }

    public function update(Request $request, $id) {

        $wallets = MatchContest::find($id);
        $data = [];
        $table_cname = \Schema::getColumnListing('create_contests');
        $except = ['id','created_at','updated_at','_token','_method'];
        $data = [];
        foreach ($table_cname as $key => $value) {

           if(in_array($value, $except )){
                continue;
           }
            if($request->$value){
                $wallets->$value = $request->$value;
           }
        }
        $wallets->save();

        return Redirect::to(route('matchContest'))
                        ->with('flash_alert_notice', ' Match Contest  successfully updated.');
    }
    /*
     * Delete User
     * @param ID
     *
     */
    public function destroy($id) {
        #PrizeDistribution::where('id',$id)->delete();
        return Redirect::to(route('matchContest'))
                        ->with('flash_alert_notice', ' wallets  successfully deleted.');

    }

}
