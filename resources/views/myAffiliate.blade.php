@extends('layouts.master') 
    @section('header')
    <h1>Dashboard</h1>
    @stop
    @section('content') 
     @if($remove_header==false)
      @include('partials.navigation') 
    @endif
<style type="text/css">
  .page_title{
    margin-top: -110px;right: 10px;position: absolute;background: #fff;padding: 10px;border-radius: 10px;
    font-family: 'Raleway', sans-serif;
    
  }
  .divider-left{
    height: 4px;
    width: 70px;
    background: #dd2342;
    display: block;
    margin-top: 1px; 
  }
  .divider{
    background: #151515;
    height: 1px;
    width: 70px !important;
    margin-left: 0px;
    position: absolute;
    left: 70px;
    top: 50px;
  }
</style>

  <!--Section: Content-->
  <section  id="termscondition" data-aos="fade-up">
      <div class="container">
           <div class="row justify-content-end">
        @if($remove_header==false)
        
        @endif
          <div class="col-md-12" style="margin-top:10px">     
            <div class="faq_content wow fadeIn animated" data-wow-delay="400ms">
              
              <h2 class="heading heading_space wow fadeInDown animated" style="visibility: visible; animation-name: fadeInDown;">
                <span>My Affiliate Details</span>
                <span class="divider-left">
                  
                </span>
                <span class="divider">
                  
                </span>
            </h2>       
          </div>
          <div class="heading heading_space wow fadeInDown animated" style="padding: 10px">
            <div class="col-md-12 wow fadeInRight animated animated" data-aos="fade-right" data-wow-delay="450ms" style="visibility: visible; animation-delay: 450ms; animation-name: fadeInRight;"> 
                
        <form method="POST" action="contactus" accept-charset="UTF-8" class="form-inline findus" id="contact-form"> 
          <div class="row">
            <div class="col-md-4 col-sm-4">
              <div class="form-group ">
                <style type="text/css">
                  .form-group{
                    margin: 5px;
                  }
                </style>
                <button type="button" class="form-group btn btn-primary">Referral Code: {{$user->referal_code??null}} </button>
                  <button type="button" class="form-group btn btn-purple">My Total  Users: {{$total_registered??0}} </button>
                  <button type="button" class="form-group btn btn-secondary">My Active  Users: {{$total_user??0}} </button>
                  
                  <button type="button" class="form-group btn btn-success">Total User Deposit: {{$total_deposit??0}} INR</button>
                  
                  <button type="button" class="form-group btn btn-danger">Total User Winning: {{$total_winning??0}} INR</button>
                   
                  <button type="button" class="form-group btn btn-info">Total Commission: {{round($commission,2)}} INR</button>
                   
                  <button type="button" class="form-group btn btn-dark" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">View All Active User</button>
                 
              </div>
 

            </div> 
          </div>
        </form>

        <div class="collapse" id="collapseExample">
            <div class="card">
               <table class="table table-striped" cellpadding="5" cellspacing="2">
                 <tr align="center">
                   <td><b>Name</b></td> 
                     <td><b>Deposit</b></td>
                      <td><b>Winning</b></td>
                 </tr>
                 @foreach($myAffiliate as $key => $result)
                  <tr>
                   <td>{{++$key}}. {{$result->team_name}}</td> 
                   <td>{{$result->deposit}}</td>
                   <td>{{$result->winning}}</td>
                     
                 </tr>
                 @endforeach
               </table>
            </div>
          </div>
        
    </div>
          </div>
        </div>
      </div>
    </div>
</section>

@stop