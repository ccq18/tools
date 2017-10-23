@extends('layouts.app')

@section('content')

    <div class="container" style="margin-left: 10px">

        @foreach($words as $word)
            <div class="row">
               <a href="{{build_url('/words/index',['word_id'=>$word->id])}}">{{$word->translate['word_name']}}
                [{{$word->getPham()}}]</a>
                <span class="glyphicon glyphicon-play word-play" style="height: 25px"  data-src="{{$word->getAudio()}}">
                    <audio ></audio>
                </span>
                {{$word->getFirstTranslate()}}
            </div>
        @endforeach


    </div>
    <nav class="navbar navbar-default navbar-fixed-bottom">
        <div class="container">
            <div class="row center-block">
                {{$words->links()}}
            </div>
        </div>
    </nav>





@endsection

@section('js')
    <script>
        $(function () {
            $('.word-play').click(function () {
                $(this).removeClass('glyphicon-play').addClass('glyphicon-pause');
                $(this).find('audio').attr('src',$(this).attr('data-src'));
                $(this).find('audio')[0].play();
                var that = $(this);
                setTimeout(function () {
                    $(that).addClass('glyphicon-play').removeClass('glyphicon-pause');
                },1000)
            });



        })
    </script>
@endsection