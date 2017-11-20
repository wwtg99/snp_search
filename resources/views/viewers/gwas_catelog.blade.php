@extends('layout')

@section('center')
    <div id="app">
        <gwas-catelog-view :vdata="{{ json_encode($model, JSON_UNESCAPED_UNICODE) }}"></gwas-catelog-view>
    </div>
    @if(isset($title) && $title)
        <div style="position: relative; left: 50px;"><small>From {{ $title }}</small></div>
    @endif
@endsection