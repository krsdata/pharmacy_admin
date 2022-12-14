
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
                               <strong>Item not found in our system.</strong> <a href="{{url('admin/inventory-intake')}}?pharmacy_name={{$request->get('pharmacy')??$inventory->pharmacy_id}}">Go back and retry a different search</a> or save unknown item to box by entering details below.
                            </div>
                        </div>
                    </div>
                <div class="portlet-body">
                                    <!-- BEGIN FORM-->
                                
                    <form action="{{url('admin/unknown-item')}}" method="POST" id="item_info_form" class="form-horizontal" style="margin:45px">
                        <fieldset>
                         <br>
                        <div class="row col-sm-12">
                            <b>

                        @if($request->inventory_id)
                            INVENTORY INFO <br> 
                        @else
                            GENERAL INFO <br> 
                        @endif    
                        </b>
                        </div> 
                                          
                        
                        <div class="row">                                                 
                            <div class="col-sm-4">
                              <div class="form-group1">  
                                <label>NDC#</label>
                                <input class="form-control" type="text" name="ndc" id="ndc" maxlength="100" value="{{$inventory->ndc??$request->ndc}}" @if($request->ndc) disabled @elseif($inventory->ndc) disabled @endif >
                              </div>  
                            </div>
                            <div class="col-sm-4">
                              <div class="form-group1">  
                                <label>Package Size</label>
                                <input class="form-control" type="number" name="package_size" id="package_size" maxlength="100" value="{{$inventory->package_size}}" required=""
                                @if($inventory->package_size) disabled @endif 
                                >
                              </div>  
                            </div>
                            <div class="col-sm-3">
                              <div class="form-group1">  
                                <label for="unit_size">Unit Size</label>                          
                                <select class="form-control" name="unit_size" id="df" required="" @if($inventory->unit_size) disabled @endif >
                                   <option value="">Select One</option> 
                                   <option value="1" 
                                   @if($inventory->unit_size==1) selected @endif
                                   >EA</option>
                                   <option value="3" 
                                   @if($inventory->unit_size==3) selected @endif>
                                   GM</option>
                                   <option value="2" 
                                   @if($inventory->unit_size==2) selected @endif>
                                   ML</option>
                                </select>       
                              </div>  
                            </div>
                        </div><!-- /.row -->
                        <div class="row">  
                                                                           
                            <div class="col-sm-4">
                              <div class="form-group1">  
                                <label for="df">Class</label>                               
                                <select class="form-control" name="class" id="class" required="" @if($inventory->class) disabled @endif>
                                   <option value="">Select One</option> 
                                   <option value="RX"  
                                   @if($inventory->class=="RX") selected @endif>RX</option>
                                   <option value="CII"  @if($inventory->class=="CII") selected @endif>CII</option>
                                   <option value="CIII-V"  @if($inventory->class=="CIII-V") selected @endif>CIII-V</option>
                                   <option value="OTC"  @if($inventory->class=="OTC") selected @endif>OTC</option>
                                </select> 
                              </div>  
                            </div>
                            <div class="col-sm-4">
                              <div class="form-group1">  
                                <label for="df">Package Qty</label>                               
                                <input class="form-control" type="number" name="package_qty" id="package_qty" maxlength="100" value="{{$inventory->package_qty}}" required="" min="0" @if($inventory->package_qty) disabled @endif>
                              </div>  
                            </div>
                            <div class="col-sm-3">
                              <div class="form-group1">  
                                <label>Full Value</label> 
                                <input class="form-control" type="number" step="0.01" min="0.01" name="full_value" id="full_value" maxlength="100" value="{{$inventory->full_value}}" required="" 
                                @if($inventory->full_value) disabled @endif
                                >
                              </div>  
                            </div>                            
                        </div>
                    </fieldset>
                    <fieldset> 
                        @if($request->inventory_id)
                        <br>
                        <div class="row col-sm-12">
                            <b>GENERAL ITEM INFO: </b>
                        </div>
                        <br>
                        @endif
                        <!-- /.row -->
                        <div class="row">                                                 
                        <div class="col-sm-2">
                            <div class="form-group1">
                                <label for="qty_type">Qty Type</label>
                                <select class="form-control" name="qty_type" id="qty_type" required="">
                                   <option value="F" @if($inventory->qty_type=="F") selected @endif>Full</option>
                                   <option value="P" @if($inventory->qty_type=="P") selected @endif>Partial</option> 
                                </select>                                
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group1">
                                <label for="qty">Quantity</label>
                                <input class="form-control" type="number" name="qty" id="qty" value="{{$inventory->qty}}" maxlength="10" required="">
                            </div>
                        </div>  
                        <div class="col-sm-4">
                            <div class="form-group1">
                                <label for="lot_num">Lot#</label>
                                <input class="form-control" type="text" name="lot" id="lot" value="{{$inventory->lot}}" maxlength="30">
                            </div>
                        </div>            
                        <div class="col-sm-3">
                            <div class="form-group1">
                                <label for="exp_date">Exp Date</label>
                                <input class="form-control" type="date" name="exp_date" id="exp_date" value="{{$inventory->exp_date}}" placeholder="mm/dd/yyyy"  >
                            </div>
                        </div>      
                        <div class="col-sm-4">
                            <div class="form-group1">
                                <label for="exp_date">Product Name</label>
                                <input class="form-control" type="text" name="product_name" id="product_name" value="{{$inventory->product_name}}" maxlength="60" placeholder="Product Name">
                            </div>
                        </div> 

                        @if($request->inventory_id)
                        <div class="col-sm-2">
                            <div class="form-group1">
                                <label for="acros_action_indicator">Arcos Action Indicator</label>
                                <select class="form-control" name="acros_action_indicator" id="acros_action_indicator" required="">
                                    <option></option>
                                   <option value="D-Deletion" @if($inventory->acros_action_indicator=="D-Deletion") selected @endif>
                                    D-Deletion
                                   </option>

                                   <option value="A-Adjustment" @if($inventory->acros_action_indicator=="A-Adjustment") selected @endif>
                                    A-Adjustment
                                   </option>

                                   <option value="I-Inserttion" @if($inventory->acros_action_indicator=="I-Inserttion") selected @endif>
                                    I-Inserttion
                                   </option>
                                    
                                </select>                                
                            </div>
                        </div> 
                        <div class="col-sm-2">
                            <div class="form-group1">
                                <label for="acros_unit_code">Acros unit code</label>
                                <select class="form-control" name="acros_unit_code" id="acros_unit_code" required="">
                                    
                                    <option value=""></option> 
                                    <option value="1" @if($inventory->acros_unit_code=="1") selected @endif>1 = micrograms</option>
                                    <option value="2" @if($inventory->acros_unit_code=="2") selected @endif>2 = milligrams</option>
                                    <option value="3" @if($inventory->acros_unit_code=="3") selected @endif>3 = grams</option>
                                    <option value="4" @if($inventory->acros_unit_code=="4") selected @endif >4 = kilograms</option>
                                    <option value="5" @if($inventory->acros_unit_code=="5") selected @endif>5 = milliliters</option>
                                    <option value="6" @if($inventory->acros_unit_code=="6") selected @endif>6 = liters</option>
                                    <option value="D" @if($inventory->acros_unit_code=="D") selected @endif>D = Dozens</option>
                                    <option value="K" @if($inventory->acros_unit_code=="K") selected @endif>K = Thousands</option>
                                    
                                </select>                                
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group1">
                                <label for="acros_order">Arcos Orde</label>
                                <input class="form-control" type="text" name="acros_order" id="acros_order" value="{{$inventory->acros_order}}"   placeholder="acros order">
                            </div>
                        </div> 
                        @endif

                        </div>
                    </fieldset>
                        <!-- /.row -->
                        <br>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group1">       

                                    @if(isset($inventory->id))
                                    <input type="submit" class="btn btn-success"   id="save-btn" value="Update">
                                    @else
                                    <input type="submit" class="btn btn-primary"   id="save-btn" value="Return Item" >
                                    @endif                                      
                                </div>
                            </div>
                        </div> 
                        <input type="hidden" name="inventory_id" value="{{$inventory->id}}">
                        <input type="hidden" name="pharmacy_id" value="{{$request->get('pharmacy')??$inventory->pharmacy_id}}">
                        
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