
@extends('packages::layouts.master')
  @section('title', 'Dashboard')
    @section('header')
    <h1>Dashboard</h1>
    @stop
    @section('content') 
      @include('packages::partials.navigation')
      <!-- Left side column. contains the logo and sidebar -->
      @include('packages::partials.sidebar')
                             <!-- END SIDEBAR -->
            <!-- BEGIN CONTENT -->
             <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!-- BEGIN PAGE HEAD-->
                    
                    <!-- END PAGE HEAD-->
                    <!-- BEGIN PAGE BREADCRUMB -->
                  @include('packages::partials.breadcrumb')

                    <!-- END PAGE BREADCRUMB -->
                    <!-- BEGIN PAGE BASE CONTENT -->
                      <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN VALIDATION STATES-->
                            <div class="portlet light portlet-fit portlet-form bordered" style="min-height:200px;">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-settings font-red"></i>
                                        <span class="caption-subject font-red sbold uppercase">Create  {{$heading}}</span>
                                    </div> 
                                </div>
<div class="portlet-body">
   
    <form method="GET" action="{{url('admin/inventory-intake')}}" accept-charset="UTF-8" class="form-horizontal user-form" id="user-form" enctype="multipart/form-data" novalidate="novalidate">

      <input name="_token" type="hidden" value="{{csrf_token()}}">
                                     

      <div class="form-body">
        <div class="alert alert-danger display-hide">
        <button class="close" data-close="alert"></button> Please fill the required field! </div> 

          <div class="form-group {{ $errors->first('name', ' has-error') }}">
              <label class="control-label col-md-3">Select Pharmacy<span class="required"> * </span></label>
              <div class="col-md-4"> 
                  
                  <select name="pharmacy_name" class="form-control">
                    
                     <option value="">Select Pharmacy</option> 

                      @foreach($pharmacylist as $key=>$value)
                              
                      <option value="{{$value->id}}" {{($value->id)?"selected":"selected"}}>
                        {{ $value->name }}
                      </option>
                      @endforeach
                      </select>
                      <span class="help-block">{{ $errors->first('pharmacylist', ':message') }}
                      </span> 
                  
              </div>
          </div>  
      </div> 
      <div class="form-actions">
        <div class="row">
            <div class="col-md-offset-3 col-md-9">
                {!! Form::submit(' Save ', ['class'=>'btn  btn-primary text-white','id'=>'saveBtn']) !!}


                <a href="{{route('inventory')}}">
                    {!! Form::button('Back', ['class'=>'btn btn-warning text-white']) !!} </a>
            </div>
        </div>
      </div>



                                   </form> 
                                    <!-- END FORM-->
                                </div>
                                <!-- END VALIDATION STATES-->
                            </div>
                        </div>
                    </div> 
                  </div>
                </div>

            
            <!-- END QUICK SIDEBAR -->
        </div>
        

        
@stop