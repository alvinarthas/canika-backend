<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>
	<!-- Document Meta
    ============================================= -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!--IE Compatibility Meta-->
	<meta name="author" content="zytheme"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="description" content="Canika wujudkan pernikahan impian">
	<link href="{{ asset('assets/images/favicon/favicon.ico') }}" rel="icon">

	<!-- Fonts
    ============================================= -->
	<link href='http://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i%7COpen+Sans:300,300i,400,400i,600,600i,700,700i,800,800' rel='stylesheet' type='text/css'>

	<!-- Stylesheets
    ============================================= -->
	<link href="{{ asset('assets/css/external.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">


	<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
	<!--[if lt IE 9]>
      <script src="assets/js/html5shiv.js"></script>
      <script src="assets/js/respond.min.js"></script>
    <![endif]-->

	<!-- Document Title
    ============================================= -->
	<title>Canika | Wujudkan pernikahan idaman mu!</title>
</head>

<body class="body-scroll">
	<!-- Document Wrapper
	============================================= -->
	<div id="wrapper" class="wrapper clearfix">

		<!-- Header
        ============================================= -->
		<header id="navbar-spy" class="header header-1 header-transparent header-bordered header-fixed">

			<nav id="primary-menu" class="navbar navbar-fixed-top">
				<div class="container">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					</button>
						<a class="logo" href="index.html">
							<img class="logo-dark" src="{{ asset('assets/images/logo/logo.png') }}" alt="Canika Logo">
							<img class="logo-light" src="{{ asset('assets/images/logo/logo-putih.png') }}" alt="Canika Logo">
						</a>
					</div>
					<div class="collapse navbar-collapse pull-right" id="navbar-collapse-1">
						<ul class="nav navbar-nav nav-pos-right navbar-left nav-split">
							<li class="active"><a data-scroll="scrollTo" href="#slider">home</a>
							</li>
							<li><a data-scroll="scrollTo" href="#feature2">feature</a>
							</li>
							<li><a data-scroll="scrollTo" href="#screenshots">screenshots</a>
							</li>
							<li><a data-scroll="scrollTo" href="#newsletter">subscribe</a>
							</li>
						</ul>
					</div>
					<!--/.nav-collapse -->
				</div>
			</nav>
		</header>

		@if(Session::has('status'))
		<!-- Modal -->
			<div class="modal fade" id="popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					</div>
					<div class="modal-body">
					<h6>{{Session::get('status')}}</h6>
					</div>
				</div>
				</div>
			</div>
		@endif

		<!-- Slider #1
		============================================= -->
		<section id="slider" class="section slider">
			<div class="slide--item bg-overlay bg-overlay-theme">
				<div class="bg-section">
					<img src="{{ asset('assets/images/background/wedding.jpg') }}" alt="background">
				</div>
				<div class="container">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12">
							<div class="slide--logo mt-100 hidden-xs wow fadeInUp" data-wow-duration="1s">
								<img src="{{ asset('assets/images/logo/logo-putih.png') }}" alt="Canika">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 col-sm-6 col-md-6 pt-100 wow fadeInUp" data-wow-duration="1s">
							<div class="slide--headline">
								<h1>Wujudkan pernikahan impian mu dengan Canika!</h1>
							</div>
							<div class="slide--bio">Pilih sendiri MUA, catering, dekorasi, hingga venue yang kamu inginkan dalam genggaman Android mu! <br/> Subscribe untuk info terbaru dari kami!</div>
							<div class="slide--action">
								<form class="mb-0 form-action" action="{{route('subscribe')}}" method="post">
									{{ csrf_field() }}
									<div class="input-group">
										<input type="email" class="form-control" placeholder="E-mail address" name="email">
										<span class="input-group-btn">
											<input type="submit" class="btn btn--primary" value="subscribe" name="submit">
										</span>
									</div>
									<!-- .input-group end -->
								</form>
							</div>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-4 col-md-offset-2 wow fadeInUp" data-wow-duration="1s">
							<img class="img-responsive pull-right" src="{{ asset('assets/images/mockup/Canika.png') }}" alt="screens">
						</div>
					</div>
					<!-- .row end -->
				</div>
				<!-- .container end -->
			</div>
			<!-- .slide-item end -->
		</section>
		<!-- #slider end -->

		<!-- Feature #2
		============================================= -->
		<section id="feature2" class="section feature feature-2 text-center bg-white">
			<div class="container">
				<div class="row clearfix">
					<div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3">
						<div class="heading heading-1 mb-80 text--center wow fadeInUp" data-wow-duration="1s">
							<h2 class="heading--title">Kenapa Harus Canika?</h2>
							<!-- p class="heading--desc">we shows only the best websites, portfolios ans landing pages built completely with passion, simplicity & creativity !</p -->
						</div>
					</div>
					<!-- .col-md-6 end -->
				</div>
				<!-- .row end -->
				<div class="row mb-60">
					<!-- Panel #1 -->
					<div class="col-xs-12 col-sm-4 col-md-4">
						<div class="feature-panel wow fadeInUp" data-wow-duration="1s">
							<div class="feature--icon">
								<i class="fas fa-gem"></i>
							</div>
							<div class="feature--content">
								<h3>Rancang pernikahan sesuai yang kamu idamkan!</h3>
								<p>Pilih vendor yang sesuai dengan keinginanmu ratusan pilihan vendor! </p>
							</div>
						</div>
						<!-- .feature-panel end -->
					</div>
					<!-- .col-md-4 end -->

					<!-- Panel #2 -->
					<div class="col-xs-12 col-sm-4 col-md-4">
						<div class="feature-panel wow fadeInUp" data-wow-duration="1s">
							<div class="feature--icon">
								<i class="fas fa-comments-dollar"></i>
							</div>
							<div class="feature--content">
								<h3>Negosiasikan biaya sesuai budget yang kamu punya!</h3>
								<p>Dengan fitur chat, kamu bisa mengkomunikasikan semuanya dengan vendor.</p>
							</div>
						</div>
						<!-- .feature-panel end -->
					</div>
					<!-- .col-md-4 end -->

					<!-- Panel #3 -->
					<div class="col-xs-12 col-sm-4 col-md-4">
						<div class="feature-panel wow fadeInUp" data-wow-duration="1s">
							<div class="feature--icon">
								<i class="fas fa-hand-holding-usd"></i>
							</div>
							<div class="feature--content">
								<h3>Bayar DP & pelunasan pesanan dengan aman dan nyaman!</h3>
								<p>Pembayaran akan ditransfer ke rekening Canika terlebih dahulu agar terjamin keamanan dan kenyamanan ketika bertransaksi.</p>
							</div>
						</div>
						<!-- .feature-panel end -->
					</div>
					<!-- .col-md-4 end -->
				</div>
				<!-- .row end -->
			</div>
			<!-- .container end -->
		</section>
		<!-- #feature2 end -->

		<!-- Screenshots
        ============================================= -->
		<section id="screenshots" class="section screenshots">
			<div class="container">
				<div class="row clearfix">
					<div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3">
						<div class="heading heading-1 mb-60 text--center wow fadeInUp" data-wow-duration="1s">
							<h2 class="heading--title">Solusi untuk perencanaan pernikahan mu!</h2>
						</div>
					</div>
					<!-- .col-md-6 end -->
				</div>
				<!-- .row end -->
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12">
						<div class="carousel" data-slide="4" data-slide-res="2" data-autoplay="true" data-nav="false" data-dots="false" data-space="30" data-loop="true" data-speed="1000">
							<!-- screenshot #1 -->
							<div class="screenshot">
								<img class="center-block" src="{{ asset('assets/images/screenshots/1splashscreen.png') }}" alt="splash screen">
							</div>

							<!-- screenshot #2 -->
							<div class="screenshot">
								<img class="center-block" src="{{ asset('assets/images/screenshots/2Home.png') }}" alt="home">
							</div>

							<!-- screenshot #3 -->
							<div class="screenshot">
								<img class="center-block" src="{{ asset('assets/images/screenshots/3Venue.png') }}" alt="Venue">
							</div>

							<!-- screenshot #4 -->
							<div class="screenshot">
								<img class="center-block" src="{{ asset('assets/images/screenshots/4viewetalase.png') }}" alt="Lihat Etalase">
							</div>

							<!-- screenshot #5 -->
							<div class="screenshot">
								<img class="center-block" src="{{ asset('assets/images/screenshots/5negotiation.png') }}" alt="negosiasi">
							</div>

						</div>
					</div>
					<!-- .col-md-12 end -->
				</div>
				<!-- .row end -->
			</div>
			<!-- .container End -->
		</section>
		<!-- #screenshots End-->

		<!-- Newsletter #1
		============================================= -->
		<section id="newsletter" class="section newsletter text-center bg-overlay bg-overlay-theme">
			<div class="bg-section">
				<img src="{{ asset('assets/images/background/bg-3.jpg') }}" alt="Background"/>
			</div>
			<div class="container">
				<div class="row clearfix">
					<div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
						<div class="heading heading-1 mb-60 text--center wow fadeInUp" data-wow-duration="1s">
							<h2 class="heading--title text-white">Berlangganan untuk mendapat info terbaru Canika!</h2>
							<p class="heading--desc text-white">Dengan berlangganan email ini, kami akan tahu bahwa Canika dibutuhkan oleh banyak orang. Yuk!</p>
						</div>
					</div>
					<!-- .col-md-6 end -->
				</div>
				<!-- .row end -->
				<div class="row">
					<div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
						<form class="mb-0 form-action wow fadeInUp" data-wow-duration="1s">
							<div class="input-group">
								<input type="email" class="form-control" placeholder="E-mail address">
								<span class="input-group-btn">
									<input type="submit" class="btn btn--primary" value="Subscribe" name="submit">
								</span>
							</div>
							<!-- .input-group end -->
						</form>
					</div>
					<!-- .col-md-12 end -->
				</div>
				<!-- .row end -->
			</div>
			<!-- .container end -->
		</section>
		<!-- #newsletter end -->

		<!-- Footer #5
		============================================= -->
		<footer id="footer" class="footer footer-5">
			<!-- Copyrights
			============================================= -->
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 text--center">
						<div class="footer--copyright">
							<span>&copy; 2018 Canika. Crafted with <i class="fa fa-heart"></i> by Canika team</span>
						</div>
					</div>
				</div>
			</div>
			<!-- .container end -->
		</footer>
	</div>
	<!-- #wrapper end -->

	<!-- Footer Scripts
	============================================= -->
	<script src="{{ asset('assets/js/jquery-2.2.4.min.js') }}"></script>
	<script src="{{ asset('assets/js/plugins.js') }}"></script>
	<script src="{{ asset('assets/js/functions.js') }}"></script>
	@if(Session::has('status'))
		<script>
			$('#popup').modal('show')
		</script>
	@endif
</body>
</html>
