@extends('layouts.app')

@section('content')

    <div class="container" style="margin-left: 10px">
        @if(!empty($readListUrl))
            <div class="row">
                <a  class="btn btn-default btn-xs" href="{{$readListUrl}}">学习</a>

            </div>
        @endif
        @foreach($allWords as $day=>$words)
            <div class="row">{{$day}}<br></div>
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