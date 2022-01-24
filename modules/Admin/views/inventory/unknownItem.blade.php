
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
                                        <span class="caption-subject font-red sbold uppercase">Add unknown item</span>
                                    </div> 
                                </div>
                    <div class="form-group">
                        <div class="col-sm-12" style="padding-right: 0px; padding-left: 0px;">
                            <div class="alert alert-warning alert-dismissible" role="alert" style="margin-bottom: 0px;">
                               <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                               <strong>Item not found in our system.</strong> <a href="{{url('admin/inventory-intake')}}?pharmacy_name={{$request->get('pharmacy')}}">Go back and retry a different search</a> or save unknown item to box by entering details below.
                            </div>
                        </div>
                    </div>
                <div class="portlet-body">
                                    <!-- BEGIN FORM-->
                                
                    <form action="{{url('admin/unknown-item')}}" method="POST" id="item_info_form" class="form-horizontal" style="margin:45px">
                        <div class="row">
                            <div class="col-sm-12">
                                <h6 class="section-title">GENERAL INFO</h6>
                            </div>
                        </div>                    
                        <div class="row">                                                 
                            <div class="col-sm-4">
                              <div class="form-group1">  
                                <label>NDC#</label>
                                <input class="form-control" type="text" name="ndc" id="ndc" maxlength="100" value="1" >
                              </div>  
                            </div>
                            <div class="col-sm-4">
                              <div class="form-group1">  
                                <label>Package Size</label>
                                <input class="form-control" type="number" name="package_size" id="package_size" maxlength="100" value="" required="">
                              </div>  
                            </div>
                            <div class="col-sm-3">
                              <div class="form-group1">  
                                <label for="unit_size">Unit Size</label>                               
                                <select class="form-control" name="unit_size" id="df" required="">
                                   <option value="">Select One</option> 
                                   <option value="1">EA</option>
                                   <option value="3">GM</option>
                                   <option value="2">ML</option>
                                </select>       
                              </div>  
                            </div>
                        </div><!-- /.row -->
                        <div class="row">  
                                                                           
                            <div class="col-sm-4">
                              <div class="form-group1">  
                                <label for="df">Class</label>                               
                                <select class="form-control" name="class" id="class" required="">
                                   <option value="">Select One</option> 
                                   <option value="RX">RX</option>
                                   <option value="CII">CII</option>
                                   <option value="CIII-V">CIII-V</option>
                                   <option value="OTC">OTC</option>
                                </select> 
                              </div>  
                            </div>
                            <div class="col-sm-4">
                              <div class="form-group1">  
                                <label for="df">Package Qty</label>                               
                                <input class="form-control" type="number" name="package_qty" id="package_qty" maxlength="100" value="" required="" min="0">
                              </div>  
                            </div>
                            <div class="col-sm-3">
                              <div class="form-group1">  
                                <label>Full Value</label> 
                                <input class="form-control" type="number" step="0.01" min="0.01" name="full_value" id="full_value" maxlength="100" value="" required="">
                              </div>  
                            </div>                            
                        </div><!-- /.row -->
                        <div class="row">                                                 
                        <div class="col-sm-2">
                            <div class="form-group1">
                                <label for="qty_type">Qty Type</label>
                                <select class="form-control" name="qty_type" id="qty_type" required="">
                                   <option value="F" selected="">Full</option>
                                   <option value="P">Partial</option> 
                                </select>                                
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group1">
                                <label for="qty">Quantity</label>
                                <input class="form-control" type="number" name="qty" id="qty" value="1" maxlength="10" required="">
                            </div>
                        </div>  
                        <div class="col-sm-4">
                            <div class="form-group1">
                                <label for="lot_num">Lot#</label>
                                <input class="form-control" type="text" name="lot" id="lot" value="" maxlength="30">
                            </div>
                        </div>            
                        <div class="col-sm-3">
                            <div class="form-group1">
                                <label for="exp_date">Exp Date</label>
                                <input class="form-control" type="date" name="exp_date" id="exp_date" value="" placeholder="mm/dd/yyyy" maxlength="20">
                            </div>
                        </div>      
                                    <div class="col-sm-8">
                                        <div class="form-group1">
                                            <label for="exp_date">Product Name</label>
                                            <input class="form-control" type="text" name="product_name" id="product_name" value="" maxlength="60" placeholder="Product Name">
                                        </div>
                                    </div>                     
                        </div><!-- /.row -->
                        <br>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group1">                                 
                                    <input type="submit" class="btn btn-primary"   id="save-btn" value="Return Item" >                                    
                                </div>
                            </div>
                        </div>
                      
                        <input type="hidden" name="pharmacy_id" value="{{$request->get('pharmacy')}}">
                        
                    </form>
                                    <!-- END FORM-->
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