<header id="main-header" class="main-header"> 
    <!--topbar-->
    <div class="topbar">
      <div class="container">
        <div class="row">
          <div class="col-md-6 col-sm-6">
            <ul class="topsocial" style="  color:#fff">
              <li><a href="#" class="fb"><i class="fab fa-facebook-f"></i></a></li>
              <li><a href="#" class="tw"><i class="fab fa-twitter"></i></a></li>
              <li><a href="#" class="insta"><i class="fab fa-instagram"></i></a></li>
              <li><a href="#" class="in"><i class="fab fa-linkedin-in"></i></a></li>
              <li><a href="#" class="yt"><i class="fab fa-youtube"></i></a></li>
            </ul>
          </div>
          <div class="col-md-6 col-sm-6">
            <ul class="toplinks">
              <li class="lang-btn">
                <div class="dropdown">
                  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> ENG </button>
                  
                </div>
              </li>
              
              <li class="acctount-btn"> <a href="#">My Account</a> </li>
              <li class="search-btn"> <a class="search-icon" href="#search"><i class="fas fa-search"></i></a> </li>
            </ul>
            
            <div id="search">
                  <button type="button" class="close">×</button>
                  <form class="search-overlay-form">
                    <input type="search" value="" placeholder="type keyword(s) here">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                  </form>
                </div>
            
          </div>
        </div>
      </div>
    </div>
    <!--topbar end--> 
    <!--Logo + Navbar Start-->
    <div class="logo-navbar">
      <div class="container">
        <div class="row">
          <div class="col-md-2 col-sm-5">
            <div class="logo"><a href="{{url('/')}}"><img src="https://ninja11.in/assets/img/logo.png" alt="" width="100%"></a></div>
          </div>
          <div class="col-md-10 col-sm-7">
            <nav class="main-nav">
              <ul>
                <li class="nav-item drop-down"> <a href="">Home</a>
                  
                </li>
                <li class="nav-item drop-down"> <a href="{{url('about-us')}}">About Us</a>
                  
                </li>
                <li class="nav-item drop-down"> <a href="">Matches</a>
                  <ul>
                    <li><a href="{{url('coming-soon')}}">Upcoming Match</a></li>
                    <li><a href="{{url('coming-soon')}}">Live</a></li>
                    <li><a href="{{url('coming-soon')}}">Completed</a></li>
                     
                  </ul>
                </li> 
                 
                <li class="nav-item drop-down"> <a href="{{url('coming-soon')}}">Reach Us</a>
                 
                </li>
                <li class="nav-item buy-ticket"> <a href="{{'apk'}}">Download Now</a> </li>
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </div>
    <!--Logo + Navbar End--> 
  </header>