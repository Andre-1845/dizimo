<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-login">
    <div class="card-login">
        <div class="logo-wrapper-login">
            @if ($siteLogo)
                <img class="w-20" src="{{ asset('storage/' . $siteLogo) }}" alt="{{ $appName }}">
            @else
                <span class="text-xl font-bold">{{ $appName }}</span>
            @endif
        </div>
        @yield('content')

    </div>
    </div>


</body>

</html>
