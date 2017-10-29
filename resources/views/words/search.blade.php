@extends('layouts.app')

@section('content')

    <div class="container" style="margin-left: 10px">
        <div class="row">
            <div>
                <form action="/words/search" method="get">

                    <div class="input-group">
                        <input type="text" name="search" class="form-control" value="{{request('word','')}}" placeholder="word">
                        <span class="input-group-btn">
                                <button class="btn btn-default" type="submit">Go</button>
                            </span>
                    </div><!-- /input-group -->

                </form>
                {{--<form class="form-inline form-horizontal" action="/words/search"--}}
                {{--style="display:inline-block;padding-top: 0.5em;width: 80%">--}}
                {{--<div class="form-group">--}}
                {{--<div class="input-group">--}}
                {{--<input type="text" name="search" class="form-control">--}}
                {{--<input class="btn btn-primary">搜索</input>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</form>--}}
            </div>

        </div>
        <br>
        @foreach($words as $word)
            <div class="row">
                <a href="{{build_url('/words/index',['word_id'=>$word->id])}}">{{$word->word}}
                    @if(!empty($word->getPham()))[{{$word->getPham()}}]@endif
                </a>
                @if(!empty($word->getAmAudio()))
                    <span class="glyphicon glyphicon-play word-play" style="height: 25px"
                          data-src="{{$word->getAmAudio()}}">
                    <audio></audio>
                </span>
                @endif
                {{$word->getFirstTranslateText()}}
            </div>
        @endforeach

    </div>
    @if(isset($paginate))
        <nav class="navbar navbar-default navbar-fixed-bottom">
            <div class="container">
                <div class="row center-block">
                    {{$paginate}}
                </div>
            </div>
        </nav>
    @endif
@endsection

@section('js')
    <script>
        $(function () {
            $('.word-play').click(function () {
                $(this).removeClass('glyphicon-play').addClass('glyphicon-pause');
                $(this).find('audio').attr('src', $(this).attr('data-src'));
                $(this).find('audio')[0].play();
                var that = $(this);
                setTimeout(function () {
                    $(that).addClass('glyphicon-play').removeClass('glyphicon-pause');
                }, 1000)
            });


        })
    </script>
@endsection