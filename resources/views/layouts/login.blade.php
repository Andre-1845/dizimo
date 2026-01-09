<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel</title>

    @vite(['resources/css/app.css', 'resources/js/app_auth.js'])
</head>

<body class="bg-login">
    <div class="card-login">
        <div class="logo-wrapper-login">
            <a href="{{ route('site.home') }}">
                <img class="w-20" src="{{ asset('images/sarex.png') }}" alt="LOGO" />
            </a>
        </div>
        @yield('content')

    </div>
    </div>


</body>

</html>
