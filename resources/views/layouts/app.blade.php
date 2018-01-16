<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('layouts.partials.favicons')

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @isset($title)
        <title>{{ $title }} | aecor coding guidelines</title>
    @else
        <title>aecor coding guidelines</title>
    @endif

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('css/custom.css') }}" rel="stylesheet"> --}}
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700" rel="stylesheet">

    <script src="{{ mix('js/app.js') }}" defer></script>
</head>
<body @if($background ?? false) class="waves" @endif>
    @include('googletagmanager::script')
    {{ $slot }}
</body>
</html>
