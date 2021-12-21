@if(!isset($remove_header) || $remove_header===false)
<!--Main Footer Start-->
<footer class="wf100 main-footer">
  <div class="container">
    <div class="row"> 
      <!--Footer Widget Start-->
      <div class="col-lg-3 col-md-6">
        <div class="footer-widget about-widget"> <img src="https://www.ninja11.in/assets/img/logo.png" alt="" style="

    width: 200px;
">
    <p>We drive one of the biggest virtual yet fantasy  sports platform. Also, we help you set-up your
fan base by keeping a watch over shared posts in the feed.</p>
          <address>
          <ul>
            <li><i class="fas fa-map-marker-alt"></i>{{env('company_address')}}
            </li>
            <li><i class="fas fa-phone"></i> +91-{{env('company_phone')}}</li>
            <li><i class="fas fa-envelope"></i>{{env('company_email')}}</li>
          </ul>
          </address>
        </div>
      </div>
      <!--Footer Widget End--> 
      <!--Footer Widget Start-->
      <div class="col-lg-3 col-md-6">
        <div class="footer-widget">
          <h4>About Ninja11</h4>
          <ul class="footer-links">
            
           
            @foreach($static_page as $key =>  $result)
                           
                
                <li> 
                  <a class="scroll-link" href="{{url($result->slug)}}">
                    <i class="fas fa-angle-double-right"></i>
                    {{$result->title}}</a>
                  </li>
                @endforeach


            
          </ul>
        </div>
      </div>
      <!--Footer Widget End--> 
      <!--Footer Widget Start-->
      <div class="col-lg-3 col-md-6">
        <div class="footer-widget">
          <h4>Recent Instagram</h4>
          <ul class="instagram">
            <li><img src="images/insta1.jpg" alt=""></li>
            <li><img src="images/insta2.jpg" alt=""></li>
            <li><img src="images/insta3.jpg" alt=""></li>
            <li><img src="images/insta4.jpg" alt=""></li>
            <li><img src="images/insta5.jpg" alt=""></li>
            <li><img src="images/insta6.jpg" alt=""></li>
          </ul>
        </div>
      </div>
      <!--Footer Widget End--> 
      <!--Footer Widget Start-->
      <div class="col-lg-3 col-md-6">
        <div class="footer-widget">
          <h4>Get Updated</h4>
          <p> Sign up to Get Updated & latest offers with our Newsletter. </p>
          <ul class="newsletter">
            <li>
              <input type="text" class="form-control" placeholder="Your Name">
            </li>
            <li>
              <input type="text" class="form-control" placeholder="Your Emaill Address">
            </li>
            <li> <strong>We respect your privacy</strong>
              <button><span>Subscribe</span></button>
            </li>
          </ul>
        </div>
      </div>
      <!--Footer Widget End--> 
    </div>
  </div>
  <div class="container brtop">
    <div class="row">
      <div class="col-lg-6 col-md-6">
        <p class="copyr"> All Rights Reserved of <a href="#">Ninja11 Gaming Techno</a> </p>
      </div>
      <div class="col-lg-6 col-md-6">
        <ul class="quick-links">
          <li><a href="{{url('/')}}">Home</a></li>
          <li><a href="{{url('about-us')}}">About Us</a></li>
          <li><a href="{{url('coming-soon')}}">Fixtures</a></li>
          <li><a href="{{url('coming-soon')}}">Completed</a></li>
          <li><a href="{{url('coming-soon')}}">Live</a></li>
          <li><a href="{{url('coming-soon')}}">Contact</a></li>
        </ul>
      </div>
    </div>
  </div>
</footer>
@endif
<!--Main Footer End-->
</div>
<!--Wrapper End--> 



<!-- Optional JavaScript --> 
<script src="{{ URL::asset('webmedia/js/jquery-3.3.1.min.js')}}"></script> 
<script src="{{ URL::asset('webmedia/js/jquery-migrate-3.0.1.js')}}"></script> 
<script src="{{ URL::asset('webmedia/js/popper.min.js')}}"></script> 
<script src="{{ URL::asset('webmedia/js/bootstrap.min.js')}}"></script> 
<script src="{{ URL::asset('webmedia/js/mobile-nav.js')}}"></script> 
<script src="{{ URL::asset('webmedia/js/owl.carousel.min.js')}}"></script> 
<script src="{{ URL::asset('webmedia/js/isotope.js')}}"></script> 
<script src="{{ URL::asset('webmedia/js/jquery.prettyPhoto.js')}}"></script> 
<script src="{{ URL::asset('webmedia/js/jquery.countdown.js')}}"></script> 
<script src="{{ URL::asset('webmedia/js/custom.js')}}"></script> 
<!--Rev Slider Start--> 
<script type="text/javascript" src="{{ URL::asset('webmedia/js/rev-slider/js/jquery.themepunch.tools.min.js')}}"></script> 
<script type="text/javascript" src="{{ URL::asset('webmedia/js/rev-slider/js/jquery.themepunch.revolution.min.js')}}"></script> 
<script type="text/javascript" src="{{ URL::asset('webmedia/js/rev-slider.js')}}"></script> 
<script type="text/javascript" src="{{ URL::asset('webmedia/js/rev-slider/js/extensions/revolution.extension.actions.min.js')}}"></script> 
<script type="text/javascript" src="{{ URL::asset('webmedia/js/rev-slider/js/extensions/revolution.extension.carousel.min.js')}}"></script> 
<script type="text/javascript" src="{{ URL::asset('webmedia/js/rev-slider/js/extensions/revolution.extension.kenburn.min.js')}}"></script> 
<script type="text/javascript" src="{{ URL::asset('webmedia/js/rev-slider/js/extensions/revolution.extension.layeranimation.min.js')}}"></script> 
<script type="text/javascript" src="{{ URL::asset('webmedia/js/rev-slider/js/extensions/revolution.extension.migration.min.js')}}"></script> 
<script type="text/javascript" src="{{ URL::asset('webmedia/js/rev-slider/js/extensions/revolution.extension.navigation.min.js')}}"></script> 
<script type="text/javascript" src="{{ URL::asset('webmedia/js/rev-slider/js/extensions/revolution.extension.parallax.min.js')}}"></script> 
<script type="text/javascript" src="{{ URL::asset('webmedia/js/rev-slider/js/extensions/revolution.extension.slideanims.min.js')}}"></script> 
<script type="text/javascript" src="{{ URL::asset('webmedia/js/rev-slider/js/extensions/revolution.extension.video.min.js')}}"></script>

<script type="text/javascript">
  $(function(){
    

    // ------- countdown ------- //
    if ($('.defaultCountdown').length) {
        var austDay = new Date();
        austDay = new Date(1, - 1, 21);
        $('.defaultCountdown').countdown({
            until: austDay
        });
        $('#year').text(austDay.getFullYear());
    }
});
</script>
</body>
</html>