<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Jajanan Tradisional</title>

	<!-- Favicon -->
	<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('image/icon_univ_bsi.png') }}">

	<!-- Google font -->
	<link href="https://fonts.googleapis.com/css?family=Hind:400,700" rel="stylesheet">

	<!-- Bootstrap -->
	<link type="text/css" rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}" />

	<!-- Slick -->
	<link type="text/css" rel="stylesheet" href="{{ asset('frontend/css/slick.css') }}" />
	<link type="text/css" rel="stylesheet" href="{{ asset('frontend/css/slick-theme.css') }}" />

	<!-- nouislider -->
	<link type="text/css" rel="stylesheet" href="{{ asset('frontend/css/nouislider.min.css') }}" />

	<!-- Font Awesome Icon -->
	<link rel="stylesheet" href="{{ asset('frontend/css/font-awesome.min.css') }}">

	<!-- Custom stlylesheet -->
	<link type="text/css" rel="stylesheet" href="{{ asset('frontend/css/style.css') }}" />

	<!-- Custom styles -->
	<link type="text/css" rel="stylesheet" href="{{ asset('frontend/css/custom.css') }}" />

</head>

<body>
	@php
	$kategori = DB::table('kategori')->orderBy('nama_kategori', 'asc')->get();
	$topProduk = App\Models\Produk::where('status', 1)->orderBy('updated_at', 'desc')->take(2)->get();
	@endphp
	<!-- HEADER -->
	<header>
		<!-- top Header -->
		<div id="top-header">
			<div class="container">
				<div class="pull-left">
					<span><i class="fa fa-shopping-basket"></i> Selamat datang di Jajanan Tradisional!</span>
				</div>
				<div class="pull-right">
					<ul class="header-top-links">
						<li><a href="#">Toko</a></li>
						<li><a href="#">Newsletter</a></li>
						<li><a href="#">FAQ</a></li>
						<li class="dropdown default-dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">IDR <i class="fa fa-caret-down"></i></a>
							<ul class="custom-menu">
								<li><a href="#">IDR (Rp)</a></li>
								<li><a href="#">USD ($)</a></li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<!-- /top Header -->

		<!-- header -->
		<div id="header">
			<div class="container">
				<div class="pull-left">
					<!-- Logo -->
					<div class="header-logo">
						<a class="logo" href="{{ url('/') }}">
							<img src="{{ asset('image/logo.png') }}" alt="Jajanan Tradisional">
						</a>
					</div>
					<!-- /Logo -->

					<!-- Search -->
					<div class="header-search">
						<form>
							<input class="input search-input" type="text" placeholder="Cari produk...">
							<select class="input search-categories">
								<option value="0">Semua Kategori</option>
								@foreach ($kategori as $k)
								<option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
								@endforeach
							</select>
							<button class="search-btn"><i class="fa fa-search"></i></button>
						</form>
					</div>
					<!-- /Search -->
				</div>
				<div class="pull-right">
					<ul class="header-btns">
						<!-- Account -->
						<li class="header-account dropdown default-dropdown">
							@if (Auth::check())
								<div class="dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="true">
									<div class="header-btns-icon">
										<i class="fa fa-user-o"></i>
									</div>
									<div class="header-btn-text">
										<strong class="text-uppercase">{{ Auth::user()->nama }} <i class="fa fa-caret-down"></i></strong>
									</div>
								</div>
								<ul class="custom-menu">
									<li><a href="{{ route('customer.akun', ['id' => Auth::user()->id]) }}"><i class="fa fa
									user-o"></i> Akun Saya</a> 
									</li> 
										<a href="#" onclick="event.preventDefault(); document.getElementById('keluar-app').submit();">
											<i class="fa fa-power-off"></i> Keluar
										</a>
										<form id="keluar-app" action="{{ route('logout') }}" method="POST" class="d-none">
											@csrf
										</form>
									</li>
								</ul>
							@else
								<div class="dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="true">
									<div class="header-btns-icon">
										<i class="fa fa-user-o"></i>
									</div>
									<div class="header-btn-text">
										<strong class="text-uppercase">Akun Saya <i class="fa fa-caret-down"></i></strong>
										<span>Login / Daftar</span>
									</div>
								</div>
								<ul class="custom-menu">
									<li><a href="{{ route('auth.redirect') }}"><i class="fa fa-unlock-alt"></i> Login</a></li>
									<li><a href="#"><i class="fa fa-user-plus"></i> Daftar</a></li>
								</ul>
							@endif
						</li>
						<!-- /Account -->

						<!-- Cart -->
						<li class="header-cart dropdown default-dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
								<div class="header-btns-icon">
									<i class="fa fa-shopping-cart"></i>
									<span class="qty">0</span>
								</div>
								<div class="header-btn-text">
									<strong class="text-uppercase">Keranjang</strong>
									<span class="cart-total">Rp. 0</span>
								</div>
							</a>
							<div class="custom-menu">
								<div id="shopping-cart">
									<div class="shopping-cart-list"></div>
									<div class="shopping-cart-btns">
										<button class="main-btn">Lihat Keranjang</button>
										<button class="primary-btn">Checkout <i class="fa fa-arrow-circle-right"></i></button>
									</div>
								</div>
							</div>
						</li>
						<!-- /Cart -->

						<!-- Mobile nav toggle-->
						<li class="nav-toggle">
							<button class="nav-toggle-btn main-btn icon-btn"><i class="fa fa-bars"></i></button>
						</li>
						<!-- / Mobile nav toggle -->
					</ul>
				</div>
			</div>
			<!-- header -->
		</div>
		<!-- container -->
	</header>
	<!-- /HEADER -->

	<!-- NAVIGATION -->
	<div id="navigation">
		<!-- container -->
		<div class="container">
			<div id="responsive-nav">
				<!-- category nav -->
				<div class="category-nav show-on-click">
					<span class="category-header">Kategori <i class="fa fa-list"></i></span>
					<ul class="category-list">
						@foreach ($kategori as $k)
						<li><a href="{{ route('produk.kategori', $k->id) }}">{{ $k->nama_kategori }}</a></li>
						@endforeach
					</ul>
				</div>
				<!-- /category nav -->

				<!-- menu nav -->
				<div class="menu-nav">
					<span class="menu-header">Menu <i class="fa fa-bars"></i></span>
					<ul class="menu-list">
						<li><a href="{{ route('beranda') }}">Beranda</a></li>
						<li><a href="{{ route('produk.all') }}">Produk</a></li>
						<li><a href="#">Lokasi</a></li>
						<li><a href="#">Hubungi Kami</a></li>
					</ul>
				</div>
				<!-- menu nav -->
			</div>
		</div>
		<!-- /container -->
	</div>
	<!-- /NAVIGATION -->

	<!-- HOME -->
	@if (request()->segment(1) == '' || request()->segment(1) == 'beranda')
	<div id="home">
		<!-- container -->
		<div class="container">
			<!-- home wrap -->
			<div class="home-wrap">
				<!-- home slick -->
				<div id="home-slick">
					<!-- banner -->
					<div class="banner banner-1">
						<img src="{{ asset('frontend/banner/banner01.jpg') }}" alt="">
						<div class="banner-caption text-center">
							<h1>Jajanan Tradisional</h1>
							<h3 class="white-color font-weak">Khas Makanan Indonesia</h3>
							<button class="primary-btn">Pesan Sekarang</button>
						</div>
					</div>
					<!-- /banner -->

					<!-- banner -->
					<div class="banner banner-1">
						<img src="{{ asset('frontend/banner/banner02.jpg') }}" alt="">
						<div class="banner-caption">
							<h1 class="primary-color">Jajanan Tradisional<br><span class="white-color font-weak">Khas Makanan Indonesia</span></h1>
							<button class="primary-btn">Pesan Sekarang</button>
						</div>
					</div>
					<!-- /banner -->

					<!-- banner -->
					<div class="banner banner-1">
						<img src="{{ asset('frontend/banner/banner03.jpg') }}" alt="">
						<div class="banner-caption">
							<h1 class="white-color">Jajanan Tradisional <span>Khas Makanan Indonesia</span></h1>
							<button class="primary-btn">Pesan Sekarang</button>
						</div>
					</div>
					<!-- /banner -->
				</div>
				<!-- /home slick -->
			</div>
			<!-- /home wrap -->
		</div>
		<!-- /container -->
	</div>
	@endif
	<!-- /HOME -->

	<!-- section -->
	<div class="section">
		<!-- container -->
		<div class="container">
			<!-- row -->
			<div class="row">

				<!-- ASIDE -->
				<div id="aside" class="col-md-3">

					<!-- aside widget -->
					<div class="aside">
						<h3 class="aside-title">Top Rated Product</h3>
						@foreach ($topProduk as $top)
						<!-- widget product -->
						<div class="product product-widget">
							<div class="product-thumb">
								<img src="{{ asset('storage/img-produk/thumb_md_' . $top->foto) }}" alt="{{ $top->nama_produk }}">
							</div>
							<div class="product-body">
								<h2 class="product-name"><a href="{{ route('produk.detail', $top->id) }}">{{ $top->nama_produk }}</a></h2>
								<h3 class="product-price">Rp. {{ number_format($top->harga, 0, ',', '.') }}</h3>
								<div class="product-rating">
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star-o empty"></i>
								</div>
							</div>
						</div>
						<!-- /widget product -->
						@endforeach
					</div>
					<!-- /aside widget -->

					<!-- aside widget -->
					<div class="aside">
						<h3 class="aside-title">Filter Kategori</h3>
						<ul class="list-links">
							@foreach ($kategori as $row)
							<li><a href="{{ route('produk.kategori', $row->id) }}">{{ $row->nama_kategori }}</a></li>
							@endforeach
						</ul>
					</div>
					<!-- /aside widget -->

				</div>
				<!-- /ASIDE -->

				<!-- MAIN -->
				<div id="main" class="col-md-9">

					<!-- @yieldAwal -->
					@yield('content')
					<!-- @yieldAkhir -->

				</div>
				<!-- /MAIN -->

			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</div>
	<!-- /section -->

	<!-- FOOTER -->
	<footer id="footer" class="section section-grey">
		<!-- container -->
		<div class="container">
			<!-- row -->
			<div class="row">
				<!-- footer widget -->
				<div class="col-md-3 col-sm-6 col-xs-6">
					<div class="footer">
						<!-- footer logo -->
						<div class="footer-logo">
							<a class="logo" href="{{ url('/') }}">
								<img src="{{ asset('image/logo.png') }}" alt="Jajanan Tradisional">
							</a>
						</div>
						<!-- /footer logo -->

						<p>Jajanan Tradisional menyediakan aneka jajanan pasar dan makanan khas Indonesia dengan cita rasa autentik.</p>

						<!-- footer social -->
						<ul class="footer-social">
							<li><a href="#"><i class="fa fa-facebook"></i></a></li>
							<li><a href="#"><i class="fa fa-twitter"></i></a></li>
							<li><a href="#"><i class="fa fa-instagram"></i></a></li>
							<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
							<li><a href="#"><i class="fa fa-pinterest"></i></a></li>
						</ul>
						<!-- /footer social -->
					</div>
				</div>
				<!-- /footer widget -->

				<!-- footer widget -->
				<div class="col-md-3 col-sm-6 col-xs-6">
					<div class="footer">
						<h3 class="footer-header">Akun Saya</h3>
						<ul class="list-links">
							<li><a href="#">Akun Saya</a></li>
							<li><a href="#">Checkout</a></li>
							<li><a href="#">Login</a></li>
						</ul>
					</div>
				</div>
				<!-- /footer widget -->

				<div class="clearfix visible-sm visible-xs"></div>

				<!-- footer widget -->
				<div class="col-md-3 col-sm-6 col-xs-6">
					<div class="footer">
						<h3 class="footer-header">Layanan Pelanggan</h3>
						<ul class="list-links">
							<li><a href="#">Tentang Kami</a></li>
							<li><a href="#">Pengiriman &amp; Pengembalian</a></li>
							<li><a href="#">Panduan Pengiriman</a></li>
							<li><a href="#">FAQ</a></li>
						</ul>
					</div>
				</div>
				<!-- /footer widget -->

				<!-- footer subscribe -->
				<div class="col-md-3 col-sm-6 col-xs-6">
					<div class="footer">
						<h3 class="footer-header">Tetap Terhubung</h3>
						<p>Dapatkan informasi promo dan produk terbaru dari kami.</p>
						<form>
							<div class="form-group">
								<input class="input" placeholder="Masukkan Alamat Email">
							</div>
							<button class="primary-btn">Berlangganan</button>
						</form>
					</div>
				</div>
				<!-- /footer subscribe -->
			</div>
			<!-- /row -->
			<hr>
			<!-- row -->
			<div class="row">
				<div class="col-md-8 col-md-offset-2 text-center">
					<!-- footer copyright -->
					<div class="footer-copyright">
						<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
						Copyright &copy;<script>
							document.write(new Date().getFullYear());
						</script> Jajanan Tradisional | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
						<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
					</div>
					<!-- /footer copyright -->
				</div>
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</footer>
	<!-- /FOOTER -->

	<!-- jQuery Plugins -->
	<script src="{{ asset('frontend/js/jquery.min.js') }}"></script>
	<script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('frontend/js/slick.min.js') }}"></script>
	<script src="{{ asset('frontend/js/nouislider.min.js') }}"></script>
	<script src="{{ asset('frontend/js/jquery.zoom.min.js') }}"></script>
	<script src="{{ asset('frontend/js/main.js') }}"></script>

</body>

</html>