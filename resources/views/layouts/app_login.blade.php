<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="theme-color" content="#009688">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{url('img/toyota.png')}}" type="image/x-icon">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- <title>{{ config('app.name', 'Laravel') }}</title> -->
    <title>Approval Diskon . Plaza Toyota</title>
    <!-- Scripts -->
    <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">
    <style>
        /* th { font-family: 'Montserrat', sans-serif; 
            font-size: 15px;
        } */
    </style>
    <!-- Styles -->
    <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"> -->
    <link href="{{ asset('css/floating-labels.css')}}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap_v453.min.css')}}" rel="stylesheet">
    <!-- jQuery and JS bundle w/ Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script src="{{ asset('js/jquery.typer.js')}}"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <style>
		@import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');
		body {
			background-color: #fff;
			/* background-image:url('images/back1.jpg');  */
			background-image:url('{{url('img/back1.jpg')}}'); 
			background-repeat: no-repeat;  
			background-size: cover; 
			/* overflow: visible !important; */
		}
        h2{
    		font-family: 'Roboto', sans-serif !important;
        }
		@media screen and (max-width: 800px) {
			body {
				background-color: #fff;
				background-image:url('images/back1.jpg'); 
				background-repeat: no-repeat;  
				background-size: cover;
				background-position: top;
				background-attachment: fixed;
				overflow: auto !important;
			}
        }
        .form-signin{
            max-width: 555px !important;
            background: #eaeaea; 
            border: 1px solid black; 
            border-radius: 9px;
            box-shadow: 0 1px 20px rgba(0, 0, 0, 0.9); /* Opera 10.5, IE 9, Firefox 4+, Chrome 6+, iOS 5 */
            -webkit-box-shadow: 0 1px 20px rgba(0, 0, 0, 0.7); /* Safari 3-4, iOS 4.0.2 - 4.2, Android 2.3+ */
            -moz-box-shadow: 0 1px 20px rgba(0, 0, 0, 0.7); /* Firefox 3.5 - 3.6 */
        }
        .field-icon{
            float: right;
            margin-left: -10px;
            margin-top: -30px;
            position: relative;
            z-index: 3;
            padding-right: 7px;
        }
    </style>
</head>
<body>
    @yield('content')
<script>
    $(function () {
        $('[data-typer-targets]').typer();
    });
</script>
</body>
</html>
