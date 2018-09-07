<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <title>SQS SAMPLE | @yield('titleSuffix')</title>
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" >
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @yield('additionalCss')
</head>

<body>
@yield('content')
<script src="{{ mix('js/app.js') }}"></script>
@yield('additionalJs')
</body>
</html>
