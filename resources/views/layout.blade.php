<!DOCTYPE html>
<html lang="{{ __(config('app.locale')) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@section('title') {{ __(config('app.name')) }}@if(isset($title)) - {{ __($title) }}@endif @show</title>

    <!-- Styles -->
    @section('css')
        <link rel="stylesheet" type="text/css" href="/css/app.css">
    @show
</head>
<body>
<header class="layout-header">
@section('header')
    @include('components.head')
@show
</header>
<div class="layout-center">
    @section('center')

    @show
</div>
<footer class="layout-footer">
@section('foot')
    @include('components.foot')
@show
</footer>
<!-- Javascript -->
@section('js')
    <script src="/js/app.js"></script>
@show
</body>
</html>
