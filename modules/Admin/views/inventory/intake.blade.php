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
                            <div class="portlet light portlet-fit portlet-form bordered">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-settings font-red"></i>
                                        <span class="caption-subject font-red sbold uppercase">{{$heading}} Return</span>
                                    </div> 
                                 
                                    <div class="caption" style="float:right;" >
                                        <a href="{{ url('admin/unknown-item')}}">
                                         <button class="btn btn-success">Add Unknown Item</button>
                                        </a>
                                    </div> 
                                </div>
                                <div class="portlet-body"  >
                                    <!-- BEGIN FORM-->
                                
                                  {!! Form::model($inventoryIntake, ['route' => ['return_store'],'class'=>'form-horizontal user-form','id'=>'user-form','enctype'=>'multipart/form-data']) !!}
                                  
                                  @include('packages::inventory.form2')
                                  
                                  {!! Form::close() !!}   
                                    <!-- END FORM-->
                            <div style="background:#fff">
                            <div class="row" style="margin-top: 20px;" id="box_row_1878">
                                    <div class="col-sm-12">
                                         <div class="col-md-1"></div>
                                          <h4 class="col-md-3" style="font-weight:bold;" id="">BOX: RX</h4> 
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 20px;" id="box_row_1878">
                                    <div class="col-sm-12">
                                          <div class="col-md-1"></div>
                                          <h4 class="col-md-3" style="font-weight:bold;" id="">BOX: CII</h4> 
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 20px;" id="box_row_1878">
                                    <div class="col-sm-12">
                                          <div class="col-md-1"></div>
                                          <h4 class="col-md-3" style="font-weight:bold;" id="">BOX: CIII-V</h4> 
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 20px;" id="box_row_1878">
                                    <div class="col-sm-12">
                                          <div class="col-md-1"></div>
                                          <h4 class="col-md-3" style="font-weight:bold;" id="">BOX: OTC</h4> 
                                    </div>
                                </div>
                            </div>
                                </div>
                                <!-- END VALIDATION STATES-->
                            </div>
                        </div>
                    </div>
                    <!-- END PAGE BASE CONTENT -->
                </div>
                <!-- END CONTENT BODY -->
            </div>
            
            
            <!-- END QUICK SIDEBAR -->
        </div>
        

        
@stop