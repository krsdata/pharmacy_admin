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
                                        <a href="{{ url('admin/unknown-item')}}?pharmacy={{$request->get('pharmacy_name')}}">
                                         <button class="btn btn-success">Add Unknown Item</button>
                                        </a>
                                    </div> 
                                </div>
                                <div class="portlet-body"  >
                                    <!-- BEGIN FORM-->
                                  <form method="POST" action="{{url('admin/unknown-item')}}" method="" enctype="multipart/form-data" id="user-form" class="form-horizontal user-form">

                                  <input type="hidden" name="pharmacy_id" value="{{$request->get('pharmacy_name')}}">
                                  <input type="hidden" value="return_item" name="return_item">
                                  @include('packages::inventory.form2')
                                  
                                  {!! Form::close() !!}   
                                    <!-- END FORM-->
                            <div style="background:#fff">
                            
                            @if(count($inventory)>0)    
                            @foreach($inventory as  $key => $results)
                                 <div class="row" style="margin-top: 20px;" id="box_row_1878">
                                    <div class="col-sm-12"> 
                                          <h4 class="col-md-3" style="font-weight:bold;" id="">BOX: {{$key}}</h4> 
                                    </div>
                                </div>
                                 <table class="table table-striped table-hover table-bordered" id="contact">
                                        <thead>
                                            <tr>
                                                <th>  NDC#. </th> 
                                                <th> Pkg Size    </th>
                                                 <th> Quantity </th>
                                                <th>Pkg Qty </th> 
                                                <th>UOM</th> 
                                                <th>Full/Partial</th> 
                                                <th>total</th>
                                                 <th>Lot #Exp Date</th>
                                                 <th>Action</th>
                                            </tr>
                                        </thead>
                                    
                                @foreach($results as  $key2 => $result)
                                    <thead>
                                        <tr>
                                            <th> {{$result->ndc}}   </th> 
                                            <th>  {{$result->package_size}}    </th>
                                             <th> {{$result->qty}}  </th>
                                            <th>  {{$result->package_qty}}</th>
                                            <th> {{$result->unit_size}}  </th>
                                            <th> {{$result->full_value}}</th> 
                                            <th> {{$result->total}}</th> 
                                            <th>{{$result->exp_date}} </th>
                                            <th> 
                                                <form  method="POST" onSubmit="return confirm('Do you want to submit?') "> 
                                                    <input type="hidden" name="pharmacy_name" 
                                                    value="{{$request->get('pharmacy_name')}}" >

                                                    <input type="hidden" name="remove_it" value="{{$result->id}}">
                                                  <button class='delbtn btn btn-danger btn-xs' type="submit" >
                                                    <i class="fa fa-fw fa-trash" title="Delete"></i>
                                                  </button>
                                                </form>
                                            </th>
                                        </tr>
                                    </thead> 
                                @endforeach
                            </table>
                            @endforeach
                            @else

                                <div class="row" style="margin-top: 20px;" id="box_row_1878">
                                    <div class="col-sm-12">
                                          <div class="col-md-1"></div>
                                          <h4 class="col-md-3" style="font-weight:bold;" id="">BOX: CII</h4> 
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
                            @endif 
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