<!DOCTYPE html>
<html>
<head>
	<title>Canika | Verifikasi Akun</title>
	<meta charset="utf-8">
	{{-- <link rel="stylesheet" type="text/css" href="{{ asset('mail/css/bootstrap.css')}}"> --}}
	<style type="text/css">
	/*@media only screen and (max-width: 765px){
	.logo{
		min-width: 25%;
	}
}*/

html *{
	font-family: 'Montserrat', sans-serif !important;
}

h2,h3{
	font-weight: bold;
}


.row{
	margin-top: 10px;
	margin-bottom: 20px;
	display: flex;
    flex-wrap: wrap;
}

.newsletter{
	max-width: 40%;
	margin-top: 20px;
	width: 100%;
  	height: auto;
}

.logo{
	margin-top: 20px;
	max-width: 20%;
	width: 100%;
  	height: auto;
}

.inline{
	display: inline-block;
}

h2.newsletter{
	vertical-align: middle;
	margin-top: 32px;
	margin-left: 10px;
}

.main{
	border-top: 5px solid #dd486a;
	float: none;
    margin: 0 auto;
}

h1{
	font-size: 30px;
}

.time{
	font-weight: bold;
	color: #9B9B9B;
}

.judul{
	color: #EA5D90;
	margin-bottom: 30px;
	font-weight: bold;
}

.header{
	margin-bottom: 50px;
}

p.pesan{
	font-size: 20px;
	color: #808080;
}

.btn{
	background-color: #E53072;
	color: #fff;
	font-size: 22px;
	padding-left: 50px;
	padding-right: 50px;
	margin-bottom: 20px;
	margin-top: 10px;
}

.btn:focus, .btn:hover{
	color: #fff;
}

.pesan2{
	font-size: 16px;
	color: #8c8c8c;
}

.email{
	color: #EE7FA8;
	font-weight: 600;
}

.makeup{
	/*height: 20vh;
  	width: 100%;
  	object-fit: cover;*/
  	width: 100%;
  	/*max-width: 600px;
	height: auto;*/
}

.item-thumbnail{
	display: block;
  	margin-left: auto;
  	margin-right: auto;
	width: 100%;
}

.vertical-align {
    display: flex;
    align-items: center;
}

footer{
	background-color: #F5F5F5;
	padding-top: 20px;
	padding-bottom: 50px;
	margin-top: 50px;
}

.navbar{
	margin-bottom: 0px;
}

.footermsg{
	color: #E53072;
	font-size: 25px;
	margin-bottom: 30px;
	font-weight: bold;
}</style>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
</head>
<body>
	<div class="container main">
		<div class="col-8">
			<img src="{{ asset('mail/img/logoaja.png') }}" class="logo">
			<hr>
			<h1 class="judul">Verifikasi Akun</h1>
			<p class="pesan"> <strong>Hi, John.</strong> Silahkan menggunakan tombol dibawah ini untuk melakukan verifikasi akun anda.</p>
			<button class="btn btn-lg verBtn">Verifikasi</button>
			<p class="pesan2">Jika anda memiliki kendala, silakan menghubungi kami melalui</p>
			<a href="mailto:admin@canika.co.id" class="email">admin@canika.co.id</a>
			<footer class="navbar navbar-fixed-bottom">
				<div class="container footer text-center">
					<div class="col-8">
						<h1 class="footermsg">Wujudkan Pernikahan Impianmu</h1>
						<a href="https://play.google.com/store/apps/details?id=com.cnka.canika" target="_blank"><img src="{{ asset('mail/img/googleplay.png') }}" class="img-responsive center-block"></a>
					</div>
				</div>
			</footer>
		</div>
	</div>
</body>
</html>