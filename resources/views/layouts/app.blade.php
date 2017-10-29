<!DOCTYPE html>
<html lang="cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">


    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Styles -->
    <link href="{{ elixir('css/app.css') }}" rel="stylesheet">

@yield('css')
<!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>;
        Laravel.apiToken = "{{ Auth::check() ? 'Bearer '.Auth::user()->api_token : 'Bearer ' }}";
        @if(Auth::check())
            window.Zhihu = {
            name: "{{Auth::user()->name}}",
            avatar: "{{Auth::user()->avatar}}"
        }
        @endif


    </script>
</head>
<body>
<div id="app">
    <nav class="navbar navbar-default  navbar-static-top">
        {{--navbar-static-top--}}
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#app-navbar-collapse">
                </button>
            </div>
            @include("layouts.nav")
        </div>
    </nav>
    <nav class="navbar navbar-default  navbar-fixed-top">
        {{--navbar-static-top--}}
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                @if(!empty($backUrl))
                    <a class="navbar-brand glyphicon glyphicon-menu-left" href="{{ url($backUrl) }}">
                        {{--首页--}}
                    </a>
                @endif

                {{--<form class="navbar-brand form-inline form-horizontal">--}}
                    {{--<input type="text" class="form-control">--}}
                    {{--<span class="navbar-brand btn btn-primary">搜索</span>--}}
                {{--</form>--}}


            </div>
            @include("layouts.nav")
        </div>
    </nav>

    <div class="container">
        @if (session()->has('flash_notification.message'))
            <div class="alert alert-{{ session('flash_notification.level') }}">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                {!! session('flash_notification.message') !!}
            </div>
        @endif
    </div>

    @yield('content')
</div>

<!-- Scripts -->
<script src="{{ elixir('js/app.js') }}"></script>
@yield('js')
<script>
    $('#flash-overlay-modal').modal();
</script>
</body>
</html>
