@extends('layout')

@section('center')
    <div id="app">
        <pharmgkb-view :vdata="{{ json_encode($model, JSON_UNESCAPED_UNICODE) }}"></pharmgkb-view>
    </div>
    @if(isset($title) && $title)
    <div style="position: relative; left: 50px;"><small>From {{ $title }}</small></div>
    @endif
@endsection