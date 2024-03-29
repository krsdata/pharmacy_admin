 
 <!-- END HEADER & CONTENT DIVIDER -->
        <!-- BEGIN CONTAINER -->
<?php 
    $route  =   Route::currentRouteName();

?>

<div class="page-container">
 <div class="page-sidebar-wrapper">
                <!-- BEGIN SIDEBAR -->
        <div id="scroll_bar" class="page-sidebar navbar-collapse collapse">
            
            <ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
                <li class="nav-item start active open">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="icon-home"></i>
                        <span class="title">Dashboard</span>
                        <span class="selected"></span>
                        <span class="arrow open"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="nav-item start active open">
                            <a href="{{ url('admin')}}" class="nav-link ">
                                <i class="icon-bar-chart"></i>
                                <span class="title">Accounts</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                        </ul>
                </li>
                @foreach($main_menu as $key => $result) 
                <li class="nav-item start  @if($route==$result->route_name) active open @endif @if($route==$result->route_name.'.create') active open @endif">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="glyphicon glyphicon-th"></i>
                                <span class="title">{{ucfirst($result->title)}}</span>
                                <span class="arrow @if($route==$result->route_name) open @endif"></span>
                            </a>
                            <ul class="sub-menu" style="display: 
                            @if($route==$result->route_name) block @endif">
                                
                                @foreach($result->sub_menu as $key => $sub_menu)

                                @if(\Str::contains($sub_menu->title, 'Create'))

                                 <li class="nav-item  @if($route==$result->route_name.'.create') active @endif">
                                
                                <a href="{{ route($result->route_name.'.create') }}" class="nav-link ">
                                       <i class="glyphicon glyphicon-eye-open"></i>
                                        <span class="title">
                                        {{ $sub_menu->title }}
                                        </span>
                                    </a>
                                </li> 
                                @else

                                     <li class="nav-item  @if($route==$result->route_name) active @endif">
                                
                                <a href="{{ route($result->route_name) }}" class="nav-link ">
                                       <i class="glyphicon glyphicon-eye-open"></i>
                                        <span class="title">
                                        {{ $sub_menu->title }}
                                        </span>
                                    </a>
                                </li> 
                                @endif
                                @endforeach

                            </ul>
                </li>
                @endforeach  
            </ul>  
            <!-- END SIDEBAR MENU -->
        </div>
        <!-- END SIDEBAR -->
    </div> 
