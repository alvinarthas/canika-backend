<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width">
    <meta name="format-detection" content="address=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="format-detection" content="email=no">
</head>
<body>
    Hi, {{$email}} <br>
    Terima Kasih sudah mendaftar di canika, silahkan melakukan verifikasi email <a href="{{route($route,["email" => $email, "verifyToken"=> $verifyToken])}}">Disini</a>
    
</body>