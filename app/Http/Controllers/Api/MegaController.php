<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\QueryException;
use Config,Mail,View,Redirect,Validator,Response;
use Crypt,okie,Hash,Lang,JWTAuth,Input,Closure,URL;
use App\Helpers\Helper as Helper;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Monolog\Handler\StreamHandler;
use Illuminate\Support\Str;
use Monolog\Handler\SyslogUdpHandler;
use App\Models\Competition;
use App\Models\TeamA;
use App\Models\TeamB;
use App\Models\Toss;
use App\Models\Venue;
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
use App\Models\MatchStat;
use App\Models\ReferralCode;
use App\Models\PrizeBreakup;
use File;
use Ixudra\Curl\Facades\Curl;
use Jenssegers\Agent\Agent;
use App\Http\Controllers\ApiController;


class MegaController extends BaseController
{

    public $token;
    public $date;
    public $cric_url;
    public $is_session_expire;

    public function __construct(Request $request) {
        $agent      = new Agent();

        $data['platform']   = $agent->platform();
        $data['device']     = $agent->device();
        $browser            = $agent->browser();
        $data['robot']      = $agent->isRobot();
        $data['robotName']  = $agent->robot();
        $platform = $agent->platform();
        $data['version']    = $agent->version($platform);
        $data['user_id']    = $request->user_id;
        $data['request']    = json_encode($request->all());
       // \DB::table('device_details')->insert($data);
        $okhttp = Str::contains($request->url(), 'paytmCallBack');
        if($okhttp){

        }else{

            if($data['robotName']==='Okhttp' || $data['robotName']==='Curl' || $request->allowme){
               // $detect->version('Android');
            } 
        }

        $this->date = date('Y-m-d');
        $this->token = env('CRIC_API_KEY',"8740931958a5c24fed8b66c7609c1c49");
        $request->headers->set('Accept', 'application/json');
        
        $this->cric_url = 'https://rest.entitysport.com/v2/';

        if ($request->header('Content-Type') != "application/json")  {
            $request->headers->set('Content-Type', 'application/json');
        }
        $user_name = $request->user_id;
        $user = User::where('user_name',$user_name)->first();
        if($user && $request->user_id){
            $this->is_session_expire = false;
            $request->merge(['user_id'=>$user->id]);    
        }else{
            $this->is_session_expire = true;
            $request->merge(['user_id'=>null]);
        }
        if($user && $user->status=='0'){
            $this->is_session_expire = true;
            $request->merge(['user_id'=>null]);
        }
    }


    public function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
        $sort_col = array();
        foreach ($arr as $key=> $row) {
            $sort_col[$key] = $row[$col];
        }

