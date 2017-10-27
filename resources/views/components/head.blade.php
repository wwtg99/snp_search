<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            {{--<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">--}}
                {{--<span class="sr-only">Toggle navigation</span>--}}
                {{--<span class="icon-bar"></span>--}}
                {{--<span class="icon-bar"></span>--}}
                {{--<span class="icon-bar"></span>--}}
            {{--</button>--}}
            <a class="navbar-brand" href="/">{{ __(config('app.name')) }}</a>
            <a class="navbar-brand" style="float: right" href="{{ route('freq') }}">Frequency</a>
            <a class="navbar-brand" style="float: right" href="{{ route('search') }}">Search</a>
        </div>
        {{--<div class="navbar-right" id="bs-example-navbar-collapse-1">--}}
            {{--<ul class="nav navbar-nav">--}}
                {{--<li @if (Request::is('/')) class="active" @endif><a href="/">Home <span class="sr-only">(current)</span></a></li>--}}
                {{--<li @if (Request::is('snp/search')) class="active" @endif><a href="{{ route('search') }}">Search</a></li>--}}
                {{--<li @if (Request::is('snp/freq')) class="active" @endif><a href="{{ route('freq') }}">Frequency</a></li>--}}
            {{--</ul>--}}
        {{--</div>--}}
    </div>
</nav>