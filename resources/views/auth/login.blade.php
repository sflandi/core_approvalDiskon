@extends('layouts.app_login')

@section('content')
<div class="container">
    <div class="wrapper">
        <form class="form-signin" method="POST" action="{{ route('login') }}">
            @csrf
            <h2 class="text-center mt-3" style="font-family: sans-serif;" >
                <!-- <span data-typer-targets="Welcome, ようこそ, 歡迎, أهلا بك, Welkom, Welina, 어서 오십시오"></span>  -->
                <b>PLAZA<i style="color: #A70C00;">TOYOTA</i></b>
            </h2>
            <h2 class="text-center" style="font-family: sans-serif;" >
                <span data-typer-targets="APPROVAL, TOOLS"></span>&nbsp
                <!-- <span data-typer-targets="WELCOME, WELNI, WELSU, WELWE, WERTY"></span> APPLICATION -->
            </h2>
            <h2 class="text-center mb-3" style="font-family: sans-serif;" >APPLICATION</h2>
            <hr>
            <div class="form-label-group">
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="User ID" required autocomplete = "name" autofocus>
                <label for="name">{{ __('User ID') }}</label>

                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-label-group">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="current-password">
                <span class="far fa-eye field-icon" id="togglePassword"></span>
                <label for="password">{{ __('Password') }}</label>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <!-- <div class="form-group row">
                <div class="col-md-6 offset-md-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                </div>
            </div> -->

            <!-- <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary btn-block">
                        {{ __('Login') }}
                    </button>
                </div>
            </div> -->
            <hr>
            <button class="btn btn-lg btn-primary btn-block my-3" type="submit" name="login" >Sign In</button>
        </form>
    </div>
</div>
<script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#inputPassword');

    togglePassword.addEventListener('click', function (e) {
        // toggle the type attribute
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        // toggle the eye slash icon
        this.classList.toggle('fa-eye-slash');
    });
</script>
@endsection
