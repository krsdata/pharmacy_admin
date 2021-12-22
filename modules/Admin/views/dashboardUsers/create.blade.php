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
                    
                       <div class="panel panel-cascade">
                          <div class="panel-body ">
                              <div class="row">
                                  <div class="box-header">
                                    <div class="box-tools">
                                      <div style="width: 150px;" class="input-group"> 
                                          <a href="">
                                            <button class="btn btn-sm btn-primary"><i class="fa fa-group"></i> View  Group</button> 
                                          </a>
                                      </div>
                                    </div>
                                  </div><!-- /.box-header -->
                                  <div class="col-md-9">
                                      {!! Form::model($dashboardusers, ['route' => ['dashboardUsers.store'],'class'=>'form-horizontal','id'=>'admin']) !!}
                                          @include('packages::dashboardUsers.form')
                                      {!! Form::close() !!}
                                  </div>
                              </div>
                          </div>
                    </div>
                  
                </div>            
              </div>  
            <!-- Main row --> 
          </section><!-- /.content -->
      </div> 
   
@stop
