<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <form method="POST" id="loginForm" action="{{ route('login') }}">
        @csrf

        @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
        @endif
        <div class="maindiv">
            <img src="{{ asset('acc_images/CIMS.png') }}" width="250px" height="80px" /></img>
            <br>
            <h1 style="font-family: 'Google Sans', 'Noto Sans Myanmar UI', arial, sans-serif;">Sign in</h1>
            <div class="inputs">
                <div class="Fields">
                    <div class="Fieldset">
                        <input type="text" class="Before-FS @error('email') is-invalid @enderror" name="email"
                            value="{{ old('email') }}" required autocomplete="email" autofocus>
                        <h1 class="Fs-H"><span>Email</span></h1>
                        <label class="placeholder">Email</label>
                    </div>

                </div>
                @error('email')
                <span class="invalid-feedback" role="alert">
                    {{ $message }}
                </span>
                @enderror
                <div class="Fields">
                    <div class="Fieldset">
                        <input type="password" class="Before-FS @error('password') is-invalid @enderror" name="password" id="password"
                            value="{{ old('password') }}" required autocomplete="current-password">
                        <h1 class="Fs-H"><span>Password</span></h1>
                        <label class="placeholder">Password</label>
                        <input type="checkbox" id="show-password" onclick="togglePasswordVisibility()">
                        <label style="font-family: Arial, serif; color:grey" for="show-password">Show Password</label>

                    </div>
                </div>
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <br>
            <br>

            <button type="submit">Login</button>
            <br>
            <br>
            <br>
            <a href="{{ route('password.request') }}" class="forgot-pwd">Forgot Password?</a>
            <br> <label class="label">New User?</label>&nbsp;<a href="{{ route('register') }}">Register Here</a>
        </div>
    </form>
    <style>
    body {
        font-family: 'Google Sans', 'Noto Sans Myanmar UI', arial, sans-serif;
        background-color : grey;
    }

    img {
        max-width: 100px;
        max-height: 50px;
    }

    .maindiv {
        background-color : white;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 400px;
        min-height: 300px;
        padding: 3rem;
        border-radius: 0.5rem;
        border: 1px solid #e1e1e1;
        text-align: left;
    }

    .maindiv .Fields {
        display: inline-block;
        height: 90px;
        position: relative;
    }

    h1 {
        font-size: 24px;
        font-weight: 200px;
    }

    h3 {
        color: #202124;
        font-size: 16px;
        font-weight: 400;
    }

    input {
        outline: none;
    }

    .Before-FS {
        width: 344px;
        border: 1px solid #c2c2c2;
        border-radius: 3px;
        height: 28px;
        font-size: 16px;
        margin: 1px 1px 0 1px;
        padding: 13px 15px;
        transition: 0.1s;
    }

    .Before-FS:focus {
        border: 2px solid #1a73e8;
        border-top: 1px solid transparent;
    }

    .Fs-H {
        opacity: 0;
        transition: 0.2s;
    }

    .Fieldset>h1 {
        font: 1em normal;
        margin: -5px 2.5px -8px;
        position: relative;
        top: -60px
    }

    .Fieldset>h1>span {
        float: left;
        color: #1a73e8;
        font-family: 'Google Sans', 'Noto Sans Myanmar UI', 'arial', 'sans-serif';
        font-size: 13px;
    }

    .Fieldset>h1::before {
        border-top: 2px solid #1a73e8;
        content: ' ';
        float: left;
        margin: 0.5em 2px 0 -1px;
        width: 0.75em
    }

    .Fieldset>h1::after {

        border-top: 2px solid #1a73e8;
        content: ' ';
        display: block;
        height: 1.5em;
        left: 2px;
        margin: 0 1px 0 0;
        overflow: hidden;
        position: relative;
        top: 0.5em;
    }

    .placeholder {
        position: absolute;
        left: 20px;
        top: 19px;
        color: #80868b;
        font-size: 16px;
        font-weight: 400;
        pointer-events: none;
        transition: 0.4s
    }

    input:focus~label.placeholder,
    input:valid~label.placeholder {
        top: 3px;
        font-size: 10px;
        opacity: 0;
    }

    input:focus+.Fs-H,
    input:valid+.Fs-H {
        opacity: 1;

    }

    button {
        cursor: pointer;
        border: 1px solid transparent;
        padding: 6px 12px;
        font-size: 14px;
        line-height: 1.42;
        color: white;
        border-radius: 10px;
        background-color: #1F81C4;
        outline: none;
        min-width: 380px;
        min-height: 40px;

    }

    a {
        text-decoration: none;
        font-family: 'Google Sans', 'Noto Sans Myanmar UI', 'arial', 'sans-serif';
        font-size: 13px;
        color: #1F81C4;
        /* change to the desired color */
    }

    label {
        text-decoration: none;
        font-family: 'Google Sans', 'arial', 'sans-serif';
        font-size: 13px;
        color: #000000;
        /* change to the desired color */
    }
    </style>

    <script>
    function togglePasswordVisibility() {
        var passwordInput = document.getElementById("password");
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
        } else {
            passwordInput.type = "password";
        }
    }
    </script>
</body>

</html>