<!DOCTYPE html>
<html>
	<head>
		<title>Canika | Reset Password</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="{{ asset('mail/css/bootstrap.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('mail/css/style.css') }}">
		<script src="{{ asset('mail/js/bootstrap.min.js') }}"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
	</head>
	<body>
		<div class="container main">
			<div class="col-8">
				<img src="{{ asset('mail/img/logoaja.png') }}" class="logo">
				<hr>
				<h1 class="judul">Reset Password</h1>
                <form action="{{ route('storeChangePass')}}" method="post" oninput='pass2.setCustomValidity(pass2.value != pass.value ? "Passwords do not match." : "")'>
                    @csrf
					<div class="form-group row">
						<div class="col-lg-4 col-md-4 col-sm-6">
							<label for="email">Email</label>
							<input type="text" class="form-control" id="email" placeholder="Enter password" name="email" value="{{$email}}" readonly>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-lg-4 col-md-4 col-sm-6">
							<label for="password1">Password baru</label>
							<input type="password" class="form-control" id="password1" placeholder="Enter password" name="pass" required>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-lg-4 col-md-4 col-sm-6">
							<label for="password2">Ketik ulang password baru</label>
							<input type="password" class="form-control" id="password2" placeholder="Re-enter password" name="pass2" required>
						</div>
					</div>
					<button type="submit" class="btn btn-sm">Reset Password</button>
				</form>
			</div>
			<footer class="navbar navbar-fixed-bottom">
				<div class="container footer text-center">
					<div class="col-8">
						<h1 class="footermsg">Wujudkan Pernikahan Impianmu</h1>
						<a href="https://play.google.com/store/apps/details?id=com.cnka.canika" target="_blank"><img src="{{ asset('mail/img/googleplay.png') }}" class="img-responsive center-block"></a>
					</div>
				</div>
			</footer>
		</div>
	</body>
</html>