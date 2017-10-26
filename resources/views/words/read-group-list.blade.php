@extends('layouts.app')

@section('content')

    <div class="container" style="margin-left: 10px">

        @foreach($words as $word)
            <div class="row">
                <a href="{{build_url('/words/read-word',['word_id'=>$word->id])}}">{{$word->translate['word_name']}}
                    [{{$word->getPham()}}]</a>
                <span class="glyphicon glyphicon-play word-play" style="height: 25px" data-src="{{$word->getAudio()}}">
                    <audio></audio>
                </span>
                {{$word->getFirstTranslate()}}
            </div>
        @endforeach

    </div>

    <nav class="navbar navbar-default navbar-fixed-bottom">
        <div class="container">
            <div class="row center-block">
                {{--<div class="col-md-1 col-xs-1  "></div>--}}
                <div class="col-md-1 col-xs-1 col-md-offset-2 col-xs-offset-2 ">
                    <a style="font-size: 3em" href="{{build_url('/words/index',['action'=>'last'])}}"
                       class="glyphicon glyphicon-chevron-left"
                       aria-hidden="true"></a>
                </div>
                <div class="col-md-1 col-xs-1 col-md-offset-4 col-xs-offset-4">
                    <a style="font-size: 3em" href="{{build_url('/words/index',['action'=>'next'])}}"
                       class="glyphicon glyphicon-chevron-right" id="next_page"
                       aria-hidden="true"></a>
                </div>
            </div>
        </div>

    </nav>

@endsection

@section('js')
    <script>

    </script>
@endsection