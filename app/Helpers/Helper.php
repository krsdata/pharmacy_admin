<?php

namespace App\Helpers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Mail;
use Auth;
use Config;
use View;
use Input;
use session;
use Crypt;
use Hash;
use Menu;
use Html;
use Illuminate\Support\Str;
use App\User;
use Phoenix\EloquentMeta\MetaTrait; 
use Illuminate\Support\Facades\Lang;
use App\CorporateProfile;
use Validator; 
use App\Position;
use App\InterviewRating;
use App\Interview;
use App\Criteria;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\RatingFeedback;
use PHPMailerAutoload;
use PHPMailer; 

class Helper {

    /**
     * function used to check stock in kit
     *
     * @param = null
     */ 
    public function __construct() {

    }
    public function notifyDocUploadToAdmin($title=null,$message=null){ 
        $user_email = [env('admin1_email'),env('admin2_email'),env('admin3_email')];
        
        $device_id = User::whereIn('email',$user_email)->pluck('device_id')->toArray();
          
          $data = [
              'action' => 'notify' ,
              'title' => $title ,
              'message' => $message
          ];
          
          try{
             // $helpr = new Helper; 
              $this->sendNotification($device_id,$data);
              return true;
          }catch(\ErrorException $e){
            
              return false;
          }
    } //
    public function notifyErrorToAdmin($title=null,$message=null){ 
        $user_email = [env('admin1_email')];
        $device_id = User::whereIn('email',$user_email)->pluck('device_id')->toArray();
          
          $data = [
              'action' => 'notify' ,
              'title' => $title ,
              'message' => $message
          ];
          
          try{
             // $helpr = new Helper; 
              $this->sendNotification($device_id,$data);
              return true;
          }catch(\ErrorException $e){
            
              return false;
          }
    } //

    public function notifyToAll($title=null,$message=null){ 
        
        $count =User::count(); 
        $j=1;
        for($i=1; $j<=$count; $i++) {
            $offset = $j;
            $j = $i*900; 
            $device_id = User::whereNotNull('device_id')
                  ->skip($offset)
                  ->take(900)
                  ->pluck('device_id')
                  ->toArray();
           
          $data = [
              'action' => 'notify' ,
              'title' => $title ,
              'message' => $message
          ];
          $this->sendNotification($device_id,$data);
        } 
    }
    public function notifyToAdmin($title=null,$message=null){ 
        $user_email = [env('admin1_email'),env('admin2_email'),env('admin3_email')];
        
        $device_id = User::whereIn('email',$user_email)->pluck('device_id')->toArray();
          
          $data = [
              'action' => 'notify' ,
              'title' => $title ,
              'message' => $message
          ];
          
          try{
             // $helpr = new Helper; 
              $this->sendNotification($device_id,$data);
              return true;
          }catch(\ErrorException $e){
            
              return false;
          }
    }

    public function sendNotification($token, $data){
     
      $serverLKey = env('serverLKey');
      $fcmUrl     = env('fcmUrl');

      $extraNotificationData = $data;

       if(is_array($token)){
            $fcmNotification = [
               'registration_ids' => $token, //multple token array
              // 'to' => $token, //single token
               //'notification' => $notification,
               'data' => $extraNotificationData
            ];
       }else{
            $fcmNotification = [
           //'registration_ids' => $tokenList, //multple token array
           'to' => $token, //single token
           //'notification' => $notification,
           'data' => $extraNotificationData
        ];
        }
       

       $headers = [
           'Authorization: key='.$serverLKey,
           'Content-Type: application/json'
       ];


       $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL, $fcmUrl);
       curl_setopt($ch, CURLOPT_POST, true);
       curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
       curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
       $result = curl_exec($ch);
       //echo "result".$result;
       //die;
       curl_close($ch);
       return true;
    }

    static public function generateRandomString($length=5) {
        $key = '';
        $keys = array_merge(range('A', 'Z') , range(0, 9) );

        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        } 
         return $key;
    }

/* @method : createCompanyGroup
    * @param : email,user_id
    * Response :  string
    * Return : company name
    */ 
 
   static public function validateTeam($team_id=null)
    {
        $user = User::where('id',$user_id)->count(); 
        return $user;
    }

    static public function validateMatchStatus($team_id=null)
    {
        $c = User::where('id',$user_id)->count(); 
        return $c;
    }

    static public function validateMatch($team_id=null)
    {
        $c = User::where('id',$user_id)->count(); 
        return $c;
    }
 
