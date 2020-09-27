 <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <title>Readit Blog</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/open-iconic-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">
    
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}">

    <link rel="stylesheet" href="{{ asset('css/aos.css') }}">

    <link rel="stylesheet" href="{{ asset('css/ionicons.min.css') }}">
    
    <link rel="stylesheet" href="{{ asset('css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('css/icomoon.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.10.0/css/all.css">


    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jquery-migrate-3.0.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>


    @stack('scripts')
  </head>
  <body>
      <nav class="navbar px-md-0 navbar-expand-lg navbar-dark ftco_navbar bg-dark {{!empty($banner) ? 'ftco-navbar-light' : ''}}" id="ftco-navbar">
        <div class="container">
          <a class="navbar-brand" href="{{ route('/') }}">Read<i>it</i>.</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="oi oi-menu"></span> Menu
          </button>

          <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item {{ Request::is('/') ? 'active' : '' }}"><a href="{{ route('/') }}" class="nav-link">Home</a></li>
              @auth
              {{-- <li class="nav-item"><a href="{{ route('create-blog') }}" class="nav-link">New Blog</a></li> --}}
              {{-- <li class="nav-item"><a href="{{ route('home') }}" class="nav-link">My Blogs</a></li> --}}
              @else
              <li class="nav-item"><a href="{{ route('register') }}" class="nav-link">Register</a></li>
              <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">Login</a></li>
              @endauth
              <li class="nav-item"><a href="{{ route('about-us') }}" class="nav-link">About Us</a></li>
              @auth
              <li class="nav-item dropdown">
                <a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu" style="padding:0px;">
                  @if(Auth::user()->profile_img)
                  <img src="{{ Storage::url(Auth::user()->profile_img) }}" alt="pr_pic" class="img-circle img-responsive" style="height:50px">
                  @else
                  <img src="{{ asset('images/avatar-3.png') }}" alt="pr_pic" class="img-circle img-responsive" style="height:50px">
                  @endif
                </a>
                <ul class="dropdown-menu settings-menu dropdown-menu-right">
                  <li><a class="dropdown-item" href="{{ route('create-blog') }}"><i class="fas fa-plus-square fa-lg"></i> New Blog</a></li>
                  <li><a class="dropdown-item" href="{{ route('home') }}"><i class="fas fa-blog"></i> My Blogs</a></li>
                  {{-- <li><a class="dropdown-item" href="#"><i class="fa fa-user fa-lg"></i> Profile</a></li> --}}
                  <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                  </form>
                </ul>
              </li>
              @endauth
            </ul>
          </div>
        </div>
      </nav>
    <!-- END nav -->
    @if(!empty($banner))
    <div class="hero-wrap js-fullheight" style="background-image: url('images/image_4.jpg');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-start" data-scrollax-parent="true">
          <div class="col-md-12 ftco-animate">
            <h2 class="subheading">Hello! Welcome to</h2>
            <h1 class="mb-4 mb-md-0">Readit Blog</h1>
            <div class="row">
                <div class="col-md-7">
                    <div class="text">
                        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>
                        <div class="mouse">
                          <a href="#" class="mouse-icon">
                            <div class="mouse-wheel"><span class="ion-ios-arrow-round-down"></span></div>
                          </a>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endif

    <section class="ftco-section">
        <div class="container">
            <div class="row">
                @yield('content')
          @if(!empty($sidebar))
            <div class="col-md-3 sidebar pl-lg-5 ftco-animate">
              <div class="sidebar-box">
                <form action="#" class="search-form">
                  <div class="form-group">
                    <span class="icon icon-search"></span>
                    <input type="text" class="form-control" placeholder="Type a keyword and hit enter">
                  </div>
                </form>
              </div>
              <div class="sidebar-box ftco-animate">
                <div class="categories">
                  <h3>Categories</h3>
                  @php $categories = App\Category::all(); @endphp
                  @foreach($categories as $category)
                    <li><a href="#">{{$category->title}} <span class="ion-ios-arrow-forward"></span></a></li>
                  @endforeach
                </div>
              </div>

              {{-- <div class="sidebar-box ftco-animate">
                <h3>Recent Blog</h3>
                <div class="block-21 mb-4 d-flex">
                  <a class="blog-img mr-4" style="background-image: url({{ url('images/image_1.jpg') }});"></a>
                  <div class="text">
                    <h3 class="heading"><a href="#">Even the all-powerful Pointing has no control about the blind texts</a></h3>
                    <div class="meta">
                      <div><a href="#"><span class="icon-calendar"></span> Nov. 14, 2019</a></div>
                      <div><a href="#"><span class="icon-person"></span> Admin</a></div>
                      <div><a href="#"><span class="icon-chat"></span> 19</a></div>
                    </div>
                  </div>
                </div>
                <div class="block-21 mb-4 d-flex">
                  <a class="blog-img mr-4" style="background-image: url({{ url('images/image_2.jpg') }});"></a>
                  <div class="text">
                    <h3 class="heading"><a href="#">Even the all-powerful Pointing has no control about the blind texts</a></h3>
                    <div class="meta">
                      <div><a href="#"><span class="icon-calendar"></span> Nov. 14, 2019</a></div>
                      <div><a href="#"><span class="icon-person"></span> Admin</a></div>
                      <div><a href="#"><span class="icon-chat"></span> 19</a></div>
                    </div>
                  </div>
                </div>
                <div class="block-21 mb-4 d-flex">
                  <a class="blog-img mr-4" style="background-image: url({{ url('images/image_3.jpg') }});"></a>
                  <div class="text">
                    <h3 class="heading"><a href="#">Even the all-powerful Pointing has no control about the blind texts</a></h3>
                    <div class="meta">
                      <div><a href="#"><span class="icon-calendar"></span> Nov. 14, 2019</a></div>
                      <div><a href="#"><span class="icon-person"></span> Admin</a></div>
                      <div><a href="#"><span class="icon-chat"></span> 19</a></div>
                    </div>
                  </div>
                </div>
              </div> --}}
            </div>
          @endif
        </div>
            
        </div>
    </section>

    <footer class="ftco-footer ftco-bg-dark ftco-section">
      <div class="container">
        <div class="row mb-5">
          <div class="col-md">
            <div class="ftco-footer-widget mb-4">
              <h2 class="logo"><a href="#">Read<span>it</span>.</a></h2>
              <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
              <ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-5">
                <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
                <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
                <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
              </ul>
            </div>
          </div>
          {{-- <div class="col-md">
             <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2">Latest Blogs</h2>
              <div class="block-21 mb-4 d-flex">
                  <a class="img mr-4 rounded" style="background-image: url(images/image_1.jpg);"></a>
                  <div class="text">
                    <h3 class="heading"><a href="#">Even the all-powerful Pointing has no control about</a></h3>
                    <div class="meta">
                      <div><a href="#"></span> Oct. 16, 2019</a></div>
                      <div><a href="#"></span> Admin</a></div>
                      <div><a href="#"></span> 19</a></div>
                    </div>
                  </div>
                </div>
                <div class="block-21 mb-4 d-flex">
                  <a class="img mr-4 rounded" style="background-image: url(images/image_2.jpg);"></a>
                  <div class="text">
                    <h3 class="heading"><a href="#">Even the all-powerful Pointing has no control about</a></h3>
                    <div class="meta">
                      <div><a href="#"></span> Oct. 16, 2019</a></div>
                      <div><a href="#"></span> Admin</a></div>
                      <div><a href="#"></span> 19</a></div>
                    </div>
                  </div>
                </div>
            </div>
          </div> --}}
          <div class="col-md">
            <div class="ftco-footer-widget mb-4 ml-md-5">
              <h2 class="ftco-heading-2">Information</h2>
              <ul class="list-unstyled">
                <li><a href="{{ route('/') }}" class="py-1 d-block"><span class="ion-ios-arrow-forward mr-3"></span>Home</a></li>
                @auth
                <li><a href="{{ route('create-blog') }}" class="py-1 d-block"><span class="ion-ios-arrow-forward mr-3"></span>New Blog</a></li>
                <li><a href="{{ route('home') }}" class="py-1 d-block"><span class="ion-ios-arrow-forward mr-3"></span>My Blogs</a></li>
                @else
                <li><a href="{{ route('register') }}" class="py-1 d-block"><span class="ion-ios-arrow-forward mr-3"></span>Register</a></li>
                <li><a href="{{ route('login') }}" class="py-1 d-block"><span class="ion-ios-arrow-forward mr-3"></span>Login</a></li>
                @endauth
                <li><a href="{{ route('/') }}" class="py-1 d-block"><span class="ion-ios-arrow-forward mr-3"></span>Contact</a></li>
              </ul>
            </div>
          </div>
          <div class="col-md">
            <div class="ftco-footer-widget mb-4">
                <h2 class="ftco-heading-2">Have a Question?</h2>
                <div class="block-23 mb-3">
                  <ul>
                    <li><span class="icon icon-map-marker"></span><span class="text">203 Fake St. Mountain View, San Francisco, California, USA</span></li>
                    <li><a href="#"><span class="icon icon-phone"></span><span class="text">+2 392 3929 210</span></a></li>
                    <li><a href="#"><span class="icon icon-envelope"></span><span class="text">info@yourdomain.com</span></a></li>
                  </ul>
                </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 text-center">

            <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
  Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="icon-heart color-danger" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
          </div>
        </div>
      </div>
    </footer>
    
  

  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>


  <script src="{{ asset('js/jquery.easing.1.3.js') }}"></script>
  <script src="{{ asset('js/jquery.waypoints.min.js') }}"></script>
  <script src="{{ asset('js/jquery.stellar.min.js') }}"></script>
  <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
  <script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
  <script src="{{ asset('js/aos.js') }}"></script>
  <script src="{{ asset('js/jquery.animateNumber.min.js') }}"></script>
  <script src="{{ asset('js/scrollax.min.js') }}"></script>
  @stack('downscripts')
  <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
  <script src="{{ asset('js/google-map.js') }}"></script> -->
  <script src="{{ asset('js/main.js') }}"></script>
    
  </body>
</html>