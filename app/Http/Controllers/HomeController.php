<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use Illuminate\Support\Facades\Auth; 
use App\Models\Notification;
use Illuminate\Contracts\Encryption\DecryptException;
use Config,Mail,View,Redirect,Validator,Response; 
use Crypt,okie,Hash,Lang,JWTAuth,Input,Closure,URL; 
use App\Helpers\Helper as Helper;
use Illuminate\Support\Facades\Storage;
use App\Models\Competition;
use App\Models\TeamA;
use App\Models\TeamB;
use App\Models\Toss;
use App\Models\Venue;
use App\Models\Matches;
use App\Models\ReferralCode;
use Session;
use App\User;
use App\Models\WalletTransaction;
use App\Models\Wallet;


class HomeController extends BaseController
{
   
    public function __construct(Request $request) {
        $pages = \DB::table('pages')->get(['title','slug']);
        View::share('static_page',$pages);

        $settings = \DB::table('settings')
                    ->pluck('field_value','field_key')
                    ->toArray();
       
        View::share('settings',(object)$settings);

    }  


    public function myAffiliate(Request $request){

        $referral = $request->user_id??'MAAHI11';
        $user = User::where('user_name',$referral)->first();

        $total_registered = User::select('id','name','team_name')
            ->where('reference_code',$user->referal_code)
            ->count();

        $myAffiliate = User::select('id','name','team_name')
            ->where('reference_code',$user->referal_code)
            ->whereIn('id', WalletTransaction::where('payment_type',3)
                    ->pluck('user_id')
                    ->toArray())
            ->get();

        $total_user = $myAffiliate->count();

        $myAffiliate->transform(function ($item, $key)   {  
                $wt = WalletTransaction::where('user_id',$item->id)
                    ->where('payment_type',3)
                    ->sum('amount');
                 $item->deposit = round($wt,2);   
                 if($item->deposit>0){
                    $winning = WalletTransaction::where('user_id',$item->id)
                    ->where('payment_type',4)
                    ->sum('amount');
                     $item->winning = round($winning,2); 
                     return $item;
                 }
                 
        });  
        $commission = \DB::table('affiliate_programs')
                                ->where('user_id',$user->id)
                                ->sum('amount');
       

        $total_deposit =  $myAffiliate->sum('deposit');
        $total_winning =  $myAffiliate->sum('winning'); 

        $remove_header = true;
        if($request->get('request')=='mobile'){
            $remove_header = true;
        }
            
         return view('myAffiliate',compact('myAffiliate','total_deposit','total_winning','total_user','user','commission','remove_header','total_registered'));
    }

    public function page404(Request $request){
         return view('404');
    }
    public function home(Request $request){

        $matches = Matches::with('teama','teamb')->where('status',1)
                    ->where('timestamp_start','>',time())
                    ->limit(9)->orderBy('timestamp_start','asc')
                    ->get();

        $next_matches = Matches::with('teama','teamb')
                    ->whereIn('status',[1,3])
                    ->where('timestamp_start','>',time())
                    ->where('order_by',2)
                    ->limit(2)
                    ->orderBy('timestamp_start','asc')
                    ->get();
       
                    
        return view('home',compact('matches','next_matches'));
    }

    public function liveChat(Request $request){
        return view('liveChat');
    }

    public function aboutus(Request $request){

        return view('aboutus');
    }

    public function topReferralUser(Request $request){
       // dd($request->all());
        $user = \DB::table('referral_codes')->get()->groupBy('refer_by');
        
        foreach ($user as $key => $value) {
            $refer[$key] = $value->count();
        }
        arsort($refer);
        $html = '<table border="1" cellpadding="5" cellspacing="0" bgcolor="#FCFCFC"><tr><td>Sno.</td><td>Top 50 Referral user</td><td>Total</td></tr>';
        
        try{

            $i=1;
        foreach ($refer as $key => $value) {
            if($i==51){
                break;
            }
            $topRef = \DB::table('users')->where('id',$key)->first();
           if(!empty($topRef)){
                
                $html .= "<tr><td>".$i++."</td><td>".$topRef->name."</td><td>".$value."</td></tr>";
           }
        }
        echo $html.'</table>';
        }catch(\Excecption $e){
            dd($e);
        }
    }
    

    public function contactus(Request $request){

        if($request->method()=="POST"){

        $request->merge(['request_id'=>time()]);
        $request->merge(['title'=> 'web_request']);
        $request->merge(['name' => $request->name]);
        $request->merge(['mobile'=> $request->mobile]);

        $request->merge(['subject'=> 'Enquiry']);
        
        $table_cname = \Schema::getColumnListing('contacts');
        $except = ['id','created_at','updated_at'];
        $data = [];
        foreach ($table_cname as $key => $value) {
           
           if(in_array($value, $except )){
                continue;
           } 
            if($request->get($value)){
                $data[$value] = $request->get($value);
           }
        }
        \DB::table('contacts')->insert($data);
        Session::put('status','Your Request successfully submitted!');
        
        }

        return view('contactus');
    }
    public function getPage(Request $request, $name=null){
        
        $content = \DB::table('pages')
                ->where('slug',$name)
                ->first();
        if( $content==null){
            return view('404',compact('content'));
        }
        $remove_header = false;
        if($request->get('request')=='mobile'){

            $remove_header = true;

        }


        return view('page',compact('content','remove_header'));
    }

    public function liveScore(Request $request)
    {
        
        $match_id = $request->match_id;
        
        if($match_id){
            $url = "https://rest.entitysport.com/v2/matches/".$match_id."/scorecard?token=".env('CRIC_API_KEY');
        
            $mt = \DB::table('live_scores')->where('match_id',$match_id)->first();
            
            $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL => $url,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "GET",
              CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache",
            "content-type: application/json"
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        $rs = [];
        if ($err) {
            $rs = [];
        } else {
            $data = json_decode($response);
            $rs = $data->response??[];
             
            \DB::table('live_scores')->updateOrInsert(
                ['match_id'=>$match_id],
                [
                    'match_id' => $match_id,
                    'response' => json_encode($rs)
                ]
            );
            
            //return  (array)$rs; 
        }
        }
        $rs = $rs??[];
        $notes = false;
        if(isset($rs->innings)){
            foreach($rs->innings as $key => $value ){
         //  foreach($innings as $key => $value ){
                
                  $status = $value->status;
                  if($status==3){
                        $batsmen = $value->batsmen;
                      
                        $batsmen1 = $batsmen[0]->name.':'.$batsmen[0]->runs.'('.$batsmen[0]->balls_faced.')';
                         $batsmen2 = $batsmen[1]->name.':'.$batsmen[1]->runs.'('.$batsmen[1]->balls_faced.')';
                        $notes =   $batsmen1.', '.$batsmen2;


                        \DB::table('matches')
                                ->where('match_id',$match_id)
                                ->update(['status_note' => $notes]);
                  }  
            } 
        } 
         

        if($request->match_id){
            $liveMatch = Matches::with('teama','teamb')->where('match_id',$request->match_id)->get();
        
        }else{
            $liveMatch = Matches::with('teama','teamb')->where('status',3)->get();
            
        }
        
        $remove_header = false;
        if($request->get('request')=='mobile'){
            $remove_header = true;
        }
        return view('liveScore',compact('remove_header','rs','liveMatch','notes'));
    }
}
