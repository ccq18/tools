@extends('layouts.app')

@section('content')

    <div class="container" style="margin-left: 0.2rem">

        @foreach($groups as $units=>$groupArr)
            <div class="row" style="background-color: #ffffff;margin-top: 1rem;">
                @foreach($groupArr as $k=>$group)
                    <a href="{{url("/words/read-list/{$listId}/{$group['group_id']}")}}">
                        <div class="col-md-5 col-xs-5 text-center" style="background-color: #f5f8fa;margin: 0.5rem;padding-top: 1rem;padding-bottom: 1rem">
                           group-{{$group['group_id']}}
                        </div>
                    </a>
                @endforeach
            </div>
        @endforeach

    </div>

    <nav class="navbar navbar-default navbar-fixed-bottom">
        <div class="container">
            <div class="row center-block">
                {{--<div class="col-md-1 col-xs-1  "></div>--}}
                @if(!empty($lastUrl))
                    <div class="col-md-1 col-xs-1 col-md-offset-2 col-xs-offset-2 ">
                        <a style="font-size: 3em" href="{{url($lastUrl)}}"
                           class="glyphicon glyphicon-chevron-left"
                           aria-hidden="true"></a>
                    </div>
                @endif
                @if(!empty($nextUrl))
                    <div class="col-md-1 col-xs-1 col-md-offset-3 col-xs-offset-3">
                        <a style="font-size: 3em" href="{{url($nextUrl)}}"
                           class="glyphicon glyphicon-chevron-right" id="next_page"
                           aria-hidden="true"></a>
                    </div>
                @endif
            </div>
        </div>

    </nav>


@endsection

@section('js')
    <script>

    </script>
@endsection