<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Inimahsumedang | @yield('title')</title>
    <meta name="description" content="Inimahsumedang">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!-- <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png"> -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- STYLES -->
    <link rel="stylesheet" href="{{ asset('assets/front/css/bootstrap.min.css') }}" type="text/css" media="all">
    <link rel="stylesheet" href="{{ asset('assets/front/css/all.min.css') }}" type="text/css" media="all">
    <link rel="stylesheet" href="{{ asset('assets/front/css/slick.css') }}" type="text/css" media="all">
    <link rel="stylesheet" href="{{ asset('assets/front/css/simple-line-icons.css') }}" type="text/css" media="all">
    <link rel="stylesheet" href="{{ asset('assets/front/css/style.css') }}" type="text/css" media="all">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <style>
        .ui-autocomplete {
            background: #ffffff;
            border: 2px solid #023B68 !important;
            border-top-color: #023B68 !important;
            box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px !important;
            font-family: 'Poppins', sans-serif !important;
            font-size: 16px;

        }

        .ui-menu-item-wrapper {
            padding-top: 5px !important;
            padding-bottom: 5px !important;
            padding-left: 20px !important;
            border-bottom: 1px solid #e7f3ff !important;
        }

        
    </style>
    @yield('css')
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

    <!-- preloader -->
    <div id="preloader">
        <div class="book">
            <div class="inner">
                <div class="left"></div>
                <div class="middle"></div>
                <div class="right"></div>
            </div>
            <ul>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
            </ul>
        </div>
    </div>

    <!-- site wrapper -->
    <div class="site-wrapper">

        <div class="main-overlay"></div>

        <!-- header -->
        <header class="header-default">
            <nav class="navbar navbar-expand-lg">
                <div class="container-xl">
                    <!-- site logo -->
                    <a class="navbar-brand" href="{{ route('beranda.index') }}"><img src="{{ asset('assets/front/logo_inimahsumedang_500x.png') }}"
                            style="width: 130px;" alt="logo" /></a>

                    <div class="collapse navbar-collapse">
                        <!-- menus -->
                        <ul class="navbar-nav mr-auto">
                            @php
                            $url = explode("/", url()->current());
                            @endphp
                            <li class="nav-item {{($url[3] == 'beranda') ? 'active' :null}}">
                                <a class="nav-link" href="{{ route('beranda.index') }}">Beranda</a>
                            </li>
                            <li class="nav-item {{($url[3] == 'artikel') ? 'active' : null}}">
                                <a class="nav-link" href="{{ route('artikel.index') }}">Artikel</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#">Info</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Samsat Keliling</a></li>
                                    <li><a class="dropdown-item" href="#">Sim Keliling</a></li>
                                    <li><a class="dropdown-item" href="#">Nomor telepon penting</a></li>
                                    <li><a class="dropdown-item" href="#">Jadwal Bus</a></li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Tentang</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Kontak</a>
                            </li>
                        </ul>
                    </div>

                    <!-- header right section -->
                    <div class="header-right">
                        <!-- social icons -->
                        <ul class="social-icons list-unstyled list-inline mb-0">
                            <li class="list-inline-item"><a href="https://www.facebook.com/inimahsumedangcom/"><i class="fab fa-facebook-f"></i></a></li>
                            <li class="list-inline-item"><a href="https://twitter.com/inimahsumedang"><i class="fab fa-twitter"></i></a></li>
                            <li class="list-inline-item"><a href="https://www.instagram.com/inimahsumedang/"><i class="fab fa-instagram"></i></a></li>
                            <li class="list-inline-item"><a href="https://www.youtube.com/c/inimahsumedangTV"><i class="fab fa-youtube"></i></a></li>
                        </ul>
                        <!-- header buttons -->
                        <div class="header-buttons">
                            <button class="search icon-button tombol-pencarian">
                                <i class="icon-magnifier"></i>
                            </button>
                            <button class="burger-menu icon-button">
                                <span class="burger-icon"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </nav>
        </header>

        @yield('content')

        <!-- instagram feed -->
        <div class="instagram">
            <div class="container-xl">
                <!-- button -->
                <a href="#" class="btn btn-default btn-instagram">@Katen on Instagram</a>
                <!-- images -->
                <div class="instagram-feed d-flex flex-wrap">
                    <div class="insta-item col-sm-2 col-6 col-md-2">
                        <a href="#">
                            <img src="{{ asset('assets/front/images/insta/insta-1.jpg')}}" alt="insta-title" />
                        </a>
                    </div>
                    <div class="insta-item col-sm-2 col-6 col-md-2">
                        <a href="#">
                            <img src="{{ asset('assets/front/images/insta/insta-2.jpg') }}" alt="insta-title" />
                        </a>
                    </div>
                    <div class="insta-item col-sm-2 col-6 col-md-2">
                        <a href="#">
                            <img src="{{ asset('assets/front/images/insta/insta-3.jpg') }}" alt="insta-title" />
                        </a>
                    </div>
                    <div class="insta-item col-sm-2 col-6 col-md-2">
                        <a href="#">
                            <img src="{{ asset('assets/front/images/insta/insta-4.jpg') }}" alt="insta-title" />
                        </a>
                    </div>
                    <div class="insta-item col-sm-2 col-6 col-md-2">
                        <a href="#">
                            <img src="{{ asset('assets/front/images/insta/insta-5.jpg') }}" alt="insta-title" />
                        </a>
                    </div>
                    <div class="insta-item col-sm-2 col-6 col-md-2">
                        <a href="#">
                            <img src="{{ asset('assets/front/images/insta/insta-6.jpg') }}" alt="insta-title" />
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- footer -->
        <footer>
            <div class="container-xl">
                <div class="footer-inner">
                    <div class="row d-flex align-items-center gy-4">
                        <!-- copyright text -->
                        <div class="col-md-4">
                            <span class="copyright">Build with passion by <a href="">
                                    <i><b>TAHU</b>NGODING</i></a></span>
                        </div>

                        <!-- social icons -->
                        <div class="col-md-4 text-center">
                            <ul class="social-icons list-unstyled list-inline mb-0">
                                <li class="list-inline-item"><a href="https://www.facebook.com/inimahsumedangcom/"><i class="fab fa-facebook-f"></i></a></li>
                                <li class="list-inline-item"><a href="https://twitter.com/inimahsumedang"><i class="fab fa-twitter"></i></a></li>
                                <li class="list-inline-item"><a href="https://www.instagram.com/inimahsumedang/"><i class="fab fa-instagram"></i></a></li>
                                <li class="list-inline-item"><a href="https://www.youtube.com/c/inimahsumedangTV"><i class="fab fa-youtube"></i></a></li>
                            </ul>
                        </div>

                        <!-- go to top button -->
                        <div class="col-md-4">
                            <a href="#" id="return-to-top" class="float-md-end"><i class="icon-arrow-up"></i>Back to
                                Top</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

    </div><!-- end site wrapper -->

    <!-- search popup area -->
    <div class="search-popup">
        <!-- close button -->
        <button type="button" class="btn-close keluar-dari-pencarian" aria-label="Close"></button>
        <!-- content -->
        <div class="search-content">
            <div class="text-center">
                <h3 class="mb-4 mt-0">Press ESC to close</h3>
            </div>
            <style>
                .ui-autocomplete-input {
                    border-bottom-left-radius: 0px;
                    border-bottom-right-radius: 0px;
                    font-family: 'Poppins', sans-serif !important;
                    font-size: 16px;
                    border: 2px solid #023B68 !important;

                }
            </style>
            <!-- form -->
            <form class="d-flex search-form" action="{{ route('artikel.pencarian') }}" method="POST">
                @csrf
                <input class="form-control me-2 search pencarian" name="pencarian" id="search" type="text"
                    placeholder="Cari artikel ...">
                <button class="btn btn-default btn-lg" type="submit"><i class="icon-magnifier"></i></button>
            </form>
        </div>
    </div>

    <!-- canvas menu -->
    <div class="canvas-menu d-flex align-items-end flex-column">
        <!-- close button -->
        <button type="button" class="btn-close" aria-label="Close"></button>

        <!-- logo -->
        <div class="logo">
            <img src="{{ asset('assets/front/logo_inimahsumedang_500x.png') }}" style="width: 130px;" alt="logo" />
        </div>

        <!-- menu -->
        <nav>
            <ul class="vertical-menu">
                <li><a href="{{ route('beranda.index') }}">Beranda</a></li>
                <li><a href="{{ route('artikel.index') }}">Artikel</a></li>
                <li>
                    <a href="#">Info</a>
                    <ul class="submenu">
                        <li><a href="#">Samsat Keliling</a></li>
                        <li><a href="#">Sim Keliling</a></li>
                        <li><a href="#">Nomor telepon penting</a></li>
                        <li><a href="#">Jadwal Bus</a></li>
                    </ul>
                </li>
                <li><a href="#">Tentang</a></li>
                <li><a href="#">Kontak</a></li>
            </ul>
        </nav>

        <!-- social icons -->
        <ul class="social-icons list-unstyled list-inline mb-0 mt-auto w-100">
            <li class="list-inline-item"><a href="#"><i class="fab fa-facebook-f"></i></a></li>
            <li class="list-inline-item"><a href="#"><i class="fab fa-twitter"></i></a></li>
            <li class="list-inline-item"><a href="#"><i class="fab fa-instagram"></i></a></li>
            <li class="list-inline-item"><a href="#"><i class="fab fa-youtube"></i></a></li>
        </ul>
    </div>
    
    @include('sweetalert::alert')
    <!-- JAVA SCRIPTS -->
    <script src="{{ asset('assets/front/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/slick.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/jquery.sticky-sidebar.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/custom.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script>
        $(document).on('keyup', function(e) {
        if (e.key == "Escape") $("body").css('overflow', 'initial');
        });

        $(".tombol-pencarian").on('click', function(event){
            $("body").css('overflow', 'hidden');
        });

        $(".keluar-dari-pencarian").on('click', function(event){
            $("body").css('overflow', 'initial');
        });

        

        $(document).on('click', function(event){
            var container = $(".pencarian");
            if (!container.is(event.target) &&            // If the target of the click isn't the container...
                container.has(event.target).length === 0) // ... nor a descendant of the container
            {
                $(".pencarian").css('border-bottom-left-radius', '25px');
                $(".pencarian").css('border-bottom-right-radius', '25px');
            }
        });
        $(document).ready(function(){
            $(".pencarian").keyup(function(){
                $(".pencarian").css('border-bottom-left-radius', '0px');
                $(".pencarian").css('border-bottom-right-radius', '0px');
            });
        });    
    </script>
    <script type="text/javascript">
        // CSRF Token
    
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    
        $(document).ready(function(){
    
    
          $( "#search" ).autocomplete({
    
            source: function( request, response ) {
    
              // Fetch data
    
              $.ajax({
    
                url:"{{ route('artikel.pencarian_autocomplete') }}",
    
                type: 'post',
    
                dataType: "json",
    
                data: {
    
                   _token: CSRF_TOKEN,
    
                   search: request.term
    
                },
    
                success: function( data ) {
    
                   response( data );
    
                }
    
              });
    
            },
    
            select: function (event, ui) {
    
               $('#search').val(ui.item.label);
    
               $('#employeeid').alert(ui.item.value); 
    
               return false;
    
            }
    
          });
    
    
        });
    
    </script>
    
    @yield('js')
</body>

</html>