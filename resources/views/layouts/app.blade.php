<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<style>
    body { padding-bottom: 100px;}
    .level {display:flex; align-items:center; }
    .flex {flex:1;}
</style>
<body>
<div id="app">
    @include('layouts.nav')
    <main class="py-4">
        @yield('content')
        <Flash message="{{session('flash')}}"></Flash>
    </main>
</div>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
