@extends('layouts.full')
@section('title')
    {{$w->word}}:{{$w->getFirstTranslateText()}}
@endsection
@section('content')

    <div class="container" style="margin-left: 10px">
        <div class="row">
            <h3>{{$progress}}</h3>
            <h1>{{$w->word}}</h1>
        </div>
        <div class="row">
            {{--美 --}}
            [{{$w->getPham()}}]
            <div class="glyphicon glyphicon-play word-play" id="ph_am_mp3" data-src="{{$w->getAmAudio()}}">
                <audio src="{{$w->getAmAudio()}}"></audio>
            </div>


        </div>
        <div class="row">
            @foreach($w->getTranslateTexts() as $v)
                {{$v}}<br>
            @endforeach
        </div>
        <br><br>
        @foreach($w->sents() as $sent)
            <div class="row">
                {!!$sent['orig'] !!} <br>
                {!!$sent['trans'] !!} <br>
            </div>
        @endforeach


    </div>
    <nav class="navbar navbar-default navbar-fixed-bottom">
        <div class="container">
            <div class="row center-block">
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
                @if($notCollect)
                    <div class="col-md-1 col-xs-1 col-md-offset-2 col-xs-offset-2">
                        <span class="glyphicon glyphicon-plus" id="follow" style="font-size: 3em"></span>
                    </div>
                @endif
            </div>

        </div>
    </nav>
@endsection
@section('js')
    <script>
        var wait = function (t) {
            var $d = $.Deferred();
            setTimeout(function () {
                $d.resolve();
            }, t);
            return $d.promise();
        };
        $('.delay').hide();
        setTimeout(function () {
            $('.delay').show();
        }, parseFloat("{{$delay or 0}}") * 1000)
        $(function () {
            $('#follow').click(function () {
                $.post('/words/add-collect', {'word_id': "{{$w->id}}"}, function () {
                    $('#follow').hide();
                });

            });
            $('.word-play').click(function () {
                $(this).removeClass('glyphicon-play').addClass('glyphicon-pause');
                $(this).find('audio').attr('src', $(this).attr('data-src'));
                $(this).find('audio')[0].play();
                var that = $(this);
                setTimeout(function () {
                    $(that).addClass('glyphicon-play').removeClass('glyphicon-pause');
                }, 1000)
            });

            var playNum = parseInt("{{$playNum or 0}}");
            var nowPlayNum = 0;
            var recall = setInterval( function () {
                if (nowPlayNum >= playNum) {
                    return clearInterval(recall);
                }
                $('#ph_am_mp3').click();
                nowPlayNum++;
            },2000);


        })
    </script>
    @if($isAuto)
        <script>
            $(function () {
                var defer = $.Deferred();
                defer.then(function () {
                    return wait(8000)
                }).then(function () {
                    window.location.href = $('#next_page').attr('href');
                });
                defer.resolve();
            })
        </script>
    @endif
@endsection

