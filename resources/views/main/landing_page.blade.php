<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>{{config('app.name')}} - Online Accounting Platform</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{asset('img/favicon.png')}}" rel="icon">
  <link href="{{asset('img/apple-touch-icon.png')}}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{asset('vendor/icofont/icofont.min.css')}}" rel="stylesheet">
  <link href="{{asset('vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
  <link href="{{asset('vendor/animate.css/animate.min.css')}}" rel="stylesheet">
  <link href="{{asset('vendor/owl.carousel/assets/owl.carousel.min.css')}}" rel="stylesheet">
  <link href="{{asset('vendor/venobox/venobox.css')}}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{asset('css/style.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('css/app.css')}}">

  <!-- =======================================================
  * Template Name: Waiton - v2.3.1
  * Template URL: https://bootstrapmade.com/Waiton-free-one-page-bootstrap-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="">
    <div class="container d-flex align-items-center">

      <h1 class="logo mr-auto"><a href="/">{{config('app.name')}}</a></h1>
      {{-- <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo mr-auto"><img src="{{asset('img/logo.png')}}" alt="" class="img-fluid"></a>--> --}}

      <nav class="nav-menu d-none d-lg-block mr-auto">
        <ul>
          <li><a href="#about">特徴</a></li>
          <li><a href="#services">料金</a></li>
          <li><a href="#portfolio">ストーリー</a></li>
        </ul>
      </nav><!-- .nav-menu -->
      
      <div class="dropdown">
        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">ログイン <span class="caret"></span></button>
        <ul class="dropdown-menu">
          <li class='nav-link'><a href="{{route('signin', ['user_type'=> '会計事務所'])}}">会計事務所</a></li>
          <li class='nav-link'><a href="{{route('signin', ['user_type'=> 'クライアント'])}}">クライアント</a></li>
          <li class='nav-link'><a href="{{route('signin', ['user_type'=> 'モアジョブ'])}}">モアジョブ</a></li>
        </ul>
      </div>
      <a href="register" class="get-started-btn">新規登録</a>

    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero">
    <div id="heroCarousel" class="carousel slide carousel-fade" data-ride="carousel">

      <ol class="carousel-indicators" id="hero-carousel-indicators"></ol>

      <div class="carousel-inner" role="listbox">

        <!-- Slide 1 -->
        <div class="carousel-item active">
          <div class="carousel-container">
            <div class="container">
              <h2>会計事務所とクライアントをつなぐ
              <br>プラットフォーム</h2>
            </div>
          </div>
        </div>
      </div>
  </section><!-- End Hero -->

  <main id="main">

    <section id="services" class="services">
      <div class="container">
        <div class="row"> 
          <div class="col-md-4" data-aos="zoom-in" data-aos-delay="100" >
            <div class="icon-box iconbox-blue" style="background-color:#FCF4D9;">
              <div class="icon">
                <svg width="100" height="100" viewBox="0 0 600 600" xmlns="http://www.w3.org/2000/svg">
                  <path stroke="none" stroke-width="0" fill="#f5f5f5" d="M300,521.0016835830174C376.1290562159157,517.8887921683347,466.0731472004068,529.7835943286574,510.70327084640275,468.03025145048787C554.3714126377745,407.6079735673963,508.03601936045806,328.9844924480964,491.2728898941984,256.3432110539036C474.5976632858925,184.082847569629,479.9380746630129,96.60480741107993,416.23090153303,58.64404602377083C348.86323505073057,18.502131276798302,261.93793281208167,40.57373210992963,193.5410806939664,78.93577620505333C130.42746243093433,114.334589627462,98.30271207620316,179.96522072025542,76.75703585869454,249.04625023123273C51.97151888228291,328.5150500222984,13.704378332031375,421.85034740162234,66.52175969318436,486.19268352777647C119.04800174914682,550.1803526380478,217.28368757567262,524.383925680826,300,521.0016835830174"></path>
                </svg>
                <i class="bx bxl-dribbble"></i>
              </div>
              <h4><a href="">サービスの中身</a></h4>
              <form action="" method="GET">
                <script
                src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                data-key="pk_test_51IShqvDBrLv03ZFnYLiidxC5jiBlzh9EXwlwPeO54cUtCJrgBnicvipCHNaxCbxgyYDG6ecn5kQcznAQfte5qo7C00HAac3a3r"
                data-amount="2000"
                data-name="Jenry Bargola"
                data-description="サービスの中身"
                data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                data-locale="auto"
                data-currency="jpy"
                >
                </script>
              </form>
              <!-- <button class="btn btn-warning" type="button">無料で始める</button> -->
            </div>
          </div>

          <div class="col-md-4 mt-4 mt-md-0" data-aos="zoom-in" data-aos-delay="200">
            <div class="icon-box iconbox-orange " style="background-color:#FCF4D9;">
              <div class="icon">
                <svg width="100" height="100" viewBox="0 0 600 600" xmlns="http://www.w3.org/2000/svg">
                  <path stroke="none" stroke-width="0" fill="#f5f5f5" d="M300,582.0697525312426C382.5290701553225,586.8405444964366,449.9789794690241,525.3245884688669,502.5850820975895,461.55621195738473C556.606425686781,396.0723002908107,615.8543463187945,314.28637112970534,586.6730223649479,234.56875336149918C558.9533121215079,158.8439757836574,454.9685369536778,164.00468322053177,381.49747125262974,130.76875717737553C312.15926192815925,99.40240125094834,248.97055460311594,18.661163978235184,179.8680185752513,50.54337015887873C110.5421016452524,82.52863877960104,119.82277516462835,180.83849132639028,109.12597500060166,256.43424936330496C100.08760227029461,320.3096726198365,92.17705696193138,384.0621239912766,124.79988738764834,439.7174275375508C164.83382741302287,508.01625554203684,220.96474134820875,577.5009287672846,300,582.0697525312426"></path>
                </svg>
                <i class="bx bx-file"></i>
              </div>
              <h4><a href="">会計事務所のメリット</a></h4>    
              <form action="" method="GET">
                <script
                src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                data-key="pk_test_51IShqvDBrLv03ZFnYLiidxC5jiBlzh9EXwlwPeO54cUtCJrgBnicvipCHNaxCbxgyYDG6ecn5kQcznAQfte5qo7C00HAac3a3r"
                data-amount="2000"
                data-name="Jeferson Bonayon"
                data-description="会計事務所のメリット"
                data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                data-locale="auto"
                data-currency="jpy"
                >
                </script>
              </form>
            </div>
          </div>

          <div class="col-md-4 mt-4 mt-lg-0" data-aos="zoom-in" data-aos-delay="300">
            <div class="icon-box iconbox-pink" style="background-color:#FCF4D9;">
              <div class="icon">
                <svg width="100" height="100" viewBox="0 0 600 600" xmlns="http://www.w3.org/2000/svg">
                  <path stroke="none" stroke-width="0" fill="#f5f5f5" d="M300,541.5067337569781C382.14930387511276,545.0595476570109,479.8736841581634,548.3450877840088,526.4010558755058,480.5488172755941C571.5218469581645,414.80211281144784,517.5187510058486,332.0715597781072,496.52539010469104,255.14436215662573C477.37192572678356,184.95920475031193,473.57363656557914,105.61284051026155,413.0603344069578,65.22779650032875C343.27470386102294,18.654635553484475,251.2091493199835,5.337323636656869,175.0934190732945,40.62881213300186C97.87086631185822,76.43348514350839,51.98124368387456,156.15599469081315,36.44837278890362,239.84606092416172C21.716077023791087,319.22268207091537,43.775223500013084,401.1760424656574,96.891909868211,461.97329694683043C147.22146801428983,519.5804099606455,223.5754009179313,538.201503339737,300,541.5067337569781"></path>
                </svg>
                <i class="bx bx-tachometer"></i>
              </div>
              <h4><a href="">クライアントのメリット</a></h4>
              <form action="" method="GET">
                <script
                src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                data-key="pk_test_51IShqvDBrLv03ZFnYLiidxC5jiBlzh9EXwlwPeO54cUtCJrgBnicvipCHNaxCbxgyYDG6ecn5kQcznAQfte5qo7C00HAac3a3r"
                data-amount="2000"
                data-name="Janvincent Niikura"
                data-description="会計事務所のメリット"
                data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                data-locale="auto"
                data-currency="jpy"
                >
                </script>
              </form>
            </div>
          </div>
        </div>

      </div>
    </section><!-- End Services Section -->

  </main><!-- End #main -->

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{asset('js/app.js')}}"></script>
  <script src="{{asset('vendor/jquery.easing/jquery.easing.min.js')}}"></script>
  <script src="{{asset('vendor/php-email-form/validate.js')}}"></script>
  <script src="{{asset('vendor/owl.carousel/owl.carousel.min.js')}}"></script>
  <script src="{{asset('vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>
  <script src="{{asset('vendor/venobox/venobox.min.js')}}"></script>

  <!-- Template Main JS File -->
  <script src="{{asset('js/main.js')}}"></script>

</body>

</html>