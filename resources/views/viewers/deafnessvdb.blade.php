@extends('layout')

@section('center')
    <div id="app">
        <deafnessvdb-view :vdata="{{ json_encode($model, JSON_UNESCAPED_UNICODE) }}"></deafnessvdb-view>
    </div>
    @if(isset($title) && $title)
        <div style="position: relative; left: 50px;"><small>From {{ $title }}</small></div>
    @endif
@endsection