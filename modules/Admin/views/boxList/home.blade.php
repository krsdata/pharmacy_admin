
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
                            <!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="portlet light portlet-fit bordered">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-settings font-red"></i>
                                        <span class="caption-subject font-red sbold uppercase">Inventory Box List</span>
                                    </div>
                                        <div class="col-md-2 pull-right">
                                            <div class="input-group"> 
                                                <a href="{{ url('admin/inventory-return')}}">
                                                    <button  class="btn btn-success"><i class="fa fa-plus-circle"></i> Inventory Return</button> 
                                                </a>
                                            </div>
                                        </div>  
                                </div>
                                  
                                    @if(Session::has('flash_alert_notice'))
                                         <div class="alert alert-success alert-dismissable" style="margin:10px">
                                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                          <i class="icon fa fa-check"></i>  
                                         {{ Session::get('flash_alert_notice') }} 
                                         </div>
                                    @endif
                                <div class="portlet-body">
                                    <div class="table-toolbar">
                                        <div class="row">
                                            <form action="{{route('boxList')}}" method="get" id="filter_data">
                                             <div class="col-md-3">
                                                <p style="font-weight:bold;margin-bottom:3px;">Box#</p>
                                                <input value="{{ (isset($_REQUEST['box']))?$_REQUEST['box']:''}}" placeholder="Box#" type="text" name="box" id="box" class="form-control" >
                                            </div>
                                           
                                            <div class="col-md-3">
                                            <p style="font-weight:bold;margin-bottom:3px;">Status</p>
                                                <select name="status" class="form-control">
                                                 <option value="">All</option>
                                                 <option value="">Opened</option>
                                                 <option value="">Closed</option>
                                                 <option value="">Verified</option>
                                                 <option value="">Processed</option>
                                                 <option value="">Received</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                            <p style="font-weight:bold;margin-bottom:3px;">Type</p>
                                                <select name="type" class="form-control">
                                                 <option value="">All</option>
                                                 <option value="">RX</option>
                                                 <option value="">CII</option>
                                                 <option value="">CII-V</option>
                                                 <option value="">OTC</option>
                                                </select>
                                            </div>
                                             <div class="col-md-3">
                                            <p style="font-weight:bold;margin-bottom:3px;">Pharmacy</p>
                                                <select name="pharmacy" class="form-control">
                                                 <option value="">N&J Pharmacy</option>
                                                 <option value="">21 Century Pharmacy</option>
                                                </select>
                                            </div>
                                              <div class="col-md-12" style="margin-top:20px;"></div>
                                              <div class="col-md-3">
                                            <p style="font-weight:bold;margin-bottom:3px;">Close Date</p>
                                               <input value="" placeholder="mm-dd-yyyy" type="text" name="close" id="close" class="form-control" >
                                            </div>
                                            <div class="col-md-2">
                                            <p style="font-weight:bold;margin-bottom:22px;"></p>
                                                <input type="submit" value="Search" class="btn btn-primary form-control">
                                            </div>
                                           
                                        </form>
                                         <div class="col-md-2">
                                         <p style="font-weight:bold;margin-bottom:22px;"></p>
                                             <a href="#">   <input type="submit" value="Reset" class="btn btn-default form-control"> </a>
                                        </div>
                                       
                                        </div>
                                    </div>
                                     
                                    <table class="table table-striped table-hover table-bordered" id="contact">
                                        <thead>
                                            <tr>
                                                <th>  Box# </th> 
                                                <th> Status </th>
                                                 <th> Type </th>
                                                <th>Pharmacy Name</th>

                                                <th>Start</th> 
                                                <th>Action/ Batch#</th> 
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($boxlist as $key => $result)
                                            <tr>
                                             <th> {{++$key}} </th>
                                             <td> Open </td>
                                             <td> {{$result->class }} </td>
                                             <td>{{$pharmacylist[$result->pharmacy_id]}}</td>
                                                     <td>
                                                        {!! Carbon\Carbon::parse($result->created_on)->format('Y-m-d'); !!}
                                                    </td>
                                                    
                                                    <td> 
                                                        <a href="#">
                                                            <i class="fa fa-edit" title="edit"></i> 
                                                        </a> 

 <form  onSubmit="return confirm('Do you want to submit?') ">

  <button class='delbtn btn btn-danger btn-xs' type="submit" >
    <i class="fa fa-fw fa-trash" title="Delete"></i>
  </button>
</form>

                                                        
                                                       
 

                                                    </td>
                                               
                                            </tr>
                                           @endforeach
                                            
                                        </tbody>
                                    </table>
                                   

                                     <div class="center" align="center">  {!! $boxlist->appends(['search' => isset($_GET['search'])?$_GET['search']:''])->render() !!}</div>
                                </div>
                            </div>
                            <!-- END EXAMPLE TABLE PORTLET-->
                        </div>
                    </div>
                    <!-- END PAGE BASE CONTENT -->
                </div>
                <!-- END CONTENT BODY -->
            </div>
            
            
            <!-- END QUICK SIDEBAR -->
        </div>

