<!DOCTYPE html>
<html lang="en-US">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Katen - Minimal Blog & Magazine HTML Theme</title>
	<meta name="description" content="Katen - Minimal Blog & Magazine HTML Theme">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="shortcut icon" type="image/x-icon" href="images/favicon.png">

	<!-- STYLES -->
	<link rel="stylesheet" href="{{ asset('assets/front/css/bootstrap.min.css') }}" type="text/css" media="all">
	<link rel="stylesheet" href="{{ asset('assets/front/css/all.min.css') }}" type="text/css" media="all">
	<link rel="stylesheet" href="{{ asset('assets/front/css/slick.css') }}" type="text/css" media="all">
	<link rel="stylesheet" href="{{ asset('assets/front/css/simple-line-icons.css') }}" type="text/css" media="all">
	<link rel="stylesheet" href="{{ asset('assets/front/css/style.css') }}" type="text/css" media="all">

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
		<header class="header-personal light">
			<div class="container-xl header-top">
				<div class="row align-items-center">

					<div class="col-4 d-none d-md-block d-lg-block">
						<!-- social icons -->
						<ul class="social-icons list-unstyled list-inline mb-0">
							<li class="list-inline-item"><a href="#"><i class="fab fa-facebook-f"></i></a></li>
							<li class="list-inline-item"><a href="#"><i class="fab fa-twitter"></i></a></li>
							<li class="list-inline-item"><a href="#"><i class="fab fa-instagram"></i></a></li>
							<li class="list-inline-item"><a href="#"><i class="fab fa-pinterest"></i></a></li>
							<li class="list-inline-item"><a href="#"><i class="fab fa-medium"></i></a></li>
							<li class="list-inline-item"><a href="#"><i class="fab fa-youtube"></i></a></li>
						</ul>
					</div>

					<div class="col-md-4 col-sm-12 col-xs-12 text-center">
						<!-- site logo -->
						<a class="navbar-brand" href="personal-alt.html"><img
                            src="{{ asset('assets/front/logo_inimahsumedang_500x.png') }}" style="width: 130px;"
                            alt="logo" /></a>
						<a href="personal-alt.html" class="d-block text-logo">Katen<span class="dot">.</span></a>
						<span class="slogan d-block">Professional Writer & Personal Blogger</span>
					</div>

					<div class="col-md-4 col-sm-12 col-xs-12">
						<!-- header buttons -->
						<div class="header-buttons float-md-end mt-4 mt-md-0">
							<button class="search icon-button">
								<i class="icon-magnifier"></i>
							</button>
							<button class="burger-menu icon-button ms-2 float-end float-md-none">
								<span class="burger-icon"></span>
							</button>
						</div>
					</div>

				</div>
			</div>

			<nav class="navbar navbar-expand-lg">
				<div class="container-xl">

					<div class="collapse navbar-collapse justify-content-center centered-nav">
						<!-- menus -->
						<ul class="navbar-nav">	
							<li class="nav-item">
								<a class="nav-link" href="{{ route('beranda.index') }}">Beranda</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="{{ route('artikel.index') }}">Artikel</a>
							</li>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#">Info</a>
								<ul class="dropdown-menu">
									<li><a class="dropdown-item" href="category.html">Samsat Keliling</a></li>
									<li><a class="dropdown-item" href="blog-single.html">Sim Keliling</a></li>
									<li><a class="dropdown-item" href="blog-single-alt.html">Nomor Telepon Penting</a></li>
									<li><a class="dropdown-item" href="about.html">Jadwal Bus</a></li>
								</ul>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="contact.html">Tentang</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="contact.html">Kontak</a>
							</li>
						</ul>
					</div>

				</div>
			</nav>
		</header>

		<!-- section hero -->
		<section class="hero data-bg-image d-flex align-items-center" data-bg-image="{{ asset('assets/front/images/other/hero.jpg') }}">
			<div class="container-xl">
				<!-- call to action -->
				<div class="cta text-center">
					<h2 class="mt-0 mb-4">I'm Katen Doe.</h2>
					<p class="mt-0 mb-4">Hello, I’m a content writer who is fascinated by content fashion, celebrity and
						lifestyle. She helps clients bring the right content to the right people.</p>
					<a href="#" class="btn btn-light mt-2">About Me</a>
				</div>
			</div>
			<!-- animated mouse wheel -->
			<span class="mouse">
				<span class="wheel"></span>
			</span>
			<!-- wave svg -->
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 260">
				<path fill="#FFF" fill-opacity="1"
					d="M0,256L60,245.3C120,235,240,213,360,218.7C480,224,600,256,720,245.3C840,235,960,181,1080,176C1200,171,1320,213,1380,234.7L1440,256L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z">
				</path>
			</svg>
		</section>

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
                            <img src="{{ asset('assets/back/not-found.png') }}" alt="insta-title" />
                        </a>
                    </div>
                    <div class="insta-item col-sm-2 col-6 col-md-2">
                        <a href="#">
                            <img src="{{ asset('assets/back/not-found.png') }}" alt="insta-title" />
                        </a>
                    </div>
                    <div class="insta-item col-sm-2 col-6 col-md-2">
                        <a href="#">
                            <img src="{{ asset('assets/back/not-found.png') }}" alt="insta-title" />
                        </a>
                    </div>
                    <div class="insta-item col-sm-2 col-6 col-md-2">
                        <a href="#">
                            <img src="{{ asset('assets/back/not-found.png') }}" alt="insta-title" />
                        </a>
                    </div>
                    <div class="insta-item col-sm-2 col-6 col-md-2">
                        <a href="#">
                            <img src="{{ asset('assets/back/not-found.png') }}" alt="insta-title" />
                        </a>
                    </div>
                    <div class="insta-item col-sm-2 col-6 col-md-2">
                        <a href="#">
                            <img src="{{ asset('assets/back/not-found.png') }}" alt="insta-title" />
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
								<li class="list-inline-item"><a href="#"><i class="fab fa-facebook-f"></i></a></li>
								<li class="list-inline-item"><a href="#"><i class="fab fa-twitter"></i></a></li>
								<li class="list-inline-item"><a href="#"><i class="fab fa-instagram"></i></a></li>
								<li class="list-inline-item"><a href="#"><i class="fab fa-pinterest"></i></a></li>
								<li class="list-inline-item"><a href="#"><i class="fab fa-medium"></i></a></li>
								<li class="list-inline-item"><a href="#"><i class="fab fa-youtube"></i></a></li>
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
		<button type="button" class="btn-close" aria-label="Close"></button>
		<!-- content -->
		<div class="search-content">
			<div class="text-center">
				<h3 class="mb-4 mt-0">Press ESC to close</h3>
			</div>
			<!-- form -->
			<form class="d-flex search-form">
				<input class="form-control me-2" type="search" placeholder="Search and press enter ..."
					aria-label="Search">
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
			<img src="images/logo.svg" alt="Katen" />
		</div>

		<!-- menu -->
		<nav>
			<ul class="vertical-menu">
				<li class="active">
					<a href="index.html">Home</a>
					<ul class="submenu">
						<li><a href="index.html">Magazine</a></li>
						<li><a href="personal.html">Personal</a></li>
						<li><a href="personal-alt.html">Personal Alt</a></li>
						<li><a href="minimal.html">Minimal</a></li>
						<li><a href="classic.html">Classic</a></li>
					</ul>
				</li>
				<li><a href="category.html">Lifestyle</a></li>
				<li><a href="category.html">Inspiration</a></li>
				<li>
					<a href="#">Pages</a>
					<ul class="submenu">
						<li><a href="category.html">Category</a></li>
						<li><a href="blog-single.html">Blog Single</a></li>
						<li><a href="blog-single-alt.html">Blog Single Alt</a></li>
						<li><a href="about.html">About</a></li>
						<li><a href="contact.html">Contact</a></li>
					</ul>
				</li>
				<li><a href="contact.html">Contact</a></li>
			</ul>
		</nav>

		<!-- social icons -->
		<ul class="social-icons list-unstyled list-inline mb-0 mt-auto w-100">
			<li class="list-inline-item"><a href="#"><i class="fab fa-facebook-f"></i></a></li>
			<li class="list-inline-item"><a href="#"><i class="fab fa-twitter"></i></a></li>
			<li class="list-inline-item"><a href="#"><i class="fab fa-instagram"></i></a></li>
			<li class="list-inline-item"><a href="#"><i class="fab fa-pinterest"></i></a></li>
			<li class="list-inline-item"><a href="#"><i class="fab fa-medium"></i></a></li>
			<li class="list-inline-item"><a href="#"><i class="fab fa-youtube"></i></a></li>
		</ul>
	</div>

	<!-- JAVA SCRIPTS -->
	<script src="{{ asset('assets/front/js/jquery.min.js') }}"></script>
	<script src="{{ asset('assets/front/js/popper.min.js') }}"></script>
	<script src="{{ asset('assets/front/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('assets/front/js/slick.min.js') }}"></script>
	<script src="{{ asset('assets/front/js/jquery.sticky-sidebar.min.js') }}"></script>
	<script src="{{ asset('assets/front/js/custom.js') }}"></script>

</body>

</html>