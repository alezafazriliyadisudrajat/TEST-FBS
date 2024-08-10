<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.2.0/css/all.css'>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/image/logo test.jpeg') }}">
</head>

<body>
    <div class="container">
        <div class="login-box">
            <h1 class="login-title">Welcome Back!</h1>
            <form class="login-form" method="post" action="{{ route('authlogin') }}">
              @csrf
                <div class="input-group">
                    <i class="input-icon fas fa-user"></i>
                    <input type="text" class="input-field" placeholder="Masukkan Username" name="username" value="{{ old('username') }}" required>
                </div>
                <div class="input-group">
                    <i class="input-icon fas fa-lock"></i>
                    <input type="password" class="input-field" placeholder="******" name="password" value="{{ old('password') }}" required>
                </div>
                <button type="submit" class="submit-button">Log In</button>
            </form>
           
        </div>
    </div>

</body>
@include('sweetalert::alert')
</html>