/* @method : isUserExist
    * @param : user_id
    * Response : number
    * Return : count
    */
    static public function isUserExist($user_id=null)
    {
        $user = User::where('id',$user_id)->count(); 
        return $user;
    }
 
/* @method : getpassword
    * @param : email
    * Response :  
    * Return : true or false
    */
    
    public static function getPassword(){
        $password = "";
        $user = Auth::user();
        if(isset($user)){
            $password = Auth::user()->Password;
        }
        return $password;
    }
/* @method : check mobile number
    * @param : mobile_number
    * Response :  
    * Return : true or false
    */     
   
    
    public static function FormatPhoneNumber($number){
        return preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $number). "\n";
    }
  
  
     
    public  function sendMailFrontEnd($email_content, $template)
    {        
        $email_content['verification_token'] =  Hash::make($email_content['receipent_email']);
        $email_content['email'] = isset($email_content['receipent_email'])?$email_content['receipent_email']:''; 
       $mail = new PHPMailer;
        $html = view::make('emails.'.$template,['content' => $email_content]);
        $html = $html->render(); 

        try {
            $mail->isSMTP(); // tell to use smtp
            $mail->CharSet = "utf-8"; // set charset to utf8
             

            $mail->SMTPAuth   = true;                  // enable SMTP authentication
            $mail->Host       = getenv('MAIL_HOST'); // sets the SMTP server
            $mail->Port       = getenv('MAIL_PORT');
            $mail->SMTPSecure = 'false';                 // set the SMTP port for the GMAIL server
            $mail->Username   = getenv('MAIL_USERNAME'); // SMTP account username
            $mail->Password   = getenv('MAIL_PASSWORD');

            $mail->setFrom(env('company_email'), env('company_name'));
            $mail->Subject = $email_content['subject'];
            $mail->MsgHTML($html);
            $mail->addAddress($email_content['receipent_email'], env('company_name'));

            //$mail->addAttachment(‘/home/kundan/Desktop/abc.doc’, ‘abc.doc’); // Optional name
            $mail->SMTPOptions= array(
                    'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            $mail->send();
            //echo "success";
            } catch (phpmailerException $e) {
             
            } catch (Exception $e) {
             
        } 
    } 
  /* @method : send Mail
    * @param : email
    * Response :  
    * Return : true or false
    */
    public  function sendMail($email_content, $template)
    {        
        $mail       = new PHPMailer;
        $html       = view::make('emails.'.$template,['content' => $email_content]);
        $html       = $html->render(); 
        $subject    = $email_content['subject'];

        try {
            $mail->isSMTP(); // tell to use smtp
            $mail->CharSet = "utf-8"; // set charset to utf8
             
            $mail->SMTPAuth   = true;                  // enable SMTP authentication
            $mail->Host       = getenv('MAIL_HOST'); // sets the SMTP server
            $mail->Port       = getenv('MAIL_PORT');
            $mail->SMTPSecure = 'false';                 // set the SMTP port for the GMAIL server
            $mail->Username   = getenv('MAIL_USERNAME'); // SMTP account username
            $mail->Password   = getenv('MAIL_PASSWORD');

            $mail->setFrom(env('company_email'), env('company_name'));
            $mail->Subject = $subject;
            $mail->MsgHTML($html);
            $mail->addAddress($email_content['receipent_email'], "admin");
            
            //$mail->addBCC(‘examle@examle.net’);
            //$mail->addAttachment(‘/home/kundan/Desktop/abc.doc’, ‘abc.doc’); // Optional name
            $mail->SMTPOptions= array(
            'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
            )
            );

            $mail->send();
            //echo "success";
            } catch (phpmailerException $e) {
             
            } catch (Exception $e) {
             
            }
    }
    /* @method : send Mail
    * @param : email
    * Response :  
    * Return : true or false
    */
    public  function sendNotificationMail($email_content, $template)
    {        
        return  Mail::send('emails.'.$template, array('content' => $email_content), function($message) use($email_content)
          {
            $name = $_SERVER['SERVER_NAME'];
            $message->from(env('company_email'),env('company_name'));
            $message->to($email_content['receipent_email'])->subject($email_content['subject']);
            
          });
    }
}
