<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('layouts.partials.favicons')

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @isset($title)
        <title>{{ $title }} | aecor developer handbook</title>
    @else
        <title>aecor developer handbook</title>
    @endif

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('css/custom.css') }}" rel="stylesheet"> --}}
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,900" rel="stylesheet">

    <script src="{{ mix('js/app.js') }}" defer></script>
</head>
<body @if($background ?? false) class="waves" @endif>
    @include('googletagmanager::script')
    {{ $slot }}
</body>
</html>