        return  array_multisort($sort_col, $dir, $arr);
    }

    /*
    mega Contest
    */

    public function  createAutoTeam(Request $request)
    {
        $match_id = 45058;
        $request->merge(['match_id'=>$match_id]);
        $player_list = $this->getPlayer($request);
       // dd($player_list);
        try {
            foreach ($player_list as $role =>   $player) {

                foreach ($player as $key => $results) {
                    $p_role = $key;

                    $keys = array_column($results, 'selection');
                    array_multisort($keys, SORT_DESC, $results);
                    foreach ($results as $key =>  $result) {
                        $result = (object) $result; //dd($result);
                        if($result->playing11==true){
                            $total_player[] =  $result->pid;
                            $pid[$p_role][$result->pid] = $result->selection;
                          //  $team_name[$p_role][$result->team_name][] = [$result->pid => $result->selection];

                            $team_name[$result->team_name][$p_role][$result->pid] = $result->selection; 

                        }
                    }
                }
                $final_player_id = [];


                foreach ($pid as $key => $value) {
                    if($key=='wk'){
                        $pid_key = array_key_first($value);
                        $final_player_id[] = $pid_key;
                    }
                    elseif($key=='all'){
                        $i  =   0;
                        foreach ($value as $key => $final_player) {
                            $i++;
                            if($i<=3){
                               $final_player_id[] = $key;
                            }
                        }
                       
                    }
                    elseif($key=='bat'){
                        $i  =   0;
                        foreach ($value as $key => $final_player) {
                            $i++;
                            if($i<=3){
                                $final_player_id[] = $key;
                            }else{
                                continue;
                            }
                        }
                    }

                    elseif($key=='bowl'){
                        $i  =   0;
                        foreach ($value as $key => $final_player) {
                            $i++;
                            if($i<=3){
                                $final_player_id[] = $key;
                            }else{
                                continue;
                            }
                        }
                    }
                }
                
                dd($team_name,$total_player,$final_player_id);

            }
        } catch (Exception $e) {
                dd($e);
        }
    } 

    public function getAnalyticsPlayer($match_id, $pid){
        $analytics  =   $this->getAnalytics($match_id);
        return $analytics->where('player_id',$pid)->first();
    }

    /*get Player*/

    public function getPlayer($request)
    {
        $analytics  =   $this->getAnalytics($request->match_id);
        $match_id   =   $request->match_id;
        $matchVald  =   Matches::where('match_id',$request->match_id)->count();
        
        $final_playing11 = $this->getPlaying11Team($match_id);

        $players =  Player::with(['teama'=>function($q) use ($match_id){
            $q->where('match_id',$match_id);
        }])
            ->with(['teamb'=>function($q)use ($match_id){
                $q->where('match_id',$match_id);
            }])
            ->with('team_b','team_a')
            ->where(function($q) use($match_id){
                $q->groupBy('playing_role');
                $q->where('match_id',$match_id);
            })
            ->orderBy('fantasy_player_rating','DESC')
            ->get();

        if(!$players->count()){
            return ['status'=>false,'code'=>404,'message'=>'Player not found',
                'response'=>[
                    'players'=>null
                ]
            ];
        }
        $rs['wk'] = [];
        $bat['bat'] = [];
        $bat['all'] = [];
        $bat['bowl'] = [];

        $match_points= MatchPoint::where('match_id',$match_id)->pluck('point','pid')->toArray();
        $pid = [];
         $playerPoints = $this->playerPoints($request);
        
        foreach ($players as $key => $results) {
            $data['playerPoints'] = $playerPoints[$results->pid]??0;
            if($results->teama && $results->teama->player_id==$results->pid ){
                $data['playing11'] =  filter_var($results->teama->playing11, FILTER_VALIDATE_BOOLEAN);
            }
            elseif($results->teamb &&  $results->teamb->player_id==$results->pid){

                $data['playing11'] =  filter_var($results->teamb->playing11, FILTER_VALIDATE_BOOLEAN);
            }

            if($results->team_a){
                $data['team_name'] = $results->team_a->short_name;
            }else{

                $data['team_name'] = $results->team_b->short_name;
            }

            $player_analytics   = $this->getAnalyticsPlayer($results->match_id,$results->pid);

            $data['trump']        = round(($player_analytics->trump??0),2);
            $data['vice_captain'] = round(($player_analytics->vice_captain??0),2);
            $data['captain']      = round(($player_analytics->captain??0),2);
            $data['selection']      = round(($player_analytics->selection??0),2);
            $data['count']      = round(($player_analytics->count??0),2);
            

            $data['pid']        = $results->pid;
            $data['match_id']   = $results->match_id;
            $data['team_id']    = $results->team_id;
            $data['points']     = ($match_points[$results->pid])??0;
            $fname = $results->first_name;
            $lname = $results->last_name;

            $title  = $results->title??$results->short_name;
            $fn     = explode(" ",trim($title));

            if(count($fn)>3){
                $fname = $fn[0][0]??'';
                $mname = $fn[1][0]??'';
                $lname = $fn[2][0]??'';
                $lname2 = $fn[3]??'';
                $pname = $fname.' '.$mname.' '.$lname.' '.$lname2;
            }
            elseif(count($fn)==3){
                $fname = $fn[0][0]??'';
                $mname = $fn[1][0]??'';
                $lname = $fn[2]??'';
                $pname = $fname.' '.$mname.' '.$lname;
            }
            elseif(count($fn)==2){
                $fname = $fn[0][0]??'';
                $mname = $fn[1]??'';
                $pname = $fname.' '.$mname;
            }else{
                $pname  = $title;
            }
            $data['short_name'] =  $pname;
            
            $data['fantasy_player_rating'] = ($results->fantasy_player_rating);

            $sel_per = $analytics->where('player_id',$results->pid)->first();
            
            if($sel_per){
                $data['analytics'] = $analytics->where('player_id',$results->pid)->first();
            }else{
                $data['analytics'] = [
                    'selection'     => "0.0",
                    'trump'         => "0.0",
                    'vice_captain'  => "0.0",
                    'captain'       => '0.0'
                ];
            }
            $pids[$data['pid']][] = $data['pid'];

            if(count($pids[$data['pid']])>1){
                continue;
            }
            $pid = $results->pid;
            $data['playing11'] =  false;
            
            if(is_array($final_playing11) && count($final_playing11) && isset($final_playing11[$pid])){
                $rol = $final_playing11[$pid]??$results->playing_role;
                $data['playing11'] =  true;
            }

            if($results->playing_role=="cap")
            {
                $rs['bat'][]  = $data;
            }
            if($results->playing_role=="wkcap")
            {
                $rs['wk'][]  = $data;
            }
            elseif($results->playing_role=="wkbat")
            {
                $rs['wk'][]  = $data;
            }else{
                $rs[$results->playing_role][]  = $data;
            }
            $data = [];
        }
        return  [
                'players '=>$rs
        ];
    }

    public function getAnalytics($match_id = null){
        
        $ct = CreateTeam::where('match_id',$match_id)->count();
        $player = \DB::table('player_analytics')->select('player_id',\DB::raw('COUNT(player_id) as count'))->where('match_id',$match_id)->groupBy('player_id')->where('created_team_id','>',0)->get()
            ->transform(function($item,$key) use($ct,$match_id){
                if($ct){
                  $percent = ($item->count/$ct)*100;  
              }else{
                    $percent = 0;
              }
                $trump = \DB::table('create_teams')
                        ->where('match_id',$match_id)
                        ->where('trump',$item->player_id)
                        ->count();
                $vc = \DB::table('create_teams')
                        ->where('match_id',$match_id)
                        ->where('vice_captain',$item->player_id)
                        ->groupBy('vice_captain')
                        ->count();
                $captain = \DB::table('create_teams')
                        ->where('match_id',$match_id)
                        ->where('captain',$item->player_id)
                        ->groupBy('captain')
                        ->count();
                $trump_per = ($trump/$ct)*100;
                $vc_per = ($vc/$ct)*100;
                $captain_per = ($captain/$ct)*100;
                
                $item->selection = number_format($percent,1);
                $item->trump = $trump_per;  
                $item->vice_captain = $vc_per;
                $item->captain = $captain_per; 

                return $item;

            });

        return $player;
    }   
    /*
    playing 11 team
    */
    public function getPlaying11Team($match_id=null){
        $playing11a  =\DB::table('team_a_squads')
                ->where('match_id',$match_id)
                ->where('playing11','true')
                ->pluck('role','player_id')->toArray();
               // dd($playing11_a );
        $playing11b  =\DB::table('team_b_squads')
                ->where('match_id',$match_id)
                ->where('playing11','true')
                ->pluck('role','player_id')->toArray();
        $a = array_merge($playing11a,$playing11b);


        $playing11a1  =\DB::table('team_a_squads')
                ->where('match_id',$match_id)
                ->where('playing11','true')
                ->pluck('player_id')->toArray();
               // dd($playing11_a );
        $playing11b1  =\DB::table('team_b_squads')
                ->where('match_id',$match_id)
                ->where('playing11','true')
                ->pluck('player_id')->toArray();
        $b = array_merge($playing11a1,$playing11b1);

        $final_playing11 = array_combine($b, $a);

        return $final_playing11;
    }

    public function playerPoints(Request $request){

        $match_id = $request->match_id;
        $cid = Competition::where('match_id',$match_id)
                    ->pluck('cid')->first();
                   
        $match = Matches::where('match_id',$match_id)->first();
        $competitions_match_id = Competition::where('cid',Competition::where('match_id',$match_id)
                    ->pluck('cid')->first()
                )->pluck('match_id');

        $match_pid = MatchPoint::where('match_id',$match_id)
                ->pluck('pid');
       // return $match_pid;
        $mathcPoint = MatchPoint::select('pid','match_id','point')
                ->whereIn('match_id',$competitions_match_id)    
                ->whereIn('pid',$match_pid)
                ->get()
                ->groupBy('pid');                
                $mathcPoint->transform(function($item,$key){
                    $item->playerPoints = $item->where('pid',$key)->sum('point');
                    return $item;
                });
        $data = [];        
        foreach ($mathcPoint as $key => $value) {
                    $data[$key] = (int)$value->playerPoints;
                }
        return $data;
    }
}